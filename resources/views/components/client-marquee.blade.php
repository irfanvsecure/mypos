@props([
    // Two rows of [logo file, client name, portfolio-item slug|null] — same logos and order as the WordPress home slider.
    'rows' => [],
    'title' => 'Our Clients',
    'eyebrow' => 'TRUSTED BY',
])
@php $total = \App\Models\Client::count(); @endphp
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
  </div>
  <div class="cm-rows">
    @foreach ($rows as $i => $row)
      <div class="cm-row">
        {{-- The list is rendered twice so the track can loop seamlessly; the copy is hidden from screen readers. --}}
        <div class="cm-track {{ $i % 2 ? 'cm-rev' : '' }}" style="--cm-count:{{ count($row) }}">
          @foreach ([false, true] as $copy)
            @foreach ($row as [$logo, $name, $slug])
              <a href="{{ $slug ? route('clients.show', $slug) : route('clients.index') }}" class="cm-logo" @if ($copy) aria-hidden="true" tabindex="-1" @endif>
                <picture>
                  @if (is_file(public_path('uploads/' . ($webp = preg_replace('/\.jpe?g$/', '-420.webp', $logo)))))
                    <source srcset="{{ asset('uploads/' . $webp) }}" type="image/webp">
                  @endif
                  <img src="{{ asset('uploads/' . $logo) }}" alt="{{ $copy ? '' : $name . ' logo' }}" title="{{ $name }}" loading="lazy" width="210" height="130">
                </picture>
              </a>
            @endforeach
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</section>
