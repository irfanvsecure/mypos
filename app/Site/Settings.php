<?php

namespace App\Site;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Site settings stored in the settings table. On every request the stored values replace the matching
 * config('site.*') defaults, so all existing views (header, footer, contact blocks…) pick them up unchanged.
 */
class Settings
{
    private const CACHE_KEY = 'site.settings.v1';

    /** Editable keys => what they control. Anything else in config/site.php stays code-only. */
    public const KEYS = [
        'phone' => 'Phone number as displayed, e.g. +92 322 476 5528',
        'phone_raw' => 'Phone number for tel: links, digits with leading +',
        'whatsapp' => 'WhatsApp number for wa.me links, digits only',
        'email' => 'Contact email address',
        'address' => 'Office address',
        'hours' => 'Support hours text',
        'register_url' => 'Free-trial sign-up URL (14-day trial CTA)',
        'free_download' => 'Download link of the free version',
        'clients_total' => 'Number of businesses shown on the client logo strip',
        'play_store_url' => 'Google Play link of the myPOS mobile app (empty = demo button)',
        'app_screenshot' => 'Mobile app screenshot under public/ (empty = built-in mockup)',
        'enquiry_types' => 'Options of the "Enquiry type" field on contact forms (list of strings)',
        'no_lead_form' => 'Paths whose CTA band shows buttons instead of the demo form ("*" = prefix)',
        'menu' => 'Header navigation menu (list of menus; see config/site.php for the shape)',
        'footer' => 'Footer link columns: {heading: [[label, url], …]}',
        'legal' => 'Footer legal links: [[label, url], …]',
        'default_title' => 'Meta title for pages that set none',
        'default_description' => 'Meta description for pages that set none',
        'offer_bar' => 'Top offer bar: {tag, text (HTML), link}',
        'footer_tagline' => 'Footer text under the logo (HTML)',
        'footer_since' => 'First year in the footer copyright',
        'footer_copyright' => 'Footer copyright text after the years (HTML)',
        'rating_value' => 'Average customer rating shown across the site, e.g. 4.9 (out of 5)',
        'rating_count' => 'Number of ratings behind rating_value (stored for reference; not shown on pages today)',
        'robots_extra' => 'Extra robots.txt lines added after the built-in rules (plain text)',
        'rating_source' => 'Where rating_value comes from, e.g. Google reviews (stored for reference)',
    ];

    /** Load stored settings over config('site.*'). Safe to call before the table exists. */
    public static function apply(): void
    {
        try {
            $values = Cache::rememberForever(self::CACHE_KEY, fn () => Setting::pluck('value', 'key')->all());
        } catch (\Throwable) {
            return; // not migrated yet
        }
        foreach ($values as $key => $value) {
            if (array_key_exists($key, self::KEYS)) {
                config(['site.' . $key => $value]);
            }
        }
    }

    /** Save a setting and apply it to this request too (so pages rendered next already use it). */
    public static function set(string $key, mixed $value): Setting
    {
        $s = Setting::withTrashed()->firstOrNew(['key' => $key]);
        $s->fill(['value' => $value, 'description' => self::KEYS[$key] ?? $s->description, 'deleted_at' => null])->save();
        config(['site.' . $key => $value]);
        self::flush();

        return $s;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /** Copy the current config values into the table (only keys not stored yet). */
    public static function seedFromConfig(): int
    {
        $n = 0;
        foreach (self::KEYS as $key => $description) {
            if (! Setting::withTrashed()->where('key', $key)->exists()) {
                Setting::create(['key' => $key, 'value' => config('site.' . $key), 'description' => $description]);
                $n++;
            }
        }
        self::flush();

        return $n;
    }
}
