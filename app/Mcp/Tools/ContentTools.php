<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\ClientLogo;
use App\Models\Download;
use App\Models\Faq;
use App\Models\PageSection;
use App\Models\PricingPlan;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;

/** Pricing plans, FAQs, testimonials, client logos and downloads. */
class ContentTools
{
    public static function tools(): array
    {
        $id = P::int('Record id (from the list tool).')->req();

        return [
            // ---------------- pricing ----------------
            new SiteTool('list_pricing_plans', 'List prices and plans. Rows with a plan_key are the single source of a price shown across the site ({{price:key}}); `used_on` lists the pages showing it.', [
                'group' => P::str('Only this plan_group (e.g. home, monthly, one-time, addons, support).'),
            ], function (array $a) {
                $usage = self::priceUsage();

                return PricingPlan::when(! empty($a['group']), fn ($q) => $q->where('plan_group', $a['group']))
                    ->orderBy('plan_group')->orderBy('sort_order')->get()
                    ->map(fn ($p) => self::plan($p) + ['used_on' => $usage[$p->plan_key] ?? []])->all();
            }, readOnly: true),

            new SiteTool('create_pricing_plan', 'Add a plan or price. Give plan_key to reference the price from page content as {{price:plan_key}}. Cards in plan_group "home" appear in the home page pricing block.', self::planParams(true),
                function (array $a) {
                    $data = self::planData($a);
                    $plan = PricingPlan::create($data + ['sort_order' => $a['sort_order'] ?? ((int) PricingPlan::where('plan_group', $data['plan_group'])->max('sort_order') + 1)]);
                    Support::log('pricing.create', $plan, "Added pricing plan {$plan->name}", null, $plan->toArray());

                    return ['created' => self::plan($plan), 'cache' => Support::changed()];
                }),

            new SiteTool('update_pricing_plan', 'Change a plan or price. Changing price_pkr updates every page that shows this price; a displayed label like "Rs. 2,000" is updated with it.', ['id' => $id] + self::planParams(false),
                function (array $a) {
                    $plan = PricingPlan::findOrFail($a['id']);
                    $before = $plan->toArray();
                    $data = self::planData($a, $plan);
                    if (array_key_exists('price_pkr', $data) && ! array_key_exists('price_label', $data) && $data['price_pkr'] !== null
                        && preg_match('/^(Rs\.?\s?|PKR\s?)[\d,]+$/', (string) $plan->price_label, $m)) {
                        $data['price_label'] = $m[1] . number_format((float) $data['price_pkr']);
                    }
                    $plan->update($data);
                    Support::log('pricing.update', $plan, "Updated pricing plan {$plan->name}", $before, $plan->fresh()->toArray());

                    return ['updated' => self::plan($plan->fresh()), 'cache' => Support::changed()];
                }),

            new SiteTool('delete_pricing_plan', 'Move a plan to the trash. Refused while page content still shows its price ({{price:key}}) unless force=true.', [
                'id' => $id, 'force' => P::bool('Delete even if the price is shown on pages (it then shows empty there).'),
            ], function (array $a) {
                $plan = PricingPlan::findOrFail($a['id']);
                $used = $plan->plan_key ? (self::priceUsage()[$plan->plan_key] ?? []) : [];
                if ($used && empty($a['force'])) {
                    throw new ToolError("This price is shown on: " . implode(', ', $used) . '. Update those pages first or pass force=true.');
                }
                $plan->delete();
                Support::log('pricing.delete', $plan, "Moved pricing plan {$plan->name} to the trash");

                return ['deleted' => $plan->id, 'cache' => Support::changed()];
            }, destructive: true),

            // ---------------- FAQs ----------------
            new SiteTool('list_faqs', 'List FAQs by group. Each group is one FAQ block on a page; the FAQPage structured data is generated from these rows automatically.', [
                'group' => P::str('Only this group (e.g. home:faq-1, car-wash-pos:faq-1).'),
                'page' => P::str('Only groups shown on this page (path).'),
            ], function (array $a) {
                $q = Faq::orderBy('faq_group')->orderBy('sort_order');
                if (! empty($a['group'])) {
                    $q->where('faq_group', $a['group']);
                }
                if (isset($a['page'])) {
                    $q->whereIn('faq_group', self::faqGroupsOn(Support::path($a['page'])));
                }

                return $q->get()->groupBy('faq_group')->map(fn ($rows, $g) => [
                    'group' => $g, 'format' => $rows->first()->is_html ? 'html' : 'plain text',
                    'faqs' => $rows->map(fn ($f) => ['id' => $f->id, 'question' => $f->question, 'answer' => $f->answer, 'visible' => $f->is_visible, 'sort_order' => $f->sort_order])->values()->all(),
                ])->values()->all();
            }, readOnly: true),

            new SiteTool('create_faq', 'Add a FAQ to a group (shown on the page that uses the group; structured data updates by itself). Plain-text groups take plain text; HTML groups allow simple HTML.', [
                'group' => P::str('FAQ group (see list_faqs).')->req(),
                'question' => P::str('Question.')->req(),
                'answer' => P::str('Answer.')->req(),
                'position' => P::int('1-based position in the group (default: last).', 'min:1'),
            ], function (array $a) {
                $existing = Faq::where('faq_group', $a['group'])->orderBy('sort_order')->get();
                if ($existing->isEmpty()) {
                    throw new ToolError("No FAQ group \"{$a['group']}\". FAQ groups belong to FAQ blocks on pages; see list_faqs.");
                }
                $html = $existing->first()->is_html;
                [$q, $an] = self::faqText($a['question'], $a['answer'], $html);
                $pos = min($a['position'] ?? PHP_INT_MAX, $existing->count() + 1);
                foreach ($existing as $i => $f) {
                    $f->timestamps = false;
                    $f->updateQuietly(['sort_order' => $i + 1 >= $pos ? $i + 2 : $i + 1]);
                }
                $faq = Faq::create(['faq_group' => $a['group'], 'question' => $q, 'answer' => $an, 'is_html' => $html, 'sort_order' => $pos]);
                Support::log('faq.create', $faq, "Added FAQ to {$a['group']}", null, $faq->only(['question', 'answer']));

                return ['created' => $faq->only(['id', 'faq_group', 'question', 'answer', 'sort_order']), 'cache' => Support::changed(self::faqPaths($a['group']))];
            }),

            new SiteTool('update_faq', 'Change a FAQ\'s question, answer, position or visibility.', [
                'id' => $id,
                'question' => P::str('New question.'),
                'answer' => P::str('New answer.'),
                'position' => P::int('New 1-based position in its group.', 'min:1'),
                'visible' => P::bool('Show or hide.'),
            ], function (array $a) {
                $faq = Faq::findOrFail($a['id']);
                $before = $faq->only(['question', 'answer', 'sort_order', 'is_visible']);
                [$q, $an] = self::faqText($a['question'] ?? $faq->question, $a['answer'] ?? $faq->answer, $faq->is_html, isset($a['question']), isset($a['answer']));
                $faq->fill(['question' => $q, 'answer' => $an]);
                if (isset($a['visible'])) {
                    $faq->is_visible = (bool) $a['visible'];
                }
                $faq->save();
                if (isset($a['position'])) {
                    $rows = Faq::where('faq_group', $faq->faq_group)->where('id', '!=', $faq->id)->orderBy('sort_order')->get()->all();
                    array_splice($rows, min($a['position'] - 1, count($rows)), 0, [$faq]);
                    foreach ($rows as $i => $f) {
                        $f->timestamps = false;
                        $f->updateQuietly(['sort_order' => $i + 1]);
                    }
                }
                Support::log('faq.update', $faq, "Updated FAQ #{$faq->id}", $before, $faq->fresh()->only(['question', 'answer', 'sort_order', 'is_visible']));

                return ['updated' => $faq->fresh()->only(['id', 'faq_group', 'question', 'answer', 'sort_order', 'is_visible']), 'cache' => Support::changed(self::faqPaths($faq->faq_group))];
            }),

            new SiteTool('delete_faq', 'Move a FAQ to the trash (it disappears from the page and its structured data).', ['id' => $id], function (array $a) {
                $faq = Faq::findOrFail($a['id']);
                $faq->delete();
                Support::log('faq.delete', $faq, "Moved FAQ #{$faq->id} to the trash", $faq->only(['question', 'answer']));

                return ['deleted' => $faq->id, 'cache' => Support::changed(self::faqPaths($faq->faq_group))];
            }, destructive: true),

            // ---------------- testimonials ----------------
            new SiteTool('list_testimonials', 'List customer reviews shown on the home page, sales pages and the thank-you page.', [], fn () => Testimonial::orderBy('sort_order')->get()
                ->map(fn ($t) => $t->only(['id', 'name', 'text', 'source', 'rating', 'sort_order', 'is_visible']))->all(), readOnly: true),

            new SiteTool('create_testimonial', 'Add a customer review (plain text). Only add genuine reviews from real customers.', [
                'name' => P::str('Customer name.', 'max:120')->req(),
                'text' => P::str('Review text.', 'max:2000')->req(),
                'source' => P::str('Where it was posted (default Google).', 'max:60'),
                'rating' => P::int('Stars 1–5 (default 5).', ['min:1', 'max:5']),
                'sort_order' => P::int('Position (default last).'),
            ], function (array $a) {
                $t = Testimonial::create(['name' => Support::text($a['name'], 'name'), 'text' => Support::text($a['text'], 'text'),
                    'source' => $a['source'] ?? 'Google', 'rating' => $a['rating'] ?? 5, 'sort_order' => $a['sort_order'] ?? ((int) Testimonial::max('sort_order') + 1)]);
                Support::log('testimonial.create', $t, "Added review by {$t->name}", null, $t->toArray());

                return ['created' => $t->only(['id', 'name', 'sort_order']), 'cache' => Support::changed()];
            }),

            new SiteTool('update_testimonial', 'Change a customer review (name, text, source, rating, order, visibility).', [
                'id' => $id,
                'name' => P::str('Customer name.', 'max:120'), 'text' => P::str('Review text.', 'max:2000'),
                'source' => P::str('Source.', 'max:60'), 'rating' => P::int('Stars 1–5.', ['min:1', 'max:5']),
                'sort_order' => P::int('Position.'), 'visible' => P::bool('Show or hide.'),
            ], function (array $a) {
                $t = Testimonial::findOrFail($a['id']);
                $before = $t->toArray();
                $t->fill(array_filter([
                    'name' => isset($a['name']) ? Support::text($a['name'], 'name') : null,
                    'text' => isset($a['text']) ? Support::text($a['text'], 'text') : null,
                    'source' => $a['source'] ?? null, 'rating' => $a['rating'] ?? null, 'sort_order' => $a['sort_order'] ?? null,
                ], fn ($v) => $v !== null));
                if (isset($a['visible'])) {
                    $t->is_visible = (bool) $a['visible'];
                }
                $t->save();
                Support::log('testimonial.update', $t, "Updated review #{$t->id}", $before, $t->toArray());

                return ['updated' => $t->only(['id', 'name', 'text', 'is_visible']), 'cache' => Support::changed()];
            }),

            new SiteTool('delete_testimonial', 'Move a customer review to the trash.', ['id' => $id], fn (array $a) => self::trash(Testimonial::findOrFail($a['id']), 'testimonial'), destructive: true),

            // ---------------- client logos ----------------
            new SiteTool('list_client_logos', 'List client logo strips: group "proof" (the small logo row under calls to action) and the home page marquee rows.', [
                'group' => P::str('Only this group.'),
            ], fn (array $a) => ClientLogo::when(! empty($a['group']), fn ($q) => $q->where('logo_group', $a['group']))
                ->orderBy('logo_group')->orderBy('sort_order')->get()
                ->map(fn ($l) => $l->only(['id', 'logo_group', 'name', 'image', 'client_slug', 'sort_order', 'is_visible']) + ['url' => asset('uploads/' . $l->image)])->all(), readOnly: true),

            new SiteTool('create_client_logo', 'Add a client logo to a strip. The image must already be uploaded (upload_image) under /uploads.', [
                'group' => P::str('Logo group, e.g. proof or marquee:home:1-row1 (see list_client_logos).')->req(),
                'name' => P::str('Client name (used as alt text).', 'max:120')->req(),
                'image' => P::str('Image path under public/uploads, e.g. 2026/11/acme-logo.webp.')->req(),
                'client_slug' => P::str('Portfolio page slug (/portfolio-item/<slug>) to link to.'),
                'sort_order' => P::int('Position (default last).'),
            ], function (array $a) {
                $l = ClientLogo::create(['logo_group' => $a['group'], 'name' => Support::text($a['name'], 'name'), 'image' => self::uploadPath($a['image']),
                    'client_slug' => $a['client_slug'] ?? null, 'sort_order' => $a['sort_order'] ?? ((int) ClientLogo::where('logo_group', $a['group'])->max('sort_order') + 1)]);
                Support::log('logo.create', $l, "Added logo {$l->name} to {$l->logo_group}", null, $l->toArray());

                return ['created' => $l->only(['id', 'logo_group', 'name', 'image']), 'cache' => Support::changed()];
            }),

            new SiteTool('update_client_logo', 'Change a client logo (name, image, link, order, visibility).', [
                'id' => $id,
                'name' => P::str('Client name.', 'max:120'), 'image' => P::str('Image path under public/uploads.'),
                'client_slug' => P::str('Portfolio slug.'), 'sort_order' => P::int('Position.'), 'visible' => P::bool('Show or hide.'),
            ], function (array $a) {
                $l = ClientLogo::findOrFail($a['id']);
                $before = $l->toArray();
                $l->fill(array_filter([
                    'name' => isset($a['name']) ? Support::text($a['name'], 'name') : null,
                    'image' => isset($a['image']) ? self::uploadPath($a['image']) : null,
                    'client_slug' => $a['client_slug'] ?? null, 'sort_order' => $a['sort_order'] ?? null,
                ], fn ($v) => $v !== null));
                if (isset($a['visible'])) {
                    $l->is_visible = (bool) $a['visible'];
                }
                $l->save();
                Support::log('logo.update', $l, "Updated logo #{$l->id}", $before, $l->toArray());

                return ['updated' => $l->only(['id', 'logo_group', 'name', 'image', 'is_visible']), 'cache' => Support::changed()];
            }),

            new SiteTool('delete_client_logo', 'Move a client logo to the trash.', ['id' => $id], fn (array $a) => self::trash(ClientLogo::findOrFail($a['id']), 'logo'), destructive: true),

            // ---------------- downloads ----------------
            new SiteTool('list_downloads', 'List the downloadable apps (RetailPro, RestroPro…) with version, size, download count and links. These facts are shown on /downloads and /download/* from one record each.', [],
                fn () => Download::orderBy('sort_order')->get()->map(fn ($d) => $d->only(['id', 'key', 'app_name', 'platform', 'version', 'file_size', 'download_count', 'file_url', 'store_url', 'release_notes', 'is_visible'])
                    + ['published' => $d->extra['published'] ?? null, 'updated' => $d->extra['updated'] ?? null])->all(), readOnly: true),

            new SiteTool('update_download', 'Change an app\'s version, file size, download count, download link, store link, release notes or dates. Every page showing it updates.', [
                'key' => P::str('Download key, e.g. restropro.')->req(),
                'version' => P::str('Version, e.g. 2.1.', 'max:60'),
                'file_size' => P::str('Size as shown, e.g. "74.33 MB".', 'max:40'),
                'download_count' => P::int('Number of downloads.', 'min:0'),
                'file_url' => P::str('Download link (https).', 'url'),
                'store_url' => P::str('App store link (https).', 'url'),
                'platform' => P::str('Platform text, e.g. Windows 7/8/10.', 'max:120'),
                'release_notes' => P::str('Release notes (plain text).', 'max:5000'),
                'published' => P::str('Published date as shown, e.g. "May 19, 2019".', 'max:40'),
                'updated' => P::str('Last updated date as shown, e.g. "November 5, 2026".', 'max:40'),
            ], function (array $a) {
                $d = Download::where('key', $a['key'])->first() ?? throw new ToolError("No download \"{$a['key']}\". See list_downloads.");
                $before = $d->toArray();
                foreach (['version', 'file_size', 'file_url', 'store_url', 'platform'] as $f) {
                    if (isset($a[$f])) {
                        $d->$f = $f === 'file_url' || $f === 'store_url' ? self::httpsUrl($a[$f]) : Support::text($a[$f], $f);
                    }
                }
                if (isset($a['download_count'])) {
                    $d->download_count = (string) $a['download_count'];
                }
                if (isset($a['release_notes'])) {
                    $d->release_notes = Support::text($a['release_notes'], 'release_notes');
                }
                $extra = $d->extra ?? [];
                foreach (['published', 'updated'] as $f) {
                    if (isset($a[$f])) {
                        $extra[$f] = Support::text($a[$f], $f);
                    }
                }
                $d->extra = $extra;
                $d->save();
                Support::log('download.update', $d, "Updated download {$d->key}", $before, $d->toArray());

                return ['updated' => $d->only(['key', 'version', 'file_size', 'download_count', 'file_url']), 'cache' => Support::changed(['downloads', 'download/' . $d->key])];
            }),
        ];
    }

