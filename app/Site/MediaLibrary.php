<?php

namespace App\Site;

use App\Mcp\ToolError;
use App\Models\ClientLogo;
use App\Models\Media;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Images under public/uploads: index, where each is used, upload (WebP + srcset sizes, original kept),
 * renaming and replacing everywhere they are referenced.
 */
class MediaLibrary
{
    private const TYPES = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'];

    /** Add a media row for every image file in public/uploads that has none yet. */
    public static function sync(): int
    {
        $known = array_flip(Media::withTrashed()->pluck('path')->all());
        $n = 0;
        foreach (File::allFiles(public_path('uploads')) as $f) {
            if (! in_array(strtolower($f->getExtension()), self::TYPES, true)) {
                continue;
            }
            $path = 'uploads/' . str_replace('\\', '/', $f->getRelativePathname());
            if (isset($known[$path])) {
                continue;
            }
            $size = @getimagesize($f->getPathname()) ?: [null, null, 'mime' => null];
            Media::create(['path' => $path, 'mime' => $size['mime'] ?? File::mimeType($f->getPathname()), 'width' => $size[0], 'height' => $size[1], 'size' => $f->getSize()]);
            $n++;
        }

        return $n;
    }

    /**
     * Every place that refers to an image: [label, model] pairs whose stored text contains the path.
     *
     * @return array<int, array{where:string, model:\Illuminate\Database\Eloquent\Model, field:string}>
     */
    public static function usage(string $path): array
    {
        $bare = preg_replace('#^/?uploads/#', '', ltrim($path, '/'));   // "2026/07/x.webp" (logo rows store it like this)
        $hits = [];
        foreach (self::corpus() as [$where, $model, $text, $exact]) {
            if ($exact ? $text === $bare : str_contains($text, $bare)) {
                $hits[] = ['where' => $where, 'model' => $model, 'field' => ''];
            }
        }

        return $hits;
    }

    /** @var array<int, array{0:string,1:\Illuminate\Database\Eloquent\Model,2:string,3:bool}>|null all text that can refer to an image, loaded once */
    private static ?array $corpus = null;

    private static function corpus(): array
    {
        if (self::$corpus !== null) {
            return self::$corpus;
        }
        $c = [];
        foreach (PageSection::with('page')->get() as $s) {
            if ($s->page) {
                $c[] = ["page /{$s->page->path} › {$s->key}", $s, json_encode($s->content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), false];
            }
        }
        foreach (Post::withTrashed()->get() as $p) {
            $c[] = ["blog /{$p->slug}", $p, $p->content . ' ' . $p->featured_image, false];
        }
        foreach (ClientLogo::all() as $l) {
            $c[] = ["client logo {$l->name} ({$l->logo_group})", $l, (string) $l->image, true];
        }
        foreach (SeoMeta::all() as $m) {
            $c[] = ['SEO image of ' . class_basename($m->seoable_type) . " #{$m->seoable_id}", $m, $m->og_image . ' ' . $m->twitter_image, false];
        }
        foreach (Setting::all() as $st) {
            $c[] = ["setting {$st->key}", $st, (string) json_encode($st->value, JSON_UNESCAPED_SLASHES), false];
        }

        return self::$corpus = $c;
    }

    public static function forget(): void
    {
        self::$corpus = null;
    }

