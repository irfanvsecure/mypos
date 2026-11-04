<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Website content tables managed by the MCP server and the `site:extract` command.
 * Marketing website only: there is no POS / customer data in this database.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $t) {
            $t->id();
            $t->string('path')->unique();              // '' = home, 'car-wash-pos', 'download/restropro'
            $t->string('name');                         // internal label shown in tools
            $t->string('page_key')->nullable();         // data-page attribute on the page wrapper
            $t->string('status', 20)->default('published'); // published | draft
            $t->json('options')->nullable();            // layout switches (e.g. pixel_category)
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('page_sections', function (Blueprint $t) {
            $t->id();
            $t->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $t->string('key');                          // stable handle, unique per page
            $t->string('type', 30);                     // html | component
            $t->string('component')->nullable();        // component name when type = component
            $t->unsignedInteger('sort_order')->default(0);
            $t->json('content');
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->unique(['page_id', 'key']);
            $t->index(['page_id', 'sort_order']);
        });

        Schema::create('section_revisions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('page_section_id')->constrained('page_sections')->cascadeOnDelete();
            $t->json('snapshot');                        // type, component, key, sort_order, is_visible, content
            $t->string('reason')->nullable();
            $t->string('actor', 60)->nullable();
            $t->timestamp('created_at')->nullable();
            $t->softDeletes();
        });

        Schema::create('seo_meta', function (Blueprint $t) {
            $t->id();
            $t->morphs('seoable');                      // page / post / category / client
            $t->string('title', 300)->nullable();
            $t->string('description', 1000)->nullable();
            $t->string('keywords', 500)->nullable();
            $t->string('canonical', 500)->nullable();
            $t->string('robots', 120)->nullable();
            $t->string('og_title', 300)->nullable();
            $t->string('og_description', 1000)->nullable();
            $t->string('og_image', 500)->nullable();
            $t->string('og_type', 40)->nullable();
            $t->string('twitter_title', 300)->nullable();
            $t->string('twitter_description', 1000)->nullable();
            $t->string('twitter_image', 500)->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->unique(['seoable_type', 'seoable_id']);
        });

        Schema::create('schema_blocks', function (Blueprint $t) {
            $t->id();
            $t->nullableMorphs('schemaable');           // null = site-wide
            $t->string('schema_type', 80);              // @type, e.g. SoftwareApplication
            $t->longText('json');                       // stored verbatim; {{base}}-style tokens allowed
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->string('name');
            $t->text('description')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('tags', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('post_tag', function (Blueprint $t) {
            $t->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $t->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $t->primary(['post_id', 'tag_id']);
        });

        Schema::table('posts', function (Blueprint $t) {
            $t->softDeletes();
        });

        Schema::table('clients', function (Blueprint $t) {
            $t->softDeletes();
        });

        Schema::create('media', function (Blueprint $t) {
            $t->id();
            $t->string('path')->unique();               // relative to public/, e.g. uploads/2026/07/x.webp
            $t->string('original_path')->nullable();    // upload kept as sent, when converted
            $t->string('mime', 80)->nullable();
            $t->unsignedInteger('width')->nullable();
            $t->unsignedInteger('height')->nullable();
            $t->unsignedBigInteger('size')->nullable();
            $t->string('alt', 500)->nullable();
            $t->string('title', 300)->nullable();
            $t->json('variants')->nullable();           // [{width, path}] for srcset
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('redirects', function (Blueprint $t) {
            $t->id();
            $t->string('from_path')->unique();          // no leading slash
            $t->string('to_url', 500)->nullable();      // null for 410
            $t->unsignedSmallInteger('status_code')->default(301); // 301 | 302 | 410
            $t->boolean('is_auto')->default(false);     // created by a slug change
            $t->unsignedInteger('hits')->default(0);
            $t->timestamp('last_hit_at')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('pricing_plans', function (Blueprint $t) {
            $t->id();
            $t->string('plan_group', 60);               // which block shows it, e.g. home, retailpro
            $t->string('name');
            $t->string('badge')->nullable();
            $t->decimal('price_pkr', 12, 2)->nullable(); // numeric price, null for "Contact Sales"
            $t->string('price_label')->nullable();      // as displayed, e.g. "Rs. 2,000"
            $t->string('billing_period', 40)->nullable(); // month | year | one-time
            $t->string('subtitle', 500)->nullable();
            $t->json('features')->nullable();           // list of HTML strings
            $t->string('cta_label')->nullable();
            $t->string('cta_url', 500)->nullable();
            $t->string('cta_style', 60)->nullable();
            $t->boolean('cta_new_tab')->default(false);
            $t->boolean('is_featured')->default(false);
            $t->json('extra')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['plan_group', 'sort_order']);
        });

        Schema::create('faqs', function (Blueprint $t) {
            $t->id();
            $t->string('faq_group', 120);               // e.g. home, page:car-wash-pos
            $t->text('question');
            $t->text('answer');
            $t->boolean('is_html')->default(true);      // false = plain text, escaped on output
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['faq_group', 'sort_order']);
        });

        Schema::create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('text');
            $t->string('source', 60)->default('Google');
            $t->unsignedTinyInteger('rating')->default(5);
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('client_logos', function (Blueprint $t) {
            $t->id();
            $t->string('logo_group', 60);               // e.g. proof, marquee-1, marquee-2
            $t->string('name');
            $t->string('image');                        // relative to public/uploads
            $t->string('client_slug')->nullable();      // portfolio-item link
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['logo_group', 'sort_order']);
        });

        Schema::create('downloads', function (Blueprint $t) {
            $t->id();
            $t->string('key', 60)->unique();            // retailpro, restropro…
            $t->string('app_name');
            $t->string('platform')->nullable();
            $t->string('version', 60)->nullable();
            $t->string('file_size', 40)->nullable();
            $t->string('download_count', 60)->nullable();
            $t->string('file_url', 500)->nullable();
            $t->string('store_url', 500)->nullable();
            $t->text('release_notes')->nullable();
            $t->json('extra')->nullable();
            $t->unsignedInteger('sort_order')->default(0);
            $t->boolean('is_visible')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });

        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('key')->unique();
            $t->json('value')->nullable();
            $t->string('description', 500)->nullable();
            $t->timestamps();
            $t->softDeletes();
        });

        // Append-only audit trail (no soft deletes: entries are never edited or removed by the tools).
        Schema::create('activity_log', function (Blueprint $t) {
            $t->id();
            $t->string('actor', 60);                    // mcp, cli, …
            $t->string('action', 80);
            $t->string('subject_type', 80)->nullable();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->string('summary', 500)->nullable();
            $t->json('before')->nullable();
            $t->json('after')->nullable();
            $t->string('ip', 45)->nullable();
            $t->timestamp('created_at')->nullable()->index();
            $t->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        foreach (['activity_log', 'settings', 'downloads', 'client_logos', 'testimonials', 'faqs', 'pricing_plans',
                  'redirects', 'media', 'post_tag', 'tags', 'categories', 'schema_blocks', 'seo_meta',
                  'section_revisions', 'page_sections', 'pages'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('posts', fn (Blueprint $t) => $t->dropSoftDeletes());
        Schema::table('clients', fn (Blueprint $t) => $t->dropSoftDeletes());
    }
};
