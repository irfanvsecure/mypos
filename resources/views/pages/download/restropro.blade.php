@extends('layouts.app')

@section('page', 'download-restropro')
@section('title', 'Get Your Free Version - Download RestroPro Now')
@section('description', 'Elevate efficiency with RestroPro, the ultimate solution for business management. Download now for seamless operations and enhanced productivity.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
$p = [
    'key' => 'restropro', 'tags' => [['Restaurant POS', '/restaurant-management'], ['Free Download', '/downloads']], 'name' => 'RestroPro', 'button' => 'Download myPOS RestroPro',
    'lead' => 'Restaurant POS software covering recipes, kitchen printing (KOT), kitchen display, waiter app and full accounting — download the free version.',
    'file' => 'https://drive.google.com/file/d/1E8i1FrSGBWUXo11PZsDwbub2YyHRkIR2/view',
    'version' => '2.0', 'size' => '74.33 MB', 'downloads' => 17135, 'files' => 1, 'published' => 'May 19, 2019', 'updated' => 'April 11, 2026',
    'intro' => null,
    'images' => ['uploads/2022/10/6-4-1440x860.png', 'uploads/2022/10/5-1-1-1440x860.png', 'uploads/2022/10/4-1-1-1440x860.png', 'uploads/2022/10/2-3-1-1440x860.png'],
    'video' => null,
    'featuresTitle' => 'Covering all features of Restaurants',
    'features' => [
        ['Recipe Management', 'Kitchen Print (KOT)', 'Kitchen Display Screen', 'Multi Level Kitchens', 'Multi Cuisine', 'Waiter Order Taking App'],
        ['Category Management', 'Biller', 'Permissions', 'Employee Management', 'Attendance', 'Dynamic Bills'],
        ['Full Accounting', 'Profit / Loss', 'Expiry Management', 'Storage', 'Backup System', 'Dynamic Reports'],
    ],
    'pricing' => '/pricing-restropro',
    'related' => [['Restaurant Management', '/restaurant-management'], ['RestroPro Pricing', '/pricing-restropro'], ['PRA Restaurant Integration', '/pra-pos-restaurant-integration']],
];
@endphp

@php
$check = '<svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>';
$dlIcon = '<svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M10 3v10M5.5 8.5L10 13l4.5-4.5M4 16.5h12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$others = [
    'retailpro'  => ['RetailPro', 'Retail & supermarket POS — free version', '/downloads#retailpro'],
    'restropro'  => ['RestroPro', 'Restaurant POS — v2.0 · 74.33 MB', '/download/restropro'],
    'salonpro'   => ['SalonPro', 'Salon POS — v2.0 · 70.10 MB', '/download/salonpro'],
    'laundrypro' => ['LaundryPro', 'Laundry POS — v2.0 · 61.52 MB', '/download/laundrypro'],
    'tailorpro'  => ['TailorPro', 'Tailor shop POS — v2.0 · 80 MB', '/download/tailorpro'],
];
unset($others[$p['key']]);
@endphp

@section('content')
<x-page-header :title="$p['name']" eyebrow="FREE DOWNLOAD" :crumbs="[['Downloads', '/downloads']]"
  :lead="$p['lead']" :call="true">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ $p['file'] }}" class="btn btn-primary" target="_blank" rel="noopener">{!! $dlIcon !!} {{ $p['button'] }}</a>
    <span style="color:var(--text-mute-on-dark); font-size:0.9rem;">Version {{ $p['version'] }} · {{ $p['size'] }} · {{ number_format($p['downloads']) }} downloads</span>
  </div>
</x-page-header>

