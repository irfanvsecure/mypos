<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Mcp\ToolRegistry;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\ClientLogo;
use App\Models\Download;
use App\Models\Faq;
use App\Models\Lead;
use App\Models\Media;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\PricingPlan;
use App\Models\Redirect;
use App\Models\SchemaBlock;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Site\PageRenderer;
use App\Site\Settings;
use App\Site\SiteCache;
use Illuminate\Support\Facades\File;

/** Settings, enquiries (read-only), trash, activity log, cache, performance, site info. */
class SiteTools
{
    /** Trash types → model. */
    private const TRASH = [
        'page' => Page::class, 'section' => PageSection::class, 'post' => Post::class, 'faq' => Faq::class, 'testimonial' => Testimonial::class,
        'logo' => ClientLogo::class, 'image' => Media::class, 'pricing' => PricingPlan::class, 'redirect' => Redirect::class,
        'category' => Category::class, 'tag' => Tag::class, 'schema' => SchemaBlock::class, 'download' => Download::class,
    ];

    /** Settings whose value is HTML (sanitized on save). */
    private const HTML_SETTINGS = ['footer_tagline', 'footer_copyright'];

    public static function tools(): array
    {
        $types = array_keys(self::TRASH);

        return [
            new SiteTool('get_settings', 'Site-wide settings: phone, WhatsApp, email, address, hours, trial sign-up link, header menu, footer columns and legal links, offer bar, default meta, rating, robots extras… with what each controls.', [
                'key' => P::str('Only this setting.'),
            ], function (array $a) {
                $out = [];
                foreach (Settings::KEYS as $key => $desc) {
                    if (! empty($a['key']) && $a['key'] !== $key) {
                        continue;
                    }
                    $out[] = ['key' => $key, 'value' => config('site.' . $key), 'controls' => $desc];
                }

                return $out ?: throw new ToolError('Unknown setting. Keys: ' . implode(', ', array_keys(Settings::KEYS)));
            }, readOnly: true),

            new SiteTool('update_settings', 'Change one or more site settings: {key: value}. Lists (menu, footer, legal, enquiry_types, no_lead_form) must keep their shape — read them with get_settings first.', [
                'values' => P::obj('Settings to change, e.g. {"phone": "+92 300 1234567", "phone_raw": "+923001234567"}.')->req(),
            ], function (array $a) {
                $changed = [];
                foreach ($a['values'] as $key => $value) {
                    if (! array_key_exists($key, Settings::KEYS)) {
                        throw new ToolError("Unknown setting \"$key\". Keys: " . implode(', ', array_keys(Settings::KEYS)));
                    }
                    $value = self::checkSetting($key, $value);
                    $s = Setting::withTrashed()->firstOrNew(['key' => $key]);
                    $before = $s->exists ? $s->value : config('site.' . $key);
                    $s->fill(['value' => $value, 'description' => Settings::KEYS[$key], 'deleted_at' => null])->save();
                    Support::log('setting.update', $s, "Setting $key", $before, $value);
                    $changed[] = ['key' => $key, 'before' => $before, 'after' => $value];
                }
                Settings::flush();

                return ['changed' => $changed, 'cache' => Support::changed()];
            }),

            new SiteTool('list_enquiries', 'Read-only list of website enquiries (demo / free-trial / contact forms): date, name, business, enquiry type, message and the page it came from. Phone numbers, emails and IP addresses are not returned; enquiries cannot be edited, deleted or exported here.', [
                'since' => P::str('From this date (YYYY-MM-DD).', 'date'),
                'until' => P::str('Up to this date (YYYY-MM-DD).', 'date'),
                'type' => P::str('Enquiry type, e.g. Free Demo.'),
                'limit' => P::int('Max rows (default 50, at most 200).', ['min:1', 'max:200']),
            ], function (array $a) {
                $q = Lead::query()->orderByDesc('created_at');
                if (! empty($a['since'])) {
                    $q->where('created_at', '>=', $a['since']);
                }
                if (! empty($a['until'])) {
                    $q->where('created_at', '<', \Illuminate\Support\Carbon::parse($a['until'])->addDay());
                }
                if (! empty($a['type'])) {
                    $q->where('type', 'like', '%' . $a['type'] . '%');
                }
                $total = (clone $q)->count();

                return ['total_matching' => $total, 'enquiries' => $q->limit($a['limit'] ?? 50)
                    ->get(['id', 'created_at', 'name', 'business', 'type', 'message', 'page'])
                    ->map(fn ($l) => ['id' => $l->id, 'date' => $l->created_at?->toIso8601String(), 'name' => $l->name, 'business' => $l->business,
                        'type' => $l->type, 'message' => $l->message, 'page' => $l->page])->all()];
            }, readOnly: true),

            new SiteTool('list_trash', 'Items in the trash (deleted pages, sections, posts, FAQs, images, …) that can be restored or purged.', [
                'type' => P::str('Only this kind.')->enum($types),
            ], function (array $a) {
                $out = [];
                foreach (self::TRASH as $type => $class) {
                    if (! empty($a['type']) && $a['type'] !== $type) {
                        continue;
                    }
                    foreach ($class::onlyTrashed()->orderByDesc('deleted_at')->limit(200)->get() as $m) {
                        $out[] = ['type' => $type, 'id' => $m->getKey(), 'label' => self::label($m), 'deleted_at' => $m->deleted_at?->toIso8601String()];
                    }
                }

                return $out;
            }, readOnly: true),

            new SiteTool('restore_item', 'Bring an item back from the trash.', [
                'type' => P::str('Kind of item.')->enum($types)->req(),
                'id' => P::int('Item id (from list_trash).')->req(),
            ], function (array $a) {
                $m = self::TRASH[$a['type']]::onlyTrashed()->findOrFail($a['id']);
                if ($m instanceof Page) {
                    Support::assertFreePath($m->path, $m);
                }
                if ($m instanceof Post) {
                    Support::assertFreePath($m->slug, $m);
                }
                if ($m instanceof PageSection && $m->page()->withTrashed()->first()?->trashed()) {
                    throw new ToolError('Its page is in the trash; restore the page first.');
                }
                $m->restore();
                Support::log($a['type'] . '.restore', $m, 'Restored ' . self::label($m));

                return ['restored' => ['type' => $a['type'], 'id' => $m->getKey(), 'label' => self::label($m)], 'cache' => Support::changed()];
            }),

            new SiteTool('purge_item', 'Delete an item from the trash for good (cannot be undone). Images also lose their files. Needs confirm=true.', [
                'type' => P::str('Kind of item.')->enum($types)->req(),
                'id' => P::int('Item id (from list_trash).')->req(),
                'confirm' => P::bool('Must be true.')->req(),
            ], function (array $a) {
                if (! $a['confirm']) {
                    throw new ToolError('Purging is permanent: pass confirm=true.');
                }
                $m = self::TRASH[$a['type']]::onlyTrashed()->findOrFail($a['id']);
                $label = self::label($m);
                $snapshot = $m->toArray();
                if ($m instanceof Media) {
                    foreach (array_unique(array_filter(array_merge([$m->path, $m->original_path], array_column($m->variants ?? [], 'path')))) as $f) {
                        if (str_starts_with($f, 'uploads/') && ! str_contains($f, '..')) {
                            File::delete(public_path($f));
                        }
                    }
                }
                if ($m instanceof Page) {
                    $m->sections()->withTrashed()->get()->each->forceDelete();
                    $m->schemaBlocks()->withTrashed()->forceDelete();
                    $m->seo()->withTrashed()->forceDelete();
                }
                if ($m instanceof Post) {
                    $m->tags()->detach();
                    $m->seo()->withTrashed()->forceDelete();
                }
                $m->forceDelete();
                Support::log($a['type'] . '.purge', null, "Purged {$a['type']} #{$a['id']} ($label)", $snapshot);

                return ['purged' => ['type' => $a['type'], 'id' => $a['id'], 'label' => $label]];
            }, destructive: true),

            new SiteTool('activity_log', 'Who changed what and when (newest first), with before / after values.', [
                'limit' => P::int('Max entries (default 50).', ['min:1', 'max:500']),
                'action' => P::str('Filter by action prefix, e.g. section, seo, pricing.'),
                'subject_type' => P::str('Filter by subject, e.g. Page, PageSection, Post.'),
                'include_values' => P::bool('Include before / after values (default true).'),
            ], function (array $a) {
                $q = ActivityLog::orderByDesc('id');
                if (! empty($a['action'])) {
                    $q->where('action', 'like', $a['action'] . '%');
                }
                if (! empty($a['subject_type'])) {
                    $q->where('subject_type', $a['subject_type']);
                }

                return $q->limit($a['limit'] ?? 50)->get()->map(fn ($l) => array_filter([
                    'id' => $l->id, 'at' => $l->created_at?->toIso8601String(), 'by' => $l->actor, 'action' => $l->action,
                    'subject' => $l->subject_type ? "{$l->subject_type} #{$l->subject_id}" : null, 'summary' => $l->summary,
                    'before' => ($a['include_values'] ?? true) ? $l->before : null, 'after' => ($a['include_values'] ?? true) ? $l->after : null,
                ], fn ($v) => $v !== null))->all();
            }, readOnly: true),

            new SiteTool('clear_cache', 'Clear the site\'s caches (settings, redirects, page analysis, compiled views) and purge Cloudflare when it is configured.', [], function () {
                $r = SiteCache::changed();
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                Support::log('cache.clear', null, 'Cleared caches');

                return $r + ['views' => 'cleared'];
            }),

            new SiteTool('audit_performance', 'Page-weight check of a rendered page: HTML size, render time, images (count, total size, not lazy, not WebP, largest files), CSS / JS size and third-party scripts.', [
                'page' => P::str('Page path or post slug.')->reqAllowEmpty(),
            ], function (array $a) {
                $t = Support::target($a['page']);
                $start = microtime(true);
                $html = $t['type'] === 'page' ? PageRenderer::page($t['model']) : PageRenderer::post($t['model']);
                $ms = (int) ((microtime(true) - $start) * 1000);
                $an = Support::analyze($a['page']);
                $imgs = [];
                $bytes = 0;
                foreach ($an['images'] as $i) {
                    $p = Support::internalPath($i['src']);
                    $size = $p && is_file(public_path($p)) ? filesize(public_path($p)) : null;
                    $bytes += (int) $size;
                    $imgs[] = ['src' => $p ?: $i['src'], 'kb' => $size ? round($size / 1024) : null, 'lazy' => $i['loading'] === 'lazy', 'webp' => $i['webp']];
                }
                usort($imgs, fn ($x, $y) => ($y['kb'] ?? 0) <=> ($x['kb'] ?? 0));
                preg_match_all('#<script[^>]+src="([^"]+)"|BASE_URL="(https://[^"]+)"#', $html, $scripts);
                $third = array_values(array_unique(array_filter(array_map(fn ($u) => parse_url($u, PHP_URL_HOST), array_merge($scripts[1], $scripts[2])),
                    fn ($h) => $h && ! str_contains((string) config('app.url'), $h))));

                return [
                    'path' => '/' . $an['path'], 'html_kb' => round(strlen($html) / 1024), 'server_render_ms' => $ms,
                    'images' => ['count' => count($imgs), 'local_total_kb' => round($bytes / 1024),
                        'not_lazy' => count(array_filter($imgs, fn ($i) => ! $i['lazy'])), 'not_webp' => count(array_filter($imgs, fn ($i) => ! $i['webp'])),
                        'largest' => array_slice($imgs, 0, 5)],
                    'css_kb' => round(filesize(public_path('css/style.css')) / 1024), 'js_kb' => round(filesize(public_path('js/app.js')) / 1024),
                    'third_party_hosts' => array_values(array_unique(array_merge($third, str_contains($html, 'fonts.googleapis.com') ? ['fonts.googleapis.com'] : [],
                        str_contains($html, 'connect.facebook.net') ? ['connect.facebook.net'] : []))),
                    'note' => 'Server-side measurement only; use PageSpeed Insights on the live URL for Core Web Vitals.',
                ];
            }, readOnly: true),

            new SiteTool('get_site_info', 'Overview: site URL, environment, whether search engines are blocked (SITE_NOINDEX), content counts, Cloudflare purge status, last change, and the number of tools.', [], function () {
                $last = ActivityLog::orderByDesc('id')->first();

                return [
                    'site' => config('site.name'), 'url' => rtrim((string) config('site.url'), '/'), 'environment' => app()->environment(),
                    'site_noindex' => (bool) config('site.noindex'),
                    'site_noindex_note' => config('site.noindex') ? 'Pre-launch: every page is noindex, nofollow and robots.txt has no sitemap. The owner switches SITE_NOINDEX off in .env at launch.' : 'Indexable.',
                    'counts' => ['pages' => Page::count(), 'published_pages' => Page::published()->count(), 'sections' => PageSection::count(),
                        'blog_posts' => Post::count(), 'published_posts' => Post::published()->count(), 'faqs' => Faq::count(), 'testimonials' => Testimonial::count(),
                        'pricing_plans' => PricingPlan::count(), 'downloads' => Download::count(), 'redirects' => Redirect::count(),
                        'images' => Media::count(), 'enquiries' => Lead::count()],
                    'cloudflare_purge' => config('mcp_site.cloudflare.token') && config('mcp_site.cloudflare.zone') ? 'configured' : 'not configured',
                    'last_change' => $last ? ['at' => $last->created_at?->toIso8601String(), 'by' => $last->actor, 'summary' => $last->summary] : null,
                    'tools' => count(ToolRegistry::all()),
                    'versions' => ['php' => PHP_VERSION, 'laravel' => app()->version()],
                ];
            }, readOnly: true),
        ];
    }

