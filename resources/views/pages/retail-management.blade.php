@extends('layouts.app')

@section('page', 'retail-management')
@section('title', 'Retail Inventory Management Software for Small Business')
@section('description', 'Streamline operations and boost profits with our user-friendly retail inventory management software tailored for small businesses in Pakistan')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['uploads/2018/05/barcode.png', 'Inventory Management', 'With myPOS inventory movement, you can keep track of your products, from purchase, return, damage to sale.'],
    ['uploads/2018/05/shopping-basket.png', 'Purchase Management', 'Purchase orders and bill are fully managed with their associated suppliers as well as their payments.'],
    ['uploads/2018/05/network-1.png', 'Customers & Suppliers', 'Add customers and suppliers, manage credits and collect essential information like email and phone numbers.'],
    ['uploads/2018/05/cash-register.png', 'Register Management', 'Keep track of your payments (Cash, Credit Card, Cheque etc.) as each cashier have separate register accounts.'],
    ['uploads/2018/05/network.png', 'Employee Management', 'Each user have their login details with their access levels (Owner, Sale, Purchase) to keep proceeding under control.'],
    ['uploads/2018/05/web-design.png', 'Mobile Reporting', 'Now you always connected with your business from anywhere and through any device connected with internet.'],
    ['uploads/2018/05/dollar.png', 'Easy to Setup', 'With provided documentation, now it is very easy to setup myPOS. Although our support is always there to assist.'],
    ['uploads/2018/05/company.png', 'Multi Company / Multi Location', 'With myPOS, you can manage multi companies and multi locations.'],
    ['uploads/2018/05/bill.png', 'Customisable Receipts', 'With lot of flexibility, myPOS allows end user to customize their receipt as per their needs.'],
  ];
  $modules = [
    ['uploads/2022/10/mypos.pk_.com-remotly-control-1.png', 'Desktop Application', 'You can control your business from anywhere in the world & to get remote access your Mypos software by the browser.'],
    ['uploads/2021/10/mypos.pk_.com-comfortable-sale-system.png', 'Comfortable Sales System', 'Mypos offers a fully automated retail management system for managing your grocery store business.'],
    ['uploads/2021/10/Untitled-4.png', 'Purchase Management', 'Purchase orders and bill are fully managed with their associated suppliers as well as their payments.'],
    ['uploads/2021/10/Untitled-2.png', 'Inventory Monitoring', 'Mypos has a fully integrated inventory monitoring system. It has also purchase customer information.'],
    ['uploads/2021/10/Untitled-4-1.png', 'Payment & Receipt History', 'Payment receipt provides you the details and proof of a financial transaction.'],
    ['uploads/2021/10/Untitled-3.png', 'Delivery Master Report', 'Lookup Mypos delivery data in minutes, customer service and supply chain processes.'],
    ['uploads/2021/10/stock-transfer-report.png', 'Stock Transfer Report', 'With Stock Transfer Report, you can keep track of your stock on real time.'],
    ['uploads/2021/10/register-mangmnt.png', 'Register Management', 'Keep track of your payments, as each cashier have separate register accounts.'],
  ];
  $shots = ['uploads/2022/10/2-2-1-1440x860.png', 'uploads/2022/10/5-4-1440x860.png', 'uploads/2022/10/4-4-1440x860.png', 'uploads/2022/10/3-2-1-1440x860.png', 'uploads/2022/10/1-1-1-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Retail Management" eyebrow="RETAILPRO · POS SOFTWARE" crumb="Retail Management"
  lead="Your retail business needs a Point of Sale Solution that could adapt to your desires — from inventory management to sizable reporting tools, all in one system."
  :call="true">
  <div class="sw-chips reveal"><span>FBR &amp; PRA integration</span><span>Works offline</span><span>English / Urdu / Arabic</span><span>14-day free trial</span></div>
</x-page-header>

{{-- Intro --}}
<section id="retailpro">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>MYPOS RETAILPRO</span></div>
      <h2>RetailPro is a comprehensive Retail Management System Specifically designed for your Retail Business.</h2>
      <p>Your retail business needs a Point of Sale Solution that could adapt to your desires. Our <a href="{{ url('/') }}" style="color:var(--coral-deep); text-decoration:underline;">RetailPro Systems</a> could be very smooth to put into effect and accesses the facts, budget, and stock online from anywhere.</p>
      <p>From inventory management to sizable reporting tools, we provide you with the equipment to run your business without any difficulty.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ url('/pricing') }}" class="btn btn-ghost">See Pricing</a>
      </div>
    </div>
    <div class="media-frame reveal-right">
      <img src="{{ asset('uploads/2026/03/Retail-Management.jpg') }}" alt="Retail store owner using myPOS RetailPro retail management system" width="1060" height="706">
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

