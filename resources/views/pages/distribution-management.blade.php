@extends('layouts.app')

@section('page', 'distribution-management')
@section('title', 'Distribution Management System For Whole Sellers')
@section('description', 'Optimize sales and distribution with our cutting-edge software solutions. Enhance efficiency with distributed order and distribution inventory management software for seamless operations')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['2018/05/barcode.png', 'Inventory Management', 'Comprehensive tracking maintains optimal stock levels, minimizing stock outs or overstock situations.'],
    ['2024/01/workload_12073782-removebg-preview-min-e1705392197893.png', 'Order Processing', 'Streamline purchase orders and bills with myPOS, the best POS system for small grocery stores.'],
    ['2024/01/relationship_12883806-removebg-preview-min-e1705392476712.png', 'Customer Relationship Management', 'Robust CRM features organize customer data, manage interactions, and provide insights for personalized strategies.'],
    ['2024/01/solution_8321432-removebg-preview-min-e1705396533482.png', 'Multi-Channel Integration', 'Seamless integration with e-commerce and retail outlets ensures consistent customer experiences.'],
    ['2024/01/online-marketing_8441230-removebg-preview-min-e1705396826153.png', 'Mobile Accessibility', 'Mobile-friendly interfaces allowing sales teams to manage information, orders, and relationships efficiently.'],
    ['2024/01/dashboard_12663250-removebg-preview-min-e1705397030122.png', 'Real-time Reporting', 'Features generate real-time reports on sales, inventory, and key metrics, facilitating quick decision-making.'],
    ['2024/01/analytics_8821852-removebg-preview-min-e1705397596895.png', 'Sales Analytics', 'Advanced analytics tools offer valuable insights into performance, identifying trends.'],
    ['2024/01/invoice_5280441-removebg-preview-min-e1705397725967.png', 'Automated Billing and Invoicing', 'Automation reduces errors, accelerates payment cycles, and enhances overall financial efficiency.'],
    ['2024/01/online-review_12039845-removebg-preview-min-e1705397858233.png', 'User-Friendly Interface', 'Intuitive interfaces enhance usability, reducing training time and increasing overall productivity.'],
  ];
  $shots = ['2-3-1-1440x860.png', '4-1-1-1440x860.png', '5-1-1-1440x860.png', '6-4-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Distribution Management" eyebrow="SALES &amp; DISTRIBUTION SOFTWARE" crumb="Distribution Management"
  lead="We provide end-to-end automation from order processing to shipping goods &mdash; sales, orders, inventory and channels in one integrated solution for wholesale distributors.">
    <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
    <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/fbr-digital-invoicing') }}" class="btn btn-outline">FBR Digital Invoicing</a>
  </div>
  <div class="hero-trust">
    <x-cta-proof :caption="false" />
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>4.9/5</b><span>Average customer rating</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support, always on call</span></div>
  </div>
</x-page-header>

<section id="distribution-management--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="media-frame contain"><img src="{{ asset('uploads/2024/01/Distribution-Management-Software-1.png') }}" alt="Distribution management software for wholesale distribution businesses" loading="lazy" style="height:auto;"></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHOLESALE DISTRIBUTION</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Distribution Management Software for Wholesale Distribution Businesses</h2>
      <p>Welcome to MyPOS, your ultimate destination for cutting-edge sales and distribution software solutions.</p>
      <p>Our platform not only streamlines your business operations but also integrates seamlessly with specialized features like food distribution ERP software, ensuring that your unique industry needs are met.</p>
      <ul class="check-list">
        <li>We provide end-to-end automation from order processing to shipping goods. MyPOS software delivers a comprehensive solution for businesses involved in food distribution.</li>
        <li>Experience the power of real-time data with access to up-to-the-minute insights into your sales, inventory, and distribution channels. This allows you to make informed decisions in the dynamic food distribution industry.</li>
        <li>Additionally, our sales and distribution software, including tailored features for food distribution ERP, optimizes your processes. Automate routine tasks, enhance accuracy and increase overall efficiency to keep your operations running smoothly.</li>
      </ul>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
  </div>
</section>

<section id="distribution-management--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Sales And Distribution Software</h2>
      <p>Explore the ultimate solution in sales and distribution software. Elevate your operations with user-friendly interfaces, efficient inventory management, and robust sales processing. Our software is the top choice for seamless management and customer satisfaction.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $title, $desc])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }} &ndash; distribution management" loading="lazy" style="width:28px; height:28px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p>{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<x-mid-cta />

<section id="distribution-management--why">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Why Choose MyPOS Sales And Distribution Management Software</h2>
      <p>MyPOS offers cutting-edge sales and distribution management software tailored for businesses of all types. Our intuitive platform seamlessly integrates with your systems to streamline operations and meet unique business needs.</p>
      <ul class="check-list">
        <li>As your business evolves, our solutions scale to match your growth.</li>
        <li>We understand every distributor has diverse requirements, so our software is customizable to transform your workflows.</li>
        <li>Boost profits by reducing costs through process automation and improving operational performance.</li>
      </ul>
      <p>Transform your distribution with MyPOS. Our specialized software provides contemporary features to manage sales, orders, inventory, and channels in one integrated solution. <strong>Contact our team today to modernize operations and uncover new opportunities for your evolving business.</strong></p>
      <div class="btn-row" style="margin-top:22px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/wholesalers-guide-to-fbr-digital-invoicing') }}" class="btn btn-outline">Wholesaler's FBR Guide</a>
      </div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2024/01/26761318_2108.i039.023.F.m004.c9.delivery_service_isometric-removebg-preview-min.png') }}" alt="Sales and distribution delivery service illustration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="distribution-management--screenshots" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INSIDE THE SOFTWARE</span></div>
      <h2>See myPOS distribution software in action.</h2>
    </div>
    <div class="benefit-cards stagger">
      @foreach ($shots as $i => $file)
        <div class="media-frame reveal-scale" style="--i:{{ $i }}"><img src="{{ asset('uploads/2022/10/' . $file) }}" alt="myPOS distribution management screenshot {{ $i + 1 }}" loading="lazy" style="height:auto; aspect-ratio:1440/860;"></div>
      @endforeach
    </div>
  </div>
</section>

<section id="distribution-management--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Compliance, stock &amp; multi-branch tools for distributors.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
      <a href="{{ url('/wholesalers-guide-to-fbr-digital-invoicing') }}">Wholesaler's Guide to FBR Digital Invoicing</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/multi-location-integration') }}">Multi-location Integration</a>
      <a href="{{ url('/accounting-software') }}">Accounting Software</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="See sales, routes and stock on a free demo."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free demo of MyPOS sales and distribution management software." primary="Book a Free Demo" />
@endsection
