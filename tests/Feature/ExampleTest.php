<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Post;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/** Smoke test: every migrated page, post and client page renders, and old WordPress URLs behave. */
class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_every_static_page_renders(): void
    {
        $this->get('/')->assertOk();

        foreach (File::allFiles(resource_path('views/pages')) as $file) {
            $slug = str_replace(['\\', '.blade.php'], ['/', ''], $file->getRelativePathname());
            $this->get('/' . $slug)->assertOk();
        }
    }

    public function test_blog_and_clients_render(): void
    {
        $this->get('/blogs')->assertOk();
        $this->get('/blogs?topic=salon')->assertOk();
        $this->get('/clients')->assertOk();
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        foreach (Post::pluck('slug') as $slug) {
            $this->get('/' . $slug)->assertOk();
        }
        foreach (Client::pluck('slug') as $slug) {
            $this->get('/portfolio-item/' . $slug)->assertOk();
        }
    }

    public function test_old_wordpress_urls(): void
    {
        $this->get('/woocommerce-integration')->assertRedirect('/woocommerce-pos')->assertStatus(301);
        $this->get('/Single-Location')->assertRedirect('/single-location');
        $this->get('/category/uncategorized')->assertRedirect('/blogs');
        $this->get('/wp-content/uploads/2018/05/x.jpg')->assertRedirect('/uploads/2018/05/x.jpg');
        $this->get('/australia-pokies-online-real-money-choices')->assertStatus(410);
        $this->get('/no-such-page')->assertNotFound();
    }

    public function test_noindex_mode_blocks_indexing_everywhere(): void
    {
        config(['site.noindex' => true]);

        foreach (['/', '/fbr-pos-integration', '/blogs', '/clients', '/sitemap.xml', '/no-such-page'] as $url) {
            $this->get($url)->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        }
        $this->get('/')->assertSee('<meta name="robots" content="noindex, nofollow" />', false);
        $this->get('/robots.txt')->assertOk()->assertDontSee('Sitemap:');

        config(['site.noindex' => false]);
        $this->get('/')->assertHeaderMissing('X-Robots-Tag')->assertSee('content="index, follow', false);
        $this->get('/robots.txt')->assertSee('Sitemap:');
    }

    public function test_structured_data_is_valid_json(): void
    {
        $html = $this->get('/frequently-asked-questions')->getContent();
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $this->assertNotEmpty($m[1]);
        foreach ($m[1] as $json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'Invalid JSON-LD: ' . substr($json, 0, 120));
            $this->assertSame('https://schema.org', $data['@context'] ?? null);
        }
    }
}
