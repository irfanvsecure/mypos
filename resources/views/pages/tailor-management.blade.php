@extends('layouts.app')

@section('page', 'tailor-management')
@section('title', 'Tailor Management Software | Tailor Shop Management Software')
@section('description', 'Discover MyPOS TailorPro, the best POS software solution for tailoring shops. Our fully advanced tailor management system covers all your needs for efficient and streamlined operations.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['2018/05/barcode.png', 'Inventory Management', 'Seamlessly track products from purchase to sale, ensuring accurate inventory control.'],
    ['2018/05/shopping-basket.png', 'Purchase Management', 'Streamline the process of creating and managing purchase orders and bills for a smoother inventory workflow.'],
    ['2018/05/network-1.png', 'Customers & Suppliers', 'Organize customer and supplier details efficiently, enhancing the overall management of relationships.'],
    ['2018/05/cash-register.png', 'Register Management', 'Monitor payments and transactions efficiently, providing a comprehensive solution for managing the cash register.'],
    ['2018/05/network.png', 'Employee Management', 'Control user access levels, enhancing security and management capabilities for Tailor Shop personnel.'],
    ['2018/05/web-design.png', 'Mobile Reporting', 'Stay connected to your business on-the-go with mobile reporting features, ensuring you can monitor and manage operations from anywhere.'],
    ['2018/05/dollar.png', 'Easy to Setup', 'Effortlessly set up MyPOS, making it an ideal choice for Tailor Shop looking for a user-friendly POS system.'],
    ['2018/05/company.png', 'Multi Company / Multi Location', 'Manage multiple locations seamlessly, making myPOS a versatile solution for Tailor Master with multiple branches.'],
    ['2018/05/bill.png', 'Customizable Receipts', 'Tailor receipts according to your preferences, providing flexibility for end-users and ensuring a professional and personalized touch.'],
  ];
  $shots = [
    ['2024-07-07_21-29-15', 'Inventory Management'],
    ['2024-07-07_21-30-28', 'Measurements'],
    ['2024-07-07_21-30-59', 'Additional Addons'],
    ['2024-07-07_21-31-30', 'Define Price Group'],
    ['2024-07-07_21-33-01', 'Order Page'],
    ['2024-07-07_21-34-36', 'Send Whatsapp Notification'],
    ['2024-07-07_21-50-54', 'Invoice Layout'],
    ['2024-07-07_21-51-21', 'Tailor Measurement View'],
    ['2024-07-07_21-51-54', 'Send Whatsapp Message'],
    ['2024-07-07_21-52-46', 'Customer Payment'],
    ['2024-07-07_21-53-18', 'User Login Management'],
    ['2024-07-07_21-53-45', 'Biller Management'],
    ['2024-07-07_21-54-14', 'Invoice Layout Designer'],
    ['2024-07-07_21-54-40', 'User Permissions'],
    ['2024-07-07_21-55-07', 'Accounts'],
    ['2024-07-07_21-55-47', 'Reports'],
  ];
@endphp

@section('content')
<x-page-header title="Tailor Management Software" eyebrow="MYPOS TAILORPRO" crumb="Tailor Management"
  lead="Manage measurements, orders, delivery dates and payments in one place &mdash; TailorPro is the tailoring shop POS built for tailors, fabric shops and boutiques across Pakistan.">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
    <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/download/tailorpro') }}" class="btn btn-outline">Download TailorPro</a>
  </div>
  <div class="hero-trust">
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>4.9/5</b><span>Average customer rating</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support in English &middot; Urdu &middot; Arabic</span></div>
  </div>
</x-page-header>

<section id="tailor-management--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="video-frame">
        <iframe src="https://www.youtube.com/embed/xS2HDhkXc_4?rel=0" title="MyPOS TailorPro tailor management software video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>TAILORPRO</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Best POS Software Solution For Tailoring Shops</h2>
      <p>MyPOS TailorPro is the most effective and fully advanced tailor management system, which covers all the activities of a tailor-related business.</p>
      <p>It will help your business grow faster, and it has never been easier to manage your tailor workload and pending jobs with our tailoring shop management software. Our Tailoring Point of Sale solution helps you manage customers efficiently, providing advance alerts regarding order delivery, which aids in growing your business and increasing sales.</p>
      <p>Whether you need a tailor software solution or are looking for software for tailors, our system provides everything you need. Plus, with our comprehensive booking system, you can enjoy a headache-free experience and take your business a step ahead of the competition. Download our tailoring shop management software free and see how it can transform your business.</p>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><a href="{{ url('/pricing-tailorpro') }}" class="link-arrow" style="margin-top:0;">See TailorPro pricing &rarr;</a></div>
    </div>
  </div>
