<?php

namespace App\Site;

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
 *   {{embed:N}}      the N-th embedded component of the section (handled by SectionRenderer)
 */
class Tokens
{
    public const NAMES = ['base', 'site_url', 'demo_url', 'wa_link', 'phone', 'phone_raw', 'email', 'address', 'hours', 'register_url', 'whatsapp'];

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

        return preg_replace_callback('/\{\{(' . implode('|', self::NAMES) . ')\}\}/', fn ($m) => e(self::value($m[1])), $s);
    }

    /** Same, unescaped: for meta values (escaped later by the layout) and JSON-LD. */
    public static function resolveRaw(string $s): string
    {
        if (! str_contains($s, '{{')) {
            return $s;
        }

        return preg_replace_callback('/\{\{(' . implode('|', self::NAMES) . ')\}\}/', fn ($m) => self::value($m[1]), $s);
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
