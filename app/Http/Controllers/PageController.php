<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;

/**
 * Catch-all for the migrated WordPress URLs (redirects / 410s are handled before this by SiteRedirects):
 *   1. upper-case path                              -> 301 to lower case
 *   2. (redirects table, see App\Http\Middleware\SiteRedirects)
 *   3. a published page in the pages table          -> sections rendered by site.page
 *   4. a published blog post with that slug         -> post
 */
class PageController extends Controller
{
    public function home()
    {
        if ($page = $this->dbPage('')) {
            return view('site.page', ['page' => $page]);
        }

        abort(404);
    }

    /** A published page from the pages table (sections, SEO and structured data eager-loaded). */
    private function dbPage(string $path): ?Page
    {
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

        if (!str_contains($slug, '/') && ($post = Post::published()->where('slug', $slug)->first())) {
            return app(BlogController::class)->show($post);
        }

        abort(404);
    }
}
