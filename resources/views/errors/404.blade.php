@extends('layouts.app')

@section('title', 'Page not found — myPOS')
@section('robots', 'noindex, follow')

@section('content')
<section class="not-found">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow-line"><span class="bar"></span><span>ERROR 404</span></div>
      <h2>We couldn't find that page.</h2>
      <p>It may have moved when we rebuilt our website. Try one of these instead, or talk to our team.</p>
    </div>
    <div class="related-links">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ url('/features') }}">Features</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ route('blog.index') }}">Blog</a>
      <a href="{{ url('/contact') }}">Contact</a>
    </div>
    <div class="btn-row mt-40">
      <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
    </div>
  </div>
</section>
@endsection
