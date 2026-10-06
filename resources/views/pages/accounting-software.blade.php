@extends('layouts.app')

@section('page', 'accounting-software')
@section('title', 'Accounting Software In Pakistan | Free Accounting Software')
@section('description', 'Unlock financial efficiency with the best accounting software in Pakistan. Tailored for small businesses, our online accounting software simplifies bookkeeping, ensuring accuracy and ease.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['2018/05/barcode.png', 'Inventory Management', 'Seamlessly track products from purchase to sale for accurate control.'],
    ['2018/05/shopping-basket.png', 'Purchase Management', 'Streamline creating and managing purchase orders for a smoother.'],
    ['2018/05/network-1.png', 'Customers & Suppliers', 'Organize details for enhanced relationship management.'],
    ['2018/05/cash-register.png', 'Register Management', 'Monitor payments and transactions efficiently for comprehensive cash control.'],
    ['2018/05/network.png', 'Employee Management', 'Control user access levels for security and efficient personnel management.'],
    ['2018/05/web-design.png', 'Mobile Reporting', 'Stay connected on-the-go with mobile reporting for remote operations monitoring.'],
    ['2018/05/dollar.png', 'Easy to Setup', 'Effortlessly set up our online accounting software, perfect for small businesses.'],
    ['2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple locations seamlessly with our ERP software in Pakistan.'],
    ['2018/05/bill.png', 'Customizable Receipts', 'Personalize receipts with our fast accounting software for a professional touch.'],
  ];
  $shots = ['2-3-1-1440x860.png', '4-1-1-1440x860.png', '5-1-1-1440x860.png', '6-4-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Accounting Software" eyebrow="MYPOS ACCOUNTING &amp; ERP" crumb="Accounting Software"
  lead="Experience simplified financial management with MyPOS, the best accounting software in Pakistan for small businesses.">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
    <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/pricing') }}" class="btn btn-outline">See Pricing</a>
  </div>
  <div class="hero-trust">
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>FBR</b><span>Integrated digital invoicing</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support, always on call</span></div>
  </div>
</x-page-header>

<section id="accounting-software--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="media-frame contain"><img src="{{ asset('uploads/2024/01/Best-Accounting-Software-in-Pakistan.png') }}" alt="Best accounting software in Pakistan &ndash; myPOS dashboard" loading="lazy" style="height:auto;"></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;"><strong>Best Accounting Software</strong> in Pakistan</h2>
      <p>MyPOS is a leading company in Pakistan specializing in providing top-notch online accounting software solutions.</p>
      <ul class="check-list">
        <li>With a commitment to excellence, mypos.pk offers an integrated modular approach through its ERP software, setting it apart in the market.</li>
        <li>The company strongly emphasizes meticulous financial management, empowering businesses with tools for efficient planning and resource management.</li>
        <li>MyPOS online accounting software enables users to generate diverse reports effortlessly, formulate policies, and devise strategies for sustained business growth.</li>
        <li>As a reliable gateway to success, mypos.pk ensures businesses not only navigate challenges seamlessly but also thrive continuously.</li>
        <li>With a focus on innovation and user-friendly solutions, mypos.pk stands as a key player in facilitating business progress in Pakistan.</li>
      </ul>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
  </div>
</section>

<section id="accounting-software--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Accounting Software</h2>
      <p>Our user-friendly accounting software simplifies management by ensuring seamless operations to keep customers satisfied. We provide a user-friendly system to efficiently manage inventory. The system handles inventory and processes sales easily and reliably.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $title, $desc])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }} &ndash; accounting software" loading="lazy" style="width:28px; height:28px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p>{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="accounting-software--made-easy">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>SIMPLIFIED FINANCE</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;"><b>Accounting</b> Made Easy with MyPOS</h2>
      <p>Experience simplified financial management with MyPOS, the best accounting software in Pakistan for small businesses.</p>
      <p>Our user-friendly online accounting software seamlessly integrates with FBR, providing a robust ERP solution to streamline your finances.</p>
      <p>By automating tasks and integrating features like inventory and sales tracking, MyPOS enhances efficiency and accuracy so you can focus on growing your business.</p>
      <p>As Pakistan's leading provider of fast, small-business accounting software, we empower managers with comprehensive yet easy-to-use financial tools.</p>
      <p>MyPOS paves the way for your success through our dedicated accounting solutions. Uncover the confidence that comes with simplified accounting and management. <strong>MyPOS: Your partner in Pakistan for integrated online accounting software.</strong></p>
      <div class="btn-row" style="margin-top:22px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ url('/fbr-digital-invoicing') }}" class="btn btn-outline">FBR Digital Invoicing</a>
      </div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2024/01/Best_Accounting_Software_in_Pakistan__1_-removebg-preview-min.png') }}" alt="Accounting made easy with MyPOS illustration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="accounting-software--screenshots" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INSIDE THE SOFTWARE</span></div>
      <h2>See myPOS accounting in action.</h2>
    </div>
    <div class="benefit-cards stagger">
      @foreach ($shots as $i => $file)
        <div class="media-frame reveal-scale" style="--i:{{ $i }}"><img src="{{ asset('uploads/2022/10/' . $file) }}" alt="myPOS accounting software screenshot {{ $i + 1 }}" loading="lazy" style="height:auto; aspect-ratio:1440/860;"></div>
      @endforeach
    </div>
  </div>
</section>

<section id="accounting-software--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Explore more myPOS business software.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/payroll-software') }}">Payroll Software</a>
      <a href="{{ url('/distribution-management') }}">Distribution Management</a>
      <a href="{{ url('/reports') }}">Reports</a>
    </div>
  </div>
</section>

<x-cta-band title="Give Us a Call to find out more about our Point of Sale Software."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free demo and see how MyPOS accounting, inventory and FBR invoicing work together." primary="Get In Touch" />
@endsection