<section id="download">
  <div class="wrap split" style="align-items:start;">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>DESCRIPTION</span></div>
      @if (!empty($p['intro']))<p style="font-size:1.05rem; color:var(--text-ink);">{{ $p['intro'] }}</p>@endif
      @if (!empty($p['images']))
        <div class="media-frame" style="margin-top:18px;">
          <img src="{{ asset($p['images'][0]) }}" alt="{{ $p['name'] }} screenshot 1" width="1440" height="860">
        </div>
        <div style="display:grid; grid-template-columns:repeat({{ min(4, count($p['images']) - 1) }},1fr); gap:12px; margin-top:12px;">
          @foreach (array_slice($p['images'], 1) as $i => $img)
            <a href="{{ asset($img) }}" target="_blank" rel="noopener" class="media-frame" style="display:block;"><img src="{{ asset($img) }}" alt="{{ $p['name'] }} screenshot {{ $i + 2 }}" width="1440" height="860" loading="lazy"></a>
          @endforeach
        </div>
      @endif
      @if (!empty($p['video']))
        <div class="video-frame" style="margin-top:18px;">
          <iframe src="https://www.youtube.com/embed/{{ $p['video'] }}?rel=0" title="{{ $p['name'] }} video demo" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      @endif
    </div>

    <div class="download-card reveal-right" style="position:sticky; top:100px;">
      <div style="align-self:flex-start; font-size:0.68rem; font-weight:700; color:var(--coral-deep); background:rgba(139,58,31,0.1); padding:5px 12px; border-radius:999px;">FREE VERSION</div>
      <h2 style="font-size:1.5rem;">{{ $p['button'] }}</h2>
      <div class="dl-meta">
        <span>Version {{ $p['version'] }}</span><span>{{ $p['size'] }}</span><span>{{ $p['files'] }} File</span>
      </div>
      <table style="width:100%; font-size:0.9rem; border-collapse:collapse;">
        <tbody>
          @foreach ([['Version', $p['version']], ['File Size', $p['size']], ['Downloads', $p['downloads']], ['Files', $p['files']], ['Author', 'myPOS'], ['Published', $p['published']], ['Updated', $p['updated']]] as [$k, $v])
            <tr style="border-bottom:1px solid var(--paper-line);"><th scope="row" style="text-align:left; padding:10px 0; font-weight:600; color:var(--text-mute-ink);">{{ $k }}</th><td style="text-align:right; padding:10px 0; font-weight:600;">{{ $v }}</td></tr>
          @endforeach
        </tbody>
      </table>
      <a href="{{ $p['file'] }}" class="btn btn-primary" style="justify-content:center;" target="_blank" rel="noopener">{!! $dlIcon !!} {{ $p['button'] }}</a>
      <a href="{{ url($p['pricing']) }}" class="btn btn-outline" style="justify-content:center;">See {{ $p['name'] }} Pricing</a>
      <div>
        <div style="font-size:0.78rem; font-weight:700; color:var(--text-mute-ink); letter-spacing:0.03em; margin-bottom:8px;">Categories &amp; Tags</div>
        <div class="dl-meta">
          @foreach ($p['tags'] as [$tl, $tu])<a href="{{ url($tu) }}"><span>{{ $tl }}</span></a>@endforeach
        </div>
      </div>
      <p style="font-size:0.82rem; color:var(--text-mute-ink); margin:0;">Hosted on Google Drive · Need help installing? <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener" style="color:var(--coral-deep); font-weight:600;">WhatsApp us</a></p>
    </div>
  </div>
</section>

@if (!empty($p['features']))
<section id="features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>FEATURES</span></div>
      <h2>{{ $p['featuresTitle'] }}</h2>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($p['features'] as $i => $group)
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <ul class="check-list" style="margin-top:0;">
            @foreach ($group as $f)<li><strong>{{ $f }}</strong></li>@endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="section-tight">
  <div class="wrap">
    <div class="free-band reveal" style="margin-top:0;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Want the full {{ $p['name'] }} with support?</h3>
        <p style="color:var(--text-mute-ink);">Get a free demo, FBR / PRA integration and staff training from the myPOS team — trusted by 15,000+ customers.</p>
      </div>
      <div class="btn-row">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary" style="white-space:nowrap;">Get Free Demo</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" style="white-space:nowrap;" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    </div>

    <div class="section-head reveal" style="margin-top:72px;">
      <div class="eyebrow-line"><span class="bar"></span><span>MORE FROM MYPOS</span></div>
      <h2>Similar Downloads</h2>
    </div>
    <div class="integ-grid stagger" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); margin-top:36px;">
      @foreach (array_values($others) as $i => [$oName, $oSub, $oUrl])
        <a href="{{ url($oUrl) }}" class="integ-card reveal-scale" style="--i:{{ $i }}; display:block;">
          <div class="integ-icon" style="width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; color:#fff;">{!! $dlIcon !!}</div>
          <h3>{{ $oName }}</h3>
          <p>{{ $oSub }}</p>
          <span class="link-arrow" style="margin-top:0;">View download →</span>
        </a>
      @endforeach
    </div>

    <div class="related-links reveal">
      <a href="{{ url('/downloads') }}">All Downloads</a>
      @foreach ($p['related'] as [$rl, $ru])<a href="{{ url($ru) }}">{{ $rl }}</a>@endforeach
      <a href="{{ url('/support') }}">Support</a>
      <a href="{{ url('/frequently-asked-questions') }}">FAQ</a>
    </div>
  </div>
</section>

<x-cta-band />
@endsection
