<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\ClientLogo;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Redirect;
use App\Models\Testimonial;
use App\Http\Middleware\SiteRedirects;
use App\Site\Settings;
use App\Models\SchemaBlock;
use App\Site\Extract\ContentSplitter;
use App\Site\Tokens;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

/**
 * One-time extraction of the hand-built Blade pages into the website tables, copying the exact rendered content
 * (text, headings, CTAs, images, alt texts, links, FAQs, meta, structured data). Nothing is rewritten.
 *
 *   php artisan site:extract ""  car-wash-pos   (the empty path is the home page)
 *   php artisan site:extract --all
 *
 * Each page is rendered in its own process (site:extract-render) with sentinel values for everything that
 * depends on the request or settings, which come back here as {{tokens}}. Top-level blocks become sections:
 * a block that is a single <x-component> is stored as that component with its exact attributes, any other
 * block as HTML in which nested components are {{embed:N}} placeholders.
 */
class SiteExtract extends Command
{
    protected $signature = 'site:extract {paths?* : URL paths ("" for home)} {--all : Every Blade page not yet in the database} {--force : Replace pages that are already in the database} {--globals : Also copy settings, testimonials, proof logos and redirects from config (only into empty tables)}';

    protected $description = 'Copy Blade pages into the website content tables (exact content, nothing rewritten)';

    /** Components whose `items` move into the faqs table: name => items are HTML? */
    private const FAQ_COMPONENTS = ['faq' => true, 'faq-list' => false];

    private const YIELD_FIELDS = ['title' => 'title', 'description' => 'description', 'keywords' => 'keywords',
        'canonical' => 'canonical', 'og_image' => 'og_image', 'og_type' => 'og_type', 'robots' => 'robots'];

