@extends('layouts.app')

@section('page', 'customers')
@section('title', 'Customer Relationship Management in Pakistan')
@section('description', 'Enhance customer relationships with our Customer Management services in Pakistan. Elevate satisfaction and loyalty through personalized interactions and efficient solutions.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $ic = [
    'profile'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="3" y="3" width="14" height="14" rx="2" stroke="#fff" stroke-width="1.4"/><circle cx="10" cy="8.5" r="2.4" stroke="#fff" stroke-width="1.3"/><path d="M6 15c.7-2 2.2-3 4-3s3.3 1 4 3" stroke="#fff" stroke-width="1.3"/></svg>',
    'location' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 18s6-5.2 6-10a6 6 0 10-12 0c0 4.8 6 10 6 10z" stroke="#fff" stroke-width="1.4"/><circle cx="10" cy="8" r="2.2" stroke="#fff" stroke-width="1.3"/></svg>',
    'company'  => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg>',
    'currency' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7.5" stroke="#fff" stroke-width="1.4"/><path d="M12.5 7.2c-.5-.8-1.4-1.2-2.5-1.2-1.4 0-2.5.8-2.5 2s1.1 1.6 2.5 2 2.5.8 2.5 2-1.1 2-2.5 2c-1.1 0-2-.4-2.5-1.2M10 4.5V6M10 14v1.5" stroke="#fff" stroke-width="1.3"/></svg>',
    'lock'     => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="9" width="12" height="8" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M7 9V6.5a3 3 0 016 0V9" stroke="#fff" stroke-width="1.4"/></svg>',
    'mobile'   => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2" width="8" height="16" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M9 15.5h2" stroke="#fff" stroke-width="1.4"/></svg>',
  ];
  $features = [
    ['profile', 'Customer Profile', 'You can build complete Customer profile in our myPOS and you can choose fields according your business need.'],
    ['location', 'Location Base Items', 'The myPOS has been equipped with the new featre of Cutomers location based items will be displayed on handheld devices.'],
    ['company', 'Multi Company', 'You can manage Multi Company business management in an effective and easy way to reduce burden.'],
    ['currency', 'Multi Currency', 'We have integrated the multi currency option to facilitate the Customers, either use Rupee or other currencies.'],
    ['lock', 'Register & Access Levels', 'Without Security and keeping access in control you can not protect your business and data. So we have best Access & Register mechanism in our POS.'],
    ['mobile', 'Mobile Reporting', 'We have best Mobile Reporting features integrated with our software module for the sake of easiness.'],
  ];
  $includes = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option', 'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice', 'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Customers Management" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Complete customer profiles, location-based items and customer debit/credit — turn every buyer into a valued, returning customer." :call="true" />

<section id="customers--overview">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2023/12/customer-jpg.webp') }}" alt="Customers Management in myPOS point of sale software" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>CUSTOMERS MANAGEMENT</span></div>
      <h2>All in one Point Of Sale Software</h2>
      <p>In our myPOS we are giving priority to your Customers, So we have made a complete module for handling Customers profile items, Such as Name, Contact#, Address and Preferred Shopping Items detail of each customers.</p>
      <p>myPOS has also location based Customers profile option, you can manage Customers location to make them valued Customers. Also facilitating them by displaying Customer's location base stores and available Items accordingly. on their personal Handheld device and on Desktop Computers too.</p>
      <div class="tag-cloud" style="margin-top:26px;">
        <span>Mobile Orders</span>
        <span>Salon</span>
        <span>Laundry Stores</span>
      </div>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <span class="num">Give Us a Call to find out more about our Point of Sale Software. <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="customers--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHAT YOU GET</span></div>
      <h2>Salient Features</h2>
      <p>Know who your customers are, where they shop and what they prefer — and serve them better on every visit.</p>
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

<section id="customers--includes">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>EVERY PLAN INCLUDES</span></div>
      <h2>Everything you need to run your business.</h2>
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
      <a href="{{ url('/mobile-mypos') }}">Mobile POS</a>
      <a href="{{ url('/paperless-invoicing') }}">Paperless Invoicing</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/multi-location-integration') }}">Multi Location Integration</a>
      <a href="{{ url('/employee-management') }}">Employee Management</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Build stronger customer relationships." text="Book a free demo — see how myPOS keeps every customer profile, credit balance and preference in one place." />
@endsection
