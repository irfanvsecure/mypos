@php
    $path = '/' . trim(request()->path(), '/');
    $isActive = fn ($href) => $href !== '/' && ($path === $href || str_starts_with($path, rtrim($href, '/') . '/'));
    $icons = config('site.nav_icons');
    $icon = fn ($key, $size = 20) => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($icons[$key] ?? '') . '</svg>';
    $menus = collect(config('site.menu'))->map(function ($menu) {
        $menu['all'] = $menu['items'] ?? array_merge(...array_values($menu['groups']));
        return $menu;
    });
@endphp
<nav class="nav" aria-label="Main">
  <div class="wrap">
    <a href="{{ route('home') }}" class="logo-mark"><picture><source srcset="{{ asset('images/logo-168.webp') }}" type="image/webp"><img src="{{ asset('images/logo.png') }}" alt="myPOS" width="84" height="84"></picture></a>
    <div class="nav-links">
      @foreach ($menus as $menu)
        @php $current = collect($menu['all'])->contains(fn ($i) => $isActive($i[1])) || (isset($menu['url']) && $isActive($menu['url'])); @endphp
        <div class="nav-item {{ $menu['type'] === 'mega' ? 'has-mega' : '' }} {{ $current ? 'is-current' : '' }}">
          @if (isset($menu['url']))
            <a href="{{ url($menu['url']) }}" aria-haspopup="true">{{ $menu['label'] }} <span class="caret"></span></a>
          @else
            <button type="button" aria-haspopup="true">{{ $menu['label'] }} <span class="caret"></span></button>
          @endif
          @if ($menu['type'] === 'mega')
            <div class="dropdown dropdown--mega">
              <div class="mega-cols" style="--cols:{{ collect($menu['groups'])->sum(fn ($i) => count($i) > 8 ? 2 : 1) }}">
                @foreach ($menu['groups'] as $group => $items)
                  <div class="mega-col {{ count($items) > 8 ? 'mega-col--wide' : '' }}">
                    <span class="dd-head">{{ $group }}</span>
                    <div class="mega-list {{ count($items) > 8 ? 'mega-list--2' : '' }}">
                      @foreach ($items as [$label, $href, $ic])
                        <a href="{{ url($href) }}" class="dd-link {{ $path === $href ? 'active' : '' }}"><span class="dd-ic">{!! $icon($ic) !!}</span>{{ $label }}</a>
                      @endforeach
                    </div>
                  </div>
                @endforeach
                @isset($menu['foot'])
                  <a href="{{ url($menu['foot'][1]) }}" class="dd-foot">{{ $menu['foot'][0] }} <span aria-hidden="true">→</span></a>
                @endisset
              </div>
              @include('partials.nav-promo', ['promo' => $menu['promo']])
            </div>
          @else
            <div class="dropdown dropdown--list {{ isset($menu['promo']) ? 'has-promo' : '' }}">
              <div class="dd-grid" style="--cols:{{ $menu['cols'] }}">
                @foreach ($menu['items'] as [$label, $href, $ic, $desc])
                  <a href="{{ url($href) }}" class="dd-link dd-link--desc {{ $path === $href ? 'active' : '' }}">
                    <span class="dd-ic">{!! $icon($ic) !!}</span>
                    <span class="dd-txt"><b>{{ $label }}</b><small>{{ $desc }}</small></span>
                  </a>
                @endforeach
              </div>
              @isset($menu['promo'])
                @include('partials.nav-promo', ['promo' => $menu['promo']])
              @endisset
            </div>
          @endif
        </div>
      @endforeach
    </div>
    <div class="nav-cta">
      <a href="tel:{{ config('site.phone_raw') }}" class="phone-pill">
        <span class="pp-ic">{!! $icon('call', 17) !!}</span>
        <span class="pp-txt"><small>Call or WhatsApp</small><b>{{ config('site.phone') }}</b></span>
      </a>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="nav-call" aria-label="Call {{ config('site.phone') }}">{!! $icon('call', 20) !!}</a>
      <button type="button" class="nav-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu"><span></span><span></span><span></span></button>
    </div>
  </div>
</nav>
<div class="mobile-menu" id="mobileMenu">
  <a href="{{ route('home') }}">Home</a>
  @foreach ($menus as $menu)
    <details>
      <summary>{{ $menu['label'] }}</summary>
      <div class="mm-items">
        @foreach ($menu['all'] as [$label, $href, $ic])
          <a href="{{ url($href) }}"><span class="dd-ic">{!! $icon($ic, 18) !!}</span>{{ $label }}</a>
        @endforeach
      </div>
    </details>
  @endforeach
  <div class="mm-cta">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
    <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
  </div>
</div>
