@extends('layouts.app')

@section('page', 'frequently-asked-questions')
@section('title', 'Frequently Asked Questions - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'myPOS.pk  |  Pakistan\'s Trusted POS Software Solution')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
$faqGroups = 
[
    'General Questions' => [
        ['What is myPOS.pk?', 'myPOS.pk is a Pakistan-based software company specializing in point-of-sale and business management solutions. We design, develop, and support software that helps businesses of all sizes manage sales, inventory, customers, and reporting from a single, easy-to-use platform. From single-outlet retailers to multi-branch enterprises, myPOS is built to meet the practical needs of Pakistani businesses.'],
        ['What services does myPOS provide?', 'myPOS offers a comprehensive suite of business software solutions, including POS Software, Retail and Restaurant POS, Salon and Pharmacy POS, Inventory Management, Cloud POS, Offline POS, Accounting and Reporting Systems, FBR POS Integration, FBR Digital Invoicing, PRA Integration, Multi-Branch Management, Barcode and Inventory Tracking, Customer Loyalty Solutions, and Business Automation. We also provide end-to-end technical support and staff training to ensure your team gets the most from the system.'],
        ['Which types of businesses can use myPOS?', 'myPOS is designed to serve a wide range of industries. Our software is actively used by retail stores, supermarkets, restaurants and cafes, salons and spas, pharmacies, wholesale distributors, and businesses with multiple branches. If your business involves managing sales, stock, or customer transactions, myPOS has a solution that can be tailored to your needs.'],
        ['Is myPOS available across Pakistan?', 'Yes. myPOS serves businesses across Pakistan. Whether your business is located in Karachi, Lahore, Islamabad, or any other city, our team can assist you remotely or on-site depending on your requirements. Our cloud-based options also make it easy for businesses in any location to get started quickly.'],
        ['Does myPOS provide custom software development?', 'myPOS focuses on delivering proven, feature-rich software solutions rather than fully custom development. However, we understand that every business is different, so we work closely with clients to configure and adapt the software to fit their specific workflows and operational requirements. Our team will guide you through the available options to ensure the system works the way your business works.'],
    ],
    'POS Software Questions' => [
        ['What is POS software?', 'POS stands for Point of Sale. POS software is the system businesses use to process sales transactions, manage inventory, generate receipts, and track business performance. A modern POS system like myPOS goes far beyond a simple cash register. It connects sales, stock management, customer data, and financial reporting into one centralized platform, giving business owners real-time visibility into how their business is performing.'],
        ['How does myPOS help manage sales and inventory?', 'myPOS automatically updates your inventory every time a sale is made, so you always have an accurate, real-time picture of your stock levels. You can set low-stock alerts, manage product categories, track purchase orders, and reduce the risk of overstocking or running out of key items. The sales management features allow you to process transactions quickly, apply discounts, manage different payment methods, and generate end-of-day summaries without manual effort.'],
        ['Can I manage multiple branches from one system?', 'Yes. myPOS includes a dedicated Multi-Branch Management module that allows you to oversee all your locations from a single dashboard. You can monitor sales, stock levels, and staff performance across branches in real time, transfer inventory between locations, and generate consolidated reports for your entire business. This makes myPOS a practical choice for growing businesses that operate more than one outlet.'],
        ['Does myPOS support multiple users and access levels?', 'Absolutely. myPOS allows you to create multiple user accounts, each with its own defined role and permission level. For example, a cashier may only access the billing screen, while a manager can view reports and adjust pricing. This keeps your data secure and ensures that staff members only interact with the parts of the system relevant to their responsibilities.'],
        ['Does myPOS provide reports and business analytics?', 'Yes. myPOS includes a built-in Accounting and Reporting System that gives you access to daily sales summaries, inventory reports, profit and loss overviews, customer purchase history, and staff performance data. These reports are available on demand and can help you make informed decisions about pricing, purchasing, and business growth without needing a separate accounting tool.'],
        ['Does myPOS support barcode scanning?', 'Yes. myPOS fully supports barcode scanning as part of its Barcode and Inventory Tracking solution. You can scan barcodes to add products to a sale, look up stock information, or update inventory records. This speeds up the checkout process significantly and reduces the chance of manual entry errors, which is especially valuable for retail stores and pharmacies managing large product catalogues.'],
    ],
    'Cloud and Offline Software' => [
        ['What is the difference between cloud and offline POS software?', 'Cloud POS software stores your data on secure remote servers and can be accessed from any device with an internet connection. Offline POS software stores data locally on your hardware and does not require a constant internet connection to operate. Both options have advantages, and the right choice depends on your business environment, internet reliability, and how you prefer to access your data.'],
        ['Does myPOS offer cloud-based software?', 'Yes. myPOS offers a Cloud POS solution that lets you access your sales data, inventory, and reports from anywhere with an internet connection. This is ideal for business owners who need to monitor operations remotely or manage multiple branches from different locations. Cloud-based systems also make it easier to keep your software updated without manual installations.'],
        ['Does myPOS offer offline software?', 'Yes. myPOS also provides an Offline POS option that operates fully without internet access. All transactions and data are stored locally, ensuring your business continues running smoothly regardless of connectivity. This option is well-suited for businesses in areas with inconsistent internet service or for operations that require guaranteed uptime.'],
        ['Can I continue billing if the internet goes down?', 'Yes. With myPOS Offline POS, your billing and transaction processing will continue uninterrupted even if your internet connection is unavailable. Once the connection is restored, data is synchronized automatically. This ensures your business operations are never dependent on internet availability for day-to-day sales.'],
        ['Which option is better for my business?', 'The best option depends on your specific situation. If you have reliable internet access and need to manage your business from multiple locations or devices, the Cloud POS is a strong choice. If your business operates in an area with connectivity challenges or you prefer local data storage, the Offline POS may be more suitable. Our team can help you evaluate both options during your consultation and recommend what fits your needs best.'],
    ],
    'FBR POS Integration' => [
        ['What is FBR POS Integration?', 'FBR POS Integration refers to the connection between your point-of-sale system and the Federal Board of Revenue (FBR) of Pakistan. Through this integration, businesses are required to report their sales transactions directly to FBR in real time. The goal is to improve tax transparency and bring more businesses into the formal economy. Businesses that meet certain revenue thresholds are legally required to integrate their POS with FBR.'],
        ['Which businesses require FBR POS Integration?', 'FBR POS Integration is currently mandated for Tier-1 retailers in Pakistan, which generally includes businesses operating in large shopping malls, retail chains, and high-turnover commercial outlets. FBR regularly updates its requirements and expands the list of businesses that must comply. If you are unsure whether your business is required to integrate, myPOS can help you assess your obligations and guide you through the process.'],
        ['How does myPOS help with FBR POS Integration?', 'myPOS is built with FBR POS Integration support included. Our software connects your POS system to FBR’s servers, ensuring that your sales data is reported accurately and in the required format. We handle the technical setup, configure the integration within your existing workflow, and provide guidance on maintaining compliance as your business grows. Our team stays up to date with FBR requirements so you do not have to.'],
        ['What information is required for FBR integration?', 'To set up FBR POS Integration, you will typically need your business National Tax Number (NTN), STRN (Sales Tax Registration Number) if applicable, and access to your FBR portal account. myPOS will guide you through the registration steps and coordinate the technical configuration from our end. The exact requirements may vary depending on your business category and FBR’s current guidelines.'],
        ['What happens if FBR services are temporarily unavailable?', 'myPOS is designed to handle FBR service interruptions gracefully. If FBR servers are temporarily unavailable, the system queues the transaction data and automatically syncs it once connectivity with FBR is restored. Your billing operations continue without interruption, and no transaction data is lost during the downtime.'],
    ],
    'FBR Digital Invoicing' => [
        ['What is FBR Digital Invoicing?', 'FBR Digital Invoicing is a separate but related initiative under which businesses generate and submit sales invoices electronically through FBR’s integrated system. Unlike traditional paper-based invoicing, digital invoices are issued in a standardized electronic format and are visible to both the seller and FBR. This initiative supports the broader goal of improving tax compliance and reducing undocumented transactions in Pakistan.'],
        ['How does myPOS support Digital Invoicing?', 'myPOS supports FBR Digital Invoicing by generating compliant electronic invoices directly from the billing screen. When a sale is processed, the system formats the invoice according to FBR requirements and submits it through the appropriate channel. This means your staff does not need to handle the compliance process manually. Everything is handled within the normal billing workflow, keeping operations efficient and accurate.'],
        ['Does Digital Invoicing replace my current billing process?', 'No. FBR Digital Invoicing works alongside your existing billing process rather than replacing it. myPOS integrates the digital invoicing requirement into your regular sales flow so that every eligible transaction automatically generates a compliant digital invoice. Your customers still receive their standard receipts, and your internal records remain consistent with what has been submitted to FBR.'],
    ],
    'Pricing and Implementation' => [
        ['How much does myPOS software cost?', 'Pricing for myPOS depends on the type of solution you need, the number of branches or users, and the features included. We offer flexible pricing structures to suit businesses at different stages of growth. To get an accurate quote tailored to your requirements, we recommend reaching out to our team for a consultation. We will walk you through the available options and help you find a plan that fits your budget.'],
        ['Are monthly subscription plans available?', 'Yes. myPOS offers subscription-based pricing plans so that businesses can access the software without a large upfront investment. Subscription plans typically include software updates, cloud access (for cloud-based plans), and technical support. Our team can provide full details on available plans and what each one includes during your consultation.'],
        ['Is implementation and training included?', 'Yes. myPOS includes implementation assistance and staff training as part of the onboarding process. Our team will set up the system, configure it according to your business requirements, and train your staff on how to use it effectively. We understand that getting your team up to speed quickly is important, and we take that responsibility seriously.'],
        ['Can existing business data be imported?', 'In most cases, yes. If you have existing product lists, customer data, or inventory records in a structured format such as a spreadsheet, our team can assist you with importing that data into myPOS. This saves significant time compared to manual data entry and helps you get operational quickly without starting from scratch.'],
        ['What hardware is compatible with myPOS?', 'myPOS is compatible with a range of standard business hardware, including POS terminals, receipt printers, barcode scanners, cash drawers, and customer-facing displays. The software can run on Windows-based computers and selected tablets. Our team can advise you on compatible hardware configurations during setup and help ensure your existing equipment works seamlessly with the system.'],
    ],
    'Support and Security' => [
        ['What support options are available?', 'myPOS provides dedicated technical support and training to all clients. Support is available through phone, email, and remote assistance, depending on your plan and requirements. Our support team is familiar with the day-to-day challenges Pakistani businesses face with POS systems, FBR compliance, and business automation, so you can expect informed and practical help when you need it.'],
        ['Is remote support available?', 'Yes. myPOS offers remote support, which allows our technical team to assist you without needing to visit your premises. Using remote access tools, we can diagnose issues, make configuration adjustments, and guide your staff through problems quickly and efficiently. This is particularly useful for resolving time-sensitive issues during business hours.'],
        ['How secure is my business data?', 'Data security is a priority at myPOS. For cloud-based solutions, your data is stored on secure servers with access controls and regular security practices in place. For offline installations, data is stored on your local hardware and protected by user authentication. User access levels within the software ensure that sensitive information is only accessible to authorized personnel.'],
        ['Are backups available?', 'Yes. myPOS supports data backups to protect your business information. Cloud-based plans benefit from automatic server-side backups. For offline installations, the system supports scheduled local backups, and our team can advise you on best practices for maintaining regular backup routines. We recommend discussing your backup requirements with our team during implementation.'],
        ['How do I contact support?', 'You can contact the myPOS support team through the contact information available on our website at mypos.pk. Our team is available during business hours and can assist you with technical issues, billing questions, FBR compliance queries, or any other matter related to your software. For urgent issues, we recommend calling directly for the fastest response.'],
    ],
    'Getting Started' => [
        ['How do I request a demo or get started with myPOS?', 'Getting started with myPOS is straightforward. Visit mypos.pk and use the contact form or phone number to reach our sales team. During your initial consultation, we will learn about your business, discuss the right solution for your needs, and walk you through a live demonstration of the software. There is no obligation, and our team is happy to answer any questions before you make a decision.'],
    ],
];
$topicIds = [
    'General Questions' => 'general',
    'POS Software Questions' => 'pos-software',
    'Cloud and Offline Software' => 'cloud-offline',
    'FBR POS Integration' => 'fbr-pos-integration',
    'FBR Digital Invoicing' => 'fbr-digital-invoicing',
    'Pricing and Implementation' => 'pricing-implementation',
    'Support and Security' => 'support-security',
    'Getting Started' => 'getting-started',
];
$faqSchema = [
    '@' . 'context' => 'https://schema.org',
    '@' . 'type' => 'FAQPage',
    'mainEntity' => collect($faqGroups)->flatten(1)->map(fn ($f) => [
        '@' . 'type' => 'Question',
        'name' => $f[0],
        'acceptedAnswer' => ['@' . 'type' => 'Answer', 'text' => $f[1]],
    ])->values()->all(),
];
$plus = '<span class="plus"></span>';
@endphp

