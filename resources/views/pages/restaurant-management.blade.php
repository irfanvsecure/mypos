@extends('layouts.app')

@section('page', 'restaurant-management')
@section('title', 'Best Restaurant Point of Sale with Online Ordering and Waiter App')
@section('description', 'Our Restaurant POS System Software is specially design to cover all aspect of any restaurant from dine in, take away to home delivery. Whatsapp @ 0322 4765528')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $modules = [
    ['uploads/2022/10/mypos.pk_.com-remotly-control-1.png', 'Desktop Application', 'You can control your business from anywhere in the world & to get remote access your Mypos software by the browser.'],
    ['uploads/2021/10/mypos.pk_.com-comfortable-sale-system.png', 'Comfortable Sales System', 'Mypos has a fully automatic restro system. There is excellent restro system for the purpose of restaurant.'],
    ['uploads/2021/10/Untitled-4.png', 'Purchase Management', 'Purchase orders and bill are fully managed with their associated suppliers as well as their payments.'],
    ['uploads/2021/10/Untitled-2.png', 'Inventory Monitoring', 'Mypos has a fully integrated inventory monitoring system. It has also purchase customer information.'],
    ['uploads/2021/10/Untitled-4-1.png', 'Payment & Receipt History', 'Payment receipt provides you the details and proof of a financial transaction.'],
    ['uploads/2021/10/Untitled-3.png', 'Delivery Master Report', 'Lookup Mypos delivery data in minutes, customer service and supply chain processes.'],
    ['uploads/2021/10/stock-transfer-report.png', 'Stock Transfer Report', 'With Stock Transfer Report, you can keep track of your stock on real time.'],
    ['uploads/2021/10/register-mangmnt.png', 'Register Management', 'Keep track of your payments, as each cashier have separate register accounts.'],
  ];
  $shots = ['uploads/2022/10/2-3-1-1440x860.png', 'uploads/2022/10/4-1-1-1440x860.png', 'uploads/2022/10/5-1-1-1440x860.png', 'uploads/2022/10/6-4-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Restaurant Management" eyebrow="RESTROPRO · RESTAURANT POS" crumb="Restaurant Management"
  lead="RestroPro is a complete solution tailored for restaurant businesses — dine in, take away and home delivery — designed to simplify daily operations and help increase your revenue."
  :call="true">
  <div class="sw-chips reveal"><span>Waiter, kitchen &amp; client apps</span><span>Online order notification</span><span>FBR &amp; PRA integration</span><span>Works offline</span></div>
</x-page-header>

{{-- Intro --}}
<section id="restropro">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>MYPOS RESTROPRO</span></div>
      <h2>RestroPro Ultimate Restaurant POS System: Streamlined Point of Sale Software for Efficient Management</h2>
      <p>RestroPro is a complete solution tailored for restaurant businesses, designed to simplify daily operations and help increase your revenue. It's more flexible and affordable than other restaurant management systems out there. With RestroPro, everything from taking orders to processing payments is streamlined, making it easier for you to focus on what matters most—delivering great service.</p>
      <p>If you're in need of a <strong>Restaurant Point of Sale (POS)</strong> system, POS software, or a full <strong>restaurant management software</strong>, RestroPro has it all. Our system is built to handle the needs of any restaurant, whether you're looking for advanced <strong>Restaurant POS system software</strong> or just a simple, effective POS program. Plus, you can access it on both web and mobile, making it convenient and adaptable to how you run your business.</p>
      <div class="btn-row" style="margin-top:28px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/restropro') }}" class="btn btn-ghost">Download Now</a>
      </div>
    </div>
    <div class="media-frame reveal-right">
      <img src="{{ asset('uploads/2026/03/Restaurant-Management.jpg') }}" alt="Restaurant staff taking orders with myPOS RestroPro" width="1060" height="706">
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
  <div class="wrap">
    <div class="split">
      <div class="media-frame reveal-left">
        <img src="{{ asset('uploads/2026/03/myPOS-RestroPro-System.jpg') }}" alt="myPOS RestroPro System running in a restaurant" width="1060" height="706" loading="lazy">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>BENEFITS</span></div>
        <h2>Benefits of myPOS RestroPro System.</h2>
        <ul class="check-list">
          <li>myPOS RestroPro System is specifically designed with features to help operate and manage the restaurant.</li>
          <li>Comprehensive restaurant management software can accommodate certain needs, making each and every process simple and also faster.</li>
          <li>Disconnected makes operation faster</li>
          <li>You can track your orders and deals online as well</li>
          <li>Minimize the request handling time</li>
          <li>Decide profits and costs</li>
          <li>Food stock administration</li>
          <li>Managing the entire operations.</li>
          <li>Get the client devotion</li>
        </ul>
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>TRUSTED WORLDWIDE</span></div>
        <h2>myPOS RestroPro accomplished top-notch notoriety as Pakistan's Best Restaurant Management Software.</h2>
        <p>myPOS RestroPro has the consideration of eatery proprietors all around the world.</p>
        <p>Numerous clients from the USA, UAE, Canada, UK, Europe, Pakistan are dealing with their eatery organizations utilizing this Software. So we have made it top-notch so the client from anyplace in this world can utilize it.</p>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/restropro') }}" class="btn btn-outline">Download free trial</a></div>
      </div>
      <div class="media-frame reveal-right">
        <img src="{{ asset('uploads/2026/03/myPOS-RestroPro.jpg') }}" alt="myPOS RestroPro restaurant management software" width="1060" height="706" loading="lazy">
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="media-frame reveal-left">
        <img src="{{ asset('uploads/2026/03/Restaurant-POS-Software.jpg') }}" alt="Restaurant POS software on a cashier counter" width="1060" height="706" loading="lazy">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
        <h2>Why do you choose our myPOS Restaurant Management System.</h2>
        <ul class="check-list">
          <li>Easy to understand GUI Interface - no expansion information</li>
          <li>Completely stacked library of guides, demos, and recordings</li>
          <li>Completely coordinated eatery framework for minimize price</li>
          <li>Unlimited in day and day out help included</li>
          <li>Supported at any device</li>
          <li>All frameworks prerequisites fulfill inside one</li>
          <li>All (RMS) fundamental components for minimize price</li>
          <li>Look over essential to star add-on choices to best address your issues</li>
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- Screenshots --}}
<section id="screenshots" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>SCREENSHOTS</span></div>
      <h2>See RestroPro in action.</h2>
    </div>
    <div class="shot-grid stagger">
      @foreach ($shots as $i => $s)
        <figure class="reveal-scale" style="--i:{{ $i }}"><div class="media-frame"><img src="{{ asset($s) }}" alt="myPOS RestroPro restaurant POS screenshot {{ $i + 1 }}" width="1440" height="860" loading="lazy"></div></figure>
      @endforeach
    </div>
  </div>