    private static function planParams(bool $create): array
    {
        $p = [
            'plan_group' => P::str('Group, e.g. home (home page cards), monthly, one-time, addons, support.', 'max:60'),
            'plan_key' => P::str('Stable key used in content as {{price:plan_key}} (lower-case, hyphens).', ['max:80', 'regex:/^[a-z0-9]+(-[a-z0-9]+)*$/']),
            'name' => P::str('Plan name.', 'max:190'),
            'price_pkr' => P::num('Price in PKR (empty for "Contact sales" / custom).', 'min:0'),
            'price_label' => P::str('Price as shown on a card, e.g. "Rs. 2,000" or "Contact Sales".', 'max:190'),
            'billing_period' => P::str('month, year or one-time.')->enum(['month', 'year', 'one-time']),
            'subtitle' => P::str('Line under the price.', 'max:500'),
            'badge' => P::str('Badge text, e.g. MOST POPULAR.', 'max:60'),
            'features' => P::arr('Feature list (simple HTML allowed).', P::str('Feature')),
            'cta_label' => P::str('Button text.', 'max:120'),
            'cta_url' => P::str('Button link: a path (/contact#enquiry), #enquiry, or https:// URL.', 'max:500'),
            'cta_style' => P::str('Button style.')->enum(['btn-primary', 'btn-ghost', 'btn-outline', 'btn-wa']),
            'cta_new_tab' => P::bool('Open the button link in a new tab.'),
            'is_featured' => P::bool('Highlighted card.'),
            'sort_order' => P::int('Position within the group.'),
            'visible' => P::bool('Show or hide.'),
        ];
        if ($create) {
            $p['plan_group'] = $p['plan_group']->req();
            $p['name'] = $p['name']->req();
        }

        return $p;
    }