    /** Replace one image path by another everywhere it is referenced. Returns the places changed. */
    public static function replaceEverywhere(string $old, string $new, string $actor = 'mcp'): array
    {
        $oldBare = preg_replace('#^/?uploads/#', '', ltrim($old, '/'));
        $newBare = preg_replace('#^/?uploads/#', '', ltrim($new, '/'));
        $changed = [];
        foreach (self::usage($old) as $u) {
            $m = $u['model'];
            if ($m instanceof PageSection) {
                $json = str_replace($oldBare, $newBare, json_encode($m->content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                $m->revisionActor = $actor;
                $m->revisionReason = "image $oldBare → $newBare";
                $m->content = json_decode($json, true);
                $m->save();
                $m->page?->touch();
            } elseif ($m instanceof Post) {
                $m->content = str_replace($oldBare, $newBare, (string) $m->content);
                $m->featured_image = $m->featured_image ? str_replace($oldBare, $newBare, $m->featured_image) : null;
                $m->save();
            } elseif ($m instanceof ClientLogo) {
                $m->update(['image' => $newBare]);
            } elseif ($m instanceof SeoMeta) {
                $m->update(['og_image' => $m->og_image ? str_replace($oldBare, $newBare, $m->og_image) : null,
                    'twitter_image' => $m->twitter_image ? str_replace($oldBare, $newBare, $m->twitter_image) : null]);
            } elseif ($m instanceof Setting) {
                $m->value = json_decode(str_replace($oldBare, $newBare, json_encode($m->value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)), true);
                $m->save();
                Settings::flush();
            }
            $changed[] = $u['where'];
        }

        self::forget();

        return $changed;
    }

    /** Set the alt text of every <img> showing this image (src or srcset), in sections and posts. */
    public static function setAlt(string $path, string $alt, string $actor = 'mcp'): array
    {
        $bare = preg_replace('#^/?uploads/#', '', ltrim($path, '/'));
        $altAttr = 'alt="' . htmlspecialchars($alt, ENT_QUOTES) . '"';
        $fix = function (string $html) use ($bare, $altAttr, &$count) {
            return preg_replace_callback('/<img\b[^>]*>/i', function ($m) use ($bare, $altAttr, &$count) {
                if (! str_contains($m[0], $bare)) {
                    return $m[0];
                }
                $count++;

                return preg_match('/\salt\s*=\s*("[^"]*"|\'[^\']*\')/i', $m[0])
                    ? preg_replace('/\salt\s*=\s*("[^"]*"|\'[^\']*\')/i', ' ' . $altAttr, $m[0], 1)
                    : preg_replace('/^<img\b/i', '<img ' . $altAttr, $m[0]);
            }, $html);
        };
        $changed = [];
        foreach (self::usage($path) as $u) {
            $m = $u['model'];
            $count = 0;
            if ($m instanceof PageSection) {
                $walk = function ($v) use (&$walk, $fix) {
                    return is_array($v) ? array_map($walk, $v) : (is_string($v) && str_contains($v, '<img') ? $fix($v) : $v);
                };
                $content = $walk($m->content);
                if ($count) {
                    $m->revisionActor = $actor;
                    $m->revisionReason = 'alt text';
                    $m->content = $content;
                    $m->save();
                    $m->page?->touch();
                }
            } elseif ($m instanceof Post) {
                $content = $fix((string) $m->content);
                if ($count) {
                    $m->update(['content' => $content]);
                }
            } elseif ($m instanceof ClientLogo) {
                continue; // logo alt comes from the client name
            }
            if ($count) {
                $changed[] = $u['where'] . " ($count)";
            }
        }

        self::forget();

        return $changed;
    }

    /**
     * Store an uploaded image: original kept, a WebP (max width) and srcset WebP sizes created.
     *
     * @return Media
     */
    public static function store(string $bytes, string $name, ?string $alt, ?string $title): Media
    {
        $info = @getimagesizefromstring($bytes);
        $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif', IMAGETYPE_WEBP => 'webp'];
        if (! $info || ! isset($types[$info[2]])) {
            throw new ToolError('Not a JPEG, PNG, GIF or WebP image.');
        }
        $ext = $types[$info[2]];
        $base = Str::slug(pathinfo($name, PATHINFO_FILENAME)) ?: 'image';
        $dir = 'uploads/' . date('Y/m');
        File::ensureDirectoryExists(public_path($dir));
        $stem = $base;
        for ($i = 2; File::exists(public_path("$dir/$stem.$ext")) || File::exists(public_path("$dir/$stem.webp")) || Media::withTrashed()->where('path', "$dir/$stem.webp")->exists(); $i++) {
            $stem = "$base-$i";
        }

        $original = "$dir/$stem.$ext";
        File::put(public_path($original), $bytes);

        $img = imagecreatefromstring($bytes) ?: throw new ToolError('The image could not be read.');
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        $cfg = config('mcp_site.images');
        $w = imagesx($img);
        $h = imagesy($img);

        $save = function (int $width, string $path) use ($img, $w, $h, $cfg) {
            $width = min($width, $w);
            $height = (int) round($h * $width / $w);
            $out = $width === $w ? $img : imagescale($img, $width, $height, IMG_BICUBIC);
            imagealphablending($out, false);
            imagesavealpha($out, true);
            imagewebp($out, public_path($path), (int) $cfg['webp_quality']);

            return [$width, $height];
        };

        $main = "$dir/$stem.webp";
        if ($ext === 'webp' && $w <= $cfg['max_width']) {
            $main = $original; // already WebP and small enough
            [$mw, $mh] = [$w, $h];
        } else {
            [$mw, $mh] = $save($cfg['max_width'], $main);
        }
        $variants = [];
        foreach ($cfg['srcset_widths'] as $sw) {
            if ($sw < $mw) {
                $vp = "$dir/$stem-$sw.webp";
                $save($sw, $vp);
                $variants[] = ['width' => $sw, 'path' => $vp];
            }
        }
        $variants[] = ['width' => $mw, 'path' => $main];

        return Media::create(['path' => $main, 'original_path' => $original === $main ? null : $original, 'mime' => 'image/webp',
            'width' => $mw, 'height' => $mh, 'size' => filesize(public_path($main)), 'alt' => $alt, 'title' => $title, 'variants' => $variants]);
    }

    /** Download an image from a public http(s) URL (no internal addresses, size-limited). */
    public static function fetch(string $url): string
    {
        $parts = parse_url($url);
        if (! in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true) || empty($parts['host'])) {
            throw new ToolError('image_url must be an http(s) URL.');
        }
        foreach (gethostbynamel($parts['host']) ?: [] as $ip) {
            if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                throw new ToolError('image_url points to a private or reserved address.');
            }
        }
        if (! gethostbynamel($parts['host'])) {
            throw new ToolError('image_url host could not be resolved.');
        }
        $max = (int) config('mcp_site.images.max_upload_mb') * 1024 * 1024;
        $res = Http::timeout(20)->withOptions(['allow_redirects' => false, 'stream' => false])->get($url);
        if (! $res->successful()) {
            throw new ToolError('Download failed: HTTP ' . $res->status());
        }
        if (strlen($res->body()) > $max) {
            throw new ToolError('The image is larger than ' . config('mcp_site.images.max_upload_mb') . ' MB.');
        }

        return $res->body();
    }

    /** <img> markup for a media item, ready to paste into a section ({{base}} placeholders). */
    public static function snippet(Media $m): string
    {
        $src = '{{base}}/' . $m->path;
        $srcset = collect($m->variants ?? [])->map(fn ($v) => '{{base}}/' . $v['path'] . ' ' . $v['width'] . 'w')->implode(', ');

        return '<img src="' . $src . '"' . ($srcset ? ' srcset="' . $srcset . '" sizes="(max-width:960px) 100vw, 800px"' : '')
            . ' width="' . $m->width . '" height="' . $m->height . '" alt="' . htmlspecialchars((string) $m->alt, ENT_QUOTES) . '" loading="lazy" decoding="async">';
    }
}
