@props(['group' => null, 'openFirst' => false])
@php
    // FAQ items of one topic on the /frequently-asked-questions page (plain-text FAQs from the faqs table),
    // written out with that page's original indentation.
    $out = '            ';
    foreach (\App\Models\Faq::pairs((string) $group) as $i => [$q, $a]) {
        $out .= '              <div class="faq-item ' . ($openFirst && $i === 0 ? 'open' : '') . "\">\n"
            . '                <button class="faq-q" type="button">' . e($q) . '<span class="plus"></span></button>' . "\n"
            . '                <div class="faq-a"><p>' . e($a) . '</p></div>' . "\n"
            . "              </div>\n            ";
    }
@endphp
{!! $out !!}