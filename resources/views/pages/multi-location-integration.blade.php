@extends('layouts.app')

@section('page', 'multi-location-integration')
@section('title', 'Multi Location Point of Sale (POS) Solutions for Seamless Business')
@section('description', 'Enhance business efficiency with our Multi-Location Point of Sale (POS) Solutions. Streamline operations seamlessly across multiple locations for optimal performance')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $benefits = [
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg>', 'Manage every branch from one place', 'Technology advancement facilitates managing multi locations from one location in an effective way.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="2" width="12" height="16" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M7 6h6M7 9h6M7 12h4" stroke="#fff" stroke-width="1.2"/></svg>', 'Pre-defined configuration', 'myPOS ships with pre-defined configuration modules for multi-outlet businesses.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8" stroke="#fff" stroke-width="1.4"/><path d="M2 10h16M10 2c2.2 2 3.3 5 3.3 8s-1.1 6-3.3 8c-2.2-2-3.3-5-3.3-8S7.8 4 10 2z" stroke="#fff" stroke-width="1.4"/></svg>', 'Online / Offline mode', 'Branches keep selling in Offline mode and stay connected in Online mode.'],
  ];
  $includes = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option', 'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice', 'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Multilocation Integration" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Open new outlets at any location and run them all from one place — with pre-defined configuration modules and Online / Offline mode." :call="true" />

<section id="multi-location-integration--overview">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2023/12/Asset-1-jpg.webp') }}" alt="Multilocation Integration — manage every branch with myPOS" width="700" height="700" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>MULTI LOCATION INTEGRATION</span></div>
      <h2>All in one Point Of Sale Software</h2>
      <p>It's becoming more common practice as Technology advancement facilitate to manage multi locations from on location in an effective way. So many businesses are expanding their branches by opening different outlets at different location without having any concern about geolocation. For these advance option, myPOS is fully functional and can be more efficient to be utilized for this kind of businesses.</p>
      <p>myPOS has a pre-defined configuration modules for these kind of businesses and with additional operational option for Online / Offline mode.</p>
      <div class="tag-cloud" style="margin-top:26px;">
        <span>Multi Company</span>
        <span>Retail &amp; Grocery</span>
        <span><a href="{{ url('/stock-management') }}" style="color:inherit;">Stock Management</a></span>
      </div>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <span class="num"><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="multi-location-integration--benefits" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2>Multi Location Integration Software</h2>
      <p>Grow from one outlet to many without worrying about geolocation.</p>
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

<section id="multi-location-integration--includes">
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

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/mobile-mypos') }}">Mobile POS</a>
      <a href="{{ url('/employee-management') }}">Employee Management</a>
      <a href="{{ url('/woocommerce-pos') }}">WooCommerce Integration</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Run every branch from one POS." text="Book a free demo — we will configure myPOS for all your outlets, online or offline." />
@endsection
