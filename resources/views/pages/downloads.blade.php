@extends('layouts.app')

@section('page', 'downloads')
@section('title', 'Downloads - Free POS Software for Retail, Restaurant, Salon, Laundry & Tailor Shops')
@section('description', 'Download myPOS free POS software for Pakistan: RetailPro, RestroPro, SalonPro, LaundryPro and TailorPro. Free version covers basic sales functions, Windows 7/8/10.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
$check = '<svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>';
$dlIcon = '<svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M10 3v10M5.5 8.5L10 13l4.5-4.5M4 16.5h12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$freeFile = 'https://drive.google.com/open?id=1EQBjuP8GQZDwOKGs09rf81bU56QD-2mM&usp=drive_fs';
$products = [
    ['id' => 'retailpro', 'name' => 'RetailPro', 'for' => 'Retail stores, supermarkets & pharmacies',
     'text' => 'The myPOS free version for retail stores — covers all basic sales functions, ideal for testing myPOS before you upgrade.',
     'file' => $freeFile, 'details' => null, 'meta' => ['Free version', 'Windows 7/8/10'],
     'more' => [['Retail Management', '/retail-management'], ['Pricing', '/pricing']]],
    ['id' => 'restropro', 'name' => 'RestroPro', 'for' => 'Restaurants, cafés & fast food',
     'text' => 'Covering all features of Restaurants — recipe management, kitchen print (KOT), kitchen display screen and waiter order taking app.',
     'file' => 'https://drive.google.com/file/d/1E8i1FrSGBWUXo11PZsDwbub2YyHRkIR2/view', 'details' => '/download/restropro',
     'meta' => ['Version 2.0', '74.33 MB', '17,135 downloads'],
     'more' => [['Restaurant Management', '/restaurant-management'], ['RestroPro Pricing', '/pricing-restropro']]],
    ['id' => 'salonpro', 'name' => 'SalonPro', 'for' => 'Salons, spas & beauty parlours',
     'text' => 'POS software for salons and spas — see SalonPro screenshots on the details page.',
     'file' => 'https://drive.google.com/open?id=10w4n2rDb1mI4xMk8F5avGRbAgzbvX4mf&usp=drive_fs', 'details' => '/download/salonpro',
     'meta' => ['Version 2.0', '70.10 MB', '602 downloads'],
     'more' => [['Salon Management', '/salon-management'], ['SalonPro Pricing', '/pricing-salonpro']]],
    ['id' => 'laundrypro', 'name' => 'LaundryPro', 'for' => 'Laundries & dry cleaners',
     'text' => 'Covering all features of laundries — dynamic services, unlimited categories, service wise pricing, delivery control and WhatsApp messaging.',
     'file' => 'https://drive.google.com/open?id=1LZw1dblpTFInfCxdRR40eEAybhxqKliB&usp=drive_fs', 'details' => '/download/laundrypro',
     'meta' => ['Version 2.0', '61.52 MB', '20,609 downloads'],
     'more' => [['Laundry Management', '/laundry-management'], ['LaundryPro Pricing', '/pricing-laundry-pro']]],
    ['id' => 'tailorpro', 'name' => 'TailorPro', 'for' => 'Tailor shops',
     'text' => 'Specially designed for Tailor Shops — measurements, service wise pricing, deliveries, customer ledger and debit / credit.',
     'file' => 'https://drive.google.com/open?id=12yzq1fhFi7yolb0DG6bJx0p6T-GFguiT&usp=drive_fs', 'details' => '/download/tailorpro',
     'meta' => ['Version 2.0', '80 MB', '11,946 downloads'],
     'more' => [['TailorPro Pricing', '/pricing-tailorpro']]],
];
@endphp

@section('content')
<x-page-header title="Downloads" eyebrow="FREE POS SOFTWARE" crumb="Downloads"
  lead="Download myPOS free — choose the edition built for your business and start selling today." :call="true">
  <div class="btn-row reveal" style="margin-top:22px;">
    @foreach ($products as $prod)
      <a href="#{{ $prod['id'] }}" class="btn btn-outline btn-sm">{{ $prod['name'] }}</a>
    @endforeach
  </div>
</x-page-header>

{{-- Free version info --}}
<section class="section-tight">
  <div class="wrap">
    <div class="free-band reveal" style="margin-top:0;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Try out free version</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:8px;">Our free version covers all basic sales functions.</p>
        <ul>
          <li>{!! $check !!}Support is not Included</li>
          <li>{!! $check !!}Fully compatible with Windows 7,8,10</li>
        </ul>
      </div>
      <a href="{{ $freeFile }}" class="btn btn-primary" style="white-space:nowrap;" target="_blank" rel="noopener">{!! $dlIcon !!} Download Now</a>
    </div>
  </div>
</section>

{{-- Product downloads --}}
<section id="products" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>CHOOSE YOUR EDITION</span></div>
      <h2>One POS, built for every business.</h2>
      <p>Each edition is a free download — upgrade any time for support, FBR / PRA integration and extra modules.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:22px; margin-top:44px;" class="stagger">
      @foreach ($products as $i => $prod)
        <article id="{{ $prod['id'] }}" class="download-card reveal-scale" style="--i:{{ $i }}; scroll-margin-top:110px;">
          <div style="display:flex; align-items:center; gap:14px;">
            <div class="ft-icon" style="width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; background:linear-gradient(135deg,var(--coral),var(--coral-deep)); flex-shrink:0;">{!! $dlIcon !!}</div>
            <div>
              <h3 style="font-size:1.25rem;">{{ $prod['name'] }}</h3>
              <div style="font-size:0.84rem; color:var(--text-mute-ink);">{{ $prod['for'] }}</div>
            </div>
          </div>
          <p style="font-size:0.92rem; color:var(--text-mute-ink); margin:0; flex-grow:1;">{{ $prod['text'] }}</p>
          <div class="dl-meta">@foreach ($prod['meta'] as $m)<span>{{ $m }}</span>@endforeach</div>
          <div class="btn-row">
            <a href="{{ $prod['file'] }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">{!! $dlIcon !!} Download {{ $prod['name'] }}</a>
            @if ($prod['details'])<a href="{{ url($prod['details']) }}" class="btn btn-outline btn-sm">Details &amp; screenshots</a>@endif
          </div>
          <div style="font-size:0.82rem;">
            @foreach ($prod['more'] as [$ml, $mu])<a href="{{ url($mu) }}" style="color:var(--coral-deep); font-weight:600; margin-right:14px;">{{ $ml }} →</a>@endforeach
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- Install steps --}}
<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>GETTING STARTED</span></div>
      <h2>From download to first sale.</h2>
    </div>
    <div class="steps-flow stagger">
      <div class="step-tile reveal-scale" style="--i:0"><div class="st-num">01</div><div><h4>Download</h4><p>Pick your edition above — files are hosted on Google Drive.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:1"><div class="st-num">02</div><div><h4>Install</h4><p>Set up myPOS on your Windows 7, 8 or 10 PC.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:2"><div class="st-num">03</div><div><h4>Upgrade when ready</h4><p>Need support, FBR / PRA integration or more modules? Talk to our team.</p></div></div>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/features') }}">Features</a>
      <a href="{{ url('/support') }}">Support Plans</a>
      <a href="{{ url('/frequently-asked-questions') }}">FAQ</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    </div>
  </div>
</section>

<x-cta-band title="Want the full version with support?" text="Book a free demo — our team will set up the right POS for your business, including FBR &amp; PRA integration, and train your staff." />
@endsection