</section>

{{-- Key features --}}
<section id="features">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:760px;">
      <div class="eyebrow-line"><span class="bar"></span><span>KEY FEATURES</span></div>
      <h2>Key Features For Restaurant Management System</h2>
      <p>POS constructs exclusively custom fitted and interoperable eatery the board programming that envelops all fundamental factors engaged with running a fruitful restaurant. Now, we will depict a portion of our generally significant highlights underneath that will assist you with comprehension the working activities that play out your works proficiently:</p>
    </div>

    <div class="split" style="margin-top:64px;">
      <div class="reveal-left">
        <h2 style="font-size:clamp(1.5rem,2.6vw,2.1rem);">Restaurant POS Software</h2>
        <p>Restaurant point-of-sale or POS software is an essential part of dealing with the eatery request. Our POS frameworks are based on a solid and open API that Easily interfaces your restaurant location with your favored installment progress ,internet requesting stages, gift and dependability programs, reservation applications, and then some more.</p>
        <p>POS software has an easy-to-understand UI and is easy for a client. The Restaurant POS window has all you wanted to deal with the request readily available. Key elements of this application are below:</p>
        <ul class="check-grid" style="grid-template-columns:repeat(2,1fr);">
          <li>Progressive and completely configurable POS framework</li>
          <li>Different views</li>
          <li>Take Order from the client</li>
          <li>Handle online request</li>
          <li>Check food list</li>
          <li>Token printing framework</li>
          <li>Handle on-going request</li>
          <li>Online order notification</li>
          <li>Different/Easy Payment Modes</li>
        </ul>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/restropro') }}" class="btn btn-outline">Download free trial</a></div>
      </div>
      <div class="media-frame reveal-right">
        <img src="{{ asset('uploads/2026/03/Restaurant-POS-Software-1.jpg') }}" alt="Restaurant POS order screen" width="1060" height="706" loading="lazy">
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="media-frame illus reveal-left">
        <img src="{{ asset('uploads/2022/08/3.png') }}" alt="Restaurant Management order management system" loading="lazy">
      </div>
      <div class="reveal-right">
        <h2 style="font-size:clamp(1.5rem,2.6vw,2.1rem);">Order Management System</h2>
        <p>The objective of a order management system is to convey the items to the client's hands as effectively as could really be expected. For this reason, POS has a useable request the executives highlight that assists you with overseeing client orders. Just as, deal with any remaining request related exercises naturally.</p>
        <p>There are four essential records for managing orders are:</p>
        <ul class="check-grid" style="grid-template-columns:repeat(2,1fr);">
          <li>Order list</li>
          <li>Pending request list</li>
          <li>Complete request</li>
          <li>Drop request</li>
        </ul>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/restropro') }}" class="btn btn-outline">Download free trial</a></div>
      </div>
    </div>
  </div>
