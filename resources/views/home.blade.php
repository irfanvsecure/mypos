@extends('layouts.app')

@section('page', 'home')
@section('title', 'myPOS — Free POS Software for Retail, Restaurant & Salon | FBR & PRA Compliant')
@section('description', 'myPOS is Pakistan\'s free point-of-sale software for retail, restaurant, salon and laundry businesses, with built-in FBR & PRA digital invoicing, offline-first sales, multi-branch inventory and 24-hour support.')

@push('head')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "myPOS",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Windows, Web, Android",
  "description": "Free POS software for retail, restaurant, salon and laundry businesses in Pakistan, with built-in FBR & PRA digital invoicing, offline-first sales and multi-branch inventory.",
  "url": "https://mypos.pk/",
  "offers": [
    { "@type": "Offer", "name": "Starter", "price": "0", "priceCurrency": "PKR" },
    { "@type": "Offer", "name": "Business", "priceCurrency": "PKR", "description": "Contact sales for pricing" },
    { "@type": "Offer", "name": "Enterprise", "priceCurrency": "PKR", "description": "Custom pricing" }
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "ratingCount": "12000"
  },
  "provider": {
    "@type": "Organization",
    "name": "myPOS",
    "url": "https://mypos.pk/",
    "telephone": "+92-322-4765528",
    "email": "info@mypos.pk",
    "areaServed": "PK"
  }
}
</script>
@endverbatim
@endpush

@section('content')
<header class="hero" id="home">
  <div class="wrap hero-grid">
    <div class="hero-copy">
      <div class="hero-eyebrow"><span class="pulse-dot"></span>POINT OF SALE, BUILT FOR PAKISTAN</div>
      <h1><span class="h1-kicker">Best Free POS Software for Retail, Restaurant, &amp; Salon Businesses in Pakistan</span>The POS that keeps <span class="gtext">ringing up sales</span>, online or off.</h1>
      <p class="lead">Power your business with a reliable free POS software built for seamless offline and cloud-based sales, smart inventory management, and real-time reporting. Stay connected, stay secure, and grow faster with a system built for modern businesses across Pakistan.</p>
      <div class="hero-actions">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Demo</a>
        <a href="#pricing" class="btn btn-ghost" style="border-color:rgba(255,255,255,0.4); color:var(--text-on-dark);">Try Free Version</a>
      </div>
      <div class="hero-trust">
        <div class="ht-item"><b>15,000+</b><span>Businesses served across Pakistan</span></div>
        <div class="ht-sep"></div>
        <div class="ht-item"><b>3 Languages</b><span>English · Urdu · Arabic</span></div>
        <div class="ht-sep"></div>
        <div class="ht-item"><b>24-hour</b><span>Support team, always on call</span></div>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-photo-panel photo">
        <img src="https://images.pexels.com/photos/30548311/pexels-photo-30548311.jpeg" alt="Point of sale terminal in a coffee shop">
      </div>
      <div class="float-chip fc-1"><div class="cdot"></div><div><div class="ct">FBR Status</div><div class="cv">Verified ✓</div></div></div>
      <div class="float-chip fc-2"><div class="cdot"></div><div><div class="ct">Branches Synced</div><div class="cv">4 / 4 online</div></div></div>
      <div class="float-chip fc-3"><div class="cdot"></div><div><div class="ct">Today's Sales</div><div class="cv">₨ 412,600</div></div></div>
    </div>
  </div>
</header>

<div class="marquee-section">
  <div class="marquee-label">OUR POS CLIENTS · TRUSTED BY BUSINESSES ACROSS PAKISTAN</div>
  <div class="marquee-track">
    <div class="marquee-inner">
      <span class="mq-logo"><img src="{{ asset('uploads/2026/07/appleman-logo-revise.jpeg') }}" alt="Appleman logo" loading="lazy" width="36" height="36">Appleman</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/brooklyn-logo-revise.jpeg') }}" alt="Brooklyn logo" loading="lazy" width="36" height="36">Brooklyn</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/burger-bliss-logo-revise.jpeg') }}" alt="Burger Bliss logo" loading="lazy" width="36" height="36">Burger Bliss</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/but-karahi-logo-revise.jpeg') }}" alt="But Karahi logo" loading="lazy" width="36" height="36">But Karahi</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/chemcos-logo-revise.jpeg') }}" alt="Chemcos logo" loading="lazy" width="36" height="36">Chemcos</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/hyundai-blue-logo-revise.jpeg') }}" alt="Hyundai logo" loading="lazy" width="36" height="36">Hyundai</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/kids-care-logo-revise.jpeg') }}" alt="Kids Care logo" loading="lazy" width="36" height="36">Kids Care</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/meadows-grammar-school-logo-revise.jpeg') }}" alt="Meadows Grammar School logo" loading="lazy" width="36" height="36">Meadows Grammar School</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/mesol-logo-revise.jpeg') }}" alt="Mesol logo" loading="lazy" width="36" height="36">Mesol</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/mitti-di-handi-logo-revise.jpeg') }}" alt="Mitti Di Handi logo" loading="lazy" width="36" height="36">Mitti Di Handi</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/shaakh-logo-revise.jpeg') }}" alt="Shaakh logo" loading="lazy" width="36" height="36">Shaakh</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/snt-foods-logo-revise.jpeg') }}" alt="SNT Foods logo" loading="lazy" width="36" height="36">SNT Foods</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/strongman-logo-revise.jpeg') }}" alt="Strongman logo" loading="lazy" width="36" height="36">Strongman</span><span class="mq-logo"><img src="{{ asset('uploads/2026/07/jojo-logo-revise.jpeg') }}" alt="Jojo logo" loading="lazy" width="36" height="36">Jojo</span>
      <span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/appleman-logo-revise.jpeg') }}" alt="Appleman logo" loading="lazy" width="36" height="36">Appleman</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/brooklyn-logo-revise.jpeg') }}" alt="Brooklyn logo" loading="lazy" width="36" height="36">Brooklyn</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/burger-bliss-logo-revise.jpeg') }}" alt="Burger Bliss logo" loading="lazy" width="36" height="36">Burger Bliss</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/but-karahi-logo-revise.jpeg') }}" alt="But Karahi logo" loading="lazy" width="36" height="36">But Karahi</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/chemcos-logo-revise.jpeg') }}" alt="Chemcos logo" loading="lazy" width="36" height="36">Chemcos</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/hyundai-blue-logo-revise.jpeg') }}" alt="Hyundai logo" loading="lazy" width="36" height="36">Hyundai</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/kids-care-logo-revise.jpeg') }}" alt="Kids Care logo" loading="lazy" width="36" height="36">Kids Care</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/meadows-grammar-school-logo-revise.jpeg') }}" alt="Meadows Grammar School logo" loading="lazy" width="36" height="36">Meadows Grammar School</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/mesol-logo-revise.jpeg') }}" alt="Mesol logo" loading="lazy" width="36" height="36">Mesol</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/mitti-di-handi-logo-revise.jpeg') }}" alt="Mitti Di Handi logo" loading="lazy" width="36" height="36">Mitti Di Handi</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/shaakh-logo-revise.jpeg') }}" alt="Shaakh logo" loading="lazy" width="36" height="36">Shaakh</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/snt-foods-logo-revise.jpeg') }}" alt="SNT Foods logo" loading="lazy" width="36" height="36">SNT Foods</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/strongman-logo-revise.jpeg') }}" alt="Strongman logo" loading="lazy" width="36" height="36">Strongman</span><span class="mq-logo" aria-hidden="true"><img src="{{ asset('uploads/2026/07/jojo-logo-revise.jpeg') }}" alt="Jojo logo" loading="lazy" width="36" height="36">Jojo</span>
    </div>
  </div>
