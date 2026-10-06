@extends('layouts.app')

@section('page', 'reports')
@section('title', 'Reports - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Reports" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'reports--intro',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'myPOS business reports dashboard showing sales, purchases and profits',
  'eyebrow' => 'REPORTS',
  'title' => 'Powerful Business Reports',
  'sub' => 'Turn Data into Smart Decisions',
  'paras' => [
    'myPOS provides detailed and easy-to-understand reports that give you a complete overview of your business performance. From sales and purchases to expenses and profits, everything is available in one place.',
    'With real-time data and clear insights, you can quickly analyze trends, monitor performance, and make informed decisions to grow your business.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'reports--more',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Business owner reviewing myPOS performance reports and key metrics',
  'eyebrow' => 'INSIGHTS',
  'title' => 'Complete Visibility & Insights',
  'sub' => 'Stay Informed. Stay Ahead.',
  'paras' => [
    'Access a wide range of reports anytime to understand how your business is performing. Filter data, track key metrics, and identify opportunities for improvement with just a few clicks.',
    'With accurate and organized reporting, myPOS helps you stay in control, reduce guesswork, and plan your business strategy with confidence.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'reports',
])

@include('partials.plan-features.plan-box', ['current' => 'reports', 'name' => 'Reports'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Reports free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
