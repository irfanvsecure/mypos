<?php

namespace App\Mcp\Tools;

use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SiteRedirects;
use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Redirect;
use App\Models\SchemaBlock;
use App\Models\SeoMeta;
use App\Models\Setting;
use App\Site\Settings;
use App\Site\SiteAnalyzer;
use App\Site\Tokens;
use Illuminate\Database\Eloquent\Model;

/** Meta tags, SEO audits and report, structured data, redirects, sitemap and robots.txt. */
class SeoTools
{
    private const FIELDS = ['title', 'description', 'focus_keyword', 'keywords', 'canonical', 'robots', 'og_title', 'og_description', 'og_image',
        'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image', 'exclude_from_sitemap'];

    private const ROBOTS = ['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'];

    public static function tools(): array
    {
        $type = P::str('page (default), post or category.')->enum(['page', 'post', 'category']);
        $ref = P::str('Page path, post slug or category slug ("" or "home" = home page).')->reqAllowEmpty();
        $seoParams = [
            'title' => P::str('SEO title (aim for 50–60 characters).', 'max:300'),
            'description' => P::str('Meta description (aim for 140–160 characters).', 'max:1000'),
            'focus_keyword' => P::str('Focus keyword (stored for reference and used by seo_report; not output).', 'max:120'),
            'canonical' => P::str('Canonical URL (empty = the page itself).', 'max:500'),
            'robots' => P::str('Robots directive.')->enum(self::ROBOTS),
            'og_title' => P::str('Social share title (default: the SEO title).', 'max:300'),
            'og_description' => P::str('Social share description.', 'max:1000'),
            'og_image' => P::str('Social share image path, e.g. /uploads/2026/11/share.webp.', 'max:500'),
            'twitter_card' => P::str('Twitter card type.')->enum(['summary', 'summary_large_image']),
            'twitter_title' => P::str('Twitter title.', 'max:300'),
            'twitter_description' => P::str('Twitter description.', 'max:1000'),
            'twitter_image' => P::str('Twitter image path.', 'max:500'),
            'exclude_from_sitemap' => P::bool('Leave this URL out of sitemap.xml.'),
        ];

        return [
            new SiteTool('get_seo', 'SEO fields of a page, blog post or blog category, plus the values actually output on the page (and whether site-wide noindex is forcing noindex).', [
                'type' => $type, 'ref' => $ref,
            ], function (array $a) {
                [$model, $kind] = self::seoTarget($a['type'] ?? 'page', $a['ref']);
                $out = ['type' => $kind, 'ref' => $a['ref'], 'stored' => self::stored($model)];
                if ($kind !== 'category') {
                    $an = Support::analyze($a['ref']);
                    $out['as_rendered'] = ['title' => $an['title'], 'description' => $an['description'], 'robots' => $an['robots'],
                        'canonical' => $an['canonical'], 'og_title' => $an['og_title'], 'og_image' => $an['og_image']];
                }
                $out['site_noindex'] = (bool) config('site.noindex');
                if ($out['site_noindex']) {
                    $out['note'] = 'SITE_NOINDEX is on (pre-launch): every page outputs noindex, nofollow whatever robots is set to.';
                }

                return $out;
            }, readOnly: true),

            new SiteTool('update_seo', 'Set SEO fields of a page, blog post or blog category. Only the fields you pass change; pass "" to clear one. Returns before / after and length warnings.', ['type' => $type, 'ref' => $ref] + $seoParams,
                fn (array $a) => self::updateSeo($a['type'] ?? 'page', $a['ref'], $a)),

            new SiteTool('bulk_update_seo', 'Update SEO fields of many pages / posts in one call: [{type?, ref, title?, description?, …}]. Returns before / after for each.', [
                'items' => P::arr('List of {type?, ref, fields…} (same fields as update_seo).', P::obj('One page'))->req(),
            ], function (array $a) {
                $results = [];
                foreach ($a['items'] as $i => $item) {
                    if (! is_array($item) || ! array_key_exists('ref', $item)) {
                        throw new ToolError("items[$i] needs ref.");
                    }
                    $fields = array_intersect_key($item, array_flip(self::FIELDS));
                    $v = \Illuminate\Support\Facades\Validator::make($fields, array_map(fn ($p) => [], $fields) + [
                        'robots' => 'nullable|in:' . implode(',', self::ROBOTS), 'twitter_card' => 'nullable|in:summary,summary_large_image',
                    ]);
                    $v->validate();
                    $results[] = self::updateSeo($item['type'] ?? 'page', (string) $item['ref'], $fields);
                }

                return ['updated' => count($results), 'results' => $results];
            }),

            new SiteTool('audit_meta', 'Meta-tag audit of every published page and post: missing / duplicate / too long or short titles (aim 50–60 characters) and descriptions (aim 140–160), missing canonical or OG image, and noindex pages still listed in the sitemap.', [],
                fn () => self::auditMeta(), readOnly: true),

            new SiteTool('audit_seo', 'Overall SEO audit: meta problems, heading problems, images without alt, thin content (under 300 words) and missing canonical — per page, worst first.', [
                'page' => P::str('Only this page / post.'),
            ], function (array $a) {
                $items = isset($a['page']) ? [Support::analyze($a['page'])] : array_values(SiteAnalyzer::all());
                $meta = collect(self::auditMeta()['pages'])->keyBy('path');
                $rows = [];
                foreach ($items as $an) {
                    $issues = $meta['/' . $an['path']]['issues'] ?? [];
                    $issues = array_merge($issues, HeadingTools::headingIssues($an['headings']));
                    $noAlt = count(array_filter($an['images'], fn ($i) => $i['alt'] === null || trim($i['alt']) === ''));
                    if ($noAlt) {
                        $issues[] = "$noAlt image(s) without alt text";
                    }
                    if ($an['words']['content_total'] < 300) {
                        $issues[] = "Thin content: {$an['words']['content_total']} words";
                    }
                    if (! $an['canonical']) {
                        $issues[] = 'No canonical link';
                    }
                    $rows[] = ['path' => '/' . $an['path'], 'type' => $an['type'], 'issue_count' => count($issues), 'issues' => $issues];
                }
                usort($rows, fn ($x, $y) => $y['issue_count'] <=> $x['issue_count']);

                return ['pages_checked' => count($rows), 'site_noindex' => (bool) config('site.noindex'), 'pages' => isset($a['page']) ? $rows : array_values(array_filter($rows, fn ($r) => $r['issue_count']))];
            }, readOnly: true),

            new SiteTool('seo_report', 'Everything about one page in one read-only result: outline, word count, meta tags, structured-data types, internal links in / out, image issues, the first paragraph, and focus-keyword checks.', [
                'page' => P::str('Page path or post slug.')->reqAllowEmpty(),
            ], function (array $a) {
                $an = Support::analyze($a['page']);
                $t = Support::target($a['page']);
                $all = SiteAnalyzer::all();
                $inbound = [];
                foreach ($all as $from => $other) {
                    foreach ($other['links'] as $l) {
                        if ($l['path'] === $an['path'] && ! in_array($l['section'], SiteAnalyzer::CHROME, true) && $from !== $an['path']) {
                            $inbound[] = ['from' => '/' . $from, 'anchor' => $l['anchor']];
                        }
                    }
                }
                $outbound = array_values(array_filter($an['links'], fn ($l) => $l['path'] !== null && ! in_array($l['section'], SiteAnalyzer::CHROME, true)));
                $keyword = $t['model']->seo?->focus_keyword;
                $kwChecks = null;
                if ($keyword) {
                    $kw = mb_strtolower($keyword);
                    $h1 = collect($an['headings'])->firstWhere('level', 1)['text'] ?? '';
                    $kwChecks = [
                        'in_title' => str_contains(mb_strtolower((string) $an['title']), $kw),
                        'in_description' => str_contains(mb_strtolower((string) $an['description']), $kw),
                        'in_h1' => str_contains(mb_strtolower($h1), $kw),
                        'in_first_paragraph' => str_contains(mb_strtolower((string) $an['first_paragraph']), $kw),
                        'in_url' => str_contains($an['path'], str_replace(' ', '-', $kw)),
                    ];
                }
                $imgIssues = array_values(array_filter(array_map(fn ($i) => $i['alt'] === null || trim($i['alt']) === '' ? ['src' => $i['src'], 'issue' => 'no alt', 'section' => $i['section']] : null, $an['images'])));

                return [
                    'path' => '/' . $an['path'], 'type' => $an['type'],
                    'meta' => ['title' => $an['title'], 'title_length' => mb_strlen((string) $an['title']), 'description' => $an['description'],
                        'description_length' => mb_strlen((string) $an['description']), 'canonical' => $an['canonical'], 'robots' => $an['robots'], 'og_image' => $an['og_image']],
                    'site_noindex' => (bool) config('site.noindex'),
                    'focus_keyword' => $keyword, 'keyword_checks' => $kwChecks,
                    'outline' => array_map(fn ($h) => str_repeat('  ', $h['level'] - 1) . 'H' . $h['level'] . ' ' . $h['text'], $an['headings']),
                    'heading_issues' => HeadingTools::headingIssues($an['headings']),
                    'words' => $an['words']['content_total'],
                    'first_paragraph' => $an['first_paragraph'],
                    'schema_types' => $an['schema_types'],
                    'internal_links' => ['outbound' => count($outbound), 'inbound_pages' => count(array_unique(array_column($inbound, 'from'))), 'inbound' => array_slice($inbound, 0, 30)],
                    'image_issues' => $imgIssues,
                ];
            }, readOnly: true),

            // ---------------- structured data ----------------
            new SiteTool('get_schema', 'Structured data (JSON-LD) of a page: the editable blocks stored for it, and the types output automatically (site-wide Organization, breadcrumbs, FAQPage from FAQ blocks, Article on posts).', [
                'page' => P::str('Page path or post slug.')->reqAllowEmpty(),
            ], function (array $a) {
                $t = Support::target($a['page']);
                $an = Support::analyze($a['page']);
                $stored = $t['type'] === 'page'
                    ? $t['model']->schemaBlocks()->withTrashed()->get()->map(fn ($b) => ['id' => $b->id, 'type' => $b->schema_type, 'active' => $b->is_active && ! $b->trashed(), 'json' => json_decode(Tokens::resolveRaw($b->json), true), 'raw' => $b->json])->all()
                    : [];

                return ['path' => '/' . $an['path'], 'stored_blocks' => $stored, 'all_types_output' => $an['schema_types'],
                    'automatic' => array_values(array_diff($an['schema_types'], array_column($stored, 'type')))];
            }, readOnly: true),

            new SiteTool('update_schema', 'Replace the JSON of a stored structured-data block, or switch it on / off. The JSON must be one schema.org object with @context and @type; {{base}} / {{site_url}} placeholders are allowed.', [
                'id' => P::int('Block id (from get_schema).')->req(),
                'json' => P::str('New JSON-LD (an object).'),
                'active' => P::bool('Output it (true) or keep it stored but off (false).'),
            ], function (array $a) {
                $b = SchemaBlock::findOrFail($a['id']);
                $before = $b->only(['schema_type', 'json', 'is_active']);
                if (isset($a['json'])) {
                    [$json, $type] = self::validJsonLd($a['json']);
                    $owner = $b->schemaable;
                    if ($owner && $owner->schemaBlocks()->where('id', '!=', $b->id)->where('schema_type', $type)->exists()) {
                        throw new ToolError("This page already has a $type block.");
                    }
                    $b->fill(['json' => $json, 'schema_type' => $type]);
                }
                if (isset($a['active'])) {
                    $b->is_active = (bool) $a['active'];
                }
                $b->save();
                Support::log('schema.update', $b, "Updated {$b->schema_type} schema", $before, $b->only(['schema_type', 'json', 'is_active']));

                return ['block' => ['id' => $b->id, 'type' => $b->schema_type, 'active' => $b->is_active], 'cache' => Support::changed($b->schemaable instanceof Page ? [$b->schemaable->path] : [])];
            }),

            new SiteTool('delete_schema', 'Move a stored structured-data block to the trash.', ['id' => P::int('Block id.')->req()], function (array $a) {
                $b = SchemaBlock::findOrFail($a['id']);
                $b->delete();
                Support::log('schema.delete', $b, "Moved {$b->schema_type} schema to the trash", $b->only(['json']));

                return ['deleted' => $b->id, 'cache' => Support::changed($b->schemaable instanceof Page ? [$b->schemaable->path] : [])];
            }, destructive: true),

            new SiteTool('generate_schema', 'Build a structured-data block from the site\'s own data: Organization or LocalBusiness (settings), SoftwareApplication (with PKR offers from pricing_plans), Product, FAQPage, BreadcrumbList or Article. Returns the JSON; save=true stores it on the page. Never adds review / rating markup about our own business. Refuses a type the page already outputs.', [
                'page' => P::str('Page path.')->reqAllowEmpty(),
                'type' => P::str('Schema type.')->enum(['Organization', 'LocalBusiness', 'SoftwareApplication', 'Product', 'FAQPage', 'BreadcrumbList', 'Article'])->req(),
                'plan_group' => P::str('SoftwareApplication / Product: pricing_plans group for the offers (default: one-time).'),
                'save' => P::bool('Store it on the page (default false: just return it).'),
            ], fn (array $a) => self::generate($a)),

            // ---------------- redirects ----------------
            new SiteTool('list_redirects', 'List redirects (301 / 302) and gone URLs (410), with hit counts. "auto" ones were added when a slug changed.', [
                'search' => P::str('Text in the from / to path.'),
            ], fn (array $a) => Redirect::when(! empty($a['search']), fn ($q) => $q->where(fn ($w) => $w->where('from_path', 'like', "%{$a['search']}%")->orWhere('to_url', 'like', "%{$a['search']}%")))
                ->orderBy('from_path')->get()->map(fn ($r) => ['id' => $r->id, 'from' => '/' . $r->from_path, 'to' => $r->to_url, 'code' => $r->status_code,
                    'hits' => $r->hits, 'last_hit' => $r->last_hit_at?->toIso8601String(), 'auto' => $r->is_auto])->all(), readOnly: true),

            new SiteTool('save_redirect', 'Add or change a redirect: 301 (permanent), 302 (temporary) or 410 (gone, no target). Chains are shortened and loops refused.', [
                'from' => P::str('Old path, e.g. /old-page.')->req(),
                'to' => P::str('Target path or URL (not for 410).'),
                'code' => P::int('301 (default), 302 or 410.')->enum([301, 302, 410]),
                'force' => P::bool('Allow redirecting a path that is a live page (the page becomes unreachable).'),
            ], function (array $a) {
                $from = Support::path($a['from']);
                $code = (int) ($a['code'] ?? 301);
                if ($from === '') {
                    throw new ToolError('The home page cannot be redirected.');
                }
                $live = Support::resolvePath($from);
                if (in_array($live['what'] ?? '', ['page', 'post', 'page (Blade file)'], true) && empty($a['force'])) {
                    throw new ToolError("/$from is a live {$live['what']}; redirecting it hides it. Pass force=true if that is intended.");
                }
                $to = null;
                if ($code !== 410) {
                    if (empty($a['to'])) {
                        throw new ToolError('Give `to` for a 301 / 302.');
                    }
                    $stored = Support::storeUrl($a['to']);
                    $to = preg_replace('/^\{\{base\}\}/', '', $stored) ?: '/';
                    $target = Support::internalPath($stored);
                    for ($i = 0; $target !== null && $i < 10; $i++) {
                        if ($target === $from) {
                            throw new ToolError('That would create a redirect loop.');
                        }
                        $r = Support::resolvePath($target);
                        if (in_array($r['status'], [301, 302], true) && isset($r['to'])) {
                            $to = $r['to'];
                            $target = Support::internalPath($r['to']);
                        } elseif ($r['status'] >= 400) {
                            throw new ToolError("The target /$target answers {$r['status']}.");
                        } else {
                            break;
                        }
                    }
                }
                $r = Redirect::withTrashed()->updateOrCreate(['from_path' => $from], ['to_url' => $to, 'status_code' => $code, 'is_auto' => false, 'deleted_at' => null]);
                Redirect::where('to_url', '/' . $from)->where('id', '!=', $r->id)->update(['to_url' => $to ?? '/']); // repoint chains
                SiteRedirects::flush();
                Support::log('redirect.save', $r, "/$from → " . ($to ?? '410'), null, $r->toArray());

                return ['redirect' => ['from' => '/' . $from, 'to' => $to, 'code' => $code], 'cache' => Support::changed([$from])];
            }),

            new SiteTool('delete_redirect', 'Move a redirect to the trash (the old URL then answers normally again, usually 404).', [
                'from' => P::str('Old path of the redirect.')->req(),
            ], function (array $a) {
                $r = Redirect::where('from_path', Support::path($a['from']))->first() ?? throw new ToolError('No redirect from /' . Support::path($a['from']) . '.');
                $r->delete();
                SiteRedirects::flush();
                Support::log('redirect.delete', $r, "Removed redirect /{$r->from_path}", $r->toArray());

                return ['deleted' => '/' . $r->from_path, 'cache' => Support::changed([$r->from_path])];
            }, destructive: true),

            // ---------------- sitemap & robots ----------------
            new SiteTool('validate_sitemap_robots', 'Check sitemap.xml and robots.txt: every sitemap URL answers 200 and is indexable, no published page is missing, robots.txt rules, and whether site-wide noindex (SITE_NOINDEX) is on.', [], function () {
                $xml = (string) app(SitemapController::class)()->getContent();
                preg_match_all('#<loc>([^<]+)</loc>#', $xml, $m);
                $base = rtrim((string) config('site.url'), '/');
                $problems = [];
                $inSitemap = [];
                foreach ($m[1] as $loc) {
                    $loc = html_entity_decode($loc);
                    $path = trim(str_replace($base, '', $loc), '/');
                    $inSitemap[$path] = true;
                    $r = Support::resolvePath(preg_replace('/\?.*$/', '', $path));
                    if ($r['status'] !== 200) {
                        $problems[] = "$loc answers {$r['status']}";
                    }
                }
                foreach (Page::published()->with('seo')->get() as $p) {
                    $hidden = $p->seo && ($p->seo->exclude_from_sitemap || str_contains(strtolower((string) $p->seo->robots), 'noindex'));
                    if (! $hidden && ! isset($inSitemap[$p->path])) {
                        $problems[] = "Published page /{$p->path} is missing from the sitemap";
                    }
                    if ($hidden && isset($inSitemap[$p->path])) {
                        $problems[] = "/{$p->path} is noindex / excluded but still in the sitemap";
                    }
                }
                $robots = \App\Site\Robots::text();
                $noindex = (bool) config('site.noindex');

                return [
                    'site_noindex' => $noindex,
                    'site_noindex_note' => $noindex ? 'SITE_NOINDEX is on: every page is noindex, nofollow and robots.txt does not list the sitemap. The owner switches it off in .env at launch.' : 'Site is indexable.',
                    'sitemap_urls' => count($m[1]),
                    'robots_txt' => $robots,
                    'robots_lists_sitemap' => str_contains($robots, 'Sitemap:'),
                    'problems' => $problems,
                ];
            }, readOnly: true),

            new SiteTool('update_robots', 'Set the extra robots.txt lines added after the built-in rules (User-agent: * / Disallow: /enquiry). Only User-agent, Allow, Disallow, Crawl-delay, Sitemap and # comment lines. Empty text removes them.', [
                'lines' => P::str('robots.txt lines, one per line.', 'max:5000')->reqAllowEmpty(),
            ], function (array $a) {
                $lines = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $a['lines'])), fn ($l) => $l !== ''));
                foreach ($lines as $l) {
                    if (! preg_match('/^(#.*|(User-agent|Allow|Disallow|Crawl-delay|Sitemap)\s*:\s*\S.*)$/i', $l)) {
                        throw new ToolError("Not a robots.txt rule: \"$l\"");
                    }
                }
                $warn = preg_grep('/^Disallow:\s*\/\s*$/i', $lines) ? ['"Disallow: /" blocks the whole site for that user-agent.'] : [];
                $before = config('site.robots_extra');
                $s = Settings::set('robots_extra', implode("\n", $lines));
                Support::log('robots.update', $s, 'Updated robots.txt extra lines', $before, $s->value);

