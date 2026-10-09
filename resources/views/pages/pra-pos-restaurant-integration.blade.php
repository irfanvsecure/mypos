@extends('layouts.app')

@section('page', 'pra-pos-restaurant-integration')
@section('title', 'PRA POS Restaurant Integration in Punjab | myPOS')
@section('description', 'myPOS delivers PRA POS restaurant integration for dine-in, takeaway, and delivery billing, with automatic tax reporting for Punjab restaurants.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $chk = '<svg width="16" height="16" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>';
  $tel = 'tel:' . config('site.phone_raw');
  $wa = wa_link();
@endphp

@section('content')
<header class="ind-hero">
  <div class="wrap">
    <div class="crumb reveal"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; <a href="{{ url('/pra-integration') }}">PRA Integration</a> &nbsp;/&nbsp; Restaurants</div>
    <span class="eyebrow-pill reveal">Punjab Revenue Authority</span>
    <h1 class="reveal">PRA POS Restaurant Integration in Punjab</h1>
    <p class="lead reveal">myPOS delivers PRA POS restaurant integration for dine-in, takeaway, and delivery billing, with automatic tax reporting for Punjab restaurants.</p>
    <div class="ind-actions reveal">
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ $wa }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      <a href="#how-it-works" class="btn btn-outline">Learn How It Works &#9662;</a>
    </div>
    <x-cta-proof />
    <div class="hero-photo-wrap reveal-scale">
      <img src="{{ asset('uploads/2026/07/PRA-POS-Restaurant-Integration-in-Punjab.jpg') }}" alt="Restaurant cashier billing an order on PRA integrated POS in Punjab" width="1060" height="707">
      <div class="float-chip fchip-1"><div class="cdot"></div><div><div class="ct">Dine-in &middot; Table 7</div><div class="cv">PRA Reported</div></div></div>
      <div class="float-chip fchip-3"><div class="cdot is-coral"></div><div><div class="ct">Delivery Order</div><div class="cv">QR-Coded Invoice</div></div></div>
      <div class="float-chip fchip-2"><div class="cdot"></div><div><div class="ct">Takeaway</div><div class="cv">Tax Calculated</div></div></div>
    </div>
    <div class="stats-row reveal" style="margin-top:44px; grid-template-columns:repeat(4,1fr);">
      <div class="stat"><div class="num">500+</div><div class="lbl">Restaurants Integrated</div></div>
      <div class="stat"><div class="num">100%</div><div class="lbl">PRA Compliant</div></div>
      <div class="stat"><div class="num">3 Days</div><div class="lbl">Average Setup</div></div>
      <div class="stat"><div class="num">15,000+</div><div class="lbl">Customers Across Pakistan</div></div>
    </div>
    <div class="enforce-banner reveal">DINE-IN &middot; TAKEAWAY &middot; DELIVERY &mdash; EVERY INVOICE CALCULATED, QR-CODED &amp; REPORTED TO PRA THE MOMENT THE SALE HAPPENS</div>
  </div>
</header>

