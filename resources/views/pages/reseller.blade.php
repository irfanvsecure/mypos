@extends('layouts.app')

@section('page', 'reseller')
@section('title', 'Reseller - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $benefits = [
    ['2022/10/1-5.png', 'Grow Together', 'Your integration with Grow MyPos POS brings you strength and profitable growth.'],
    ['2022/10/2-5.png', 'Control Everything', 'Confirm, update and organize pending orders with one easy-to-use app.'],
    ['2022/10/3-5.png', 'We Market Professionally', 'We are working to acquire new customers in your market every day.'],
    ['2022/10/4-3.png', 'Marketing And Ads', 'MyPos has opened the door of massive marketing of your brands with multiple platforms, including social media, SMS, and email marketing.'],
    ['2022/10/5-3.png', 'Simple, Easy to Use Interface', 'MyPos is an intuitive, affordable, and powerful POS solution with remarkable features.'],
    ['2022/10/6-3.png', 'Add Orders, Not Tables', 'MyPos can help you increase your customer base with no upfront cost.'],
  ];
  $faqs = [
    ['Why should I resell MyPOS services?', 'It is indeed a good opportunity for you to become a MyPOS reseller it helps you accomplish your goals via shortcuts. We will be honored to help you establish your business, build your brand name and provide you complete control over the features and packaging of our product that you can offer to your target market.'],
    ['How do I start reselling with MyPOS?', 'To become a POS reseller with MyPOS, you need to activate your account or get yourself registered with MyPOS. Once you are done with it, you can go ahead and start selling up your reseller business. For further details, please contact our help representative they will be happy to help you.'],
    ['In case of any help, do MyPOS provide support to my clients?', 'When you become a MyPOS reseller it’s your responsibility to address your clients’ issues. Still, when the situation arises, when you do not have sufficient server access to check and investigate the problems. Then, our technical team will step in and do our best to help you and your clients.'],
    ['Do MyPOS have any direct or indirect contact with my clients?', 'No, they will be your clients, and we will respect your privacy. So we will not contact any of your clients at any point in time.'],
    ['Being a POS Reseller, how effective MyPOS for me?', 'If you are keen on your business’s success, then MyPOS system is the best solution that brings proficiency and profitability to your target market.'],
  ];
  // Numbered questions on screen (as on WordPress); clean question text in the FAQPage schema.
  $faqItems = collect($faqs)->map(fn ($f, $i) => ['<span><span style="color:var(--coral-deep); margin-right:12px;">' . ($i + 1) . '</span>' . e($f[0]) . '</span>', e($f[1])])->all();
  $faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqs)->map(fn ($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]])->all(),
  ];
@endphp

@push('head')
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<x-page-header title="Reseller" eyebrow="PARTNER PROGRAM" crumb="Reseller"
  lead="Become a myPOS reseller — sell a complete, proven POS solution with our engineering, support, fulfillment and marketing behind you, and earn larger commissions and residuals." :call="true">
  <div class="btn-row reveal" style="margin-top:22px;">
    <a href="#reseller-apply" class="btn btn-primary">Apply to Become a Reseller</a>
  </div>
</x-page-header>

<section id="reseller--support">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>WHY PARTNER WITH US</span></div>
      <h2>MyPos Technical Support</h2>
      <p>We have all the resources you expect, and we will help you build a more efficient and rewarding POS management system practice.</p>
      <p>We have a pre-defined reference architecture with on-demand engineering resources that allow you to actively sell the complete solution and service offerings and generate more revenue and gain a competitive industry-leading edge in the market.</p>
      <p>You don’t need to be a big business to join the program. Many of our resellers are individuals who wanted to take control of their careers. Additionally, our technical team of experts is always ready to help you and provide you with live technical support no matter where you are.</p>
      <div class="cta-inline">
        <a href="#reseller-apply" class="btn btn-primary">Join the Program</a>
        <span class="num">Give Us a Call to find out more about our Point of Sale Software. <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span>
      </div>
    </div>
    <div class="media-frame contain reveal-right">
      <img src="{{ asset('uploads/2022/10/Asset-2.png') }}" alt="Reseller — myPOS technical support for partners" width="500" height="600" loading="lazy">
    </div>
  </div>
