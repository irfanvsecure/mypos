<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\View;

/**
 * Catch-all for the migrated WordPress URLs:
 *   1. old URL listed in config('site.redirects')  -> 301
 *   2. spam URL listed in config('site.gone')       -> 410
 *   3. resources/views/pages/{slug}.blade.php       -> static page
 *   4. a published blog post with that slug         -> post
 */
class PageController extends Controller
{
    public function show(string $slug)
    {
        $slug = trim($slug, '/');

        // WordPress matched slugs case-insensitively (e.g. /Single-Location) — canonicalise to lowercase.
        if ($slug !== strtolower($slug)) {
            return redirect('/' . strtolower($slug), 301);
        }

        if ($to = config('site.redirects')[$slug] ?? null) {
            return redirect($to, 301);
        }

        if (in_array($slug, config('site.gone'), true)) {
            abort(410);
        }

        $view = 'pages.' . str_replace('/', '.', $slug);
        if (preg_match('#^[a-z0-9\-/]+$#', $slug) && View::exists($view)) {
            return view($view);
        }

        if (!str_contains($slug, '/') && ($post = Post::published()->where('slug', $slug)->first())) {
            return app(BlogController::class)->show($post);
        }

        abort(404);
    }
}
