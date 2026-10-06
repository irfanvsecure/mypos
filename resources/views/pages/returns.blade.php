@extends('layouts.app')

@section('page', 'returns')
@section('title', 'Returns - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Returns" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'returns--intro',
  'img' => '/uploads/2026/04/Easy-Return-Management.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Processing a customer return at the myPOS counter',
  'eyebrow' => 'RETURNS',
  'title' => 'Easy Return Management',
  'sub' => 'Handle Returns Without Hassle',
  'paras' => [
    'Managing product returns doesn’t have to be complicated. With myPOS, you can quickly process returns, update inventory, and maintain accurate records—all in one place.',
    'Whether it’s a customer return or a supplier return, the system ensures everything is handled smoothly, reducing confusion and saving valuable time.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'returns--more',
  'img' => '/uploads/2026/04/Easy-Return-Management2.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Return records and reports with automatic stock adjustment in myPOS',
  'eyebrow' => 'RETURN RECORDS',
  'title' => 'Accurate Records & Better Control',
  'sub' => 'Track Every Return with Confidence',
  'paras' => [
    'Keep a complete record of all return transactions with full details for better transparency. myPOS automatically adjusts stock levels and keeps your data up to date.',
    'Generate return reports, identify patterns, and minimize losses by understanding the reasons behind returns. With better insights, you can improve operations and customer satisfaction.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'returns',
])

@include('partials.plan-features.plan-box', ['current' => 'returns', 'name' => 'Returns'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Returns free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
