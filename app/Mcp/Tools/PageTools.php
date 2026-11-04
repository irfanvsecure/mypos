<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\Faq;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Redirect;
use App\Models\SectionRevision;
use App\Site\HtmlEdit;
use App\Site\SectionRenderer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/** Pages, their sections, revisions, search and find-and-replace. */
class PageTools
{
    public static function tools(): array
    {
        $page = P::str('Page URL path, e.g. "car-wash-pos" or "download/restropro"; "" or "home" for the home page.')->req();
        $section = P::str('Section key (from get_page_sections).')->req();
        $stamp = P::str('updated_at you read; the change is refused if the section changed since (optional but recommended).');

        return [
            new SiteTool('list_pages', 'List all pages of the website with their URL path, status, SEO title and section count.', [
                'status' => P::str('Only pages with this status.')->enum(['published', 'draft']),
                'search' => P::str('Filter by path or name containing this text.'),
            ], function (array $a) {
                $q = Page::withCount('sections')->with('seo')->orderBy('path');
                if (! empty($a['status'])) {
                    $q->where('status', $a['status']);
                }
                if (! empty($a['search'])) {
                    $q->where(fn ($w) => $w->where('path', 'like', "%{$a['search']}%")->orWhere('name', 'like', "%{$a['search']}%"));
                }

                return $q->get()->map(fn (Page $p) => [
                    'path' => $p->path, 'url' => $p->url(), 'name' => $p->name, 'status' => $p->status,
                    'seo_title' => $p->seo?->title, 'sections' => $p->sections_count, 'updated_at' => Support::stamp($p),
                ])->all();
            }, readOnly: true),

            new SiteTool('get_page', 'Get one page: details, SEO fields, structured data blocks and a summary of its sections.', [
                'page' => $page,
            ], function (array $a) {
                $p = Support::page($a['page']);

                return [
                    'path' => $p->path, 'url' => $p->url(), 'name' => $p->name, 'status' => $p->status, 'page_key' => $p->page_key,
                    'updated_at' => Support::stamp($p),
                    'seo' => $p->seo?->only(['title', 'description', 'focus_keyword', 'canonical', 'robots', 'og_title', 'og_description', 'og_image', 'twitter_card', 'exclude_from_sitemap']),
                    'schema' => $p->schemaBlocks->map(fn ($b) => ['id' => $b->id, 'type' => $b->schema_type, 'active' => $b->is_active])->all(),
                    'sections' => $p->sections->map(fn ($s) => self::summary($s))->all(),
                ];
            }, readOnly: true),

            new SiteTool('create_page', 'Create a page (saved as a draft unless status=published). Optionally copy all sections of an existing page as a starting point. New pages need exactly one <h1>.', [
                'path' => P::str('URL path for the new page, e.g. "pharmacy-pos".')->req(),
                'name' => P::str('Internal name (e.g. "Pharmacy POS").')->req(),
                'title' => P::str('SEO title.'),
                'description' => P::str('Meta description.'),
                'status' => P::str('draft (default) or published.')->enum(['draft', 'published']),
                'copy_sections_from' => P::str('Path of a page whose sections are copied.'),
            ], function (array $a) {
                $path = Support::path($a['path']);
                Support::assertFreePath($path);
                $page = DB::transaction(function () use ($a, $path) {
                    $page = Page::create(['path' => $path, 'name' => Support::text($a['name'], 'name'), 'page_key' => Str::slug(basename($path)),
                        'status' => $a['status'] ?? 'draft']);
                    $page->seo()->create(['title' => Support::text($a['title'] ?? null, 'title'), 'description' => Support::text($a['description'] ?? null, 'description')]);
                    if (! empty($a['copy_sections_from'])) {
                        $from = Support::page($a['copy_sections_from']);
                        foreach ($from->sections as $s) {
                            $page->sections()->create($s->only(['key', 'type', 'component', 'sort_order', 'content', 'is_visible']));
                        }
                    }

                    return $page;
                });
                Support::log('page.create', $page, "Created /$path", null, ['path' => $path, 'status' => $page->status]);

                return ['created' => $path, 'status' => $page->status, 'url' => $page->url(), 'sections' => $page->sections()->count(),
                    'cache' => Support::changed([$path])];
            }),

            new SiteTool('update_page', 'Change a page\'s URL path, name or status (published / draft). Changing the path of a published page adds a 301 redirect from the old URL.', [
                'page' => $page,
                'path' => P::str('New URL path.'),
                'name' => P::str('New internal name.'),
                'status' => P::str('published or draft.')->enum(['published', 'draft']),
                'expected_updated_at' => $stamp,
            ], function (array $a) {
                $p = Support::page($a['page']);
                Support::assertStamp($p, $a['expected_updated_at'] ?? null);
                $before = $p->only(['path', 'name', 'status']);
                $redirect = null;
                if (isset($a['path']) && Support::path($a['path']) !== $p->path) {
                    if ($p->path === '') {
                        throw new ToolError('The home page path cannot change.');
                    }
                    $new = Support::path($a['path']);
                    Support::assertFreePath($new, $p);
                    if ($p->status === 'published') {
                        Redirect::withTrashed()->updateOrCreate(['from_path' => $p->path], ['to_url' => '/' . $new, 'status_code' => 301, 'is_auto' => true, 'deleted_at' => null]);
                        Redirect::where('to_url', '/' . $p->path)->update(['to_url' => '/' . $new]); // no redirect chains
                        $redirect = "/{$p->path} → /$new (301)";
                    }
                    $p->path = $new;
                }
                if (isset($a['name'])) {
                    $p->name = Support::text($a['name'], 'name');
                }
                if (isset($a['status'])) {
                    $p->status = $a['status'];
                }
                $p->save();
                Support::log('page.update', $p, "Updated /{$p->path}", $before, $p->only(['path', 'name', 'status']));

                return ['page' => $p->only(['path', 'name', 'status']), 'redirect_added' => $redirect, 'updated_at' => Support::stamp($p),
                    'cache' => Support::changed(array_unique([$before['path'], $p->path]))];
            }),

            new SiteTool('delete_page', 'Move a page to the trash (restore with restore_item). The URL then answers 404. The home page cannot be deleted.', [
                'page' => $page,
            ], function (array $a) {
                $p = Support::page($a['page']);
                if ($p->path === '') {
                    throw new ToolError('The home page cannot be deleted.');
                }
                $p->delete();
                Support::log('page.delete', $p, "Moved /{$p->path} to the trash");

                return ['deleted' => $p->path, 'restore_with' => ['tool' => 'restore_item', 'type' => 'page', 'id' => $p->id], 'cache' => Support::changed([$p->path])];
            }, destructive: true),

            new SiteTool('get_page_sections', 'Get a page\'s sections in order with their full content (HTML or component attributes) and updated_at stamps.', [
                'page' => $page,
                'section' => P::str('Only this section key.'),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $sections = $p->sections()->when(! empty($a['section']), fn ($q) => $q->where('key', $a['section']))->get();

                return $sections->map(fn ($s) => self::summary($s) + ['content' => self::publicContent($s->content)])->all();
            }, readOnly: true),

            new SiteTool('list_components', 'List the components a "component" section (or an embed) can use, with the attributes each accepts.', [], function () {
                $out = [];
                foreach (File::allFiles(resource_path('views/components')) as $f) {
                    $name = str_replace(['\\', '/', '.blade.php'], ['.', '.', ''], $f->getRelativePathname());
                    preg_match('/@props\(\[(.*?)\]\)/s', File::get($f), $m);
                    preg_match_all("/'([a-zA-Z]+)'\s*(?:=>\s*([^,\n]+))?/", $m[1] ?? '', $props, PREG_SET_ORDER);
                    $out[] = ['component' => $name, 'attributes' => array_map(fn ($x) => trim($x[1] . (isset($x[2]) ? ' (default ' . trim($x[2]) . ')' : '')), $props)];
                }

                return $out;
            }, readOnly: true),

            new SiteTool('add_page_section', 'Add a section to a page: type "html" with HTML, or type "component" with a component name and its attributes. Placed after `after` (a section key) or at the end.', [
                'page' => $page,
                'key' => P::str('New section key: lower-case words joined by hyphens, unique on the page.')->req(),
                'type' => P::str('html or component.')->enum(['html', 'component'])->req(),
                'html' => P::str('HTML for an html section.'),
                'component' => P::str('Component name (see list_components).'),
                'attributes' => P::obj('Component attributes.'),
                'slot_html' => P::str('Inner HTML for a component that takes content.'),
                'after' => P::str('Insert after this section key (default: at the end).'),
                'visible' => P::bool('Visible on the page (default true).'),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $key = $a['key'];
                if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $key)) {
                    throw new ToolError('Section keys use lower-case letters, digits and hyphens.');
                }
                if ($p->sections()->withTrashed()->where('key', $key)->exists()) {
                    throw new ToolError("Page /{$p->path} already has a section \"$key\" (maybe in the trash).");
                }
                $removed = [];
                $content = self::buildContent($a['type'], $a, $removed);
                $sort = self::sortAfter($p, $a['after'] ?? null);
                $s = $p->sections()->create(['key' => $key, 'type' => $a['type'], 'component' => $a['type'] === 'component' ? $a['component'] : null,
                    'sort_order' => $sort, 'content' => $content, 'is_visible' => $a['visible'] ?? true]);
                $p->touch();
                Support::log('section.create', $s, "Added section $key to /{$p->path}", null, $content);

                return ['added' => self::summary($s), 'sanitizer_removed' => array_values(array_unique($removed)), 'cache' => Support::changed([$p->path])];
            }),

