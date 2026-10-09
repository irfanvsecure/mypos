@php
    $path = '/' . trim(request()->path(), '/');
    $isActive = fn ($href) => $href !== '/' && ($path === $href || str_starts_with($path, rtrim($href, '/') . '/'));
@endphp
<nav class="nav" aria-label="Main">
  <div class="wrap">
    <a href="{{ route('home') }}" class="logo-mark"><img src="{{ asset('images/logo.png') }}" alt="myPOS" width="84" height="84"></a>
    <div class="nav-links">
      @foreach (config('site.menu') as $menu)
        @php $current = collect($menu['items'])->contains(fn ($i) => $isActive($i[1])) || (isset($menu['url']) && $isActive($menu['url'])); @endphp
        <div class="nav-item {{ $current ? 'is-current' : '' }}">
          @if (isset($menu['url']))
            <a href="{{ url($menu['url']) }}" aria-haspopup="true">{{ $menu['label'] }} <span class="caret"></span></a>
          @else
            <button type="button" aria-haspopup="true">{{ $menu['label'] }} <span class="caret"></span></button>
          @endif
          <div class="dropdown {{ $menu['wide'] ? 'dropdown--wide' : '' }}">
            @isset($menu['head'])<span class="dd-head">{{ $menu['head'] }}</span>@endisset
            @foreach ($menu['items'] as [$label, $href])
              <a href="{{ url($href) }}" class="{{ $path === $href ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
            @isset($menu['foot'])<a href="{{ url($menu['foot'][1]) }}" class="dd-foot">{{ $menu['foot'][0] }}</a>@endisset
          </div>
        </div>
      @endforeach
    </div>
    <div class="nav-cta">
      <a href="tel:{{ config('site.phone_raw') }}" class="phone-pill">{{ config('site.phone') }}</a>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <button type="button" class="nav-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu"><span></span><span></span><span></span></button>
    </div>
  </div>
</nav>
<div class="mobile-menu" id="mobileMenu">
  <a href="{{ route('home') }}">Home</a>
  @foreach (config('site.menu') as $menu)
    <details>
      <summary>{{ $menu['label'] }}</summary>
      @foreach ($menu['items'] as [$label, $href])
        <a href="{{ url($href) }}">{{ $label }}</a>
      @endforeach
    </details>
  @endforeach
  <div class="mm-cta">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
    <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
  </div>
</div>
