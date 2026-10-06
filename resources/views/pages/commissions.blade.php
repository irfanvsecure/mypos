@extends('layouts.app')

@section('page', 'commissions')
@section('title', 'Commissions - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Commissions" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'commissions--intro',
  'img' => '/uploads/2026/04/Commission-Management.avif', 'w' => 626, 'h' => 354,
  'alt' => 'Calculating staff and agent commissions in myPOS',
  'eyebrow' => 'COMMISSIONS',
  'title' => 'Smart Commission Management',
  'sub' => 'Track Earnings with Accuracy',
  'paras' => [
    'Managing commissions manually can be confusing and time-consuming. With myPOS, you can easily calculate and track commissions for sales, staff, or agents with complete accuracy.',
    'Set custom commission rules, monitor performance, and ensure that every earning is recorded correctly. This helps you maintain transparency and build trust within your team.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'commissions--more',
  'img' => '/uploads/2026/04/Commission-Management2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'Commission reports and payout tracking in myPOS',
  'eyebrow' => 'COMMISSION REPORTS',
  'title' => 'Clear Insights & Easy Tracking',
  'sub' => 'Stay Updated. Stay in Control.',
  'paras' => [
    'myPOS gives you a clear overview of all commission-related data in one place. View detailed reports, track payouts, and analyze performance to make better business decisions.',
    'With automated calculations and organized records, you can reduce errors, save time, and manage commissions effortlessly while focusing on growing your business.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'commissions',
])

@include('partials.plan-features.plan-box', ['current' => 'commissions', 'name' => 'Commissions'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Commissions free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