</div>

<section id="industries">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT FOR YOUR INDUSTRY</span></div>
      <h2>One POS, tuned for every counter.</h2>
      <p>Retail, restaurant or salon — myPOS adapts its workflow to how your business actually runs.</p>
    </div>
    <div class="industries-grid stagger">
      <a href="{{ url('/retail-management') }}" class="ind-card ind-card--feat reveal-scale" style="--i:0">
        <div class="photo"><img src="https://images.pexels.com/photos/12935045/pexels-photo-12935045.jpeg" alt="Cashier at a retail store checkout using a POS terminal"></div>
        <div class="ind-body">
          <div class="ind-tag">RETAIL <span class="ind-badge">MOST POPULAR</span></div>
          <h3>RetailPro</h3>
          <p>Barcode scanning, stock control and multi-branch inventory in one till — built for shops that never want a queue to stall.</p>
        </div>
      </a>
      <a href="{{ url('/restaurant-management') }}" class="ind-card reveal-scale" style="--i:1">
        <div class="photo"><img src="https://images.pexels.com/photos/12935084/pexels-photo-12935084.jpeg" alt="Restaurant kitchen digital ordering touchscreen system"></div>
        <div class="ind-body">
          <div class="ind-tag">RESTAURANT</div>
          <h3>RestroPro</h3>
          <p>Kitchen display, table management and split billing built for speed.</p>
        </div>
      </a>
      <a href="{{ url('/salon-management') }}" class="ind-card reveal-scale" style="--i:2">
        <div class="photo"><img src="https://images.pexels.com/photos/7195806/pexels-photo-7195806.jpeg" alt="Beauty salon reception counter"></div>
        <div class="ind-body">
          <div class="ind-tag">SALON</div>
          <h3>SalonPro</h3>
          <p>Appointment booking, stylist commissions and loyalty ledgers, handled.</p>
        </div>
      </a>
    </div>
  </div>
</section>

<section id="about">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>ALL-IN-ONE ERP</span></div>
      <h2>All in One Cloud Based POS System and Desktop POS Software</h2>
      <p><strong>myPOS</strong> is not just a point of sale software, it is a complete online ERP software solution. It has a lot of features to highlight, from multi company management, multi locations, offline and online integration as a true cloud based POS system, full integrated accounting system, friendly interface, easy-to-use inventory management and barcode scanning, to very flexible reporting and mobile reporting. Available as both desktop POS software and a cloud based POS system, it is designed to be an all-in-one solution for your business.</p>
      <p>myPOS keeps your business running even without a steady internet connection, syncing everything the moment you&rsquo;re back online. As a free POS software option, it lets small and growing businesses test core sales features before committing to a paid plan, while mobile reporting keeps you connected to daily performance from anywhere. Download the demo version to see how our online ERP software handles remote reporting, or get in touch if you need a custom built application.</p>
      <div class="btn-row" style="margin-top:26px;">
        <a href="{{ url('/features') }}" class="btn btn-primary">See all features</a>
        <a href="{{ url('/contact') }}#enquiry" class="link-arrow">Need a custom application? Get in touch →</a>
      </div>
    </div>
    <div class="network-card reveal-right">
      <svg viewBox="0 0 400 380">
        <defs>
          <linearGradient id="flow" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="#4FA8DA"/>
            <stop offset="1" stop-color="#1D5D89"/>
          </linearGradient>
        </defs>
        <path id="p1" d="M60,90 C160,60 220,140 320,110" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <path id="p2" d="M60,200 C160,180 220,230 320,190" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <path id="p3" d="M60,300 C160,300 220,240 320,270" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <circle r="4" fill="url(#flow)"><animateMotion dur="3.2s" repeatCount="indefinite"><mpath href="#p1"/></animateMotion></circle>
        <circle r="4" fill="url(#flow)"><animateMotion dur="3.6s" repeatCount="indefinite" begin="0.5s"><mpath href="#p2"/></animateMotion></circle>
        <circle r="4" fill="url(#flow)"><animateMotion dur="4s" repeatCount="indefinite" begin="1s"><mpath href="#p3"/></animateMotion></circle>
        <circle cx="60" cy="90" r="5" fill="#4FA8DA"/>
        <circle cx="60" cy="200" r="5" fill="#4FA8DA"/>
        <circle cx="60" cy="300" r="5" fill="#4FA8DA"/>
        <circle cx="320" cy="190" r="7" fill="#C1502E"/>
      </svg>
      <div class="node-label" style="top:56px; left:22px;"><div class="nd"></div><div><b>Gulberg</b>Branch — synced</div></div>
      <div class="node-label" style="top:168px; left:22px;"><div class="nd"></div><div><b>DHA</b>Branch — synced</div></div>
      <div class="node-label" style="top:268px; left:22px;"><div class="nd"></div><div><b>Model Town</b>Branch — synced</div></div>
      <div class="node-label" style="top:150px; right:8px; background:var(--coral-deep); border-color:transparent;"><div class="nd" style="background:#fff;"></div><div><b>Head Office</b>Consolidated view</div></div>
    </div>
  </div>
