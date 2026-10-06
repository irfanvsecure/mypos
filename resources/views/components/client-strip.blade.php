@props([
    'limit' => 6,
    'slugs' => null,   // optional: exact clients to show, in order (portfolio-item slugs)
    'title' => 'Our Clients',
    'eyebrow' => 'TRUSTED BY',
])
@php
    $clients = $slugs
        ? \App\Models\Client::whereIn('slug', $slugs)->get()->sortBy(fn ($c) => array_search($c->slug, $slugs))->values()
        : \App\Models\Client::orderBy('sort')->limit($limit)->get();
@endphp
@if ($clients->isNotEmpty())
<section class="section-tight" {{ $attributes }}>
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>{{ $eyebrow }}</span></div>
      <h2>{{ $title }}</h2>
    </div>
    <div class="client-strip">
      @foreach ($clients as $c)
        <a href="{{ $c->url }}" title="{{ $c->name }}"><img src="{{ asset(ltrim($c->logo, '/')) }}" alt="{{ $c->name }} logo" loading="lazy"></a>
      @endforeach
    </div>
    <a href="{{ route('clients.index') }}" class="link-arrow">See all our clients →</a>
  </div>
</section>
@endif
