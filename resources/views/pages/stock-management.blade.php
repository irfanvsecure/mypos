@extends('layouts.app')

@section('page', 'stock-management')
@section('title', 'Best Stock Management Software | Inventory Management Software Free')
@section('description', 'Optimize stock control with the best stock management software. Our stock inventory management software ensures precision and efficiency for seamless business operations.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $ic = [
    'account'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="5" width="16" height="11" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M2 8.5h16M5 13h4" stroke="#fff" stroke-width="1.4"/></svg>',
    'employee' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="7" r="3.2" stroke="#fff" stroke-width="1.4"/><path d="M3.5 17c1-3.5 3.8-5.2 6.5-5.2s5.5 1.7 6.5 5.2" stroke="#fff" stroke-width="1.4"/></svg>',
    'company'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg>',
    'expense'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v13l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/><path d="M7 8h6M7 11h4" stroke="#fff" stroke-width="1.2"/></svg>',
    'mobile'   => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2" width="8" height="16" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M9 15.5h2" stroke="#fff" stroke-width="1.4"/></svg>',
    'lock'     => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="9" width="12" height="8" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M7 9V6.5a3 3 0 016 0V9" stroke="#fff" stroke-width="1.4"/></svg>',
  ];
  $features = [
    ['account', 'Account Management', 'The Account module is bundled with fully customized features, You can enable or disable features according to your need.'],
    ['employee', 'Employee Management', 'The Employee Management was never easy to handle and we have integrated the Employee Management in our POS.'],
    ['company', 'Multi Company', 'You can manage Multi Company business management in an effective and easy way to reduce burden.'],
    ['expense', 'Expense Management', 'The expense management is a big tough task and we made it so easy as it was never before. Even you can get daily expense reporrts on your personal mobile phone.'],
    ['mobile', 'Mobile Reporting', 'We have best Mobile Reporting features integrated with our software module for the sake of easiness.'],
    ['lock', 'Register & Access Levels', 'Without Security and keeping access in control you can not protect your business and data. So we have best Access & Register mechanism in our POS.'],
  ];
  $includes = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option', 'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice', 'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Stock Management" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Low stock alerts, mobile reporting, price management and product custom price values — everything you need to keep stock under control, in one Point Of Sale Software." :call="true" />

<section id="stock-management--overview">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2023/12/1234-jpg.webp') }}" alt="Stock Management in myPOS point of sale software" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>STOCK MANAGEMENT</span></div>
      <h2>All in one Point Of Sale Software</h2>
      <p>myPOS is comprehensively equipped with stock managing features such as Low Stock Alert, Mobile Reporting, Price Management, Product Custom Price Value. It's full fill all the required need of the current era and modern age.</p>
      <p>myPOS has best security implementation integrated, to protect your data and keep privacy at the same time.</p>
      <div class="tag-cloud" style="margin-top:26px;">
        <span>SMS Software</span>
        <span>Super Stores</span>
        <span>Restaurants</span>
      </div>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <span class="num">Give Us a Call to find out more about our Point of Sale Software. <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="stock-management--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHAT YOU GET</span></div>
      <h2>Salient Features</h2>
      <p>Stock control works best when your accounts, staff, branches and expenses live in the same system.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$icon, $title, $text])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon">{!! $ic[$icon] !!}</div>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="stock-management--includes">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>EVERY PLAN INCLUDES</span></div>
      <h2>Everything you need to run your store.</h2>
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

<x-client-strip :slugs="['blue-gulf', 'client', 'chemcos', 'maras-turka', 'edrees-medical-equipments', 'perfect-biryani-house']" title="Our Clients" />

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/multi-location-integration') }}">Multi Location Integration</a>
      <a href="{{ url('/employee-management') }}">Employee Management</a>
      <a href="{{ url('/customers') }}">Customers Management</a>
      <a href="{{ url('/mobile-mypos') }}">Mobile POS</a>
      <a href="{{ url('/woocommerce-pos') }}">WooCommerce Integration</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Take control of your stock today." text="Book a free demo — we will set up myPOS for your store, import your products and train your staff." />
@endsection
