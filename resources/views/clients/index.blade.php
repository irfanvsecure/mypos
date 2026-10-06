@extends('layouts.app')

@section('page', 'clients')
@section('title', 'Our Clients — Businesses Running on myPOS | Pakistan')
@section('description', 'Restaurants, salons, retailers, clinics and distributors across Pakistan and the Gulf trust myPOS point of sale software. See who runs on myPOS.')

@section('content')
<x-page-header title="Our Clients" eyebrow="TRUSTED BY 15,000+ BUSINESSES"
  lead="Restaurants, salons, retail stores, clinics, schools and distributors run their day on myPOS. Here are some of the businesses we work with." />

<section>
  <div class="wrap">
    <div class="client-grid">
      @foreach ($clients as $c)
        <a href="{{ $c->url }}" class="client-card reveal-scale">
          <div class="cl-logo">@if ($c->logo)<img src="{{ asset(ltrim($c->logo, '/')) }}" alt="{{ $c->name }} logo" loading="lazy">@endif</div>
          <span>{{ $c->name }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

<x-cta-band title="Join {{ number_format(15000) }}+ businesses on myPOS." text="Get a free demo and see how myPOS fits your business — with FBR &amp; PRA integration, offline sales and multi-branch reporting built in." />
@endsection
