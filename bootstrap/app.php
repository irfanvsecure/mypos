<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\CanonicalHost::class);
        $middleware->append(\App\Http\Middleware\NoindexHeader::class);
        // Behind Cloudflare / a load balancer set TRUSTED_PROXIES=* so HTTPS is detected (the MCP endpoint requires it).
        if ($proxies = env('TRUSTED_PROXIES')) {
            $middleware->trustProxies(at: $proxies === '*' ? '*' : explode(',', $proxies));
        }
        // Redirects / 410s from the redirects table (in the web group, so error pages get a session as before).
        $middleware->appendToGroup('web', \App\Http\Middleware\SiteRedirects::class);
        // Inline styles → classes and collapsed whitespace on every HTML page (app/Site/HtmlOptimizer.php).
        $middleware->appendToGroup('web', \App\Http\Middleware\OptimizeHtml::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
