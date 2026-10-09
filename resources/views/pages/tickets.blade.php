@extends('layouts.app')

@section('page', 'tickets')
@section('title', 'Tickets - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
$check = '<svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>';
$features = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option',
    'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice',
    'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Support Tickets" crumb="Tickets" eyebrow="CUSTOMER SUPPORT" :crumbs="[['Support', '/support']]"
  lead="Report an issue with your myPOS system and our support team will get back to you — usually within minutes on WhatsApp." :call="true" />

{{-- How it works --}}
<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>HOW IT WORKS</span></div>
      <h2>Raise a ticket in three steps.</h2>
    </div>
    <div class="steps-flow stagger">
      <div class="step-tile reveal-scale" style="--i:0"><div class="st-num">01</div><div><h4>Describe the issue</h4><p>Fill in the form below and choose “Customer Support” or “Technical Assistance”.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:1"><div class="st-num">02</div><div><h4>We get in touch</h4><p>Our team calls or messages you on WhatsApp to understand the problem.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:2"><div class="st-num">03</div><div><h4>Problem solved</h4><p>Troubleshooting via remote assistance, or on-site when needed.</p></div></div>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/support') }}">Support Plans</a>
      <a href="{{ url('/frequently-asked-questions') }}">FAQ</a>
      <a href="{{ url('/support-policy') }}">Support Policy</a>
      <a href="{{ url('/downloads') }}">Downloads</a>
    </div>
  </div>
</section>

<x-contact-section id="ticket" eyebrow="OPEN A TICKET" type="Customer Support"
  title="Tell us what is going wrong. We will get you unstuck."
  text="Call us anytime on {{ config('site.phone') }} — or submit a support ticket below and our team will get back to you.">
  <div style="margin-top:22px;">
    <a href="{{ url('/contact') }}" class="btn btn-primary">Get In Touch</a>
  </div>
</x-contact-section>

{{-- Features --}}
<section id="tickets--features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHAT YOU GET</span></div>
      <h2>Features</h2>
    </div>
    <div class="core-grid stagger">
      @foreach ($features as $f)
        <a href="{{ url('/features') }}" class="core-item">{!! $check !!}{{ $f }}</a>
      @endforeach
    </div>
  </div>
</section>

<x-cta-band title="Prefer to talk to someone?" text="Our support team is available on phone and WhatsApp — English, Urdu and Arabic." primary="Contact Support" />
@endsection
