<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Writes the website content tables to database/data/site-content.json, so the content travels with the code
 * (the SQLite file is not committed). `site:import` loads it on another server.
 */
class SiteExport extends Command
{
    /** Website tables in insert order (parents first). Posts and clients come from ContentSeeder. */
    public const TABLES = ['pages', 'page_sections', 'seo_meta', 'schema_blocks', 'categories', 'tags', 'post_tag', 'media',
        'redirects', 'pricing_plans', 'faqs', 'testimonials', 'client_logos', 'downloads', 'settings'];

    protected $signature = 'site:export {--file= : Output file (default database/data/site-content.json)}';

    protected $description = 'Export the website content tables to JSON';

    public function handle(): int
    {
        $out = ['exported_at' => now()->toIso8601String(), 'tables' => []];
        foreach (self::TABLES as $table) {
            $q = DB::table($table);
            $cols = DB::getSchemaBuilder()->getColumnListing($table);
            if (in_array('id', $cols, true)) {
                $q->orderBy('id');
            }
            $out['tables'][$table] = $q->get()->map(fn ($r) => (array) $r)->all();
            $this->line(sprintf('%-15s %d rows', $table, count($out['tables'][$table])));
        }

        $file = $this->option('file') ?: database_path('data/site-content.json');
        File::put($file, json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        $this->info("Written to $file");

        return self::SUCCESS;
    }
}
