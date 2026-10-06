@extends('layouts.app')

@section('page', 'expiry')
@section('title', 'Expiry - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Expiry" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'expiry--intro',
  'img' => '/uploads/2026/04/Expiry-Management-software.avif', 'w' => 626, 'h' => 424,
  'alt' => 'Tracking product expiry dates with myPOS expiry management software',
  'eyebrow' => 'EXPIRY',
  'title' => 'Smart Expiry Management',
  'sub' => 'Reduce Losses. Stay Ahead.',
  'paras' => [
    'Managing product expiry dates is crucial for avoiding losses and maintaining product quality. With myPOS, you can easily track expiry dates and ensure that your stock is always fresh and up to standard.',
    'Stay informed with real-time updates on expiring and near-expiry products, so you can take timely action and prevent unnecessary waste.',
    'Manually tracking expiry dates can lead to costly mistakes. myPOS automatically monitors your inventory and sends alerts for products that are close to expiry.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'expiry--more',
  'img' => '/uploads/2026/04/Expiry-Management-software2.avif', 'w' => 626, 'h' => 411,
  'alt' => 'Batch-wise expiry records and expiry reports in myPOS',
  'eyebrow' => 'BATCH TRACKING',
  'title' => 'Organized & Accurate Tracking',
  'sub' => 'Manage Every Product with Confidence',
  'paras' => [
    'With myPOS, all your product details—including expiry dates—are stored in one centralized system. Easily add, update, and manage expiry information with just a few clicks.',
    'Track batch-wise products, maintain accurate records, and ensure compliance with quality standards across your business.',
    'Having full visibility over expiring products helps you make smarter business decisions. Generate expiry reports, identify slow-moving items, and optimize your stock management.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'expiry',
])

@include('partials.plan-features.plan-box', ['current' => 'expiry', 'name' => 'Expiry'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Expiry free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
