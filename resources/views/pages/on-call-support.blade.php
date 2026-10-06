@extends('layouts.app')

@section('page', 'on-call-support')
@section('title', 'On Call Support - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="On Call Support" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'on-call-support--intro',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'myPOS support team assisting a business owner over the phone',
  'eyebrow' => 'ON CALL SUPPORT',
  'title' => 'Dedicated On-Call Assistance',
  'sub' => 'Help Whenever You Need It',
  'paras' => [
    'With myPOS On Call Support, you’re never alone in managing your business operations. Our support team is always ready to assist you with quick solutions for any system-related issues, setup guidance, or general queries.',
    'Whether it’s a small question or an urgent problem, you can rely on fast and responsive help to keep your business running without interruptions.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'on-call-support--more',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Fast, reliable myPOS support keeping a business running',
  'eyebrow' => 'FAST RESPONSE',
  'title' => 'Fast Response, Reliable Support',
  'sub' => 'Stay Connected. Stay Stress-Free.',
  'paras' => [
    'We understand that every minute matters in business. That’s why myPOS provides timely support to ensure your issues are resolved as quickly as possible.',
    'Get expert guidance over the call, reduce downtime, and continue your work with confidence knowing help is just a call away.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'on-call-support',
])

@include('partials.plan-features.plan-box', ['current' => 'on-call-support', 'name' => 'On Call Support'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try On Call Support free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
