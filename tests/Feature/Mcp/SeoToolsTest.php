<?php

namespace Tests\Feature\Mcp;

use App\Models\Redirect;
use App\Models\SchemaBlock;

class SeoToolsTest extends McpTestCase
{
    public function test_get_and_update_seo_with_noindex_forced_before_launch(): void
    {
        $seo = $this->tool('get_seo', ['ref' => 'car-wash-pos']);
        $this->assertTrue($seo['site_noindex']);

        $r = $this->tool('update_seo', ['ref' => 'car-wash-pos', 'title' => 'Car Wash POS Software in Pakistan | FBR & PRA Ready',
            'og_title' => 'Car Wash POS for Pakistan', 'twitter_card' => 'summary', 'focus_keyword' => 'car wash pos', 'robots' => 'index, follow']);
        $this->assertSame('Car Wash POS Software in Pakistan | FBR & PRA Ready', $r['after']['title']);
        $this->assertNotEmpty(array_filter($r['warnings'], fn ($w) => str_contains($w, 'SITE_NOINDEX')));

        $html = $this->html('car-wash-pos');
        $this->assertStringContainsString('<title>Car Wash POS Software in Pakistan | FBR &amp; PRA Ready</title>', $html);
        $this->assertStringContainsString('<meta property="og:title" content="Car Wash POS for Pakistan" />', $html);
        $this->assertStringContainsString('<meta name="twitter:card" content="summary" />', $html);
        $this->assertStringContainsString('<meta name="robots" content="noindex, nofollow" />', $html);   // still forced

        config(['site.noindex' => false]);
        $this->assertStringContainsString('<meta name="robots" content="index, follow" />', $this->html('car-wash-pos'));

        $this->assertStringContainsString('robots', $this->toolError('update_seo', ['ref' => 'car-wash-pos', 'robots' => 'all']));
        $this->assertStringContainsString('plain text', $this->toolError('update_seo', ['ref' => 'car-wash-pos', 'title' => '<b>x</b>']));
    }

    public function test_exclude_from_sitemap_and_bulk_update(): void
    {
        $this->tool('update_seo', ['ref' => 'cookie-policy', 'exclude_from_sitemap' => true]);
        $this->assertStringNotContainsString('/cookie-policy<', $this->get('/sitemap.xml')->getContent());

        $r = $this->tool('bulk_update_seo', ['items' => [
            ['ref' => 'bakery-pos', 'description' => 'Bakery POS software for Pakistan with FBR invoicing, recipe costing, expiry tracking and multi-branch stock. Free demo, setup in days.'],
            ['type' => 'post', 'ref' => 'retail-pos-reports-check-weekly', 'title' => 'Retail POS Reports to Check Every Week'],
            ['type' => 'category', 'ref' => 'retail', 'title' => 'Retail POS Guides — myPOS Blog'],
        ]]);
        $this->assertSame(3, $r['updated']);
        $this->assertStringContainsString('recipe costing', $this->html('bakery-pos'));
        $this->assertStringContainsString('<title>Retail POS Reports to Check Every Week</title>', $this->html('retail-pos-reports-check-weekly'));
        $this->assertStringContainsString('<title>Retail POS Guides — myPOS Blog</title>', $this->html('blogs?topic=retail'));
    }

    public function test_audits_and_report(): void
    {
        $meta = $this->tool('audit_meta');
        $this->assertGreaterThan(100, $meta['pages_checked']);
        $this->assertNotEmpty($this->tool('audit_seo', ['page' => 'pricing'])['pages']);

        $this->tool('update_seo', ['ref' => 'car-wash-pos', 'focus_keyword' => 'car wash pos']);
        $report = $this->tool('seo_report', ['page' => 'car-wash-pos']);
        $this->assertTrue($report['keyword_checks']['in_h1']);
        $this->assertContains('FAQPage', $report['schema_types']);
        $this->assertNotEmpty($report['outline']);
        $this->assertNotEmpty($report['first_paragraph']);
    }

