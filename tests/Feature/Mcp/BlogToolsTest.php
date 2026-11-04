<?php

namespace Tests\Feature\Mcp;

use App\Models\Post;

class BlogToolsTest extends McpTestCase
{
    public function test_post_lifecycle(): void
    {
        $r = $this->tool('create_blog', ['title' => 'Choosing a POS for a Pharmacy', 'content' => '<h2>Why it matters</h2><p>Expiry tracking.</p><script>x</script>',
            'excerpt' => 'How to choose a pharmacy POS in Pakistan.', 'category' => 'retail', 'tags' => ['Pharmacy', 'Expiry']]);
        $slug = $r['created']['slug'];
        $this->assertSame('draft', $r['created']['status']);
        $this->assertSame(['pharmacy', 'expiry'], $r['created']['tags']);
        $this->get('/' . $slug)->assertNotFound();
        $this->assertStringNotContainsString('<script>', Post::where('slug', $slug)->value('content'));

        $this->tool('publish_blog', ['slug' => $slug]);
        $this->assertStringContainsString('Choosing a POS for a Pharmacy', $this->html($slug));
        $this->assertStringContainsString($slug, $this->get('/sitemap.xml')->getContent());

        $this->tool('update_blog', ['slug' => $slug, 'new_slug' => 'pharmacy-pos-guide', 'title' => 'Pharmacy POS Guide']);
        $this->get('/' . $slug)->assertRedirect(url('/pharmacy-pos-guide'));
        $this->assertStringContainsString('Pharmacy POS Guide', $this->html('pharmacy-pos-guide'));

        $this->tool('unpublish_blog', ['slug' => 'pharmacy-pos-guide']);
        $this->get('/pharmacy-pos-guide')->assertNotFound();
        $this->tool('schedule_blog', ['slug' => 'pharmacy-pos-guide', 'publish_at' => now()->addWeek()->toIso8601String()]);
        $this->assertSame('scheduled', $this->tool('get_blog', ['slug' => 'pharmacy-pos-guide'])['status']);
        $this->assertStringContainsString('future', $this->toolError('schedule_blog', ['slug' => 'pharmacy-pos-guide', 'publish_at' => '2020-01-01']));

        $this->tool('delete_blog', ['slug' => 'pharmacy-pos-guide']);
        $this->assertSame(1, Post::onlyTrashed()->count());
        $this->assertStringContainsString('<h1>', $this->toolError('create_blog', ['title' => 'X', 'content' => '<h1>Two H1</h1>']));
        $this->assertNotEmpty($this->tool('list_blogs', ['status' => 'published']));
        $this->assertIsArray($this->tool('list_stale_posts', ['months' => 1]));
    }

    public function test_categories(): void
    {
        $this->assertCount(4, $this->tool('list_categories'));
        $this->tool('create_category', ['name' => 'Pharmacy POS']);
        $this->assertStringContainsString('Pharmacy POS', $this->html('blogs'));

        $post = Post::published()->where('topic', 'salon')->first();
        $this->tool('update_category', ['slug' => 'salon', 'new_slug' => 'salon-spa', 'name' => 'Salon & Spa POS']);
        $this->assertSame('salon-spa', $post->fresh()->topic);
        $this->assertStringContainsString('Salon &amp; Spa POS', $this->html('blogs'));

        $this->assertStringContainsString('move_posts_to', $this->toolError('delete_category', ['slug' => 'salon-spa']));
        $this->tool('delete_category', ['slug' => 'salon-spa', 'move_posts_to' => 'retail']);
        $this->assertSame('retail', $post->fresh()->topic);
    }

    public function test_tags_and_merge_redirect(): void
    {
        $post = Post::published()->first();
        $this->tool('create_tag', ['name' => 'FBR']);
        $this->tool('set_blog_taxonomies', ['slug' => $post->slug, 'tags' => ['FBR', 'Invoicing'], 'category' => 'fbr-compliance']);
        $this->assertSame(['fbr', 'invoicing'], $post->fresh()->tags()->orderBy('slug')->pluck('slug')->all());
        $this->assertStringContainsString($post->title, $this->html('tag/fbr'));

        $this->tool('update_tag', ['slug' => 'invoicing', 'new_slug' => 'e-invoicing', 'name' => 'E-invoicing']);
        $this->get('/tag/invoicing')->assertRedirect(url('/tag/e-invoicing'));

        $r = $this->tool('merge_tags', ['from' => 'e-invoicing', 'into' => 'fbr']);
        $this->assertSame(1, $r['posts_moved']);
        $this->get('/tag/e-invoicing')->assertRedirect(url('/tag/fbr'));
        $this->get('/tag/invoicing')->assertRedirect(url('/tag/fbr'));       // no chain
        $this->assertCount(1, $this->tool('list_tags'));

        $this->tool('delete_tag', ['slug' => 'fbr']);
        $this->get('/tag/fbr')->assertNotFound();
    }
}
