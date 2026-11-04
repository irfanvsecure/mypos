<?php

namespace App\Site;

use App\Http\Controllers\BlogController;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

/**
 * Renders a page or blog post to the HTML a visitor would get, from inside another request (an MCP call).
 * The request is swapped for one at the page's path while rendering, so per-page values (WhatsApp message,
 * demo link) come out exactly as they do on the live site.
 */
class PageRenderer
{
    public static function page(Page $page, bool $annotate = false): string
    {
        $page->loadMissing(['sections', 'seo', 'schemaBlocks']);

        return self::within($page->path, function () use ($page, $annotate) {
            SectionRenderer::$annotate = $annotate;
            try {
                return view('site.page', ['page' => $page])->render();
            } finally {
                SectionRenderer::$annotate = false;
            }
        });
    }

    public static function post(Post $post): string
    {
        return self::within($post->slug, fn () => app(BlogController::class)->show($post)->render());
    }

    private static function within(string $path, callable $render): string
    {
        $app = app();
        $original = $app['request'];
        $url = $app['url'];
        $root = rtrim($url->to('/'), '/');

        $request = Request::create($root . '/' . ltrim($path, '/'), 'GET');
        $request->setLaravelSession($app['session']->driver());
        $app->instance('request', $request);
        $url->setRequest($request);
        Facade::clearResolvedInstance('request');
        View::share('errors', new ViewErrorBag());
        $formRendered = config('site.form_rendered');
        config(['site.form_rendered' => false]);

        try {
            return $render();
        } finally {
            config(['site.form_rendered' => $formRendered]);
            $app->instance('request', $original);
            $url->setRequest($original);
            Facade::clearResolvedInstance('request');
            View::flushState();
        }
    }
}
