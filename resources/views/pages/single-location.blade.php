@extends('layouts.app')

@section('page', 'single-location')
@section('title', 'Single Location - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Single Location" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'single-location--intro',
  'img' => '/uploads/2023/12/Asset-1-jpg.webp', 'w' => 700, 'h' => 700,
  'alt' => 'Single Location',
  'eyebrow' => 'SINGLE LOCATION',
  'title' => 'Single Location Management',
  'sub' => 'All in one Point Of Sale Software',
  'paras' => [
    'Running a single business location efficiently requires reliable and streamlined technology. With modern advancements, businesses can now manage all their operations from one centralized system, ensuring smooth day-to-day performance without complexity.',
    'myPOS is designed to provide a powerful and easy-to-use solution for single-location businesses. It offers all the essential tools needed to handle sales, inventory, and customer management in one place—helping you focus more on growing your business and less on operational challenges.',
    'With its pre-configured modules, myPOS simplifies setup and usage, making it ideal for retail stores, restaurants, and service-based businesses operating from a single outlet. It also supports both online and offline modes, ensuring uninterrupted operations even during connectivity issues.',
    'Whether you\'re starting fresh or upgrading your current system, myPOS delivers efficiency, reliability, and control—everything you need to manage your business successfully from one location.',
  ],
  'tags' => ['Multi Company', 'Retail & Grocery', 'Stock Management'],
])

@include('partials.plan-features.salient', [
  'current' => 'single-location', 'bg' => true,
])

@include('partials.plan-features.plan-box', ['current' => 'single-location', 'name' => 'Single Location'])

<section id="single-location--multi-location" class="section-tight">
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

<x-cta-band title="Try Single Location free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
