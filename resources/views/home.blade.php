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
@php
  $businessTypes = ['Retail / Shop', 'Restaurant / Café', 'Salon / Spa', 'Supermarket / Mart', 'Pharmacy / Clinic', 'Other business'];
@endphp
<header class="hero hero-home hero-cine" id="home">
  <div class="hx-bg" aria-hidden="true"></div>
  <div class="hx-3d" data-hero3d aria-hidden="true"></div>
  <div class="wrap hx-grid">
    <div class="hx-copy">
      <div class="hx-badges">
        <span class="hx-pill"><span class="pulse-dot"></span>Point of sale, built for Pakistan</span>
        <span class="hx-pill hx-pill--coral">FBR &amp; PRA ready</span>
      </div>
      <h1><span class="hx-hl">Free POS Software</span> for Retail, Restaurant, &amp; Salon Businesses in Pakistan</h1>
      <p class="lead">Fast billing that keeps working offline, smart inventory and real-time reports — with FBR &amp; PRA digital invoicing built in. Free to start, set up for you in days.</p>
      <form class="hx-form" method="POST" action="{{ route('enquiry.store') }}#hero-demo" id="hero-demo" novalidate>
        @csrf
        <input type="hidden" name="page" value="home (hero)">
        <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="hx-form-title"><span class="pulse-dot"></span>Get a free demo on your own products</div>
        <div class="hx-form-row">
          <label class="sr-only" for="h-name">Your name</label>
          <input id="h-name" type="text" name="name" value="{{ old('name') }}" placeholder="Your name" required autocomplete="name">
          <label class="sr-only" for="h-phone">Phone / WhatsApp</label>
          <input id="h-phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel">
          <label class="sr-only" for="h-type">Business type</label>
          <select id="h-type" name="type">
            @foreach ($businessTypes as $bt)<option value="Free Demo · {{ $bt }}" @selected(old('type') === "Free Demo · $bt")>{{ $bt }}</option>@endforeach
          </select>
          <button class="btn btn-primary hx-btn" type="submit">Get My Free Demo <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        </div>
        @if ($errors->any())<p class="hx-form-err" role="alert">{{ $errors->first() }}</p>@endif
        <ul class="hx-assure">
          <li>Free version available</li><li>Works offline</li><li>Reply within minutes</li>
        </ul>
      </form>
      <p class="hx-talk">Prefer to chat? <a href="{{ wa_link() }}" target="_blank" rel="noopener">WhatsApp us</a> · <a href="#free-version">Download the free version</a> · or call <a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></p>
    </div>

    <div class="hx-visual" data-pos-demo role="group" aria-label="Interactive myPOS billing demo">
      <div class="hx-hint"><span class="hx-hint-dot"></span>Live demo: tap items, then Charge</div>
      <div class="hx-app">
        <div class="hx-bar">
          <span class="hx-dots"><i></i><i></i><i></i></span>
          <span class="hx-title">myPOS · Counter 1</span>
          <span class="hx-online"><i></i>Online</span>
        </div>
        <div class="hx-body">
          <div class="hx-menu">
            <div class="hx-cats">
              <button type="button" class="on" data-cat="all" aria-pressed="true">All</button><button type="button" data-cat="food" aria-pressed="false">Food</button><button type="button" data-cat="drinks" aria-pressed="false">Drinks</button><button type="button" data-cat="desserts" aria-pressed="false">Desserts</button>
            </div>
            <div class="hx-items">
              <button type="button" class="hx-item" data-id="zinger" data-cat="food" data-price="650"><i style="--c:#FBE3D6" aria-hidden="true">🍔</i><b>Zinger Burger</b><span>Rs 650</span></button>
              <button type="button" class="hx-item" data-id="fries" data-cat="food" data-price="350"><i style="--c:#DCEEF9" aria-hidden="true">🍟</i><b>Masala Fries</b><span>Rs 350</span></button>
              <button type="button" class="hx-item" data-id="pizza" data-cat="food" data-price="1450"><i style="--c:#F7DDD3" aria-hidden="true">🍕</i><b>Tikka Pizza</b><span>Rs 1,450</span></button>
              <button type="button" class="hx-item" data-id="drink" data-cat="drinks" data-price="200"><i style="--c:#E1EAF2" aria-hidden="true">🥤</i><b>Cold Drink</b><span>Rs 200</span></button>
              <button type="button" class="hx-item" data-id="chai" data-cat="drinks" data-price="180"><i style="--c:#F1E4DA" aria-hidden="true">☕</i><b>Doodh Patti</b><span>Rs 180</span></button>
              <button type="button" class="hx-item" data-id="cake" data-cat="desserts" data-price="420"><i style="--c:#FBE3D6" aria-hidden="true">🍰</i><b>Lava Cake</b><span>Rs 420</span></button>
            </div>
          </div>
          <div class="hx-cart">
            <div class="hx-cart-head"><b>Order #<span data-order>1042</span></b><span>Dine in</span></div>
            <ul data-lines>
              <li><span>Zinger Burger <em>×2</em></span><b>1,300</b></li>
              <li><span>Masala Fries</span><b>350</b></li>
              <li><span>Cold Drink <em>×2</em></span><b>400</b></li>
            </ul>
            <div class="hx-sum"><span>Subtotal</span><b data-sub>2,050</b></div>
            <div class="hx-sum"><span>Sales tax 16%</span><b data-tax>328</b></div>
            <div class="hx-total"><span>Total</span><b>Rs <span data-total>2,378</span></b></div>
            <button type="button" class="hx-pay" data-pay>Charge Rs <span data-total>2,378</span></button>
            <div class="hx-done" data-done hidden aria-live="polite">
              <span class="hx-done-ic"><svg width="26" height="26" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
              <b>Payment received</b>
              <span>FBR invoice <strong data-inv>…</strong></span>
              <small>Receipt sent on WhatsApp</small>
            </div>
          </div>
        </div>
      </div>

      <div class="hx-chip hx-chip--fbr" data-fbr-chip>
        <span class="hx-ico hx-ico--green"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        <div><span class="ct">FBR invoice</span><span class="cv" data-fbr-text>Verified &amp; synced</span></div>
      </div>
      <div class="hx-chip hx-chip--sales" data-sales-chip>
        <div><span class="ct">Today's sales</span><span class="cv">₨ <span data-today>412,600</span> <em>▲ 18%</em></span></div>
        <div class="hx-spark"><i style="height:38%"></i><i style="height:55%"></i><i style="height:46%"></i><i style="height:70%"></i><i style="height:62%"></i><i style="height:84%"></i><i style="height:100%"></i></div>
      </div>
      <div class="hx-chip hx-chip--sync">
        <span class="hx-ico hx-ico--blue"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13 5.5A5.3 5.3 0 0 0 3.4 6M3 10.5a5.3 5.3 0 0 0 9.6.5" stroke="#fff" stroke-width="1.7" stroke-linecap="round"/><path d="M13.3 2.5v3.2h-3.2M2.7 13.5v-3.2h3.2" stroke="#fff" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        <div><span class="ct">Branches synced</span><span class="cv">4 / 4 online</span></div>
      </div>
    </div>
  </div>
  <div class="wrap hx-trustbar">
    <div class="hx-trust">
      <div class="hx-stat"><b>15,000+</b><span>Businesses served across Pakistan</span></div>
      <div class="hx-stat"><b>4.9<small>/5</small> <i class="hx-stars" aria-hidden="true">★★★★★</i></b><span>Average customer rating</span></div>
      <div class="hx-stat"><b>1–3 days</b><span>From demo to going live</span></div>
      <div class="hx-stat"><b>24-hour</b><span>Support in English, Urdu &amp; Arabic</span></div>
    </div>
  </div>
</header>

