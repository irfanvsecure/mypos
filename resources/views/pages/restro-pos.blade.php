@extends('layouts.app')

@section('page', 'restro-pos')
@section('title', 'Restro POS - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $modes = ['Dine in', 'Delivery', 'Takeaway', 'Touch Screen', 'Kitchen Print', 'Multi Registers', 'Backup/Restore', 'Online Order', 'Employee Salary'];
  $modules = [
    [null, 'Cashier Module'],
    [null, 'Waiter’s App'],
    ['2021/07/Real-time_Reports-removebg-preview.png', 'Real Time Reports'],
    ['2021/07/Table_Management-removebg-preview.png', 'Table Management'],
    ['2021/07/Accept_Digital_Payments-removebg-preview.png', 'Accept Digital Payments'],
    ['2021/07/Inventory-Management-1024x1024.png', 'Inventory Management'],
    [null, 'Delivery Apps Integration'],
    ['2021/07/Kitchen_Display_System-removebg-preview.png', 'Kitchen Display System'],
    [null, 'Low Stock and Expiry Alert'],
  ];
  $inventory = ['Product Manager', 'Make Deal', 'Search Item', 'Import Categories', 'MyShops.pk', 'Import Product', 'Barcode Templates', 'Barcode Labels', 'Tables', 'Barcode Printing', 'Toppings', 'Stock Adjustment', 'Stock Audit', 'Stock Audit Report'];
  $sales = ['New Sale Invoice', 'New Sale Order', 'Sale Return', 'Sale History', 'Import Sale', 'Online Food Portal', 'Order Delivery', 'Customers', 'Customers Balances', 'Customer Receipt', 'Customer Payment', 'Receipt and Payment History', 'Delivery Master Report', 'Stock Audit Report', 'Plate Report', 'Daily Expenses', 'Stock Transfer Register'];
@endphp

@section('content')
<x-page-header title="Restro POS" eyebrow="MYPOS RESTROPRO" crumb="Restro POS"
  lead="The restaurant POS for dine in, delivery and takeaway &mdash; cashier module, waiter&rsquo;s app, kitchen print and display, table management and real time reports in one system.">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
    <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/download/restropro') }}" class="btn btn-outline">Download RestroPro</a>
  </div>
  <div class="hero-trust">
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>Offline</b><span>Keeps billing without internet</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>FBR &amp; PRA</b><span>Integrated invoicing</span></div>
  </div>
</x-page-header>

<section id="restro-pos--what-you-want">
  <div class="wrap split">
    <div class="reveal-left">
      <img src="{{ asset('uploads/2021/07/laptop_PNG5887-removebg-preview-1.png') }}" alt="Restro POS running on a laptop" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>ONE POS, EVERY ORDER TYPE</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">What You Want!</h2>
      <p>Whatever way your restaurant serves, Restro POS has it covered:</p>
      <ul class="check-grid" style="grid-template-columns:repeat(2,1fr);">
        @foreach ($modes as $m)<li>{{ $m }}</li>@endforeach
      </ul>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
  </div>
</section>

<section id="restro-pos--modules" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="split" style="align-items:start;">
      <div>
        <div class="section-head reveal">
          <div class="eyebrow-line"><span class="bar"></span><span>CORE MODULES</span></div>
          <h2>Everything your restaurant runs on.</h2>
        </div>
        <div class="icon-row-grid stagger" style="grid-template-columns:repeat(2,1fr);">
          @foreach ($modules as $i => [$img, $label])
            <div class="icon-row-card reveal-scale" style="--i:{{ $i }}">
              @if ($img)
                <div class="ic-wrap" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $label }}" loading="lazy" style="width:30px; height:30px; object-fit:contain;"></div>
              @else
                <div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M5 10.2L8.4 13.5L15 6.5" stroke="#fff" stroke-width="1.8"/></svg></div>
              @endif
              <span>{{ $label }}</span>
            </div>
          @endforeach
        </div>
      </div>
      <div class="reveal-right">
        <img src="{{ asset('uploads/2021/07/apple-606761_1920-removebg-preview.png') }}" alt="Restro POS on desktop and tablet" loading="lazy" style="height:auto; object-fit:contain;">
      </div>
    </div>
  </div>
</section>

<section id="restro-pos--inventory">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="media-frame contain"><img src="{{ asset('uploads/2021/07/laptop_PNG5887-1-1.png') }}" alt="Restro POS inventory modules on a laptop" loading="lazy" style="height:auto;"></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>INVENTORY</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;"><b>Inventory Modules and Features</b></h2>
      <ul class="check-grid" style="grid-template-columns:repeat(2,1fr);">
        @foreach ($inventory as $m)<li>{{ $m }}</li>@endforeach
      </ul>
    </div>
  </div>
</section>

<section id="restro-pos--sales" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>SALES</span></div>
      <h2><b>Sales Modules and Features</b></h2>
      <p>From new sale invoices and orders to deliveries, customer balances and daily expenses &mdash; every sales workflow is built in.</p>
    </div>
    <ul class="check-grid reveal">
      @foreach ($sales as $m)<li>{{ $m }}</li>@endforeach
    </ul>
    <div class="cta-inline reveal"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><a href="{{ url('/pricing-restropro') }}" class="btn btn-outline">See RestroPro Pricing</a></div>
  </div>
</section>

<section id="restro-pos--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Pricing, downloads &amp; compliance for restaurants.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/download/restropro') }}">Download RestroPro</a>
      <a href="{{ url('/restaurant-management') }}">Restaurant Management</a>
      <a href="{{ url('/home-delivery') }}">Home Delivery</a>
      <a href="{{ url('/pra-pos-restaurant-integration') }}">Restaurant PRA POS Integration</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    </div>
  </div>
</section>

<x-cta-band title="Ready to run your restaurant on Restro POS?"
  text="Book a free demo &mdash; our team will set up RestroPro for your dine in, delivery and takeaway service, including FBR &amp; PRA integration, and train your staff." />
@endsection