</section>

{{-- Mid CTA + modules --}}
<section id="modules" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT-IN MODULES</span></div>
      <h2>Everything your restaurant runs on, in one system.</h2>
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

    <div class="free-band reveal">
      <div class="fb-icon"><svg width="24" height="24" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
      <div>
        <h3>See RestroPro on your own floor — free demo, setup included.</h3>
        <p style="color:var(--text-mute-ink);"><a href="tel:{{ config('site.phone_raw') }}" style="color:var(--navy); font-weight:600;">{{ config('site.phone') }}</a> — Call us anytime, or message us on <a href="{{ wa_link() }}" target="_blank" rel="noopener" style="color:var(--coral-deep); font-weight:600;">WhatsApp</a>.</p>
      </div>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary" style="white-space:nowrap;">Book a Free Demo</a>
    </div>
  </div>
</section>

{{-- Android apps, production, purchase --}}
<section id="apps">
  <div class="wrap">
    <div class="split">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>APP SECTION</span></div>
        <h2>Android App Integration</h2>
        <p>In the current world, clients lean toward online orders as opposed to disconnected requests. In this software, you can incorporate the android application for working the web-based request framework easily. Along these lines, you can associate the POS software with three recognizable applications for getting this facility. They are:</p>
        <ul class="check-list">
          <li>Client application</li>
          <li>Server application</li>
          <li>Kitchen app</li>
        </ul>
        <p>To learn more about this software please see the <a href="{{ url('/restaurant-management') }}#apps" style="color:var(--coral-deep); text-decoration:underline;">App Section</a></p>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/download/restropro') }}" class="btn btn-outline">Download free trial</a></div>
      </div>
      <div class="media-frame reveal-right">
        <img src="{{ asset('uploads/2026/03/Android-App-Integration.jpg') }}" alt="RestroPro Android client, server and kitchen apps" width="1060" height="706" loading="lazy">
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="media-frame reveal-left">
        <img src="{{ asset('uploads/2026/03/Production-Management-System.jpg') }}" alt="Restaurant production management system" width="1060" height="706" loading="lazy">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>PRODUCTION</span></div>
        <h2>Production Management System</h2>
        <p>Handle all of your things and stock inventory POS has a incredible POS product management system. Through this software ,you can manage your bit-by-bit creation system as well. Furthermore, you can manage your current product records and new upcoming productions as well. Also, you can set up production units easily.</p>
        <p>So, using POS software, you can keep track of your production system easily. Here, it is the summary of your record work process in the going with portions.</p>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/download/restropro') }}" class="btn btn-ghost">Check Trial Version</a></div>
      </div>
    </div>

    <div class="split" style="margin-top:96px;">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>PURCHASING</span></div>
        <h2>Purchase Management System</h2>
        <p>Purchase Management System is vital for your business. For dealing with the purchases POS has an attract element. In the restaurant business, the purchase will occur at each time. In this way, you need to purchase fixings according to your necessities to secure the appropriate assistance.</p>
        <p>For this reason, POS will be the best decision for you. Because this software purchase the executives include assists you with playing out this task naturally.</p>
        <div class="btn-row" style="margin-top:28px;"><a href="{{ url('/download/restropro') }}" class="btn btn-ghost">Check Trial Version</a></div>
      </div>
      <div class="media-frame illus reveal-right">
        <img src="{{ asset('uploads/2022/08/5.png') }}" alt="Restaurant Management purchase management system" loading="lazy">
      </div>
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
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/pra-pos-restaurant-integration') }}">PRA POS for Restaurants</a>
      <a href="{{ url('/fbr-pos-integration-guide-restaurants') }}">FBR POS Guide for Restaurants</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/download/restropro') }}">Download RestroPro</a>
      <a href="{{ url('/bakery-pos') }}">Bakery POS</a>
    </div>
  </div>
</section>

<x-cta-band title="Run your restaurant on RestroPro." text="Book a free demo — dine in, take away and home delivery set up for your restaurant, including FBR &amp; PRA integration and staff training." primary="Book a Free Demo" />
@endsection
