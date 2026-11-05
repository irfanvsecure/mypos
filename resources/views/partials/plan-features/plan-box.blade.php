{{--
  "Part of the Standard Plan" CTA + sibling plan-feature navigation + call box.
  Facts (Rs. 2,000/month, free for 14 days, register link, included items) mirror /pricing.
  Params: current (slug of this page), name (feature name)
--}}
@php
    $planFeatures = [
        ['Single Location', '/single-location'],
        ['Inventory', '/inventory'],
        ['Sales', '/sales'],
        ['Purchase', '/purchase'],
        ['Expense', '/expense'],
        ['Expiry', '/expiry'],
        ['Bulk Import', '/bulk-import'],
        ['Commissions', '/commissions'],
        ['Returns', '/returns'],
        ['Payment Accounts', '/payment-accounts'],
        ['Unlimited Products', '/unlimited-products'],
        ['On Call Support', '/on-call-support'],
        ['Biller/Permission', '/biller-permission'],
        ['Reports', '/reports'],
    ];
@endphp
<section id="{{ $current }}--plan" class="u-background-var-paper-2 bg-paper2">
  <div class="wrap">
    <div class="u-margin-bottom-44px section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>STANDARD PLAN</span></div>
      <h2>{{ $name }} is part of the Standard Plan.</h2>
      <p>Get {{ $name }} and every other Standard Plan feature for Rs. 2,000/month — free for 14 days.</p>
    </div>
    <div class="plan-layout">
      <div class="plan-card reveal-left">
        <div class="pc-badge">STANDARD</div>
        <div class="u-font-size-1-5rem-mar-50d4e h3">Standard Plan</div>
        <div class="pc-trial">Free for 14 days</div>
        <div class="pc-price">Rs. 2,000<span>/month</span></div>
        <nav aria-label="Standard Plan features">
          <ul class="plan-included">
            @foreach ($planFeatures as [$label, $href])
              <li @if ($href === '/' . $current) aria-current="page" style="color:var(--coral-soft); font-weight:700;" @endif>
                <svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>
                @if ($href === '/' . $current)
                  <span class="u-color-var-coral-soft">{{ $label }}</span>
                @else
                  <a class="u-color-inherit-text-d-85383" href="{{ url($href) }}">{{ $label }}</a>
                @endif
              </li>
            @endforeach
          </ul>
        </nav>
        <div class="btn-row">
          <a href="{{ demo_url() }}" class="btn btn-primary">Book a Free Demo</a>
          <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
          <a href="{{ config('site.register_url') }}" class="btn-secondary-link" target="_blank" rel="noopener">Or start the 14-day trial</a>
          <a href="{{ url('/pricing') }}" class="btn-secondary-link">See full pricing &amp; add-on modules</a>
        </div>
      </div>

      <div class="addon-card reveal-right">
        <div class="h3">Not sure this is the right plan? We will set it up with you.</div>
        <a class="u-display-block-font-f-f44ec" href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a>
        <div class="u-font-size-0-9rem-col-112d4">Call us anytime</div>
        <div class="u-display-flex-flex-wr-13162 btn-row">
          <a href="{{ demo_url() }}" class="btn btn-primary btn-sm">Book a Free Demo</a>
          <a href="{{ wa_link() }}" class="btn btn-wa btn-sm" target="_blank" rel="noopener">WhatsApp Us</a>
        </div>
        <div class="u-margin-top-26px-bord-efead">
          <div class="addon-row"><span>Businesses using myPOS</span><span class="price">15,000+</span></div>
          <div class="addon-row"><span>Customer rating</span><span class="price">{{ config('site.rating_value') }}/5</span></div>
          <div class="addon-row"><span>Languages</span><span class="price">English / Urdu / Arabic</span></div>
          <div class="addon-row"><span>Tax integration</span><span class="price">FBR / PRA / KPRA / SRB</span></div>
        </div>
      </div>
    </div>
  </div>
</section>