@php
  $clientRows = [
    [['2026/07/appleman-logo-revise.jpeg', 'Appleman', null], ['2026/07/brooklyn-logo-revise.jpeg', 'Brooklyn', 'brooklyn'], ['2026/07/burger-bliss-logo-revise.jpeg', 'Burger Bliss', 'burger-bliss'], ['2026/07/but-karahi-logo-revise.jpeg', 'Butt Karahi', 'butt-karahi'], ['2026/07/chemcos-logo-revise.jpeg', 'Chemcos', 'chemcos'], ['2026/07/hyundai-blue-logo-revise.jpeg', 'Hyundai Blue Otimus', 'hyundai-blue-otimus'], ['2026/07/kids-care-logo-revise.jpeg', 'Kids Care', null], ['2026/06/tea-at-terrace-logo-removebg-preview.png', 'Tea at Terrace', 'tea-at-terrace'], ['2018/05/bhavna-1.jpg', 'Bhavna Restaurant', 'bhavna-restaurant'], ['2018/05/baked-potato-1.jpg', 'Baked Potato', 'baked-potato'], ['2018/05/perfect-biryani-1.jpg', 'Perfect Biryani House', 'perfect-biryani-house'], ['2018/05/shahi-mughal-1.jpg', 'Shahi Mughal', 'shahi-mughal'], ['2018/05/mugcafe-1.jpg', 'Mug Cafe', 'mugcafe'], ['2018/05/candadian-pizza-1.jpg', 'Canadian Pizza', 'canadian-pizza'], ['2018/05/maras-turka-1.jpg', 'Maras Turka', 'maras-turka'], ['2018/05/bazaar-1.jpg', 'Bazaar', 'bazaar'], ['2018/05/xd-cinema-1.jpg', 'XD Cinema', 'xd-cinema'], ['2026/06/the-florist-by-aimen-tahir-logo-removebg-preview.png', 'The Florist by Aimen Tahir', 'the-florist-by-aimen-tahir'], ['2026/06/vision-optik-logo-removebg-preview.png', 'Vision Optik', 'vision-optik']],
    [['2026/07/meadows-grammar-school-logo-revise.jpeg', 'Meadows Grammar School', 'meadows-grammar-school'], ['2026/07/mesol-logo-revise.jpeg', 'Mesol Pvt LTD', 'mesol-pvt-ltd'], ['2026/07/mitti-di-handi-logo-revise.jpeg', 'Mitti Di Handi', 'mitti-di-handi'], ['2026/07/shaakh-logo-revise.jpeg', 'Shaakh', 'client'], ['2026/07/snt-foods-logo-revise.jpeg', 'SNT Foods', 'snt-foods'], ['2026/07/strongman-logo-revise.jpeg', 'Strongman Medifur Systems', 'strongman-medifur-systems'], ['2026/07/jojo-logo-revise.jpeg', 'JoJo', null], ['2018/05/compubase-1.jpg', 'CompuBase', 'compubase'], ['2018/05/cedar-1.jpg', 'Cedars', 'cedars'], ['2018/05/green-desert-1.jpg', 'Green Desert Aquarium', 'green-desert'], ['2018/05/brain-games-1.jpg', 'Brain Games', 'brain-games'], ['2018/05/izaak-1.jpg', 'Izaak Men Salon', 'izaak-men-salon'], ['2018/05/lavande-1.jpg', 'Lavande', 'lavande'], ['2018/05/nibras-1.jpg', 'Nebras', 'nebras'], ['2018/05/pective-1.jpg', 'Pectiv', 'pectiv'], ['2018/05/france-gallery-1.jpg', 'France Gallery', 'france-gallery'], ['2018/05/transworld-1.jpg', 'Transworld', 'transworld'], ['2018/05/topit-1.jpg', 'Topit', 'topit'], ['2018/05/good-times-1.jpg', 'Good Times', 'good-times'], ['2018/05/emd-1.jpg', 'Edrees Medical Equipments', 'edrees-medical-equipments'], ['2018/05/TAS-1.jpg', 'TAS', 'tas'], ['2018/05/bisou-1.jpg', 'Bisou Salon', 'bisou-salon']],
  ];
@endphp
<x-client-marquee :rows="$clientRows" title="Our POS Clients" eyebrow="TRUSTED BY" id="clients" />

@php
  // Business selector: [key, tab label, product, tag, intro, 3 wins, page url, image, alt]
  $industries = [
    ['retail', 'Retail / Shop', 'RetailPro', 'RETAIL · MOST POPULAR', 'Barcode scanning, stock control and multi-branch inventory in one till — built for shops that never want a queue to stall.',
      ['Scan &amp; bill in under 5 seconds', 'Low-stock alerts &amp; auto purchase orders', 'Customer credit ledgers &amp; loyalty'], '/retail-management',
      'uploads/2026/10/retail-shop-counter', 'Shopkeeper at the counter of a busy South Asian grocery store'],
    ['restaurant', 'Restaurant / Café', 'RestroPro', 'RESTAURANT', 'Kitchen display, table management and split billing built for speed.',
      ['Dine-in, takeaway &amp; delivery on one screen', 'Kitchen order tickets &amp; table map', 'PRA-ready restaurant invoices'], '/restaurant-management',
      'uploads/2026/10/restaurant-kitchen', 'Cook preparing food in a desi restaurant kitchen'],
    ['salon', 'Salon / Spa', 'SalonPro', 'SALON &amp; SPA', 'Appointment booking, stylist commissions and loyalty ledgers, handled.',
      ['Appointments &amp; walk-ins in one calendar', 'Stylist commissions calculated for you', 'Packages, memberships &amp; loyalty'], '/salon-management',
      'uploads/2026/10/salon-bridal-makeup', 'Makeup artist doing bridal makeup in a beauty salon'],
    ['supermarket', 'Supermarket / Mart', 'Supermarket POS', 'SUPERMARKET', 'Fast multi-counter billing with thousands of barcoded products, weighing scales and expiry tracking.',
      ['Multiple tills, one live stock count', 'Weighing scale &amp; barcode label printing', 'Expiry and batch tracking'], '/supermarket-pos',
      'uploads/2026/10/supermarket-shelves', 'Well-stocked grocery shelves in a supermarket'],
    ['clinic', 'Pharmacy / Clinic', 'Clinic &amp; Pharmacy POS', 'HEALTHCARE', 'Patient billing, medicine stock with expiry alerts and FBR-compliant invoices for clinics, labs and pharmacies.',
      ['Medicine batches &amp; expiry alerts', 'Patient &amp; doctor-wise billing', 'FBR / PRA integration built in'], '/clinics-fbr-pos-integration',
      'uploads/2026/10/pharmacy-counter', 'Pharmacist at the billing computer in a pharmacy'],
    ['other', 'Other business', 'myPOS ERP', 'EVERY KIND OF BUSINESS', 'Bakery, garments, laundry, tailor, distribution, hospital or something custom — one system covers the till to the back office.',
      ['Ready-made apps for 30+ business types', 'Accounting, payroll &amp; HR built in', 'Custom features built on request'], '/features',
      'uploads/2026/10/bakery-sweets-counter', 'Customer buying sweets at a bakery counter'],
  ];
