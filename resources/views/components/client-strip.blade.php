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
    $total = \App\Models\Client::count();
    // A "see all" tile closes a half-empty last row (desktop shows 6 per row); full rows get the header button only.
    $fillTile = $clients->count() % 6 !== 0;
@endphp
@if ($clients->isNotEmpty())
<section class="section-tight cs-section" {{ $attributes }}>
  <div class="wrap">
    <div class="cs-head reveal">
      <div class="section-head">
        <div class="eyebrow-line"><span class="bar"></span><span>{{ $eyebrow }}</span></div>
        <h2>{{ $title }}</h2>
        <p class="cs-sub">Restaurants, retailers, pharmacies, schools and distributors across Pakistan run their counters on myPOS.</p>
      </div>
      <div class="cs-meta">
        <div class="cs-stat"><strong>{{ $total }}+</strong><span>businesses on myPOS</span></div>
        <a href="{{ route('clients.index') }}" class="btn btn-ghost">See all our clients →</a>
      </div>
    </div>
    <ul class="cs-grid">
      @foreach ($clients as $c)
        <li class="reveal">
          <a href="{{ $c->url }}" class="cs-card">
            <span class="cs-logo"><img src="{{ asset(ltrim($c->logo, '/')) }}" alt="{{ $c->name }} logo" loading="lazy"></span>
            <span class="cs-name">{{ $c->name }}</span>
          </a>
        </li>
      @endforeach
      @if ($fillTile)
        <li class="reveal">
          <a href="{{ route('clients.index') }}" class="cs-card cs-more">
            <strong>+{{ max($total - $clients->count(), 0) }}</strong>
            <span>more businesses</span>
            <em>View all →</em>
          </a>
        </li>
      @endif
    </ul>
  </div>
</section>
@endif