            new SiteTool('update_page_section', 'Replace a section\'s HTML (html sections) or attributes / slot HTML (component sections). The previous version is kept as a revision. Keep {{embed:N}} placeholders that the section already has.', [
                'page' => $page,
                'section' => $section,
                'html' => P::str('New HTML (html sections).'),
                'attributes' => P::obj('New component attributes (replaces all attributes).'),
                'slot_html' => P::str('New inner HTML (component sections that take content).'),
                'reason' => P::str('Short note saved with the revision.'),
                'expected_updated_at' => $stamp,
            ], function (array $a) {
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                Support::assertStamp($s, $a['expected_updated_at'] ?? null);
                $c = $s->content;
                $removed = [];
                if ($s->type === 'html') {
                    if (! isset($a['html'])) {
                        throw new ToolError('Give `html` for an html section.');
                    }
                    [$c['html'], $r] = Support::html($a['html'], count($c['embeds'] ?? []));
                    $removed = $r;
                } else {
                    if (! isset($a['attributes']) && ! isset($a['slot_html'])) {
                        throw new ToolError('Give `attributes` and/or `slot_html` for a component section.');
                    }
                    if (isset($a['attributes'])) {
                        $c['attributes'] = Support::attributes($a['attributes'], $removed);
                    }
                    if (isset($a['slot_html'])) {
                        [$html, $r] = Support::html($a['slot_html'], count($c['slot']['embeds'] ?? []), 'slot_html');
                        $c['slot'] = ['html' => $html] + (isset($c['slot']['embeds']) ? ['embeds' => $c['slot']['embeds']] : []);
                        array_push($removed, ...$r);
                    }
                }

                return self::saveSection($p, $s, $c, $a['reason'] ?? 'update_page_section') + ['sanitizer_removed' => array_values(array_unique($removed))];
            }),

