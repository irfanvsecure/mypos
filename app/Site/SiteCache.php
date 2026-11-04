<?php

namespace App\Site;

use App\Http\Middleware\SiteRedirects;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Clears what a content change can make stale: settings and redirect maps, the site analysis cache used by
 * the SEO/link tools, and (when configured) Cloudflare's cache for the affected URLs.
 */
class SiteCache
{
    public const ANALYSIS_KEY = 'site.analysis.v1';

    /** @param string[] $paths URL paths that changed ('' = home); empty = purge everything at Cloudflare. */
    public static function changed(array $paths = []): array
    {
        Settings::flush();
        SiteRedirects::flush();
        Cache::forget(self::ANALYSIS_KEY);

        return ['cache' => 'cleared', 'cloudflare' => self::purgeCloudflare($paths)];
    }

    public static function purgeCloudflare(array $paths = []): string
    {
        $token = config('mcp_site.cloudflare.token');
        $zone = config('mcp_site.cloudflare.zone');
        if (! $token || ! $zone) {
            return 'not configured';
        }

        $base = rtrim((string) config('site.url'), '/');
        $urls = array_values(array_unique(array_map(fn ($p) => $base . '/' . ltrim($p, '/'), $paths)));
        $body = $urls ? ['files' => array_merge($urls, [$base . '/sitemap.xml'])] : ['purge_everything' => true];

        try {
            $res = Http::withToken($token)->timeout(8)
                ->post("https://api.cloudflare.com/client/v4/zones/$zone/purge_cache", $body);

            return $res->successful() ? ($urls ? 'purged ' . count($body['files']) . ' URLs' : 'purged everything') : 'failed: HTTP ' . $res->status();
        } catch (\Throwable $e) {
            Log::channel('mcp')->warning('cloudflare purge failed', ['error' => $e->getMessage()]);

            return 'failed: ' . $e->getMessage();
        }
    }
}
