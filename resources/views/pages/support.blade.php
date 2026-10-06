@extends('layouts.app')

@section('page', 'support')
@section('title', 'Support - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'It is not all about software... its about services and we tried our level best to provide a proper support to our customers. Whatsapp 0322-4765528')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
$check = '<svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>';
$plans = [
    ['On Call', '3,000', 'home_software_pricing_icon_4.png', 'ONE-TIME VISIT', false,
        ['For Paid Only (within year)', 'Single Location', 'One Time Only', 'Troubleshooting', 'Reinstallation']],
    ['Basic', '18,000', 'home_software_pricing_icon_1.png', '1 YEAR', false,
        ['For Paid/Free Users', 'Single Location', '1 Year Term', 'Troubleshooting', 'Reinstallation']],
    ['Standard', '24,000', 'home_software_pricing_icon_2.png', 'BEST VALUE', true,
        ['For Paid/Free Users', 'Single Location', '1 Year Term', 'Troubleshooting', 'Reinstallation', 'Free Updates', 'Mobile Reporting *']],
];
$features = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore', 'Bulk Upload Option',
    'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option', 'User Access Levels', 'Customizable Invoice',
    'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp

@section('content')
<x-page-header title="Support" eyebrow="CUSTOMER SUPPORT" crumb="Support"
  lead="It is not all about software... it’s about services, and we try our level best to provide proper support to our customers." :call="true" />

{{-- Support channels --}}
<section id="support--channels">
  <div class="wrap">
    <div class="split">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>TALK TO US</span></div>
        <h2>Give Us a Call to find out more about our Point of Sale Software.</h2>
        <p>Our support team is a phone call or WhatsApp message away — replies usually take under 2 minutes, in English, Urdu or Arabic.</p>
        <a href="tel:{{ config('site.phone_raw') }}" style="display:block; margin-top:26px; background:var(--navy); color:var(--text-on-dark); border-radius:14px; padding:26px 28px;">
          <div style="font-family:'Space Grotesk',sans-serif; font-size:clamp(1.5rem,3vw,2rem); font-weight:700; color:var(--coral-soft);">{{ config('site.phone') }}</div>
          <div style="margin-top:6px; font-weight:600;">Call us anytime</div>
        </a>
        <div class="btn-row" style="margin-top:22px;">
          <a href="{{ url('/contact') }}" class="btn btn-primary">Get In Touch</a>
          <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
        </div>
      </div>
      <div class="reveal-right">
        <div class="who-grid" style="margin-top:0;">
          <div class="who-row">{!! $check !!}<div><strong>Phone / WhatsApp</strong><br><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a> · <a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Chat on WhatsApp</a></div></div>
          <div class="who-row">{!! $check !!}<div><strong>Email</strong><br><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></div></div>
          <div class="who-row">{!! $check !!}<div><strong>Support hours</strong><br>{{ config('site.hours') }}</div></div>
          <div class="who-row">{!! $check !!}<div><strong>Support tickets</strong><br>Report an issue and track it with our team — <a href="{{ url('/tickets') }}" class="link-arrow" style="margin-top:0;">Open a ticket →</a></div></div>
          <div class="who-row">{!! $check !!}<div><strong>Self-help</strong><br>Quick answers on setup, FBR integration, pricing and backups — <a href="{{ url('/frequently-asked-questions') }}" class="link-arrow" style="margin-top:0;">Read the FAQ →</a></div></div>
          <div class="who-row">{!! $check !!}<div><strong>Remote assistance</strong><br>Our technical team can diagnose issues and guide your staff without visiting your premises.</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Support plans --}}
<section id="support--plans" class="bg-paper2">
  <div class="wrap">
    <div class="section-head center reveal" style="text-align:center;">
      <div class="eyebrow-line" style="justify-content:center;"><span class="bar"></span><span>SUPPORT PLANS</span></div>
      <h2>Choose the support that fits your business.</h2>
      <p>One-time on-call help or a full year of troubleshooting, reinstallation and free updates.</p>
    </div>
    <div class="pricing-grid stagger">
      @foreach ($plans as $i => [$name, $price, $icon, $badge, $featured, $items])
        <div class="price-card {{ $featured ? 'featured' : '' }} reveal-scale" style="--i:{{ $i }}">
          <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px;">
            <div class="pc-badge" style="margin:0;">{{ $badge }}</div>
            <img src="{{ asset('uploads/2015/07/' . $icon) }}" alt="{{ $name }} support plan" loading="lazy" style="width:44px; height:44px; object-fit:contain; background:#fff; border-radius:10px; padding:6px;">
          </div>
          <h3>{{ $name }}</h3>
          <div class="pc-price"><span style="font-size:0.9rem; font-weight:600; vertical-align:super; margin-right:4px;">PKR</span>{{ $price }}</div>
          <div class="pc-sub">{{ $name === 'On Call' ? 'Single visit / call' : 'Per year, per location' }}</div>
          <ul>
            @foreach ($items as $item)
              <li>{!! $check !!}<strong>{{ $item }}</strong></li>
            @endforeach
          </ul>
          <a href="{{ url('/contact') }}" class="btn {{ $featured ? 'btn-primary' : 'btn-outline' }}">Contact Now</a>
        </div>
      @endforeach
    </div>
    <p class="reveal" style="margin-top:28px; text-align:center; color:var(--text-mute-ink); font-size:0.9rem;">* On Clients Discretion</p>

    <div class="related-links reveal" style="justify-content:center;">
      <a href="{{ url('/support-policy') }}">Support Policy</a>
      <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
      <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
      <a href="{{ url('/security-policy') }}">Security Policy</a>
    </div>
  </div>
</section>

{{-- Mid-page CTA --}}
<section class="section-tight">
  <div class="wrap">
    <div class="free-band reveal" style="margin-top:0;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v9H8l-4 3V4z" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Facing an issue right now?</h3>
        <p style="color:var(--text-mute-ink);">Open a support ticket with the details and our team will get back to you — or WhatsApp us for the fastest response.</p>
      </div>
      <div class="btn-row">
        <a href="{{ url('/tickets') }}" class="btn btn-primary" style="white-space:nowrap;">Open a Ticket</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" style="white-space:nowrap;" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    </div>
  </div>
</section>

{{-- Features --}}
<section id="support--features" class="bg-paper2">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHAT YOU GET</span></div>
      <h2>Features</h2>
      <p>Every myPOS installation we support comes with the full feature set.</p>
    </div>
    <div class="core-grid stagger">
      @foreach ($features as $f)
        <a href="{{ url('/features') }}" class="core-item">{!! $check !!}{{ $f }}</a>
      @endforeach
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/frequently-asked-questions') }}">FAQ</a>
      <a href="{{ url('/tickets') }}">Support Tickets</a>
      <a href="{{ url('/downloads') }}">Downloads</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/contact') }}">Contact</a>
    </div>
  </div>
</section>

<x-cta-band title="Need help with your myPOS system?" text="Call, WhatsApp or send us an enquiry — our support team will help you troubleshoot, reinstall or update your POS." primary="Contact Support" primaryUrl="/contact#enquiry" />
@endsection
