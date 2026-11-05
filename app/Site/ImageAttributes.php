<?php

namespace App\Site;

use App\Models\Media;

/**
 * Fills in what stored HTML often lacks on its images, at render time: width and height from the media library
 * (so the page does not jump as images load) and, in blog posts, lazy loading after the first image.
 * Attributes already present are kept.
 */
class ImageAttributes
{
    public static function apply(string $html, bool $lazyAfterFirst = false): string
    {
        if (! str_contains($html, '<img')) {
            return $html;
        }

        $seen = 0;

        return preg_replace_callback('/<img\b[^>]*>/i', function ($m) use (&$seen, $lazyAfterFirst) {
            $tag = $m[0];
            $add = '';
            $first = $seen++ === 0;

            if (! preg_match('/\swidth\s*=/i', $tag) && ! preg_match('/\sheight\s*=/i', $tag)
                && preg_match('/\ssrc\s*=\s*"([^"]+)"/i', $tag, $src) && ($size = self::size($src[1]))) {
                $add .= ' width="' . $size[0] . '" height="' . $size[1] . '"';
            }
            if ($lazyAfterFirst && ! $first && ! preg_match('/\sloading\s*=/i', $tag)) {
                $add .= ' loading="lazy" decoding="async"';
            }

            return $add === '' ? $tag : preg_replace('/^<img\b/i', '<img' . $add, $tag);
        }, $html);
    }

    /** [width, height] of a local upload, or null when the media library does not know it. */
    private static function size(string $src): ?array
    {
        $path = ltrim((string) parse_url($src, PHP_URL_PATH), '/');
        $path = str_starts_with($path, 'public/') ? substr($path, 7) : $path;

        return self::sizes()[$path] ?? null;
    }

    private static function sizes(): array
    {
        return once(fn () => Media::whereNotNull('width')->whereNotNull('height')->where('width', '>', 0)->where('height', '>', 0)
            ->get(['path', 'width', 'height'])
            ->mapWithKeys(fn ($m) => [$m->path => [(int) $m->width, (int) $m->height]])
            ->all());
    }
}
