<?php

namespace App\Site;

use App\Mcp\ToolError;
use App\Models\ClientLogo;
use App\Models\Media;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\SeoMeta;
use App\Models\Setting;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
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

    private const FETCH_TIMEOUT = 20;

    private const MAX_REDIRECTS = 5;

    /** Image CDNs such as Pexels reject requests without a browser User-Agent. */
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36';

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
     * Store an image: a main file (max width, WebP by default) plus smaller srcset sizes, and the file as sent.
     *
     * Options: max_width, format ('webp' or 'keep'), keep_original (default true), folder (under uploads/, default
     * the current year/month), source_url, uploaded_via. Every file except a kept original is re-encoded, which
     * removes EXIF data.
     */
    public static function store(string $bytes, string $name, ?string $alt, ?string $title, array $opts = []): Media
    {
        $info = @getimagesizefromstring($bytes);
        $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_GIF => 'gif', IMAGETYPE_WEBP => 'webp'];
        if (! $info || ! isset($types[$info[2]])) {
            throw new ToolError('Not a JPEG, PNG, GIF or WebP image.');
        }
        self::ensureMemory($info[0], $info[1]);

        $cfg = config('mcp_site.images');
        $maxWidth = (int) ($opts['max_width'] ?? $cfg['max_width']);
        $keepOriginal = $opts['keep_original'] ?? true;
        $ext = $types[$info[2]];
        $outExt = ($opts['format'] ?? 'webp') === 'keep' ? $ext : 'webp';

        $img = @imagecreatefromstring($bytes) ?: throw new ToolError('The image could not be read.');
        $img = self::orient($img, $bytes, $ext);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        $w = imagesx($img);
        $h = imagesy($img);

        $base = Str::slug(pathinfo($name, PATHINFO_FILENAME)) ?: 'image';
        $dir = 'uploads/' . (($opts['folder'] ?? null) ?: date('Y/m'));
        File::ensureDirectoryExists(public_path($dir));
        $stem = $base;
        for ($i = 2; File::exists(public_path("$dir/$stem.$ext")) || File::exists(public_path("$dir/$stem.$outExt")) || Media::withTrashed()->where('path', "$dir/$stem.$outExt")->exists(); $i++) {
            $stem = "$base-$i";
        }

        $written = [];
        $save = function (int $width, string $path) use ($img, $w, $h, $cfg, $outExt, &$written) {
            $width = min($width, $w);
            $height = (int) round($h * $width / $w);
            // Not imagescale(): it returned false for ordinary JPEGs with production's GD build.
            $out = $img;
            if ($width !== $w) {
                $out = imagecreatetruecolor($width, $height);
                imagealphablending($out, false);
                imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
                imagecopyresampled($out, $img, 0, 0, 0, 0, $width, $height, $w, $h);
            }
            imagealphablending($out, false);
            imagesavealpha($out, true);
            $written[] = $path;
            $file = public_path($path);
            $quality = (int) $cfg['webp_quality'];
            $ok = match ($outExt) {
                'webp' => imagewebp($out, $file, $quality),
                'jpg' => imagejpeg($out, $file, $quality),
                'png' => imagepng($out, $file),
                'gif' => imagegif($out, $file),
            };
            if (! $ok) {
                throw new \RuntimeException("Could not write $path.");
            }

            return [$width, $height];
        };

        try {
            $original = null;
            if ($keepOriginal) {
                $original = "$dir/$stem.$ext";
                $written[] = $original;
                File::put(public_path($original), $bytes);
            }

            $main = "$dir/$stem.$outExt";
            if ($keepOriginal && $ext === 'webp' && $outExt === 'webp' && $w <= $maxWidth) {
                [$mw, $mh] = [$w, $h]; // already WebP and small enough: the kept file is the main file
            } else {
                [$mw, $mh] = $save($maxWidth, $main);
            }
            $variants = [];
            foreach ($cfg['srcset_widths'] as $sw) {
                if ($sw < $mw) {
                    $vp = "$dir/$stem-$sw.$outExt";
                    $save($sw, $vp);
                    $variants[] = ['width' => $sw, 'path' => $vp];
                }
            }
            $variants[] = ['width' => $mw, 'path' => $main];

            $mimes = ['webp' => 'image/webp', 'jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];

            return Media::create(['path' => $main, 'original_path' => $original === $main ? null : $original, 'mime' => $mimes[$outExt],
                'width' => $mw, 'height' => $mh, 'size' => filesize(public_path($main)), 'alt' => $alt, 'title' => $title, 'variants' => $variants,
                'source_url' => $opts['source_url'] ?? null, 'uploaded_via' => $opts['uploaded_via'] ?? null]);
        } catch (\Throwable $e) {
            File::delete(array_map('public_path', $written)); // no half-finished image left behind

            throw $e;
        }
    }

    /**
     * Download an image from a public URL and add it to the library. Used by upload_image_from_url and by the URL
     * path of upload_image. Options: filename, alt, title, folder, max_width, convert_to_webp.
     * Failures are ToolErrors with a code: url_not_allowed, fetch_failed, not_an_image, too_large, processing_failed.
     */
    public static function fromUrl(string $url, array $opts = []): Media
    {
        [$bytes, $contentType] = self::download($url);
        if (self::sniff($bytes) === null) {
            throw ToolError::coded('not_an_image', 'The URL did not return a JPEG, PNG, GIF or WebP image.', ['content_type' => $contentType]);
        }

        try {
            return self::store($bytes, $opts['filename'] ?? self::nameFromUrl($url), $opts['alt'] ?? null, $opts['title'] ?? null, [
                'max_width' => $opts['max_width'] ?? null,
                'format' => ($opts['convert_to_webp'] ?? true) ? 'webp' : 'keep',
                'keep_original' => false, // the source URL is recorded, and a raw copy would keep the EXIF data
                'folder' => $opts['folder'] ?? null,
                'source_url' => $url,
                'uploaded_via' => 'mcp_url',
            ]);
        } catch (\Throwable $e) {
            if ($e instanceof ToolError && $e->errorCode !== null) {
                throw $e;
            }
            report($e);

            throw ToolError::coded('processing_failed', 'The image was downloaded but could not be processed.', ['detail' => $e->getMessage()]);
        }
    }

    /**
     * Fetch a URL, checking every redirect hop against the SSRF guard and pinning the connection to the checked IP.
     *
     * @return array{0:string,1:string} body and Content-Type
     */
    private static function download(string $url): array
    {
        $max = (int) config('mcp_site.images.max_upload_mb') * 1024 * 1024;
        $deadline = microtime(true) + self::FETCH_TIMEOUT;

        for ($redirects = 0; ; $redirects++) {
            [$host, $resolve] = self::guardUrl($url);
            if (! extension_loaded('curl')) {
                throw ToolError::coded('fetch_failed', 'The PHP curl extension is required to download images.', ['status' => null, 'hostname' => $host]);
            }

            $tooLarge = false;
            $curl = [
                CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
                CURLOPT_NOPROGRESS => false,
                CURLOPT_PROGRESSFUNCTION => function ($ch, $total, $received) use ($max, &$tooLarge) {
                    $tooLarge = $total > $max || $received > $max;

                    return $tooLarge ? 1 : 0; // non-zero stops the transfer
                },
            ];
            if ($resolve !== null) {
                $curl[CURLOPT_RESOLVE] = [$resolve];
            }

            try {
                $res = Http::withoutRedirecting()
                    ->withUserAgent(self::USER_AGENT)
                    ->accept('image/*')
                    ->connectTimeout(10)
                    ->timeout(max(1, (int) ceil($deadline - microtime(true))))
                    ->withOptions(['curl' => $curl])
                    ->get($url);
            } catch (\Throwable $e) {
                if ($tooLarge) {
                    throw self::tooLarge();
                }
                report($e);

                throw ToolError::coded('fetch_failed', 'The download failed.', ['status' => null, 'hostname' => $host, 'detail' => $e->getMessage()]);
            }

            $status = $res->status();
            if (in_array($status, [301, 302, 303, 307, 308], true)) {
                $location = $res->header('Location');
                if ($location === '' || $redirects >= self::MAX_REDIRECTS) {
                    throw ToolError::coded('fetch_failed', $location === '' ? 'The redirect had no target.' : 'Too many redirects.', ['status' => $status, 'hostname' => $host]);
                }
                $url = (string) UriResolver::resolve(new Uri($url), new Uri($location));

                continue;
            }
            if ($status !== 200) {
                throw ToolError::coded('fetch_failed', "The server answered HTTP $status.", ['status' => $status, 'hostname' => $host]);
            }

            $contentType = $res->header('Content-Type');
            if (! str_starts_with(strtolower(trim($contentType)), 'image/')) {
                throw ToolError::coded('not_an_image', 'The URL did not return an image.', ['content_type' => $contentType, 'hostname' => $host]);
            }
            if (strlen($res->body()) > $max) {
                throw self::tooLarge();
            }

            return [$res->body(), $contentType];
        }
    }

    /**
     * SSRF guard for one URL: http(s) only, allow-listed host if a list is set, public addresses only.
     *
     * @return array{0:string,1:?string} host and the curl "host:port:ip" entry that pins it (null for an IP literal)
     */
    private static function guardUrl(string $url): array
    {
        $deny = fn (string $why, ?string $host = null) => ToolError::coded('url_not_allowed', $why, ['hostname' => $host]);

        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        if (! in_array($scheme, ['http', 'https'], true) || empty($parts['host'])) {
            throw $deny('The URL must be http or https.');
        }
        // A URL that parsers could read differently must not reach curl, because the checks below read PHP's result.
        if (isset($parts['user']) || isset($parts['pass']) || preg_match('/[\s\\\\\x00-\x1f]/', $url)) {
            throw $deny('The URL must not contain credentials, backslashes or spaces.', $parts['host']);
        }

        $host = strtolower(trim($parts['host'], '[]'));
        $allowed = config('mcp_site.images.url_allowed_hosts', []);
        if ($allowed && ! in_array($host, $allowed, true)) {
            throw $deny("$host is not in MCP_IMAGE_URL_ALLOWED_HOSTS.", $host);
        }

        if (filter_var($host, FILTER_VALIDATE_IP)) {
            if (! self::isPublicIp($host)) {
                throw $deny('The URL points to a private or reserved address.', $host);
            }

            return [$host, null];
        }
        if (preg_match('/^(0x[0-9a-f]+|\d+)(\.(0x[0-9a-f]+|\d+))*$/i', $host)) {
            throw $deny('Write IP addresses in the normal dotted form.', $host); // 2130706433 or 0x7f.1 mean 127.0.0.1
        }

        $ips = gethostbynamel($host) ?: [];
        foreach (@dns_get_record($host, DNS_AAAA) ?: [] as $record) {
            $ips[] = $record['ipv6'];
        }
        if (! $ips) {
            throw ToolError::coded('fetch_failed', 'The host name could not be resolved.', ['status' => null, 'hostname' => $host]);
        }
        foreach ($ips as $ip) {
            if (! self::isPublicIp($ip)) {
                throw $deny('The URL points to a private or reserved address.', $host);
            }
        }

        $port = $parts['port'] ?? ($scheme === 'https' ? 443 : 80);
        $ip = str_contains($ips[0], ':') ? "[{$ips[0]}]" : $ips[0];

        return [$host, "$host:$port:$ip"];
    }

    public static function isPublicIp(string $ip): bool
    {
        $bin = @inet_pton($ip);
        if ($bin === false) {
            return false;
        }
        if (strlen($bin) === 16) {
            if (substr($bin, 0, 12) === str_repeat("\0", 10) . "\xff\xff" || substr($bin, 0, 12) === str_repeat("\0", 12)) {
                return strlen(ltrim($bin, "\0")) > 0 && self::isPublicIp((string) inet_ntop(substr($bin, 12))); // IPv4 inside IPv6
            }
            $first = ord($bin[0]);
            if (($first & 0xFE) === 0xFC || ($first === 0xFE && (ord($bin[1]) & 0xC0) === 0x80)) {
                return false; // fc00::/7 unique local, fe80::/10 link local
            }
        } elseif (ord($bin[0]) === 100 && (ord($bin[1]) & 0xC0) === 64) {
            return false; // 100.64.0.0/10 carrier-grade NAT
        }

        return (bool) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    /** The real type from the file's first bytes: jpg, png, gif, webp, or null. */
    public static function sniff(string $bytes): ?string
    {
        return match (true) {
            str_starts_with($bytes, "\xFF\xD8\xFF") => 'jpg',
            str_starts_with($bytes, "\x89PNG\r\n\x1A\n") => 'png',
            str_starts_with($bytes, 'GIF87a'), str_starts_with($bytes, 'GIF89a') => 'gif',
            str_starts_with($bytes, 'RIFF') && substr($bytes, 8, 4) === 'WEBP' => 'webp',
            default => null,
        };
    }

    /** A file name from the URL path. Generic last parts such as "download" give way to the part before them. */
    private static function nameFromUrl(string $url): string
    {
        $segments = array_values(array_filter(explode('/', urldecode((string) parse_url($url, PHP_URL_PATH)))));
        $last = array_pop($segments) ?? 'image';
        if (in_array(strtolower(pathinfo($last, PATHINFO_FILENAME)), ['download', 'image', 'photo', 'file', 'raw', 'index'], true) && $segments) {
            return end($segments);
        }

        return $last;
    }

    private static function tooLarge(): ToolError
    {
        return ToolError::coded('too_large', 'The image is larger than ' . config('mcp_site.images.max_upload_mb') . ' MB.', ['max_mb' => (int) config('mcp_site.images.max_upload_mb')]);
    }

    /** Refuse images too big to decode: running out of memory is a fatal error that no catch block can report. */
    private static function ensureMemory(int $w, int $h): void
    {
        $maxMp = (int) config('mcp_site.images.max_megapixels');
        if ($w * $h > $maxMp * 1_000_000) {
            throw ToolError::coded('too_large', "The image is {$w}x{$h}, above the limit of {$maxMp} megapixels.", ['width' => $w, 'height' => $h]);
        }
        $need = $w * $h * 10 + 64 * 1024 * 1024; // source and scaled copy, 4-5 bytes per pixel each
        $limit = ini_parse_quantity((string) ini_get('memory_limit'));
        if ($limit > 0 && $need > $limit && @ini_set('memory_limit', (string) $need) === false) {
            throw ToolError::coded('too_large', "The image is {$w}x{$h}, too big for this server's memory limit.", ['width' => $w, 'height' => $h]);
        }
    }

    /** Turn a JPEG upright according to its EXIF orientation, which is lost when the EXIF data is removed. */
    private static function orient(\GdImage $img, string $bytes, string $ext): \GdImage
    {
        if ($ext !== 'jpg' || ! function_exists('exif_read_data')) {
            return $img;
        }
        $exif = @exif_read_data('data://image/jpeg;base64,' . base64_encode($bytes));
        $orientation = (int) ($exif['Orientation'] ?? 1);
        if (in_array($orientation, [2, 5, 7], true)) {
            imageflip($img, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 4) {
            imageflip($img, IMG_FLIP_VERTICAL);
        }
        $angle = [3 => 180, 5 => 90, 6 => -90, 7 => -90, 8 => 90][$orientation] ?? 0;

        return $angle ? (imagerotate($img, $angle, 0) ?: $img) : $img;
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
