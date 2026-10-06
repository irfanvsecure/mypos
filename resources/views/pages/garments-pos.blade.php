@extends('layouts.app')

@section('page', 'garments-pos')
@section('title', 'Garment Shop Management Software with Billing & Inventory')
@section('description', 'Improve your garment shop efficiency with MyPOS – advanced management software integrating seamless billing and inventory control. Boost productivity effortlessly!')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2024/01/inventory_11000621-removebg-preview-min-e1704876468205.png', 'Inventory Management', 'Effortlessly monitor product lifecycles from procurement to sale with MyPOS—your premier choice for garment shop POS systems.'],
    ['uploads/2024/01/baby-clothes_8340276-removebg-preview-min-e1704876892264.png', 'Purchase Management', 'Simplify purchase orders and invoicing with MyPOS, the ultimate POS system for small garment stores.'],
    ['uploads/2018/05/network-1.png', 'Customers & Suppliers', 'Efficiently organize customer and supplier information, making MyPOS the preferred POS software for garment shops.'],
    ['uploads/2024/01/assessment_11112924-removebg-preview-min-e1704876617764.png', 'Register Management', 'Efficiently track payments with MyPOS, a leading solution for garment shop POS software.'],
    ['uploads/2024/01/network-removebg-preview-min.png', 'Employee Management', 'Regulate user access levels seamlessly with MyPOS, an ideal solution for garment shop POS systems.'],
    ['uploads/2024/01/ecommerce_5364121-removebg-preview-min-e1704877081647.png', 'Mobile Reporting', 'Stay connected with your business from anywhere using MyPOS mobile reporting for garment shop.'],
    ['uploads/2024/01/gear_1416751-removebg-preview-min-e1704876769683.png', 'Easy to Setup', 'Set up MyPOS effortlessly, recommended as the best POS system for small garment stores.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple locations seamlessly with MyPOS, a versatile solution for garment shop POS needs.'],
    ['uploads/2018/05/bill.png', 'Customizable Receipts', 'Garment receipts with MyPOS, the best POS software for garment shops, offering flexibility for end-users.'],
  ];
  $shots = ['uploads/2022/10/2-3-1-1440x860.png', 'uploads/2022/10/4-1-1-1440x860.png', 'uploads/2022/10/5-1-1-1440x860.png', 'uploads/2022/10/6-4-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Garments POS" eyebrow="POS SOFTWARE · GARMENTS &amp; APPAREL" crumb="Garments POS"
  lead="Billing software for the garment industry that integrates inventory control, customer management, invoicing, and reporting into one easy-to-use platform."
  :call="true">
  <div class="sw-chips reveal"><span>Optional FBR integration</span><span>Sales, returns &amp; loyalty</span><span>Multi-location</span><span>Desktop &amp; offline</span></div>
</x-page-header>

{{-- Intro --}}
<section id="garments">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>GARMENT POINT OF SALE</span></div>
      <h2>MyPOS Garment Point of Sale Software</h2>
      <p>Manage your garment shop efficiently with MyPOS, the best software for garment shops. This powerful billing software for the garment industry seamlessly integrates inventory control, customer management, invoicing, and reporting into one easy-to-use platform.</p>
      <p>MyPOS optimizes workflows in garment retail stores by automatically generating invoices and tracking payments and accounts receivables. Robust reporting provides real-time visibility into inventory status and sales trends, enabling data-driven decisions.</p>
      <p>The intuitive interface enhances customer experience by quickly processing sales, returns, and loyalty programs. By boosting efficiency, visibility, and service, MyPOS Point of Sale Software takes garment shops to the next level. The all-in-one solution is reliably designed to meet the specific needs of the garment industry.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ url('/pricing') }}" class="btn btn-ghost">See Pricing</a>
      </div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2024/01/Software_For_Garment-removebg-preview-min.png') }}" alt="Garments POS software illustration">
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
<section id="perfect-fit">
  <div class="wrap split">
    <div class="media-frame illus reveal-left">
      <img src="{{ asset('uploads/2024/01/4283943_17795-removebg-preview-min.png') }}" alt="Garments POS store management illustration" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>DESIGN TO SALES</span></div>
      <h2>MyPOS Software Your Perfect Fit for Garments Store Management</h2>
      <p>MyPOS Garments simplifies operations for Garment businesses. The desktop software seamlessly manages your supply chain, costing, production, inventory, and sales. Key features include supplier, material, brand, and category tracking to optimize sourcing. Create design recipes to calculate material costs and profit margins.</p>
      <p>Inventory, purchasing, and production planning modules give you operational control, while integrated customer analytics provide sales insight. In today's complex fashion industry, growing brands need an integrated POS solution to manage design to sales.</p>
      <p>MyPOS brings it together on one user-friendly desktop platform with optional FBR integration. Focus on developing, producing, and selling while we streamline your backend needs. <a href="{{ url('/contact') }}#enquiry" style="color:var(--coral-deep); text-decoration:underline; font-weight:600;">Sign up for a demo today.</a></p>
    </div>
  </div>
</section>

{{-- Features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:720px;">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Garment Point of Sale Software</h2>
      <p>Our Garment POS optimizes boutique retail workflows through robust inventory management, sales tracking, and centralized customer data. The specialized solution empowers apparel stores to boost efficiency, visibility, and customer satisfaction for data-driven growth.</p>
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
        <h3>Give Us a Call to find out more about our Point of Sale Software.</h3>
        <p style="color:var(--text-mute-ink);"><a href="tel:{{ config('site.phone_raw') }}" style="color:var(--navy); font-weight:600;">{{ config('site.phone') }}</a> — Call us anytime, or message us on <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" style="color:var(--coral-deep); font-weight:600;">WhatsApp</a>.</p>
      </div>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary" style="white-space:nowrap;">Get In Touch</a>
    </div>
  </div>
</section>

{{-- Screenshots --}}
<section id="screenshots">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>SCREENSHOTS</span></div>
      <h2>See MyPOS in action.</h2>
    </div>
    <div class="shot-grid stagger">
      @foreach ($shots as $i => $s)
        <figure class="reveal-scale" style="--i:{{ $i }}"><div class="media-frame"><img src="{{ asset($s) }}" alt="MyPOS garments POS screenshot {{ $i + 1 }}" width="1440" height="860" loading="lazy"></div></figure>
      @endforeach
    </div>
  </div>
</section>

{{-- Related --}}
<section class="section-tight bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>NEXT STEPS</span></div>
      <h2>Pricing, compliance &amp; downloads.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/retail-management') }}">Retail Management Software</a>
      <a href="{{ url('/fbr-pos-integration-retail-stores-pakistan') }}">FBR POS Integration for Retail Stores</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/downloads') }}">Downloads</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your garment shop on myPOS." text="Book a free demo — we will set up myPOS for your garment shop or boutique, including FBR integration, and train your staff." primary="Get Free Demo" />
@endsection
