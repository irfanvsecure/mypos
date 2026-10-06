@extends('layouts.app')

@section('page', 'inventory')
@section('title', 'Inventory - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Inventory" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'inventory--intro',
  'img' => '/uploads/2026/04/Inventory.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Monitoring stock levels and product movement in myPOS inventory management',
  'eyebrow' => 'INVENTORY',
  'title' => 'Smart Inventory Management',
  'sub' => 'Stay Stocked. Stay in Control.',
  'paras' => [
    'Managing inventory doesn’t have to be complicated or time-consuming. With the right system, you can track every product, reduce losses, and make smarter business decisions.',
    'myPOS gives you a powerful inventory management system that keeps everything organized in real time. Easily monitor stock levels, track product movement, and avoid overstocking or running out of items.',
    'Designed for simplicity, myPOS lets you add, update, and manage your products with just a few clicks. Whether you have a small product list or a large catalog, everything stays accurate and up to date.',
    'Get instant alerts for low stock, generate reports, and maintain complete control over your inventory—all from one place.',
    'With myPOS, you can reduce errors, save time, and ensure your business always runs smoothly with the right stock at the right time.',
  ],
  'tags' => ['Multi Company', 'Retail & Grocery', 'Stock Management'],
])

@include('partials.plan-features.salient', [
  'current' => 'inventory', 'bg' => true,
])

@include('partials.plan-features.plan-box', ['current' => 'inventory', 'name' => 'Inventory'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Inventory free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
