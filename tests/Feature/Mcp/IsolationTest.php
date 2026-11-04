<?php

namespace Tests\Feature\Mcp;

use App\Mcp\ToolRegistry;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The MCP manages the marketing website only. This proves it cannot read POS-application data: POS-style tables
 * are created next to the website tables, every tool is run while all SQL is recorded, and no query may touch a
 * table outside the website allow-list (and no tool output may contain the POS rows).
 */
class IsolationTest extends McpTestCase
{
    /** Tables the MCP is allowed to touch. */
    private const ALLOWED = ['pages', 'page_sections', 'section_revisions', 'seo_meta', 'schema_blocks', 'categories', 'tags', 'post_tag',
        'posts', 'clients', 'media', 'redirects', 'pricing_plans', 'faqs', 'testimonials', 'client_logos', 'downloads', 'settings',
        'activity_log', 'leads', 'cache', 'cache_locks'];

    /** Stand-ins for the POS application's data. */
    private const POS_TABLES = ['tenants', 'pos_sales', 'pos_invoices', 'fbr_submissions', 'licences', 'users'];

    private const MARKER = 'POS-PRIVATE-7f3a9c';

    protected function setUp(): void
    {
        parent::setUp();
        foreach (self::POS_TABLES as $t) {
            if (! Schema::hasTable($t)) {
                Schema::create($t, function (Blueprint $b) {
                    $b->id();
                    $b->string('name')->nullable();
                    $b->string('email')->nullable();
                    $b->string('password')->nullable();
                    $b->timestamps();
                });
            }
            DB::table($t)->insert(['name' => self::MARKER, 'email' => self::MARKER . '@pos.example', 'password' => self::MARKER]);
        }
    }

    public function test_no_tool_has_raw_sql_shell_file_or_env_access(): void
    {
        foreach (ToolRegistry::all() as $t) {
            $this->assertDoesNotMatchRegularExpression('/sql|query|shell|exec|command|artisan|env|file_write|write_file|eval|pos_data|tenant|licen[cs]e|invoice_data/', $t->name());
        }
    }

    public function test_tools_only_touch_website_tables_and_never_return_pos_data(): void
    {
        $tables = [];
        DB::listen(function ($q) use (&$tables) {
            preg_match_all('/\b(?:from|into|update|join|table)\s+["`]?([a-z_]+)["`]?/i', $q->sql, $m);
            foreach ($m[1] as $t) {
                $tables[strtolower($t)] = $q->sql;
            }
        });

        $outputs = [];
        foreach ($this->calls() as [$name, $args]) {
            $outputs[$name] = json_encode($this->tool($name, $args));
        }

        // SQLite schema look-ups (column info) are fine only when they inspect a website table.
        foreach (['main', 'sqlite_master', 'pragma_table_info', 'pragma_table_xinfo'] as $meta) {
            if (isset($tables[$meta])) {
                preg_match("/(?:name = |pragma_table_x?info\\()'([a-z_]+)'/", $tables[$meta], $inspected);
                $this->assertContains($inspected[1] ?? '?', self::ALLOWED, "Schema query on a non-website table: {$tables[$meta]}");
                unset($tables[$meta]);
            }
        }
        $outside = array_diff(array_keys($tables), self::ALLOWED);
        $this->assertSame([], array_values($outside), 'Queries outside the website tables: ' . json_encode(array_intersect_key($tables, array_flip($outside))));
        foreach (self::POS_TABLES as $t) {
            $this->assertArrayNotHasKey($t, $tables, "A tool queried the POS table $t");
        }
        foreach ($outputs as $name => $out) {
            $this->assertStringNotContainsString(self::MARKER, $out, "$name returned POS data");
        }
        $this->assertGreaterThanOrEqual(60, count($outputs));
    }

    /** Every tool, with arguments that make it do real work (writes included). */
    private function calls(): array
    {
        $plan = \App\Models\PricingPlan::where('plan_key', 'addon-offline')->value('id');
        $faq = \App\Models\Faq::first();
        $post = \App\Models\Post::published()->first()->slug;

        return [
            ['list_pages', []], ['get_page', ['page' => 'pricing']], ['get_page_sections', ['page' => 'pricing']], ['list_components', []],
            ['search_content', ['query' => 'POS']], ['replace_text', ['find' => 'POS', 'replace' => 'POS']],
            ['create_page', ['path' => 'iso-test', 'name' => 'Iso']], ['update_page', ['page' => 'iso-test', 'name' => 'Iso 2']],
            ['add_page_section', ['page' => 'iso-test', 'key' => 's1', 'type' => 'html', 'html' => '<section><h1>Iso</h1><p>Text here</p></section>']],
            ['update_page_section', ['page' => 'iso-test', 'section' => 's1', 'html' => '<section><h1>Iso</h1><p>Text there</p></section>']],
            ['list_section_revisions', ['page' => 'iso-test', 'section' => 's1']], ['toggle_section_visibility', ['page' => 'iso-test', 'section' => 's1', 'visible' => true]],
            ['reorder_page_sections', ['page' => 'iso-test', 'order' => ['s1']]],
            ['get_page_outline', ['page' => 'pricing']], ['audit_headings', ['page' => 'pricing']],
            ['update_heading', ['page' => 'iso-test', 'section' => 's1', 'old_text' => 'Iso', 'new_text' => 'Isolation']],
            ['get_internal_links', ['page' => 'pricing']], ['anchor_text_report', ['url' => '/pricing']], ['check_broken_links', ['page' => 'pricing']],
            ['find_orphan_pages', []], ['replace_link_sitewide', ['old_url' => '/reports', 'new_url' => '/sales']],
            ['list_pricing_plans', []], ['update_pricing_plan', ['id' => $plan, 'price_pkr' => 500]],
            ['list_faqs', ['page' => 'car-wash-pos']], ['update_faq', ['id' => $faq->id, 'visible' => true]],
            ['list_testimonials', []], ['list_client_logos', []], ['list_downloads', []], ['update_download', ['key' => 'restropro', 'version' => '2.0']],
            ['list_blogs', []], ['get_blog', ['slug' => $post]], ['list_stale_posts', []], ['list_categories', []], ['list_tags', []],
            ['create_tag', ['name' => 'Iso tag']], ['set_blog_taxonomies', ['slug' => $post, 'tags' => ['Iso tag']]],
            ['list_images', ['limit' => 3]], ['audit_images', ['page' => 'pricing']],
            ['get_seo', ['ref' => 'pricing']], ['update_seo', ['ref' => 'iso-test', 'title' => 'Iso page']], ['seo_report', ['page' => 'pricing']],
            ['audit_seo', ['page' => 'pricing']], ['audit_meta', []], ['get_schema', ['page' => '']],
            ['generate_schema', ['page' => 'iso-test', 'type' => 'Product']],
            ['list_redirects', []], ['save_redirect', ['from' => '/iso-old', 'to' => '/pricing']], ['delete_redirect', ['from' => '/iso-old']],
            ['validate_sitemap_robots', []], ['update_robots', ['lines' => '# test']],
            ['get_settings', []], ['update_settings', ['values' => ['hours' => config('site.hours')]]], ['list_enquiries', []],
            ['delete_page_section', ['page' => 'iso-test', 'section' => 's1']], ['list_trash', []], ['delete_page', ['page' => 'iso-test']],
            ['activity_log', ['limit' => 5]], ['clear_cache', []], ['audit_performance', ['page' => 'pricing']], ['get_site_info', []],
        ];
    }
}
