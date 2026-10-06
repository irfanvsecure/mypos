@extends('layouts.app')

@section('page', 'purchase')
@section('title', 'Purchase - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Purchase" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'purchase--intro',
  'img' => '/uploads/2026/04/Smart-Purchase-Management.avif', 'w' => 626, 'h' => 432,
  'alt' => 'Creating purchase orders and invoices in myPOS',
  'eyebrow' => 'PURCHASE',
  'title' => 'Smart Purchase Management',
  'sub' => 'Buy Better. Manage Smarter.',
  'paras' => [
    'Managing purchases shouldn’t be stressful or disorganized. With the right system, you can track every order, control costs, and maintain a smooth supply chain for your business.',
    'myPOS provides a powerful purchase management system that helps you handle suppliers, purchase orders, and stock updates—all in one place. Easily create and manage purchase invoices, keep track of due payments, and ensure accurate record-keeping every time.',
    'With myPOS, you can reduce errors, save time, and ensure your business always runs smoothly with the right stock at the right time.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'purchase--more',
  'img' => '/uploads/2026/04/Smart-Purchase-Management2.avif', 'w' => 626, 'h' => 521,
  'alt' => 'Supplier balances and purchase history in myPOS',
  'eyebrow' => 'SUPPLIERS',
  'title' => 'Supplier Management Made Easy',
  'sub' => 'Build Stronger Vendor Relationships',
  'paras' => [
    'Managing multiple suppliers can quickly become overwhelming without the right tools. myPOS simplifies supplier management by keeping all your vendor details, transactions, and payment records in one organized system.',
    'Easily add and manage suppliers, track outstanding balances, and review complete purchase histories whenever you need. With better visibility into supplier performance and pricing, you can negotiate smarter deals and improve your profit margins.',
    'Stay on top of payments with clear due dates and reminders, ensuring you never miss an important transaction. With myPOS, building reliable supplier relationships becomes easier, helping your business grow with confidence.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'purchase',
])

@include('partials.plan-features.plan-box', ['current' => 'purchase', 'name' => 'Purchase'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Purchase free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
