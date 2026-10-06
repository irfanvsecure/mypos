@props([
    'items' => [],          // [['Question?', 'Answer (HTML allowed)'], ...]
    'title' => 'Frequently Asked Questions.',
    'eyebrow' => 'FAQ',
    'id' => 'faq',
    'schema' => true,       // emit FAQPage structured data
])
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
          <button class="faq-q" type="button">{!! $q !!}<span class="plus"></span></button>
          <div class="faq-a"><p>{!! $a !!}</p></div>
        </div>
      @endforeach
    </div>
    {{ $slot }}
  </div>
</section>