    private static function planData(array $a, ?PricingPlan $plan = null): array
    {
        $d = [];
        foreach (['plan_group', 'plan_key', 'name', 'price_pkr', 'price_label', 'billing_period', 'subtitle', 'badge', 'cta_label', 'cta_style', 'sort_order'] as $f) {
            if (array_key_exists($f, $a)) {
                $d[$f] = is_string($a[$f]) && ! in_array($f, ['plan_key', 'plan_group'], true) ? Support::text($a[$f], $f) : $a[$f];
            }
        }
        if (isset($d['plan_key']) && PricingPlan::withTrashed()->where('plan_key', $d['plan_key'])->where('id', '!=', $plan?->id)->exists()) {
            throw new ToolError("plan_key \"{$d['plan_key']}\" is already used.");
        }
        if (array_key_exists('features', $a)) {
            $removed = [];
            $d['features'] = array_values(array_map(function ($f) use (&$removed) {
                [$h, $r] = Support::html($f, 0, 'feature');
                array_push($removed, ...$r);

                return $h;
            }, $a['features'] ?? []));
        }
        if (array_key_exists('cta_url', $a)) {
            $u = trim((string) $a['cta_url']);
            if ($u !== '' && ! preg_match('#^(https?://|/|\#|mailto:|tel:)#i', $u)) {
                throw new ToolError('cta_url must be a path, #anchor or https:// URL.');
            }
            $d['cta_url'] = $u ?: null;
        }
        foreach (['cta_new_tab' => 'cta_new_tab', 'is_featured' => 'is_featured', 'visible' => 'is_visible'] as $in => $col) {
            if (isset($a[$in])) {
                $d[$col] = (bool) $a[$in];
            }
        }

        return $d;
    }