    public function test_schema_get_generate_update_delete(): void
    {
        $s = $this->tool('get_schema', ['page' => '']);
        $this->assertSame('SoftwareApplication', $s['stored_blocks'][0]['type']);
        $this->assertArrayNotHasKey('aggregateRating', $s['stored_blocks'][0]['json']);

        $gen = $this->tool('generate_schema', ['page' => 'restro-pos', 'type' => 'SoftwareApplication', 'plan_group' => 'one-time', 'save' => true]);
        $this->assertSame('PKR', $gen['json']['offers'][0]['priceCurrency']);
        $this->assertStringContainsString('"@type":"SoftwareApplication"', str_replace(["\n", ' '], '', $this->html('restro-pos')));
        $this->assertStringContainsString('already outputs', $this->toolError('generate_schema', ['page' => 'restro-pos', 'type' => 'SoftwareApplication']));
        $this->assertStringContainsString('already outputs', $this->toolError('generate_schema', ['page' => 'car-wash-pos', 'type' => 'FAQPage']));

        $id = $gen['saved_block_id'];
        $self = '{"@context":"https://schema.org","@type":"SoftwareApplication","name":"myPOS","aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"12000"}}';
        $this->assertStringContainsString('self-serving', $this->toolError('update_schema', ['id' => $id, 'json' => $self]));
        $this->assertStringContainsString('@context', $this->toolError('update_schema', ['id' => $id, 'json' => '{"name":"x"}']));

        $this->tool('update_schema', ['id' => $id, 'active' => false]);
        $this->assertStringNotContainsString('"name": "Restro POS', $this->html('restro-pos'));
        $this->tool('delete_schema', ['id' => $id]);
        $this->assertSame(1, SchemaBlock::onlyTrashed()->count());
    }

    public function test_redirects(): void
    {
        $this->assertNotEmpty($this->tool('list_redirects'));
        $this->tool('save_redirect', ['from' => '/old-pricing', 'to' => '/pricing']);
        $this->get('/old-pricing')->assertRedirect(url('/pricing'));

        // A redirect to a redirect is shortened to the final target.
        $this->tool('save_redirect', ['from' => '/older-pricing', 'to' => '/old-pricing']);
        $this->assertSame('/pricing', Redirect::where('from_path', 'older-pricing')->value('to_url'));

        $this->assertStringContainsString('loop', $this->toolError('save_redirect', ['from' => '/pricing-x', 'to' => '/pricing-x']));
        $this->assertStringContainsString('live page', $this->toolError('save_redirect', ['from' => '/pricing', 'to' => '/contact']));
        $this->assertStringContainsString('404', $this->toolError('save_redirect', ['from' => '/a-b-c', 'to' => '/no-such-page']));

        $this->tool('save_redirect', ['from' => '/spam-page', 'code' => 410]);
        $this->get('/spam-page')->assertStatus(410);

        $this->tool('delete_redirect', ['from' => '/old-pricing']);
        $this->get('/old-pricing')->assertNotFound();
    }

    public function test_sitemap_and_robots(): void
    {
        $v = $this->tool('validate_sitemap_robots');
        $this->assertTrue($v['site_noindex']);
        $this->assertSame([], $v['problems']);
        $this->assertSame('public/robots.txt', $v['robots_source']);
        $this->assertStringContainsString('Disallow: /enquiry', $v['robots_txt']);
        $this->assertStringNotContainsString('Sitemap:', \App\Site\Robots::text());

        $this->tool('update_robots', ['lines' => "User-agent: GPTBot\nDisallow: /"]);
        $this->assertStringContainsString("User-agent: GPTBot\nDisallow: /", $this->get('/robots.txt')->getContent());
        $this->assertStringContainsString('Not a robots.txt rule', $this->toolError('update_robots', ['lines' => '<script>']));
    }
}
