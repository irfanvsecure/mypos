@extends('layouts.app')

@section('page', 'client')
@section('title', $client->meta_title ?: $client->name . ' — myPOS Client')
@section('description', $client->name . ' runs on myPOS — Pakistan\'s point of sale software for retail, restaurant, salon and service businesses, with FBR & PRA integration built in.')
@if ($client->logo)
@section('og_image', $client->logo)
@endif

@section('content')
<x-page-header :title="e($client->name)" :crumbs="[['Our Clients', '/clients']]" eyebrow="MYPOS CLIENT" />

<section>
  <div class="wrap split">
    <div class="media-frame contain reveal-left" style="max-width:420px;">
      @if ($client->logo)<img src="{{ asset(ltrim($client->logo, '/')) }}" alt="{{ $client->name }} logo">@endif
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>RUNS ON MYPOS</span></div>
      <h2>{{ $client->name }}</h2>
      <p>{{ $client->name }} is one of the 15,000+ businesses that run their sales, stock and reporting on myPOS point of sale software.</p>
      <p>Want the same setup for your business? Our team handles installation, data migration, FBR &amp; PRA integration and staff training.</p>
      <div class="btn-row mt-24">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ route('clients.index') }}" class="btn btn-outline">See all clients</a>
      </div>
    </div>
  </div>
</section>

@if ($others->isNotEmpty())
<section class="section-tight bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>MORE CLIENTS</span></div>
      <h2>Other businesses on myPOS.</h2>
    </div>
    <ul class="cs-grid">
      @foreach ($others as $o)
        <li><a href="{{ $o->url }}" class="cs-card">
          <span class="cs-logo">@if ($o->logo)<img src="{{ asset(ltrim($o->logo, '/')) }}" alt="{{ $o->name }} logo" loading="lazy">@endif</span>
          <span class="cs-name">{{ $o->name }}</span>
        </a></li>
      @endforeach
    </ul>
  </div>
</section>
@endif
@endsection
