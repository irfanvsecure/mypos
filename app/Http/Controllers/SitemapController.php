<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Post;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $base = rtrim(config('site.url'), '/');
        $urls = [[$base . '/', filemtime(resource_path('views/home.blade.php')), '1.0']];

        foreach (File::allFiles(resource_path('views/pages')) as $file) {
            $slug = str_replace(['\\', '.blade.php'], ['/', ''], $file->getRelativePathname());
            $urls[] = [$base . '/' . $slug, $file->getMTime(), str_contains($slug, '-policy') || $slug === 'terms-of-service' ? '0.3' : '0.8'];
        }

        $urls[] = [$base . '/blogs', Post::max('updated_at') ? strtotime(Post::max('updated_at')) : time(), '0.7'];
        foreach (Post::published()->get(['slug', 'updated_at']) as $p) {
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
