<footer>
  <div class="wrap footer-grid">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="footer-logo" aria-label="myPOS home">
        <span class="footer-logo-mark" aria-hidden="true"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4M7 9h6M7 12h3"/></svg></span>
        <span class="footer-logo-text">my<b>POS</b></span>
      </a>
      <p>{!! config('site.footer_tagline') !!}</p>
      <ul class="u-margin-top-18px">
        <li><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></li>
        <li><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
        <li class="u-max-width-260px">{{ config('site.address') }}</li>
      </ul>
      <div class="footer-cta">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    </div>
    <div class="footer-links">
      @foreach (config('site.footer') as $heading => $links)
        <div>
          <div class="h4">{{ $heading }}</div>
          <ul>
            @foreach ($links as [$label, $href])
              <li><a href="{{ url($href) }}">{{ $label }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </div>
  <div class="wrap footer-bottom">
    <span>© {{ config('site.footer_since') }}–{{ date('Y') }} {!! config('site.footer_copyright') !!}</span>
    <span>
      @foreach (config('site.legal') as [$label, $href])
        <a href="{{ url($href) }}">{{ $label }}</a>@if (!$loop->last) · @endif
      @endforeach
    </span>
  </div>
</footer>
