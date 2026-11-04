<?php

namespace Tests\Feature\Mcp;

use App\Models\ActivityLog;
use App\Models\Lead;
use App\Models\PageSection;

class SiteToolsTest extends McpTestCase
{
    public function test_settings(): void
    {
        $this->assertSame('+92 322 476 5528', $this->tool('get_settings', ['key' => 'phone'])[0]['value']);
        $r = $this->tool('update_settings', ['values' => ['phone' => '+92 300 1112233', 'phone_raw' => '+923001112233', 'rating_value' => '4.8']]);
        $this->assertCount(3, $r['changed']);
        $html = $this->html('car-wash-pos');
        $this->assertStringContainsString('+92 300 1112233', $html);
        $this->assertStringContainsString('tel:+923001112233', $html);
        $this->assertStringContainsString('4.8/5', $html);
        $this->assertStringNotContainsString('4.9/5', $html);

        $this->assertStringContainsString('Unknown setting', $this->toolError('update_settings', ['values' => ['app_key' => 'x']]));
        $this->assertStringContainsString('valid address', $this->toolError('update_settings', ['values' => ['email' => 'nope']]));
        $this->assertStringContainsString('same shape', $this->toolError('update_settings', ['values' => ['menu' => 'flat text']]));
        $this->assertStringContainsString('0 to 5', $this->toolError('update_settings', ['values' => ['rating_value' => '9']]));
    }

    public function test_enquiries_are_read_only_without_contact_details(): void
    {
        Lead::create(['name' => 'Bilal', 'business' => 'Bilal Mart', 'phone' => '03001234567', 'email' => 'b@example.com', 'type' => 'Free Demo', 'message' => 'Need a demo', 'page' => 'pricing', 'ip' => '1.2.3.4']);
        $r = $this->tool('list_enquiries', ['type' => 'Free Demo']);
        $this->assertSame(1, $r['total_matching']);
        $row = $r['enquiries'][0];
        $this->assertSame(['id', 'date', 'name', 'business', 'type', 'message', 'page'], array_keys($row));
        $this->assertStringNotContainsString('03001234567', json_encode($r));
        $this->assertStringNotContainsString('b@example.com', json_encode($r));

        $names = array_map(fn ($t) => $t->name(), \App\Mcp\ToolRegistry::all());
        foreach ($names as $n) {
            $this->assertDoesNotMatchRegularExpression('/(update|delete|create|export|purge)_enquir|lead/', $n);
        }
    }

    public function test_trash_restore_purge_and_activity_log(): void
    {
        $this->tool('delete_page_section', ['page' => 'about-us', 'section' => 'stats-band']);
        $trash = $this->tool('list_trash', ['type' => 'section']);
        $this->assertCount(1, $trash);

        $this->tool('restore_item', ['type' => 'section', 'id' => $trash[0]['id']]);
        $this->assertSame(0, PageSection::onlyTrashed()->count());

        $this->tool('delete_page_section', ['page' => 'about-us', 'section' => 'stats-band']);
        $this->assertStringContainsString('confirm', $this->toolError('purge_item', ['type' => 'section', 'id' => $trash[0]['id'], 'confirm' => false]));
        $this->tool('purge_item', ['type' => 'section', 'id' => $trash[0]['id'], 'confirm' => true]);
        $this->assertNull(PageSection::withTrashed()->find($trash[0]['id']));

        $log = $this->tool('activity_log', ['limit' => 5]);
        $this->assertSame('section.purge', $log[0]['action']);
        $this->assertSame('mcp', $log[0]['by']);
        $this->assertTrue(ActivityLog::where('action', 'section.restore')->exists());
    }

    public function test_cache_performance_and_site_info(): void
    {
        $this->assertSame('cleared', $this->tool('clear_cache')['cache']);
        $perf = $this->tool('audit_performance', ['page' => '']);
        $this->assertGreaterThan(0, $perf['html_kb']);
        $info = $this->tool('get_site_info');
        $this->assertTrue($info['site_noindex']);
        $this->assertSame(count(\App\Mcp\ToolRegistry::all()), $info['tools']);
    }
}