    private static function label($m): string
    {
        return match (true) {
            $m instanceof Page => '/' . $m->path,
            $m instanceof PageSection => 'section ' . $m->key . ' of /' . ($m->page()->withTrashed()->value('path') ?? '?'),
            $m instanceof Post => 'blog /' . $m->slug,
            $m instanceof Faq => 'FAQ: ' . mb_substr(strip_tags($m->question), 0, 60),
            $m instanceof Testimonial => 'review by ' . $m->name,
            $m instanceof ClientLogo => 'logo ' . $m->name,
            $m instanceof Media => $m->path,
            $m instanceof PricingPlan => 'plan ' . $m->name,
            $m instanceof Redirect => 'redirect /' . $m->from_path,
            $m instanceof Category, $m instanceof Tag => $m->slug,
            $m instanceof SchemaBlock => $m->schema_type . ' schema',
            $m instanceof Download => 'download ' . $m->key,
            default => class_basename($m) . ' #' . $m->getKey(),
        };
    }

    /** Validate a setting value against the shape of its current value. */
    private static function checkSetting(string $key, mixed $value): mixed
    {
        $current = config('site.' . $key);
        if (in_array($key, self::HTML_SETTINGS, true)) {
            return Support::html((string) $value, 0, $key)[0];
        }
        if ($key === 'offer_bar') {
            if (! is_array($value) || array_diff(['tag', 'text', 'link'], array_keys($value))) {
                throw new ToolError('offer_bar needs {tag, text, link}.');
            }

            return ['tag' => Support::text((string) $value['tag'], 'tag'), 'text' => Support::html((string) $value['text'], 0, 'offer_bar.text')[0], 'link' => Support::text((string) $value['link'], 'link')];
        }
        if (is_array($current)) {
            if (! is_array($value) || ($current && array_is_list($current) !== array_is_list($value))) {
                throw new ToolError("$key must keep the same shape as before (see get_settings).");
            }
            $removed = [];
            array_walk_recursive($value, function (&$v, $k) use ($key) {
                if (is_string($v) && $v !== strip_tags($v)) {
                    throw new ToolError("$key: no HTML inside list values.");
                }
            });

            return $value;
        }
        if (is_array($value)) {
            throw new ToolError("$key takes a single value, not a list.");
        }
        $value = $value === null ? null : (string) $value;
        if ($value !== null && $value !== strip_tags($value)) {
            throw new ToolError("$key must be plain text.");
        }
        if (in_array($key, ['phone_raw'], true) && $value !== null && ! preg_match('/^\+?\d{7,15}$/', $value)) {
            throw new ToolError('phone_raw must be digits with an optional leading + (e.g. +923224765528).');
        }
        if ($key === 'whatsapp' && $value !== null && ! preg_match('/^\d{7,15}$/', $value)) {
            throw new ToolError('whatsapp must be digits only, with country code (e.g. 923224765528).');
        }
        if ($key === 'email' && $value !== null && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ToolError('email is not a valid address.');
        }
        if (in_array($key, ['register_url', 'play_store_url'], true) && $value && ! preg_match('#^https://#', $value)) {
            throw new ToolError("$key must start with https://.");
        }
        if ($key === 'rating_value' && $value !== null && (! is_numeric($value) || $value < 0 || $value > 5)) {
            throw new ToolError('rating_value must be a number from 0 to 5.');
        }
        if ($key === 'robots_extra') {
            throw new ToolError('Use update_robots for robots.txt lines.');
        }

        return $value;
    }
}