            new SiteTool('delete_page_section', 'Move a section to the trash (restore with restore_item).', [
                'page' => $page, 'section' => $section,
            ], function (array $a) {
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                $s->delete();
                $p->touch();
                Support::log('section.delete', $s, "Moved section {$s->key} of /{$p->path} to the trash");

                return ['deleted' => $s->key, 'restore_with' => ['tool' => 'restore_item', 'type' => 'section', 'id' => $s->id], 'cache' => Support::changed([$p->path])];
            }, destructive: true),

            new SiteTool('reorder_page_sections', 'Set the order of a page\'s sections. List every section key in the new order.', [
                'page' => $page,
                'order' => P::arr('All section keys, in the new order.', P::str('Section key'))->req(),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $keys = $p->sections->pluck('key')->all();
                if (count($a['order']) !== count(array_unique($a['order'])) || array_diff($keys, $a['order']) || array_diff($a['order'], $keys)) {
                    throw new ToolError('List each section key exactly once. Current keys: ' . implode(', ', $keys));
                }
                $before = $keys;
                DB::transaction(function () use ($p, $a) {
                    foreach ($a['order'] as $i => $key) {
                        $s = $p->sections->firstWhere('key', $key);
                        if ($s->sort_order !== ($i + 1) * 10) {
                            $s->revisionActor = Support::ACTOR;
                            $s->revisionReason = 'reorder';
                            $s->update(['sort_order' => ($i + 1) * 10]);
                        }
                    }
                    $p->touch();
                });
                Support::log('section.reorder', $p, "Reordered sections of /{$p->path}", $before, $a['order']);

                return ['order' => $a['order'], 'cache' => Support::changed([$p->path])];
            }),

