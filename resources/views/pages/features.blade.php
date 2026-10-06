@extends('layouts.app')

@section('page', 'features')
@section('title', 'Features - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'With myPOS online mobile reporting enable you to keep track of inventory items, sales and employee performance from anywhere whatsapp @ +92 322 476 5528')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Features" eyebrow="POS FEATURES"
  lead="Inventory, purchases, registers, staff and mobile reporting — everything you need to run and measure your business, in one POS." :call="true" />

<section id="features--measure">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>REPORTING</span></div>
      <h2>Measure everything with a few clicks.</h2>
      <p>Get an immediate summary of your business across all of your locations and strategies.</p>
      <p>Online mobile reporting enable you to keep track of inventory items, sales and employee performance from anywhere, anytime. With lot of flexibility and runtime designer, now myPOS will enable you to customize your reports quickly without the intervention of any code modifications.</p>
      <p>Get an instant overview of your business across all of your locations. Access real-time product, sales and employee performance reports from anywhere, at anytime. Through customizable reports, access your key information quickly without the need to re-run individual reports.</p>
      <div class="btn-row" style="margin-top:26px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="#features--explore" class="link-arrow">Explore all features →</a>
      </div>
    </div>
    <div class="media-frame contain reveal-right">
      <img src="{{ asset('uploads/2018/05/features-2.png') }}" alt="myPOS sales report — track your sales, purchases and expenses" loading="lazy">
    </div>
  </div>
</section>

<section id="features--explore" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>ALL FEATURES</span></div>
      <h2>Explore all features.</h2>
    </div>
    <div class="feat-grid-9 stagger">
      <div class="feat-tile reveal-scale" style="--i:0">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/barcode.png') }}" alt="Inventory management icon" loading="lazy"></div>
        <h3>Inventory Management</h3>
        <p>With myPOS inventory movement, you can keep track of your products, from purchase, return, damage to sale.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:1">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/shopping-basket.png') }}" alt="Purchase management icon" loading="lazy"></div>
        <h3>Purchase Management</h3>
        <p>Purchase orders and bill are fully managed with their associated suppliers as well as their payments.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:2">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/network-1.png') }}" alt="Customers and suppliers icon" loading="lazy"></div>
        <h3>Customers &amp; Suppliers</h3>
        <p>Add customers and suppliers, manage credits and collect essential information like email and phone numbers.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:3">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/cash-register.png') }}" alt="Register management icon" loading="lazy"></div>
        <h3>Register Management</h3>
        <p>Keep track of your payments (Cash, Credit Card, Cheque etc.) as each cashier have separate register accounts.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:4">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/network.png') }}" alt="Employee management icon" loading="lazy"></div>
        <h3>Employee Management</h3>
        <p>Each user have their login details with their access levels (Owner, Sale, Purchase) to keep proceeding under control.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:5">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/web-design.png') }}" alt="Mobile reporting icon" loading="lazy"></div>
        <h3>Mobile Reporting</h3>
        <p>Now you always connected with your business from anywhere and through any device connected with internet.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:6">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/dollar.png') }}" alt="Easy to setup icon" loading="lazy"></div>
        <h3>Easy to Setup</h3>
        <p>With provided documentation, now it is very easy to setup myPOS. Although our support is always there to assist.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:7">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/company.png') }}" alt="Multi company / multi location icon" loading="lazy"></div>
        <h3>Multi Company / Multi Location</h3>
        <p>With myPOS, you can manage multi companies and multi locations.</p>
      </div>
      <div class="feat-tile reveal-scale" style="--i:8">
        <div class="ft-icon ft-img"><img src="{{ asset('uploads/2018/05/bill.png') }}" alt="Customisable receipts icon" loading="lazy"></div>
        <h3>Customisable Receipts</h3>
        <p>With lot of flexibility, myPOS allows end user to customize their receipt as per their needs.</p>
      </div>
    </div>

    <div class="free-band reveal">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Try out free version</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:8px;">Our free version covers all basic sales functions.</p>
        <ul>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Support is not Included</li>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Fully compatible with Windows 7,8,10</li>
        </ul>
      </div>
      <a href="{{ url('/download') }}" class="btn btn-primary" style="white-space:nowrap;">Download Now</a>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/retail-management') }}">Retail Management</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/mobile-mypos') }}">Mobile App</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    </div>
  </div>
</section>

<x-cta-band />
@endsection