                return ['robots_extra' => $s->value, 'warnings' => $warn, 'cache' => Support::changed(['robots.txt'])];
            }),
        ];
    }

    /** @return array{0: Model, 1: string} */
    private static function seoTarget(string $type, string $ref): array
    {
        return match ($type) {
            'post' => [Support::post($ref), 'post'],
            'category' => [Category::where('slug', $ref)->first() ?? throw new ToolError("No category \"$ref\"."), 'category'],
            default => [Support::page($ref), 'page'],
        };
    }

    private static function stored(Model $m): array
    {
        $seo = $m->seo;
        $out = [];
        foreach (self::FIELDS as $f) {
            $out[$f] = $seo?->$f;
        }
        if ($m instanceof Post) {
            $out['title'] = $m->meta_title;
            $out['description'] = $m->meta_description;
        }
        $out['exclude_from_sitemap'] = (bool) ($seo?->exclude_from_sitemap);

        return $out;
    }

    private static function updateSeo(string $type, string $ref, array $a): array
    {
        [$model, $kind] = self::seoTarget($type, $ref);
        $before = self::stored($model);
        $seo = $model->seo ?? $model->seo()->make();
        foreach (self::FIELDS as $f) {
            if (! array_key_exists($f, $a)) {
                continue;
            }
            $v = $a[$f];
            if ($f === 'exclude_from_sitemap') {
                $seo->$f = (bool) $v;
                continue;
            }
            $v = is_string($v) ? trim($v) : $v;
            $v = $v === '' ? null : $v;
            if ($v !== null && in_array($f, ['canonical'], true) && ! preg_match('#^https?://#i', $v)) {
                throw new ToolError('canonical must be a full https:// URL.');
            }
            if ($v !== null && in_array($f, ['og_image', 'twitter_image'], true)) {
                if (! preg_match('#^https?://#i', $v)) {
                    $v = '/' . ltrim($v, '/');
                    if (str_contains($v, '..') || ! is_file(public_path(ltrim($v, '/')))) {
                        throw new ToolError("No image at $v.");
                    }
                }
            } elseif ($v !== null) {
                $v = Support::text($v, $f);
            }
            if ($model instanceof Post && in_array($f, ['title', 'description'], true)) {
                $model->{$f === 'title' ? 'meta_title' : 'meta_description'} = $v;
                continue;
            }
            $seo->$f = $v;
        }
        if ($model instanceof Post) {
            $model->save();
        }
        $seo->seoable()->associate($model);
        $seo->save();
        $model->touch();
        $after = self::stored($model->fresh());
        Support::log('seo.update', $model, "SEO of $kind $ref", $before, $after);

        $warn = [];
        $title = $after['title'];
        $desc = $after['description'];
        if ($title !== null && (mb_strlen($title) < 30 || mb_strlen($title) > 65)) {
            $warn[] = 'Title is ' . mb_strlen($title) . ' characters (aim for 50–60).';
        }
        if ($desc !== null && (mb_strlen($desc) < 120 || mb_strlen($desc) > 165)) {
            $warn[] = 'Description is ' . mb_strlen($desc) . ' characters (aim for 140–160).';
        }
        if (config('site.noindex') && isset($a['robots']) && str_starts_with((string) $a['robots'], 'index')) {
            $warn[] = 'Saved, but SITE_NOINDEX is on: the page stays noindex until launch.';
        }
        $path = $model instanceof Page ? $model->path : ($model instanceof Post ? $model->slug : 'blogs');

        return ['ref' => $ref, 'type' => $kind, 'before' => array_intersect_key($before, $a) ?: $before, 'after' => array_intersect_key($after, $a) ?: $after,
            'warnings' => $warn, 'cache' => Support::changed([$path])];
    }

    private static function auditMeta(): array
    {
        $all = SiteAnalyzer::all();
        $titles = [];
        $descs = [];
        foreach ($all as $path => $an) {
            $titles[mb_strtolower(trim((string) $an['title']))][] = '/' . $path;
            $descs[mb_strtolower(trim((string) $an['description']))][] = '/' . $path;
        }
        $xml = (string) app(SitemapController::class)()->getContent();
        $defaultDesc = mb_strtolower((string) config('site.default_description'));
        $rows = [];
        foreach ($all as $path => $an) {
            $issues = [];
            $t = trim((string) $an['title']);
            $d = trim((string) $an['description']);
            if ($t === '') {
                $issues[] = 'Missing title';
            } else {
                $len = mb_strlen($t);
                if ($len > 60 || $len < 50) {
                    $issues[] = "Title is $len characters (aim 50–60)";
                }
                if (count($titles[mb_strtolower($t)]) > 1) {
                    $issues[] = 'Duplicate title, also on ' . implode(', ', array_diff($titles[mb_strtolower($t)], ['/' . $path]));
                }
            }
            if ($d === '') {
                $issues[] = 'Missing description';
            } else {
                $len = mb_strlen($d);
                if ($len > 160 || $len < 140) {
                    $issues[] = "Description is $len characters (aim 140–160)";
                }
                if (mb_strtolower($d) === $defaultDesc) {
                    $issues[] = 'Uses the site-wide default description (no page-specific one)';
                } elseif (count($descs[mb_strtolower($d)]) > 1) {
                    $issues[] = 'Duplicate description, also on ' . implode(', ', array_slice(array_diff($descs[mb_strtolower($d)], ['/' . $path]), 0, 5));
                }
            }
            if (! $an['canonical']) {
                $issues[] = 'Missing canonical';
            }
            if (! $an['og_image'] || str_ends_with($an['og_image'], '/images/logo.png')) {
                $issues[] = 'No page-specific OG image (uses the logo)';
            }
            $model = Support::target($path)['model'];
            if ($model->seo && str_contains(strtolower((string) $model->seo->robots), 'noindex') && str_contains($xml, '/' . $path . '</loc>')) {
                $issues[] = 'Set to noindex but still in the sitemap';
            }
            $rows[] = ['path' => '/' . $path, 'type' => $an['type'], 'title' => $t, 'description_length' => mb_strlen($d), 'issues' => $issues];
        }

        return ['pages_checked' => count($rows), 'with_issues' => count(array_filter($rows, fn ($r) => $r['issues'])),
            'pages' => array_values(array_filter($rows, fn ($r) => $r['issues']))];
    }

    /** @return array{0:string,1:string} [json text, @type] */
    private static function validJsonLd(string $json): array
    {
        $data = json_decode(Tokens::resolveRaw($json), true);
        if (! is_array($data) || array_is_list($data)) {
            throw new ToolError('json must be one JSON object.');
        }
        if (! str_contains((string) ($data['@context'] ?? ''), 'schema.org') || empty($data['@type'])) {
            throw new ToolError('The object needs "@context": "https://schema.org" and an "@type".');
        }
        $flat = json_encode($data);
        if (preg_match('/"@type":"(AggregateRating|Review)"/', $flat) && in_array($data['@type'], ['Organization', 'LocalBusiness', 'SoftwareApplication', 'Product'], true)) {
            throw new ToolError('Review / AggregateRating markup about our own business or product is self-serving and not eligible for rich results; leave it out.');
        }
        if (stripos($json, '</script') !== false) {
            throw new ToolError('json cannot contain </script>.');
        }
        if ($bad = array_values(array_filter(Tokens::invalid($json), fn ($t) => ! in_array($t, ['{{base}}', '{{site_url}}'], true)))) {
            throw new ToolError('Unknown placeholders: ' . implode(' ', $bad));
        }

        return [$json, is_array($data['@type']) ? implode(',', $data['@type']) : $data['@type']];
    }

    private static function generate(array $a): array
    {
        $page = Support::page($a['page']);
        $an = SiteAnalyzer::page($page);
        $type = $a['type'];
        if (in_array($type, $an['schema_types'], true)) {
            throw new ToolError("/{$page->path} already outputs $type" . (in_array($type, ['BreadcrumbList', 'FAQPage', 'LocalBusiness', 'Organization'], true) ? ' (generated automatically by the page)' : '') . '.');
        }
        $site = '{{site_url}}';
        $url = $site . '/' . $page->path;
        $org = ['@type' => 'Organization', 'name' => 'myPOS.pk', 'url' => $site, 'logo' => $site . '/images/logo.png',
            'telephone' => config('site.phone_raw'), 'email' => config('site.email')];
        $offers = function () use ($a) {
            return PricingPlan::where('plan_group', $a['plan_group'] ?? 'one-time')->where('is_visible', true)->whereNotNull('price_pkr')->orderBy('sort_order')->get()
                ->map(fn ($p) => array_filter(['@type' => 'Offer', 'name' => $p->name, 'price' => number_format((float) $p->price_pkr, 0, '.', ''), 'priceCurrency' => 'PKR',
                    'description' => $p->billing_period === 'month' ? 'Per month' : ($p->billing_period === 'year' ? 'Per year' : null)]))->values()->all();
        };
        $name = $page->seo?->title ?: $page->name;
        $desc = $page->seo?->description;

        $data = match ($type) {
            'Organization' => ['@context' => 'https://schema.org'] + $org,
            'LocalBusiness' => ['@context' => 'https://schema.org', '@type' => 'LocalBusiness', 'name' => 'myPOS.pk', 'url' => $site, 'image' => $site . '/images/logo.png',
                'telephone' => config('site.phone_raw'), 'email' => config('site.email'), 'address' => ['@type' => 'PostalAddress', 'streetAddress' => config('site.address'), 'addressCountry' => 'PK'],
                'areaServed' => 'PK'],
            'SoftwareApplication' => array_filter(['@context' => 'https://schema.org', '@type' => 'SoftwareApplication', 'name' => $page->name, 'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Windows, Web, Android', 'description' => $desc, 'url' => $url, 'offers' => $offers() ?: null, 'provider' => $org]),
            'Product' => array_filter(['@context' => 'https://schema.org', '@type' => 'Product', 'name' => $page->name, 'description' => $desc, 'url' => $url,
                'brand' => ['@type' => 'Brand', 'name' => 'myPOS'], 'offers' => $offers() ?: null]),
            'FAQPage' => (function () use ($page) {
                $items = Faq::whereIn('faq_group', Faq::where('faq_group', 'like', ($page->path ?: 'home') . ':%')->pluck('faq_group'))->where('is_visible', true)->orderBy('faq_group')->orderBy('sort_order')->get();
                if ($items->isEmpty()) {
                    throw new ToolError('This page has no FAQs in the faqs table.');
                }

                return ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $items->map(fn ($f) => ['@type' => 'Question', 'name' => strip_tags($f->question),
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f->answer, '<a><strong><br>')]])->all()];
            })(),
            'BreadcrumbList' => ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => array_values(array_filter([
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site . '/'],
                $page->path !== '' ? ['@type' => 'ListItem', 'position' => 2, 'name' => $page->name] : null,
            ]))],
            'Article' => array_filter(['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => mb_substr($name, 0, 110), 'description' => $desc, 'url' => $url,
                'dateModified' => $page->updated_at?->toIso8601String(), 'author' => $org, 'publisher' => $org]),
        };

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $saved = null;
        if (! empty($a['save'])) {
            [$json, $t] = self::validJsonLd($json);
            $saved = $page->schemaBlocks()->create(['schema_type' => $t, 'json' => $json, 'sort_order' => (int) $page->schemaBlocks()->max('sort_order') + 1]);
            Support::log('schema.create', $saved, "Generated $type schema for /{$page->path}", null, ['json' => $json]);
            Support::changed([$page->path]);
        }

        return ['type' => $type, 'json' => json_decode(Tokens::resolveRaw($json), true), 'saved_block_id' => $saved?->id,
            'note' => $saved ? 'Saved and live on the page.' : 'Not saved. Call again with save=true to add it to the page.'];
    }
}
