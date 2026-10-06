@props([
    'title',
    'lead' => null,
    'eyebrow' => null,
    'crumbs' => [],      // [['Label', '/url'], ...] — the current page is appended automatically
    'crumb' => null,     // label for the current page in the breadcrumb (defaults to title)
    'call' => false,     // show the phone + "Get In Touch" row
])
@php
    $trail = array_merge([['Home', '/']], $crumbs, [[$crumb ?? $title, null]]);
    $siteUrl = rtrim(config('site.url'), '/');
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($trail)->values()->map(fn ($c, $i) => array_filter([
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c[0],
            'item' => $c[1] !== null ? $siteUrl . ($c[1] === '/' ? '/' : $c[1]) : null,
        ]))->all(),
    ];
@endphp
@push('head')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
<header class="page-header">
  <div class="wrap">
    <nav class="crumb reveal" aria-label="Breadcrumb">
      <ol>
        @foreach ($trail as [$label, $href])
          <li>@if ($href !== null)<a href="{{ url($href) }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
        @endforeach
      </ol>
    </nav>
    @if ($eyebrow)<div class="eyebrow-line reveal"><span class="bar"></span><span style="color:var(--coral-soft);">{{ $eyebrow }}</span></div>@endif
    <h1 class="reveal">{!! $title !!}</h1>
    @if ($lead)<p class="lead reveal">{!! $lead !!}</p>@endif
    {{ $slot }}
    @if ($call)
      <div class="call-row reveal">
        <div class="phone">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
          <div><a href="tel:{{ config('site.phone_raw') }}" style="color:var(--text-on-dark);">{{ config('site.phone') }}</a><div class="phone-sub">Call us anytime — find out more about our Point of Sale Software</div></div>
        </div>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get In Touch</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-outline" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    @endif
  </div>
</header>
