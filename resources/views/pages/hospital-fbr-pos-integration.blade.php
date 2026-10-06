@extends('layouts.app')

@section('page', 'hospital-fbr-pos-integration')
@section('title', 'Hospital FBR POS Integration & PRA Software - Mypos.pk')
@section('description', 'Get The Best Hospital FBR POS Integration For Tier-1 Facilities. Our PRA Integration Service For Hospitals Ensures 100% Tax Compliance. Book A Demo Today!')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<header class="ind-hero">
  <div class="wrap">
    <div class="crumb reveal"><a href="{{ route('home') }}">Home</a> &nbsp;/&nbsp; <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a> &nbsp;/&nbsp; Hospitals</div>
    <h1 class="reveal">Hospital FBR POS Integration</h1>
    <p class="lead reveal">FBR &amp; PRA compliant POS for hospitals and medical institutions &mdash; OPD, IPD, pharmacy and lab billing reported in real time, with FBR-verifiable QR codes on every patient receipt.</p>
    <div class="ind-actions reveal">
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Book A Free Demo</a>
      <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-outline" target="_blank" rel="noopener">WhatsApp</a>
      <a href="{{ url('/contact') }}#enquiry" class="btn btn-outline">Get In Touch</a>
    </div>
    <p class="reveal" style="margin-top:18px; color:var(--text-mute-on-dark); font-size:0.92rem;">Give Us a Call to find out more about our Point of Sale Software. <a href="tel:{{ config('site.phone_raw') }}" style="color:var(--blue-light); font-weight:600;">{{ config('site.phone') }} Call us anytime</a></p>
    <div class="hero-photo-wrap reveal-scale">
      <img src="{{ asset('uploads/2025/12/how-to-integrate-your-pos-with-fbr-digital-invoicing-1024x576-1.webp') }}" alt="hospital fbr pos integration" width="1024" height="576">
      <div class="float-chip fchip-1"><div class="cdot" style="background:var(--blue-light);"></div><div><div class="ct">OPD Billing</div><div class="cv">FBR Filed</div></div></div>
      <div class="float-chip fchip-3"><div class="cdot" style="background:var(--blue-light);"></div><div><div class="ct">IPD Invoice</div><div class="cv">FBR Filed</div></div></div>
      <div class="float-chip fchip-2"><div class="cdot" style="background:var(--coral-soft);"></div><div><div class="ct">PSTS (Punjab)</div><div class="cv">PRA Filed</div></div></div>
    </div>
    <div class="stats-row reveal" style="margin-top:44px; grid-template-columns:repeat(4,1fr);">
      <div class="stat"><div class="num">15,000+</div><div class="lbl">Customers Across Pakistan</div></div>
      <div class="stat"><div class="num">12,000+</div><div class="lbl">Active Users</div></div>
      <div class="stat"><div class="num">4.9/5</div><div class="lbl">Average Rating</div></div>
      <div class="stat"><div class="num">&lt;2 min</div><div class="lbl">Avg. Response Time</div></div>
    </div>
    <div class="enforce-banner reveal">FBR ENFORCEMENT IS ACTIVE FOR HOSPITALS &amp; TIER-1 MEDICAL PROVIDERS ACROSS PAKISTAN</div>
  </div>
</header>

<section id="fbr-integration">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>FEDERAL COMPLIANCE</span></div>
      <h2>PRA &amp; FBR Compliant POS Integration For Hospitals</h2>
      <p>We provide reliable and professionally managed hospital FBR POS integration services for hospitals and medical institutions across Pakistan. Our solutions help hospitals comply with applicable Federal Board Of Revenue (FBR) and Punjab Revenue Authority (PRA) regulations, manage structured income reporting, and meet POS integration requirements where enforcement applies.</p>
      <p>Whether your hospital requires mandatory Point Of Sale integration under regulatory notifications or needs a compliant system for income tax filing, documentation, and audits, MyPOS.pk delivers secure, scalable, and healthcare-ready POS solutions.</p>
      <div class="btn-row" style="margin-top:24px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Book A Free Demo</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-outline" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    </div>
    <div class="compliance-visual reveal-right">
      <div class="compliance-mock" style="max-width:420px;">
        <div class="compliance-mock-head"><span class="cm-dot"></span> FBR REAL-TIME FEED &mdash; LIVE</div>
        <div class="live-row"><span class="lv-lbl">OPD + IPD Bill Sync</span><span class="lv-val">Verified</span></div>
        <div class="live-row"><span class="lv-lbl">QR Code on Receipt</span><span class="lv-val">Printed</span></div>
        <div class="live-row"><span class="lv-lbl">Reporting Authority</span><span class="lv-val">FBR</span></div>
      </div>
    </div>
  </div>
