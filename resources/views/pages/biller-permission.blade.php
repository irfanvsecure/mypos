@extends('layouts.app')

@section('page', 'biller-permission')
@section('title', 'Biller Permission - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Biller Permission" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'biller-permission--intro',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'Assigning biller roles and permissions in myPOS',
  'eyebrow' => 'BILLER PERMISSION',
  'title' => 'Controlled Access for Billers',
  'sub' => 'Assign Roles with Confidence',
  'paras' => [
    'With myPOS Biller Permission, you can easily manage who can access billing features in your system. Assign specific rights to users so they can handle invoices, sales, and transactions based on their role.',
    'This helps you maintain control over your business operations while ensuring that only authorized users can perform billing activities.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'biller-permission--more',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Secure, transparent billing operations with user permission levels in myPOS',
  'eyebrow' => 'SECURITY',
  'title' => 'Secure & Transparent Operations',
  'sub' => 'Protect Your Business Data',
  'paras' => [
    'myPOS ensures complete security by allowing you to define clear permission levels for each biller. You can track user activity, reduce unauthorized actions, and maintain full transparency in your system.',
    'With better control and accountability, your business stays secure, organized, and efficiently managed.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'biller-permission',
])

@include('partials.plan-features.plan-box', ['current' => 'biller-permission', 'name' => 'Biller Permission'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Biller Permission free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