</section>

@php
  // Product tour screens — every WordPress hero-slider screenshot + the all-in-one illustration.
  $tourScreens = [
    ['sales', 'Sales Invoice', 'Bill customers in seconds — discounts, taxes and split payments on one screen.', '2022/10/2-3-1-1440x860', 'png', 'myPOS point of sale billing screen — sales invoice'],
    ['purchase', 'Purchase Bill', 'Record supplier bills and stock is updated the moment you save.', '2022/10/4-1-1-1440x860', 'png', 'myPOS inventory and sales management screen — new purchase bill'],
    ['employees', 'Employee Payment', 'Salaries, advances and commissions tracked per employee.', '2022/10/5-1-1-1440x860', 'png', 'myPOS desktop POS software screen — employee payment'],
    ['accounts', 'Account Chart', 'Full accounting built in — ledgers, chart of accounts and reports.', '2022/10/6-4-1440x860', 'png', 'myPOS reporting and accounting screen — account chart'],
    ['all-in-one', 'All-in-One POS', 'One system on the desktop and in the cloud, for every branch.', '2026/07/All_in_one_Point_Of_Sale_Software-', 'png', 'All in one point of sale software — cloud based POS system and desktop POS software'],
  ];
@endphp
<section id="product-tour" class="tour-band" style="background-image:linear-gradient(160deg, rgba(18,63,95,0.95), rgba(21,74,115,0.9)), url('{{ asset('uploads/2019/01/mart-pos-mypos-pk-1.webp') }}');">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">PRODUCT TOUR</span></div>
      <h2>See myPOS in action.</h2>
      <p>One system for sales, inventory, purchases, employees and accounting — on the desktop and in the cloud.</p>
    </div>

    <div class="tour-shell reveal" data-tabs>
      <div class="tour-tabs" role="tablist" aria-label="myPOS screens">
        @foreach ($tourScreens as $i => [$key, $label, $desc])
          <button type="button" role="tab" class="tour-tab {{ $i === 0 ? 'active' : '' }}" id="tt-{{ $key }}" aria-controls="tp-{{ $key }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" data-tab-target="tp-{{ $key }}">
            <span class="tt-num">{{ sprintf('%02d', $i + 1) }}</span>
            <span class="tt-text"><b>{{ $label }}</b><small>{{ $desc }}</small></span>
          </button>
        @endforeach
      </div>

      <div class="tour-stage">
        @foreach ($tourScreens as $i => [$key, $label, $desc, $img, $ext, $alt])
          <figure class="tour-panel {{ $i === 0 ? 'active' : '' }} {{ $key === 'all-in-one' ? 'is-illus' : '' }}" role="tabpanel" id="tp-{{ $key }}" aria-labelledby="tt-{{ $key }}" @if ($i) hidden @endif>
            <picture>
              <source srcset="{{ asset('uploads/' . $img . '.webp') }}" type="image/webp">
              <img src="{{ asset('uploads/' . $img . '.' . $ext) }}" alt="{{ $alt }}" width="{{ $key === 'all-in-one' ? 544 : 1440 }}" height="{{ $key === 'all-in-one' ? 459 : 860 }}" loading="{{ $i ? 'lazy' : 'eager' }}" decoding="async">
            </picture>
            <figcaption><span class="tp-dot"></span>{{ $label }} <em>— {{ $desc }}</em></figcaption>
          </figure>
        @endforeach
      </div>
    </div>

    <div class="tour-cta reveal">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book Now</a>
      <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <span class="tour-note">Free version available · Works offline · FBR &amp; PRA ready</span>
    </div>
  </div>
</section>

<section class="section-tight split-reverse">
  <div class="wrap split">
    <div class="photo-panel reveal-scale">
      <div class="photo"><img src="{{ asset('uploads/2026/07/Ease-Of-Access.avif') }}" alt="POS software that works with or without internet" loading="lazy" width="626" height="481"></div>
      <div class="status-card sc-pos1"><div class="sc-top"><span class="sc-dot"></span>Connection</div><div class="sc-main">Offline mode</div></div>
      <div class="status-card sc-pos2"><div class="sc-top"><span class="sc-dot" style="background:var(--coral-soft);"></span>Auto-sync</div><div class="sc-main">Ready to push</div></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>OFFLINE-FIRST</span></div>
      <h2>Point of Sale Software That Works With or Without Internet</h2>
      <p><em>No internet? No problem. This ERP software still gives you real-time reports the moment you&rsquo;re back online.</em></p>
      <p>myPOS automatically syncs data whenever your point of sale system reconnects to the internet, so a live connection isn&rsquo;t necessary to keep running, which is what makes our ERP software stand out in the market.</p>
      <ul>
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#8B3A1F"/><path d="M5 9.2L7.7 12L13 6" stroke="#8B3A1F" stroke-width="1.6"/></svg>myPOS setup is ready to trade within minutes.</li>
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#8B3A1F"/><path d="M5 9.2L7.7 12L13 6" stroke="#8B3A1F" stroke-width="1.6"/></svg>As a free POS software solution, it works with almost all POS hardware.</li>
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#8B3A1F"/><path d="M5 9.2L7.7 12L13 6" stroke="#8B3A1F" stroke-width="1.6"/></svg>Get started with guides and a 24-hour customer support team.</li>
      </ul>
      <a href="{{ url('/features') }}" class="link-arrow">See all features →</a>
    </div>
  </div>
