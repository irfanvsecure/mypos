<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_meta', function (Blueprint $t) {
            $t->string('focus_keyword', 120)->nullable()->after('keywords'); // reference only, not output
            $t->string('twitter_card', 40)->nullable()->after('twitter_image');
            $t->boolean('exclude_from_sitemap')->default(false)->after('twitter_card');
        });

        // Blog categories start as the four topics the blog has always used (same slugs and names).
        $topics = ['fbr-compliance' => 'FBR & Tax Compliance', 'restaurant' => 'Restaurant POS', 'salon' => 'Salon POS', 'retail' => 'Retail POS'];
        $i = 0;
        foreach ($topics as $slug => $name) {
            if (! DB::table('categories')->where('slug', $slug)->exists()) {
                DB::table('categories')->insert(['slug' => $slug, 'name' => $name, 'sort_order' => ++$i, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('seo_meta', fn (Blueprint $t) => $t->dropColumn(['focus_keyword', 'twitter_card', 'exclude_from_sitemap']));
    }
};