{{-- Benefits: reputation / guidance / support --}}
<section id="why-retailpro">
  <div class="wrap">
    <div class="split">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>WORLD-CLASS REPUTATION</span></div>
        <h2>myPOS RetailPro achieved world-class reputation as Pakistan's Best Retail Management Software.</h2>
        <p>myPOS RetailPro has got the attention of retail owners all over the world because of comprehensive feedback.</p>
        <p>Many users from USA, Canada, UAE, UK, Europe, Pakistan are managing their retail businesses by using this Software. We made this software world-class so that users from anywhere in the world can use it.</p>
      </div>
      <div class="media-frame reveal-right">
        <img src="{{ asset('uploads/2026/03/Retail-Management-Software.jpg') }}" alt="myPOS RetailPro retail management software on a store counter" width="1060" height="706" loading="lazy">
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="media-frame reveal-left">
        <img src="{{ asset('uploads/2026/03/All-in-one-Point-Of-Sale-Software.jpg') }}" alt="All-in-one point of sale software for retail stores" width="1060" height="706" loading="lazy">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>THE RIGHT FIT</span></div>
        <h2>mypos.pk Guide you the proper retail POS system, with the capability you want and the functions you need.</h2>
        <p>myPOS RetailPro, given the solution built especially for your particular store, ensures that you will have the proper retail management software.</p>
        <p>myPOS.pk provides the entire suite of solutions such as software and all the services before, during, and after your system implementation.</p>
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>LOCAL SUPPORT</span></div>
        <h2>We provide unparalleled local support, all over the country.</h2>
        <p>myPOS RetailPro trust that simply providing a custom-built Point of Sale solution is not sufficient for your successful business.</p>
        <p>Our high-quality support system is industry-leading and much like the POS system we provide, it is customized to your commercial enterprises for unique needs.</p>
        <ul class="check-list">
          <li>24-hour support with an average response time under 2 minutes</li>
          <li>Setup, training and FBR / PRA integration handled by our team</li>
        </ul>
      </div>
      <div class="media-frame reveal-right">
        <img src="{{ asset('uploads/2026/03/local-support.jpg') }}" alt="myPOS local support team helping a retail customer" width="1060" height="707" loading="lazy">
      </div>
    </div>
  </div>
</section>

{{-- Core features --}}
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Retail Management System Software</h2>
      <p>Running a retail store presents complex challenges - tracking inventory, managing purchasing, processing sales transactions efficiently. Our software solution aims to simplify retail operations for small businesses.</p>
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
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary" style="white-space:nowrap;">Get Free Demo</a>
    </div>
  </div>
</section>

{{-- Inventory purchasing --}}
<section id="inventory">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2026/02/mypos-scaled.jpg') }}" alt="myPOS inventory purchasing on a retail POS terminal" width="2560" height="1707" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>INVENTORY</span></div>
      <h2>Inventory Purchasing</h2>
      <p>Accommodate all kinds of inventory, from weighed and grocery store easily build your object database with alternatives for item import collectively with a time-saving and single bulk object import and also assisting you to generate numerous product variations.</p>
      <p>Optimize sales overall performance and preserve your customer's happiness with smartly making plans, reporting, and forecasting inventory tools. Easily categorize and classify your item database with elegant tags and customary descriptions.</p>
    </div>
  </div>
</section>

{{-- Modules --}}
<section id="modules" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT-IN MODULES</span></div>
      <h2>Everything your store runs on, in one system.</h2>
    </div>
    <div class="feat-grid-4 stagger">
      @foreach ($modules as $i => [$img, $t, $d])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon ft-img"><img src="{{ asset($img) }}" alt="{{ $t }} icon" loading="lazy"></div>
          <h3>{{ $t }}</h3>
          <p>{{ $d }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- CRM --}}
<section id="crm">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>CUSTOMERS</span></div>
      <h2>CRM (customer relationship management) &amp; Clients</h2>
      <p>Customer profiles could be stored in the retail POS system with the intent to improve general consumer relationship management. Allows companies to gain perception of the behavior of their customers and adjust their enterprise operations to make sure that clients are served in a first-class viable manner.</p>
    </div>
    <div class="media-frame illus reveal-right">
      <img src="{{ asset('uploads/2023/12/CRM-removebg-preview.png') }}" alt="Retail Management CRM illustration" loading="lazy">
    </div>
  </div>
</section>

{{-- Reporting + screenshots --}}
<section id="reporting" class="bg-paper2">
  <div class="wrap">
    <div class="split">
      <div class="media-frame illus reveal-left">
        <img src="{{ asset('uploads/2023/12/conclusive-Reporting-removebg-preview.png') }}" alt="Retail Management reporting illustration" loading="lazy">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>REPORTING</span></div>
        <h2>Conclusive &amp; Reporting</h2>
        <p>Analyze numerous units of data with a huge range of reports at your fingertips, create your personal custom reviews with easy to use document author options, and easily export them to Excel for additional inspection.</p>
        <p>Identification of elements that might require your attention is without any difficulty with our POS structure: examine the items which can be fast moving as well as acquire tendency of clients based on their buy history, all in helping you to recognize your enterprise better.</p>
        <p>Track and have a look at object overall performance with distinctive, configurable reporting. Support reporting for the permit with majesty report alternatives.</p>
      </div>
    </div>
    <div class="section-head reveal" style="margin-top:90px;">
      <div class="eyebrow-line"><span class="bar"></span><span>SCREENSHOTS</span></div>
      <h2>See RetailPro in action.</h2>
    </div>
    <div class="shot-grid cols-3 stagger">
      @foreach ($shots as $i => $s)
        <figure class="reveal-scale" style="--i:{{ $i }}"><div class="media-frame"><img src="{{ asset($s) }}" alt="myPOS RetailPro screenshot {{ $i + 1 }}" width="1440" height="860" loading="lazy"></div></figure>
      @endforeach
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
      <a href="{{ url('/pricing') }}">RetailPro Pricing</a>
      <a href="{{ url('/fbr-pos-integration-retail-stores-pakistan') }}">FBR POS Integration for Retail Stores</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
      <a href="{{ url('/downloads') }}#retailpro">Download RetailPro</a>
      <a href="{{ url('/supermarket-pos') }}">Supermarket POS</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your retail store on RetailPro." text="Book a free demo — we will set up RetailPro for your store, including FBR &amp; PRA integration, and train your staff." primary="Get Free Demo" />
@endsection
