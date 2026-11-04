@props(['groups' => []])
{{-- One FAQPage structured-data block for all the FAQs in these groups (plain-text FAQs). Outputs nothing visible. --}}
@php
    $faqItems = collect((array) $groups)->flatMap(fn ($g) => \App\Models\Faq::pairs($g));
@endphp
@if ($faqItems->isNotEmpty())
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqItems->map(fn ($f) => [
        '@type' => 'Question',
        'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif