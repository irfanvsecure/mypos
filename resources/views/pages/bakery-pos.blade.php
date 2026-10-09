@extends('layouts.app')

@section('page', 'bakery-pos')
@section('title', 'Bakery POS System | Bakery Point of Sale Software')
@section('description', 'Boost your bakery\'s efficiency with Bakery management software. Manage sales, inventory, and orders with our cake point of sale software.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2018/05/barcode.png', 'Inventory Management', 'Effortlessly track bakery products from purchase to sale with myPOS, ensuring accurate stock levels and optimizing inventory efficiency.'],
    ['uploads/2018/05/shopping-basket.png', 'Purchase Management', 'Streamline purchase orders and bills, enhancing the efficiency of procurement processes for bakery ingredients and supplies.'],
    ['uploads/2018/05/network-1.png', 'Customers & Suppliers', 'Organize customer and supplier details seamlessly, fostering better relationships and enabling personalized service based on purchase history.'],
    ['uploads/2018/05/cash-register.png', 'Register Management', 'Monitor bakery sales and payments efficiently, reducing errors in transaction processing and maintaining accurate daily sales records.'],
    ['uploads/2018/05/network.png', 'Employee Management', 'Control user access levels, ensuring employees have appropriate permissions, and track performance while managing work shifts effectively.'],
    ['uploads/2018/05/web-design.png', 'Mobile Reporting', 'Stay connected with your bakery business from anywhere using mobile reporting features, accessing real-time sales data, and crucial information on the go.'],
    ['uploads/2018/05/dollar.png', 'Easy to Setup', 'Set up the bakery POS system effortlessly, making it an ideal choice for small bakery businesses with minimal training requirements.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple bakery locations seamlessly from a centralized system, streamlining operations and reporting across various branches.'],
    ['uploads/2018/05/bill.png', 'Customizable Receipts', 'Tailor bakery receipts with the POS system, providing a professional and branded experience while including relevant information like promotions and discounts.'],
  ];
@endphp

@section('content')
<x-page-header title="Bakery POS" eyebrow="POS SOFTWARE · BAKERY &amp; SWEETS" crumb="Bakery POS"
  lead="Bakery inventory management and billing in one desktop system — track stock levels, manage orders and stay FBR compliant."
  :call="true">
  <div class="sw-chips reveal"><span>FBR integration</span><span>Desktop &amp; offline</span><span>Multi-branch</span><span>Minimal training</span></div>
</x-page-header>

{{-- Intro --}}
<section id="bakery">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>BAKERY &amp; SWEETMEAT BILLING</span></div>
      <h2>Pakistan's #1 Bakery Sweetmeat Billing POS Software</h2>
      <p>At myPOS.pk, we're dedicated to revolutionizing bakery management through our advanced software solutions. Our Bakery Inventory Management System ensures simplified efficiency in tracking stock levels and managing orders, while our Bakery Point of Sale (POS) software enhances customer experience and boosts sales.</p>
      <p>Tailored to meet your bakery's unique needs, our Management Software provides a customizable suite of tools for seamless operations. With innovation at its core, myPOS.pk eliminates manual processes, increasing productivity and serving as the trusted software for bakery businesses. Upgrade your bakery with myPOS.pk, where technology meets growth for unparalleled success.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/pricing') }}" class="btn btn-ghost">See Pricing</a>
      </div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2024/01/bakery_pos__2_-removebg-preview-min.png') }}" alt="Bakery POS illustration">
    </div>
  </div>
</section>

{{-- Trust stats --}}
<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num">15,000+</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num">12,000+</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num">4.9/5</div><div class="lbl">Average rating</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">&lt;2min</div><div class="lbl">Avg. response time</div></div>
  </div>
</div>

{{-- Benefit split --}}
<section id="complete-solution">
  <div class="wrap split">
    <div class="media-frame illus reveal-left">
      <img src="{{ asset('uploads/2024/01/Bakery-Mnagemnet-1.png') }}" alt="Bakery POS management illustration" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>FBR COMPLIANT</span></div>
      <h2>Bakery Management with MyPOS Complete Solution</h2>
      <p>MyPOS offers a seamless bakery management system, bakery POS software, and bakery software programs that integrate with the Federal Board of Revenue systems for hassle-free tax compliance. Our solution provides a bakery POS system to simplify your business operations.</p>
      <p>As a user-friendly desktop and POS system designed specifically for bakery businesses in Pakistan, MyPOS goes beyond online order processing to allow efficient inventory, order, and financial tracking right from your computer. With FBR integration and flexibility as a desktop bakery management software, MyPOS.pk aims to simplify running a compliant bakery shop for our clients.</p>
      <p>As an all-in-one tool for small bakeries, our bakery POS and management system is crafted to make compliance, sales, and operations a breeze.</p>
    </div>
  </div>
</section>

{{-- Features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:720px;">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Bakery Inventory Management System</h2>
      <p>Bakery Management Solution ensuring flawless operations and heightened customer satisfaction. Delve into features that make our software the prime selection for bakeries boasting a user-friendly interface, advanced inventory management, and robust sales processing capabilities.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $t, $d])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon ft-img"><img src="{{ asset($img) }}" alt="{{ $t }} icon" loading="lazy"></div>
          <h3>{{ $t }}</h3>
          <p>{{ $d }}</p>
        </div>
      @endforeach
    </div>

    <div class="free-band reveal">
      <div class="fb-icon"><svg width="24" height="24" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
      <div>
        <h3>See the bakery POS on your own counter — free demo, setup included.</h3>
        <p style="color:var(--text-mute-ink);"><a href="tel:{{ config('site.phone_raw') }}" style="color:var(--navy); font-weight:600;">{{ config('site.phone') }}</a> — Call us anytime, or message us on <a href="{{ wa_link() }}" target="_blank" rel="noopener" style="color:var(--coral-deep); font-weight:600;">WhatsApp</a>.</p>
      </div>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary" style="white-space:nowrap;">Book a Free Demo</a>
    </div>
  </div>
</section>

{{-- Related --}}
<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>NEXT STEPS</span></div>
      <h2>Pricing, compliance &amp; downloads.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/restaurant-management') }}">Restaurant Management Software</a>
      <a href="{{ url('/downloads') }}">Downloads</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your bakery on myPOS." text="Book a free demo — we will set up myPOS for your bakery or sweet shop, including FBR integration, and train your staff." primary="Book a Free Demo" />
@endsection
