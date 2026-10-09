@extends('layouts.app')

@section('page', 'pricing')
@section('title', 'Monthly Subscription - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'myPOS offers monthly payment plan which helps new businesses to focus on their work and keep it cost effective as well. contact us at +92 322 4765528')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Monthly Subscription" crumb="Pricing" eyebrow="PRICING"
  lead="Start free for 14 days, then just Rs. 2,000 per month — add only the modules your business needs." :call="true" />

<section id="pricing--plan">
  <div class="wrap plan-layout">
    <div class="plan-card reveal-left">
      <div style="display:flex; align-items:center; gap:14px; margin-bottom:18px;">
        <img src="{{ asset('uploads/2015/07/home_software_pricing_icon_2.png') }}" alt="Monthly Subscription" style="width:52px; height:52px; object-fit:contain; background:#fff; border-radius:12px; padding:6px;">
        <div class="pc-badge" style="margin:0;">STANDARD</div>
      </div>
      <h2>Standard Plan</h2>
      <div class="pc-trial">Free for 14 days</div>
      <div class="pc-price">Rs. 2,000<span>/month</span></div>
      <div class="pc-trial" style="margin-top:-18px; margin-bottom:22px;">2000/- Per Month after your free trial</div>
      <ul class="plan-included">
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/Single-Location') }}">Single Location</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/Inventory') }}">Inventory</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/sales') }}">Sales</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/purchase') }}">Purchase</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/expense') }}">Expense</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/expiry') }}">Expiry</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/bulk-import') }}">Bulk Import</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/commissions') }}">Commissions</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/returns') }}">Returns</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/payment-accounts') }}">Payment Accounts</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/unlimited-products') }}">Unlimited Products</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/on-call-support') }}">On Call Support</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/biller-permission') }}">Biller/Permission</a></li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><a href="{{ url('/reports') }}">Reports</a></li>
      </ul>
      <div class="btn-row">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
        <a href="{{ config('site.register_url') }}" class="btn-secondary-link" target="_blank" rel="noopener">Or start the 14-day trial</a>
        <a href="{{ url('/one-time-pricing') }}" class="btn-secondary-link">One-time payment plan</a>
      </div>
      <x-cta-proof />
    </div>

    <div class="addon-card reveal-right">
      <h3>Add-on Modules</h3>
        <div class="addon-row"><span>Offline Module</span><span class="price">+ 500/-</span></div>
        <div class="addon-row"><span>Accounting Module</span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span>Instalment Module</span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span>FBR Digital Invoicing</span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span>FBR/PRA/SBR POS Integration</span><span class="price">+ 500/-</span></div>
        <div class="addon-row"><span>Whatsapp Invoicing</span><span class="price">+ 500/-</span></div>
        <div class="addon-row"><span>Manufacturing Module</span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span><a href="{{ url('/woocommerce-integration') }}" style="text-decoration:underline; text-underline-offset:3px;">Woocommerce Integration</a></span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span><a href="{{ url('/online-store-catalogue') }}" style="text-decoration:underline; text-underline-offset:3px;">Online Store Catalogue</a></span><span class="price">+ 1000/-</span></div>
        <div class="addon-row"><span><a href="{{ url('/mobile-mypos') }}" style="text-decoration:underline; text-underline-offset:3px;">Mobile App</a></span><span class="price">+ 1000/-</span></div>
    </div>
  </div>

  <div class="wrap">
    <div class="section-head reveal" style="margin-top:70px;">
      <div class="eyebrow-line"><span class="bar"></span><span>EVERY PLAN INCLUDES</span></div>
      <h2>Core features, built in.</h2>
    </div>
    <div class="core-grid stagger">
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Easy to configure</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Touch Screen Ready</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multi Registers</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Customer Debit/Credit</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Backup/Restore</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Bulk Upload Option</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Barcode Printing</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multiple Languages</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Supplier Management</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multiple Payment Option</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>User Access Levels</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Customizable Invoice</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Employee Salary</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Low Stock Alerts</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Product Expiry Alerts</a>
      <a href="{{ url('/features') }}" class="core-item"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>And much more...</a>
    </div>
    <div class="related-links reveal" style="margin-top:44px;">
      <a href="{{ url('/one-time-pricing') }}">One-time Pricing</a>
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/pricing-salonpro') }}">SalonPro Pricing</a>
      <a href="{{ url('/pricing-laundry-pro') }}">LaundryPro Pricing</a>
      <a href="{{ url('/pricing-tailorpro') }}">TailorPro Pricing</a>
      <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
    </div>
  </div>
</section>

<x-cta-band title="Not sure which modules you need?" text="Tell us which modules you use and we will recommend the right setup — free demo, no obligation." />
@endsection
