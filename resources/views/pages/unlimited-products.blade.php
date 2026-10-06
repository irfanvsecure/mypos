@extends('layouts.app')

@section('page', 'unlimited-products')
@section('title', 'Unlimited Products - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Unlimited Products" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'unlimited-products--intro',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility2.avif', 'w' => 626, 'h' => 418,
  'alt' => 'Managing an unlimited product catalogue in myPOS',
  'eyebrow' => 'UNLIMITED PRODUCTS',
  'title' => 'Unlimited Product Management',
  'sub' => 'Add Without Limits',
  'paras' => [
    'With myPOS, you are never restricted by product limits. You can add, manage, and organize an unlimited number of products with complete ease, making it perfect for growing businesses and large inventories.',
    'Whether you have a small shop or a large retail setup, the system ensures every product is stored accurately and is easy to access whenever you need it.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'unlimited-products--more',
  'img' => '/uploads/2026/04/Clear-Financial-Visibility.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Scalable, organized product data in myPOS for growing businesses',
  'eyebrow' => 'SCALABLE',
  'title' => 'Scalable & Organized System',
  'sub' => 'Grow Your Business Freely',
  'paras' => [
    'As your business expands, managing more products becomes simple with myPOS. The system keeps everything structured, searchable, and well-organized so you can focus on growth instead of limitations.',
    'Enjoy smooth performance, fast access, and reliable data handling no matter how large your inventory becomes.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'unlimited-products',
])

@include('partials.plan-features.plan-box', ['current' => 'unlimited-products', 'name' => 'Unlimited Products'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Unlimited Products free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
