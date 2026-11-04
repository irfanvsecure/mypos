<?php

namespace Tests\Feature\Mcp;

use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\Redirect;

class PageToolsTest extends McpTestCase
{
    public function test_list_and_get_pages(): void
    {
        $pages = $this->tool('list_pages');
        $this->assertCount(Page::count(), $pages);
        $this->assertNotEmpty($this->tool('list_pages', ['search' => 'car-wash']));

        $page = $this->tool('get_page', ['page' => 'home']);
        $this->assertSame('', $page['path']);
        $this->assertNotEmpty($page['sections']);
        $this->assertNotEmpty($this->tool('list_components'));
    }

    public function test_create_update_delete_restore_page(): void
    {
        $r = $this->tool('create_page', ['path' => 'pharmacy-pos', 'name' => 'Pharmacy POS', 'title' => 'Pharmacy POS in Pakistan', 'copy_sections_from' => 'car-wash-pos']);
        $this->assertSame('draft', $r['status']);
        $this->get('/pharmacy-pos')->assertNotFound();            // drafts are not public

        $this->assertStringContainsString('already uses', $this->toolError('create_page', ['path' => 'car-wash-pos', 'name' => 'x']));
        $this->assertStringContainsString('not a valid URL path', $this->toolError('create_page', ['path' => 'Bad Path!', 'name' => 'x']));
        $this->assertStringContainsString('reserved', $this->toolError('create_page', ['path' => 'blogs', 'name' => 'x']));

        $this->tool('update_page', ['page' => 'pharmacy-pos', 'status' => 'published']);
        $this->assertStringContainsString('Car Wash POS Software', $this->html('pharmacy-pos'));

        // Moving a published page adds a 301 from the old URL.
        $r = $this->tool('update_page', ['page' => 'pharmacy-pos', 'path' => 'pharmacy-pos-software']);
        $this->assertSame('/pharmacy-pos → /pharmacy-pos-software (301)', $r['redirect_added']);
        $this->get('/pharmacy-pos')->assertRedirect(url('/pharmacy-pos-software'));

        $this->tool('delete_page', ['page' => 'pharmacy-pos-software']);
        $this->get('/pharmacy-pos-software')->assertNotFound();
        $this->assertStringContainsString('cannot be deleted', $this->toolError('delete_page', ['page' => 'home']));

        $id = Page::onlyTrashed()->where('path', 'pharmacy-pos-software')->value('id');
        $this->tool('restore_item', ['type' => 'page', 'id' => $id]);
        $this->get('/pharmacy-pos-software')->assertOk();
        $this->assertTrue(ActivityLog::where('action', 'page.create')->exists());
    }

    public function test_deleting_a_page_does_not_fall_back_to_its_old_blade_file(): void
    {
        $this->get('/privacy-policy')->assertOk();
        $this->tool('delete_page', ['page' => 'privacy-policy']);
        $this->get('/privacy-policy')->assertNotFound();
        $this->assertStringNotContainsString('/privacy-policy<', $this->get('/sitemap.xml')->getContent());
    }

    public function test_section_update_keeps_revisions_and_restores(): void
    {
        $s = collect($this->tool('get_page_sections', ['page' => 'car-wash-pos']))->firstWhere('key', 'car-wash-pos-why-needed');
        $html = $s['content']['html'];

        $r = $this->tool('update_page_section', ['page' => 'car-wash-pos', 'section' => $s['key'], 'expected_updated_at' => $s['updated_at'],
            'html' => str_replace('</h2>', ' — updated</h2>', $html) . '<script>alert(1)</script>', 'reason' => 'test edit']);
        $this->assertContains('<script> element', $r['sanitizer_removed']);
        $page = $this->html('car-wash-pos');
        $this->assertStringContainsString('— updated', $page);
        $this->assertStringNotContainsString('alert(1)', $page);

        // A stale stamp is refused.
        $this->assertStringContainsString('changed since you read it', $this->toolError('update_page_section', ['page' => 'car-wash-pos', 'section' => $s['key'],
            'html' => $html, 'expected_updated_at' => '2000-01-01T00:00:00+00:00']));
        // Unknown placeholders are refused.
        $this->assertStringContainsString('unknown placeholders', $this->toolError('update_page_section', ['page' => 'car-wash-pos', 'section' => $s['key'], 'html' => '<p>{{ config("app.key") }}</p>']));

        $revs = $this->tool('list_section_revisions', ['page' => 'car-wash-pos', 'section' => $s['key']]);
        $this->assertSame('test edit', $revs[0]['reason'] ?? null) ?: null;
        $this->tool('restore_section_revision', ['page' => 'car-wash-pos', 'section' => $s['key'], 'revision_id' => end($revs)['revision_id']]);
        $this->assertStringNotContainsString('— updated', $this->html('car-wash-pos'));
    }