    public function handle(): int
    {
        if ($this->option('globals')) {
            $this->globals();
        }

        $paths = $this->option('all') ? $this->bladePaths() : array_map(fn ($p) => trim((string) $p, '/'), $this->argument('paths'));
        if (! $paths) {
            if ($this->option('globals')) {
                return self::SUCCESS;
            }
            $this->error('Give one or more paths, or --all.');
            return self::FAILURE;
        }

        $failed = 0;
        foreach ($paths as $path) {
            try {
                $exists = Page::withTrashed()->where('path', $path)->first();
                if ($exists && ! $this->option('force')) {
                    $this->line("skip /$path (already in the database; use --force to replace)");
                    continue;
                }
                $n = $this->extract($path, $exists);
                $this->info("/$path → $n sections");
            } catch (\Throwable $e) {
                $failed++;
                $this->error("/$path: " . $e->getMessage());
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /** Sitewide content kept in config/site.php → settings, testimonials, client_logos, redirects (only if empty). */
    private function globals(): void
    {
        $this->info('settings: ' . Settings::seedFromConfig() . ' added');

        if (! Testimonial::withTrashed()->exists()) {
            foreach (config('site.reviews') as $i => [$name, $text]) {
                Testimonial::create(['name' => $name, 'text' => $text, 'source' => 'Google', 'rating' => 5, 'sort_order' => $i + 1]);
            }
        }
        $this->info('testimonials: ' . Testimonial::count());

        if (! ClientLogo::withTrashed()->where('logo_group', 'proof')->exists()) {
            foreach (config('site.proof_logos') as $i => [$image, $name]) {
                ClientLogo::create(['logo_group' => 'proof', 'name' => $name, 'image' => $image, 'sort_order' => $i + 1]);
            }
        }
        $this->info('proof logos: ' . ClientLogo::where('logo_group', 'proof')->count());

        if (! Redirect::withTrashed()->exists()) {
            foreach (config('site.redirects') as $from => $to) {
                Redirect::create(['from_path' => $from, 'to_url' => $to, 'status_code' => 301]);
            }
            foreach (config('site.gone') as $from) {
                Redirect::create(['from_path' => $from, 'to_url' => null, 'status_code' => 410]);
            }
            SiteRedirects::flush();
        }
        $this->info('redirects: ' . Redirect::count());
    }

    private function bladePaths(): array
    {
        $paths = is_file(resource_path('views/home.blade.php')) ? [''] : [];
        foreach (File::allFiles(resource_path('views/pages')) as $f) {
            $paths[] = str_replace(['\\', '.blade.php'], ['/', ''], $f->getRelativePathname());
        }
        $done = Page::withTrashed()->pluck('path')->all();

        return $this->option('force') ? $paths : array_values(array_diff($paths, $done));
    }

    private function extract(string $path, ?Page $existing): int
    {
        $result = Process::path(base_path())->timeout(120)->run([PHP_BINARY, 'artisan', 'site:extract-render', $path]);
        $json = json_decode($result->output(), true);
        if (! $json) {
            throw new \RuntimeException('render failed: ' . trim($result->errorOutput() ?: $result->output()));
        }
        if ($json['status'] !== 200) {
            throw new \RuntimeException("rendered with HTTP {$json['status']}: " . mb_substr(trim(preg_replace('/\s+/', ' ', $json['error'] ?? '')), 0, 300));
        }

        $layout = $json['layout'];
        $captured = $json['captured'];
        $decode = fn ($v) => $v === null ? null : html_entity_decode($v, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $yields = array_map($decode, $layout['yields']);

        if (trim($layout['scripts'] ?? '') !== '') {
            throw new \RuntimeException('page pushes to the "scripts" stack, which sections cannot hold');
        }

        return DB::transaction(function () use ($path, $existing, $layout, $captured, $yields) {
            if ($existing) {
                $existing->sections()->withTrashed()->get()->each->forceDelete();
                $existing->schemaBlocks()->withTrashed()->forceDelete();
                Faq::withTrashed()->where('faq_group', 'like', $this->groupPrefix($path) . '%')->forceDelete();
                ClientLogo::withTrashed()->where('logo_group', 'like', 'marquee:' . $this->groupPrefix($path) . '%')->forceDelete();
                $existing->seo()->withTrashed()->forceDelete();
                $existing->restore();
            }

            $page = $existing ?? new Page(['path' => $path]);
            $page->fill([
                'name' => $this->pageName($yields['title'], $path),
                'page_key' => $yields['page'],
                'status' => 'published',
                'options' => array_filter(['pixel_category' => $yields['pixel_category']], fn ($v) => $v !== null),
            ])->save();

            $seo = array_filter(array_map(fn ($f) => $yields[$f], self::YIELD_FIELDS), fn ($v) => $v !== null);
            $page->seo()->create(Tokens::tokenize($seo));

            foreach ($this->schemaBlocks($layout['head']) as $i => [$type, $json]) {
                $page->schemaBlocks()->create(['schema_type' => $type, 'json' => $json, 'sort_order' => $i + 1]);
            }

            $split = ContentSplitter::split(str_replace("\r\n", "\n", $layout['content']));
            $used = [];
            $counters = ['faq' => 0, 'logos' => 0];
            foreach ($split['items'] as $i => $item) {
                $before = Tokens::tokenize($item['before']);
                if ($item['kind'] === 'component') {
                    $cap = $captured[$item['key']] ?? throw new \RuntimeException("no capture for component marker {$item['key']}");
                    $attrs = $this->moveListsToTables($cap['component'], $cap['attributes'], $path, $counters);
                    $content = ['before' => $before, 'attributes' => Tokens::tokenize($attrs)];
                    if ($cap['slot'] !== null) {
                        $content['slot'] = $this->htmlWithEmbeds($cap['slot'], $captured, $path, $counters);
                    }
                    $key = $this->uniqueKey($cap['attributes']['id'] ?? $cap['component'], $used);
                    $page->sections()->create(['key' => $key, 'type' => 'component', 'component' => $cap['component'],
                        'sort_order' => ($i + 1) * 10, 'content' => $content]);
                } else {
                    $content = ['before' => $before] + $this->htmlWithEmbeds($item['html'], $captured, $path, $counters);
                    $page->sections()->create(['key' => $this->uniqueKey($this->elementKey($item['html']), $used), 'type' => 'html',
                        'sort_order' => ($i + 1) * 10, 'content' => $content]);
                }
            }

            $tail = Tokens::tokenize($split['tail']);
            $page->options = array_merge($page->options ?? [], $tail !== '' ? ['content_tail' => $tail] : []);
            $page->save();

            ActivityLog::record('cli', 'page.extract', $page, "Extracted /$path from Blade", null, ['sections' => count($split['items'])]);

            return count($split['items']);
        });
    }

    /** HTML of one block, with every top-level component inside it replaced by {{embed:N}}. */
    private function htmlWithEmbeds(string $html, array $captured, string $path, array &$counters): array
    {
        $embeds = [];
        $html = preg_replace_callback('/<!--§E(\d+)-->.*?<!--§\/E\1-->/s', function ($m) use (&$embeds, $captured, $path, &$counters) {
            $cap = $captured[(int) $m[1]] ?? throw new \RuntimeException("no capture for component marker {$m[1]}");
            $embed = ['component' => $cap['component'],
                'attributes' => Tokens::tokenize($this->moveListsToTables($cap['component'], $cap['attributes'], $path, $counters))];
            if ($cap['slot'] !== null) {
                $embed['slot'] = $this->htmlWithEmbeds($cap['slot'], $captured, $path, $counters);
            }
            $embeds[] = $embed;

            return '{{embed:' . (count($embeds) - 1) . '}}';
        }, $html);

        $html = Tokens::tokenize($html);
        $this->assertClean($html);

        return $embeds ? ['html' => $html, 'embeds' => $embeds] : ['html' => $html];
    }

    /** FAQ items → faqs table, logo rows → client_logos; the component then reads them by group. */
    private function moveListsToTables(string $component, array $attrs, string $path, array &$counters): array
    {
        if (isset(self::FAQ_COMPONENTS[$component]) && isset($attrs['items']) && is_array($attrs['items'])) {
            $group = $this->groupPrefix($path) . 'faq-' . (++$counters['faq']);
            foreach (array_values($attrs['items']) as $i => [$q, $a]) {
                Faq::create(['faq_group' => $group, 'question' => $q, 'answer' => $a,
                    'is_html' => self::FAQ_COMPONENTS[$component], 'sort_order' => $i + 1]);
            }
            unset($attrs['items']);
            $attrs['group'] = $group;
        }

        if ($component === 'client-marquee' && isset($attrs['rows'])) {
            $groups = [];
            $n = ++$counters['logos'];
            foreach (array_values($attrs['rows']) as $r => $row) {
                $groups[] = $group = 'marquee:' . $this->groupPrefix($path) . $n . '-row' . ($r + 1);
                foreach (array_values($row) as $i => [$logo, $name, $slug]) {
                    ClientLogo::create(['logo_group' => $group, 'name' => $name, 'image' => $logo, 'client_slug' => $slug, 'sort_order' => $i + 1]);
                }
            }
            unset($attrs['rows']);
            $attrs['groups'] = $groups;
        }

        return $attrs;
    }

    private function groupPrefix(string $path): string
    {
        return ($path === '' ? 'home' : $path) . ':';
    }

    /** Page-level JSON-LD blocks (between the §H markers the extractor put inside @push('head')). */
    private function schemaBlocks(string $head): array
    {
        $blocks = [];
        preg_match_all('/<!--§H-->(.*?)<!--§\/H-->/s', $head, $parts);
        foreach ($parts[1] as $part) {
            $rest = preg_replace_callback('/<script type="application\/ld\+json">(.*?)<\/script>\n?/s', function ($m) use (&$blocks) {
                $data = json_decode($m[1], true);
                if (! is_array($data)) {
                    throw new \RuntimeException('page has a JSON-LD block that is not valid JSON');
                }
                $type = $data['@type'] ?? 'Thing';
                $blocks[] = [is_array($type) ? implode(',', $type) : $type, Tokens::tokenize($m[1])];

                return '';
            }, $part);
            if (trim($rest) !== '') {
                throw new \RuntimeException('page pushes something other than JSON-LD into <head>: ' . mb_substr(trim($rest), 0, 120));
            }
        }

        return $blocks;
    }

    private function assertClean(string $html): void
    {
        if (str_contains($html, 'name="_token"')) {
            throw new \RuntimeException('a form with a CSRF token is part of an HTML block; move the form into a component first');
        }
        if (preg_match('/§|%%[A-Z_]+%%|extract\.invalid/', $html, $m)) {
            throw new \RuntimeException("left-over extraction marker in HTML: {$m[0]}");
        }
    }

    private function elementKey(string $html): string
    {
        if (preg_match('/^<([a-z0-9]+)[^>]*?\bid="([^"]+)"/i', $html, $m)) {
            return $m[2];
        }
        if (preg_match('/^<([a-z0-9]+)[^>]*?\bclass="([^"]+)"/i', $html, $m)) {
            return strtok($m[2], ' ');
        }

        return preg_match('/^<([a-z0-9]+)/i', $html, $m) ? strtolower($m[1]) : 'block';
    }

    private function uniqueKey(string $base, array &$used): string
    {
        $base = Str::slug($base) ?: 'section';
        $key = $base;
        for ($i = 2; isset($used[$key]); $i++) {
            $key = "$base-$i";
        }
        $used[$key] = true;

        return $key;
    }

    private function pageName(?string $title, string $path): string
    {
        $name = trim(preg_replace('/\s+[-|–—]\s+(my ?pos.*)$/i', '', (string) $title));

        return $name !== '' ? mb_substr($name, 0, 190) : ($path === '' ? 'Home' : Str::headline(basename($path)));
    }
}
