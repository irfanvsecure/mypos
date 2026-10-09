@extends('layouts.app')

@section('page', 'car-wash-pos')
@section('title', 'Car Wash POS with FBR & PRA Integration in Pakistan - MyPOS')
@section('description', 'Compliant car wash POS software with real-time FBR & PRA integration. Reduce audit risk, automate tax reporting. Get a free demo from myPOS.pk today.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@push('head')
<script type="application/ld+json">{!! json_encode(['@@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
  ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => rtrim(config('site.url'), '/') . '/'],
  ['@type' => 'ListItem', 'position' => 2, 'name' => 'FBR POS Integration', 'item' => rtrim(config('site.url'), '/') . '/fbr-pos-integration'],
  ['@type' => 'ListItem', 'position' => 3, 'name' => 'Car Wash POS'],
]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<header class="ind-hero">
  <div class="wrap">
    <nav class="crumb reveal" aria-label="Breadcrumb"><ol><li><a href="{{ url('/') }}">Home</a></li><li><a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a></li><li><span aria-current="page">Car Wash POS</span></li></ol></nav>
    <div class="eyebrow-line reveal"><span class="bar"></span><span style="color:var(--coral-soft);">FBR &amp; PRA Compliant Car Wash POS</span></div>
    <h1 class="reveal">Car Wash POS Software with FBR &amp; PRA Integration in Pakistan</h1>
    <p class="lead reveal">Every service transaction reported to FBR and PRA automatically &mdash; no manual filing, no separate systems, fully audit-ready.</p>
    <div class="ind-actions reveal">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call</a>
    </div>
    <x-cta-proof />
    <div class="hero-photo-wrap reveal-scale">
      <div class="float-chip" style="bottom:16px; left:20px;"><div class="cdot"></div><div><div class="cv">Car Wash POS &mdash; Dashboard</div></div></div>
      <div class="float-chip fchip-1"><div class="cdot"></div><div><div class="ct">Premium Exterior Wash</div><div class="cv">FBR Filed</div></div></div>
      <div class="float-chip fchip-3"><div class="cdot"></div><div><div class="ct">Interior Detailing</div><div class="cv">FBR Filed</div></div></div>
      <div class="float-chip fchip-2"><div class="cdot"></div><div><div class="ct">Wax &amp; Polish Add-on</div><div class="cv">PRA Filed</div></div></div>
      <img src="https://images.pexels.com/photos/29504462/pexels-photo-29504462.jpeg" alt="Professional car wash facility with team washing a vehicle">
    </div>
    <div class="stats-row reveal" style="margin-top:44px; grid-template-columns:repeat(4,1fr);">
      <div class="stat"><div class="num">15,000+</div><div class="lbl">Customers Across Pakistan</div></div>
      <div class="stat"><div class="num">12,000+</div><div class="lbl">Active Users</div></div>
      <div class="stat"><div class="num">4.9/5</div><div class="lbl">Average Rating</div></div>
      <div class="stat"><div class="num">&lt;2 min</div><div class="lbl">Avg. Response Time</div></div>
    </div>
    <div class="enforce-banner reveal">2026 FBR ENFORCEMENT IS ACTIVE FOR CAR WASH &amp; SERVICE STATIONS ACROSS PUNJAB</div>
  </div>
</header>

<section id="car-wash-pos--fbr-integration">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>FEDERAL COMPLIANCE</span></div>
      <h2>Car Wash FBR POS Integration Service in Pakistan.</h2>
      <p>Our car wash FBR POS integration service helps registered car wash businesses, service stations, and auto care centers comply with Pakistan&rsquo;s mandatory digital documentation and tax reporting requirements. We provide a secure and scalable POS solution that ensures every service transaction is recorded and reported to Federal Board Of Revenue in real time.</p>
      <p>With stricter enforcement in 2026, FBR POS integration is essential for businesses offering taxable services, bundled packages, or add-on vehicle care solutions.</p>
    </div>
    <div class="compliance-visual reveal-scale" style="margin-top:20px;">
      <div class="compliance-mock" style="max-width:420px;">
        <div class="compliance-mock-head"><span class="cm-dot"></span> FBR REAL-TIME FEED &mdash; LIVE</div>
        <div class="live-row"><span class="lv-lbl">Invoice #4471</span><span class="lv-val">Verified</span></div>
        <div class="live-row"><span class="lv-lbl">Tax Filed</span><span class="lv-val">PKR 465</span></div>
        <div class="live-row"><span class="lv-lbl">Reporting Authority</span><span class="lv-val">FBR</span></div>
        <div class="live-row"><span class="lv-lbl">Federal Board of Revenue</span></div>
      </div>
    </div>
  </div>
</section>

<section id="car-wash-pos--pra-integration" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>PROVINCIAL COMPLIANCE</span></div>
      <h2>PRA Integration Service for Car Wash &amp; Service Stations.</h2>
      <p>For businesses operating in Punjab, PRA integration service for car wash and service stations is mandatory to report provincial sales tax accurately. The Punjab Revenue Authority closely monitors service-based businesses, including car care and vehicle maintenance providers.</p>
      <p>Our unified system combines car wash Punjab Revenue Authority integration with federal reporting, removing the need for separate software. We also support PRA integration service for car service stations, ensuring full provincial compliance under one platform.</p>
    </div>
    <div class="compliance-visual reveal-scale" style="margin-top:20px;">
      <div class="compliance-mock" style="max-width:420px;">
        <div class="compliance-mock-head"><span class="cm-dot"></span> PRA &mdash; PUNJAB DASHBOARD &mdash; LIVE</div>
        <div class="live-row"><span class="lv-lbl">Provincial Sales Tax</span><span class="lv-val">Filed</span></div>
        <div class="live-row"><span class="lv-lbl">Service Station Coverage</span><span class="lv-val">Active</span></div>
        <div class="live-row"><span class="lv-lbl">Reporting Authority</span><span class="lv-val">PRA</span></div>
        <div class="live-row"><span class="lv-lbl">Punjab Province</span></div>
      </div>
    </div>
  </div>
</section>

<x-mid-cta />

<section id="car-wash-pos--compare">
  <div class="wrap">
    <div class="section-head reveal" style="text-align:center;">
      <h2>Ready to run a fully compliant car wash POS across FBR &amp; PRA reporting?</h2>
    </div>
    <div class="compare-table-wrap reveal">
      <table class="compare-table">
        <thead><tr><th>Feature</th><th>FBR POS Integration</th><th>PRA Integration (Punjab)</th></tr></thead>
        <tbody>
          <tr><td>Real-time reporting</td><td>Real-time invoice submission to FBR</td><td>Punjab Revenue Authority reporting built-in</td></tr>
          <tr><td>Service coverage</td><td>Covers taxable service &amp; bundled packages</td><td>Covers service stations &amp; fuel-linked car care</td></tr>
          <tr><td>Documentation</td><td>Audit-ready digital documentation</td><td>One dashboard for FBR + PRA together</td></tr>
        </tbody>
      </table>
    </div>
    <div style="text-align:center; margin-top:28px;">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ wa_link() }}" class="btn btn-outline" style="margin-left:14px;" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>