</section>

<section id="features">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>FEATURES</span></div>
      <h2>What makes myPOS ERP Software Prominent?</h2>
      <p>Everything a growing retail, restaurant or salon business needs — built in, not bolted on.</p>
    </div>
    <div class="feat-layout">
      <div class="feat-list reveal-left">
        <div class="feat-row">
          <div class="ficon-sm"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M3 6l7-3.5L17 6v8l-7 3.5L3 14V6z" stroke="#fff" stroke-width="1.4"/><path d="M3 6l7 3.5L17 6M10 9.5V17" stroke="#fff" stroke-width="1.4"/></svg></div>
          <div><h4><a href="{{ url('/stock-management') }}">Inventory Management</a></h4><p>Our inventory management system keep track of complete movement of all products from purchase, sale, return and other crucial information instantly.</p></div>
        </div>
        <div class="feat-row">
          <div class="ficon-sm"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="7" r="3.2" stroke="#fff" stroke-width="1.4"/><path d="M3.5 17c1-3.5 3.8-5.2 6.5-5.2s5.5 1.7 6.5 5.2" stroke="#fff" stroke-width="1.4"/></svg></div>
          <div><h4><a href="{{ url('/customers') }}">Customer Management</a></h4><p>Add customer instantly during checkout and easily manage their Debit/Credit Ledger and view their sale history, send SMS/Email and much more.</p></div>
        </div>
        <div class="feat-row">
          <div class="ficon-sm"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><rect x="2" y="5" width="16" height="11" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M2 8.5h16" stroke="#fff" stroke-width="1.4"/></svg></div>
          <div><h4><a href="{{ url('/accounting-software') }}">Multiple Payment Methods</a></h4><p>myPOS allows to accept different mode of payments like CASH, Debit/Credit Card, Gift Card, Cheque, Bank Transfer or Coupon. Even one sale an accept multiple payment modes.</p></div>
        </div>
        <div class="feat-row">
          <div class="ficon-sm"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v10l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></div>
          <div><h4>Discount, Refund &amp; Taxes</h4><p>Lot of sale related stuff available to keep the transaction smooth and reliable. Item/product level discounts and taxes and refund are few of them.</p></div>
        </div>
        <div class="feat-row">
          <div class="ficon-sm"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8" stroke="#fff" stroke-width="1.4"/><path d="M2 10h16M10 2c2.2 2 3.3 5 3.3 8s-1.1 6-3.3 8c-2.2-2-3.3-5-3.3-8S7.8 4 10 2z" stroke="#fff" stroke-width="1.4"/></svg></div>
          <div><h4>Multilingual</h4><p>To facilitate our national and international customer, myPOS is available in three languages (English, Urdu, Arabic) now and more to come soon...</p></div>
        </div>
      </div>
      <div class="feat-spotlight reveal-right">
        <div class="ficon"><svg width="24" height="24" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg></div>
        <h3>Multicompany / Multilocation</h3>
        <p>If you want to handle more than one company or you have more then one branches then myPOS should be the ideal choice for you.</p>
        <a href="{{ url('/multi-location-integration') }}" class="link-arrow">See multi-location integration →</a>
      </div>
    </div>

    <div class="feat-sub reveal" id="devices">
      <h3>Run the counter, the kitchen, or the boardroom.</h3>
      <p class="feat-sub-lead">The same data, wherever you check it from.</p>
      <div class="tab-bar">
        <button class="tab-btn active" data-tab="desktop">Desktop POS</button>
        <button class="tab-btn" data-tab="mobile">Mobile Reporting</button>
        <button class="tab-btn" data-tab="cloud">Cloud Dashboard</button>
      </div>
      <div class="device-stage">
        <div class="device-mock reveal-left">
          <div class="device-panel active" data-panel="desktop">
            <div class="d-row"><span>Order #4821</span><b>2x Zinger Combo</b></div>
            <div class="d-row"><span>Payment</span><b>Cash + Card</b></div>
            <div class="d-row"><span>Discount</span><b>Loyalty 10%</b></div>
            <div class="d-row"><span>Tax (FBR)</span><b>Filed automatically</b></div>
            <div class="d-row" style="border:none;"><span>Total</span><b style="color:#4FA8DA; font-size:1.1rem;">₨ 1,840</b></div>
          </div>
          <div class="device-panel" data-panel="mobile">
            <div class="d-row"><span>Today, all branches</span><b>₨ 412,600</b></div>
            <div class="d-row"><span>Top branch</span><b>Gulberg — ₨ 148,200</b></div>
            <div class="d-row"><span>Low stock alerts</span><b>3 items</b></div>
            <div class="d-row" style="border:none;"><span>Pending approvals</span><b>2 refunds</b></div>
          </div>
          <div class="device-panel" data-panel="cloud">
            <div class="d-row"><span>Locations online</span><b>4 / 4</b></div>
            <div class="d-row"><span>Consolidated inventory</span><b>2,340 SKUs</b></div>
            <div class="d-row"><span>Staff access levels</span><b>Cashier / Manager / Admin</b></div>
            <div class="d-row" style="border:none;"><span>Last full sync</span><b>Just now</b></div>
          </div>
        </div>
        <div class="tab-copy reveal-right">
          <h4 id="tabTitle">Full sales terminal, offline-ready</h4>
          <p id="tabDesc">Ring up items, split payments, apply discounts and print or send receipts — even mid-outage. Every FBR invoice files itself the moment you're back online.</p>
        </div>
      </div>
    </div>

    <div class="feat-sub reveal" id="software">
      <h3>One system, every kind of business.</h3>
      <p class="feat-sub-lead">Beyond the core POS, myPOS covers the software your whole operation runs on — from the till to the back office.</p>
      <div class="software-grid stagger">
        <div class="software-col reveal-scale" style="--i:0">
          <h4><div class="sc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><rect x="2" y="5" width="16" height="11" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M2 8.5h16" stroke="#fff" stroke-width="1.4"/></svg></div>POS Software</h4>
          <ul>
            <li><a href="{{ url('/retail-management') }}">Retail Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/restaurant-management') }}">Restaurant Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/salon-management') }}">Salon Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/supermarket-pos') }}">Supermarket POS<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/bakery-pos') }}">Bakery POS<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
          </ul>
        </div>
        <div class="software-col reveal-scale" style="--i:1">
          <h4><div class="sc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v10l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></div>More to Offer</h4>
          <ul>
            <li><a href="{{ url('/accounting-software') }}">Accounting Software<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/garments-pos') }}">Garments POS<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/laundry-management') }}">Laundry Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/tailor-management') }}">Tailor Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
          </ul>
        </div>
        <div class="software-col reveal-scale" style="--i:2">
          <h4><div class="sc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8" stroke="#fff" stroke-width="1.4"/><path d="M2 10h16M10 2c2.2 2 3.3 5 3.3 8s-1.1 6-3.3 8c-2.2-2-3.3-5-3.3-8S7.8 4 10 2z" stroke="#fff" stroke-width="1.4"/></svg></div>Cloud Applications</h4>
          <ul>
            <li><a href="{{ url('/distribution-management') }}">Distribution Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/hospital-management') }}">Hospital Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
            <li><a href="{{ url('/payroll-software') }}">Payroll Management<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="full-control" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="media-frame contain reveal-left"><img src="{{ asset('uploads/2024/01/software-process-jpg-removebg-preview-min.png') }}" alt="myPOS software process — purchase, stock, sale and reporting" loading="lazy"></div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>KEEP FULL CONTROL</span></div>
      <h2>Keep Full Control — Complete Awareness</h2>
      <p>Always have a complete awareness of your inventory levels, eliminating many unnecessary stock takes. Monitor your wastage and shrinkage, whilst ensuring you always have your best-selling products in stock.</p>
      <p>As a complete ERP software layer, myPOS streamlines the stock ordering process by automatically raising purchase orders, and makes inter-location stock transfer easy to manage.</p>
    </div>
  </div>
  <div class="wrap">
    <div class="control-cards stagger">
      <div class="control-card control-card--dark reveal-scale" style="--i:0">
        <img src="{{ asset('uploads/2018/05/My-Pos-Logo.png') }}" alt="myPOS logo" loading="lazy" class="cc-logo">
        <p class="cc-big">myPOS is serving 15000+ customers globally.</p>
        <p>We also develop custom applications as per the customer&rsquo;s requirements.</p>
        <a href="{{ url('/contact') }}" class="link-arrow">Contact Us →</a>
      </div>
      <div class="control-card reveal-scale" style="--i:1">
        <h3>Useful info</h3>
        <ul class="check-grid" style="grid-template-columns:repeat(2,1fr); margin-top:14px;">
          <li>myPOS allows to print barcodes</li>
          <li>Quickly upload products</li>
          <li>Complete Accounting</li>
          <li>LPO, PDC, Bank Accounts</li>
          <li>Mobile Reporting</li>
          <li>User Access Levels</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section id="integrations" class="integrations">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INTEGRATIONS</span></div>
      <h2>Built to plug into everything you already use.</h2>
      <p>From tax authorities to payment rails to your customers' phones — myPOS keeps every part of your business talking to each other.</p>
    </div>
    <div class="integ-grid stagger">
      <div class="integ-card reveal-scale" style="--i:0">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><path d="M5 2h10v16l-2.5-1.5L10 18l-2.5-1.5L5 18V2z" stroke="#fff" stroke-width="1.4"/><path d="M7.5 7h5M7.5 10h5M7.5 13h3" stroke="#fff" stroke-width="1.2"/></svg></div>
        <h3>Tax Authority e-Invoicing</h3>
        <p>Every sale is reported live and auto-filed with the right authority — no manual returns, no year-end scramble.</p>
        <div class="integ-tags"><span>FBR</span><span>PRA</span><span>SRB</span><span>KPRA</span></div>
      </div>
      <div class="integ-card reveal-scale" style="--i:1">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><rect x="2" y="4" width="16" height="12" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M3 5.5l7 5.5 7-5.5" stroke="#fff" stroke-width="1.4"/></svg></div>
        <h3>Email Notifications</h3>
        <p>Digital receipts, daily sales summaries and low-stock alerts sent straight to your inbox, automatically.</p>
        <div class="integ-tags"><span>Gmail</span><span>Outlook</span><span>SMTP</span></div>
      </div>
      <div class="integ-card reveal-scale" style="--i:2">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><path d="M3 17l1.2-3.6A7 7 0 1110 17c-1.2 0-2.3-.3-3.3-.8L3 17z" stroke="#fff" stroke-width="1.4"/></svg></div>
        <h3>WhatsApp &amp; SMS</h3>
        <p>Send invoices, order confirmations and promotions directly to your customers' phones after every sale.</p>
        <div class="integ-tags"><span>WhatsApp Business API</span><span>SMS Gateway</span></div>
      </div>
      <div class="integ-card reveal-scale" style="--i:3">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><rect x="2" y="5" width="16" height="11" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M2 8.5h16" stroke="#fff" stroke-width="1.4"/><circle cx="14.5" cy="12.5" r="1.4" fill="#fff"/></svg></div>
        <h3>Payment Gateways</h3>
        <p>Take cash, card, wallet and QR payments — every method reconciles automatically against the sale.</p>
        <div class="integ-tags"><span>EasyPaisa</span><span>JazzCash</span><span>Bank Card Machines</span></div>
      </div>
      <div class="integ-card reveal-scale" style="--i:4">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><rect x="4" y="2" width="12" height="5" stroke="#fff" stroke-width="1.4"/><rect x="2" y="7" width="16" height="8" rx="1" stroke="#fff" stroke-width="1.4"/><rect x="5.5" y="12" width="9" height="5" stroke="#fff" stroke-width="1.2"/></svg></div>
        <h3>POS Hardware</h3>
        <p>Barcode scanners, thermal &amp; kitchen printers, cash drawers and weighing scales — plug in and go.</p>
        <div class="integ-tags"><span>Barcode Scanners</span><span>Receipt Printers</span><span>Cash Drawers</span></div>
      </div>
      <div class="integ-card reveal-scale" style="--i:5">
        <div class="integ-icon"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><rect x="2" y="2" width="16" height="16" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M2 8h16M7 8v10M13 8v10" stroke="#fff" stroke-width="1.2"/></svg></div>
        <h3>Accounting &amp; Reports Export</h3>
        <p>Export sales, inventory and ledger reports to Excel/CSV for your accountant or existing books.</p>
        <div class="integ-tags"><span>Excel / CSV Export</span><span>Ledger Reports</span></div>
      </div>
    </div>
  </div>
