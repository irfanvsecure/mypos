<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * While config('site.noindex') is on, tell search engines not to index or follow anything Laravel serves
 * (pages, redirects, sitemap, errors) — the header also covers non-HTML responses that have no <meta> tag.
 */
class NoindexHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (config('site.noindex')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