    public static function plan(PricingPlan $p): array
    {
        return ['id' => $p->id, 'plan_key' => $p->plan_key, 'plan_group' => $p->plan_group, 'name' => $p->name, 'price_pkr' => $p->price_pkr === null ? null : (float) $p->price_pkr,
            'price_label' => $p->price_label, 'billing_period' => $p->billing_period, 'subtitle' => $p->subtitle, 'badge' => $p->badge,
            'features' => $p->features, 'cta' => array_filter(['label' => $p->cta_label, 'url' => $p->cta_url, 'style' => $p->cta_style, 'new_tab' => $p->cta_new_tab ?: null]),
            'featured' => $p->is_featured, 'visible' => $p->is_visible, 'sort_order' => $p->sort_order];
    }

    /** plan_key => pages whose content shows {{price:key}} / {{price_plain:key}} (plus builder / home cards). */
    private static function priceUsage(): array
    {
        $usage = [];
        foreach (PageSection::with('page')->get() as $s) {
            if (! $s->page) {
                continue;
            }
            preg_match_all('/\{\{price(?:_plain)?:([a-z0-9-]+)\}\}/', json_encode($s->content), $m);
            foreach (array_unique($m[1]) as $k) {
                $usage[$k][] = '/' . $s->page->path;
            }
        }
        foreach (['retailpro-monthly', 'retailpro-onetime-basic', 'retailpro-onetime-standard'] as $k) {
            $usage[$k][] = '/ (price builder)';
        }
        foreach (PricingPlan::where('plan_group', 'addons')->pluck('plan_key') as $k) {
            $usage[$k][] = '/ (price builder)';
        }

        return array_map(fn ($v) => array_values(array_unique($v)), $usage);
    }

