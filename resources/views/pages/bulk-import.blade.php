@extends('layouts.app')

@section('page', 'bulk-import')
@section('title', 'Bulk Import - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Bulk Import" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'bulk-import--intro',
  'img' => '/uploads/2026/04/Bulk-Import2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'Uploading a full product list to myPOS with Bulk Import',
  'eyebrow' => 'BULK IMPORT',
  'title' => 'Effortless Data Upload',
  'sub' => 'Bring Your Products in Instantly',
  'paras' => [
    'Adding products one by one can slow down your business. With myPOS Bulk Import, you can upload your entire product list in one go and get started immediately.',
    'Just prepare your file with product details and import everything within seconds—no repetitive work, no delays.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'bulk-import--more',
  'img' => '/uploads/2026/04/Bulk-Import.avif', 'w' => 626, 'h' => 365,
  'alt' => 'Reviewing a structured product import file before uploading to myPOS',
  'eyebrow' => 'CLEAN DATA',
  'title' => 'Reliable & Structured Imports',
  'sub' => 'Keep Your Data Clean and Organized',
  'paras' => [
    'Uploading large data sets doesn’t mean compromising on accuracy. myPOS ensures your imported data stays properly structured and easy to manage.',
    'You can review your file before uploading to avoid mistakes and maintain clean records.',
    'Need to update pricing, stock, or product details? Simply edit your file and re-upload it. Bulk Import makes large-scale updates fast and hassle-free.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'bulk-import',
])

@include('partials.plan-features.plan-box', ['current' => 'bulk-import', 'name' => 'Bulk Import'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Bulk Import free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