@endphp
<section id="industries" class="bsel">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT FOR YOUR INDUSTRY</span></div>
      <h2>What kind of business do you run?</h2>
      <p>Retail, restaurant or salon — myPOS adapts its workflow to how your business actually runs. Pick yours to see what you get.</p>
    </div>
    <div class="bsel-shell reveal" data-tabs>
      <div class="bsel-tabs" role="tablist" aria-label="Business type">
        @foreach ($industries as $i => [$key, $label])
          <button type="button" role="tab" class="bsel-tab {{ $i === 0 ? 'active' : '' }}" id="bt-{{ $key }}" aria-controls="bp-{{ $key }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" data-tab-target="bp-{{ $key }}">{{ $label }}</button>
        @endforeach
      </div>
      @foreach ($industries as $i => [$key, $label, $product, $tag, $intro, $wins, $href, $img, $alt])
        <div class="bsel-panel {{ $i === 0 ? 'active' : '' }}" role="tabpanel" id="bp-{{ $key }}" aria-labelledby="bt-{{ $key }}" @if ($i) hidden @endif>
          <div class="bsel-copy">
            <div class="ind-tag">{!! $tag !!}</div>
            <h3>{!! $product !!}</h3>
            <p>{{ $intro }}</p>
            <ul class="bsel-wins">@foreach ($wins as $w)<li>{!! $w !!}</li>@endforeach</ul>
            <div class="btn-row">
              <a href="#enquiry" class="btn btn-primary" data-prefill="Business type: {{ $label }}. I would like a free demo of {{ html_entity_decode($product) }}.">Get a demo for my business</a>
              <a href="{{ url($href) }}" class="link-arrow">Explore {!! $product !!} →</a>
            </div>
          </div>
          <div class="bsel-vis tilt" data-tilt>
            @if ($img)
              @if (str_starts_with($img, 'http'))
              <div class="photo"><img src="{{ pexels($img, 900) }}" srcset="{{ pexels($img, 600) }} 600w, {{ pexels($img, 900) }} 900w, {{ pexels($img, 1300) }} 1300w" sizes="(max-width:960px) 100vw, 640px" alt="{{ $alt }}" width="900" height="600" loading="lazy" decoding="async"></div>
              @elseif (is_file(public_path($img . '-900.webp')))
              {{-- Local photo saved as -600 / -900 / -1300 webp, cropped to the card's 5:4 frame. --}}
              <div class="photo"><img src="{{ asset($img . '-900.webp') }}" srcset="{{ asset($img . '-600.webp') }} 600w, {{ asset($img . '-900.webp') }} 900w, {{ asset($img . '-1300.webp') }} 1300w" sizes="(max-width:960px) 100vw, 640px" alt="{{ $alt }}" width="900" height="720" loading="lazy" decoding="async"></div>
              @else
              <div class="photo"><img src="{{ asset($img) }}" alt="{{ $alt }}" width="900" height="600" loading="lazy" decoding="async"></div>
              @endif
            @else
              <div class="bsel-art" aria-hidden="true"><span>{!! $product !!}</span></div>
            @endif
            <div class="bsel-float"><b>Live in 1–3 days</b><span>Setup &amp; training included</span></div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@php
  // Tax authorities: [short name, region, description, url]
  $taxAuthorities = [
    ['FBR', 'Federal', 'Real-time e-invoicing for federal sales tax.', '/fbr-digital-invoicing'],
    ['PRA', 'Punjab', 'Digital reporting for Punjab sales tax.', '/pra-integration'],
    ['KPRA', 'Khyber Pakhtunkhwa', 'Compliant filing for Khyber Pakhtunkhwa.', '/kpra-integration'],
    ['SRB', 'Sindh', 'Automated returns for Sindh sales tax.', '/srb-integration-services-in-pakistan'],
  ];
  // Decorative 21x21 QR-style code for the sample receipt (finder squares + a fixed pseudo-random fill).
  $qr = [];
  for ($y = 0; $y < 21; $y++) {
    for ($x = 0; $x < 21; $x++) {
      $inFinder = ($x < 8 && $y < 8) || ($x > 12 && $y < 8) || ($x < 8 && $y > 12);
      if ($inFinder) continue;
      if ((crc32("mypos{$x}-{$y}") % 100) < 47) $qr[] = [$x, $y];
    }
  }
@endphp
<section id="compliance" class="fx">
  <div class="fx-bg" aria-hidden="true"></div>
  <div class="wrap fx-grid">
    <div class="fx-copy reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>TAX COMPLIANCE</span></div>
      <h2>Stay compliant with FBR &amp; PRA — <span class="fx-hl">automatically.</span></h2>
      <p>myPOS also keeps you compliant with Pakistan's tax authorities. Through built-in <a href="{{ url('/fbr-pos-integration') }}">FBR POS integration</a>, every sale is digitally reported in real time, so you can meet FBR's invoicing requirements without any manual filing or extra paperwork.</p>
      <ul class="fx-points">
        <li><span aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Every invoice reported the moment it's printed</li>
        <li><span aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>FBR invoice number &amp; QR code on every receipt</li>
        <li><span aria-hidden="true"><svg width="12" height="12" viewBox="0 0 16 16" fill="none"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Offline sales queue up and sync automatically</li>
      </ul>
      <div class="fx-cards">
        @foreach ($taxAuthorities as $i => [$code, $region, $desc, $href])
          <a href="{{ url($href) }}" class="fx-card fx-card--{{ strtolower($code) }}">
            <span class="fx-badge">{{ $code }}</span>
            <span class="fx-card-body"><b>{{ $code }} <small>{{ $region }}</small></b><span>{{ $desc }}</span></span>
            <svg class="fx-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        @endforeach
      </div>
      <a href="{{ url('/fbr-pos-integration') }}" class="btn btn-primary fx-cta">Get FBR-integrated POS <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
    </div>

    <div class="fx-visual reveal-right" role="img" aria-label="Sample myPOS sales receipt with FBR invoice number and QR code, and a live filing status panel showing FBR, PRA, KPRA and SRB filed">
      <div class="fx-receipt">
        <span class="fx-sample">Sample receipt</span>
        <div class="fx-r-head">
          <b>Karachi Café &amp; Grill</b>
          <span>NTN 1234567-8 · STRN 32-77-8761-234-56</span>
          <span>Sale Invoice · Counter 1 · 14:32</span>
        </div>
        <div class="fx-r-lines">
          <div><span>Chicken Karahi</span><b>1,800</b></div>
          <div><span>Roghni Naan ×4</span><b>160</b></div>
          <div><span>Mint Margarita ×2</span><b>700</b></div>
        </div>
        <div class="fx-r-sum">
          <div><span>Subtotal</span><b>2,660</b></div>
          <div><span>Sales tax 16%</span><b>426</b></div>
          <div><span>POS service fee</span><b>1</b></div>
        </div>
        <div class="fx-r-total"><span>Total</span><b>Rs 3,087</b></div>
        <div class="fx-r-fbr">
          <svg class="fx-qr" viewBox="0 0 21 21" shape-rendering="crispEdges" aria-hidden="true">
            @foreach ([[0, 0], [14, 0], [0, 14]] as [$fx, $fy])
              <rect x="{{ $fx }}" y="{{ $fy }}" width="7" height="7" fill="#0F2B44"/><rect x="{{ $fx + 1 }}" y="{{ $fy + 1 }}" width="5" height="5" fill="#fff"/><rect x="{{ $fx + 2 }}" y="{{ $fy + 2 }}" width="3" height="3" fill="#0F2B44"/>
            @endforeach
            @foreach ($qr as [$x, $y])<rect x="{{ $x }}" y="{{ $y }}" width="1" height="1" fill="#0F2B44"/>@endforeach
          </svg>
          <div>
            <span class="fx-r-label">FBR Invoice No.</span>
            <b>182046 2610 0714 3201</b>
            <span class="fx-r-ok"><i></i>Verified with FBR</span>
          </div>
        </div>
        <div class="fx-r-foot">Thank you! Scan the QR code to verify this invoice.</div>
      </div>

      <div class="fx-status">
        <div class="fx-status-head"><span class="cm-dot"></span>Live filing status</div>
        @foreach ($taxAuthorities as $i => [$code])
          <div class="fx-row" style="--d:{{ $i }}"><span>{{ $code }}</span><b><i></i>Filed just now</b></div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@php
  // Problem finder: [pain, what myPOS does, icon path]
  $problems = [
    ['Long queues at the counter', 'Barcode billing, saved favourites and split payments ring up a customer in seconds.', 'M3 17h14M5 17V9m4 8V5m4 12v-6m4 6V8'],
    ['Stock goes missing', 'Every item in and out is logged per user, with stock audits and shrinkage reports.', 'M3 6l7-3.5L17 6v8l-7 3.5L3 14V6zM3 6l7 3.5L17 6M10 9.5V17'],
    ['Worried about FBR / PRA notices', 'Each invoice is reported live with an FBR number and QR code — no manual filing.', 'M5 2h10v16l-2.5-1.5L10 18l-2.5-1.5L5 18V2zM7.5 7h5M7.5 10h5'],
    ['Can\'t see other branches', 'Live sales, stock and cash for every branch in one dashboard and on your phone.', 'M2 7h7v7H2zM11 7h7v7h-7zM5.5 7V4h9v3'],
    ['Customer credit (udhaar) is a mess', 'Customer ledgers, payment reminders on WhatsApp and full sale history per customer.', 'M10 4a3.2 3.2 0 110 6.4A3.2 3.2 0 0110 4zM3.5 17c1-3.5 3.8-5.2 6.5-5.2s5.5 1.7 6.5 5.2'],
    ['Internet keeps dropping', 'Keep selling offline — every sale and FBR invoice syncs the moment you reconnect.', 'M2 8a12 12 0 0116 0M5 11a7.5 7.5 0 0110 0M8 14a3 3 0 014 0M10 17h.01'],
  ];
@endphp
<section id="fix" class="fixes">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>FIND YOUR FIX</span></div>
      <h2>What's slowing your business down?</h2>
      <p>Pick the problem you want gone first — we'll show you exactly how myPOS fixes it on a free demo.</p>
    </div>
    <div class="fix-grid stagger">
      @foreach ($problems as $i => [$pain, $fix, $icon])
        <article class="fix-card reveal-3d tilt" data-tilt style="--i:{{ $i }}">
          <span class="fix-ic" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 20 20" fill="none"><path d="{{ $icon }}" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
          <h3>{{ $pain }}</h3>
          <p>{{ $fix }}</p>
          <a href="#enquiry" class="fix-btn" data-prefill="My biggest problem: {{ $pain }}. Please show me how myPOS fixes it.">Fix this first — free demo →</a>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section id="features">
  <div class="wrap">
    <div class="bn-head reveal">
      <div class="section-head">
        <div class="eyebrow-line"><span class="bar"></span><span>FEATURES</span></div>
        <h2>What makes myPOS ERP Software Prominent?</h2>
        <p>Everything a growing retail, restaurant or salon business needs — built in, not bolted on.</p>
      </div>
      <a href="{{ url('/features') }}" class="btn btn-ghost bn-all">See all features →</a>
    </div>

    <div class="bn-grid">
      <article class="bn-card bn-inv reveal-scale" style="--i:0">
        <div class="bn-text">
          <span class="bn-ic bn-ic--coral"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 6l7-3.5L17 6v8l-7 3.5L3 14V6z" stroke="#fff" stroke-width="1.4"/><path d="M3 6l7 3.5L17 6M10 9.5V17" stroke="#fff" stroke-width="1.4"/></svg></span>
          <h3><a href="{{ url('/stock-management') }}">Inventory Management</a></h3>
          <p>Our inventory management system keep track of complete movement of all products from purchase, sale, return and other crucial information instantly.</p>
          <a href="{{ url('/stock-management') }}" class="bn-link">Explore stock management →</a>
        </div>
        <div class="bn-vis bn-stock" aria-hidden="true">
          <div class="bn-vis-head"><b>Stock levels</b><span>Live</span></div>
          <div class="bn-sk"><span>Basmati Rice 5kg</span><i style="--w:86%"></i><b>172</b></div>
          <div class="bn-sk"><span>Cooking Oil 1L</span><i style="--w:58%"></i><b>96</b></div>
          <div class="bn-sk"><span>Tea 950g</span><i style="--w:34%"></i><b>41</b></div>
          <div class="bn-sk is-low"><span>Sugar 1kg</span><i style="--w:9%"></i><b>6 · Low</b></div>
          <div class="bn-po">Purchase order raised automatically</div>
        </div>
      </article>

      <article class="bn-card bn-multi reveal-scale" style="--i:1">
        <span class="bn-ic bn-ic--light"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg></span>
        <h3>Multicompany / Multilocation</h3>
        <p>If you want to handle more than one company or you have more then one branches then myPOS should be the ideal choice for you.</p>
        <div class="bn-branches" aria-hidden="true">
          <div class="bn-hq"><span>Head Office · Consolidated view</span><b>₨ 412,600</b><small>Today, all branches</small></div>
          <div class="bn-br"><i></i><b>Gulberg</b><span>₨ 148,200</span></div>
          <div class="bn-br"><i></i><b>DHA</b><span>₨ 131,900</span></div>
          <div class="bn-br"><i></i><b>Model Town</b><span>₨ 132,500</span></div>
        </div>
        <a href="{{ url('/multi-location-integration') }}" class="bn-link bn-link--light">See multi-location integration →</a>
      </article>

      <article class="bn-card reveal-scale" style="--i:2">
        <span class="bn-ic bn-ic--blue"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="7" r="3.2" stroke="#fff" stroke-width="1.4"/><path d="M3.5 17c1-3.5 3.8-5.2 6.5-5.2s5.5 1.7 6.5 5.2" stroke="#fff" stroke-width="1.4"/></svg></span>
        <h3><a href="{{ url('/customers') }}">Customer Management</a></h3>
        <p>Add customer instantly during checkout and easily manage their Debit/Credit Ledger and view their sale history, send SMS/Email and much more.</p>
        <div class="bn-cust" aria-hidden="true">
          <span class="bn-av">AK</span>
          <div><b>Ahmed Khan</b><span>12 visits · Last: today</span></div>
          <em>Credit ₨ 2,400</em>
        </div>
      </article>

      <article class="bn-card reveal-scale" style="--i:3">
        <span class="bn-ic bn-ic--navy"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="2" y="5" width="16" height="11" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M2 8.5h16" stroke="#fff" stroke-width="1.4"/></svg></span>
        <h3><a href="{{ url('/accounting-software') }}">Multiple Payment Methods</a></h3>
        <p>myPOS allows to accept different mode of payments like CASH, Debit/Credit Card, Gift Card, Cheque, Bank Transfer or Coupon. Even one sale an accept multiple payment modes.</p>
        <div class="bn-chips" aria-hidden="true"><span>Cash</span><span>Card</span><span>Gift Card</span><span>Cheque</span><span>Bank Transfer</span><span>Coupon</span></div>
      </article>

      <article class="bn-card reveal-scale" style="--i:4">
        <span class="bn-ic bn-ic--coral"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v10l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></span>
        <h3>Discount, Refund &amp; Taxes</h3>
        <p>Lot of sale related stuff available to keep the transaction smooth and reliable. Item/product level discounts and taxes and refund are few of them.</p>
        <div class="bn-mini" aria-hidden="true">
          <div><span>Item discount</span><b class="is-green">−10%</b></div>
          <div><span>Sales tax</span><b>16%</b></div>
          <div><span>Refund #1038</span><b class="is-coral">Approved</b></div>
        </div>
      </article>

      <article class="bn-card reveal-scale" style="--i:5">
        <span class="bn-ic bn-ic--blue"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8" stroke="#fff" stroke-width="1.4"/><path d="M2 10h16M10 2c2.2 2 3.3 5 3.3 8s-1.1 6-3.3 8c-2.2-2-3.3-5-3.3-8S7.8 4 10 2z" stroke="#fff" stroke-width="1.4"/></svg></span>
        <h3>Multilingual</h3>
        <p>To facilitate our national and international customer, myPOS is available in three languages (English, Urdu, Arabic) now and more to come soon...</p>
        <div class="bn-langs" aria-hidden="true"><span class="on">English</span><span lang="ur" dir="rtl">اردو</span><span lang="ar" dir="rtl">العربية</span></div>
      </article>

      <article class="bn-card bn-cta reveal-scale" style="--i:6">
        <div class="h3">Need something built for your business?</div>
        <p>We also develop custom applications as per the customer&rsquo;s requirements.</p>
        <div class="bn-cta-btns">
          <a href="#enquiry" class="btn btn-primary">Book a Free Demo</a>
          <a href="{{ wa_link() }}" class="bn-link bn-link--light" target="_blank" rel="noopener">or WhatsApp us →</a>
        </div>
      </article>
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
          <div class="dm-bar" aria-hidden="true"><span class="hx-dots"><i></i><i></i><i></i></span><span>myPOS</span><em><i></i>Synced</em></div>
          <div class="device-panel active" data-panel="desktop">
            <div class="d-row"><span>Order #4821</span><b>2x Zinger Combo</b></div>
            <div class="d-row"><span>Payment</span><b>Cash + Card</b></div>
            <div class="d-row"><span>Discount</span><b>Loyalty 10%</b></div>
            <div class="d-row"><span>Tax (FBR)</span><b>Filed automatically</b></div>
            <div class="d-row" style="border:none;"><span>Total</span><b style="color:#5CC8FF; font-size:1.1rem;">₨ 1,840</b></div>
          </div>
          <div class="device-panel" data-panel="mobile">
            <div class="phone-mock">
              <div class="pm-notch" aria-hidden="true"></div>
              @if (config('site.app_screenshot'))
                <img src="{{ asset(config('site.app_screenshot')) }}" alt="myPOS mobile app showing today's sales report" loading="lazy">
              @else
                <div class="pm-screen">
                  <div class="pm-head"><small>Today, all branches</small><b>₨ 412,600</b><em>▲ 18% vs yesterday</em></div>
                  <div class="pm-bars" aria-hidden="true"><i style="height:40%"></i><i style="height:58%"></i><i style="height:46%"></i><i style="height:72%"></i><i style="height:64%"></i><i style="height:86%"></i><i style="height:100%"></i></div>
                  <div class="pm-row"><span>Top branch</span><b>Gulberg</b></div>
                  <div class="pm-row"><span>Low stock</span><b class="warn">3 items</b></div>
                  <div class="pm-row"><span>Pending refunds</span><b>2</b></div>
                </div>
              @endif
            </div>
          </div>
          <div class="device-panel" data-panel="cloud">
            <div class="d-row"><span>Locations online</span><b>4 / 4</b></div>
            <div class="d-row"><span>Consolidated inventory</span><b>2,340 SKUs</b></div>
            <div class="d-row"><span>Staff access levels</span><b>Cashier / Manager / Admin</b></div>
            <div class="d-row" style="border:none;"><span>Last full sync</span><b>Just now</b></div>
          </div>
        </div>
        <div class="tab-copy reveal-right">
          <div class="h4" id="tabTitle">Full sales terminal, offline-ready</div>
          <p id="tabDesc">Ring up items, split payments, apply discounts and print or send receipts — even mid-outage. Every FBR invoice files itself the moment you're back online.</p>
          <a href="#enquiry" class="link-arrow" data-tab-hide="mobile">See it on a free demo →</a>
          <div class="app-dl" data-tab-show="mobile" hidden>
            <ul class="app-dl-points"><li>Live sales &amp; profit for every branch</li><li>Stock alerts and refund approvals</li><li>Free with every myPOS plan</li></ul>
            @if (config('site.play_store_url'))
              <a href="{{ config('site.play_store_url') }}" class="gplay" target="_blank" rel="noopener">
                <svg width="26" height="28" viewBox="0 0 26 28" aria-hidden="true"><path d="M1.2.6L14.4 14 1.2 27.4a1.6 1.6 0 01-.7-1.4V2C.5 1.4.8.9 1.2.6z" fill="#00D7FE"/><path d="M18.8 9.6L14.4 14 1.2.6c.4-.3 1-.3 1.6 0z" fill="#00F076"/><path d="M18.8 18.4l-16 9c-.6.3-1.2.3-1.6 0L14.4 14z" fill="#FF3A44"/><path d="M24.4 12.6c1 .6 1 2.2 0 2.8l-5.6 3L14.4 14l4.4-4.4z" fill="#FFD400"/></svg>
                <span><small>GET IT ON</small>Google Play</span>
              </a>
            @else
              <a href="#enquiry" class="btn btn-primary">Get the app with a free demo</a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="feat-sub reveal" id="software">
      <h3>One system, every kind of business.</h3>
      <p class="feat-sub-lead">Beyond the core POS, myPOS covers the software your whole operation runs on — from the till to the back office.</p>
      @php
        // [label, url, group, svg path markup (24x24, stroked)]
        $bizTiles = [
          ['Retail', '/retail-management', 'POS', '<path d="M4 9l1.5-5h13L20 9"/><path d="M4 9h16v2a3 3 0 01-5.3 2A3 3 0 0112 14a3 3 0 01-2.7-1A3 3 0 014 11z"/><path d="M5 14v6h14v-6"/><path d="M10 20v-4h4v4"/>'],
          ['Restaurant', '/restaurant-management', 'POS', '<path d="M7 3v8M5 3v5a2 2 0 004 0V3M7 11v10"/><path d="M17 21V3c-2 1-3 4-3 7v3h3"/>'],
          ['Salon &amp; Spa', '/salon-management', 'POS', '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M8.1 8.1L20 20M8.1 15.9L20 4"/>'],
          ['Supermarket', '/supermarket-pos', 'POS', '<path d="M3 4h2l2.4 11h11l2-8H6"/><circle cx="9" cy="19.5" r="1.5"/><circle cx="17" cy="19.5" r="1.5"/>'],
          ['Bakery', '/bakery-pos', 'POS', '<path d="M4 13a8 5 0 0116 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2z"/><path d="M9 9.5l1 4M15 9.5l-1 4M12 9v4.5"/>'],
          ['Garments', '/garments-pos', 'POS', '<path d="M9 3l3 2 3-2 5 3-2 4-2-1v12H8V9l-2 1-2-4z"/>'],
          ['Laundry', '/laundry-management', 'POS', '<rect x="4" y="3" width="16" height="18" rx="2"/><circle cx="12" cy="13" r="4.5"/><path d="M7 6.5h.01M10 6.5h.01"/>'],
          ['Tailor', '/tailor-management', 'POS', '<path d="M4 20L18 6"/><circle cx="19" cy="5" r="1.6"/><path d="M4 8c3 0 3 3 6 3s3-3 6-3"/>'],
          ['Car Wash', '/car-wash-pos', 'POS', '<path d="M5 15l1.6-4.5A2 2 0 018.5 9h7a2 2 0 011.9 1.5L19 15"/><rect x="3" y="15" width="18" height="4" rx="1.5"/><path d="M8 4.5c0 1-.8 1.5-.8 2.3a.8.8 0 001.6 0C8.8 6 8 5.5 8 4.5zM16 4.5c0 1-.8 1.5-.8 2.3a.8.8 0 001.6 0C16.8 6 16 5.5 16 4.5z"/>'],
          ['Clinics &amp; Pharmacy', '/clinics-fbr-pos-integration', 'Healthcare', '<rect x="3" y="5" width="18" height="15" rx="2"/><path d="M12 9v7M8.5 12.5h7M9 5V3h6v2"/>'],
          ['Hospital', '/hospital-management', 'Healthcare', '<path d="M4 21V7l8-4 8 4v14"/><path d="M12 8v6M9 11h6M9 21v-4h6v4"/>'],
          ['Schools &amp; Colleges', '/schools-fbr-pos-integration', 'Education', '<path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c3 2.5 9 2.5 12 0v-5M22 9v6"/>'],
          ['Gym &amp; Fitness', '/gym-fbr-pos-integration', 'Services', '<path d="M6.5 6.5v11M17.5 6.5v11M3.5 9v6M20.5 9v6M6.5 12h11"/>'],
          ['Distribution', '/distribution-management', 'Cloud', '<path d="M2 6h11v10H2zM13 9h4l3 3.5V16h-7"/><circle cx="6" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>'],
          ['Accounting', '/accounting-software', 'Back office', '<rect x="5" y="2.5" width="14" height="19" rx="2"/><path d="M8 6.5h8M8 11h.01M12 11h.01M16 11h.01M8 14.5h.01M12 14.5h.01M16 14.5h.01M8 18h.01M12 18h4"/>'],
          ['Payroll &amp; HR', '/payroll-software', 'Back office', '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0113 0"/><path d="M17 7v8M19.5 9H16a1.3 1.3 0 000 2.6h2a1.3 1.3 0 010 2.6h-3.5"/>'],
        ];
      @endphp
      <div class="biz-grid stagger">
        @foreach ($bizTiles as $i => [$label, $href, $group, $icon])
          <a href="{{ url($href) }}" class="biz-tile reveal-scale" style="--i:{{ $i % 8 }}">
            <span class="biz-ic"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg></span>
            <b>{!! $label !!}</b>
            <small>{{ $group }}</small>
            <i class="biz-go" aria-hidden="true">→</i>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section id="savings" class="calc">
  <div class="calc-bg" aria-hidden="true"></div>
  <div class="wrap calc-grid">
    <div class="calc-copy reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">SAVINGS CALCULATOR</span></div>
      <div class="h2">How much is manual billing costing you?</div>
      <p>Move the sliders to match your business. We'll estimate the staff time and stock leakage myPOS can win back every month.</p>
      <div class="calc-inputs" data-calc>
        <label class="calc-field"><span>Monthly sales <b data-out="sales">Rs 1,500,000</b></span>
          <input type="range" min="200000" max="20000000" step="100000" value="1500000" data-in="sales"></label>
        <label class="calc-field"><span>Staff doing billing / stock work <b data-out="staff">3</b></span>
          <input type="range" min="1" max="25" step="1" value="3" data-in="staff"></label>
        <label class="calc-field"><span>Hours each spends on manual work per day <b data-out="hours">2</b></span>
          <input type="range" min="0.5" max="8" step="0.5" value="2" data-in="hours"></label>
        <label class="calc-field"><span>Average staff cost per hour <b data-out="wage">Rs 250</b></span>
          <input type="range" min="100" max="1500" step="25" value="250" data-in="wage"></label>
      </div>
    </div>
    <div class="calc-result reveal-right tilt" data-tilt aria-live="polite">
      <span class="calc-label">You could save around</span>
      <div class="calc-total">Rs <span data-out="total">0</span><small>/month</small></div>
      <div class="calc-split">
        <div><b>Rs <span data-out="time">0</span></b><span>Staff time won back</span></div>
        <div><b>Rs <span data-out="leak">0</span></b><span>Stock leakage stopped</span></div>
      </div>
      <div class="calc-roi">That's <b data-out="roi">0×</b> the cost of myPOS (from Rs 2,000/month).</div>
      <a href="#enquiry" class="btn btn-primary" data-prefill="I used the savings calculator and want to see how much myPOS can save my business.">Show me these savings — free demo</a>
      <p class="calc-note">Estimate only: assumes myPOS automates 60% of manual billing &amp; stock work and cuts stock leakage by 1.5% of sales. Your demo gives you real numbers.</p>
    </div>
  </div>
</section>

@php
  $reviews = config('site.reviews');
  $initials = fn ($n) => strtoupper(collect(preg_split('/\s+/', trim($n)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
  $writeReview = 'https://admin.trustindex.io/api/googleWriteReview?place-id=ChIJ16hGakEFGTkRfzzOykTT1q4';
@endphp
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="rv-star" viewBox="0 0 20 20"><path d="M10 1.8l2.5 5.2 5.7.8-4.1 4 1 5.7L10 14.8l-5.1 2.7 1-5.7-4.1-4 5.7-.8L10 1.8z" fill="#F5B301"/></symbol>
  <symbol id="rv-google" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/><path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/><path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/><path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.4-.4-3.5z"/></symbol>
</svg>
<section id="reviews" class="reviews">
  <div class="wrap sx">
    <div class="sx-card stagger">
      <div class="sx-stat reveal-scale" style="--i:0">
        <span class="sx-ic sx-ic--blue"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 20c1.3-4.5 4.8-6.5 8-6.5s6.7 2 8 6.5" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.7"/></svg></span>
        <div class="sx-num"><span class="num" data-count="15000">0</span></div>
        <div class="sx-lbl">Customers globally</div>
        <div class="sx-sub">Retail, restaurants, salons &amp; more</div>
      </div>
      <div class="sx-stat reveal-scale" style="--i:1">
        <span class="sx-ic sx-ic--coral"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="8" cy="9" r="3.2" stroke="currentColor" stroke-width="1.7"/><circle cx="17" cy="10" r="2.6" stroke="currentColor" stroke-width="1.7"/><path d="M2.5 20c.9-3.6 3.3-5.2 5.5-5.2s4.6 1.6 5.5 5.2M14.5 20c.6-3 2.4-4.4 4-4.4s3.3 1.4 4 4.4" stroke="currentColor" stroke-width="1.7"/></svg></span>
        <div class="sx-num"><span class="num" data-count="12000">0</span></div>
        <div class="sx-lbl">Active users</div>
        <div class="sx-sub">Ringing up sales every day</div>
      </div>
      <div class="sx-stat reveal-scale" style="--i:2">
        <span class="sx-ic sx-ic--amber"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3.5l2.6 5.4 5.9.9-4.3 4.2 1 5.9-5.2-2.8-5.2 2.8 1-5.9-4.3-4.2 5.9-.9L12 3.5z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
        <div class="sx-num"><span class="num" data-decimal="4.9">0</span><small>/5</small></div>
        <div class="sx-lbl">Average rating</div>
        <div class="sx-sub sx-stars" aria-hidden="true">★★★★★</div>
      </div>
      <div class="sx-stat reveal-scale" style="--i:3">
        <span class="sx-ic sx-ic--green"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.7"/><path d="M12 7.5V12l3.2 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
        <div class="sx-num">&lt;2<small>min</small></div>
        <div class="sx-lbl">Avg. response time</div>
        <div class="sx-sub">On phone &amp; WhatsApp</div>
      </div>
    </div>
  </div>
  <div class="wrap rv-layout">
    <div class="rv-panel reveal">
      <div class="rv-head">
        <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">CUSTOMER REVIEWS</span></div>
        <div class="h2">Loved by businesses across Pakistan.</div>
        <p>Real reviews from myPOS customers — retail, salon, hospital and restaurant owners.</p>
      </div>
      <div class="rv-actions">
      <div class="rv-score-row">
        <span class="rv-score">5.0</span>
        <div>
          <div class="rv-stars" role="img" aria-label="5 out of 5 stars">@for ($s = 0; $s < 5; $s++)<svg><use href="#rv-star"/></svg>@endfor</div>
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
          <div class="rv-stars" role="img" aria-label="5 out of 5 stars">@for ($s = 0; $s < 5; $s++)<svg><use href="#rv-star"/></svg>@endfor</div>
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
<section id="product-tour" class="tour-band" style="background-image:linear-gradient(160deg, rgba(10,37,64,0.95), rgba(15,59,99,0.9)), url('{{ asset('uploads/2019/01/mart-pos-mypos-pk-1.webp') }}');">
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
          <div class="tour-panel {{ $i === 0 ? 'active' : '' }} {{ $key === 'all-in-one' ? 'is-illus' : '' }}" role="tabpanel" id="tp-{{ $key }}" aria-labelledby="tt-{{ $key }}" @if ($i) hidden @endif>
            <picture>
              @if (is_file(public_path('uploads/' . $img . '-760.webp')))
                <source srcset="{{ asset('uploads/' . $img . '-760.webp') }} 760w, {{ asset('uploads/' . $img . '.webp') }} 1440w" sizes="(max-width:960px) 100vw, 760px" type="image/webp">
              @else
                <source srcset="{{ asset('uploads/' . $img . '.webp') }}" type="image/webp">
              @endif
              <img src="{{ asset('uploads/' . $img . '.' . $ext) }}" alt="{{ $alt }}" width="{{ $key === 'all-in-one' ? 544 : 1440 }}" height="{{ $key === 'all-in-one' ? 459 : 860 }}" loading="{{ $i ? 'lazy' : 'eager' }}" decoding="async">
            </picture>
            <div class="tp-cap"><span class="tp-dot"></span>{{ $label }} <em>— {{ $desc }}</em></div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="tour-cta reveal">
      <a href="#enquiry" class="btn btn-primary">Book Now</a>
      <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
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
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#9E3412"/><path d="M5 9.2L7.7 12L13 6" stroke="#9E3412" stroke-width="1.6"/></svg>myPOS setup is ready to trade within minutes.</li>
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#9E3412"/><path d="M5 9.2L7.7 12L13 6" stroke="#9E3412" stroke-width="1.6"/></svg>As a free POS software solution, it works with almost all POS hardware.</li>
        <li><svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="#9E3412"/><path d="M5 9.2L7.7 12L13 6" stroke="#9E3412" stroke-width="1.6"/></svg>Get started with guides and a 24-hour customer support team.</li>
      </ul>
      <a href="{{ url('/features') }}" class="link-arrow">See all features →</a>
    </div>
  </div>
</section>

<section id="get-started" class="steps-band">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>GET STARTED</span></div>
      <h2>Go live in three simple steps.</h2>
      <p>Most businesses have myPOS fully set up within 1 to 3 days — installation, data migration, product setup and staff training included.</p>
    </div>
    <ol class="steps-grid stagger">
      <li class="step-card reveal-scale" style="--i:0">
        <span class="step-num">1</span>
        <div class="h3">Book a free demo</div>
        <p>Tell us about your business. We show you myPOS working on your own products and answer every question.</p>
      </li>
      <li class="step-card reveal-scale" style="--i:1">
        <span class="step-num">2</span>
        <div class="h3">We set it up for you</div>
        <p>Installation, product upload, hardware and your FBR / PRA integration — handled by our team.</p>
      </li>
      <li class="step-card reveal-scale" style="--i:2">
        <span class="step-num">3</span>
        <div class="h3">Start selling</div>
        <p>Your staff is trained and our 24-hour support team stays on call, by phone and WhatsApp.</p>
      </li>
    </ol>
    <div class="steps-cta reveal">
      <a href="#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <span class="steps-note">No obligation · Free version available</span>
    </div>
  </div>
</section>

@php
  // Comparison: [row, manual register / Excel, typical POS, myPOS]   true = yes, false = no, string = note
  $compare = [
    ['FBR / PRA / KPRA / SRB invoicing', false, 'Paid add-on', 'Built in'],
    ['Works without internet', true, false, 'Offline + auto-sync'],
    ['Live stock across branches', false, 'Extra cost', true],
    ['Accounting, HR &amp; payroll', false, false, true],
    ['Urdu &amp; Arabic interface', false, false, true],
    ['Setup, data migration &amp; training', false, 'Self-service', 'Done for you'],
    ['Local support on phone &amp; WhatsApp', false, 'Email tickets', '24-hour, &lt;2 min reply'],
    ['Free version to start', true, false, true],
  ];
  $mark = fn ($v) => $v === true ? '<span class="cmp-yes" aria-label="Yes">✓</span>' : ($v === false ? '<span class="cmp-no" aria-label="No">✕</span>' : '<span class="cmp-note">' . $v . '</span>');
@endphp
<section id="compare" class="compare">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2>myPOS vs the way you do it today.</h2>
      <p>See why 15,000+ businesses moved off registers, spreadsheets and generic POS apps.</p>
    </div>
    <div class="cmp-wrap reveal-3d">
      <table class="cmp">
        <thead><tr><th scope="col"><span class="sr-only">Feature</span></th><th scope="col">Register / Excel</th><th scope="col">Typical POS app</th><th scope="col" class="cmp-us">myPOS</th></tr></thead>
        <tbody>
          @foreach ($compare as [$row, $a, $b, $c])
            <tr><th scope="row">{!! $row !!}</th><td>{!! $mark($a) !!}</td><td>{!! $mark($b) !!}</td><td class="cmp-us">{!! $mark($c) !!}</td></tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="steps-cta reveal">
      <a href="#enquiry" class="btn btn-primary" data-prefill="I'd like to switch to myPOS — please book my free demo.">Switch to myPOS — free demo</a>
      <span class="steps-note">We move your products &amp; customers over for you</span>
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
        <a href="#enquiry" class="link-arrow">Need a custom application? Get in touch →</a>
      </div>
    </div>
    <div class="network-card reveal-right">
      <svg viewBox="0 0 400 380">
        <defs>
          <linearGradient id="flow" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="#5CC8FF"/>
            <stop offset="1" stop-color="#1A5A8E"/>
          </linearGradient>
        </defs>
        <path id="p1" d="M60,90 C160,60 220,140 320,110" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <path id="p2" d="M60,200 C160,180 220,230 320,190" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <path id="p3" d="M60,300 C160,300 220,240 320,270" fill="none" stroke="rgba(255,255,255,0.14)" stroke-width="1.5"/>
        <circle r="4" fill="url(#flow)"><animateMotion dur="3.2s" repeatCount="indefinite"><mpath href="#p1"/></animateMotion></circle>
        <circle r="4" fill="url(#flow)"><animateMotion dur="3.6s" repeatCount="indefinite" begin="0.5s"><mpath href="#p2"/></animateMotion></circle>
        <circle r="4" fill="url(#flow)"><animateMotion dur="4s" repeatCount="indefinite" begin="1s"><mpath href="#p3"/></animateMotion></circle>
        <circle cx="60" cy="90" r="5" fill="#5CC8FF"/>
        <circle cx="60" cy="200" r="5" fill="#5CC8FF"/>
        <circle cx="60" cy="300" r="5" fill="#5CC8FF"/>
        <circle cx="320" cy="190" r="7" fill="#C8461C"/>
      </svg>
      <div class="node-label" style="top:56px; left:22px;"><div class="nd"></div><div><b>Gulberg</b>Branch — synced</div></div>
      <div class="node-label" style="top:168px; left:22px;"><div class="nd"></div><div><b>DHA</b>Branch — synced</div></div>
      <div class="node-label" style="top:268px; left:22px;"><div class="nd"></div><div><b>Model Town</b>Branch — synced</div></div>
      <div class="node-label" style="top:150px; right:8px; background:var(--coral-deep); border-color:transparent;"><div class="nd" style="background:#fff;"></div><div><b>Head Office</b>Consolidated view</div></div>
    </div>
  </div>
</section>

<section id="full-control" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="media-frame contain reveal-left"><img src="{{ asset('uploads/2024/01/software-process-jpg-removebg-preview-min.png') }}" alt="myPOS software process — purchase, stock, sale and reporting" width="503" height="496" loading="lazy" decoding="async"></div>
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
        <img src="{{ asset('uploads/2018/05/My-Pos-Logo.png') }}" alt="myPOS logo" width="116" height="142" loading="lazy" class="cc-logo">
        <p class="cc-big">myPOS is serving 15000+ customers globally.</p>
        <p>We also develop custom applications as per the customer&rsquo;s requirements.</p>
        <a href="{{ url('/contact') }}" class="link-arrow">Contact Us →</a>
      </div>
      <div class="control-card reveal-scale" style="--i:1">
        <div class="h3">Useful info</div>
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
        <div class="h3">Starter</div>
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
        <div class="h3">Business</div>
        <div class="pc-price">Contact Sales</div>
        <div class="pc-sub">For growing multi-branch businesses</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Everything in Starter</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Multi-location &amp; multi-company</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>FBR / PRA / KPRA / SRB e-invoicing</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>WhatsApp, SMS &amp; email receipts</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Role-based staff access</li>
        </ul>
        <a href="#enquiry" class="btn btn-primary">Book a Free Demo</a>
      </div>
      <div class="price-card reveal-scale" style="--i:2">
        <div class="pc-badge">CUSTOM</div>
        <div class="h3">Enterprise</div>
        <div class="pc-price">Custom</div>
        <div class="pc-sub">Tailored builds for large operations</div>
        <ul>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Everything in Business</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Custom application development</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Dedicated onboarding &amp; training</li>
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Priority 24-hour support</li>
        </ul>
        <a href="#enquiry" class="btn btn-ghost">Book a Free Demo</a>
      </div>
    </div>
    <div class="pricing-links reveal">
      <a href="{{ url('/pricing') }}">RetailPro Pricing</a>
      <a href="{{ url('/pricing-restropro') }}">RestroPro Pricing</a>
      <a href="{{ url('/pricing-salonpro') }}">SalonPro Pricing</a>
      <a href="{{ url('/pricing-laundry-pro') }}">LaundryPro Pricing</a>
      <a href="{{ url('/pricing-tailorpro') }}">TailorPro Pricing</a>
    </div>
    <div class="free-band reveal" id="free-version">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <div class="h3">Try out free version</div>
        <p style="color:var(--text-mute-ink); margin-bottom:8px;">Our free POS software version covers all basic sales functions.</p>
        <ul>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Support is not Included</li>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Fully compatible with Windows 7,8,10</li>
        </ul>
      </div>
      <div class="btn-row">
        <a href="#enquiry" class="btn btn-primary" style="white-space:nowrap;">Book a Free Demo</a>
        <a href="https://drive.google.com/open?id=1EQBjuP8GQZDwOKGs09rf81bU56QD-2mM&usp=drive_fs" class="btn btn-outline" style="white-space:nowrap;" target="_blank" rel="noopener">Download free version</a>
      </div>
    </div>
  </div>
</section>

@php
  // Price builder — figures from the /pricing and /one-time-pricing pages.
  $addons = [
    ['offline', 'Offline Module', 500], ['accounting', 'Accounting Module', 1000], ['fbr-di', 'FBR Digital Invoicing', 1000],
    ['fbr-pos', 'FBR / PRA / SRB POS Integration', 500], ['whatsapp', 'WhatsApp Invoicing', 500], ['mobile', 'Mobile App', 1000],
    ['instalment', 'Instalment Module', 1000], ['manufacturing', 'Manufacturing Module', 1000], ['woocommerce', 'WooCommerce Integration', 1000],
    ['catalogue', 'Online Store Catalogue', 1000],
  ];
@endphp
<section id="builder" class="builder">
  <div class="wrap">
    <div class="section-head center reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>PRICE BUILDER</span></div>
      <div class="h2">Build your myPOS setup in one minute.</div>
      <p>Pick your business, branches and modules — see your price instantly. No sign-up, pay only for what you use.</p>
    </div>
    <form class="bld reveal-3d" method="POST" action="{{ route('enquiry.store') }}#builder" data-builder novalidate>
      @csrf
      <input type="hidden" name="page" value="home (price builder)">
      <input type="hidden" name="type" value="Price Builder">
      <input type="hidden" name="message" data-bld-message>
      <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <ol class="bld-steps" aria-hidden="true"><li class="on">Business</li><li>Branches</li><li>Plan</li><li>Modules</li><li>Your price</li></ol>

      <fieldset class="bld-step on" data-step="0">
        <legend>What kind of business is it?</legend>
        <div class="bld-chips">
          @foreach ($businessTypes as $i => $bt)
            <label class="bld-chip"><input type="radio" name="bld_business" value="{{ $bt }}" @checked($i === 0)><span>{{ $bt }}</span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="1">
        <legend>How many branches?</legend>
        <div class="bld-chips">
          @foreach (['1' => '1 branch', '2-3' => '2–3 branches', '4-10' => '4–10 branches', '10+' => '10+ branches'] as $v => $l)
            <label class="bld-chip"><input type="radio" name="bld_branches" value="{{ $v }}" @checked($v === '1')><span>{{ $l }}</span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="2">
        <legend>How would you like to pay?</legend>
        <div class="bld-chips bld-chips--big">
          <label class="bld-chip"><input type="radio" name="bld_plan" value="monthly" checked><span><b>Monthly</b><small>Rs 2,000/month · 14 days free</small></span></label>
          <label class="bld-chip"><input type="radio" name="bld_plan" value="onetime"><span><b>One-time licence</b><small>From Rs 24,000, pay once</small></span></label>
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="3">
        <legend>Which add-ons do you need? <small>(optional)</small></legend>
        <div class="bld-chips bld-chips--mods">
          @foreach ($addons as [$key, $name, $price])
            <label class="bld-chip"><input type="checkbox" name="bld_mod" value="{{ $key }}" data-name="{{ $name }}" data-price="{{ $price }}"><span>{{ $name }} <small>+Rs {{ number_format($price) }}/mo</small></span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="4">
        <legend>Your estimated price</legend>
        <div class="bld-result">
          <div class="bld-price" aria-live="polite"><span data-bld-price>Rs 2,000</span><small data-bld-per>/month</small></div>
          <p class="bld-plan" data-bld-plan>Standard monthly plan · first 14 days free</p>
          <ul class="bld-summary" data-bld-summary></ul>
        </div>
        <div class="bld-contact">
          <p>Get this exact quote and a free demo — we'll confirm on WhatsApp.</p>
          <div class="form-row">
            <div class="field"><label for="b-name">Full name <span class="req">*</span></label><input id="b-name" type="text" name="name" placeholder="Your name" required autocomplete="name"></div>
            <div class="field"><label for="b-phone">Phone / WhatsApp <span class="req">*</span></label><input id="b-phone" type="tel" name="phone" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel"></div>
          </div>
          <div class="btn-row">
            <button class="btn btn-primary" type="submit">Send me this quote</button>
            <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener" data-bld-wa>Or send on WhatsApp</a>
          </div>
        </div>
      </fieldset>

      <div class="bld-nav">
        <button type="button" class="btn btn-ghost" data-bld-back hidden>← Back</button>
        <button type="button" class="btn btn-primary" data-bld-next>Next →</button>
      </div>
      <p class="bld-note">Prices from our pricing pages. Multi-branch and FBR setups on a one-time licence are quoted individually.</p>
    </form>
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
        <div class="h3">Still have questions?</div>
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
        <form class="callback" method="POST" action="{{ route('enquiry.store') }}#faq" novalidate>
          @csrf
          <input type="hidden" name="page" value="home (call me back)">
          <input type="hidden" name="type" value="Call Me Back">
          <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
          <b>Rather talk it through? We'll call you.</b>
          <label class="sr-only" for="c-name">Your name</label>
          <input id="c-name" type="text" name="name" placeholder="Your name" required autocomplete="name">
          <label class="sr-only" for="c-phone">Phone number</label>
          <input id="c-phone" type="tel" name="phone" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel">
          <button class="btn btn-primary" type="submit">Call Me Back</button>
          <small>No sales pressure · Mon–Fri, 10am–6pm</small>
        </form>
        <a href="{{ url('/contact') }}" class="btn btn-outline" style="margin-top:14px; width:100%; justify-content:center;">Contact Support</a>
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