<section id="car-wash-pos--service-billing" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT FOR SERVICE-BASED BILLING</span></div>
      <h2>Car Care Shops FBR &amp; PRA Integration POS Software.</h2>
      <p>Our car care shops PRA integration POS software is designed specifically for service-based auto businesses rather than retail-only environments. It supports service-wise billing, package pricing, staff-level tracking, and automated tax calculations.</p>
    </div>
    <div class="who-grid">
      <div class="who-row"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><span>Service-category income tracking</span></div>
      <div class="who-row"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><span>Automated FBR &amp; PRA invoice submission</span></div>
      <div class="who-row"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><span>Daily, weekly &amp; monthly reports</span></div>
      <div class="who-row"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><span>Audit-ready documentation</span></div>
      <div class="who-row"><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg><span>Secure data handling &amp; backups</span></div>
    </div>
  </div>
</section>

<section id="car-wash-pos--why-needed">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>THE COMPLIANCE CASE</span></div>
      <h2>Why car wash businesses need FBR POS Integration?</h2>
      <p>Car wash and auto service businesses fall under taxable service categories and must maintain transparent income reporting. Manual billing, cash-only records, or undocumented services increase audit risk and penalties.</p>
    </div>
    <div class="icon-row-grid stagger">
      <div class="icon-row-card reveal-scale" style="--i:0"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v13l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></div><span>Basic and premium car wash services</span></div>
      <div class="icon-row-card reveal-scale" style="--i:1"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7.5" stroke="#fff" stroke-width="1.4"/><path d="M10 5.5v9M5.5 10h9" stroke="#fff" stroke-width="1.2"/></svg></div><span>Detailing, polishing, waxing, interior cleaning</span></div>
      <div class="icon-row-card reveal-scale" style="--i:2"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="5" width="12" height="10" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M4 8.5h12" stroke="#fff" stroke-width="1.2"/></svg></div><span>Add-on services and service packages</span></div>
      <div class="icon-row-card reveal-scale" style="--i:3"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M6 3h8v14H6z" stroke="#fff" stroke-width="1.4"/><path d="M8.5 7h3M8.5 10h3" stroke="#fff" stroke-width="1.2"/></svg></div><span>Real-time invoice generation and FBR reporting</span></div>
      <div class="icon-row-card reveal-scale" style="--i:4"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 15V9M9 15V5M14 15v-7" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg></div><span>Daily and monthly income summaries</span></div>
    </div>
    <p style="margin-top:28px; max-width:760px;">Car wash operators in Lahore, Multan, Gujranwala, and across Punjab are rapidly adopting compliant Point Of Sale systems to stay protected. Protect your business with a compliant car wash POS from day one.</p>
    <div style="margin-top:20px;">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Request PRA Integration</a>
      <a href="{{ wa_link() }}" class="btn btn-outline" style="margin-left:14px;" target="_blank" rel="noopener">WhatsApp</a>
    </div>
  </div>
