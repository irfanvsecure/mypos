<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sends http:// and www. requests to the one canonical address in a single redirect, and adds HSTS on it.
 * Lives here rather than in public/.htaccess because production's document root is the project folder, where a
 * rewrite rule in public/ can see /public/... as the request URI. Other hosts (local, tests) are left alone.
 */
class CanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $canonical = (string) config('site.canonical_host');
        $host = strtolower($request->getHost());

        if ($canonical === '' || ! in_array($host, [$canonical, 'www.' . $canonical], true)) {
            return $next($request);
        }

        if ($host !== $canonical || ! $request->isSecure()) {
            // 308 keeps the method and body of a POST; a 301 may turn it into a GET.
            $status = $request->isMethodSafe() ? 301 : 308;

            return $this->withHsts($request, redirect()->away('https://' . $canonical . $request->getRequestUri(), $status));
        }

        return $this->withHsts($request, $next($request));
    }

    /** Browsers only accept HSTS over HTTPS, so https://www gets it on its redirect and plain http never does. */
    private function withHsts(Request $request, Response $response): Response
    {
        if ($request->isSecure() && ($maxAge = (int) config('site.hsts_max_age')) > 0) {
            $response->headers->set('Strict-Transport-Security', 'max-age=' . $maxAge);
        }

        return $response;
    }
}
