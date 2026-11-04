<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\View;

/**
 * Catch-all for the migrated WordPress URLs (redirects / 410s are handled before this by SiteRedirects):
 *   1. upper-case path                              -> 301 to lower case
 *   2. (redirects table, see App\Http\Middleware\SiteRedirects)
 *   3. a published page in the pages table          -> sections rendered by site.page
 *   4. resources/views/pages/{slug}.blade.php       -> static page (not yet moved to the database)
 *   5. a published blog post with that slug         -> post
 */
class PageController extends Controller
{
    public function home()
    {
        if ($page = $this->dbPage('')) {
            return view('site.page', ['page' => $page]);
        }

        return view('home');
    }

    /** A published page from the pages table (sections, SEO and structured data eager-loaded). */
    private function dbPage(string $path): ?Page
    {
        if (config('site.__extract')) {
            return null; // site:extract always reads the Blade file
        }

        return Page::published()->where('path', $path)->with(['sections', 'seo', 'schemaBlocks'])->first();
    }

    public function show(string $slug)
    {
        $slug = trim($slug, '/');

        // WordPress matched slugs case-insensitively (e.g. /Single-Location) — canonicalise to lowercase.
        if ($slug !== strtolower($slug)) {
            return redirect('/' . strtolower($slug), 301);
        }

        // Redirects and 410s (old WordPress URLs, spam) are answered earlier by the SiteRedirects middleware.

        if ($page = $this->dbPage($slug)) {
            return view('site.page', ['page' => $page]);
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
