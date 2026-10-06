<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Imports the blog posts and client portfolio migrated from the old WordPress site
 * (database/data/*.json). Safe to re-run: rows are matched on slug.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = json_decode(file_get_contents(database_path('data/posts.json')), true);
        foreach ($posts as $p) {
            $updated = $p['updated_at'] ?? null;
            unset($p['updated_at']);
            $post = Post::updateOrCreate(['slug' => $p['slug']], $p);
            if ($updated) {
                $post->timestamps = false;
                $post->forceFill(['updated_at' => $updated])->save();
            }
        }

        $clients = json_decode(file_get_contents(database_path('data/clients.json')), true);
        foreach ($clients as $i => $c) {
            Client::updateOrCreate(['slug' => $c['slug']], $c + ['sort' => $i]);
        }

        $this->command?->info(count($posts) . ' posts, ' . count($clients) . ' clients imported.');
    }
}
