<?php

namespace Tests\Feature\Mcp;

use App\Models\Setting;

class LinkToolsTest extends McpTestCase
{
    public function test_internal_links_in_and_out(): void
    {
        $links = $this->tool('get_internal_links', ['page' => 'car-wash-pos']);
        $this->assertContains('/fbr-pos-integration', array_column($links['outbound'], 'url'));
        $this->assertNotEmpty($links['inbound']);
        foreach ($links['outbound'] as $l) {
            $this->assertNotContains($l['section'], ['header', 'footer', 'chrome']);
        }
        $this->assertNotEmpty(array_filter($this->tool('get_internal_links', ['page' => 'car-wash-pos', 'include_header_footer' => true])['outbound'], fn ($l) => $l['section'] === 'header'));
    }

    public function test_add_internal_link_and_refuse_duplicates(): void
    {
        // The text exists in this section and the page does not link to /bakery-pos yet.
        $this->tool('add_internal_link', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'anchor_text' => 'audit risk', 'url' => '/bakery-pos']);
        $this->assertStringContainsString('<a href="' . url('/bakery-pos') . '">audit risk</a>', $this->html('car-wash-pos'));

        // Same URL again on the same page → refused, wherever the anchor is.
        $msg = $this->toolError('add_internal_link', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-security', 'anchor_text' => 'POS', 'url' => '/bakery-pos']);
        $this->assertStringContainsString('already links to /bakery-pos', $msg);

        // Text that is already a link → refused.
        $this->assertStringContainsString('already a link', $this->toolError('add_internal_link',
            ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'anchor_text' => 'audit risk', 'url' => '/garments-pos']));

        // Text that is not there → refused.
        $this->assertStringContainsString('is not in the text', $this->toolError('add_internal_link',
            ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'anchor_text' => 'no such words here', 'url' => '/garments-pos']));

        // Broken target → refused.
        $this->assertStringContainsString('answers 404', $this->toolError('add_internal_link',
            ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-security', 'anchor_text' => 'POS', 'url' => '/no-such-page']));
    }

    public function test_update_and_remove_link_keep_the_text(): void
    {
        $this->tool('add_internal_link', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'anchor_text' => 'audit risk', 'url' => '/bakery-pos']);
        $this->tool('update_internal_link', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'url' => '/bakery-pos', 'new_url' => '/garments-pos', 'new_anchor' => 'audit exposure']);
        $this->assertStringContainsString('<a href="' . url('/garments-pos') . '">audit exposure</a>', $this->html('car-wash-pos'));

        $this->tool('remove_internal_link', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-why-needed', 'url' => '/garments-pos']);
        $html = $this->html('car-wash-pos');
        $this->assertStringContainsString('audit exposure', $html);
        $this->assertStringNotContainsString('">audit exposure</a>', $html);
    }

    public function test_replace_link_sitewide_dry_run_then_apply(): void
    {
        $preview = $this->tool('replace_link_sitewide', ['old_url' => '/multi-location-integration', 'new_url' => '/single-location']);
        $this->assertTrue($preview['dry_run']);
        $this->assertGreaterThan(0, $preview['total_links']);
        $this->assertStringContainsString(url('/multi-location-integration'), $this->html('features'));

        $this->tool('replace_link_sitewide', ['old_url' => '/multi-location-integration', 'new_url' => '/single-location', 'dry_run' => false]);
        $this->assertStringNotContainsString('href="' . url('/multi-location-integration') . '"', $this->html('features'));
        // Footer setting updated too.
        $this->assertStringContainsString('/single-location', json_encode(Setting::where('key', 'footer')->value('value')));
    }

    public function test_anchor_report_orphans_and_broken_links(): void
    {
        $report = $this->tool('anchor_text_report', ['url' => '/fbr-pos-integration']);
        $this->assertNotEmpty($report['links']);

        $orphans = $this->tool('find_orphan_pages');
        $this->assertArrayHasKey('orphans', $orphans);

        $broken = $this->tool('check_broken_links', ['page' => 'paperless-invoicing']);
        $this->assertSame([], $broken['broken']);
        $this->assertNotEmpty($broken['internal_links_through_redirects']);   // old WordPress URLs on that page
    }
}
