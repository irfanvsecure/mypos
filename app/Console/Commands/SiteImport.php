<?php

namespace App\Console\Commands;

use App\Http\Middleware\SiteRedirects;
use App\Site\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Loads database/data/site-content.json (written by `site:export`) into the website tables.
 * Refuses to touch a site that already has pages unless --force is given (which replaces the website tables).
 */
class SiteImport extends Command
{
    protected $signature = 'site:import {--file= : Input file (default database/data/site-content.json)} {--force : Replace existing website content}';

    protected $description = 'Import the website content tables from JSON';

    public function handle(): int
    {
        $file = $this->option('file') ?: database_path('data/site-content.json');
        $data = json_decode(File::get($file), true);
        if (! isset($data['tables'])) {
            $this->error("$file is not a site:export file.");
            return self::FAILURE;
        }

        if (DB::table('pages')->exists() && ! $this->option('force')) {
            $this->error('The pages table already has content. Use --force to replace all website content.');
            return self::FAILURE;
        }

        DB::transaction(function () use ($data) {
            foreach (array_reverse(SiteExport::TABLES) as $table) {
                DB::table($table)->delete();
            }
            foreach (SiteExport::TABLES as $table) {
                foreach (array_chunk($data['tables'][$table] ?? [], 200) as $chunk) {
                    DB::table($table)->insert($chunk);
                }
                $this->line(sprintf('%-15s %d rows', $table, count($data['tables'][$table] ?? [])));
            }
        });

        Settings::flush();
        SiteRedirects::flush();
        $this->info('Imported. Run `php artisan optimize:clear` if caches are in use.');

        return self::SUCCESS;
    }
}
