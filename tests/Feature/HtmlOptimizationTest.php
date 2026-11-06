<?php

namespace Tests\Feature;

use App\Site\NavSprite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\OptimizeHtml;
use Illuminate\Http\Request;
use Tests\TestCase;

class HtmlOptimizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_nav_sprite_file_matches_the_icon_config(): void
    {
        $this->assertSame(
            NavSprite::build(),
            file_get_contents(public_path(NavSprite::FILE)),
            'public/images/nav-icons.svg is stale: run `php artisan site:nav-sprite`.'
        );
    }

    public function test_every_menu_icon_in_use_exists_in_the_sprite(): void
    {
        $icons = config('site.nav_icons');
        foreach (config('site.menu') as $menu) {
            $items = $menu['items'] ?? array_merge(...array_values($menu['groups']));
            foreach ($items as $item) {
                $this->assertArrayHasKey($item[2], $icons, "Menu item {$item[0]} uses a missing icon");
            }
        }
        $this->assertArrayHasKey('call', $icons);
    }

    public function test_menu_icons_come_from_the_sprite(): void
    {
        $html = view('partials.nav')->render();

        $this->assertStringContainsString('<use href="' . NavSprite::url() . '#call"/>', $html);
        $this->assertStringNotContainsString('stroke-linejoin="round" aria-hidden="true">', $html);
    }

    public function test_pages_are_served_optimized(): void
    {
        $html = $this->get('https://mypos.pk/no-such-page')->assertNotFound()->getContent(); // full layout, no DB content needed

        $this->assertStringContainsString('<use href="' . NavSprite::url() . '#', $html);
        $this->assertDoesNotMatchRegularExpression('/>\n\s*\n\s*</', $html);
        $this->assertDoesNotMatchRegularExpression('/\n {4,}</', $html);
    }

    public function test_only_html_responses_are_changed_and_it_can_be_switched_off(): void
    {
        $mw = new OptimizeHtml;
        // The router has already prepared the response (Content-Type set) when route middleware sees it.
        $run = fn ($response) => $mw->handle(Request::create('/'), fn () => $response->prepare(Request::create('/')))->getContent();

        $this->assertSame('<p>a b</p>', $run(response('<p>a     b</p>')));
        $this->assertSame('{"a":"x    y"}', $run(response()->json(['a' => 'x    y'])));
        $this->assertSame('a     b', $run(response('a     b', 200, ['Content-Type' => 'text/plain'])));

        config(['site.optimize_html' => false]);
        $this->assertSame('<p>a     b</p>', $run(response('<p>a     b</p>')));
    }
}
