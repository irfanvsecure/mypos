@extends('layouts.app')

@section('page', 'about-us')
@section('title', 'Your Trusted Partner in Modern Payment Solutions')
@section('description', 'Explore the journey behind myPOS and learn about our commitment to revolutionizing payment solutions.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="About Us" eyebrow="ABOUT MYPOS.PK"
  lead="A technology partner helping Pakistani businesses operate smarter and grow faster." :call="true" />

<section id="about-us--about-content">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>ABOUT MYPOS.PK</span></div>
      <h2>About Mypos.pk:</h2>
      <p>At mypos.pk, we are more than just a POS provider — we are a technology partner committed to helping Pakistani businesses operate smarter and grow faster. By combining reliable systems, local expertise and dedicated support, we ensure our customers can focus on what matters most: running and expanding their business with confidence.</p>
      <p>Whether you&rsquo;re a small shop or a multi-branch enterprise, our software is built to scale with your needs. We are driven by innovation, guided by customer trust and focused on delivering practical solutions that simplify operations and create long-term value for businesses across Pakistan.</p>
      <div class="btn-row" style="margin-top:26px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Talk To Expert</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      </div>
    </div>
    <div class="about-photo reveal-right">
      <div class="photo"><img src="{{ asset('uploads/2025/06/2109.i607.018.S.m012.c12.fintech-isometric-icons-scaled.jpg') }}" alt="myPOS fintech and point of sale technology illustration" loading="lazy"></div>
    </div>
  </div>
</section>

<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num" data-count="15000">0</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num" data-count="12000">0</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num" data-decimal="4.9">0</div><div class="lbl">Average rating / 5</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">24-hour</div><div class="lbl">Customer support</div></div>
  </div>
</div>

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>EXPLORE MYPOS</span></div>
      <h2>See what we build for your business.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">Features</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/retail-management') }}">Retail Management</a>
      <a href="{{ url('/restaurant-management') }}">Restaurant Management</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/clients') }}">Our Clients</a>
    </div>
  </div>
</section>

<x-contact-section title="Request a Quote" eyebrow="CONTACT US" />
@endsection
