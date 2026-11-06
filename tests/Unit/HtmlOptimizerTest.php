<?php

namespace Tests\Unit;

use App\Console\Commands\SiteExtractStyles;
use App\Site\HtmlOptimizer;
use PHPUnit\Framework\TestCase;

class HtmlOptimizerTest extends TestCase
{
    private function optimizer(): HtmlOptimizer
    {
        return new HtmlOptimizer([
            'margin-top:26px;' => 'x-a',
            '--i:0' => 'x-b',
            'color:inherit; font-weight:700;' => 'x-c',
        ]);
    }

    public function test_mapped_style_becomes_a_class(): void
    {
        $this->assertSame('<div class="x-a">Hi</div>', $this->optimizer()->optimize('<div style="margin-top:26px;">Hi</div>'));
    }

    public function test_class_is_appended_to_an_existing_class_before_or_after_the_style(): void
    {
        $o = $this->optimizer();
        $this->assertSame('<div class="btn-row x-a">', $o->optimize('<div class="btn-row" style="margin-top:26px;">'));
        $this->assertSame('<div class="stat reveal x-b">', $o->optimize('<div style="--i:0" class="stat reveal">'));
        $this->assertSame('<p class="x-a">', $o->optimize('<p class="" style="margin-top:26px;">'));
    }

    public function test_single_quoted_styles_and_self_closing_tags(): void
    {
        $o = $this->optimizer();
        $this->assertSame('<a href="tel:1" class="x-c">', $o->optimize("<a href=\"tel:1\" style='color:inherit; font-weight:700;'>"));
        $this->assertSame('<img src="a.png" alt="x" class="x-b"/>', $o->optimize('<img src="a.png" alt="x" style="--i:0"/>'));
    }

    public function test_unknown_style_stays_inline(): void
    {
        $html = '<div style="color:red">x</div>';
        $this->assertSame($html, $this->optimizer()->optimize($html));
    }

    public function test_attribute_values_containing_gt_or_style_text_are_safe(): void
    {
        $o = $this->optimizer();
        $this->assertSame('<a data-prefill="a > b" class="x-a">', $o->optimize('<a data-prefill="a > b" style="margin-top:26px;">'));
        $this->assertSame('<div data-style="margin-top:26px;">', $o->optimize('<div data-style="margin-top:26px;">'));
    }

    public function test_scripts_styles_pre_and_comments_are_untouched(): void
    {
        $html = "<script>var a = '<div style=\"--i:0\">';    x();</script>\n<style>a  {  color:red }</style>"
            . "<pre>  keep   spacing  </pre><!--  <b style=\"--i:0\">  -->"
            . '<textarea>  two  spaces </textarea>';
        $this->assertSame($html, $this->optimizer()->optimize($html));
    }

    public function test_whitespace_collapses_outside_raw_text(): void
    {
        $this->assertSame("<ul>\n<li>A b</li>\n</ul>", $this->optimizer()->optimize("<ul>\n      <li>A    b</li>\n    </ul>"));
        $this->assertSame('<p>one two</p>', $this->optimizer()->optimize("<p>one \t two</p>"));
    }

    public function test_non_breaking_space_is_kept(): void
    {
        $this->assertSame("<p>a\u{00A0}\u{00A0}b</p>", $this->optimizer()->optimize("<p>a\u{00A0}\u{00A0}b</p>"));
    }

    public function test_extractor_css_marks_every_declaration_important(): void
    {
        $css = SiteExtractStyles::cssFor(['margin-top:26px; color:var(--x)' => 'x-a', 'background:url("a;b.png") no-repeat;' => 'x-b', 'top:0 !important' => 'x-c']);
        $this->assertSame(".x-a{margin-top:26px !important;color:var(--x) !important}\n.x-b{background:url(\"a;b.png\") no-repeat !important}\n.x-c{top:0 !important}\n", $css);
    }

    public function test_extractor_skips_properties_that_javascript_changes(): void
    {
        $this->assertFalse(SiteExtractStyles::extractable('max-height:0'));
        $this->assertFalse(SiteExtractStyles::extractable('--rx:0deg'));
        $this->assertFalse(SiteExtractStyles::extractable(''));
        $this->assertTrue(SiteExtractStyles::extractable('margin:0; --i:3'));
    }

    public function test_extractor_rewrites_style_attribute_selectors(): void
    {
        $map = ['grid-template-columns:repeat(3,1fr)' => 'x-a', 'text-align:left' => 'x-b'];
        $css = ".x[style*=\"repeat(3\"]{gap:0}\n@media (max-width:600px){.y[style]{a:b !important;}}\n.z{c:d}";
        $this->assertSame(
            ".x:is(.x-a){gap:0}\n@media (max-width:600px){.y:is(.x-a,.x-b){a:b !important;}}\n",
            SiteExtractStyles::attributeRules($css, $map)
        );
    }
}
