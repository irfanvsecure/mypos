@extends('layouts.app')

@section('page', 'post')
@section('title', $post->meta_title ?: $post->title)
@section('description', $post->meta_description ?: $post->excerpt)
@section('og_type', 'article')
@if ($post->featured_image)
@section('og_image', $post->featured_image)
@endif

@push('head')
<meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}" />
<meta property="article:modified_time" content="{{ $post->updated_at?->toIso8601String() }}" />
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $post->title,
    'description' => $post->meta_description ?: $post->excerpt,
    'image' => $post->featured_image ? rtrim(config('site.url'), '/') . $post->featured_image : null,
    'datePublished' => $post->published_at?->toIso8601String(),
    'dateModified' => $post->updated_at?->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => 'myPOS', 'url' => rtrim(config('site.url'), '/')],
    'publisher' => ['@id' => rtrim(config('site.url'), '/') . '/#organization'],
    'mainEntityOfPage' => rtrim(config('site.url'), '/') . '/' . $post->slug,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<x-page-header :title="e($post->title)" :crumbs="[['Blog', '/blogs']]" :crumb="\Illuminate\Support\Str::limit($post->title, 40)">
  <div class="article-meta reveal">
    <span>{{ $post->topic_label }}</span><span class="dot"></span>
    <span>{{ $post->published_at?->format('F j, Y') }}</span><span class="dot"></span>
    <span>{{ $post->reading_minutes }} min read</span>
  </div>
</x-page-header>

<section style="padding-top:60px;">
  <div class="wrap article-layout">
    <article>
      @if ($post->featured_image)
        <div class="article-hero-img"><img src="{{ asset(ltrim($post->featured_image, '/')) }}" alt="{{ $post->title }}"></div>
      @endif
      <div class="prose">{!! $content !!}</div>

      <div class="cta-band" style="margin-top:56px; text-align:left;">
        <h2 style="font-size:1.4rem;">Get your business on myPOS — free demo, FBR-ready.</h2>
        <p style="margin:0 0 22px;">Our team sets up the POS, FBR / PRA integration and staff training for you. Most businesses are live within 1–3 days.</p>
        <div class="btn-row">
          <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
          <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
        </div>
      </div>
    </article>

    <aside class="article-aside">
      @if (count($toc) > 1)
        <nav class="toc" aria-label="Table of contents">
          <h4>IN THIS ARTICLE</h4>
          @foreach ($toc as [$id, $label])<a href="#{{ $id }}">{{ $label }}</a>@endforeach
        </nav>
      @endif
      <div class="aside-cta">
        <h4>Talk to a POS expert</h4>
        <p>Free consultation on POS setup and FBR / PRA integration for your business.</p>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,0.35); color:var(--text-on-dark);">{{ config('site.phone') }}</a>
      </div>
    </aside>
  </div>
</section>

@if ($related->isNotEmpty())
<section class="section-tight bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>KEEP READING</span></div>
      <h2>Related articles.</h2>
    </div>
    <div class="post-grid">
      @foreach ($related as $r)
        <article class="post-card reveal-scale">
          <a href="{{ $r->url }}" class="pc-img">@if ($r->featured_image)<img src="{{ asset(ltrim($r->featured_image, '/')) }}" alt="{{ $r->title }}" loading="lazy">@endif</a>
          <div class="pc-body">
            <div class="pc-tag">{{ strtoupper($r->topic_label) }}</div>
            <h3><a href="{{ $r->url }}">{{ $r->title }}</a></h3>
            <p>{{ $r->excerpt }}</p>
            <div class="pc-foot"><span>{{ $r->reading_minutes }} min read</span><b>Read →</b></div>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection
