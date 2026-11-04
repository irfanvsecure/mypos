<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Redirect;
use App\Models\Setting;
use App\Site\HtmlEdit;
use App\Site\Settings;
use App\Site\SiteAnalyzer;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

/** Internal links: inventory, orphans, add / edit / remove, sitewide replace, anchor report, broken links. */
class LinkTools
{
    private const GENERIC = ['click here', 'here', 'read more', 'learn more', 'more', 'this', 'link', 'this link', 'go', 'see more', 'details', 'more info'];

    public static function tools(): array
    {
        $page = P::str('Page path ("" or "home" for the home page).')->reqAllowEmpty();
        $section = P::str('Section key (from get_page_sections).')->req();

        return [
            new SiteTool('get_internal_links', 'Internal links of a page or post: outbound (URL, anchor text, section, nofollow) and inbound (which pages link to it, with anchors). Header/footer links are marked as such. Without `page`, a per-page summary for the whole site.', [
                'page' => P::str('Page path or post slug; empty = whole-site summary.'),
                'include_header_footer' => P::bool('Include links in the site header, footer and floating buttons (default false).'),
            ], function (array $a) {
                $all = SiteAnalyzer::all();
                $chrome = $a['include_header_footer'] ?? false;
                $internal = fn ($l) => $l['path'] !== null && ($chrome || ! in_array($l['section'], SiteAnalyzer::CHROME, true));
                if (! isset($a['page'])) {
                    $inbound = self::inbound($all, false);

                    return collect($all)->map(fn ($an, $path) => [
                        'path' => '/' . $path, 'type' => $an['type'],
                        'outbound' => count(array_filter($an['links'], $internal)),
                        'inbound_from_pages' => count(array_unique(array_column($inbound[$path] ?? [], 'from'))),
                    ])->values()->all();
                }
                $an = Support::analyze($a['page']);
                $inbound = self::inbound($all, $chrome)[$an['path']] ?? [];

                return [
                    'path' => '/' . $an['path'],
                    'outbound' => array_values(array_map(fn ($l) => ['url' => '/' . $l['path'], 'href' => $l['href'], 'anchor' => $l['anchor'], 'section' => $l['section'], 'nofollow' => $l['nofollow']],
                        array_filter($an['links'], $internal))),
                    'inbound' => $inbound,
                    'external' => array_values(array_map(fn ($l) => ['url' => $l['href'], 'anchor' => $l['anchor'], 'section' => $l['section'], 'nofollow' => $l['nofollow']],
                        array_filter($an['links'], fn ($l) => $l['path'] === null && preg_match('#^https?://#', $l['href']) && ($chrome || ! in_array($l['section'], SiteAnalyzer::CHROME, true))))),
                ];
            }, readOnly: true),

            new SiteTool('find_orphan_pages', 'Published pages and posts that no other page links to from its content. Links from the site header/footer are counted separately.', [], function () {
                $all = SiteAnalyzer::all();
                $content = self::inbound($all, false);
                $withChrome = self::inbound($all, true);
                $out = [];
                foreach ($all as $path => $an) {
                    $fromContent = array_filter($content[$path] ?? [], fn ($l) => $l['from'] !== '/' . $path);
                    if (! $fromContent && $path !== '') {
                        $out[] = ['path' => '/' . $path, 'type' => $an['type'],
                            'linked_from_header_footer' => count(array_filter($withChrome[$path] ?? [], fn ($l) => in_array($l['section'], SiteAnalyzer::CHROME, true))) > 0];
                    }
                }

                return ['orphans' => $out, 'count' => count($out)];
            }, readOnly: true),

            new SiteTool('add_internal_link', 'Turn the FIRST occurrence of exact anchor_text in a section into a link. Fails if the text is not found or is already a link, or if the page already links to that URL from its content.', [
                'page' => $page, 'section' => $section,
                'anchor_text' => P::str('Exact visible text to link.', 'min:2')->req(),
                'url' => P::str('Target: a path like /pricing (internal) or a full https:// URL.')->req(),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                $href = Support::storeUrl($a['url']);
                $target = Support::internalPath($href);

                $an = SiteAnalyzer::page($p);
                foreach ($an['links'] as $l) {
                    if (in_array($l['section'], SiteAnalyzer::CHROME, true)) {
                        continue;
                    }
                    $same = $target !== null ? $l['path'] === $target : rtrim($l['href'], '/') === rtrim($a['url'], '/');
                    if ($same) {
                        throw new ToolError("/{$p->path} already links to {$a['url']} (section {$l['section']}, anchor \"{$l['anchor']}\"). A page links to the same URL only once.");
                    }
                }
                if ($target !== null && ($r = Support::resolvePath($target))['status'] >= 400) {
                    throw new ToolError("{$a['url']} answers {$r['status']}; link to a live page.");
                }

                $c = $s->content;
                $done = false;
                if (isset($c['html'])) {
                    [$c['html'], $done] = HtmlEdit::addLink($c['html'], $a['anchor_text'], $href);
                }
                if (! $done && isset($c['slot']['html'])) {
                    [$c['slot']['html'], $done] = HtmlEdit::addLink($c['slot']['html'], $a['anchor_text'], $href);
                }
                if (! $done) {
                    throw new ToolError("\"{$a['anchor_text']}\" is not in the text of section {$s->key}" . ($s->type === 'component' ? ' (component text in attributes cannot take links; edit the section instead)' : '') . '.');
                }

                return PageTools::saveSection($p, $s, $c, "add_internal_link → {$a['url']}");
            }),

            new SiteTool('update_internal_link', 'Change the target and/or the anchor text of the links to `url` in a section.', [
                'page' => $page, 'section' => $section,
                'url' => P::str('Current link target (path or full URL).')->req(),
                'new_url' => P::str('New target.'),
                'new_anchor' => P::str('New anchor text (plain).'),
            ], function (array $a) {
                if (! isset($a['new_url']) && ! isset($a['new_anchor'])) {
                    throw new ToolError('Give new_url and/or new_anchor.');
                }

                return self::editSectionLinks($a, isset($a['new_url']) ? Support::storeUrl($a['new_url']) : null, $a['new_anchor'] ?? null, false);
            }),

            new SiteTool('remove_internal_link', 'Unlink the links to `url` in a section, keeping their text.', [
                'page' => $page, 'section' => $section,
                'url' => P::str('Link target to remove (path or full URL).')->req(),
            ], fn (array $a) => self::editSectionLinks($a, null, null, true), destructive: true),

            new SiteTool('replace_link_sitewide', 'Point every link to old_url at new_url across pages, components, blog posts, header/footer menus, pricing buttons and redirect targets. dry_run (default true) lists what would change; dry_run=false applies it.', [
                'old_url' => P::str('Current target (path or full URL).')->req(),
                'new_url' => P::str('New target (path or full URL).')->req(),
                'dry_run' => P::bool('Default true: preview only.'),
            ], fn (array $a) => self::replaceSitewide($a)),

            new SiteTool('anchor_text_report', 'Every anchor text pointing to a URL, with counts and where it appears; flags generic anchors ("click here", "read more") and heavy exact-match repetition.', [
                'url' => P::str('Target path or URL, e.g. /fbr-pos-integration.')->req(),
            ], function (array $a) {
                $target = Support::internalPath(Support::storeUrl($a['url']));
                $rows = [];
                foreach (SiteAnalyzer::all() as $path => $an) {
                    foreach ($an['links'] as $l) {
                        if ($target !== null ? $l['path'] === $target : rtrim($l['href'], '/') === rtrim($a['url'], '/')) {
                            $rows[] = ['from' => '/' . $path, 'section' => $l['section'], 'anchor' => $l['anchor']];
                        }
                    }
                }
                $counts = array_count_values(array_map(fn ($r) => mb_strtolower($r['anchor']), array_filter($rows, fn ($r) => ! in_array($r['section'], SiteAnalyzer::CHROME, true))));
                arsort($counts);
                $total = array_sum($counts);
                $flags = [];
                foreach ($counts as $anchor => $n) {
                    if (in_array($anchor, self::GENERIC, true) || $anchor === '') {
                        $flags[] = "Generic or empty anchor \"$anchor\" used $n time(s)";
                    } elseif ($total >= 5 && $n / $total > 0.5) {
                        $flags[] = "\"$anchor\" is " . round(100 * $n / $total) . '% of content anchors to this URL: vary the wording';
                    }
                }

                return ['url' => $target !== null ? '/' . $target : $a['url'], 'content_anchors' => $counts, 'flags' => $flags,
                    'header_footer_links' => count(array_filter($rows, fn ($r) => in_array($r['section'], SiteAnalyzer::CHROME, true))), 'links' => $rows];
            }, readOnly: true),

            new SiteTool('check_broken_links', 'Find broken links, with the page and section where each appears. Internal links are checked against the site (404, 410, redirects); external links with a live HTTP request.', [
                'page' => P::str('Only this page / post; empty = whole site.'),
                'scope' => P::str('internal (default), external or all.')->enum(['internal', 'external', 'all']),
                'max_external' => P::int('Max external URLs to request (default 150).', ['min:1', 'max:500']),
            ], fn (array $a) => self::brokenLinks($a), readOnly: true),
        ];
    }

    /** path => [['from' => '/x', 'section' => …, 'anchor' => …], …] */
    private static function inbound(array $all, bool $withChrome): array
    {
        $in = [];
        foreach ($all as $from => $an) {
            foreach ($an['links'] as $l) {
                if ($l['path'] === null || (! $withChrome && in_array($l['section'], SiteAnalyzer::CHROME, true))) {
                    continue;
                }
                $in[$l['path']][] = ['from' => '/' . $from, 'section' => $l['section'], 'anchor' => $l['anchor']];
            }
        }

        return $in;
    }

    private static function matcher(string $url): callable
    {
        $target = Support::internalPath(Support::storeUrl($url));

        return $target !== null
            ? fn (string $href) => Support::internalPath($href) === $target
            : fn (string $href) => rtrim(html_entity_decode($href), '/') === rtrim($url, '/');
    }

    private static function editSectionLinks(array $a, ?string $newHref, ?string $newAnchor, bool $unlink): array
    {
        $p = Support::page($a['page']);
        $s = Support::section($p, $a['section']);
        $match = self::matcher($a['url']);
        $c = $s->content;
        $n = 0;
        foreach (['html', 'slot'] as $part) {
            $ref = &$c;
            if ($part === 'slot') {
                if (! isset($c['slot']['html'])) {
                    continue;
                }
                $ref = &$c['slot'];
            } elseif (! isset($c['html'])) {
                continue;
            }
            $links = HtmlEdit::links($ref['html'], $match);
            $n += count($links);
            $ref['html'] = HtmlEdit::editLinks($ref['html'], $links, $newHref, $newAnchor, $unlink);
            unset($ref);
        }
        if (! $n) {
            throw new ToolError("Section {$s->key} has no link to {$a['url']}.");
        }

        return PageTools::saveSection($p, $s, $c, ($unlink ? 'remove_internal_link ' : 'update_internal_link ') . $a['url']) + ['links_changed' => $n];
    }