<section id="what-is-pra-integration">
  <div class="wrap split">
    <div class="ib-photo square reveal-left">
      <img src="{{ asset('uploads/2026/07/What-Is-PRA-POS-Restaurant-Integration.png') }}" alt="What is PRA POS restaurant integration: billing software connected to PRA" loading="lazy" width="1056" height="1056">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>Compliance Basics</span></div>
      <h2>What Is PRA POS Restaurant Integration?</h2>
      <p>Restaurants in Punjab are required to charge and report tax under the Punjab Revenue Authority's rules for restaurant services, which are handled separately from the federal FBR system most retail businesses deal with. PRA POS restaurant integration means your billing software is connected directly to PRA's reporting system, so every invoice, whether it's dine-in, takeaway, or a delivery order, is automatically calculated, QR-coded, and reported the moment the sale happens.</p>
      <p>Without this, restaurants end up running two separate processes: one for actually billing the customer, and another for manually reporting sales to PRA later. That second process is where most compliance problems start, since it depends on someone remembering to do it correctly, every single day, across every shift.</p>
      <div class="btn-row" style="margin-top:26px;">
        <a href="{{ $tel }}" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ url('/contact#enquiry') }}" class="btn btn-ghost">Book a Free Demo</a>
      </div>
    </div>
  </div>
  <div class="wrap">
    <div class="compare-grid reveal" style="margin-top:60px;">
      <div class="compare-col">
        <h3>Without PRA integration</h3>
        <ul>
          <li>{!! $chk !!}<span>Two processes: billing the customer, then reporting sales to PRA later</span></li>
          <li>{!! $chk !!}<span>Depends on someone remembering to report correctly, every shift</span></li>
          <li>{!! $chk !!}<span>Manual tax registers that rarely match PRA's records</span></li>
        </ul>
      </div>
      <div class="compare-col" style="background:var(--paper-2);">
        <h3>With myPOS PRA integration</h3>
        <ul>
          <li>{!! $chk !!}<span>Billing software connected directly to PRA's reporting system</span></li>
          <li>{!! $chk !!}<span>Every invoice calculated, QR-coded and reported automatically</span></li>
          <li>{!! $chk !!}<span>Correct dine-in, takeaway and delivery treatment on every order</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section id="how-it-works" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="split">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>Process</span></div>
        <h2>How PRA Restaurant Integration Works with myPOS</h2>
        <p>myPOS handles PRA restaurant integration at the point of sale, not as an after-the-fact reporting step. When an order is billed, whether it came from a waiter's tablet, a counter till, or a delivery app, the system calculates PRA tax automatically, generates the required QR code on the invoice, and sends the transaction data to PRA in real time.</p>
        <p>Staff don't do anything differently. There's no extra screen, no separate tax entry, and no end-of-day reconciliation step added to their workload. The integration sits underneath your existing restaurant billing software, so kitchen order tickets, table management, and menu changes all continue working exactly as before. Tax reporting just happens alongside it.</p>
        <p>This also solves a problem specific to restaurants: tax treatment often needs to differ between dine-in, takeaway, and delivery, and manual systems tend to blur that distinction under pressure during a rush. Automated PRA restaurant integration applies the correct treatment every time, regardless of how busy the floor is.</p>
      </div>
      <div class="ib-photo square reveal-right">
        <img src="{{ asset('uploads/2026/07/How-PRA-Restaurant-Integration-Works-with-myPOS.jpg') }}" alt="How PRA restaurant integration works with myPOS at the point of sale" loading="lazy" width="1060" height="1060">
        <div class="compliance-mock">
          <div class="compliance-mock-head"><span class="cm-dot"></span> PRA &mdash; PUNJAB FEED &mdash; LIVE</div>
          <div class="live-row"><span class="lv-lbl">Dine-in invoice</span><span class="lv-val">Reported</span></div>
          <div class="live-row"><span class="lv-lbl">Takeaway invoice</span><span class="lv-val">Reported</span></div>
          <div class="live-row"><span class="lv-lbl">Delivery invoice</span><span class="lv-val">Reported</span></div>
        </div>
      </div>
    </div>
    <div class="steps-flow stagger" style="grid-template-columns:repeat(4,1fr);">
      <div class="step-tile reveal-scale" style="--i:0"><div class="st-num">01</div><div><h4>Order billed</h4><p>From a waiter's tablet, a counter till or a delivery app.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:1"><div class="st-num">02</div><div><h4>Tax calculated</h4><p>PRA tax applied automatically for dine-in, takeaway or delivery.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:2"><div class="st-num">03</div><div><h4>QR code generated</h4><p>The required QR code is printed on the invoice.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:3"><div class="st-num">04</div><div><h4>Reported in real time</h4><p>Transaction data is sent to PRA the moment the sale happens.</p></div></div>
    </div>
    <div class="btn-row reveal" style="margin-top:30px;">
      <a href="{{ $tel }}" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ url('/restaurant-management') }}" class="link-arrow">See the restaurant billing software &rarr;</a>
    </div>
  </div>
</section>

<x-mid-cta />

<section class="section-tight" id="rush-hours">
  <div class="wrap">
    <div class="ib-callout reveal-scale">
      <div class="ib-bolt" aria-hidden="true">&#9889;</div>
      <div>
        <h3>Built for Rush Hours</h3>
        <p>Dinner rushes are when manual tax entry breaks down first. PRA POS restaurant integration through myPOS applies dine-in, takeaway, and delivery tax rules automatically on every order, so accuracy doesn't depend on how busy the floor gets or how many tickets are stacked up at once.</p>
      </div>
    </div>
  </div>
</section>

