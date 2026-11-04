<?php

namespace Tests\Feature\Mcp;

use App\Models\Media;
use App\Site\MediaLibrary;
use Illuminate\Support\Facades\File;

class MediaToolsTest extends McpTestCase
{
    private array $created = [];

    protected function tearDown(): void
    {
        foreach (Media::withTrashed()->where('id', '>', 0)->whereNotNull('variants')->get() as $m) {
            foreach (array_filter(array_merge([$m->path, $m->original_path], array_column($m->variants ?? [], 'path'))) as $f) {
                File::delete(public_path($f));
            }
        }
        MediaLibrary::forget();
        parent::tearDown();
    }

    private function png(int $w = 1800, int $h = 900): string
    {
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, imagecolorallocate($img, 15, 59, 99));
        ob_start();
        imagepng($img);

        return base64_encode(ob_get_clean());
    }

    public function test_upload_converts_to_webp_with_srcset_and_keeps_the_original(): void
    {
        $r = $this->tool('upload_image', ['base64' => $this->png(), 'filename' => 'mcp-test-banner', 'alt' => 'Test banner']);
        $this->assertStringEndsWith('.webp', $r['path']);
        $this->assertSame(1600, $r['width']);                                // scaled to max width
        $this->assertSame([480, 800, 1200, 1600], $r['srcset']);
        $this->assertFileExists(public_path($r['path']));
        $this->assertFileExists(public_path($r['original']));
        $this->assertStringContainsString('srcset="{{base}}/', $r['html']);

        $this->assertStringContainsString('JPEG, PNG', $this->toolError('upload_image', ['base64' => base64_encode('not an image'), 'alt' => 'x']));
        $this->assertStringContainsString('private', $this->toolError('upload_image', ['image_url' => 'http://127.0.0.1/secret.png', 'alt' => 'x']));
        $this->assertStringContainsString('either', $this->toolError('upload_image', ['alt' => 'x']));
    }

    public function test_alt_replace_and_guarded_delete(): void
    {
        $r = $this->tool('upload_image', ['base64' => $this->png(400, 200), 'filename' => 'mcp-test-icon', 'alt' => 'Icon']);
        $this->tool('add_page_section', ['page' => 'about-us', 'key' => 'img-test', 'type' => 'html', 'html' => '<section><div class="wrap">' . $r['html'] . '</div></section>']);
        $this->assertStringContainsString('alt="Icon"', $this->html('about-us'));

        $this->tool('update_image', ['image' => $r['id'], 'alt' => 'myPOS icon']);
        $this->assertStringContainsString('alt="myPOS icon"', $this->html('about-us'));
        $this->tool('bulk_update_alt', ['items' => [['image_id' => $r['id'], 'alt' => 'myPOS app icon']]]);
        $this->assertStringContainsString('alt="myPOS app icon"', $this->html('about-us'));

        $this->assertStringContainsString('is used in', $this->toolError('delete_image', ['image' => $r['id']]));

        $r2 = $this->tool('upload_image', ['base64' => $this->png(400, 200), 'filename' => 'mcp-test-icon-new', 'alt' => 'New icon']);
        $replaced = $this->tool('replace_image', ['image' => $r['id'], 'replacement' => $r2['id']]);
        $this->assertNotEmpty($replaced['places']);
        $this->assertStringContainsString($r2['path'], $this->html('about-us'));

        $this->tool('delete_image', ['image' => $r['id']]);                 // no longer used
        $this->tool('purge_item', ['type' => 'image', 'id' => $r['id'], 'confirm' => true]);
        $this->assertFileDoesNotExist(public_path($r['path']));
        $this->assertNotEmpty($this->tool('list_images', ['search' => 'mcp-test'])['images']);
    }

    public function test_rename_updates_references_and_redirects(): void
    {
        $r = $this->tool('upload_image', ['base64' => $this->png(400, 200), 'filename' => 'mcp-test-old', 'alt' => 'Old']);
        $this->tool('add_page_section', ['page' => 'about-us', 'key' => 'img-rename', 'type' => 'html', 'html' => '<p>' . $r['html'] . '</p>']);
        $res = $this->tool('update_image', ['image' => $r['id'], 'filename' => 'mcp-test-renamed']);
        $this->assertStringContainsString('mcp-test-renamed.webp', $res['image']['path']);
        $this->assertStringContainsString('mcp-test-renamed.webp', $this->html('about-us'));
        $this->assertStringNotContainsString('mcp-test-old.webp', $this->html('about-us'));
    }

    public function test_audit_images(): void
    {
        $a = $this->tool('audit_images', ['page' => '']);
        $this->assertSame(1, $a['pages_checked']);
        $this->assertArrayHasKey('totals', $a);
    }
}