    private static function replaceSitewide(array $a): array
    {
        $dry = $a['dry_run'] ?? true;
        $match = self::matcher($a['old_url']);
        $newStored = Support::storeUrl($a['new_url']);
        $newPath = Support::internalPath($newStored);
        if ($newPath !== null && ($r = Support::resolvePath($newPath))['status'] >= 400) {
            throw new ToolError("{$a['new_url']} answers {$r['status']}.");
        }
        $plainNew = $newPath !== null ? '/' . $newPath : $a['new_url'];
        // Keep a #fragment / ?query the old link had.
        $withTail = fn (string $old, string $new) => preg_match('/([?#].*)$/', html_entity_decode($old), $m) && ! preg_match('/[?#]/', $new) ? $new . $m[1] : $new;

        $changes = [];
        $paths = [];

        foreach (PageSection::with('page')->get() as $s) {
            if (! $s->page) {
                continue;
            }
            $n = 0;
            $walk = function ($v, $k = null) use (&$walk, &$n, $match, $newStored, $withTail) {
                if (is_array($v)) {
                    $out = [];
                    foreach ($v as $kk => $vv) {
                        $out[$kk] = in_array($kk, ['before', 'component'], true) ? $vv : $walk($vv, $kk);
                    }

                    return $out;
                }
                if (! is_string($v)) {
                    return $v;
                }
                if (str_contains($v, '<a')) {
                    $links = HtmlEdit::links($v, $match);
                    foreach (array_reverse($links) as $l) {
                        $v = HtmlEdit::editLinks($v, [$l], $withTail($l['href'], $newStored), null, false);
                    }
                    $n += count($links);

                    return $v;
                }
                // A component attribute that is just a URL (e.g. primaryUrl="/contact#enquiry").
                if (preg_match('#^(\{\{base\}\}|/|https?://)\S*$#', $v) && $match($v)) {
                    $n++;

                    return $withTail($v, str_starts_with($v, '{{base}}') || str_starts_with($v, 'http') ? $newStored : preg_replace('/^\{\{base\}\}/', '', $newStored));
                }

                return $v;
            };
            $new = $walk($s->content);
            if ($n) {
                $changes[] = ['where' => "page /{$s->page->path} › {$s->key}", 'links' => $n];
                if (! $dry) {
                    PageTools::saveSection($s->page, $s, $new, "replace_link_sitewide {$a['old_url']} → {$a['new_url']}");
                    $paths[] = $s->page->path;
                }
            }
        }

        foreach (Post::all() as $post) {
            $links = HtmlEdit::links((string) $post->content, $match);
            if ($links) {
                $changes[] = ['where' => "blog /{$post->slug}", 'links' => count($links)];
                if (! $dry) {
                    $content = $post->content;
                    foreach (array_reverse($links) as $l) {
                        $content = HtmlEdit::editLinks($content, [$l], $withTail($l['href'], $plainNew), null, false);
                    }
                    $post->update(['content' => $content]);
                    Support::log('post.update', $post, "replace_link_sitewide {$a['old_url']} → {$a['new_url']}");
                    $paths[] = $post->slug;
                }
            }
        }

        // Menus, footer and legal links (settings), pricing buttons, redirect targets.
        foreach (['menu', 'footer', 'legal'] as $key) {
            $value = config("site.$key");
            $n = 0;
            array_walk_recursive($value, function (&$v) use (&$n, $match, $plainNew, $withTail) {
                if (is_string($v) && (str_starts_with($v, '/') || str_starts_with($v, 'http')) && $match($v)) {
                    $v = $withTail($v, $plainNew);
                    $n++;
                }
            });
            if ($n) {
                $changes[] = ['where' => "setting $key (header/footer)", 'links' => $n];
                if (! $dry) {
                    $setting = Setting::firstOrNew(['key' => $key]);
                    $before = $setting->value;
                    $setting->value = $value;
                    $setting->save();
                    Settings::flush();
                    Support::log('setting.update', $setting, "replace_link_sitewide in $key", $before, $value);
                }
            }
        }
        foreach (PricingPlan::whereNotNull('cta_url')->get() as $pl) {
            if ($match($pl->cta_url)) {
                $changes[] = ['where' => "pricing plan #{$pl->id} {$pl->name} button", 'links' => 1];
                if (! $dry) {
                    $pl->update(['cta_url' => $withTail($pl->cta_url, $plainNew)]);
                    Support::log('pricing.update', $pl, 'replace_link_sitewide');
                }
            }
        }
        foreach (Redirect::whereNotNull('to_url')->get() as $r) {
            if ($match($r->to_url)) {
                $changes[] = ['where' => "redirect /{$r->from_path}", 'links' => 1];
                if (! $dry) {
                    $r->update(['to_url' => $withTail($r->to_url, $plainNew)]);
                    Support::log('redirect.update', $r, 'replace_link_sitewide');
                }
            }
        }

        return ['dry_run' => $dry, 'total_links' => array_sum(array_column($changes, 'links')), 'changes' => $changes,
            'note' => $dry ? 'Nothing changed. Run again with dry_run=false to apply.' : 'Applied (sections keep revisions).',
            'cache' => $dry ? null : Support::changed(array_values(array_unique($paths)))];
    }