</section>

<section id="compliance" class="compliance">
  <div class="photo"><img src="https://images.pexels.com/photos/12935048/pexels-photo-12935048.jpeg" alt="Cashier using a point of sale system to process a transaction"></div>
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>TAX COMPLIANCE</span></div>
      <h2>Stay compliant with FBR &amp; PRA — automatically.</h2>
      <p>myPOS also keeps you compliant with Pakistan's tax authorities. Through built-in <a href="{{ url('/fbr-pos-integration') }}" style="color:var(--blue-light); text-decoration:underline; text-underline-offset:3px;">FBR POS integration</a>, every sale is digitally reported in real time, so you can meet FBR's invoicing requirements without any manual filing or extra paperwork.</p>
      <div class="compliance-cards stagger">
        <a href="{{ url('/fbr-digital-invoicing') }}" class="compliance-card reveal-scale" style="--i:0">
          <div class="cc-top">FBR<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></div>
          <p>Real-time e-invoicing for federal sales tax.</p>
        </a>
        <a href="{{ url('/pra-integration') }}" class="compliance-card reveal-scale" style="--i:1">
          <div class="cc-top">PRA<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></div>
          <p>Digital reporting for Punjab sales tax.</p>
        </a>
        <a href="{{ url('/kpra-integration') }}" class="compliance-card reveal-scale" style="--i:2">
          <div class="cc-top">KPRA<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></div>
          <p>Compliant filing for Khyber Pakhtunkhwa.</p>
        </a>
        <a href="{{ url('/srb-integration-services-in-pakistan') }}" class="compliance-card reveal-scale" style="--i:3">
          <div class="cc-top">SRB<svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 3l4 4-4 4" stroke="currentColor" stroke-width="1.5"/></svg></div>
          <p>Automated returns for Sindh sales tax.</p>
        </a>
      </div>
    </div>
    <div class="compliance-visual reveal-scale">
      <div class="compliance-mock">
        <div class="compliance-mock-head"><span class="cm-dot"></span>Live filing status</div>
        <div class="d-row"><span>FBR</span><b style="color:var(--blue-light);">Filed just now</b></div>
        <div class="d-row"><span>PRA</span><b style="color:var(--blue-light);">Filed just now</b></div>
        <div class="d-row"><span>KPRA</span><b style="color:var(--blue-light);">Filed just now</b></div>
        <div class="d-row" style="border:none;"><span>SRB</span><b style="color:var(--blue-light);">Filed just now</b></div>
      </div>
    </div>
  </div>
