<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\Media;
use App\Models\Redirect;
use App\Site\MediaLibrary;
use App\Site\SiteAnalyzer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/** Images: library, upload, alt text, rename, replace, delete, audit. */
class MediaTools
{
    public static function tools(): array
    {
        $image = P::str('Image id, or its path such as uploads/2026/07/logo.webp.')->req();

        return [
            new SiteTool('list_images', 'List images in /uploads with size, dimensions, alt text and how many places use each.', [
                'search' => P::str('Text in the path or alt.'),
                'unused_only' => P::bool('Only images nothing refers to.'),
                'limit' => P::int('Max results (default 100).', ['min:1', 'max:1000']),
                'offset' => P::int('Skip this many (paging).', 'min:0'),
            ], function (array $a) {
                MediaLibrary::sync();
                $q = Media::orderByDesc('id');
                if (! empty($a['search'])) {
                    $q->where(fn ($w) => $w->where('path', 'like', "%{$a['search']}%")->orWhere('alt', 'like', "%{$a['search']}%"));
                }
                $rows = $q->get();
                $out = [];
                foreach ($rows as $m) {
                    $uses = count(MediaLibrary::usage($m->path));
                    if (! empty($a['unused_only']) && $uses) {
                        continue;
                    }
                    $out[] = self::item($m) + ['used_in' => $uses];
                }

                return ['total' => count($out), 'images' => array_slice($out, $a['offset'] ?? 0, $a['limit'] ?? 100)];
            }, readOnly: true),

            new SiteTool('upload_image', 'Upload an image from a public URL or base64 data. It is converted to WebP (max 1600 px wide, original kept) with 480/800/1200 px srcset sizes. Returns ready-to-use <img> HTML.', [
                'image_url' => P::str('Public http(s) URL of the image.'),
                'base64' => P::str('Image data as base64 (or a data: URL).'),
                'filename' => P::str('File name to use, e.g. "car-wash-pos-dashboard" (default from the URL).', 'max:120'),
                'alt' => P::str('Alt text: describe the image (required).', 'max:250')->req(),
                'title' => P::str('Title (optional).', 'max:250'),
            ], function (array $a) {
                if (empty($a['image_url']) === empty($a['base64'])) {
                    throw new ToolError('Give either image_url or base64.');
                }
                if (! empty($a['base64'])) {
                    $bytes = base64_decode(preg_replace('/^data:[^,]*,/', '', $a['base64']), true);
                    if ($bytes === false) {
                        throw new ToolError('base64 is not valid.');
                    }
                    if (strlen($bytes) > config('mcp_site.images.max_upload_mb') * 1024 * 1024) {
                        throw new ToolError('The image is too large.');
                    }
                } else {
                    $bytes = MediaLibrary::fetch($a['image_url']);
                }
                $name = $a['filename'] ?? (! empty($a['image_url']) ? basename(parse_url($a['image_url'], PHP_URL_PATH) ?: 'image') : 'image');
                $m = MediaLibrary::store($bytes, $name, Support::text($a['alt'], 'alt'), Support::text($a['title'] ?? null, 'title'));
                Support::log('media.upload', $m, "Uploaded {$m->path}", null, self::item($m));

                return self::item($m) + ['html' => MediaLibrary::snippet($m), 'note' => 'Paste `html` into a section; {{base}} is filled in with the site address.'];
            }),

            new SiteTool('update_image', 'Change an image\'s alt text (applied to every <img> that shows it), title, or file name (the file is renamed, every reference updated, and the old URL redirects).', [
                'image' => $image,
                'alt' => P::str('New alt text.', 'max:250'),
                'title' => P::str('New title.', 'max:250'),
                'filename' => P::str('New file name without folder or extension, e.g. "fbr-invoice-receipt".', ['max:120', 'regex:/^[a-z0-9]+(-[a-z0-9]+)*$/']),
            ], function (array $a) {
                $m = self::find($a['image']);
                $before = self::item($m);
                $result = [];
                if (isset($a['alt'])) {
                    $m->alt = Support::text($a['alt'], 'alt');
                    $result['alt_updated_in'] = MediaLibrary::setAlt($m->path, $m->alt);
                }
                if (array_key_exists('title', $a)) {
                    $m->title = Support::text($a['title'], 'title');
                }
                if (isset($a['filename'])) {
                    $result['renamed'] = self::rename($m, $a['filename']);
                }
                $m->save();
                Support::log('media.update', $m, "Updated image {$m->path}", $before, self::item($m));

                return ['image' => self::item($m)] + $result + ['cache' => Support::changed()];
            }),

            new SiteTool('replace_image', 'Show a different image everywhere an image is used (pages, components, posts, logos, SEO images, settings).', [
                'image' => $image,
                'replacement' => P::str('Id or path of the new image (upload it first).')->req(),
                'copy_alt' => P::bool('Also give the new image the old one\'s alt text where it had none (default true).'),
            ], function (array $a) {
                $old = self::find($a['image']);
                $new = self::find($a['replacement']);
                $changed = MediaLibrary::replaceEverywhere($old->path, $new->path);
                if (($a['copy_alt'] ?? true) && ! $new->alt && $old->alt) {
                    $new->update(['alt' => $old->alt]);
                }
                Support::log('media.replace', $old, "Replaced {$old->path} with {$new->path}", null, ['places' => $changed]);

                return ['replaced' => $old->path, 'with' => $new->path, 'places' => $changed, 'cache' => Support::changed()];
            }),

            new SiteTool('delete_image', 'Move an image to the trash. Refused while it is used somewhere unless force=true. The file is removed only when the item is purged.', [
                'image' => $image, 'force' => P::bool('Delete even though it is used (those places will show a broken image).'),
            ], function (array $a) {
                $m = self::find($a['image']);
                $uses = MediaLibrary::usage($m->path);
                if ($uses && empty($a['force'])) {
                    throw new ToolError('This image is used in: ' . implode('; ', array_column($uses, 'where')) . '. Replace it first (replace_image) or pass force=true.');
                }
                $m->delete();
                Support::log('media.delete', $m, "Moved image {$m->path} to the trash", null, ['used_in' => array_column($uses, 'where')]);

                return ['deleted' => $m->path, 'was_used_in' => array_column($uses, 'where'), 'restore_with' => ['tool' => 'restore_item', 'type' => 'image', 'id' => $m->id]];
            }, destructive: true),

            new SiteTool('audit_images', 'Image SEO check of rendered pages: missing or empty alt, filename-like alt ("IMG_123"), files over 300 KB, missing width/height, no WebP, and images below the fold that are not lazy-loaded.', [
                'page' => P::str('Page path or post slug; empty = whole site.'),
            ], function (array $a) {
                $items = isset($a['page']) ? [Support::analyze($a['page'])] : array_values(SiteAnalyzer::all());
                $limit = (int) config('mcp_site.images.oversized_kb') * 1024;
                $report = [];
                $totals = [];
                foreach ($items as $an) {
                    $issues = [];
                    $contentIndex = 0;
                    foreach ($an['images'] as $img) {
                        $content = ! in_array($img['section'], SiteAnalyzer::CHROME, true);
                        $contentIndex += $content ? 1 : 0;
                        $local = self::localPath($img['src']);
                        $found = [];
                        if ($img['alt'] === null) {
                            $found[] = 'missing alt';
                        } elseif (trim($img['alt']) === '') {
                            $found[] = 'empty alt (fine only if decorative)';
                        } elseif (preg_match('/^(img|dsc|image|photo|pic|screenshot|untitled)[\s_-]*\d*$|\.(jpe?g|png|webp|gif)$|^[\w-]*\d{3,}[\w-]*$/i', trim($img['alt']))) {
                            $found[] = 'filename-like alt "' . $img['alt'] . '"';
                        }
                        if ($local && is_file(public_path($local)) && filesize(public_path($local)) > $limit) {
                            $found[] = 'file is ' . round(filesize(public_path($local)) / 1024) . ' KB';
                        }
                        if (! $img['width'] || ! $img['height']) {
                            $found[] = 'no width/height';
                        }
                        if ($local && ! $img['webp'] && ! str_ends_with(strtolower($local), '.svg')) {
                            $found[] = 'no WebP';
                        }
                        if ($content && $contentIndex > 2 && $img['loading'] !== 'lazy') {
                            $found[] = 'below the fold but not lazy-loaded';
                        }
                        foreach ($found as $f) {
                            $key = preg_replace('/ ".*"| is \d+ KB/', '', $f);
                            $totals[$key] = ($totals[$key] ?? 0) + 1;
                        }
                        if ($found) {
                            $issues[] = ['src' => $img['src'], 'alt' => $img['alt'], 'section' => $img['section'], 'issues' => $found,
                                'image_id' => $local ? Media::where('path', $local)->value('id') : null];
                        }
                    }
                    if ($issues || isset($a['page'])) {
                        $report[] = ['path' => '/' . $an['path'], 'images' => count($an['images']), 'issues' => $issues];
                    }
                }

                return ['pages_checked' => count($items), 'totals' => $totals, 'pages' => $report];
            }, readOnly: true),

            new SiteTool('bulk_update_alt', 'Set alt text for many images at once: [{image_id, alt}]. Each is applied wherever the image appears.', [
                'items' => P::arr('List of {image_id, alt}.', P::obj('{image_id, alt}'))->req(),
            ], function (array $a) {
                $done = [];
                foreach ($a['items'] as $i => $it) {
                    if (empty($it['image_id']) || ! isset($it['alt']) || ! is_string($it['alt'])) {
                        throw new ToolError("items[$i] needs image_id and alt.");
                    }
                    $m = self::find((string) $it['image_id']);
                    $before = $m->alt;
                    $m->update(['alt' => Support::text($it['alt'], 'alt')]);
                    $places = MediaLibrary::setAlt($m->path, $m->alt);
                    Support::log('media.alt', $m, "Alt of {$m->path}", ['alt' => $before], ['alt' => $m->alt]);
                    $done[] = ['image_id' => $m->id, 'path' => $m->path, 'before' => $before, 'after' => $m->alt, 'updated_in' => $places];
                }

                return ['updated' => $done, 'cache' => Support::changed()];
            }),
        ];
    }

