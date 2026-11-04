<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $base = rtrim(config('site.url'), '/');
        // Pages: published database pages (last change to the page, its sections or SEO), plus any Blade page
        // not moved to the database yet (file time). Sorted the way the Blade files always were.
        // Left out: pages / posts set to noindex or "exclude from sitemap" through the SEO tools.
        $hidden = fn ($seo) => $seo && ($seo->exclude_from_sitemap || str_contains(strtolower((string) $seo->robots), 'noindex'));
        // Paths with a database record in any state (draft, trashed) never fall back to their old Blade file.
        $inDatabase = array_flip(Page::withTrashed()->pluck('path')->all());
        $pages = [];
        foreach (Page::published()->withMax('sections', 'updated_at')->with('seo')->get() as $page) {
            if ($hidden($page->seo)) {
                continue;
            }
            $pages[$page->path] = max(array_filter([
                $page->updated_at?->timestamp,
                $page->sections_max_updated_at ? strtotime($page->sections_max_updated_at) : null,
                $page->seo?->updated_at?->timestamp,
            ]));
        }
        if (! isset($inDatabase['']) && is_file(resource_path('views/home.blade.php'))) {
            $pages[''] = filemtime(resource_path('views/home.blade.php'));
        }
        foreach (File::allFiles(resource_path('views/pages')) as $file) {
            $slug = str_replace(['\\', '.blade.php'], ['/', ''], $file->getRelativePathname());
            if (! isset($inDatabase[$slug])) {
                $pages[$slug] = $file->getMTime();
            }
        }
        $home = $pages[''] ?? null;
        unset($pages['']);
        uksort($pages, fn ($a, $b) => strcmp($a . '.blade.php', $b . '.blade.php'));

        $urls = $home ? [[$base . '/', $home, '1.0']] : [];
        foreach ($pages as $slug => $time) {
            $urls[] = [$base . '/' . $slug, $time, str_contains($slug, '-policy') || $slug === 'terms-of-service' ? '0.3' : '0.8'];
        }

        $urls[] = [$base . '/blogs', Post::max('updated_at') ? strtotime(Post::max('updated_at')) : time(), '0.7'];
        foreach (Post::published()->with('seo')->get(['id', 'slug', 'updated_at']) as $p) {
            if ($hidden($p->seo)) {
                continue;
            }
            $urls[] = [$base . '/' . $p->slug, $p->updated_at->timestamp, '0.6'];
        }

        $urls[] = [$base . '/clients', time(), '0.5'];
        foreach (Client::get(['slug', 'updated_at']) as $c) {
            $urls[] = [$base . '/portfolio-item/' . $c->slug, $c->updated_at->timestamp, '0.3'];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$loc, $mod, $prio]) {
            $xml .= '  <url><loc>' . e($loc) . '</loc><lastmod>' . date('Y-m-d', $mod) . '</lastmod><priority>' . $prio . "</priority></url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
