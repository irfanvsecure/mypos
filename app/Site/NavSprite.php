<?php

namespace App\Site;

/**
 * The header menu icons (config('site.nav_icons')) as one cached SVG sprite file.
 *
 * Every page used to carry about 130 inline icons (desktop menu + mobile menu), around 30 KB of SVG that
 * pushed most pages under Semrush's text-to-HTML threshold. The menu now draws each icon with
 * <svg><use href="sprite#key"/></svg>; the stroke style lives on a <g> inside each symbol and the colour is
 * currentColor, so the icons keep following the CSS colour of .dd-ic / .pp-ic exactly as before.
 *
 * After changing nav_icons run `php artisan site:nav-sprite`; NavSpriteTest fails while the file is stale.
 */
class NavSprite
{
    public const FILE = 'images/nav-icons.svg';

    public static function build(): string
    {
        $symbols = '';
        foreach (config('site.nav_icons') as $key => $paths) {
            $symbols .= '<symbol id="' . $key . '" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">'
                . $paths . '</g></symbol>' . "\n";
        }

        return '<svg xmlns="http://www.w3.org/2000/svg">' . "\n" . $symbols . '</svg>' . "\n";
    }

    /** Versioned URL of the sprite, so browsers fetch a new copy whenever the icons change. */
    public static function url(): string
    {
        static $version;
        $version ??= substr((string) @md5_file(public_path(self::FILE)), 0, 8);

        return asset(self::FILE) . '?v=' . $version;
    }

    public static function icon(string $key, int $size = 20): string
    {
        return '<svg width="' . $size . '" height="' . $size . '" aria-hidden="true"><use href="' . self::url() . '#' . $key . '"/></svg>';
    }
}
