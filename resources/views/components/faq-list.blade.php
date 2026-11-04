@props(['items' => [], 'group' => null])
@php if ($group) { $items = \App\Models\Faq::pairs($group); } @endphp
@push('head')
<script type="application/ld+json">{!! json_encode(['@@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($items)->map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]])->all()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
@foreach ($items as $i => [$q, $a])
        <div class="faq-item {{ $i === 0 ? 'open' : '' }}">
          <button class="faq-q" type="button">{{ $q }}<span class="plus"></span></button>
          <div class="faq-a"><p>{{ $a }}</p></div>
        </div>
        @endforeach