</section>

<section id="tailor-management--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Tailor Management Software</h2>
      <p>Our point-of-sale software offers an optimal solution for tailor management to ensure smooth operations and increased customer satisfaction. We provide a user-friendly system to efficiently manage inventory resiliently process sales.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $title, $desc])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }} &ndash; tailor management" loading="lazy" style="width:28px; height:28px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p>{{ $desc }}</p>
        </div>
      @endforeach
    </div>
    <div class="cta-inline reveal"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
  </div>
</section>

<section id="tailor-management--fabric-shops">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>TAILORS &amp; FABRIC SHOPS</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Tailor and Fabric Shop Management Software</h2>
      <p>MyPOS Data Systems Limited offers the premier tailor shop management software, providing a meticulous solution to operate your tailoring business efficiently. Our comprehensive system is designed specifically for tailoring, clothing, and fabric companies, enhancing your store's productivity through numerous advanced features.</p>
      <p>Seamlessly integrated with FBR requirements, our desktop POS software ensures precision in managing all aspects of your business, from inventory to sales and taxes. With our easy-to-use tailoring software, you can effortlessly categorize fabrics, materials, and readymade clothing items, detailing information such as yards in stock, cost per yard, and selling price per item. This keeps your store organized and efficient.</p>
      <p>Generate quotes, orders, and invoices with ease, while keeping your inventory synchronized in real-time across checkout and stock rooms. Whether you're managing fabric rolls or tracking readymade garment sales, our tailor shop management software optimizes business operations for tailor and fabric shops alike.</p>
      <p><strong>Ready to transform your business? Download tailor shop management software today and experience streamlined business management tailored to your needs!</strong></p>
      <div class="btn-row" style="margin-top:22px;">
        <a href="{{ url('/download/tailorpro') }}" class="btn btn-primary">Download TailorPro</a>
        <a href="{{ url('/fbr-pos-integration') }}" class="btn btn-outline">FBR POS Integration</a>
      </div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2024/01/7970071_3730360__1_-removebg-preview-min.png') }}" alt="Tailor and fabric shop management software illustration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="tailor-management--screenshots" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INSIDE THE SOFTWARE</span></div>
      <h2>TailorPro Screenshots</h2>
      <p>From measurements and orders to WhatsApp notifications, invoices and reports &mdash; click any screen to view it full size.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($shots as $i => [$file, $label])
        <a href="{{ asset('uploads/2024/07/' . $file . '.png') }}" class="feat-tile reveal-scale" style="--i:{{ $i % 9 }}; padding:0; overflow:hidden; display:block;" target="_blank" rel="noopener">
          <img src="{{ asset('uploads/2024/07/' . $file . '-1.png') }}" alt="TailorPro screenshot: {{ $label }}" loading="lazy" style="height:auto; aspect-ratio:1600/860; object-fit:cover; border-bottom:1px solid var(--paper-line);">
          <h3 style="padding:14px 18px; margin:0; font-size:0.98rem;">{{ $label }}</h3>
        </a>
      @endforeach
    </div>
  </div>
</section>

<section id="tailor-management--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Pricing, downloads &amp; compliance for tailors.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing-tailorpro') }}">TailorPro Pricing</a>
      <a href="{{ url('/download/tailorpro') }}">Download TailorPro</a>
      <a href="{{ url('/garments-pos') }}">Garments POS</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/features') }}">All Features</a>
    </div>
  </div>
</section>

<x-cta-band title="Give Us a Call to find out more about our Point of Sale Software."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free TailorPro demo and our team will set it up for your shop, including FBR &amp; PRA integration." primary="Get In Touch" />
@endsection
