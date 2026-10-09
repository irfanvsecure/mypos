@extends('layouts.app')

@section('page', 'contact')
@section('title', 'CONTACT AND SUPPORT - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'mypos is a multilocation desktop based pos + accounting software works in online/offline mode. Free version available. whatsapp / call @ +92 322 476 5528')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Contact and Support" crumb="Contact" eyebrow="CONTACT US"
  lead="Talk to the myPOS team about sales, support or FBR / PRA integration — call, WhatsApp or send an enquiry." :call="true" />

<section id="contact--contact-details">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>CONTACT US</span></div>
      <h2>Get in touch with our team.</h2>
      <p>For the quickest answer, call or WhatsApp us — or send an enquiry and our team will get back to you with the right solution, pricing and support details.</p>

      <div class="office-card">
        <div style="display:flex; align-items:center; gap:14px; margin-bottom:14px;">
          <img src="{{ asset('uploads/2018/05/My-Pos-Logo.png') }}" alt="myPOS contact and support" loading="lazy" style="width:44px; height:auto; object-fit:contain;">
          <h4 style="margin:0;">myPOS</h4>
        </div>
        <div style="font-size:0.78rem; font-weight:700; letter-spacing:0.04em; color:var(--coral-deep); margin-bottom:4px;">Contact details:</div>
        <div class="office-row"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 14s5-4.2 5-8a5 5 0 10-10 0c0 3.8 5 8 5 8z" stroke="currentColor" stroke-width="1.3"/><circle cx="8" cy="6" r="1.7" stroke="currentColor" stroke-width="1.2"/></svg>Office No. 1, Midlane Plaza, Ghazni Lane, New Super Town, Lahore, Pakistan</div>
        <div class="office-row"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="currentColor" stroke-width="1.2"/></svg><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit;">+92 322 4765528</a></div>
        <div class="office-row"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 3l6 4.5L14 3M2 3h12v10H2V3z" stroke="currentColor" stroke-width="1.3"/></svg><a href="mailto:{{ config('site.email') }}" style="color:inherit;">info@mypos.pk</a></div>
      </div>
    </div>

    <div class="support-card reveal-right">
      <h3>Support Hours</h3>
      <div class="hours">Mon-Fri (10:00 am - 18:00 pm) - Pakistan Standard Time</div>
      <div class="note">Email usually takes 12–24 hours. For a faster answer, call or WhatsApp — we typically reply in minutes.</div>

      <div class="support-detail-row">
        <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 3l6 4.5L14 3M2 3h12v10H2V3z" stroke="#fff" stroke-width="1.3"/></svg></div>
        <div><a href="mailto:{{ config('site.email') }}" class="val" style="color:var(--text-on-dark);">info@mypos.pk</a></div>
      </div>
      <div class="support-detail-row">
        <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
        <div><a href="tel:{{ config('site.phone_raw') }}" class="val" style="color:var(--text-on-dark);">+92 322 476 5528</a></div>
      </div>
      <a href="{{ wa_link() }}" target="_blank" rel="noopener" class="wa-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 13l1.2-3.6A7 7 0 1110 13c-1.2 0-2.3-.3-3.3-.8L3 13z" stroke="currentColor" stroke-width="1.4"/></svg>
        Whatsapp Us
      </a>
    </div>
  </div>
</section>

<section id="contact--contact" class="contact">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">GET A QUOTE</span></div>
      <h2>Request a Quote</h2>
      <p>Tell us about your business and requirements — our team will get back to you with the right solution, pricing and support details.</p>
    </div>
    <div class="contact-grid">
      <div class="reveal-left">
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M5 9.2L7.7 12L13 6" stroke="#fff" stroke-width="1.6"/></svg></div>
          <div><div class="lbl">Free demo</div><div class="val">See myPOS on your own products before you commit.</div></div>
        </div>
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M5 9.2L7.7 12L13 6" stroke="#fff" stroke-width="1.6"/></svg></div>
          <div><div class="lbl">FBR / PRA / KPRA / SRB</div><div class="val">Integration handled by our certified team.</div></div>
        </div>
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M5 9.2L7.7 12L13 6" stroke="#fff" stroke-width="1.6"/></svg></div>
          <div><div class="lbl">Trusted</div><div class="val">15,000+ customers · 4.9/5 average rating</div></div>
        </div>
        <div class="btn-row" style="margin-top:26px;">
          <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
          <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call Now</a>
        </div>
      </div>
      <div class="reveal-right">
        <x-enquiry-form title="Request a Quote" />
      </div>
    </div>
  </div>
</section>

<section class="section-tight">
  <div class="wrap">
    <div class="free-band reveal" style="margin-top:0;">
      <div class="fb-icon"><svg width="26" height="26" viewBox="0 0 20 20" fill="none"><path d="M10 2v16M4 6l6-4 6 4M4 14l6 4 6-4" stroke="#fff" stroke-width="1.4"/></svg></div>
      <div>
        <h3>Try out free version</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:8px;">Our free version covers all basic sales functions.</p>
        <ul>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Support is not Included</li>
          <li><svg width="15" height="15" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>Fully compatible with Windows 7,8,10</li>
        </ul>
      </div>
      <a href="{{ config('site.free_download') }}" class="btn btn-primary" style="white-space:nowrap;" target="_blank" rel="noopener">Download Now</a>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/features') }}">Features</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/pra-integration') }}">PRA Integration</a>
      <a href="{{ url('/frequently-asked-questions') }}">FAQs</a>
    </div>
  </div>
</section>
@endsection