            new SiteTool('toggle_section_visibility', 'Show or hide a section without deleting it.', [
                'page' => $page, 'section' => $section,
                'visible' => P::bool('true = show, false = hide.')->req(),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                $s->revisionActor = Support::ACTOR;
                $s->revisionReason = $a['visible'] ? 'shown' : 'hidden';
                $s->update(['is_visible' => (bool) $a['visible']]);
                $p->touch();
                Support::log('section.visibility', $s, ($a['visible'] ? 'Showed' : 'Hid') . " section {$s->key} on /{$p->path}");

                return ['section' => $s->key, 'visible' => $s->is_visible, 'cache' => Support::changed([$p->path])];
            }),

            new SiteTool('list_section_revisions', 'List the saved earlier versions of a section (newest first).', [
                'page' => $page, 'section' => $section,
            ], function (array $a) {
                $s = Support::section(Support::page($a['page']), $a['section']);

                return $s->revisions()->get()->map(fn (SectionRevision $r) => [
                    'revision_id' => $r->id, 'saved_at' => $r->created_at?->toIso8601String(), 'reason' => $r->reason, 'by' => $r->actor,
                    'visible' => $r->snapshot['is_visible'] ?? null, 'size' => strlen(json_encode($r->snapshot['content'] ?? [])),
                    'preview' => mb_substr(HtmlEdit::plain($r->snapshot['content']['html'] ?? json_encode($r->snapshot['content']['attributes'] ?? [])), 0, 160),
                ])->all();
            }, readOnly: true),

            new SiteTool('restore_section_revision', 'Bring back an earlier version of a section. The current version is saved as a revision first, so this can be undone.', [
                'page' => $page, 'section' => $section,
                'revision_id' => P::int('Revision id from list_section_revisions.')->req(),
            ], function (array $a) {
                $p = Support::page($a['page']);
                $s = Support::section($p, $a['section']);
                $r = $s->revisions()->whereKey($a['revision_id'])->first() ?? throw new ToolError('That revision does not belong to this section.');
                $snap = $r->snapshot;
                $s->revisionActor = Support::ACTOR;
                $s->revisionReason = "restore revision {$r->id}";
                $s->fill(['content' => $snap['content'], 'is_visible' => $snap['is_visible'] ?? $s->is_visible])->save();
                $p->touch();
                Support::log('section.restore_revision', $s, "Restored revision {$r->id} of {$s->key} on /{$p->path}");

                return ['restored' => $r->id, 'section' => self::summary($s->fresh()), 'cache' => Support::changed([$p->path])];
            }),

            new SiteTool('search_content', 'Search the visible text of all pages, FAQs, pricing, settings and blog posts. Returns where each match is.', [
                'query' => P::str('Text to look for (case-insensitive).', 'min:2')->req(),
                'limit' => P::int('Max results (default 100).', 'max:500'),
            ], function (array $a) {
                $q = mb_strtolower(html_entity_decode($a['query'], ENT_QUOTES | ENT_HTML5));
                $hits = [];
                $look = function (string $where, string $text) use ($q, &$hits) {
                    $plain = HtmlEdit::plain($text);
                    $pos = mb_stripos($plain, $q);
                    if ($pos !== false) {
                        $hits[] = ['where' => $where, 'context' => '…' . mb_substr($plain, max(0, $pos - 70), 160) . '…'];
                    }
                };
                foreach (PageSection::with('page')->get() as $s) {
                    if ($s->page) {
                        $text = '';
                        array_walk_recursive($s->content, function ($v, $k) use (&$text) {
                            if (is_string($v) && $k !== 'before') {
                                $text .= ' ' . $v;
                            }
                        });
                        $look("page /{$s->page->path} › section {$s->key}", $text);
                    }
                }
                foreach (Faq::all() as $f) {
                    $look("faq #{$f->id} ({$f->faq_group})", $f->question . ' ' . $f->answer);
                }
                foreach (PricingPlan::all() as $pl) {
                    $look("pricing plan #{$pl->id} {$pl->name}", implode(' ', array_filter([$pl->name, $pl->subtitle, $pl->badge, implode(' ', $pl->features ?? [])])));
                }
                foreach (Post::all() as $post) {
                    $look("blog /{$post->slug}", $post->title . ' ' . $post->excerpt . ' ' . $post->content);
                }

                return array_slice($hits, 0, $a['limit'] ?? 100);
            }, readOnly: true),

