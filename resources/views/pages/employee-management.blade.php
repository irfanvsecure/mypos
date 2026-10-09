@extends('layouts.app')

@section('page', 'employee-management')
@section('title', 'Effortless Employee Management System with myPOS')
@section('description', 'Transform your workforce management with myPOS Employee Management System. Simplify HR tasks, track attendance, and enhance collaboration seamlessly.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="7.5" stroke="#fff" stroke-width="1.4"/><path d="M10 5.5V10l3 2" stroke="#fff" stroke-width="1.4" stroke-linecap="round"/></svg>', 'Time Tracking', 'Automated time tracking with intuitive in/out punch features'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="3" y="3" width="14" height="14" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M6.5 7.5l1.3 1.3L10 6.5M6.5 12.5l1.3 1.3 2.2-2.3M12 8h2.5M12 13h2.5" stroke="#fff" stroke-width="1.2"/></svg>', 'Task Management', 'Project management tools to assign tasks and monitor progress'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="2" width="12" height="16" rx="1" stroke="#fff" stroke-width="1.4"/><path d="M7 6h6M7 9h6M7 12h4" stroke="#fff" stroke-width="1.2"/></svg>', 'Detailed Reporting', 'Detailed reporting on employee hours, activities and location data'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4 15V9M9 15V5M14 15v-7" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>', 'Real-Time Dashboards', 'Customizable dashboards with real-time visibility into staff productivity'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><rect x="4" y="9" width="12" height="8" rx="1.5" stroke="#fff" stroke-width="1.4"/><path d="M7 9V6.5a3 3 0 016 0V9" stroke="#fff" stroke-width="1.4"/></svg>', 'Role-Based Access', 'Role-based access controls for employees, managers and HR'],
    ['<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 3v9M6.5 8.5L10 12l3.5-3.5M4 14v3h12v-3" stroke="#fff" stroke-width="1.4"/></svg>', 'Exportable Insights', 'Exportable data and insights for payroll, compliance and HR initiatives'],
  ];
@endphp

@section('content')
<x-page-header title="Employee Management" eyebrow="FEATURES" :crumbs="[['Features', '/features']]"
  lead="Track attendance, assign tasks and see staff productivity in real time — with your data kept securely on your own premises." :call="true" />

<section id="employee-management--overview">
  <div class="wrap split">
    <div class="media-frame reveal-left">
      <img src="{{ asset('uploads/2023/12/employ-jpg.webp') }}" alt="Employee Management in myPOS point of sale software" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>EMPLOYEE MANAGEMENT</span></div>
      <h2>Best Employee Management System</h2>
      <p>myPOS is a desktop application for employee management and workforce analytics. It enables organizations to track employee productivity across both office and field locations right from employee computers. Key features include:</p>
      <ul class="check-list">
        @foreach ($features as [$icon, $title, $text])
          <li>{{ $title }}</li>
        @endforeach
      </ul>
      <div class="cta-inline">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <span class="num"><a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
  </div>
</section>

<section id="employee-management--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>WHAT YOU GET</span></div>
      <h2>Salient Features</h2>
      <p>Everything a manager needs to track, evaluate and allocate work — from punch-in to payroll.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$icon, $title, $text])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon">{!! $icon !!}</div>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}.</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="employee-management--on-premise">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>YOUR DATA, YOUR CONTROL</span></div>
      <h2>On-premise workforce management.</h2>
      <p>As an on-premise software solution, myPOS provides robust workforce management capabilities while keeping data securely within the organization's control.</p>
      <p>By leveraging the power of the desktop for data collection and access, myPOS aims to simplify employee tracking, performance evaluation and work allocation - without relying on a cloud delivery model.</p>
      <p>The desktop focus aims to provide reliable tools readily accessible to managers and staff alike.</p>
    </div>
    <div class="cta-inline">
      <a href="{{ url('/pricing') }}" class="btn btn-primary">See Pricing</a>
      <a href="{{ url('/features') }}" class="link-arrow">Explore all features →</a>
    </div>
  </div>
</section>

<div class="stats-band">
  <div class="wrap stats-row">
    <div class="stat reveal-scale" style="--i:0"><div class="num" data-count="15000">0</div><div class="lbl">Customers globally</div></div>
    <div class="stat reveal-scale" style="--i:1"><div class="num" data-count="12000">0</div><div class="lbl">Active users</div></div>
    <div class="stat reveal-scale" style="--i:2"><div class="num" data-decimal="4.9">0</div><div class="lbl">Average rating / 5</div></div>
    <div class="stat reveal-scale" style="--i:3"><div class="num">&lt;2min</div><div class="lbl">Avg. response time</div></div>
  </div>
</div>

<x-client-strip title="Our Clients" />

<section class="section-tight">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED FEATURES</span></div>
      <h2>More from myPOS.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/features') }}">All Features</a>
      <a href="{{ url('/stock-management') }}">Stock Management</a>
      <a href="{{ url('/multi-location-integration') }}">Multi Location Integration</a>
      <a href="{{ url('/customers') }}">Customers Management</a>
      <a href="{{ url('/mobile-mypos') }}">Mobile POS</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
    </div>
  </div>
</section>

<x-cta-band title="Manage your team with confidence." text="Book a free demo — see attendance, tasks and staff performance reports in myPOS." />
@endsection
