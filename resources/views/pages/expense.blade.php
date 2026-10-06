@extends('layouts.app')

@section('page', 'expense')
@section('title', 'Expense - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Expense" eyebrow="STANDARD PLAN FEATURE" :crumbs="[['Pricing', '/pricing']]"
  lead="Included in the myPOS Standard Plan — Rs. 2,000/month, free for 14 days." :call="true" />

@include('partials.plan-features.block', [
  'id' => 'expense--intro',
  'img' => '/uploads/2026/04/Smart-Expense-Management.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Recording and categorizing business expenses in myPOS',
  'eyebrow' => 'EXPENSE',
  'title' => 'Smart Expense Management',
  'sub' => 'Control Costs. Maximize Profits.',
  'paras' => [
    'Keeping track of business expenses is essential for maintaining profitability. With myPOS, you can easily record, monitor, and manage all your expenses without the hassle of manual tracking.',
    'From daily operational costs to supplier payments and utility bills, everything is organized in one place. Stay updated with real-time expense tracking and never lose sight of where your money is going.',
    'Designed for ease of use, myPOS allows you to add and categorize expenses in just a few clicks. Whether your business is small or growing, your financial data remains accurate and well-structured.',
  ],
])

@include('partials.plan-features.block', [
  'id' => 'expense--more',
  'img' => '/uploads/2026/04/Smart-Expense-Management2.avif', 'w' => 626, 'h' => 417,
  'alt' => 'Expense reports and spending trends in myPOS',
  'eyebrow' => 'FINANCIAL VISIBILITY',
  'title' => 'Better Financial Visibility',
  'sub' => 'Know Where Every Rupee Goes',
  'paras' => [
    'Understanding your spending patterns helps you make smarter financial decisions. myPOS provides detailed expense insights so you can analyze costs, reduce unnecessary spending, and improve overall efficiency.',
    'Generate clear expense reports, filter by categories, and track trends over time. This helps you identify areas where you can save money and increase profitability.',
    'With accurate data at your fingertips, you can plan budgets more effectively and keep your business finances under control.',
  ],
  'reverse' => true, 'bg' => true,
])

@include('partials.plan-features.salient', [
  'current' => 'expense',
])

@include('partials.plan-features.plan-box', ['current' => 'expense', 'name' => 'Expense'])

<x-client-strip :slugs="['vision-optik', 'the-florist-by-aimen-tahir', 'tea-at-terrace', 'strongman-medifur-systems', 'snt-foods', 'mitti-di-handi']" title="Our Clients" />

<x-cta-band title="Try Expense free for 14 days." text="Get the full myPOS Standard Plan for Rs. 2,000/month after your free trial — or book a free demo and our team will set it up for your business." />
@endsection
