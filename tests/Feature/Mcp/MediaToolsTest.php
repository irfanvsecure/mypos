<?php

namespace Tests\Feature\Mcp;

use App\Models\Media;
use App\Site\MediaLibrary;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

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

    private function fakeImage(string $url, string $bytes, string $type = 'image/png', int $status = 200): void
    {
        Http::preventStrayRequests();
        Http::fake([$url => Http::response($bytes, $status, ['Content-Type' => $type])]);
    }

    /** The decoded structured error of a tool call. */
    private function codedError(string $tool, array $args): array
    {
        $error = json_decode($this->toolError($tool, $args), true);
        $this->assertIsArray($error);

        return $error;
    }

    public function test_upload_from_url_stores_webp_with_thumbnails_and_records_the_source(): void
    {
        $url = 'https://8.8.8.8/photos/mcp-test-shot.png?w=1600';
        $this->fakeImage('8.8.8.8/*', base64_decode($this->png()));

        $r = $this->tool('upload_image_from_url', ['url' => $url, 'alt' => 'Shop counter']);

        $this->assertSame(['id', 'path', 'url', 'width', 'height', 'size_bytes', 'mime', 'alt'], array_values(array_intersect(array_keys($r), ['id', 'path', 'url', 'width', 'height', 'size_bytes', 'mime', 'alt'])));
        $this->assertStringEndsWith('/mcp-test-shot.webp', $r['path']);
        $this->assertSame('image/webp', $r['mime']);
        $this->assertSame(1600, $r['width']);
        $this->assertSame([480, 800, 1200, 1600], $r['srcset']);
        $this->assertSame('Shop counter', $r['alt']);
        $this->assertSame(filesize(public_path($r['path'])), $r['size_bytes']);
        $this->assertNull($r['original']);

        $media = Media::find($r['id']);
        $this->assertSame($url, $media->source_url);
        $this->assertSame('mcp_url', $media->uploaded_via);
        Http::assertSent(fn ($req) => str_contains($req->header('User-Agent')[0], 'Mozilla') && $req->header('Accept')[0] === 'image/*');
    }

    public function test_upload_from_url_options_filename_folder_width_and_format(): void
    {
        $this->fakeImage('8.8.8.8/*', base64_decode($this->png(1000, 500)));

        $r = $this->tool('upload_image_from_url', ['url' => 'https://8.8.8.8/a.png', 'filename' => 'mcp-test-chosen', 'folder' => 'mcp-test-folder', 'max_width' => 600, 'convert_to_webp' => false]);

        $this->assertSame('uploads/mcp-test-folder/mcp-test-chosen.png', $r['path']);
        $this->assertSame('image/png', $r['mime']);
        $this->assertSame([600, 300], [$r['width'], $r['height']]);
        $this->assertSame([480, 600], $r['srcset']);
        $this->assertFileExists(public_path('uploads/mcp-test-folder/mcp-test-chosen-480.png'));

        $this->assertStringContainsString('format', $this->toolError('upload_image_from_url', ['url' => 'https://8.8.8.8/a.png', 'folder' => '../secret']));
        File::deleteDirectory(public_path('uploads/mcp-test-folder'));
    }

    public function test_upload_from_url_removes_exif_and_applies_its_orientation(): void
    {
        // A 40x20 JPEG with an APP1 segment saying "rotate 90 degrees clockwise" (orientation 6).
        $img = imagecreatetruecolor(40, 20);
        ob_start();
        imagejpeg($img);
        $jpeg = ob_get_clean();
        $tiff = "MM\x00\x2A\x00\x00\x00\x08\x00\x01\x01\x12\x00\x03\x00\x00\x00\x01\x00\x06\x00\x00\x00\x00\x00\x00";
        $app1 = "Exif\x00\x00" . $tiff;
        $withExif = "\xFF\xD8\xFF\xE1" . pack('n', strlen($app1) + 2) . $app1 . substr($jpeg, 2);
        $this->fakeImage('8.8.8.8/*', $withExif, 'image/jpeg');

        $r = $this->tool('upload_image_from_url', ['url' => 'https://8.8.8.8/mcp-test-exif.jpg', 'convert_to_webp' => false]);

        $this->assertSame([20, 40], [$r['width'], $r['height']]);
        $this->assertStringNotContainsString('Exif', File::get(public_path($r['path'])));
    }

    public function test_upload_from_url_follows_redirects_and_names_generic_paths(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            '8.8.8.8/photos/mcp-test-abc/download*' => Http::response('', 302, ['Location' => 'https://1.1.1.1/cdn/x.png']),
            '1.1.1.1/*' => Http::response(base64_decode($this->png(100, 50)), 200, ['Content-Type' => 'image/png']),
        ]);

        $r = $this->tool('upload_image_from_url', ['url' => 'https://8.8.8.8/photos/mcp-test-abc/download?w=1600']);
        $this->assertStringEndsWith('/mcp-test-abc.webp', $r['path']);

        Http::fake(['8.8.4.4/*' => Http::response('', 302, ['Location' => 'https://8.8.4.4/again'])]);
        $e = $this->codedError('upload_image_from_url', ['url' => 'https://8.8.4.4/loop']);
        $this->assertSame('fetch_failed', $e['error']);
        $this->assertStringContainsString('redirects', $e['message']);
        Http::assertSentCount(6); // the first request and 5 redirects (a new Http::fake resets the count)
    }

    public function test_upload_from_url_structured_errors(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            '8.8.8.8/missing' => Http::response('nope', 404, ['Content-Type' => 'text/plain']),
            '8.8.8.8/page' => Http::response('<html>hello</html>', 200, ['Content-Type' => 'text/html; charset=utf-8']),
            '8.8.8.8/lying.png' => Http::response('<html>not a png</html>', 200, ['Content-Type' => 'image/png']),
            '8.8.8.8/svg' => Http::response('<svg xmlns="http://www.w3.org/2000/svg"></svg>', 200, ['Content-Type' => 'image/svg+xml']),
            '8.8.8.8/huge.png' => Http::response(str_repeat('x', 10 * 1024 * 1024 + 1), 200, ['Content-Type' => 'image/png']),
            '8.8.8.8/broken.png' => Http::response("\x89PNG\r\n\x1A\nbroken", 200, ['Content-Type' => 'image/png']),
            '8.8.8.8/down' => fn () => throw new \Illuminate\Http\Client\ConnectionException('cURL error 28: timed out'),
        ]);
        $call = fn (string $path) => $this->codedError('upload_image_from_url', ['url' => "https://8.8.8.8/$path"]);

        $e = $call('missing');
        $this->assertSame(['fetch_failed', 404, '8.8.8.8'], [$e['error'], $e['status'], $e['hostname']]);

        $e = $call('page');
        $this->assertSame(['not_an_image', 'text/html; charset=utf-8'], [$e['error'], $e['content_type']]);
        $this->assertSame('not_an_image', $call('lying.png')['error']);   // the bytes decide, not the header or the extension
        $this->assertSame('not_an_image', $call('svg')['error']);

        $this->assertSame('too_large', $call('huge.png')['error']);

        $e = $call('broken.png');
        $this->assertSame('processing_failed', $e['error']);
        $this->assertNotEmpty($e['detail']);

        $e = $call('down');
        $this->assertSame(['fetch_failed', null, '8.8.8.8'], [$e['error'], $e['status'], $e['hostname']]);
        $this->assertStringContainsString('timed out', $e['detail']);

        $this->assertSame(0, Media::whereNotNull('uploaded_via')->count()); // nothing half-saved
    }

    public function test_upload_from_url_blocks_internal_addresses_on_every_hop(): void
    {
        Http::preventStrayRequests();
        Http::fake(['8.8.8.8/*' => Http::response('', 302, ['Location' => 'http://169.254.169.254/latest/meta-data/'])]);

        foreach (['http://127.0.0.1/x.png', 'http://10.0.0.5/x.png', 'http://172.16.0.1/x.png', 'http://172.31.255.1/x.png', 'http://192.168.1.1/x.png',
            'http://169.254.169.254/x.png', 'http://[::1]/x.png', 'http://[::ffff:127.0.0.1]/x.png', 'http://[fe80::1]/x.png', 'http://[fd00::1]/x.png', 'http://100.64.0.1/x.png',
            'http://2130706433/x.png', 'http://0x7f.1/x.png', 'http://localhost/x.png', 'ftp://8.8.8.8/x.png', 'file:///etc/passwd',
            'http://user:pw@8.8.8.8/x.png', 'https://8.8.8.8/start'] as $url) {
            $this->assertSame('url_not_allowed', $this->codedError('upload_image_from_url', ['url' => $url])['error'], $url);
        }
        Http::assertSentCount(1); // only the public first hop was requested
    }

    public function test_upload_from_url_allow_list(): void
    {
        config(['mcp_site.images.url_allowed_hosts' => ['8.8.8.8']]);
        $this->fakeImage('8.8.8.8/*', base64_decode($this->png(100, 50)));

        $this->assertNotEmpty($this->tool('upload_image_from_url', ['url' => 'https://8.8.8.8/mcp-test-listed.png'])['id']);
        $e = $this->codedError('upload_image_from_url', ['url' => 'https://1.1.1.1/x.png']);
        $this->assertSame(['url_not_allowed', '1.1.1.1'], [$e['error'], $e['hostname']]);
    }

    public function test_upload_image_url_path_uses_the_same_function(): void
    {
        $url = 'https://8.8.8.8/mcp-test-legacy.png';
        $this->fakeImage('8.8.8.8/*', base64_decode($this->png(100, 50)));

        $r = $this->tool('upload_image', ['image_url' => $url, 'alt' => 'Legacy']);
        $this->assertSame($url, $r['source_url']);
        $this->assertSame('mcp_url', $r['uploaded_via']);
        $this->assertStringContainsString('<img', $r['html']);

        Http::fake(['1.1.1.1/*' => Http::response('<html>', 200, ['Content-Type' => 'text/html'])]);
        $this->assertSame('not_an_image', $this->codedError('upload_image', ['image_url' => 'https://1.1.1.1/x', 'alt' => 'x'])['error']);
    }

    public function test_structured_error_reaches_the_client_over_http_and_auth_is_required(): void
    {
        $this->fakeImage('8.8.8.8/*', '<html>', 'text/html');
        $body = ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'tools/call', 'params' => ['name' => 'upload_image_from_url', 'arguments' => ['url' => 'https://8.8.8.8/page']]];
        $accept = ['Accept' => 'application/json, text/event-stream'];

        $this->postJson('/mcp', $body, $accept)->assertStatus(401);

        $res = $this->postJson('/mcp', $body, $accept + ['Authorization' => 'Bearer ' . self::SECRET])->assertOk();
        $this->assertTrue($res->json('result.isError'));
        $this->assertSame('not_an_image', json_decode($res->json('result.content.0.text'), true)['error']);
    }

    public function test_audit_images(): void
    {
        $a = $this->tool('audit_images', ['page' => '']);
        $this->assertSame(1, $a['pages_checked']);
        $this->assertArrayHasKey('totals', $a);
    }
}
