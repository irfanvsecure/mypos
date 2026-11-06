<?php

namespace App\Http\Middleware;

use App\Site\HtmlOptimizer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** Runs HtmlOptimizer over HTML pages (see that class). Switch off with HTML_OPTIMIZE=false. */
class OptimizeHtml
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('site.optimize_html')
            || $response instanceof StreamedResponse
            || $response instanceof BinaryFileResponse
            || ! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return $response;
        }

        $html = $response->getContent();
        if (is_string($html) && $html !== '') {
            $response->setContent(HtmlOptimizer::fromMapFile()->optimize($html));
        }

        return $response;
    }
}
