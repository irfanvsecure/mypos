@extends('layouts.app')

@section('page', 'sales')
@section('title', 'Sales - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Sales" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'sales--intro',
  'img' => '/uploads/2026/04/sales.jpg', 'w' => 1060, 'h' => 760,
  'alt' => 'Cashier completing a sale on the myPOS point of sale system',
  'eyebrow' => 'SALES',
  'title' => 'Simplify Your Business Operations',
  'sub' => 'One POS System Total Control',
  'paras' => [
    'Managing a single business location doesn’t have to be overwhelming. With the right system in place, you can handle everything smoothly and keep your operations running without stress.',
    'myPOS is designed to make your daily business tasks faster and easier. From handling sales to tracking inventory and managing customers, everything is available in one powerful platform—so you can work smarter, not harder.',
    'Built with simplicity in mind, myPOS comes with ready-to-use features that require minimal setup. It’s the perfect fit for retail shops, restaurants, and service businesses operating from a single location.',
    'No internet? No problem. myPOS supports both online and offline modes, ensuring your business stays active at all times.',
    'Whether you\'re starting out or upgrading your current system, myPOS helps you stay efficient, organized, and in full control of your business.',
  ],
  'tags' => ['Multi Company', 'Retail & Grocery', 'Stock Management'],
])

@include('partials.plan-features.salient', [
  'current' => 'sales', 'bg' => true,
])

@include('partials.plan-features.plan-box', ['current' => 'sales', 'name' => 'Sales'])

<section id="sales--multi-location" class="section-tight">
  <div class="wrap">
    <div class="free-band reveal" style="margin-top:0;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><rect x="2" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><rect x="11" y="7" width="7" height="7" stroke="#fff" stroke-width="1.4"/><path d="M5.5 7V4h9v3" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h2 style="font-size:1.35rem; margin-bottom:8px;">Multi Location Integration Software</h2>
        <p style="color:var(--text-mute-ink);">Growing beyond one outlet? With myPOS, you can manage multi companies and multi locations.</p>
      </div>
      <a href="{{ url('/multi-location-integration') }}" class="btn btn-primary" style="white-space:nowrap;">Explore Multi Location</a>
    </div>
  </div>
</section>

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Sales free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
