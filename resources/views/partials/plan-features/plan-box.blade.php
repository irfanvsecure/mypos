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
<section id="{{ $current }}--plan" class="bg-paper2" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal" style="margin-bottom:44px;">
      <div class="eyebrow-line"><span class="bar"></span><span>STANDARD PLAN</span></div>
      <h2>{{ $name }} is part of the Standard Plan.</h2>
      <p>Get {{ $name }} and every other Standard Plan feature for Rs. 2,000/month — free for 14 days.</p>
    </div>
    <div class="plan-layout">
      <div class="plan-card reveal-left">
        <div class="pc-badge">STANDARD</div>
        <h3 style="font-size:1.5rem; margin-bottom:6px;">Standard Plan</h3>
        <div class="pc-trial">Free for 14 days</div>
        <div class="pc-price">Rs. 2,000<span>/month</span></div>
        <nav aria-label="Standard Plan features">
          <ul class="plan-included">
            @foreach ($planFeatures as [$label, $href])
              <li @if ($href === '/' . $current) aria-current="page" style="color:var(--coral-soft); font-weight:700;" @endif>
                <svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>
                @if ($href === '/' . $current)
                  <span style="color:var(--coral-soft);">{{ $label }}</span>
                @else
                  <a href="{{ url($href) }}" style="color:inherit; text-decoration:underline; text-decoration-color:rgba(255,255,255,0.25); text-underline-offset:3px;">{{ $label }}</a>
                @endif
              </li>
            @endforeach
          </ul>
        </nav>
        <div class="btn-row">
          <a href="{{ config('site.register_url') }}" class="btn btn-primary" target="_blank" rel="noopener">Start Your 14-Day Free Trial</a>
          <a href="{{ url('/pricing') }}" class="btn-secondary-link">See full pricing &amp; add-on modules</a>
        </div>
      </div>

      <div class="addon-card reveal-right">
        <h3>Give Us a Call to find out more about our Point of Sale Software.</h3>
        <a href="tel:{{ config('site.phone_raw') }}" style="display:block; font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.6rem; color:var(--navy);">{{ config('site.phone') }}</a>
        <div style="font-size:0.9rem; color:var(--text-mute-ink); margin-top:4px;">Call us anytime</div>
        <div class="btn-row" style="display:flex; flex-wrap:wrap; gap:10px; margin-top:22px;">
          <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary btn-sm">Get In Touch</a>
          <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa btn-sm" target="_blank" rel="noopener">WhatsApp Us</a>
        </div>
        <div style="margin-top:26px; border-top:1px solid var(--paper-line); padding-top:6px;">
          <div class="addon-row"><span>Businesses using myPOS</span><span class="price">15,000+</span></div>
          <div class="addon-row"><span>Customer rating</span><span class="price">4.9/5</span></div>
          <div class="addon-row"><span>Languages</span><span class="price">English / Urdu / Arabic</span></div>
          <div class="addon-row"><span>Tax integration</span><span class="price">FBR / PRA / KPRA / SRB</span></div>
        </div>
      </div>
    </div>
  </div>
</section>
