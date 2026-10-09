@extends('layouts.app')

@section('page', 'mobile-mypos')
@section('title', 'myPOS Mobile: Secure and Seamless Mobile Payment Solutions')
@section('description', 'Explore the power of myPOS Mobile, your trusted partner for secure and convenient mobile payment solutions.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $benefits = [
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2" width="8" height="16" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M9 15.5h2" stroke="#fff" stroke-width="1.4"/></svg>', 'Sell from your handheld', 'Place orders and perform sale / purchase operations from your personal handheld device.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 18s6-5.2 6-10a6 6 0 10-12 0c0 4.8 6 10 6 10z" stroke="#fff" stroke-width="1.4"/><circle cx="10" cy="8" r="2.2" stroke="#fff" stroke-width="1.3"/></svg>', 'Location-aware products', 'Products / Items are displayed according to what is physically available at your location.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 6l7-3.5L17 6v8l-7 3.5L3 14V6z" stroke="#fff" stroke-width="1.4"/><path d="M3 6l7 3.5L17 6M10 9.5V17" stroke="#fff" stroke-width="1.4"/></svg>', 'Outlet stock guidance', 'Customers can see the location base store / outlet products stock before they visit.'],
  ];
  $includes = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option', 'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice', 'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Mobile POS" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Place orders and perform sale / purchase operations from your personal handheld device — with products shown according to stock at your location." :call="true" />

<section id="mobile-mypos--overview">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2023/12/1-1-jpg.webp') }}" alt="Mobile POS — myPOS on a handheld device" width="700" height="700" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>MOBILE MYPOS FACILITY</span></div>
      <h2>All in one Point Of Sale Software</h2>
      <p>It's the feature of best features that you can place order and perform sale / purchase operations from your personal handheld device. Even you can place orders according to your location and our myPOS will display products / Items according to physically available at that location.</p>
      <p>This feature of myPOS do not only save time of our Customers to first check the availability of the products and also guides them about the location base store / outlet products stock.</p>
      <div class="tag-cloud" style="margin-top:26px;">
        <span>SMS Software</span>
        <span>Retail &amp; Grocery</span>
        <span>Bakery</span>
      </div>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <span class="num"><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="mobile-mypos--benefits" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY GO MOBILE</span></div>
      <h2>Mobile myPOS Facility</h2>
      <p>Your store in your pocket — save time for your staff and your customers.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($benefits as $i => [$icon, $title, $text])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon">{!! $icon !!}</div>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="mobile-mypos--includes">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>EVERY PLAN INCLUDES</span></div>
      <h2>Salient Features</h2>
    </div>
    <ul class="check-grid reveal">
      @foreach ($includes as $item)
        <li><a href="{{ url('/features') }}">{{ $item }}</a></li>
      @endforeach
    </ul>
    <div class="cta-inline">
      <a href="{{ url('/pricing') }}" class="btn btn-primary">See Pricing</a>
      <a href="{{ url('/features') }}" class="link-arrow">Explore all features →</a>
    </div>
  </div>
</section>

<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num" data-count="15000">0</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num" data-count="12000">0</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num" data-decimal="4.9">0</div><div class="lbl">Average rating / 5</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">&lt;2min</div><div class="lbl">Avg. response time</div></div>
  </div>
</div>

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" eyebrow="MOBILE MYPOS SOFTWARE" title="Our Clients" />

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/multi-location-integration') }}">Multi Location Integration</a>
      <a href="{{ url('/customers') }}">Customers Management</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/woocommerce-pos') }}">WooCommerce Integration</a>
      <a href="{{ url('/paperless-invoicing') }}">Paperless Invoicing</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Take your POS wherever you go." text="Book a free demo — see Mobile myPOS place orders and check location stock from a handheld device." />
@endsection
