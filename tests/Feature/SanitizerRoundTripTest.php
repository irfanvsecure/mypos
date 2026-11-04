<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\PageSection;
use App\Models\PricingPlan;
use App\Site\HtmlSanitizer;
use App\Site\Tokens;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The MCP write tools run every HTML value through HtmlSanitizer and Tokens::invalid(). This proves that
 * neither would change or reject any content the site has today: every section, slot, component attribute,
 * FAQ, pricing feature and HTML setting (as committed in database/data/site-content.json) comes back
 * byte-identical with only known placeholders.
 */
class SanitizerRoundTripTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('site:import')->assertSuccessful();
        \App\Site\Settings::apply();
    }

    public function test_every_stored_html_value_passes_the_sanitizer_unchanged(): void
    {
        $sanitizer = new HtmlSanitizer();
        $checked = 0;
        $failures = [];

        foreach ($this->htmlValues() as $where => $html) {
            $result = $sanitizer->clean($html);
            $checked++;
            if ($result['html'] !== $html) {
                $failures[] = "$where: would remove " . implode(', ', $result['removed'] ?: ['(escaping only)']);
            }
        }

        $this->assertGreaterThan(500, $checked, 'expected to check every stored HTML value');
        $this->assertSame([], $failures, implode("\n", array_slice($failures, 0, 30)));
    }

    public function test_every_stored_placeholder_is_known(): void
    {
        $failures = [];
        foreach (PageSection::with('page')->get() as $s) {
            foreach ($this->sectionStrings($s->content, "/{$s->page->path} [{$s->key}]") as $where => [$value, $embeds]) {
                if ($bad = Tokens::invalid($value, $embeds)) {
                    $failures[] = "$where: " . implode(' ', $bad);
                }
            }
        }

        $this->assertSame([], $failures, implode("\n", $failures));
    }

    public function test_unknown_placeholders_are_rejected(): void
    {
        $this->assertSame([], Tokens::invalid('{{base}} {{phone}} {{price:retailpro-monthly}} {{download:restropro.version}} {{embed:0}}', 1));
        $this->assertSame(
            ['{{embed:1}}', '{{price:no-such-plan}}', '{{download:restropro.secret}}', '{{ config("app.key") }}', '{{nope}}'],
            Tokens::invalid('{{embed:1}} {{price:no-such-plan}} {{download:restropro.secret}} {{ config("app.key") }} {{nope}}', 1)
        );
    }

    /** @return iterable<string, string> */
    private function htmlValues(): iterable
    {
        foreach (PageSection::with('page')->get() as $s) {
            foreach ($this->sectionStrings($s->content, "/{$s->page->path} [{$s->key}]") as $where => [$value]) {
                if (str_contains($value, '<')) {
                    yield $where => $value;
                }
            }
        }
        foreach (Faq::where('is_html', true)->get() as $f) {
            yield "faq #{$f->id} question" => $f->question;
            yield "faq #{$f->id} answer" => $f->answer;
        }
        foreach (PricingPlan::whereNotNull('features')->get() as $p) {
            foreach ($p->features as $i => $feature) {
                yield "pricing plan #{$p->id} feature $i" => $feature;
            }
        }
        foreach (['offer_bar.text', 'footer_tagline', 'footer_copyright'] as $key) {
            yield "setting $key" => (string) config("site.$key");
        }
    }

    /**
     * Every string in a section's content, with the number of embeds it may reference.
     *
     * @return array<string, array{0:string,1:int}>
     */
    private function sectionStrings(array $content, string $where): array
    {
        $out = [];
        if (isset($content['html'])) {
            $out["$where html"] = [$content['html'], count($content['embeds'] ?? [])];
        }
        foreach ($content['embeds'] ?? [] as $i => $embed) {
            $out += $this->attributeStrings($embed['attributes'] ?? [], "$where embed $i");
            if (isset($embed['slot'])) {
                $out += $this->sectionStrings($embed['slot'], "$where embed $i slot");
            }
        }
        $out += $this->attributeStrings($content['attributes'] ?? [], "$where attribute");
        if (isset($content['slot'])) {
            $out += $this->sectionStrings($content['slot'], "$where slot");
        }

        return $out;
    }

    private function attributeStrings(array $attributes, string $where): array
    {
        $out = [];
        array_walk_recursive($attributes, function ($v, $k) use (&$out, $where) {
            if (is_string($v)) {
                $out["$where $k #" . count($out)] = [$v, 0];
            }
        });

        return $out;
    }
}