</section>

<section id="pra-integration" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>PROVINCIAL COMPLIANCE</span></div>
      <h2>PRA Integration Service for Punjab-Based Hospitals</h2>
      <p>For hospitals operating in Punjab, PRA integration with POS is essential for provincial-level documentation and reporting. Our hospital PRA integration service helps medical institutions align their billing and income records with Punjab Revenue Authority (PRA) requirements.</p>
      <p>We provide PRA integration service for hospital clients across:</p>
      <div class="geo-tags">
        <span>Lahore</span><span>Rawalpindi</span><span>Faisalabad</span><span>Multan</span><span>Gujranwala</span><span>Sialkot</span>
      </div>
      <p>Our systems support consistent reporting while keeping hospital operations smooth.</p>
      <div class="btn-row" style="margin-top:24px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Talk To Expert</a>
      </div>
    </div>
    <div class="media-frame reveal-right">
      <img src="{{ asset('uploads/2025/12/e-invoice-696x377-1.png') }}" alt="hospital fbr pos integration - PRA e-invoice" width="696" height="377" loading="lazy">
    </div>
  </div>
</section>

<section id="pra-clinics">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2025/12/FBR-e-invoicing-smk-mojo-222-Sadaan-1024x576-1.webp') }}" alt="hospital fbr pos integration - FBR e-invoicing" width="1024" height="576" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>CLINICS &amp; MEDICAL PROVIDERS</span></div>
      <h2>The Role of PRA Integration Service for Clinics</h2>
      <p>For healthcare providers operating in Punjab, a reliable PRA integration service for clinics plays a vital role in maintaining provincial tax compliance and accurate income documentation. The Punjab Revenue Authority (PRA) requires clinics and medical service providers to properly record and report applicable provincial sales tax on services and taxable supplies.</p>
      <p>Our company offers a streamlined solution that simplifies this entire process by automating reporting, documentation, and reconciliation. Through our platform, clinics can manage both FBR (federal) requirements and clinics PRA integration (provincial) from a single, unified interface. This reduces manual effort, minimizes reporting errors, and ensures clinics remain compliant while focusing on patient care and daily operations.</p>
      <div class="btn-row" style="margin-top:24px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Book A Free Demo</a>
        <a href="{{ url('/clinics-fbr-pos-integration') }}" class="btn btn-ghost">Clinics FBR POS Integration</a>
      </div>
    </div>
  </div>
</section>

