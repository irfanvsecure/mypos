@extends('layouts.app')

@section('page', 'paperless-invoicing')
@section('title', 'Paperless Invoicing Integrated with WhatsApp')
@section('description', 'Embrace Paperless Invoicing integrated with WhatsApp. Streamline billing, send and track invoices instantly via chat. Save time, reduce costs, and go green effortlessly.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $benefits = [
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 16c0-7 4-11 12-12-1 8-5 12-12 12z" stroke="#fff" stroke-width="1.4"/><path d="M4 16l6-6" stroke="#fff" stroke-width="1.4"/></svg>', 'Environmental Sustainability', 'Reduce paper waste and contribute to a greener planet by transitioning to digital invoices.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7.5" stroke="#fff" stroke-width="1.4"/><path d="M12.5 7.2c-.5-.8-1.4-1.2-2.5-1.2-1.4 0-2.5.8-2.5 2s1.1 1.6 2.5 2 2.5.8 2.5 2-1.1 2-2.5 2c-1.1 0-2-.4-2.5-1.2M10 4.5V6M10 14v1.5" stroke="#fff" stroke-width="1.3"/></svg>', 'Cost Efficiency', 'Cut down on printing, postage, and storage costs associated with traditional paper invoices.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2l6 2.5v5c0 4-2.6 6.8-6 8.5-3.4-1.7-6-4.5-6-8.5v-5L10 2z" stroke="#fff" stroke-width="1.4"/><path d="M7 10l2 2 4-4" stroke="#fff" stroke-width="1.4"/></svg>', 'Enhanced Security', 'Safeguard sensitive financial information with secure digital transactions and encryption protocols.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M11 2L4 11h5l-1 7 7-9h-5l1-7z" stroke="#fff" stroke-width="1.4" stroke-linejoin="round"/></svg>', 'Improved Efficiency', 'Streamline your invoicing process with automated features, saving time and minimizing errors.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3.5 16.5l1-3.2A7 7 0 1110 17a7 7 0 01-3.3-.8l-3.2.3z" stroke="#fff" stroke-width="1.4" stroke-linejoin="round"/></svg>', 'Customer Convenience', 'Offer clients the ease of receiving and paying invoices directly through WhatsApp, enhancing their experience.'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="2" width="12" height="16" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M7 7l1.5 1.5L11 6M7 12h6M7 14.5h4" stroke="#fff" stroke-width="1.2"/></svg>', 'Regulatory Compliance', 'Ensure adherence to local and international invoicing regulations, minimizing compliance risks.'],
  ];
@endphp

@section('content')
<x-page-header title="Paperless Invoicing" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Send every invoice straight to your customer's WhatsApp — no printing, no paper, and a stronger bond with your customers." :call="true" />

<section id="paperless-invoicing--overview">
  <div class="wrap split">
    <div class="media-frame contain reveal-left">
      <img src="{{ asset('uploads/2023/12/Boost-Sales-Enhance-Transactions-removebg-preview.png') }}" alt="Paperless Invoicing — invoice sent to a customer's WhatsApp" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHATSAPP INVOICING</span></div>
      <h2>Send Invoice Directly On Customer's Whatsapp</h2>
      <p style="font-weight:600; color:var(--text-ink);">Make a stronger bond with your customers</p>
      <p>We empower businesses to transform from traditional paper invoices to streamlined e-invoicing solutions integrated with WhatsApp. Getting digital invoices not only supports sustainable business practices but also enhances operational efficiency.</p>
      <p>Our innovative system ensures every transaction is securely recorded and compliant with regulatory standards, simplifying your invoicing process while offering a seamless customer experience.</p>
      <p style="font-size:0.9rem;">Available in:</p>
      <div class="related-links" style="margin-top:10px;">
        <a href="{{ url('/download/mypos-retailpro') }}">Retail Pro</a>
        <a href="{{ url('/download/restropro') }}">Restaurant</a>
        <a href="{{ url('/pricing-laundrypro') }}">Laundry</a>
      </div>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <span class="num"><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="paperless-invoicing--benefits" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BENEFITS</span></div>
      <h2>Benefits Of Paperless Invoicing</h2>
      <p>Improving customer satisfaction and business operations</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($benefits as $i => [$icon, $title, $text])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon">{!! $icon !!}</div>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
    <div class="cta-inline">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Go Paperless Today</a>
      <a href="{{ url('/fbr-digital-invoicing') }}" class="link-arrow">FBR Digital Invoicing →</a>
    </div>
  </div>
</section>

<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num" data-count="15000">0</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num" data-count="12000">0</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num" data-decimal="4.9">0</div><div class="lbl">Average rating / 5</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">&lt;2min</div><div class="lbl">Avg. response time</div></div>
  </div>
</div>

<x-client-strip title="Our Clients" />

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
      <a href="{{ url('/customers') }}">Customers Management</a>
      <a href="{{ url('/mobile-mypos') }}">Mobile POS</a>
      <a href="{{ url('/woocommerce-pos') }}">WooCommerce Integration</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Send your first WhatsApp invoice." text="Book a free demo — see how myPOS sends invoices directly to your customers' WhatsApp." />
@endsection
