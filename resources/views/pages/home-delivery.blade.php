@extends('layouts.app')

@section('page', 'home-delivery')
@section('title', 'Home Delivery - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $shots = ['2-3-1-1440x860.png', '4-1-1-1440x860.png', '5-1-1-1440x860.png', '6-4-1440x860.png'];
  $benefits = [
    'myPOS RestroPro System is specifically designed with features to help operate and manage the restaurant.',
    'Comprehensive restaurant management software can accommodate certain needs, making each and every process simple and also faster.',
    'Disconnected makes operation faster',
    'You can track your orders and deals online as well',
    'Minimize the request handling time',
    'Decide profits and costs',
    'Food stock administration',
    'Managing the entire operations.',
    'Get the client devotion',
  ];
  $why = [
    'Easy to understand GUI Interface - no expansion information',
    'Completely stacked library of guides, demos, and recordings',
    'Completely coordinated eatery framework for minimize price',
    'Unlimited in day and day out help included',
    'Supported at any device',
    'All frameworks prerequisites fulfill inside one',
    'All (RMS) fundamental components for minimize price',
    'Look over essential to star add-on choices to best address your issues',
  ];
  $posFeatures = ['Progressive and completely configurable POS framework', 'Different views', 'Take Order from the client', 'Handle online request', 'Check food list', 'Token printing framework', 'Handle on-going request', 'Online order notification', 'Different/Easy Payment Modes'];
  $cards = [
    ['2022/10/mypos.pk_.com-remotly-control-1.png', 'Desktop Application', 'You can control your business from anywhere in the world & to get remote access your Mypos software by the browser.'],
    ['2021/10/mypos.pk_.com-comfortable-sale-system.png', 'Comfortable Sales System', 'Mypos has a fully automatic restro system. There is excellent restro system for the purpose of restaurant.'],
    ['2021/10/Untitled-4.png', 'Purchase Management', 'Purchase orders and bill are fully managed with their associated suppliers as well as their payments.'],
    ['2021/10/Untitled-2.png', 'Inventory Monitoring', 'Mypos has a fully integrated inventory monitoring system. It has also purchase customer information.'],
    ['2021/10/Untitled-4-1.png', 'Payment & Receipt History', 'Payment receipt provides you the details and proof of a financial transaction.'],
    ['2021/10/Untitled-3.png', 'Delivery Master Report', 'Lookup Mypos delivery data in minutes, customer service and supply chain processes.'],
    ['2021/10/stock-transfer-report.png', 'Stock Transfer Report', 'With Stock Transfer Report, you can keep track of your stock on real time.'],
    ['2021/10/register-mangmnt.png', 'Register Management', 'Keep track of your payments, as each cashier have separate register accounts.'],
  ];
  $h2 = 'font-size:clamp(1.5rem, 2.6vw, 2.1rem); line-height:1.18;';
@endphp

@section('content')
<x-page-header title="Home Delivery" eyebrow="MYPOS RESTROPRO" crumb="Home Delivery"
  lead="RestroPro is a complete solution tailored for restaurant businesses, designed to simplify daily operations and help increase your revenue &mdash; from taking orders to processing payments and delivery.">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
    <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/download/restropro') }}" class="btn btn-outline" target="_blank">Download Now</a>
  </div>
  <div class="hero-trust">
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>Web &amp; Mobile</b><span>Access RestroPro anywhere</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support, always on call</span></div>
  </div>
</x-page-header>

<section id="home-delivery--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>RESTROPRO</span></div>
      <h2 style="{{ $h2 }}"><strong>RestroPro</strong> <strong>Ultimate Restaurant POS System: Streamlined Point of Sale Software for Efficient Management</strong></h2>
      <p>RestroPro is a complete solution tailored for restaurant businesses, designed to simplify daily operations and help increase your revenue. It's more flexible and affordable than other restaurant management systems out there. With RestroPro, everything from taking orders to processing payments is streamlined, making it easier for you to focus on what matters most—delivering great service.</p>
      <p>If you're in need of a <strong>Restaurant Point of Sale (POS)</strong> system, <strong>POS software</strong>, or a full <strong>restaurant management software</strong>, RestroPro has it all. Our system is built to handle the needs of any restaurant, whether you're looking for advanced <strong>Restaurant POS system software</strong> or just a simple, effective <strong>POS program</strong>. Plus, you can access it on both web and mobile, making it convenient and adaptable to how you run your business.</p>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2022/08/ease-of-access.png') }}" alt="RestroPro home delivery POS &ndash; ease of access on web and mobile" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="home-delivery--screenshots" class="section-tight" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="benefit-cards stagger" style="margin-top:0;">
      @foreach ($shots as $i => $file)
        <div class="media-frame reveal-scale" style="--i:{{ $i }}"><img src="{{ asset('uploads/2022/10/' . $file) }}" alt="RestroPro restaurant POS screenshot {{ $i + 1 }}" loading="lazy" style="height:auto; aspect-ratio:1440/860;"></div>
      @endforeach
    </div>
  </div>
</section>

<section id="home-delivery--benefits">
  <div class="wrap split">
    <div class="reveal-left">
      <img src="{{ asset('uploads/2022/08/Benefits-of-myPOS-RestroPro-System..png') }}" alt="Benefits of myPOS RestroPro System" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>BENEFITS</span></div>
      <h2 style="{{ $h2 }}">Benefits of <strong>myPOS RestroPro System</strong>.</h2>
      <ul class="check-list">
        @foreach ($benefits as $b)<li>{{ $b }}</li>@endforeach
      </ul>
    </div>
  </div>
</section>

<section id="home-delivery--notoriety" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>TRUSTED WORLDWIDE</span></div>
      <h2 style="{{ $h2 }}">myPOS RestroPro accomplished top-notch notoriety as <strong>Pakistan's Best Restaurant Management Software</strong>.</h2>
      <p>myPOS RestroPro has the consideration of eatery proprietors all around the world.</p>
      <p>Numerous clients from the USA, UAE, Canada, UK, Europe, Pakistan are dealing with their eatery organizations utilizing this Software. So we have made it top-notch so the client from anyplace in this world can utilize it.</p>
      <div class="tag-cloud" style="margin-top:22px;"><span>USA</span><span>UAE</span><span>Canada</span><span>UK</span><span>Europe</span><span>Pakistan</span></div>
      <div class="btn-row" style="margin-top:24px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Download Now</a></div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2022/08/myPOS-RestroPro-accomplished-top-notch-notoriety-as.png') }}" alt="myPOS RestroPro &ndash; Pakistan's best restaurant management software" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="home-delivery--why">
  <div class="wrap split">
    <div class="reveal-left">
      <img src="{{ asset('uploads/2022/08/Why-do-you-choose-our-myPOS-Restaurant-Management-System..png') }}" alt="Why choose the myPOS Restaurant Management System" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2 style="{{ $h2 }}">Why do you choose our <strong>myPOS Restaurant Management System</strong>.</h2>
      <ul class="check-list">
        @foreach ($why as $w)<li>{{ $w }}</li>@endforeach
      </ul>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><a href="{{ url('/pricing-restropro') }}" class="btn btn-outline">See RestroPro Pricing</a></div>
    </div>
  </div>
</section>

<section id="home-delivery--key-features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:820px;">
      <div class="eyebrow-line"><span class="bar"></span><span>KEY FEATURES</span></div>
      <h2>Key Features For Restaurant Management System</h2>
      <p>POS constructs exclusively custom fitted and interoperable eatery the board programming that envelops all fundamental factors engaged with running a fruitful restaurant. Now, we will depict a portion of our generally significant highlights underneath that will assist you with comprehension the working activities that play out your works proficiently:</p>
    </div>

    <div class="split" style="margin-top:56px;">
      <div class="reveal-left">
        <h3 style="font-size:1.5rem;">Restaurant POS Software</h3>
        <p>Restaurant point-of-sale or POS software is an essential part of dealing with the eatery request. Our POS frameworks are based on a solid and open API that Easily interfaces your restaurant location with your favored installment progress ,internet requesting stages, gift and dependability programs, reservation applications, and then some more.</p>
        <p>POS software has an easy-to-understand UI and is easy for a client. The Restaurant POS window has all you wanted to deal with the request readily available. Key elements of this application are below:</p>
        <ul class="check-grid" style="grid-template-columns:repeat(2,1fr); margin-top:18px;">
          @foreach ($posFeatures as $f)<li>{{ $f }}</li>@endforeach
        </ul>
        <div class="btn-row" style="margin-top:22px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Download Now</a></div>
      </div>
      <div class="reveal-right">
        <div class="media-frame contain"><img src="{{ asset('uploads/2022/08/2.png') }}" alt="Restaurant POS software screen" loading="lazy" style="height:auto;"></div>
      </div>
    </div>

    <div class="split" style="margin-top:72px;">
      <div class="reveal-left">
        <div class="media-frame contain"><img src="{{ asset('uploads/2022/08/3.png') }}" alt="Order management system screen" loading="lazy" style="height:auto;"></div>
      </div>
      <div class="reveal-right">
        <h3 style="font-size:1.5rem;">Order Management System</h3>
        <p>The objective of a order management system is to convey the items to the client's hands as effectively as could really be expected. For this reason, POS has a useable request the executives highlight that assists you with overseeing client orders. Just as, deal with any remaining request related exercises naturally.</p>
        <p>There are four essential records for managing orders are:</p>
        <ul class="check-grid" style="grid-template-columns:repeat(2,1fr); margin-top:18px;">
          <li>Order list</li><li>Pending request list</li><li>Complete request</li><li>Drop request</li>
        </ul>
        <div class="btn-row" style="margin-top:22px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Download Now</a></div>
      </div>
    </div>
  </div>
</section>

<section id="home-delivery--modules">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>MODULES</span></div>
      <h2>Run sales, purchases, stock and delivery from one system.</h2>
    </div>
    <div class="integ-grid stagger" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:22px; margin-top:44px;">
      @foreach ($cards as $i => [$img, $title, $desc])
        <div class="integ-card reveal-scale" style="--i:{{ $i % 4 }}">
          <div class="integ-icon" style="background:var(--paper-2) !important; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }}" loading="lazy" style="width:30px; height:30px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p style="margin-bottom:0;">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="home-delivery--android" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>ONLINE ORDERS</span></div>
      <h2 style="{{ $h2 }}"><strong>Android App Integration</strong></h2>
      <p>In the current world, clients lean toward online orders as opposed to disconnected requests. In this software, you can incorporate the android application for working the web-based request framework easily. Along these lines, you can associate the POS software with three recognizable applications for getting this facility. They are:</p>
      <div class="icon-row-grid" style="grid-template-columns:repeat(3,1fr); margin-top:22px;">
        <div class="icon-row-card"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2.5" width="8" height="15" rx="1.5" stroke="#fff" stroke-width="1.4"/></svg></div><span>Client application</span></div>
        <div class="icon-row-card"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2.5" width="8" height="15" rx="1.5" stroke="#fff" stroke-width="1.4"/></svg></div><span>Server application</span></div>
        <div class="icon-row-card"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="6" y="2.5" width="8" height="15" rx="1.5" stroke="#fff" stroke-width="1.4"/></svg></div><span>Kitchen app</span></div>
      </div>
      <p>To learn more about this software please see the <a href="{{ url('/restaurant-management') }}" style="color:var(--coral-deep); font-weight:600; text-decoration:underline;">App Section</a></p>
      <div class="btn-row" style="margin-top:22px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Download Now</a></div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2022/08/Android-App-Integration.png') }}" alt="RestroPro Android app integration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="home-delivery--production">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="media-frame contain"><img src="{{ asset('uploads/2022/08/4.png') }}" alt="Production management system screen" loading="lazy" style="height:auto;"></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>PRODUCTION</span></div>
      <h2 style="{{ $h2 }}">Production Management System</h2>
      <p>Handle all of your things and stock inventory POS has a incredible POS product management system. Through this software ,you can manage your bit-by-bit creation system as well. Furthermore, you can manage your current product records and new upcoming productions as well. Also, you can set up production units easily. So, using POS software, you can keep track of your production system easily. Here, it is the summary of your record work process in the going with portions.</p>
      <div class="btn-row" style="margin-top:22px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Check Trial Version</a></div>
    </div>
  </div>
</section>

<section id="home-delivery--purchase" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>PURCHASING</span></div>
      <h2 style="{{ $h2 }}">Purchase Management System</h2>
      <p>Purchase Management System is vital for your business. For dealing with the purchases POS has an attract element. In the restaurant business, the purchase will occur at each time. In this way, you need to purchase fixings according to your necessities to secure the appropriate assistance. For this reason, POS will be the best decision for you. Because this software purchase the executives include assists you with playing out this task naturally.</p>
      <div class="btn-row" style="margin-top:22px;"><a href="{{ url('/download/restropro') }}" class="btn btn-primary" target="_blank">Check Trial Version</a><a href="{{ url('/contact') }}#enquiry" class="btn btn-outline">Get Free Demo</a></div>
    </div>
    <div class="reveal-right">
      <div class="media-frame contain"><img src="{{ asset('uploads/2022/08/5.png') }}" alt="Purchase management system screen" loading="lazy" style="height:auto;"></div>
    </div>
  </div>
</section>

<section id="home-delivery--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Pricing, downloads &amp; compliance for restaurants.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/download/restropro') }}">Download RestroPro</a>
      <a href="{{ url('/restaurant-management') }}">Restaurant Management</a>
      <a href="{{ url('/restro-pos') }}">Restro POS</a>
      <a href="{{ url('/pra-pos-restaurant-integration') }}">Restaurant PRA POS Integration</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    </div>
  </div>
</section>

<x-cta-band title="Give Us a Call to find out more about our Point of Sale Software."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free RestroPro demo for dine in, takeaway and home delivery, including FBR &amp; PRA integration." primary="Get In Touch" />
@endsection
