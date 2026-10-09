<footer>
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="logo-mark"><img src="{{ asset('images/logo.png') }}" alt="myPOS" width="96" height="96" loading="lazy"></a>
      <p>Pakistan's leading free POS software for retail, restaurant, salon and laundry businesses — with FBR &amp; PRA compliance built in.</p>
      <ul style="margin-top:18px;">
        <li><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></li>
        <li><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
        <li style="max-width:260px;">{{ config('site.address') }}</li>
      </ul>
      <div class="footer-cta">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      </div>
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
