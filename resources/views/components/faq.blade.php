@props([
    'items' => [],          // [['Question?', 'Answer (HTML allowed)'], ...]
    'title' => 'Frequently Asked Questions.',
    'eyebrow' => 'FAQ',
    'id' => 'faq',
    'schema' => true,       // emit FAQPage structured data
    'group' => null,        // read the items from the faqs table instead
    'numbered' => false,    // plain-text items shown as "1  Question" (numbers are not part of the stored question)
])
@php if ($group) { $items = \App\Models\Faq::pairs($group); } @endphp
@if ($schema && count($items))
@push('head')
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($items)->map(fn ($f) => [
        '@type' => 'Question',
        'name' => preg_replace('/^\s*\d{1,2}\s*[.)]?\s*/', '', trim(strip_tags($f[0]))),
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f[1], '<a><strong><br>')],
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@endif
<section id="{{ $id }}" {{ $attributes }}>
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>{{ $eyebrow }}</span></div>
      <h2>{!! $title !!}</h2>
    </div>
    <div class="faq-list" style="max-width:820px; margin-top:40px;">
      @foreach ($items as $i => [$q, $a])
        <div class="faq-item {{ $i === 0 ? 'open' : '' }}">
@if ($numbered)
          <button class="faq-q" type="button"><span><span style="color:var(--coral-deep); margin-right:12px;">{{ $i + 1 }}</span>{{ $q }}</span><span class="plus"></span></button>
          <div class="faq-a"><p>{{ $a }}</p></div>
@else
          <button class="faq-q" type="button">{!! $q !!}<span class="plus"></span></button>
          <div class="faq-a"><p>{!! $a !!}</p></div>
@endif
        </div>
      @endforeach
    </div>
    {{ $slot }}
  </div>
</section>
