@extends('layouts.app')

@section('page', 'payment-accounts')
@section('title', 'Payment Accounts - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Payment Accounts" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'payment-accounts--intro',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'myPOS payment accounts with balances, transactions and payment history',
  'eyebrow' => 'PAYMENT ACCOUNTS',
  'title' => 'Clear Financial Visibility',
  'sub' => 'Know Where Your Money Stands',
  'paras' => [
    'myPOS gives you complete visibility over your payment accounts with real-time updates and accurate records. You can monitor balances, track transactions, and review payment history anytime.',
    'With detailed insights and organized data, you can make better financial decisions, reduce errors, and maintain full control over your business cash flow.',
  ],
])

@include('partials.plan-features.salient', [
  'current' => 'payment-accounts',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Tracking business cash flow across payment accounts in myPOS',
])

@include('partials.plan-features.plan-box', ['current' => 'payment-accounts', 'name' => 'Payment Accounts'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Payment Accounts free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