<section id="restaurant-chains">
  <div class="wrap">
    <div class="split">
      <div class="ib-photo reveal-left">
        <img src="{{ asset('uploads/2026/07/PRA-POS-Integration-for-Restaurant-Chains-and-Multi-Branch-Setups.png') }}" alt="PRA POS integration for restaurant chains and multi-branch setups" loading="lazy" width="1060" height="706">
      </div>
      <div class="reveal-right">
        <div class="eyebrow-line"><span class="bar"></span><span>For Restaurant Groups</span></div>
        <h2>PRA POS Integration for Restaurant Chains and Multi-Branch Setups</h2>
        <p>Restaurant groups running multiple outlets face a version of this problem that's harder to manage manually: each branch reporting sales on its own, with no easy way to reconcile them centrally.</p>
        <p>With PRA POS restaurant integration through myPOS, every branch reports through the same connected system, giving you one consolidated view of tax data instead of collecting spreadsheets from each location separately.</p>
      </div>
    </div>
    <div class="benefit-cards stagger" style="grid-template-columns:repeat(4,1fr);">
      <div class="benefit-card reveal-scale" style="--i:0;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><rect x="3" y="3" width="6" height="6" rx="1" stroke="#fff" stroke-width="1.4"/><rect x="11" y="3" width="6" height="6" rx="1" stroke="#fff" stroke-width="1.4"/><rect x="3" y="11" width="6" height="6" rx="1" stroke="#fff" stroke-width="1.4"/><rect x="11" y="11" width="6" height="6" rx="1" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Consolidated View</h3><p>All branches, one tax dashboard. No more collecting spreadsheets.</p></div>
      <div class="benefit-card reveal-scale" style="--i:1;"><div class="bc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M10 2.5l6 2.5v4.5c0 4-2.6 6.7-6 8-3.4-1.3-6-4-6-8V5l6-2.5z" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Audit-Ready</h3><p>Consistent records across every branch. No branch-by-branch inconsistency to explain.</p></div>
      <div class="benefit-card reveal-scale" style="--i:2;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7" stroke="#fff" stroke-width="1.4"/><path d="M3 10h14M10 3c2 2.2 3 4.5 3 7s-1 4.8-3 7c-2-2.2-3-4.5-3-7s1-4.8 3-7z" stroke="#fff" stroke-width="1.2"/></svg></div><h3>Multi-Province Ready</h3><p>Handles PRA and FBR e-invoicing through the same platform if you operate across provinces.</p></div>
      <div class="benefit-card reveal-scale" style="--i:3;"><div class="bc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><rect x="3" y="4" width="14" height="10" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M7 17h6M10 14v3" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Unified Platform</h3><p>Federal and provincial reporting on one system &mdash; no separate software per authority.</p></div>
    </div>
    <div class="btn-row reveal" style="margin-top:30px;">
      <a href="{{ url('/contact#enquiry') }}" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ $wa }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <a href="{{ $tel }}" class="btn btn-ghost">Call {{ config('site.phone') }}</a>
    </div>
  </div>
</section>

<section id="risks" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="split">
      <div class="reveal-left">
        <div class="eyebrow-line"><span class="bar"></span><span>Risks</span></div>
        <h2>What Happens Without PRA Restaurant Integration</h2>
        <p>Restaurants that delay integration usually run into a specific set of problems, not vague ones.</p>
      </div>
      <div class="ib-photo reveal-right">
        <img src="{{ asset('uploads/2026/07/What-Happens-Withoout-PRA-Restaurant-Integration.jpg') }}" alt="What happens without PRA restaurant integration: mismatched tax registers" loading="lazy" width="705" height="576">
      </div>
    </div>
    <div class="benefit-cards stagger" style="grid-template-columns:repeat(3,1fr);">
      <div class="benefit-card reveal-scale" style="--i:0; background:#fff;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M6 3h8v14H6z" stroke="#fff" stroke-width="1.4"/><path d="M8.5 7h3M8.5 10h3M8.5 13h3" stroke="#fff" stroke-width="1.3"/></svg></div><h3>Mismatched Tax Registers</h3><p>Manual tax registers rarely match PRA's records exactly, since they depend on staff entering data correctly after the fact.</p></div>
      <div class="benefit-card reveal-scale" style="--i:1; background:#fff;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7" stroke="#fff" stroke-width="1.4"/><path d="M10 6v5M10 13.5v.5" stroke="#fff" stroke-width="1.6"/></svg></div><h3>Unexplainable Discrepancies</h3><p>Discrepancies between kitchen tickets and final invoices become harder to explain once PRA starts cross-checking transaction volume against reported tax.</p></div>
      <div class="benefit-card reveal-scale" style="--i:2; background:#fff;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M3 6h14M3 10h14M3 14h14" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Inconsistent Tax Across Channels</h3><p>Restaurants running multiple channels &mdash; dine-in, delivery apps, takeaway counters &mdash; often end up applying inconsistent tax treatment because no single system tracks all three the same way.</p></div>
    </div>
  </div>
