<footer>
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="logo-mark"><img src="{{ asset('images/logo.png') }}" alt="myPOS logo" width="52" height="52" loading="lazy"><span class="word">myPOS</span></a>
      <p>Pakistan's leading free POS software for retail, restaurant, salon and laundry businesses — with FBR &amp; PRA compliance built in.</p>
      <ul style="margin-top:18px;">
        <li><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></li>
        <li><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
        <li style="max-width:260px;">{{ config('site.address') }}</li>
      </ul>
    </div>
    @foreach (config('site.footer') as $heading => $links)
      <div>
        <h4>{{ $heading }}</h4>
        <ul>
          @foreach ($links as [$label, $href])
            <li><a href="{{ url($href) }}">{{ $label }}</a></li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>
  <div class="wrap footer-bottom">
    <span>© 2018–{{ date('Y') }} myPOS | Pakistan's Best Point of Sale Software. All rights reserved.</span>
    <span>
      @foreach (config('site.legal') as [$label, $href])
        <a href="{{ url($href) }}">{{ $label }}</a>@if (!$loop->last) · @endif
      @endforeach
    </span>
  </div>
</footer>
