@extends('layouts.app')

@section('page', 'pricing-tailorpro')
@section('title', 'Pricing TailorPro - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Pricing TailorPro" eyebrow="TAILORPRO · ONE-TIME LICENSE" :crumbs="[['Pricing', '/pricing']]" crumb="TailorPro"
  lead="Give Us a Call to find out more about our Point of Sale Software. Start free, then pick the one-time TailorPro license that fits your tailoring business." :call="true" />

<section class="section-tight" style="padding-bottom:0;">
  <div class="wrap">
    <nav class="related-links reveal" aria-label="Pricing by product" style="margin-top:0; justify-content:center;">
      <a href="{{ url('/pricing') }}">RetailPro (Monthly)</a>
      <a href="{{ url('/pricing-restropro') }}">RestroPro</a>
      <a href="{{ url('/pricing-salonpro') }}">SalonPro</a>
      <a href="{{ url('/pricing-laundry-pro') }}">LaundryPro</a>
      <a href="{{ url('/pricing-tailorpro') }}" aria-current="page" style="background:var(--navy); color:var(--text-on-dark); border-color:var(--navy);">TailorPro</a>
      <a href="{{ url('/one-time-pricing') }}">RetailPro (One-time)</a>
    </nav>
  </div>
</section>

<section id="plans" class="section-tight">
  <div class="wrap">
    <div class="section-head center reveal" style="margin:0 auto; text-align:center; max-width:680px;">
      <div class="eyebrow-line" style="justify-content:center;"><span class="bar"></span><span>TAILORPRO PLANS</span></div>
      <h2>Pay once, own your TailorPro license.</h2>
      <p>Start with the free Primary edition and upgrade as your tailoring business grows.</p>
    </div>
    <div class="pricing-grid pricing-grid-4 stagger">
      <div class="price-card reveal-scale" style="--i:0">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
          <div class="pc-badge" style="margin-bottom:0;">PRIMARY</div>
          <img src="{{ asset('uploads/2015/07/home_software_pricing_icon_4.png') }}" alt="Pricing TailorPro — Primary plan" width="44" height="44" loading="lazy" style="width:44px; height:44px; object-fit:contain;">
        </div>
        <h3 style="margin-top:16px;">Primary</h3>
        <div class="pc-price">FREE</div>
        <div class="pc-sub">Free forever — download &amp; start selling</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Single Location</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Inventory</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Sale</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Reports</li>
        </ul>
        <a href="{{ url('/download/tailorpro') }}" class="btn btn-ghost">Download TailorPro</a>
      </div>
      <div class="price-card reveal-scale" style="--i:1">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
          <div class="pc-badge" style="margin-bottom:0;">BASIC</div>
          <img src="{{ asset('uploads/2015/07/home_software_pricing_icon_1.png') }}" alt="Pricing TailorPro — Basic plan" width="44" height="44" loading="lazy" style="width:44px; height:44px; object-fit:contain;">
        </div>
        <h3 style="margin-top:16px;">Basic</h3>
        <div class="pc-price">Rs. 24,000</div>
        <div class="pc-sub">One-time license fee</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Single Location</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Inventory</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Sale</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Purchase</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Expense</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Biller/Permission</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Reports</li>
        </ul>
        <a href="{{ url('/download/tailorpro') }}" class="btn btn-ghost">Download TailorPro</a>
      </div>
      <div class="price-card featured reveal-scale" style="--i:2">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
          <div class="pc-badge" style="margin-bottom:0;">STANDARD</div>
          <img src="{{ asset('uploads/2015/07/home_software_pricing_icon_2.png') }}" alt="Pricing TailorPro — Standard plan" width="44" height="44" loading="lazy" style="width:44px; height:44px; object-fit:contain;">
        </div>
        <h3 style="margin-top:16px;">Standard</h3>
        <div class="pc-price">Rs. 36,500</div>
        <div class="pc-sub">One-time license fee</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Single Location</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Inventory</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Sale</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Purchase</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Expense</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Transfer</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Stock Audit</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Accounting</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Whatsapp</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Employee</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Biller/Permission</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Reports</li>
        </ul>
        <a href="{{ url('/download/tailorpro') }}" class="btn btn-primary">Download TailorPro</a>
      </div>
      <div class="price-card reveal-scale" style="--i:3">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
          <div class="pc-badge" style="margin-bottom:0;">PREMIUM</div>
          <img src="{{ asset('uploads/2015/07/home_software_pricing_icon_3.png') }}" alt="Pricing TailorPro — Premium plan" width="44" height="44" loading="lazy" style="width:44px; height:44px; object-fit:contain;">
        </div>
        <h3 style="margin-top:16px;">Premium</h3>
        <div class="pc-price">Contact</div>
        <div class="pc-sub">Custom quote for multi-location setups</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multi Location</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Inventory</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Sale</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Purchase</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Expense</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Transfer</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Stock Audit</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Accounting</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Whatsapp</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Employee</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Biller/Permission</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Reports</li>
        </ul>
        <a href="{{ url('/contact') }}" class="btn btn-ghost">Write to Us</a>
      </div>
    </div>

    <div class="plan-layout" style="margin-top:64px;">
      <div class="plan-card reveal-left">
        <div class="pc-badge">PREFER TO PAY MONTHLY?</div>
        <h2>Monthly subscription plans</h2>
        <div class="pc-trial">Not ready for a one-time license? Our monthly Standard Plan is Rs. 2,000/month and free for 14 days.</div>
        <ul class="plan-included" style="margin-top:22px;">
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Low monthly cost</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Add-on modules any time</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>On Call Support</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>FBR/PRA integration add-ons</li>
        </ul>
        <div class="btn-row">
          <a href="{{ url('/pricing') }}" class="btn btn-primary">Checkout Our Monthly Subscription Plans</a>
          <a href="{{ url('/contact') }}#enquiry" class="btn-secondary-link">Not sure which plan fits? Get a free demo</a>
        </div>
      </div>

      <div class="addon-card reveal-right">
        <h3>Good to know</h3>
        <div class="addon-row"><span>* Additional terminal at same location would cost</span><span class="price">8000/-</span></div>
        <div class="addon-row"><span>Average support response time</span><span class="price">&lt; 2 min</span></div>
        <div class="addon-row"><span>Businesses already using myPOS</span><span class="price">15,000+</span></div>
        <div class="addon-row"><span>Customer rating</span><span class="price">4.9/5</span></div>
      </div>
    </div>
  </div>
</section>

<section class="section-tight bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>EVERY TAILORPRO PLAN INCLUDES</span></div>
      <h2>Features</h2>
    </div>
    <div class="core-grid stagger">
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Unlimited Services</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Touch Screen Ready</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multi Registers</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Customer Debit/Credit</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Backup/Restore</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Customizable Invoice</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Easy Order Taking</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Online Booking Integration</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Supplier Management</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multiple Payment Option</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>User Access Levels</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Employee Salary</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Low Stock Alerts</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Product Expiry Alerts</a>
    </div>
    <p class="reveal" style="margin-top:28px;"><a href="{{ url('/features') }}" class="link-arrow">And much more... &rarr;</a></p>

    <div class="reveal" style="margin-top:48px;">
      <h3 style="font-size:1.05rem;">Related pages</h3>
      <div class="related-links">
        <a href="{{ url('/tailor-management') }}">Tailor Management Software</a>
        <a href="{{ url('/features') }}">All Features</a>
        <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
        <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
        <a href="{{ url('/pricing') }}">Monthly Subscription Plans</a>
      </div>
    </div>
  </div>
</section>

<x-cta-band title="Ready to run your tailoring business on TailorPro?" text="Download the free edition today or talk to our team — we will help you choose the right plan, set up FBR/PRA integration and train your staff." primary="Get Free Demo" />
@endsection