<section id="psts" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>PUNJAB SALES TAX ON SERVICES</span></div>
      <h2>The Strategic Importance of Hospital PRA Integration Service</h2>
      <p>For hospitals located in Punjab, compliance is twofold. While federal taxes are handled via FBR, provincial service taxes fall under the PRA. Our hospital PRA integration service is specifically designed to handle the complexities of the Punjab Sales Tax on Services (PSTS). By using our PRA integration service for hospital workflows, you can automatically calculate, report, and update invoices without manual intervention.</p>
      <div class="btn-row" style="margin-top:24px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Request Hospital POS Integration</a>
      </div>
    </div>
    <div class="media-frame reveal-right" style="max-width:460px; justify-self:center;">
      <img src="{{ asset('uploads/2025/12/qr-code.jpg') }}" alt="hospital fbr pos integration - FBR QR code receipt" width="550" height="448" loading="lazy">
    </div>
  </div>
  <div class="wrap">
    <div class="compare-table-wrap reveal">
      <table class="compare-table">
        <thead><tr><th>Compliance</th><th>FBR POS Integration</th><th>PRA Integration (Punjab)</th></tr></thead>
        <tbody>
          <tr><td>Authority</td><td>Federal Board Of Revenue (federal taxes)</td><td>Punjab Revenue Authority (provincial service taxes)</td></tr>
          <tr><td>Tax reported</td><td>Real-time invoice reporting (FBR Real-Time Sync)</td><td>Punjab Sales Tax on Services (PSTS)</td></tr>
          <tr><td>Patient receipt</td><td>FBR-verifiable QR code (SRO 1842(I)/2023)</td><td>Automated provincial tax reporting</td></tr>
          <tr><td>Platform</td><td colspan="2">Both handled from a single, unified MyPOS.pk interface</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section id="software">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2025/06/2109.i607.018.S.m012.c12.fintech-isometric-icons-scaled-1024x1024.jpg') }}" alt="hospital fbr pos integration software" width="1024" height="1024" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>BUILT FOR HEALTHCARE</span></div>
      <h2>The Ultimate Hospital PRA Integration POS Software</h2>
      <p>Unlike generic retail systems, <a href="{{ url('/hospital-management') }}" class="link-arrow">our software is built for the healthcare environment</a>. It understands the nuances of OPD billing, pharmacy sales, diagnostic lab charges, and IPD (In-Patient) invoicing.</p>
    </div>
  </div>
  <div class="wrap">
    <div class="icon-row-grid stagger">
      <div class="icon-row-card reveal-scale" style="--i:0"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 4h12v13l-3-2-3 2-3-2-3 2V4z" stroke="#fff" stroke-width="1.4"/></svg></div><span><strong>Unified Billing:</strong> Sync OPD and IPD bills in one click (FBR Real-Time Sync).</span></div>
      <div class="icon-row-card reveal-scale" style="--i:1"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="3" y="3" width="5" height="5" stroke="#fff" stroke-width="1.4"/><rect x="12" y="3" width="5" height="5" stroke="#fff" stroke-width="1.4"/><rect x="3" y="12" width="5" height="5" stroke="#fff" stroke-width="1.4"/><path d="M12 12h2v2h-2zM15 15h2v2h-2z" fill="#fff"/></svg></div><span><strong>QR Code Generation:</strong> Instant FBR-verifiable QR codes on patient receipts (SRO 1842(I)/2023 Compliant).</span></div>
      <div class="icon-row-card reveal-scale" style="--i:2"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2l6 3v5c0 4-3 6.5-6 8-3-1.5-6-4-6-8V5l6-3z" stroke="#fff" stroke-width="1.4"/></svg></div><span><strong>PRA Ready:</strong> Automated provincial tax reporting for Punjab facilities.</span></div>
      <div class="icon-row-card reveal-scale" style="--i:3"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 17V8l7-5 7 5v9" stroke="#fff" stroke-width="1.4"/><path d="M8 17v-5h4v5" stroke="#fff" stroke-width="1.4"/></svg></div><span><strong>Multi-Branch Control:</strong> Manage hospitals in Faisalabad, Peshawar, and Rawalpindi from one desk (Centralized Tax Audit).</span></div>
      <div class="icon-row-card reveal-scale" style="--i:4"><div class="ic-wrap"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="9" width="12" height="8" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M7 9V6a3 3 0 016 0v3" stroke="#fff" stroke-width="1.4"/></svg></div><span><strong>Secure EMR:</strong> Encrypted Electronic Medical Records linked to billing.</span></div>
    </div>
    <div class="btn-row reveal" style="margin-top:28px;">
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Book A Free Demo</a>
      <a href="{{ url('/hospital-management') }}" class="btn btn-ghost">Hospital Management Software</a>
    </div>
  </div>
</section>