</section>

<section id="car-wash-pos--how-it-works" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>HOW IT WORKS</span></div>
      <h2>How our Car Wash PRA &amp; FBR POS Integration works?</h2>
      <p>We begin with a detailed assessment of your car wash or service station operations, services, and compliance scope. Then we deploy suitable <a href="{{ url('/fbr-pos-integration') }}" class="link-arrow" style="display:inline;">FBR POS integration</a> for service stations, configure reporting aligned with Federal Board Of Revenue and Punjab Revenue Authority rules, and provide ongoing support for updates, documentation, and compliance guidance.</p>
    </div>
    <div class="steps-flow stagger">
      <div class="step-tile reveal-scale" style="--i:0"><div class="st-num">01</div><div><h4>Assess</h4><p>Review services, package pricing, and current compliance scope.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:1"><div class="st-num">02</div><div><h4>Deploy</h4><p>POS goes live, configured for FBR and PRA reporting from day one.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:2"><div class="st-num">03</div><div><h4>Configure</h4><p>Reporting rules aligned to Federal and Punjab Revenue Authority requirements.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:3"><div class="st-num">04</div><div><h4>Support</h4><p>Ongoing updates, documentation, and compliance guidance.</p></div></div>
    </div>
  </div>
</section>

<section id="car-wash-pos--coverage">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>GEOGRAPHIC COVERAGE</span></div>
      <h2>Car Wash POS operators across Punjab.</h2>
    </div>
    <div class="geo-tags reveal">
      <span>Lahore</span>
      <span>Multan</span>
      <span>Gujranwala</span>
      <span>Punjab-wide</span>
    </div>
  </div>
</section>

<section id="car-wash-pos--security" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>SECURE &amp; COMPLIANT</span></div>
      <h2>Secure &amp; Compliant PRA &amp; FBR POS Integration for Car Wash Businesses.</h2>
      <p>Manual billing and undocumented services can create serious compliance challenges, but choosing integration service for stations and car wash through MyPOS.pk protects your business and reputation across Pakistan. Our solution ensures accurate, real-time financial reporting while reducing audit and penalty risks. Whether you operate a car wash, detailing center, or vehicle service station, our PRA integration service deliver compliance without complexity. Contact us today for consultation, system setup, and ongoing regulatory guidance.</p>
    </div>
  </div>
</section>

<x-faq id="car-wash-pos--faq" title="FAQ&rsquo;s About Car Wash PRA &amp; FBR POS Integration" :items="[
  ['Is FBR POS integration mandatory for car wash businesses in Pakistan?', 'Yes, registered car wash and vehicle service businesses offering taxable services must implement FBR POS integration to comply with federal reporting requirements.'],
  ['Do car wash businesses in Punjab need PRA integration as well?', 'Yes, car washes operating in Punjab are required to use PRA integration service for car wash to report provincial sales tax accurately.'],
  ['What services are covered under car wash POS integration?', 'Basic and premium washes, detailing, polishing, waxing, interior cleaning, and bundled service packages are all reported through POS integration.'],
  ['Is FBR POS integration required for service stations and fuel-linked car care shops?', 'Yes, FBR POS integration for service stations applies to car care services offered alongside fuel or maintenance operations.'],
  ['Can small or single-bay car wash businesses use POS integration?', 'Yes, FBR and PRA POS integration applies to car wash businesses of all sizes, including small and single-location setups.'],
  ['What happens if a car wash does not integrate with FBR or PRA?', 'Non-compliance may result in penalties, audits, fines, or suspension of business activities under updated enforcement rules.'],
  ['Is car care shops PRA integration POS software different from retail POS?', 'Yes, car care shops PRA integration POS software is designed for service-based billing rather than retail-only transactions.'],
  ['Can MyPOS.pk manage both FBR and PRA reporting together?', 'Yes, MyPOS.pk provides a unified platform for car wash FBR POS integration service and PRA compliance in one system.'],
]">
  <div class="related-links reveal" style="max-width:820px;">
    <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    <a href="{{ url('/pra-integration') }}">PRA Integration</a>
    <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
    <a href="{{ url('/veteran-clinic-fbr-pos-integration') }}">Veteran Clinic POS</a>
    <a href="{{ url('/pricing') }}">Pricing</a>
  </div>
</x-faq>

<section id="car-wash-pos--final-cta" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="cta-band reveal">
      <h2>Get Your Car Wash POS Compliant Before Penalties Hit.</h2>
      <p>2026 enforcement is active for car wash and service station businesses. Set up FBR &amp; PRA reporting in one visit &mdash; no separate systems, no manual filing.</p>
      <div>
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Call +92 322 476 5528</a>
        <a href="{{ wa_link() }}" class="btn btn-outline" style="margin-left:14px; border-color:rgba(255,255,255,0.35); color:#fff;" target="_blank" rel="noopener">WhatsApp</a>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-outline" style="margin-left:14px; border-color:rgba(255,255,255,0.35); color:#fff;">Request PRA &amp; FBR Setup</a>
      </div>
    </div>
  </div>
</section>
@endsection
