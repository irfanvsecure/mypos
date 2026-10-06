@php
    $siteUrl     = rtrim(config('site.url'), '/');
    // Inline @section values arrive already HTML-escaped; decode once so {{ }} below escapes exactly once.
    $yield       = fn ($name) => trim(html_entity_decode($__env->yieldContent($name), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $metaTitle   = $yield('title') ?: 'myPOS — Free POS Software for Pakistan';
    $metaDesc    = $yield('description') ?: 'Free POS software for Pakistani businesses — FBR & PRA digital invoicing built in, works offline, syncs across every branch.';
    $metaKeys    = $yield('keywords');
    $canonical   = trim($__env->yieldContent('canonical')) ?: $siteUrl . (request()->path() === '/' ? '/' : '/' . request()->path());
    $ogImage     = trim($__env->yieldContent('og_image')) ?: '/images/logo.png';
    $ogImage     = str_starts_with($ogImage, 'http') ? $ogImage : $siteUrl . $ogImage;
    $robots      = trim($__env->yieldContent('robots')) ?: 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}" />
@if ($metaKeys)<meta name="keywords" content="{{ $metaKeys }}" />
@endif
<meta name="robots" content="{{ $robots }}" />
<link rel="canonical" href="{{ $canonical }}" />
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
<meta name="theme-color" content="#154A73" />

<meta property="og:type" content="@yield('og_type', 'website')" />
<meta property="og:site_name" content="myPOS" />
<meta property="og:title" content="{{ $metaTitle }}" />
<meta property="og:description" content="{{ $metaDesc }}" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:locale" content="en_US" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $metaTitle }}" />
<meta name="twitter:description" content="{{ $metaDesc }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
<script type="application/ld+json">{!! json_encode([
    '@@context' => 'https://schema.org',
    '@type' => ['LocalBusiness', 'Organization'],
    '@id' => $siteUrl . '/#organization',
    'name' => 'myPOS.pk',
    'url' => $siteUrl,
    'logo' => $siteUrl . '/images/logo.png',
    'telephone' => config('site.phone_raw'),
    'email' => config('site.email'),
    'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Office No. 1, Midlane Plaza, Ghazni Lane, New Super Town', 'addressLocality' => 'Lahore', 'addressRegion' => 'Punjab', 'addressCountry' => 'PK'],
    'openingHours' => ['Mo-Fr 10:00-18:00'],
    'areaServed' => 'PK',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@stack('head')
</head>
<body>
@include('partials.nav')
<main id="app">
<div class="pg" data-page="@yield('page')">
@yield('content')
</div>
</main>
@include('partials.footer')

<a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ rawurlencode('Hi myPOS, I would like to know more about your POS software.') }}" class="wa-float" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
  <span class="wa-tip">Chat on WhatsApp</span>
  <svg width="30" height="30" viewBox="0 0 32 32" fill="#fff" aria-hidden="true"><path d="M16 3C9 3 3.3 8.6 3.3 15.6c0 2.2.6 4.4 1.7 6.3L3.2 28.8l7.1-1.8c1.8 1 3.8 1.5 5.8 1.5 7 0 12.7-5.6 12.7-12.6S23 3 16 3zm0 23.1c-1.9 0-3.7-.5-5.3-1.4l-.4-.2-4.2 1.1 1.1-4.1-.3-.4c-1-1.6-1.6-3.5-1.6-5.4C5.3 9.9 10.1 5.2 16 5.2s10.7 4.7 10.7 10.6S21.9 26.1 16 26.1zm5.9-7.9c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-1.9-1.8-2.3-.2-.3 0-.5.1-.7l.5-.6c.2-.2.2-.3.3-.6.1-.2 0-.4 0-.6-.1-.2-.7-1.7-1-2.3-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.7s1.2 3.1 1.4 3.3c.2.2 2.3 3.5 5.6 4.9.8.3 1.4.5 1.9.7.8.2 1.5.2 2.1.1.6-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.3-.7-.4z"/></svg>
</a>
<div class="sticky-cta" role="navigation" aria-label="Quick contact">
  <a href="tel:{{ config('site.phone_raw') }}" class="sc-call">
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="currentColor" stroke-width="1.3"/></svg>Call</a>
  <a href="https://wa.me/{{ config('site.whatsapp') }}" class="sc-wa" target="_blank" rel="noopener">WhatsApp</a>
  <a href="{{ url('/contact') }}#enquiry" class="sc-demo">Free Demo</a>
</div>

<script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
@stack('scripts')
</body>
</html>
