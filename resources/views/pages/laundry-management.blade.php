@extends('layouts.app')

@section('page', 'laundry-management')
@section('title', 'Laundry Management System | Laundry POS Software')
@section('description', 'Optimize your laundry business with our comprehensive Laundry Management System. Streamline operations and enhance efficiency with our cutting-edge Laundry POS Software.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2018/05/barcode.png', 'Inventory Management', 'Effortlessly track products from intake to service with myPOS—a top choice for laundry business POS systems.'],
    ['uploads/2018/05/shopping-basket.png', 'Purchase Management', 'Streamline inventory management and order processing with myPOS, the best POS system for small laundry businesses.'],
    ['uploads/2018/05/network-1.png', 'Customers & Suppliers', 'Organize customer and supplier details easily, making myPOS the ideal POS software for dry cleaning management.'],
    ['uploads/2018/05/cash-register.png', 'Register Management', 'Monitor payments efficiently with myPOS, a leading solution for laundry business POS software.'],
    ['uploads/2018/05/network.png', 'Employee Management', 'Control user access levels with myPOS, perfect for managing employees in a laundry business setting.'],
    ['uploads/2018/05/web-design.png', 'Mobile Reporting', 'Stay connected with your business from anywhere using myPOS mobile reporting—a perfect fit for a laundry business POS.'],
    ['uploads/2018/05/dollar.png', 'Easy to Setup', 'Set up myPOS effortlessly, recommended for small laundry businesses as the best POS system.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple locations seamlessly with myPOS, a versatile solution for laundry business POS needs.'],
    ['uploads/2018/05/bill.png', 'Customizable Receipts', 'Tailor receipts with myPOS, the best POS software for dry cleaning management, offering flexibility for end-users.'],
  ];
  // [full-size link, thumbnail, caption]
  $shots = [
    ['uploads/2024/01/2019-09-26_12-05-38.png', 'uploads/2024/01/2019-09-26_12-05-38-1.png', 'Sales History'],
    ['uploads/2024/01/2019-09-26_12-05-14.png', 'uploads/2024/01/2019-09-26_12-05-14-1.png', 'Laundry Invoice'],
    ['uploads/2024/01/2019-09-26_12-03-34.png', 'uploads/2024/01/2019-09-26_12-03-34-1-1600x860.png', 'Sale Addons'],
    ['uploads/2024/01/2019-09-26_12-03-12.png', 'uploads/2024/01/2019-09-26_12-03-12-1-1600x860.png', 'Sale Screen'],
    ['uploads/2024/01/2019-09-26_12-02-43.png', 'uploads/2024/01/2019-09-26_12-02-43-1.png', 'Dashboard'],
    ['uploads/2024/01/2019-09-26_12-02-06.png', 'uploads/2024/01/2019-09-26_12-02-06-1.png', 'Laundry Login'],
  ];
@endphp

@section('content')
<x-page-header title="Laundry Management" eyebrow="LAUNDRYPRO · LAUNDRY POS SOFTWARE" crumb="Laundry Management"
  lead="User-friendly desktop software integrated with FBR — billing and invoicing, linen shipping and receiving, routes and clients for commercial and industrial laundries."
  :call="true">
  <div class="sw-chips reveal"><span>FBR integration</span><span>24-hour phone support</span><span>Free trial</span><span>Dry cleaning ready</span></div>
</x-page-header>

{{-- Intro --}}
<section id="laundrypro">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>MYPOS LAUNDRYPRO</span></div>
      <h2>Laundry Management Software Solutions for Pakistan</h2>
      <p>Welcome to myPOS, the globally trusted user-friendly desktop software integrated with FBR, widely embraced by commercial and industrial laundries. Our state-of-the-art technology streamlines and enhances laundry processes, reducing costs and boosting profitability.</p>
      <p>Whether overseeing Linen Shipping and Receiving, optimizing routes, handling billing and invoicing, or managing clients, myPOS caters to all your operational needs. Experience the convenience of myPOS, now seamlessly integrated with FBR, offering 24-hour phone support, a user-friendly learning system, extensive customization options, and a straightforward free trial.</p>
      <p>Simplify the initiation process and revolutionize your laundry operations effortlessly with myPOS.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ url('/download/laundrypro') }}" class="btn btn-ghost">Download Free Trial</a>
      </div>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2024/01/Laundry_Management_Software-min-removebg-preview-min.png') }}" alt="Laundry Management software illustration">
    </div>
  </div>
</section>

{{-- Trust stats --}}
<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num">15,000+</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num">12,000+</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num">4.9/5</div><div class="lbl">Average rating</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">24h</div><div class="lbl">Phone support</div></div>
  </div>
</div>

{{-- Benefit split --}}
<section id="operations">
  <div class="wrap split">
    <div class="media-frame illus reveal-left">
      <img src="{{ asset('uploads/2024/01/Laundry_Business_Operations_with_MyPOS-removebg-preview-min.png') }}" alt="Laundry Management business operations illustration" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>BEHIND THE SCENES</span></div>
      <h2>Optimize Your Laundry Business Operations with MyPOS</h2>
      <p>As the leading laundry point-of-sale (POS) provider, MyPOS optimizes profit margins through cutting-edge technology tailored to businesses of all sizes. Our user-friendly laundry POS easily incorporates inventory spanning hundreds or thousands of items. MyPOS empowers laundry owners to control inventory and manage restocks efficiently before thresholds are reached.</p>
      <p>We offer a complete laundry business solution that combines robust inventory and margin management with simplified setup processes. With our specialized laundry POS software, you can optimize behind-the-scenes operations through an intuitive interface. Our laundry management system is designed to take your business to the next level.</p>
    </div>
  </div>
</section>

{{-- Features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:720px;">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Laundry Management System</h2>
      <p>Discover the best POS system for your laundry business, guaranteeing smooth operations and heightened customer satisfaction. Delve into the features that set our software apart as the premier choice for small laundry businesses.</p>
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
      <h2>LaundryPro Screenshots</h2>
      <p>Click any screen to view it full size.</p>
    </div>
    <div class="shot-grid cols-3 stagger">
      @foreach ($shots as $i => [$full, $thumb, $cap])
        <figure class="reveal-scale" style="--i:{{ $i }}">
          <a href="{{ asset($full) }}" class="media-frame" target="_blank" rel="noopener"><img src="{{ asset($thumb) }}" alt="LaundryPro {{ $cap }} screen" width="1600" height="860" loading="lazy"></a>
          <figcaption>{{ $cap }}</figcaption>
        </figure>
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
      <a href="{{ url('/pricing-laundry-pro') }}">LaundryPro Pricing</a>
      <a href="{{ url('/download/laundrypro') }}">Download LaundryPro</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your laundry on LaundryPro." text="Book a free demo — we will set up LaundryPro for your laundry or dry cleaning business, including FBR integration, and train your staff." primary="Get Free Demo" />
@endsection