            new SiteTool('replace_text', 'Find and replace visible text across pages (sections, including component text), FAQs, pricing features and blog posts. Never touches tags, attributes or links. dry_run (default true) only shows what would change.', [
                'find' => P::str('Exact text to find.', 'min:2')->req(),
                'replace' => P::str('Replacement text (plain text).')->req(),
                'page' => P::str('Only this page (path). Default: everywhere.'),
                'case_sensitive' => P::bool('Default true.'),
                'dry_run' => P::bool('Default true: preview only.'),
            ], fn (array $a) => self::replaceText($a)),
        ];
    }

    /** Section summary for tool output. */
    public static function summary(PageSection $s): array
    {
        return ['key' => $s->key, 'type' => $s->type, 'component' => $s->component, 'sort_order' => $s->sort_order,
            'visible' => $s->is_visible, 'updated_at' => Support::stamp($s),
            'preview' => mb_substr(HtmlEdit::plain($s->content['html'] ?? json_encode($s->content['attributes'] ?? [], JSON_UNESCAPED_UNICODE)), 0, 120)];
    }

    /** Stored content without the internal whitespace field. */
    private static function publicContent(array $c): array
    {
        unset($c['before']);

        return $c;
    }

    private static function buildContent(string $type, array $a, array &$removed): array
    {
        if ($type === 'html') {
            if (empty($a['html'])) {
                throw new ToolError('Give `html` for an html section.');
            }
            [$html, $removed] = Support::html($a['html']);

            return ['before' => "\n\n", 'html' => $html];
        }
        if (empty($a['component']) || ! SectionRenderer::componentExists($a['component'])) {
            throw new ToolError('Unknown component "' . ($a['component'] ?? '') . '". See list_components.');
        }
        $c = ['before' => "\n\n", 'attributes' => Support::attributes($a['attributes'] ?? [], $removed)];
        if (! empty($a['slot_html'])) {
            [$html, $r] = Support::html($a['slot_html'], 0, 'slot_html');
            $c['slot'] = ['html' => $html];
            array_push($removed, ...$r);
        }

        return $c;
    }

    private static function sortAfter(Page $p, ?string $after): int
    {
        if ($after === null || $after === '') {
            return ((int) $p->sections()->max('sort_order')) + 10;
        }
        $anchor = Support::section($p, $after);
        $next = $p->sections()->where('sort_order', '>', $anchor->sort_order)->min('sort_order');
        if ($next === null) {
            return $anchor->sort_order + 10;
        }
        if ($next - $anchor->sort_order > 1) {
            return intdiv($anchor->sort_order + $next, 2);
        }
        // No gap: renumber everything in steps of 10, then insert.
        foreach ($p->sections as $i => $s) {
            $s->timestamps = false;
            $s->updateQuietly(['sort_order' => ($i + 1) * 10]);
        }

        return $p->sections()->where('key', $after)->value('sort_order') + 5;
    }

    /** Save new content for a section (revision via the model), log, clear caches. */
    public static function saveSection(Page $p, PageSection $s, array $content, string $reason): array
    {
        $before = $s->content;
        $s->revisionActor = Support::ACTOR;
        $s->revisionReason = $reason;
        $s->content = $content;
        $s->save();
        $p->touch();
        Support::log('section.update', $s, "Updated section {$s->key} on /{$p->path}: $reason", $before, $content);

        return ['section' => self::summary($s), 'cache' => Support::changed([$p->path])];
    }

    private static function replaceText(array $a): array
    {
        $dry = $a['dry_run'] ?? true;
        $cs = $a['case_sensitive'] ?? true;
        if ($a['replace'] !== strip_tags($a['replace'])) {
            throw new ToolError('`replace` must be plain text.');
        }
        $changes = [];
        $paths = [];

        $sections = PageSection::with('page')->get()->filter(fn ($s) => $s->page && (! isset($a['page']) || $s->page->path === Support::path($a['page'])));
        foreach ($sections as $s) {
            $total = 0;
            $ctx = [];
            $walk = function ($v, $k = null) use (&$walk, $a, $cs, &$total, &$ctx) {
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
                [$new, $n, $c] = HtmlEdit::replaceText($v, $a['find'], $a['replace'], $cs);
                $total += $n;
                array_push($ctx, ...$c);

                return $new;
            };
            $new = $walk($s->content);
            if ($total) {
                $changes[] = ['where' => "page /{$s->page->path} › {$s->key}", 'count' => $total, 'contexts' => array_slice($ctx, 0, 3)];
                if (! $dry) {
                    self::saveSection($s->page, $s, $new, "replace_text \"{$a['find']}\"");
                    $paths[] = $s->page->path;
                }
            }
        }

        if (! isset($a['page'])) {
            foreach (Faq::all() as $f) {
                $n = 0;
                $q = $f->is_html ? HtmlEdit::replaceText($f->question, $a['find'], $a['replace'], $cs) : self::plainReplace($f->question, $a, $cs);
                $an = $f->is_html ? HtmlEdit::replaceText($f->answer, $a['find'], $a['replace'], $cs) : self::plainReplace($f->answer, $a, $cs);
                if ($q[1] + $an[1]) {
                    $changes[] = ['where' => "faq #{$f->id} ({$f->faq_group})", 'count' => $q[1] + $an[1], 'contexts' => [HtmlEdit::plain($f->question)]];
                    if (! $dry) {
                        $before = $f->only(['question', 'answer']);
                        $f->update(['question' => $q[0], 'answer' => $an[0]]);
                        Support::log('faq.update', $f, 'replace_text', $before, $f->only(['question', 'answer']));
                    }
                }
            }
            foreach (PricingPlan::whereNotNull('features')->get() as $pl) {
                $n = 0;
                $features = array_map(function ($x) use ($a, $cs, &$n) {
                    [$v, $c] = HtmlEdit::replaceText($x, $a['find'], $a['replace'], $cs);
                    $n += $c;

                    return $v;
                }, $pl->features);
                if ($n) {
                    $changes[] = ['where' => "pricing plan #{$pl->id} {$pl->name}", 'count' => $n, 'contexts' => []];
                    if (! $dry) {
                        $before = $pl->features;
                        $pl->update(['features' => $features]);
                        Support::log('pricing.update', $pl, 'replace_text', $before, $features);
                    }
                }
            }
            foreach (Post::all() as $post) {
                [$content, $n, $c] = HtmlEdit::replaceText($post->content, $a['find'], $a['replace'], $cs);
                [$title, $n2] = self::plainReplace($post->title, $a, $cs);
                [$excerpt, $n3] = self::plainReplace((string) $post->excerpt, $a, $cs);
                if ($n + $n2 + $n3) {
                    $changes[] = ['where' => "blog /{$post->slug}", 'count' => $n + $n2 + $n3, 'contexts' => array_slice($c, 0, 3)];
                    if (! $dry) {
                        $before = $post->only(['title', 'excerpt']);
                        $post->update(['content' => $content, 'title' => $title, 'excerpt' => $excerpt]);
                        Support::log('post.update', $post, 'replace_text', $before, $post->only(['title', 'excerpt']));
                        $paths[] = $post->slug;
                    }
                }
            }
        }

        return ['dry_run' => $dry, 'matches' => array_sum(array_column($changes, 'count')), 'changes' => $changes,
            'note' => $dry ? 'Nothing changed. Run again with dry_run=false to apply.' : 'Applied; each changed section has a revision.',
            'cache' => $dry ? null : Support::changed(array_values(array_unique($paths)))];
    }

    private static function plainReplace(string $s, array $a, bool $cs): array
    {
        $n = 0;
        $out = $cs ? str_replace($a['find'], $a['replace'], $s, $n) : str_ireplace($a['find'], $a['replace'], $s, $n);

        return [$out, $n];
    }
}
