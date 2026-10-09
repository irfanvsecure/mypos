@extends('layouts.app')

@section('page', 'supermarket-pos')
@section('title', 'Best POS Software For Supermarket - Top Solutions in 2024')
@section('description', 'Streamline supermarket operations with our curated list of the best POS software. Enhance efficiency and customer experience effortlessly.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2018/05/barcode.png', 'Inventory Management', 'Effortlessly track products from purchase to sale with myPOS—a top choice for grocery store POS systems.'],
    ['uploads/2018/05/shopping-basket.png', 'Purchase Management', 'Streamline purchase orders and bills with myPOS, the best POS system for small grocery stores.'],
    ['uploads/2018/05/network-1.png', 'Customers & Suppliers', 'Organize customer and supplier details easily, making myPOS the best POS software for supermarkets.'],
    ['uploads/2018/05/cash-register.png', 'Register Management', 'Monitor payments efficiently with myPOS, a leading solution for grocery store POS software.'],
    ['uploads/2018/05/network.png', 'Employee Management', 'Control user access levels with myPOS, ideal for grocery store POS systems.'],
    ['uploads/2018/05/web-design.png', 'Mobile Reporting', 'Stay connected with your business from anywhere using myPOS mobile reporting—a perfect fit for a grocery store POS.'],
    ['uploads/2018/05/dollar.png', 'Easy to Setup', 'Set up myPOS effortlessly, recommended for small grocery stores as the best POS system.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple locations seamlessly with myPOS, a versatile solution for grocery store POS needs.'],
    ['uploads/2018/05/bill.png', 'Customizable Receipts', 'Tailor receipts with myPOS, the best POS software for supermarkets, offering flexibility for end-users.'],
  ];
@endphp

@section('content')
<x-page-header title="Supermarket POS" eyebrow="POS SOFTWARE · GROCERY &amp; SUPERMARKET" crumb="Supermarket POS"
  lead="POS systems designed specifically for grocery stores and supermarkets — high transaction volumes, perishable stock control, promotions, integrated scales and FBR synchronization."
  :call="true">
  <div class="sw-chips reveal"><span>FBR integration</span><span>Integrated scale</span><span>Multi-location</span><span>Works offline</span></div>
</x-page-header>

{{-- Intro --}}
<section id="supermarket">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT FOR FOOD RETAIL</span></div>
      <h2>Best POS Software For Supermarket</h2>
      <p>MyPOS offers POS systems designed specifically for grocery stores and supermarkets. We understand the unique challenges of food retail environments, such as high transaction volumes, perishable stock control, and promotion/membership tracking.</p>
      <p>Our POS software provides owners/managers with robust reporting and analytics to optimize inventory ordering, shelf layouts, and storage. An integrated scale simplifies the handling of loose produce. Effortless FBR and supplier synchronizations reduce accounting headaches so that you can evaluate profitability more easily.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/pricing') }}" class="btn btn-ghost">See Pricing</a>
      </div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2024/01/Grocery_shopping-cuate__1_-removebg-preview-min.png') }}" alt="Supermarket grocery shopping illustration">
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
<section id="grocery-pos">
  <div class="wrap split">
    <div class="media-frame illus reveal-left">
      <img src="{{ asset('uploads/2024/01/3887312_11697-removebg-preview-min.png') }}" alt="Supermarket checkout illustration" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2>MyPOS Ideal Grocery Store POS Software</h2>
      <p>MyPOS stands out as the premier point-of-sale (POS) solution for grocery stores, leveraging cutting-edge technology to optimize profit margins. Tailored to accommodate businesses of all sizes, MyPOS provides a comprehensive solution for every store.</p>
      <p>Our grocery store POS software is user-friendly and effortless to set up and manage. MyPOS's POS system for grocery stores empowers you to effortlessly incorporate hundreds or thousands of products with just a few clicks. Take control of your store's inventory by efficiently managing and restocking products before they hit the threshold.</p>
    </div>
  </div>
</section>

{{-- Features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:720px;">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Supermarket Management Software</h2>
      <p>Discover the best POS system for your grocery store, ensuring seamless operations and enhanced customer satisfaction. Explore the features that make our software the top choice for small grocery stores, including a user-friendly interface, inventory management, and robust sales processing.</p>
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
        <h3>See the supermarket POS on your own lane — free demo, setup included.</h3>
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
      <a href="{{ url('/retail-management') }}">Retail Management Software</a>
      <a href="{{ url('/fbr-pos-integration-retail-stores-pakistan') }}">FBR POS Integration for Retail Stores</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/downloads') }}#retailpro">Download RetailPro</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your supermarket on myPOS." text="Book a free demo — we will set up myPOS for your grocery store or supermarket, including FBR integration, and train your cashiers." primary="Book a Free Demo" />
@endsection