    private static function find(string $ref): Media
    {
        MediaLibrary::sync();
        if (is_numeric($ref)) {
            return Media::findOrFail((int) $ref);
        }
        $path = 'uploads/' . preg_replace('#^/?(uploads/)?#', '', preg_replace('#^https?://[^/]+/#', '', $ref));

        return Media::where('path', $path)->first() ?? throw new ToolError("No image $path in the library.");
    }

    public static function item(Media $m): array
    {
        return ['id' => $m->id, 'path' => $m->path, 'url' => asset($m->path), 'width' => $m->width, 'height' => $m->height,
            'size_kb' => $m->size ? round($m->size / 1024) : null, 'alt' => $m->alt, 'title' => $m->title,
            'original' => $m->original_path, 'srcset' => array_column($m->variants ?? [], 'width')];
    }

    /** "uploads/…" for a site image URL, else null. */
    private static function localPath(string $src): ?string
    {
        $path = Support::internalPath($src);

        return $path !== null && str_starts_with($path, 'uploads/') ? $path : null;
    }

    private static function rename(Media $m, string $filename): string
    {
        $dir = dirname($m->path);
        $ext = pathinfo($m->path, PATHINFO_EXTENSION);
        $new = "$dir/$filename.$ext";
        if ($new === $m->path) {
            return 'unchanged';
        }
        if (File::exists(public_path($new)) || Media::withTrashed()->where('path', $new)->exists()) {
            throw new ToolError("$new already exists.");
        }
        File::move(public_path($m->path), public_path($new));
        $variants = [];
        foreach ($m->variants ?? [] as $v) {
            if ($v['path'] === $m->path) {
                $variants[] = ['width' => $v['width'], 'path' => $new];
                continue;
            }
            $vn = $dir . '/' . $filename . '-' . $v['width'] . '.' . pathinfo($v['path'], PATHINFO_EXTENSION);
            if (File::exists(public_path($v['path']))) {
                File::move(public_path($v['path']), public_path($vn));
                MediaLibrary::replaceEverywhere($v['path'], $vn);
            }
            $variants[] = ['width' => $v['width'], 'path' => $vn];
        }
        MediaLibrary::replaceEverywhere($m->path, $new);
        Redirect::withTrashed()->updateOrCreate(['from_path' => $m->path], ['to_url' => '/' . $new, 'status_code' => 301, 'is_auto' => true, 'deleted_at' => null]);
        $old = $m->path;
        $m->path = $new;
        $m->variants = $variants ?: null;

        return "$old → $new (old URL redirects)";
    }
}
