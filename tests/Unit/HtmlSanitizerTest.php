<?php

namespace Tests\Unit;

use App\Site\HtmlSanitizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerTest extends TestCase
{
    private function clean(string $html): string
    {
        return (new HtmlSanitizer())->clean($html)['html'];
    }

    public static function attacks(): array
    {
        return [
            'script element' => ['<p>a</p><script>alert(1)</script><p>b</p>', '<p>a</p><p>b</p>'],
            'script, upper case' => ['<SCRIPT src="//x.js"></SCRIPT>ok', 'ok'],
            'event handler' => ['<img src="/a.png" onerror="alert(1)" alt="x">', '<img src="/a.png" alt="x">'],
            'event handler, no quotes' => ['<div onmouseover=alert(1) class="c">x</div>', '<div class="c">x</div>'],
            'javascript href' => ['<a href="javascript:alert(1)">x</a>', '<a>x</a>'],
            'entity-encoded javascript' => ['<a href="&#106;avascript:alert(1)">x</a>', '<a>x</a>'],
            'javascript with a tab' => ["<a href=\"java\tscript:alert(1)\">x</a>", '<a>x</a>'],
            'data URL' => ['<img src="data:text/html;base64,PHNjcmlwdD4=" alt="">', '<img alt="">'],
            'srcset with javascript' => ['<img srcset="/a.png 1x, javascript:alert(1) 2x" alt="">', '<img alt="">'],
            'iframe from another host' => ['<iframe src="https://evil.example/x"></iframe>', '</iframe>'],
            'iframe srcdoc' => ['<iframe src="https://www.youtube.com/embed/x" srcdoc="&lt;script&gt;"></iframe>', '<iframe src="https://www.youtube.com/embed/x"></iframe>'],
            'css expression' => ['<div style="width:expression(alert(1))">x</div>', '<div>x</div>'],
            'css javascript url' => ['<div style="background:url(javascript:alert(1))">x</div>', '<div>x</div>'],
            'svg use outside the page' => ['<svg><use href="https://evil.example/s.svg#a"/></svg>', '<svg><use/></svg>'],
            'svg animate attack' => ['<svg><a><animate attributeName="href" values="javascript:alert(1)"/>x</a></svg>', '<svg><a>x</a></svg>'],
            'form' => ['<form action="https://evil.example"><input name="p"></form>ok', 'ok'],
            'style element' => ['<style>body{display:none}</style>ok', 'ok'],
            'meta refresh' => ['<meta http-equiv="refresh" content="0;url=https://evil.example">ok', 'ok'],
            'alpine attributes' => ['<div x-data="{}" @click="alert(1)" :class="x" class="c">x</div>', '<div class="c">x</div>'],
            'unknown tag keeps its text' => ['<marquee>hi</marquee>', 'hi'],
        ];
    }

    #[DataProvider('attacks')]
    public function test_removes_unsafe_markup(string $in, string $expected): void
    {
        $this->assertSame($expected, $this->clean($in));
    }

    public function test_keeps_design_markup_byte_for_byte(): void
    {
        $html = "<section id=\"x\" class=\"a b\" style=\"background:var(--paper-2); background-image:url('{{base}}/uploads/a.webp')\">\n"
            . '<a href="{{demo_url}}" class="btn btn-primary" data-prefill="Hi &amp; hello" aria-label="Demo">Book</a>'
            . '<svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/>'
            . '<path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/><use href="#rv-star"/></svg>'
            . '<a href="tel:{{phone_raw}}">{{phone}}</a> <a href="mailto:{{email}}">x</a> {{embed:0}}'
            . '<iframe src="https://www.youtube.com/embed/abc?rel=0" loading="lazy" allowfullscreen></iframe>'
            . '<p>&lt; 2 min · Rs. {{price:retailpro-monthly}}</p><!-- note --></section>';

        $this->assertSame($html, $this->clean($html));
    }
}