</section>

<section id="why-mypos">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Advantage</span></div>
      <h2>Why Restaurants in Punjab Choose myPOS</h2>
    </div>
    <div class="benefit-cards stagger" style="grid-template-columns:repeat(3,1fr);">
      <div class="benefit-card reveal-scale" style="--i:0;"><div class="bc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v13l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Built for Pakistani Tax</h3><p>myPOS was built around Pakistani tax requirements specifically, not adapted from a generic POS system after the fact. PRA reporting logic is part of the core billing engine rather than a plugin bolted on later.</p></div>
      <div class="benefit-card reveal-scale" style="--i:1;"><div class="bc-ic is-coral"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><rect x="5" y="2.5" width="10" height="5" rx="1" stroke="#fff" stroke-width="1.4"/><rect x="3" y="7.5" width="14" height="7" rx="1.5" stroke="#fff" stroke-width="1.4"/><rect x="6" y="12" width="8" height="5.5" rx="1" stroke="#fff" stroke-width="1.4"/></svg></div><h3>Works With Your Hardware</h3><p>The platform runs on hardware restaurants already use &mdash; printers, KOTs, and existing card machines &mdash; so switching doesn't mean replacing equipment your staff are already trained on.</p></div>
      <div class="benefit-card reveal-scale" style="--i:2;"><div class="bc-ic"><svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M4 3.5h3l1.5 4-2 1.2a9 9 0 0 0 4.8 4.8l1.2-2 4 1.5v3c0 .8-.7 1.5-1.5 1.5C8.3 17.5 2.5 11.7 2.5 5 2.5 4.2 3.2 3.5 4 3.5z" stroke="#fff" stroke-width="1.3"/></svg></div><h3>Local Support in Pakistan</h3><p>Support is based locally in Pakistan, so questions about how a specific transaction was reported get answered by someone who understands PRA's rules directly &mdash; not a generic support queue reading from a script.</p></div>
    </div>
    <div class="btn-row reveal" style="margin-top:30px;">
      <a href="{{ $tel }}" class="btn btn-primary">Book a Free Demo</a>
      <a href="{{ url('/pricing') }}" class="link-arrow">See pricing &rarr;</a>
    </div>
  </div>
</section>

<x-faq title="FAQs About PRA POS Restaurant Integration" style="background:var(--paper-2);" :items="[
  ['1. Is PRA POS restaurant integration mandatory in Punjab?', 'Most PRA-registered restaurants are required to integrate their billing systems under provincial sales tax rules. Requirements can vary by size and registration category, so it’s worth confirming your restaurant’s specific status.'],
  ['2. Does PRA restaurant integration slow down billing during busy hours?', 'No. Tax calculation and PRA reporting happen automatically the moment a sale is processed. Staff bill exactly the way they already do.'],
  ['3. Can PRA integration work across multiple restaurant branches?', 'Yes. All branches report through the same connected system, giving you centralized records instead of separate tax registers per outlet.'],
  ['4. What happens if my restaurant isn’t PRA compliant yet?', 'Non-compliance can lead to PRA notices, penalties, and closer scrutiny during audits. Restaurants that integrate early avoid the backlog of fixing months of unreported or mismatched sales data.'],
  ['5. How long does PRA restaurant integration setup take?', 'Most restaurant setups are completed within a few days, including staff walkthroughs, though most staff notice no change to how they actually bill customers.'],
]">
  <div class="related-links reveal" style="margin-top:36px;">
    <a href="{{ url('/restaurant-management') }}">Restaurant Management Software</a>
    <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
    <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
    <a href="{{ url('/bakery-pos') }}">Bakery POS</a>
    <a href="{{ url('/pricing') }}">Pricing</a>
  </div>
</x-faq>

<section class="section-tight bg-paper2" id="get-started">
  <div class="wrap">
    <div class="cta-band reveal">
      <div class="eyebrow-line center" style="justify-content:center;"><span class="bar"></span><span style="color:var(--coral-soft);">Get Started Today</span></div>
      <h2>Make Your Restaurant PRA Compliant</h2>
      <p>Setup takes a few days. Your staff won't notice a difference at the counter &mdash; but PRA will notice the difference in your compliance.</p>
      <div class="btn-row" style="justify-content:center;">
        <a href="{{ url('/contact#enquiry') }}" class="btn btn-primary">Request a Demo &rarr;</a>
        <a href="{{ $tel }}" class="btn btn-outline">&#9742; Call Us Now</a>
        <a href="{{ $wa }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      </div>
    </div>
  </div>
</section>
@endsection