    private static function brokenLinks(array $a): array
    {
        $scope = $a['scope'] ?? 'internal';
        $items = isset($a['page']) ? [Support::analyze($a['page'])] : array_values(SiteAnalyzer::all());
        $broken = [];
        $redirected = [];
        $external = [];

        foreach ($items as $an) {
            foreach ($an['links'] as $l) {
                $where = ['page' => '/' . $an['path'], 'section' => $l['section'], 'anchor' => $l['anchor']];
                if ($l['path'] !== null && $scope !== 'external') {
                    $r = Support::resolvePath($l['path']);
                    if ($r['status'] >= 400) {
                        $broken[] = $where + ['url' => '/' . $l['path'], 'status' => $r['status']];
                    } elseif (in_array($r['status'], [301, 302], true)) {
                        $redirected['/' . $l['path']] = ['url' => '/' . $l['path'], 'redirects_to' => $r['to'] ?? null, 'example' => $where];
                    }
                } elseif ($l['path'] === null && preg_match('#^https?://#i', $l['href']) && $scope !== 'internal') {
                    $external[html_entity_decode($l['href'])][] = $where;
                }
            }
        }

        $checked = 0;
        if ($external) {
            $urls = array_slice(array_keys($external), 0, $a['max_external'] ?? 150);
            foreach (array_chunk($urls, 10) as $chunk) {
                $responses = Http::pool(fn (Pool $pool) => array_map(fn ($u) => $pool->as($u)->withHeaders(['User-Agent' => 'mypos.pk link checker'])
                    ->timeout(8)->withOptions(['allow_redirects' => ['max' => 5]])->get($u), $chunk));
                foreach ($chunk as $u) {
                    $checked++;
                    $res = $responses[$u] ?? null;
                    $status = $res instanceof \Illuminate\Http\Client\Response ? $res->status() : 0;
                    // 401/403/405/429 usually mean "reachable but refusing bots" (LinkedIn, Facebook…): not broken.
                    if ($status === 0 || $status === 404 || $status === 410 || $status >= 500) {
                        foreach ($external[$u] as $where) {
                            $broken[] = $where + ['url' => $u, 'status' => $status ?: 'no response'];
                        }
                    }
                }
            }
        }

        return [
            'pages_checked' => count($items),
            'broken' => $broken,
            'internal_links_through_redirects' => array_values($redirected),
            'external_urls_checked' => $checked,
            'external_urls_not_checked' => max(0, count($external) - $checked),
        ];
    }
}
