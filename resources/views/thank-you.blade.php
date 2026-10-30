@extends('layouts.app')

@section('title', 'Thank You — myPOS')
@section('robots', 'noindex, nofollow')

@php
    $reviews = collect(config('site.reviews'))->filter(fn ($r) => mb_strlen($r[1]) > 90)->take(3);
    $initials = fn ($n) => strtoupper(collect(preg_split('/\s+/', trim($n)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp

@section('content')
<section class="ty-hero">
  <div class="wrap">
    <div class="ty-main">
      <div class="ty-check" aria-hidden="true">
        <svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="24"/><path d="M15 27l7 7 15-16"/></svg>
      </div>
      <span class="ty-chip"><i></i>Enquiry received · our team is online</span>
      <h1>Thank you! We'll be in <em>touch shortly.</em></h1>
      <p class="ty-lead">Your request is with our sales team. We call back during business hours (Mon–Fri, 10am–6pm). Need an answer right now? WhatsApp us — we usually reply in under 2 minutes.</p>
      <div class="btn-row ty-actions">
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.4-.5c.2-.2.2-.3.3-.5.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 00-8.6 15.1L2 22l5-1.3A10 10 0 1012 2z"/></svg>
          WhatsApp Us
        </a>
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
      </div>
    </div>

    <div class="ty-next" aria-labelledby="ty-next-title">
      <h2 id="ty-next-title">What happens next</h2>
      <ol>
        <li class="done"><span>✓</span><b>Enquiry received</b><small>Your details reached our sales team.</small></li>
        <li class="active"><span>2</span><b>We call you back</b><small>A product expert learns about your business.</small></li>
        <li><span>3</span><b>Free live demo</b><small>See myPOS on your own products.</small></li>
        <li><span>4</span><b>Setup &amp; go live</b><small>Install, FBR / PRA and training in 1–3 days.</small></li>
      </ol>
    </div>
  </div>
</section>

<section class="ty-explore">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow-line"><span class="bar"></span><span>WHILE YOU WAIT</span></div>
      <h2>Get to know myPOS</h2>
    </div>
    <div class="ty-cards">
      <a href="{{ url('/features') }}" class="ty-card"><b>Features</b><small>Billing, inventory, reports and more.</small><i>→</i></a>
      <a href="{{ url('/pricing') }}" class="ty-card"><b>Pricing</b><small>Simple plans with one-time options.</small><i>→</i></a>
      <a href="{{ route('clients.index') }}" class="ty-card"><b>Our Clients</b><small>Businesses already running on myPOS.</small><i>→</i></a>
      <a href="{{ route('blog.index') }}" class="ty-card"><b>Blog</b><small>FBR updates, guides and tips.</small><i>→</i></a>
    </div>

    @if ($reviews->isNotEmpty())
      <div class="sp-reviews ty-reviews">
        @foreach ($reviews as [$name, $text])
          <figure class="sp-review">
            <div class="sp-stars" aria-label="5 out of 5 stars">★★★★★</div>
            <blockquote>{{ \Illuminate\Support\Str::limit($text, 190) }}</blockquote>
            <figcaption><span class="rv-avatar">{{ $initials($name) }}</span><span><b>{{ $name }}</b><small>Google review</small></span></figcaption>
          </figure>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
