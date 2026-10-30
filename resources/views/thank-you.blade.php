@extends('layouts.app')

@section('title', 'Thank You — myPOS')
@section('robots', 'noindex, nofollow')

@section('content')
<section class="thank-you">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow-line"><span class="bar"></span><span>ENQUIRY RECEIVED</span></div>
      <h2>Thank you! We'll be in touch shortly.</h2>
      <p>Our team will call you back during business hours (Mon–Fri, 10am–6pm). For a faster reply, message us on WhatsApp at {{ config('site.phone') }}.</p>
    </div>
    <div class="btn-row mt-40">
      <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
    </div>
    <div class="related-links">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ url('/features') }}">Features</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ route('clients.index') }}">Our Clients</a>
      <a href="{{ route('blog.index') }}">Blog</a>
    </div>
  </div>
</section>
@endsection

@if (session('lead'))
@push('scripts')
<script>if (window.fbq) fbq('track', 'Lead');</script>
@endpush
@endif
