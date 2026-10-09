@extends('layouts.app')

@section('page', 'woocommerce-pos')
@section('title', 'WooCommerce POS Integration')
@section('description', 'Seamlessly merge online and in-store experiences with our WooCommerce POS integration. Elevate your business efficiency and customer satisfaction effortlessly.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $why = [
    ['2023/12/Untitled-1-1-jpg.webp', 'Always in sync', 'WooCommerce uses the same database as your offline myPOS Retail store. Whether you make a offline sale or you receive an online order – your inventory is always in sync.'],
    ['2023/12/Asset-2-jpg.webp', 'No monthly fees', 'Just like WordPress, WooCommerce is an open source solution and most of its plugins are free to use. You own your data with no monthly fees.'],
    ['2023/12/Asset-3-jpg.webp', 'The missing piece', 'WordPress + WooCommerce are a powerful combination for online retail. Online store is the missing piece of the puzzle for store owners and myPOS is there for you.'],
  ];
  $features = [
    ['2022/09/get-started.png', 'Get started in minutes', 'Getting started with WooCommerce & myPOS integration is easy. Simply link your online store with myPOS, customize your settings and that’s it!'],
    ['2022/09/select-sync-option.png', 'Select sync option', 'Select the myPOS inventory you want to appear on your WooCommerce store, whether that’s your entire range of products or select specific range from your existing inventory.'],
    ['2022/09/seamless-inventory.png', 'Seamless inventory', 'Sales, Purchases, Inventory take or any other transaction will instantly update inventor on both platforms: myPOS and WooCommerce.'],
    ['2022/09/sysnc-order.png', 'Sync orders', 'Any orders placed in WooCommerce will be immediately synced to myPOS. Your staff can manage both in-store and online orders using myPOS sales dashboard.'],
    ['2022/09/Robust.png', 'Robust product management', 'A centralized inventory and catalog means no more double entry. Easily add, update or remove an item using myPOS and changes are instantly reflected in your WooCommerce store.'],
    ['2022/09/detail-sync-log.png', 'Detailed sync log', 'myPOS keeps accessible data sync log. If something fails to sync, simply check the log to see what failed and why. The log lets you zero in on the information that you require to fix broken data.'],
    ['2022/09/customer-profile.png', 'Customer profiles', 'Existing user profile updates and new user accounts are synchronized from myPOS to WooCommerce and vice-a-versa.'],
    ['2022/09/analytics.png', 'Analytics', 'With complete sales integration, use myPOS’s sales reporting to gain insights into both in-store and online sales.'],
    ['2022/09/sysnc-existing-catalog.png', 'Sync existing catalog', 'Already using myPOS or WooCommerce? Automatically sync your existing inventory from myPOS to Woo or other way around.'],
  ];
@endphp

@section('content')
<x-page-header title="WooCommerce Integration" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Use myPOS as your WooCommerce POS to empower your business with a robust retail solution — one inventory for your shop and your online store." :call="true" />

<section id="woocommerce-pos--why">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY WOOCOMMERCE + MYPOS</span></div>
      <h2>Online and in-store, finally in one place.</h2>
    </div>
    <div class="integ-grid stagger">
      @foreach ($why as $i => [$img, $title, $text])
        <div class="integ-card reveal-scale" style="--i:{{ $i }}; padding:0; overflow:hidden;">
          <img src="{{ asset('uploads/' . $img) }}" alt="WooCommerce Integration — {{ $title }}" loading="lazy" style="width:100%; aspect-ratio:16/10; object-fit:cover;">
          <div style="padding:24px 26px 6px;">
            <h3>{{ $title }}</h3>
            <p>{{ $text }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="woocommerce-pos--overview" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="media-frame contain reveal-left">
      <img src="{{ asset('uploads/2023/12/pngwing-jpg.webp') }}" alt="WooCommerce POS Integration with myPOS" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WOOCOMMERCE POS</span></div>
      <h2>WooCommerce POS Integration</h2>
      <p style="font-weight:600; color:var(--text-ink);">Use myPOS as your WooCommerce POS to empower your business with a robust retail solution.</p>
      <p>WooCommerce on WordPress is a great way to sell online. myPOS is a brilliant in-store point of sale solution. myPOS seamlessly integrates with WooCommerce, giving you central access to all your customers, inventory, product catalog and more.</p>
      <p>Control and manage every aspect of your business, from an all-in-one retail POS solution.</p>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <span class="num"><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="woocommerce-pos--features">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>SALIENT FEATURES</span></div>
      <h2>myPOS + WooCommerce</h2>
      <p>Everything syncs both ways — products, stock, orders and customers.</p>
    </div>
    <div class="integ-grid stagger">
      @foreach ($features as $i => [$img, $title, $text])
        <div class="integ-card reveal-scale" style="--i:{{ $i % 3 }}">
          <img src="{{ asset('uploads/' . $img) }}" alt="WooCommerce Integration — {{ $title }}" loading="lazy" style="width:52px; height:52px; object-fit:contain; margin-bottom:18px;">
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
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

<section id="woocommerce-pos--get-started">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>GET STARTED</span></div>
      <h2>Ready to get started?</h2>
      <p>If you’re already a Mypos and WooCommerce user, simply login to Mypos, go to integrations and connect your WooCommerce store with MyPOS. New to Mypos or Woo? get started with a free trial!</p>
    </div>
    <div class="free-band reveal" style="margin-top:40px;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 3v9M6.5 8.5L10 12l3.5-3.5M4 14v3h12v-3" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Try out the free version</h3>
        <ul>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Support is not Included</li>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Fully compatible with Windows 7, 8, 10</li>
        </ul>
      </div>
      <a href="{{ url('/download') }}" class="btn btn-primary" style="white-space:nowrap;">Download Now</a>
    </div>
  </div>
</section>

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/multi-location-integration') }}">Multi Location Integration</a>
      <a href="{{ url('/customers') }}">Customers Management</a>
      <a href="{{ url('/paperless-invoicing') }}">Paperless Invoicing</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Connect your WooCommerce store to myPOS." text="Book a free demo — we will link your online store, sync your catalog and train your staff." :bg="true" />
@endsection
