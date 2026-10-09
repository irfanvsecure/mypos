@extends('layouts.app')

@section('page', 'hospital-management')
@section('title', 'Doctors, Pharmacy and Hospital Management System - myPOS')
@section('description', 'For small and medium size hospitals our application controls all operations like booking appointments, issuing tickets, lab test, patient records and much more.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['2024/01/document_971549-removebg-preview-min-e1705045802261.png', 'Electronic Health Records', 'Digitize patient medical records for secure paperless storage and access.'],
    ['2024/01/printer-cartridges_5755137-min-1-e1705128684549.png', 'Medical Billing and Insurance Claims Processing', 'Streamline insurance verification and claims submissions.'],
    ['2024/01/computer_4377782-removebg-preview-min-e1705130660786.png', 'Hospital Administration and Analytics', 'Centralize data for actionable insights, enhancing informed decision-making processes effectively.'],
    ['2024/01/schedule_4148598-removebg-preview-min-e1705045954883.png', 'Patient Portal and Self-Scheduling', 'Enable patients to book appointments and pay bills online with myPOS.'],
    ['2024/01/checklist_9279554-removebg-preview-min-e1705129305713.png', 'Pharmacy Inventory Control', 'Efficiently oversee pharmaceutical inventory and process prescription requests seamlessly.'],
    ['2024/01/webpage_5865702-removebg-preview-min-e1705131256104.png', 'Custom Reporting and Dashboards', 'Create hospital KPI reports for effective performance monitoring and analysis.'],
    ['2024/01/continuity_12376707-removebg-preview-min-e1705046346200.png', 'Revenue Cycle Management', 'Automate billing, streamline claims processing workflows for efficiency and accuracy.'],
    ['2024/01/report_2877751-removebg-preview-min-e1705129497416.png', 'Laboratory Information System', 'Efficiently manage and monitor lab tests, results through electronic tracking.'],
    ['2024/01/deadline_7890943-removebg-preview-min-e1705134484970.png', 'Appointment Reminders and Waitlist Management', 'Efficiently send reminders, manage patient waitlists for streamlined appointments.'],
  ];
  $shots = [
    ['2022/10/Users-min-1.png', 'Users'],
    ['2024/01/Patient-min-1.png', 'Patient'],
    ['2024/01/Report-Form-min-1.png', 'Report Form'],
    ['2024/01/Receipts-min-1.png', 'Receipts'],
  ];
@endphp

@section('content')
<x-page-header title="Hospital Management" eyebrow="HOSPITAL MANAGEMENT SYSTEM" crumb="Hospital Management"
  lead="As the best hospital management system software in Pakistan, myPOS offers automated tools to optimize healthcare administration &mdash; appointments, patient records, lab tests, pharmacy and billing in one place.">
    <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
    <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="{{ url('/hospital-fbr-pos-integration') }}" class="btn btn-outline">Hospital FBR Integration</a>
  </div>
  <div class="hero-trust">
    <x-cta-proof :caption="false" />
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>FBR &amp; PRA</b><span>Integrated invoicing</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support, always on call</span></div>
  </div>
</x-page-header>

<section id="hospital-management--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>HIMS</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Best Hospital Management System Software Pakistan</h2>
      <p>As the best hospital management system software in Pakistan, myPOS offers automated tools to optimize healthcare administration.</p>
      <p>The comprehensive hospital information management system (HIMS) aims to digitize manual workflows, including outdoor patient management across hospitals and clinic networks.</p>
      <ul class="check-list">
        <li>By transitioning to the myPOS hospital management system and outdoor patient module, healthcare facilities can focus more resources on quality care rather than paperwork.</li>
        <li>Core HMS features include electronic health records, appointment scheduling, revenue cycle management, inventory control, and data analytics.</li>
        <li>The user-friendly, customizable platform centralizes data for transparent reporting and prevents supply shortages.</li>
      </ul>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2024/01/Best_Hospital_Management_System-removebg-preview-min.png') }}" alt="Best hospital management system software in Pakistan" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="hospital-management--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For Hospital Management System Software</h2>
      <p>As the premier hospital management system software in Pakistan myPOS digitizes administrative processes for paperless workflows. The automated tools facilitate healthcare facilities to optimize operations, resources, and quality care. User-friendly interface provides customization across networks.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $title, $desc])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }} &ndash; hospital management" loading="lazy" style="width:28px; height:28px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p>{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<x-mid-cta />

<section id="hospital-management--why">
  <div class="wrap split">
    <div class="reveal-left">
      <img src="{{ asset('uploads/2024/01/4950249_19836-removebg-preview-min.png') }}" alt="MyPOS patient management software illustration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY MYPOS</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Choose MyPOS Patient Management Software Exclusively</h2>
      <p>MyPOS offers an end-to-end hospital information management solution that connects vital workflows to optimize efficiency.</p>
      <ul class="check-list">
        <li>The comprehensive yet user-friendly software integrates everything from admissions to discharge, leveraging automation to digitize paperwork.</li>
        <li>This unified platform allows hospitals to coordinate care delivery seamlessly across departments.</li>
        <li>By transitioning to automated tools for inventory controls, scheduling, billing and more, MyPOS maximizes resource management so staff can focus on patients over administrative tasks.</li>
        <li>Investing in this hospital management ecosystem ultimately pays dividends through improved experiences, outcomes and scalable growth for the future.</li>
      </ul>
      <a href="{{ url('/contact') }}" class="link-arrow">Sign up for a demo today. &rarr;</a>
    </div>
  </div>
</section>

<section id="hospital-management--screenshots" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INSIDE THE SOFTWARE</span></div>
      <h2>Hospital management screens.</h2>
      <p>Users, patient records, lab report forms and receipts &mdash; all managed from one system.</p>
    </div>
    <div class="benefit-cards stagger">
      @foreach ($shots as $i => [$file, $label])
        <figure class="media-frame reveal-scale" style="--i:{{ $i }}">
          <img src="{{ asset('uploads/' . $file) }}" alt="Hospital Management {{ $label }}" loading="lazy" style="height:auto; aspect-ratio:1440/860;">
          <figcaption style="padding:14px 18px; font-weight:600; color:var(--navy); border-top:1px solid var(--paper-line);">{{ $label }}</figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>

<section id="hospital-management--related" class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>FBR &amp; PRA integration for healthcare.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/hospital-fbr-pos-integration') }}">Hospital FBR POS Integration</a>
      <a href="{{ url('/clinics-fbr-pos-integration') }}">Clinics FBR POS Integration</a>
      <a href="{{ url('/laboratories-fbr-pos-integration') }}">Laboratories FBR POS Integration</a>
      <a href="{{ url('/medical-complex-fbr-pos-integration') }}">Medical Complex FBR POS Integration</a>
      <a href="{{ url('/dental-clinics-fbr-pos-integration') }}">Dental Clinics FBR POS Integration</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="See hospital billing and records on a free demo."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free demo of the myPOS hospital management system for your hospital, clinic or pharmacy." primary="Book a Free Demo" />
@endsection