    private static function faqText(string $q, string $a, bool $html, bool $checkQ = true, bool $checkA = true): array
    {
        if ($html) {
            return [$checkQ ? Support::html($q, 0, 'question')[0] : $q, $checkA ? Support::html($a, 0, 'answer')[0] : $a];
        }
        if (($checkQ && $q !== strip_tags($q)) || ($checkA && $a !== strip_tags($a))) {
            throw new ToolError('This FAQ group is plain text: no HTML in question or answer.');
        }

        return [trim($q), trim($a)];
    }

    /** FAQ groups used by a page (from its sections' attributes and embeds). */
    private static function faqGroupsOn(string $path): array
    {
        $page = Support::page($path);
        $groups = [];
        foreach ($page->sections as $s) {
            $__c = $s->content;
            array_walk_recursive($__c, function ($v, $k) use (&$groups) {
                if (in_array($k, ['group', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9], true) && is_string($v) && Faq::where('faq_group', $v)->exists()) {
                    $groups[] = $v;
                }
            });
        }

        return array_values(array_unique($groups));
    }

    private static function faqPaths(string $group): array
    {
        $prefix = explode(':', $group)[0];

        return [$prefix === 'home' ? '' : $prefix];
    }

    private static function uploadPath(string $image): string
    {
        $p = ltrim(preg_replace('#^/?uploads/#', '', trim($image)), '/');
        if (str_contains($p, '..') || ! is_file(public_path('uploads/' . $p))) {
            throw new ToolError("No file public/uploads/$p. Upload it first with upload_image.");
        }

        return $p;
    }

    private static function httpsUrl(string $u): string
    {
        if (! preg_match('#^https?://#i', $u)) {
            throw new ToolError('Links must start with https:// (or http://).');
        }

        return $u;
    }

    private static function trash(Model $m, string $what): array
    {
        $m->delete();
        Support::log("$what.delete", $m, "Moved $what #{$m->getKey()} to the trash");

        return ['deleted' => $m->getKey(), 'restore_with' => ['tool' => 'restore_item', 'type' => $what, 'id' => $m->getKey()], 'cache' => Support::changed()];
    }
}