</section>

<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0">
      <svg class="stat-ic" viewBox="0 0 24 24" fill="none"><path d="M4 20c1.3-4.5 4.8-6.5 8-6.5s6.7 2 8 6.5" stroke="var(--blue-light)" stroke-width="1.5"/><circle cx="12" cy="8" r="4" stroke="var(--blue-light)" stroke-width="1.5"/></svg>
      <div class="num" data-count="15000">0</div><div class="lbl">Customers globally</div>
    </div>
    <div class="stat reveal-scale" style="--i:1">
      <svg class="stat-ic" viewBox="0 0 24 24" fill="none"><circle cx="8" cy="9" r="3.2" stroke="var(--coral-soft)" stroke-width="1.5"/><circle cx="17" cy="10" r="2.6" stroke="var(--coral-soft)" stroke-width="1.5"/><path d="M2.5 20c.9-3.6 3.3-5.2 5.5-5.2s4.6 1.6 5.5 5.2M14.5 20c.6-3 2.4-4.4 4-4.4s3.3 1.4 4 4.4" stroke="var(--coral-soft)" stroke-width="1.5"/></svg>
      <div class="num" data-count="12000">0</div><div class="lbl">Active users</div>
    </div>
    <div class="stat reveal-scale" style="--i:2">
      <svg class="stat-ic" viewBox="0 0 24 24" fill="none"><path d="M12 3.5l2.6 5.4 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5z" stroke="var(--blue-light)" stroke-width="1.5" stroke-linejoin="round"/></svg>
      <div class="num" data-decimal="4.9">0</div><div class="lbl">Average rating / 5</div>
    </div>
    <div class="stat reveal-scale" style="--i:3">
      <svg class="stat-ic" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8.5" stroke="var(--coral-soft)" stroke-width="1.5"/><path d="M12 7.5V12l3.2 2" stroke="var(--coral-soft)" stroke-width="1.5" stroke-linecap="round"/></svg>
      <div class="num">&lt;2min</div><div class="lbl">Avg. response time</div>
    </div>
  </div>
</div>