@push('head')
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<x-page-header title="Frequently Asked Questions" crumb="FAQ" eyebrow="HELP CENTRE"
  lead="Whether you are exploring myPOS for the first time or evaluating a switch from your current system, this FAQ is here to help." :call="true">
  <p class="reveal" style="margin-top:14px; color:var(--text-mute-on-dark); font-style:italic;">myPOS.pk | Pakistan’s Trusted POS Software Solution</p>
</x-page-header>

<section id="faq">
  <div class="wrap article-layout">
    <div>
      <div class="section-head reveal" style="max-width:760px;">
        <div class="eyebrow-line"><span class="bar"></span><span>{{ collect($faqGroups)->flatten(1)->count() }} ANSWERS · {{ count($faqGroups) }} TOPICS</span></div>
        <h2>Answers about myPOS, FBR compliance, pricing &amp; support.</h2>
        <p>Below you will find clear answers about our POS software, FBR POS Integration, Digital Invoicing, cloud and offline options, pricing, implementation, and ongoing support. If you have a question that is not covered here, our team is always available to assist.</p>
      </div>

      @foreach ($faqGroups as $topic => $items)
        <div id="{{ $topicIds[$topic] }}" class="reveal" style="margin-top:{{ $loop->first ? '48px' : '64px' }}; scroll-margin-top:110px;">
          <div class="eyebrow-line"><span class="bar"></span><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ str_pad(count($faqGroups), 2, '0', STR_PAD_LEFT) }}</span></div>
          <h2 style="font-size:clamp(1.35rem,2.4vw,1.75rem); margin-bottom:18px;">{{ $topic }}</h2>
          <div class="faq-list">
            @foreach ($items as $i => [$q, $a])
              <div class="faq-item {{ $loop->parent->first && $i === 0 ? 'open' : '' }}">
                <button class="faq-q" type="button">{{ $q }}{!! $plus !!}</button>
                <div class="faq-a"><p>{{ $a }}</p></div>
              </div>
            @endforeach
          </div>
        </div>

        @if ($topic === 'FBR Digital Invoicing')
          <div class="cta-band reveal" style="margin-top:64px;">
            <h2>Need help with FBR or PRA compliance?</h2>
            <p>Our team handles the technical setup, configures the integration within your existing workflow and trains your staff.</p>
            <div class="btn-row" style="justify-content:center;">
              <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
              <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
            </div>
          </div>
        @endif
      @endforeach

      <div class="related-links reveal" style="margin-top:48px;">
        <a href="{{ url('/support') }}">Support</a>
        <a href="{{ url('/pricing') }}">Pricing</a>
        <a href="{{ url('/features') }}">Features</a>
        <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
        <a href="{{ url('/fbr-digital-invoicing') }}">FBR Digital Invoicing</a>
        <a href="{{ url('/downloads') }}">Free Downloads</a>
      </div>
    </div>

    <aside class="article-aside">
      <nav class="toc" aria-label="FAQ topics">
        <h4>FAQ TOPICS</h4>
        @foreach ($faqGroups as $topic => $items)
          <a href="#{{ $topicIds[$topic] }}">{{ $topic }} <span style="color:var(--text-mute-ink);">({{ count($items) }})</span></a>
        @endforeach
      </nav>
      <div class="aside-cta">
        <h4>Still have a question?</h4>
        <p>Talk to a myPOS expert — 15,000+ customers, rated 4.9/5, replies in under 2 minutes on WhatsApp.</p>
        <a href="{{ wa_link() }}" class="btn btn-wa btn-sm" target="_blank" rel="noopener">WhatsApp Us</a>
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline btn-sm" style="border-color:rgba(255,255,255,0.35); color:var(--text-on-dark);">Call {{ config('site.phone') }}</a>
        <a href="{{ url('/tickets') }}" class="btn btn-primary btn-sm">Open a Support Ticket</a>
      </div>
    </aside>
  </div>
</section>

<x-cta-band title="Ready to Transform Your Business?"
  text="Contact myPOS today for a free consultation and live demo. Our team will help you find the right POS solution for your business, walk you through FBR compliance requirements, and ensure a smooth implementation from day one."
  primary="Get Free Consultation" />
@endsection