<section id="how-it-works" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>AVOID PENALTIES</span></div>
      <h2>Protect Your Hospital From Penalties With PRA &amp; FBR POS Integration</h2>
      <p>Non-compliance can lead to fines, audits, or operational challenges, making professional hospital PRA integration service and FBR POS integration essential. Our systems handle regulatory requirements with clinical precision while managing income documentation and financial reporting in the background.</p>
    </div>
    <div class="steps-flow stagger" style="grid-template-columns:repeat(4,1fr);">
      <div class="step-tile reveal-scale" style="--i:0"><div class="st-num">01</div><div><h4>Consultation</h4><p>Talk to our team about your hospital's billing and compliance scope.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:1"><div class="st-num">02</div><div><h4>System Setup</h4><p>FBR &amp; PRA reporting configured on your OPD, IPD, pharmacy and lab billing.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:2"><div class="st-num">03</div><div><h4>Go Live</h4><p>Patient receipts carry FBR-verifiable QR codes from day one.</p></div></div>
      <div class="step-tile reveal-scale" style="--i:3"><div class="st-num">04</div><div><h4>Compliance Guidance</h4><p>Ongoing documentation support while your teams focus on patients.</p></div></div>
    </div>
    <div class="benefit-card reveal" style="margin-top:36px; background:#fff;">
      <p><a href="{{ url('/') }}">MyPOS.pk</a> provides hospitals across Punjab with mandatory Point Of Sale compliance, structured income reporting, and professional documentation support. Our solutions deliver smooth compliance without complexity, allowing your medical teams to focus entirely on patient care. Contact us today for consultation, system setup, or compliance guidance.</p>
      <div class="btn-row" style="margin-top:20px;">
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-primary">Book A Free Demo</a>
        <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      </div>
    </div>
  </div>
</section>

<x-faq title="FAQ's About Hospitals PRA &amp; FBR POS Integration" :items="[
  ['Is POS integration mandatory for all private clinics and hospitals in Pakistan?', 'Yes, all Tier-1 medical providers, including those in malls, chains, or with annual electricity bills over Rs. 1.2 million, must legally integrate with FBR.'],
  ['What is the latest deadline for hospital FBR POS integration in 2025?', 'Corporate hospitals were required to integrate by July 1st, 2025, while non-corporate clinics had until August 1st, 2025, to comply with the digital mandate.'],
  ['What are the penalties if my clinic fails to integrate with the FBR system?', 'Non-compliance can lead to immediate fines of Rs. 500,000, sealing of the clinic, and being removed from the Active Taxpayer List (ATL).'],
  ['Do clinics in Punjab need separate integration for the Punjab Revenue Authority (PRA)?', 'Yes, Punjab-based facilities must use a hospital pra integration service to report provincial service taxes alongside their federal FBR reporting.'],
  ['How can a patient verify if their hospital bill is officially reported to the FBR?', 'Patients can scan the QR code printed on their receipt using the Tax Asaan App or SMS their invoice number to 9966 for instant verification.'],
  ['Can I integrate my existing hospital management software with the FBR/PRA portals?', 'You can integrate if your software supports the required APIs; Mypos.pk specializes in bridging existing systems to meet 2025 compliance standards.'],
]">
  <div class="related-links reveal" style="margin-top:36px;">
    <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
    <a href="{{ url('/pra-integration') }}">PRA POS Integration</a>
    <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
    <a href="{{ url('/hospital-management') }}">Hospital Management</a>
    <a href="{{ url('/clinics-fbr-pos-integration') }}">Clinics FBR POS Integration</a>
    <a href="{{ url('/dental-clinics-fbr-pos-integration') }}">Dental Clinics FBR POS Integration</a>
    <a href="{{ url('/aesthatic-clinics-fbr-pos-integration') }}">Aesthetic Clinics FBR POS Integration</a>
  </div>
</x-faq>

<x-cta-band title="Get Your Hospital POS Compliant Before Penalties Hit." text="FBR &amp; PRA reporting for OPD, IPD, pharmacy and lab billing in one system &mdash; book a free demo with our team today." primary="Book a Free Demo" />
@endsection