    public function test_add_reorder_hide_and_delete_sections(): void
    {
        $this->tool('add_page_section', ['page' => 'about-us', 'key' => 'team-note', 'type' => 'html', 'html' => '<section><div class="wrap"><p>Team note {{phone}}</p></div></section>', 'after' => 'page-header']);
        $this->assertStringContainsString('Team note ' . config('site.phone'), $this->html('about-us'));

        $this->tool('add_page_section', ['page' => 'about-us', 'key' => 'cta-extra', 'type' => 'component', 'component' => 'mid-cta', 'attributes' => ['text' => 'Extra CTA text']]);
        $this->assertStringContainsString('Extra CTA text', $this->html('about-us'));
        $this->assertStringContainsString('Unknown component', $this->toolError('add_page_section', ['page' => 'about-us', 'key' => 'x', 'type' => 'component', 'component' => '../../.env']));

        $keys = array_column($this->tool('get_page_sections', ['page' => 'about-us']), 'key');
        $this->tool('reorder_page_sections', ['page' => 'about-us', 'order' => array_reverse($keys)]);
        $this->assertSame(array_reverse($keys), array_column($this->tool('get_page_sections', ['page' => 'about-us']), 'key'));
        $this->assertStringContainsString('exactly once', $this->toolError('reorder_page_sections', ['page' => 'about-us', 'order' => ['team-note']]));

        $this->tool('toggle_section_visibility', ['page' => 'about-us', 'section' => 'team-note', 'visible' => false]);
        $this->assertStringNotContainsString('Team note', $this->html('about-us'));

        $this->tool('delete_page_section', ['page' => 'about-us', 'section' => 'cta-extra']);
        $this->assertStringNotContainsString('Extra CTA text', $this->html('about-us'));
    }

    public function test_search_and_replace_text(): void
    {
        $this->assertNotEmpty($this->tool('search_content', ['query' => 'car wash']));

        $preview = $this->tool('replace_text', ['find' => 'Car Wash POS Software', 'replace' => 'Car Wash Billing Software', 'page' => 'car-wash-pos']);
        $this->assertTrue($preview['dry_run']);
        $this->assertGreaterThan(0, $preview['matches']);
        $this->assertStringContainsString('Car Wash POS Software', $this->html('car-wash-pos'));   // nothing changed yet

        $this->tool('replace_text', ['find' => 'Car Wash POS Software', 'replace' => 'Car Wash Billing Software', 'page' => 'car-wash-pos', 'dry_run' => false]);
        $html = $this->html('car-wash-pos');
        $this->assertStringContainsString('Car Wash Billing Software', $html);
        $this->assertStringContainsString('href="' . url('/fbr-pos-integration') . '"', $html);   // links untouched
    }

    public function test_headings_outline_update_and_audit(): void
    {
        $outline = $this->tool('get_page_outline', ['page' => 'car-wash-pos']);
        $h1 = collect($outline['headings'])->firstWhere('level', 1);
        $this->assertSame('Car Wash POS Software with FBR & PRA Integration in Pakistan', $h1['text']);
        $this->assertGreaterThan(500, $outline['words']['content_total']);

        $this->tool('update_heading', ['page' => 'car-wash-pos', 'section' => 'car-wash-pos-fbr-integration',
            'old_text' => 'Car Wash FBR POS Integration Service in Pakistan.', 'new_text' => 'Car Wash FBR Integration in Pakistan', 'level' => 3]);
        $this->assertStringContainsString('<h3>Car Wash FBR Integration in Pakistan</h3>', $this->html('car-wash-pos'));

        // Inline markup inside a heading is kept (home H1 has a <span class="hx-hl">).
        $this->tool('update_heading', ['page' => '', 'section' => 'home', 'old_text' => 'Free POS Software for Retail, Restaurant, & Salon Businesses in Pakistan',
            'new_text' => 'Free POS Software for Retail, Restaurant, & Salon Shops in Pakistan']);
        $this->assertStringContainsString('<h1><span class="hx-hl">Free POS Software</span> for Retail, Restaurant, &amp; Salon Shops in Pakistan</h1>', $this->html('/'));

        $this->assertStringContainsString('No heading reading', $this->toolError('update_heading', ['page' => 'car-wash-pos', 'section' => 'ind-hero', 'old_text' => 'Nope', 'new_text' => 'x']));
        $audit = $this->tool('audit_headings', ['page' => 'car-wash-pos']);
        $this->assertSame(1, $audit['checked']);
    }
}