</section>

<section id="reseller--options" style="background:var(--paper-2);">
  <div class="wrap split">
    <div class="media-frame contain reveal-left">
      <img src="{{ asset('uploads/2022/10/Asset-1-1.png') }}" alt="Reseller — partner options and commissions" width="500" height="600" loading="lazy">
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>RESELLER OPTIONS</span></div>
      <h2>We Offer More Options for MyPos Reseller:</h2>
      <div class="benefit-list" style="margin-top:28px;">
        <div class="benefit-row"><div class="bn">01</div><div><h3 style="font-size:1rem; margin-bottom:6px;">Our most popular program</h3><p>This is our most popular program. In this arrangement, you are running a business affiliated with us. You will build relationships with your clients and submit proposals and quotes directly to them. We provide support, fulfillment and shipping. However, many of our POS resellers act as the first point-of- contact for their portfolios.</p></div></div>
        <div class="benefit-row"><div class="bn">02</div><div><h3 style="font-size:1rem; margin-bottom:6px;">Larger commissions and residuals</h3><p>The compensation for each plan works a little differently. Depending on its size, each deal may pay out a different amount. Our resellers are typically submitting orders rather than leads. They have done more work to convert the sale. Additionally, they often maintain long-term relationships with clients. We will reward you for this extra work with larger commissions and residuals.</p></div></div>
      </div>
    </div>
  </div>
</section>

<section id="reseller--benefits">
  <div class="wrap">
    <div class="section-head reveal" style="max-width:860px;">
      <div class="eyebrow-line"><span class="bar"></span><span>PARTNER BENEFITS</span></div>
      <h2>MyPos Reseller Program Benefits</h2>
      <p>MyPOS is an intuitive, affordable, and powerful POS solution with remarkable features that will help your business thrive. It is an integrated system with powerful Cloud-based capabilities that proves to be a great choice to invest in.</p>
      <p>By choosing MyPos POS, You will reap many rewards like co-branded marketing, tradeshow, sponsorship, lead referrals, generate additional revenues, and saving your time and money from the headache of developing your own POS software solution. We believe in collectivism; we aim to grow your business exponentially without doing all the work yourself.</p>
    </div>
    <div class="tag-cloud reveal" style="margin-top:28px;">
      <span>Co-branded marketing</span>
      <span>Tradeshow</span>
      <span>Sponsorship</span>
      <span>Lead referrals</span>
      <span>Additional revenues</span>
    </div>
    <div class="integ-grid stagger">
      @foreach ($benefits as $i => [$img, $title, $text])
        <div class="integ-card reveal-scale" style="--i:{{ $i % 3 }}">
          <img src="{{ asset('uploads/' . $img) }}" alt="Reseller benefit — {{ $title }}" loading="lazy" style="width:56px; height:56px; object-fit:contain; margin-bottom:18px;">
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
    <div class="cta-inline">
      <a href="#reseller-apply" class="btn btn-primary">Become a Reseller</a>
      <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
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

<x-faq :items="$faqItems" :schema="false" title="Frequently Asked Questions" eyebrow="RESELLER FAQ" id="reseller-faq"
  style="background:linear-gradient(rgba(255,255,255,0.92), rgba(255,255,255,0.92)), url('{{ asset('uploads/2022/10/pane-1-bg.png') }}') center/cover no-repeat;" />

<x-contact-section id="reseller-apply" type="Sales Enquiry" eyebrow="GET STARTED TODAY"
  title="Become a myPOS reseller — Get Started Today."
  text="If you are interested in the reseller program, contact us today. We look forward to helping you get started!">
  <div class="related-links" style="margin-top:22px;">
    <a href="{{ url('/features') }}">Features</a>
    <a href="{{ url('/pricing') }}">Pricing</a>
    <a href="{{ url('/about-us') }}">About Us</a>
  </div>
</x-contact-section>
@endsection