@php
  // Google reviews shown on the WordPress home page (Trustindex widget) — text kept verbatim.
  $reviews = [
    ['raaj', 'MyPOS Pakistan is a game-changer for my vape shop in Karachi! It offers seamless inventory management, fast transactions, and real-time sales tracking. The user-friendly interface and excellent customer support make it a must-have for any vape business. Highly recommended!'],
    ['Asad Gaba', 'myPOS has simplified managing my shoe shop with easy sales tracking, inventory management, and quick billing. It’s efficient, user-friendly, and perfect for retail!'],
    ['Hassan Raza', 'I’ve been using The MyPOS Hospital Management System (HMS) for two months, and it’s a highly efficient, user-friendly solution that improves hospital operations and patient care. The support team is excellent, especially Salman Khan, who ensures everything runs smoothly. Highly recommended!'],
    ['Fahad Islam', 'As a salon owner, using myPOS.pk has made managing payments effortless. It supports multiple payment methods, integrates smoothly with my system, and offers real-time updates via the mobile app. The secure transactions give me peace of mind, and my clients appreciate the convenience. Highly recommend it for any salon business!'],
    ['Yousuf Usman', 'We are using my pos as there partner and we have more then 300 Setisfied customer in oman for my pos and they are very happy with the software and there support'],
    ['Javaid Nasir', 'Its amazing software. It meets our each & every need of business. I m more than satisfied not only withe software but service and gratitude of POS reps. Regards Happy Bhayi'],
    ['Mubashar Hussain', 'Very nice and cooperative staff sir Khalil and Salman khan thanks for guiding me.mjy apni boutique k leye myPOS SE achha koi software nhi lga'],
    ['Eaze App', 'I using this software since last three months and it is wonderful. It is very user friendly and the support provided by there team is amazing. I recommend this software to every retailer.'],
    ['Salman Raza', 'I am using MyPos Its very amazing user friendly software'],
    ['Faheem Akram', 'Efficient POS software, streamlines transactions, user-friendly interface.'],
  ];
  $initials = fn ($n) => strtoupper(collect(preg_split('/\s+/', trim($n)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
  $writeReview = 'https://admin.trustindex.io/api/googleWriteReview?place-id=ChIJ16hGakEFGTkRfzzOykTT1q4';
@endphp
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="rv-star" viewBox="0 0 20 20"><path d="M10 1.8l2.5 5.2 5.7.8-4.1 4 1 5.7L10 14.8l-5.1 2.7 1-5.7-4.1-4 5.7-.8L10 1.8z" fill="#F5B301"/></symbol>
  <symbol id="rv-google" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/><path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.4-.4-3.5z"/></symbol>
</svg>
<section id="reviews" class="reviews">
  <div class="wrap rv-layout">
    <div class="rv-panel reveal">
      <div class="rv-head">
        <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">CUSTOMER REVIEWS</span></div>
        <h2>Loved by businesses across Pakistan.</h2>
        <p>Real reviews from myPOS customers — retail, salon, hospital and restaurant owners.</p>
      </div>
      <div class="rv-actions">
      <div class="rv-score-row">
        <span class="rv-score">5.0</span>
        <div>
          <div class="rv-stars" aria-label="5 out of 5 stars">@for ($s = 0; $s < 5; $s++)<svg><use href="#rv-star"/></svg>@endfor</div>
          <span class="rv-count"><svg class="rv-g"><use href="#rv-google"/></svg> 20 Google reviews</span>
        </div>
      </div>
      <a href="{{ $writeReview }}" class="btn btn-outline rv-write" target="_blank" rel="noopener nofollow">Write a review</a>
      <div class="rv-nav">
        <button type="button" class="rv-arrow" data-rv-prev aria-label="Previous reviews"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M11 4L6 9l5 5" stroke="currentColor" stroke-width="1.8"/></svg></button>
        <button type="button" class="rv-arrow" data-rv-next aria-label="Next reviews"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M7 4l5 5-5 5" stroke="currentColor" stroke-width="1.8"/></svg></button>
      </div>
      </div>
    </div>

    <div class="rv-track" data-rv-track tabindex="0" aria-label="Customer reviews">
      @foreach ($reviews as $i => [$name, $text])
        <figure class="review-card">
          <svg class="rv-quote" width="30" height="30" viewBox="0 0 32 32" aria-hidden="true"><path d="M13 8H6v8h5c0 3-2 5-5 5v3c5 0 9-4 9-9V8zm14 0h-7v8h5c0 3-2 5-5 5v3c5 0 9-4 9-9V8z" fill="currentColor"/></svg>
          <div class="rv-stars" aria-label="5 out of 5 stars">@for ($s = 0; $s < 5; $s++)<svg><use href="#rv-star"/></svg>@endfor</div>
          <blockquote>{{ $text }}</blockquote>
          <figcaption>
            <span class="rv-avatar">{{ $initials($name) }}</span>
            <span><b>{{ $name }}</b><small>Posted on Google</small></span>
            <svg class="rv-g"><use href="#rv-google"/></svg>
          </figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>

<x-client-strip :slugs="['brooklyn', 'burger-bliss', 'butt-karahi', 'chemcos', 'hyundai-blue-otimus', 'meadows-grammar-school', 'mesol-pvt-ltd', 'mitti-di-handi', 'client', 'snt-foods', 'strongman-medifur-systems']" title="Our POS Clients" eyebrow="TRUSTED BY" :limit="12" />

<section id="pricing" class="pricing">
  <div class="wrap">
    <div class="section-head reveal" style="margin:0 auto; text-align:center; max-width:640px;">
      <div class="eyebrow-line" style="justify-content:center;"><span class="bar"></span><span>PRICING</span></div>
      <h2>Simple plans, built to grow with you.</h2>
      <p>Start free, upgrade whenever your business needs more locations, users or modules.</p>
    </div>
    <div class="pricing-grid stagger">
      <div class="price-card reveal-scale" style="--i:0">
        <div class="pc-badge">FREE</div>
        <h3>Starter</h3>
        <div class="pc-price">Rs. 0</div>
        <div class="pc-sub">Core sales features, forever free</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Single location POS</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Basic sales &amp; inventory</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Offline mode</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Community support</li>
        </ul>
        <a href="https://drive.google.com/open?id=1EQBjuP8GQZDwOKGs09rf81bU56QD-2mM&usp=drive_fs" target="_blank" rel="noopener" class="btn btn-ghost">Download Free</a>
      </div>
      <div class="price-card featured reveal-scale" style="--i:1">
        <div class="pc-badge">MOST POPULAR</div>
        <h3>Business</h3>
        <div class="pc-price">Contact Sales</div>
        <div class="pc-sub">For growing multi-branch businesses</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Everything in Starter</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multi-location &amp; multi-company</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>FBR / PRA / KPRA / SRB e-invoicing</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>WhatsApp, SMS &amp; email receipts</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Role-based staff access</li>
        </ul>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get a Quote</a>
      </div>
      <div class="price-card reveal-scale" style="--i:2">
        <div class="pc-badge">CUSTOM</div>
        <h3>Enterprise</h3>
        <div class="pc-price">Custom</div>
        <div class="pc-sub">Tailored builds for large operations</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Everything in Business</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Custom application development</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Dedicated onboarding &amp; training</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Priority 24-hour support</li>
        </ul>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-ghost">Talk to Us</a>
      </div>
    </div>
    <div class="pricing-links reveal">
      <a href="{{ url('/pricing') }}">RetailPro Pricing</a>
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/pricing-salonpro') }}">SalonPro Pricing</a>
      <a href="{{ url('/pricing-laundry-pro') }}">LaundryPro Pricing</a>
      <a href="{{ url('/pricing-tailorpro') }}">TailorPro Pricing</a>
    </div>
    <div class="free-band reveal">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Try out free version</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:8px;">Our free POS software version covers all basic sales functions.</p>
        <ul>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Support is not Included</li>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Fully compatible with Windows 7,8,10</li>
        </ul>
      </div>
      <a href="https://drive.google.com/open?id=1EQBjuP8GQZDwOKGs09rf81bU56QD-2mM&usp=drive_fs" class="btn btn-primary" style="white-space:nowrap;" target="_blank" rel="noopener">Download Now</a>
    </div>
  </div>
</section>

@php
$homeFaqs = [
    ['Does this POS Software work online and offline?', 'Yes, this POS software works in offline mode and automatically syncs sales, inventory, and reports once you\'re back online, keeping your business running.'],
    ['What payment plans does myPOS offer?', 'myPOS offers flexible monthly and annual plans for our software based on your features and number of locations, so you only pay for what you need.'],
    ['Does myPOS integrate with FBR and PRA?', 'Yes, myPOS is a POS system with built-in FBR and PRA integration, keeping your business tax-compliant with digital sales reporting instead of manual filing.'],
    ['Why should I choose myPOS?', 'myPOS is a reliable POS software offering offline access, FBR/PRA compliance, multi-location support, and dedicated customer support for businesses across Pakistan.'],
    ['How long does setup and installation take?', 'Most businesses have their POS system fully set up within 1 to 3 days, including installation, data migration, product setup, and staff training.'],
    ['Can I try a demo before purchasing myPOS?', 'Yes, we offer a free demo so you can explore our point of sale features and see how it fits your business before committing.'],
    ['What kind of customer support do you offer?', 'Our POS software comes with ongoing phone, WhatsApp, and email support, plus remote assistance and staff training whenever you need help.'],
    ['Can multiple users have different access levels?', 'Yes, this POS system supports role-based access, letting you control what cashiers, managers, and admins can see and do.'],
    ['Can I manage multiple business locations with myPOS?', 'Yes, myPOS lets you monitor sales, inventory, and staff across all branches from one dashboard, store by store or consolidated.'],
    ['Is my business data secure with myPOS?', 'Yes, this POS system uses encrypted cloud storage with regular backups and access controls, keeping your data safe and accessible only to authorized staff.'],
];
@endphp
@push('head')
<script type="application/ld+json">{!! json_encode(['@@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($homeFaqs)->map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]])->all()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
<section id="faq" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>FAQS</span></div>
      <h2>FAQs About POS Software</h2>
      <p>Everything you need to know about our platform. Can't find what you're looking for? Reach out to our team.</p>
    </div>
    <div class="faq-layout">
      <div class="faq-support reveal-left">
        <h3>Still have questions?</h3>
        <p>Our support team is ready to help you with anything you need. We typically respond within minutes.</p>
        <div class="faq-support-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
          <div><div class="lbl">WhatsApp / Phone</div><div class="val"><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></div></div>
        </div>
        <div class="faq-support-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 3l6 4.5L14 3M2 3h12v10H2V3z" stroke="#fff" stroke-width="1.3"/></svg></div>
          <div><div class="lbl">Email</div><div class="val"><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></div></div>
        </div>
        <div class="faq-mini-stats">
          <div><b>12,000+</b><span>Active users</span></div>
          <div><b>4.9/5</b><span>Average rating</span></div>
          <div><b>&lt; 2 min</b><span>Avg. response time</span></div>
        </div>
        <a href="{{ url('/contact') }}" class="btn btn-primary" style="margin-top:22px; width:100%; justify-content:center;">Contact Support</a>
      </div>
      <div class="faq-list reveal">
        @foreach ($homeFaqs as $i => [$q, $a])
        <div class="faq-item {{ $i === 0 ? 'open' : '' }}">
          <button class="faq-q" type="button">{{ $q }}<span class="plus"></span></button>
          <div class="faq-a"><p>{{ $a }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<x-contact-section eyebrow="CONTACT US" title="Request a free myPOS consultation." text="Tell us about your business and POS requirements. Our team will get back to you with the right solution, pricing, and support details." />
@endsection
