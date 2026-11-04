<?php

namespace App\Site;

use App\Models\Download;
use App\Models\PricingPlan;

/**
 * Placeholders stored in section HTML (and component attributes) for values that depend on the request or on
 * site settings. They are filled in at render time, so content in the database never hard-codes the domain,
 * the per-page WhatsApp message, the phone number, etc.
 *
 *   {{base}}         site root as seen by the visitor (what url() / asset() return), e.g. https://mypos.pk
 *   {{site_url}}     config('site.url') — the canonical domain used in structured data
 *   {{demo_url}}     where "Book a free demo" points on this page (#enquiry or /contact#enquiry)
 *   {{wa_link}}      WhatsApp chat link with a message naming the current page
 *   {{phone}} {{phone_raw}} {{email}} {{address}} {{hours}} {{register_url}} {{whatsapp}}  site settings
 *   {{rating_value}} {{rating_count}} {{rating_source}}  customer rating shown on the site (settings)
 *   {{price:key}}    a price from pricing_plans (by plan_key), formatted "2,000"
 *   {{price_plain:key}}  the same without thousands separators, "2000"
 *   {{download:key.field}}  a fact about a download (version, file_size, download_count, file_url, …)
 *   {{embed:N}}      the N-th embedded component of the section (handled by SectionRenderer)
 */
class Tokens
{
    public const NAMES = ['base', 'site_url', 'demo_url', 'wa_link', 'phone', 'phone_raw', 'email', 'address', 'hours', 'register_url', 'whatsapp',
        'rating_value', 'rating_count', 'rating_source'];

    /** Unique strings rendered in place of each value during extraction, turned back into {{tokens}}. */
    public const SENTINELS = [
        'base' => 'http://base.extract.invalid',
        'site_url' => 'http://siteurl.extract.invalid',
        'demo_url' => '%%DEMO_URL%%',
        'wa_link' => '%%WA_LINK%%',
        'phone' => '%%PHONE%%',
        'phone_raw' => '%%PHONE_RAW%%',
        'email' => '%%EMAIL%%',
        'address' => '%%ADDRESS%%',
        'hours' => '%%HOURS%%',
        'register_url' => '%%REGISTER_URL%%',
        'whatsapp' => '%%WHATSAPP%%',
    ];

    public static function value(string $name): string
    {
        return match ($name) {
            'base' => rtrim(url('/'), '/'),
            'site_url' => rtrim((string) config('site.url'), '/'),
            'demo_url' => demo_url(),
            'wa_link' => wa_link(),
            default => (string) config('site.' . $name),
        };
    }

    /** Replace {{tokens}} in a string (HTML-escaped, as the original {{ }} echoes were). Embeds are left alone. */
    public static function resolve(string $s): string
    {
        if (! str_contains($s, '{{')) {
            return $s;
        }

        return preg_replace_callback(self::pattern(), fn ($m) => e(self::match($m)), $s);
    }

    private static function pattern(): string
    {
        return '/\{\{(?:(' . implode('|', self::NAMES) . ')|(price|price_plain):([a-z0-9][a-z0-9-]*)|download:([a-z0-9][a-z0-9-]*)\.([a-z_]+))\}\}/';
    }

    private static function match(array $m): string
    {
        if (($m[1] ?? '') !== '') {
            return self::value($m[1]);
        }
        if (($m[4] ?? '') !== '') {
            return (string) Download::field($m[4], $m[5]);
        }

        return PricingPlan::formatted($m[3], $m[2] === 'price_plain');
    }

    /**
     * Every {{…}} in $s that is not a known placeholder (unknown name, unknown price key, or an embed number
     * with no embed). Write tools reject content for which this is not empty.
     *
     * @return string[]
     */
    public static function invalid(string $s, int $embedCount = 0): array
    {
        preg_match_all('/\{\{\s*(.*?)\s*\}\}/s', $s, $all);
        $bad = [];
        foreach ($all[1] as $i => $inner) {
            $ok = in_array($inner, self::NAMES, true)
                || (preg_match('/^embed:(\d+)$/', $inner, $e) && (int) $e[1] < $embedCount)
                || (preg_match('/^price(?:_plain)?:([a-z0-9][a-z0-9-]*)$/', $inner, $p) && PricingPlan::where('plan_key', $p[1])->exists())
                || (preg_match('/^download:([a-z0-9][a-z0-9-]*)\.([a-z_]+)$/', $inner, $d) && isset(Download::FIELDS[$d[2]]) && Download::where('key', $d[1])->exists());
            if (! $ok) {
                $bad[] = $all[0][$i];
            }
        }

        return array_values(array_unique($bad));
    }

    /** Same, unescaped: for meta values (escaped later by the layout) and JSON-LD. */
    public static function resolveRaw(string $s): string
    {
        if (! str_contains($s, '{{')) {
            return $s;
        }

        return preg_replace_callback(self::pattern(), fn ($m) => self::match($m), $s);
    }

    /** Resolve tokens in every string of a nested array (component attributes). */
    public static function resolveDeep(mixed $v): mixed
    {
        if (is_string($v)) {
            return self::resolve($v);
        }
        if (is_array($v)) {
            return array_map([self::class, 'resolveDeep'], $v);
        }

        return $v;
    }

    /** Extraction: sentinel strings → {{tokens}}. */
    public static function tokenize(mixed $v): mixed
    {
        if (is_array($v)) {
            return array_map([self::class, 'tokenize'], $v);
        }
        if (! is_string($v)) {
            return $v;
        }
        foreach (self::SENTINELS as $name => $sentinel) {
            $v = str_replace($sentinel, '{{' . $name . '}}', $v);
        }

        return $v;
    }
}
