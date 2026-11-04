<?php

namespace App\Site;

/**
 * robots.txt. Crawling stays allowed while SITE_NOINDEX is on, so bots can see the noindex signals; the sitemap
 * is only advertised once the site is meant to be indexed. Extra rules come from the robots_extra setting.
 */
class Robots
{
    public static function text(): string
    {
        $txt = "User-agent: *\nDisallow: /enquiry\n";
        if ($extra = trim((string) config('site.robots_extra'))) {
            $txt .= str_replace("\r\n", "\n", $extra) . "\n";
        }
        if (! config('site.noindex')) {
            $txt .= "\nSitemap: " . rtrim(config('site.url'), '/') . "/sitemap.xml\n";
        }

        return $txt;
    }
}
