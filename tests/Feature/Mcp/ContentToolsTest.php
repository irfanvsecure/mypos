<?php

namespace Tests\Feature\Mcp;

use App\Models\ClientLogo;
use App\Models\Faq;
use App\Models\PricingPlan;
use App\Models\Testimonial;

class ContentToolsTest extends McpTestCase
{
    public function test_one_price_change_updates_every_page(): void
    {
        $plan = PricingPlan::where('plan_key', 'retailpro-monthly')->first();
        $list = collect($this->tool('list_pricing_plans', ['group' => 'monthly']))->firstWhere('plan_key', 'retailpro-monthly');
        $this->assertContains('/pricing', $list['used_on']);

        $this->tool('update_pricing_plan', ['id' => $plan->id, 'price_pkr' => 2500]);
        $this->assertStringContainsString('Rs. 2,500', $this->html('pricing'));
        $this->assertStringContainsString('Rs. 2,500', $this->html('inventory'));
        $this->assertStringContainsString('data-monthly="2500"', $this->html('/'));

        $this->assertStringContainsString('shown on', $this->toolError('delete_pricing_plan', ['id' => $plan->id]));
    }

    public function test_create_update_delete_pricing_plan(): void
    {
        $r = $this->tool('create_pricing_plan', ['plan_group' => 'home', 'name' => 'Pro', 'badge' => 'NEW', 'price_pkr' => 5000, 'price_label' => 'Rs. 5,000',
            'subtitle' => 'For chains', 'features' => ['Everything in Business', '<script>x</script>Priority support'], 'cta_label' => 'Book a Free Demo', 'cta_url' => '#enquiry', 'cta_style' => 'btn-primary']);
        $this->assertSame(['Everything in Business', 'Priority support'], $r['created']['features']);
        $this->assertStringContainsString('<div class="h3">Pro</div>', $this->html('/'));

        $this->tool('update_pricing_plan', ['id' => $r['created']['id'], 'price_pkr' => 6000]);
        $this->assertSame('Rs. 6,000', PricingPlan::find($r['created']['id'])->price_label);   // label follows the price

        $this->tool('delete_pricing_plan', ['id' => $r['created']['id']]);
        $this->assertStringNotContainsString('<div class="h3">Pro</div>', $this->html('/'));
        $this->assertStringContainsString('cta_url', $this->toolError('create_pricing_plan', ['plan_group' => 'home', 'name' => 'X', 'cta_url' => 'javascript:alert(1)']));
    }

    public function test_faqs_update_the_page_and_structured_data(): void
    {
        $group = collect($this->tool('list_faqs', ['page' => 'car-wash-pos']))->first()['group'];
        $r = $this->tool('create_faq', ['group' => $group, 'question' => 'Does it work offline?', 'answer' => 'Yes, sales sync when back online.', 'position' => 1]);
        $html = $this->html('car-wash-pos');
        $this->assertStringContainsString('Does it work offline?', $html);
        $this->assertMatchesRegularExpression('/"FAQPage".*Does it work offline\?/s', $html);

        $this->tool('update_faq', ['id' => $r['created']['id'], 'answer' => 'Yes — fully offline.', 'position' => 3]);
        $this->assertStringContainsString('Yes — fully offline.', $this->html('car-wash-pos'));

        $this->tool('delete_faq', ['id' => $r['created']['id']]);
        $this->assertStringNotContainsString('Does it work offline?', $this->html('car-wash-pos'));

        // Plain-text groups refuse HTML; the FAQ page's counters follow the table.
        $plain = Faq::where('faq_group', 'like', 'frequently-asked-questions:%')->first();
        $this->assertStringContainsString('plain text', $this->toolError('update_faq', ['id' => $plain->id, 'answer' => '<b>x</b>']));
        $before = Faq::where('faq_group', 'like', 'frequently-asked-questions:%')->count();
        $this->tool('create_faq', ['group' => $plain->faq_group, 'question' => 'New question?', 'answer' => 'New answer.']);
        $this->assertStringContainsString(($before + 1) . ' ANSWERS', $this->html('frequently-asked-questions'));
    }

    public function test_testimonials(): void
    {
        $r = $this->tool('create_testimonial', ['name' => 'Ayesha Malik', 'text' => 'Setup took one day and support answered on WhatsApp within minutes. Very happy with myPOS for our pharmacy chain.', 'sort_order' => 0]);
        $this->assertStringContainsString('Ayesha Malik', $this->html('/'));
        $this->tool('update_testimonial', ['id' => $r['created']['id'], 'visible' => false]);
        $this->assertStringNotContainsString('Ayesha Malik', $this->html('/'));
        $this->tool('delete_testimonial', ['id' => $r['created']['id']]);
        $this->assertSame(1, Testimonial::onlyTrashed()->count());
        $this->assertNotEmpty($this->tool('list_testimonials'));
        $this->assertStringContainsString('plain text', $this->toolError('create_testimonial', ['name' => 'X', 'text' => '<a href="x">spam</a>']));
    }

    public function test_client_logos(): void
    {
        $r = $this->tool('create_client_logo', ['group' => 'proof', 'name' => 'Chemcos Two', 'image' => '2026/07/chemcos-logo-revise.jpeg']);
        $this->assertStringContainsString('alt="Chemcos Two"', $this->html('car-wash-pos'));
        $this->tool('update_client_logo', ['id' => $r['created']['id'], 'name' => 'Chemcos Lahore']);
        $this->assertStringContainsString('alt="Chemcos Lahore"', $this->html('car-wash-pos'));
        $this->tool('delete_client_logo', ['id' => $r['created']['id']]);
        $this->assertSame(5, ClientLogo::where('logo_group', 'proof')->count());
        $this->assertNotEmpty($this->tool('list_client_logos', ['group' => 'proof']));
        $this->assertStringContainsString('Upload it first', $this->toolError('create_client_logo', ['group' => 'proof', 'name' => 'X', 'image' => '../../.env']));
    }

    public function test_downloads(): void
    {
        $this->assertCount(5, $this->tool('list_downloads'));
        $this->tool('update_download', ['key' => 'restropro', 'version' => '2.1', 'file_size' => '75 MB', 'download_count' => 18000, 'updated' => 'November 5, 2026']);
        $this->assertStringContainsString('Version 2.1 · 75 MB · 18,000 downloads', $this->html('download/restropro'));
        $this->assertStringContainsString('v2.1 · 75 MB', $this->html('download/salonpro'));
        $this->assertStringContainsString('<span>Version 2.1</span><span>75 MB</span><span>18,000 downloads</span>', $this->html('downloads'));
        $this->assertStringContainsString('https', $this->toolError('update_download', ['key' => 'restropro', 'file_url' => 'ftp://x']));
    }
}
