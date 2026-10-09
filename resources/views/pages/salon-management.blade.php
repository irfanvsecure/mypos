@extends('layouts.app')

@section('page', 'salon-management')
@section('title', 'Hair Salon Management Software | Spa Parlour Management System')
@section('description', 'All-in-one hair salon management software. Client care, streamline appointments, and enhance efficiency with our comprehensive parlour management system and salon spa software.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2018/05/barcode.png', 'Spa Management Software', 'Explore the top-rated spa management software - MyPOS. Enhance efficiency and client satisfaction.'],
    ['uploads/2018/05/shopping-basket.png', 'Salon Booking System', 'MyPOS salon booking system - Effortless appointment scheduling for salons. Enhance customer experience and efficiency.'],
    ['uploads/2018/05/network-1.png', 'Client Loyalty for Salons', 'Build lasting client loyalty with MyPOS. Personalized experiences that keep your salon customers coming back.'],
    ['uploads/2018/05/cash-register.png', 'Register Management', 'Keep track of your payments (Cash, Credit Card, Cheque etc.) as each cashier have separate register accounts.'],
    ['uploads/2018/05/network.png', 'Employee Management', 'Each user have their login details with their access levels (Owner, Sale, Purchase) to keep proceeding under control.'],
    ['uploads/2018/05/web-design.png', 'Mobile Spa Management', 'MyPOS mobile spa management - Control your spa business on the go. Embrace flexibility and convenience with our mobile solution.'],
    ['uploads/2018/05/dollar.png', 'Easy-to-Use Salon Software', 'MyPOS - The easy-to-use salon software. Simplify daily tasks and provide a seamless experience for your team and clients.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'With myPOS, you can manage multi companies and multi locations.'],
    ['uploads/2018/05/bill.png', 'Customisable Receipts', 'With lot of flexibility, myPOS allows end user to customize their receipt as per their needs.'],
  ];
@endphp

@section('content')
<x-page-header title="Salon Management" eyebrow="SALONPRO · SALON &amp; SPA SOFTWARE" crumb="Salon Management"
  lead="Appointment scheduling, inventory tracking, accounts, employee management and client communications — Pakistan's desktop software solution for spa and salon management."
  :call="true">
  <div class="sw-chips reveal"><span>Works without internet</span><span>Free trial version</span><span>FBR &amp; PRA integration</span><span>English / Urdu / Arabic</span></div>
</x-page-header>

{{-- Intro --}}
<section id="salonpro">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>MYPOS SALONPRO</span></div>
      <h2>Best Spa Management Software</h2>
      <p>Welcome to MyPOS, Pakistan's ultimate desktop <a href="{{ url('/') }}" style="color:var(--coral-deep); text-decoration:underline;">Software solution</a> for spa and salon management. MyPOS is downloaded and installed directly onto your computers for fast, secure access without an internet connection.</p>
      <p>Our software is designed to meet Pakistan's spa and salon industry's needs right from your desktop. With MyPOS, you increase revenue and earn a place in your clients' hearts with an all-in-one solution to arrange everything you require and serve your clients efficiently.</p>
      <p>Now, say goodbye to the hassles of traditional management systems. MyPOS makes appointment scheduling, inventory tracking, and accounts easy, with fantastic options for employee management, client communications, and detailed reporting, all accessible from the convenience of your computers.</p>
      <p>You can get a free trial version of MyPOS desktop software and see how our technology can take your business to the next level without needing an internet connection or cloud access. Many satisfied spa owners have trusted our desktop solution, so why wait? Try MyPOS today and turn your dreams into reality.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/salonpro') }}" class="btn btn-ghost">Download Free Trial</a>
      </div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2023/12/point-of-sale-1-min-1.png') }}" alt="Salon Management point of sale software">
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

{{-- Benefits --}}
<section id="benefits">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>DESKTOP AUTOMATION</span></div>
      <h2>Boost Your Beauty Salon Business with Easy Desktop Automation</h2>
      <p>Managing your beauty salon in Pakistan can be difficult. Our desktop solution makes it easy. With our software installed directly on your salon computers, you can:</p>
      <ul class="check-list">
        <li>Easily manage customer bookings and see your calendar.</li>
        <li>Track your inventory levels to know what to reorder.</li>
        <li>See sales data to understand business performance.</li>
        <li>Collect customer details to offer promotions that keep them coming back.</li>
        <li>Automate salon operations for smoother management right from your desktops.</li>
        <li>Focus more on client care.</li>
      </ul>
      <p>Take your beauty business to the next level with simplicity. Our software helps streamline success for your salon without the need for internet connectivity or a mobile app. Contact us to automate your salon tasks directly from your computers with our easy-to-use desktop software.</p>
      <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Contact Us</a></div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2024/01/Hairdresser-bro-removebg-preview-min.png') }}" alt="Salon Management hairdresser illustration" loading="lazy">
    </div>
  </div>
</section>

{{-- Features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Salon Management system</h2>
      <p>Running a successful salon requires meticulous organization, careful attention to detail, and tools that empower you to provide excellent customer service. That's why sensible salon owners choose MyPOS.</p>
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
        <h3>See SalonPro on your own chair — free demo, setup included.</h3>
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
      <a href="{{ url('/pricing-salonpro') }}">SalonPro Pricing</a>
      <a href="{{ url('/download/salonpro') }}">Download SalonPro</a>
      <a href="{{ url('/beauty-salons-fbr-pos-integration') }}">FBR POS for Beauty Salons</a>
      <a href="{{ url('/fbr-pos-integration-guide-beauty-salons') }}">FBR POS Guide for Beauty Salons</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your salon or spa on SalonPro." text="Book a free demo — we will set up SalonPro on your salon computers, including FBR &amp; PRA integration, and train your staff." primary="Book a Free Demo" />
@endsection
