<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

/**
 * Saves the rendered HTML (plus status code and Location header) of every public URL, so a refactor can be
 * proven to change nothing: take a snapshot before, one after, then run `site:diff`.
 *
 * The URL list is frozen in the first ("baseline") snapshot's manifest and reused by later snapshots, so pages
 * that move from Blade files into the database are still compared one for one.
 */
class SiteSnapshot extends Command
{
    protected $signature = 'site:snapshot
        {label : Folder name under storage/app/snapshots, e.g. "baseline" or "after-home"}
        {--base= : Site root to fetch from (default SITE_SNAPSHOT_URL or http://127.0.0.1:8090 — run `php artisan serve --port=8090`)}
        {--urls-from= : Reuse the URL list of this earlier snapshot (default: baseline, when it exists)}
        {--only= : Comma-separated paths to fetch (e.g. ",car-wash-pos" — an empty item is the home page)}';

    protected $description = 'Save the rendered HTML of every public URL for before/after comparison';

    public function handle(): int
    {
        $base = rtrim($this->option('base') ?: env('SITE_SNAPSHOT_URL', 'http://127.0.0.1:8090'), '/');
        $root = storage_path('app/snapshots');
        $dir = $root . '/' . $this->argument('label');

        $from = $this->option('urls-from') ?: (is_file("$root/baseline/manifest.json") ? 'baseline' : null);
        $paths = $from
            ? array_keys(json_decode(File::get("$root/$from/manifest.json"), true)['pages'])
            : $this->discoverPaths();

        if ($only = $this->option('only')) {
            $paths = array_values(array_intersect($paths, explode(',', $only)));
        }

        File::ensureDirectoryExists($dir . '/pages');
        $manifest = ['base' => $base, 'taken_at' => now()->toIso8601String(), 'pages' => []];

        $bar = $this->output->createProgressBar(count($paths));
        foreach ($paths as $path) {
            $res = Http::withoutRedirecting()->timeout(60)->get($base . '/' . $path);
            File::put($dir . '/pages/' . self::fileName($path), $res->body());
            $manifest['pages'][$path] = [
                'status' => $res->status(),
                'location' => $res->header('Location') ?: null,
                'content_type' => $res->header('Content-Type'),
                'x_robots' => $res->header('X-Robots-Tag') ?: null,
            ];
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        File::put($dir . '/manifest.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info(count($paths) . " URLs saved to $dir");

        return self::SUCCESS;
    }

    /** Every URL the site answers: pages, blog, clients, SEO files, redirects and 410s. */
    private function discoverPaths(): array
    {
        $paths = [''];

        if (class_exists(\App\Models\Page::class) && \Illuminate\Support\Facades\Schema::hasTable('pages')) {
            $paths = array_merge($paths, \App\Models\Page::pluck('path')->all());
        }

        $paths[] = 'blogs';
        foreach (array_keys(Post::TOPICS) as $topic) {
            $paths[] = 'blogs?topic=' . $topic;
        }
        $paths[] = 'blogs?page=2';
        $paths = array_merge($paths, Post::published()->pluck('slug')->all());

        $paths[] = 'clients';
        $paths = array_merge($paths, Client::pluck('slug')->map(fn ($s) => 'portfolio-item/' . $s)->all());

        $paths = array_merge($paths, ['thank-you', 'sitemap.xml', 'robots.txt', 'this-page-does-not-exist', 'Single-Location']);
        $paths = array_merge($paths, array_keys(config('site.redirects')), config('site.gone'));

        return array_values(array_unique($paths));
    }

    public static function fileName(string $path): string
    {
        return ($path === '' ? '_home' : preg_replace('/[^a-z0-9._-]+/i', '~', $path)) . '.html';
    }
}
