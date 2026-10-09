@extends('layouts.app')

@section('page', 'terms-of-service')
@section('title', 'Terms of Service - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'myPOS.pk')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Terms of Service" eyebrow="LEGAL" crumb="Terms of Service">
</x-page-header>

<section class="section-tight">
  <div class="wrap article-layout">
    <div>
      <article class="prose">
        <p><a href="{{ url('/') }}"><strong>myPOS.pk</strong></a></p>
        <p>By accessing, registering for, or using any myPOS product, software, service, integration, API, or website (collectively, the “Services”), you (“Customer”) agree to these Terms of Service (“Terms”). If you do not agree, discontinue use immediately. These Terms constitute a binding agreement between the Customer and myPOS (“Company”).</p>
        <h2 id="definitions">1. Definitions</h2>
        <ul><li>Company: myPOS, its affiliates, officers, and representatives.</li> <li>Customer: Any individual or entity that registers for or uses the Services.</li> <li>User: Any individual authorized by the Customer to operate the Software.</li> <li>Software: All POS applications, cloud platforms, offline systems, mobile apps, and reporting tools provided by the Company.</li> <li>Services: All software, hosting, implementation, integration, support, and consulting provided by the Company.</li> <li>Subscription: A recurring licensing arrangement under which the Customer pays periodic fees for Software access.</li> <li>Government Integration Services: Technical facilitation of connections between Customer systems and tax or regulatory authorities.</li> <li>FBR: Federal Board of Revenue of Pakistan and its associated systems and APIs.</li> <li>PRA: Punjab Revenue Authority and its associated digital infrastructure and APIs.</li></ul>
        <h2 id="acceptance-of-terms">2. Acceptance of Terms</h2>
        <p>Use of any Software, platform, website, API, or implementation service constitutes unconditional acceptance of these Terms. If accepting on behalf of a company, you warrant that you have authority to bind that entity. These Terms supersede all prior agreements relating to the subject matter herein.</p>
        <h2 id="services-provided">3. Services Provided</h2>
        <p>myPOS offers POS Software (retail, restaurant, salon), Cloud POS, Offline POS, Inventory and Accounting Systems, FBR POS Integration, FBR Digital Invoicing, PRA Integration, Mobile Reporting, Custom Software Development, and Technical Support. The Company reserves the right to modify, add, or discontinue Services at any time. Continued use after changes constitutes acceptance.</p>
        <h2 id="account-registration-and-responsibilities">4. Account Registration and Responsibilities</h2>
        <p>Customers must provide accurate registration information and are solely responsible for maintaining the confidentiality of account credentials, restricting access to authorized personnel, all activities performed under their account, and promptly notifying the Company of any unauthorized access or security breach. The Company may suspend accounts suspected of compromise pending investigation.</p>
        <h2 id="software-license">5. Software License</h2>
        <p>Subject to these Terms and payment of applicable fees, the Company grants the Customer a limited, non-exclusive, non-transferable, revocable license to use the Software for internal business operations during the active Subscription period. Customers may not reverse engineer, decompile, resell, sublicense, copy, or use the Software for any unlawful purpose. This license terminates immediately upon Subscription expiry, non-renewal, or breach of these Terms.</p>
        <h2 id="fbr-and-pra-integration-services">6. FBR and PRA Integration Services</h2>
        <p>myPOS acts solely as a technology intermediary and does not control FBR, PRAL, PRA, or any government system. Customers must be aware that:</p>
        <ul><li>Government portals and APIs may experience downtime, outages, or failures beyond the Company’s control.</li> <li>Tax compliance obligations remain entirely the Customer’s responsibility. Integration services do not constitute tax or legal advice.</li> <li>Regulatory requirements, API specifications, and reporting formats may change without prior notice.</li> <li>Customers are solely responsible for the accuracy and completeness of all business and tax data submitted through the Software.</li></ul>
        <p>The Company shall not be liable for government system outages, API failures, policy changes, tax penalties, fines, or compliance failures arising from inaccurate or incomplete Customer data.</p>
        <h2 id="customer-obligations">7. Customer Obligations</h2>
        <p>Customers must maintain lawful business operations, comply with all applicable Pakistani tax laws, provide accurate transaction records, keep registration and business details current, and use the Software exclusively for lawful purposes. Violation of these obligations may result in suspension or termination of Services.</p>
        <h2 id="fees-and-payments">8. Fees and Payments</h2>
        <p>Services are subject to Subscription fees, one-time implementation fees, integration fees, and custom development fees as invoiced. Payments are due per invoice terms. Late payments may result in suspension of access. The Company may revise pricing with reasonable notice; continued use constitutes acceptance of revised fees.</p>
        <h2 id="refund-policy">9. Refund Policy</h2>
        <p>Subscription fees are generally non-refundable once activated. Custom development and implementation fees are non-refundable upon commencement of work. Refund requests are considered at the Company’s sole discretion unless otherwise required by applicable Pakistani law.</p>
        <h2 id="data-ownership-and-customer-data">10. Data Ownership and Customer Data</h2>
        <p>Customers retain full ownership of all business data entered into the Software. myPOS processes Customer Data solely to provide the Services and will not share it with third parties except as necessary for service delivery or as required by law. Customers are responsible for data accuracy. While the Company implements reasonable backup measures, Customers should maintain independent copies of all critical business records.</p>
        <h2 id="privacy-and-security">11. Privacy and Security</h2>
        <p>Data collection and handling are governed by the myPOS Privacy Policy, available at <a href="{{ url('/') }}">https://mypos.pk</a>. The Company implements industry-standard security measures; however, no online system can be guaranteed completely secure. myPOS shall not be liable for security incidents resulting from factors outside its reasonable control.</p>
        <h2 id="software-availability">12. Software Availability</h2>
        <p>The Company targets high availability but does not warrant uninterrupted or error-free operation. Planned maintenance and unplanned outages may occur. myPOS shall not be liable for losses caused by temporary unavailability of the Services.</p>
        <h2 id="intellectual-property-rights">13. Intellectual Property Rights</h2>
        <p>All Software, branding, logos, trademarks, documentation, and underlying technology remain the exclusive property of myPOS or its licensors. No ownership rights are transferred to Customers. Unauthorized use, reproduction, or distribution of myPOS intellectual property is strictly prohibited.</p>
        <h2 id="third-party-services">14. Third-Party Services</h2>
        <p>Certain Services involve government APIs (FBR, PRAL, PRA), cloud hosting, SMS gateways, and payment providers. myPOS does not control third-party services and is not responsible for their availability, accuracy, or performance. Customer use of third-party services may be subject to those providers’ own terms.</p>
        <h2 id="limitation-of-liability">15. Limitation of Liability</h2>
        <p>To the maximum extent permitted by Pakistani law, myPOS shall not be liable for lost profits, business interruption, data loss, tax penalties, government fines, or any indirect, incidental, consequential, or punitive damages. The Company’s total aggregate liability shall not exceed the fees paid by the Customer in the twelve (12) months preceding the claim, regardless of the form of action.</p>
        <h2 id="indemnification">16. Indemnification</h2>
        <p>The Customer agrees to indemnify and hold harmless myPOS, its affiliates, officers, and employees from all claims, damages, and costs (including legal fees) arising from: Customer misuse of the Services; illegal activity conducted through the account; inaccurate or misleading data provided to the Software; violations of Pakistani tax or regulatory law; or breach of these Terms. This obligation survives termination.</p>
        <h2 id="suspension-and-termination">17. Suspension and Termination</h2>
        <p>myPOS may suspend or terminate access for non-payment, abuse, illegal activity, security risks, or material breach of these Terms. Upon termination, the software license is immediately revoked. Customers may request a data export within thirty (30) days of termination, after which data may be deleted. Outstanding fees remain payable. Sections 13, 15, 16, and 20 survive termination.</p>
        <h2 id="modifications-to-services">18. Modifications to Services</h2>
        <p>The Company may update, modify, or discontinue any Software feature or integration at any time. Material changes will be communicated with reasonable advance notice where practicable. Continued use of the Services after modifications constitutes acceptance.</p>
        <h2 id="changes-to-terms">19. Changes to Terms</h2>
        <p>These Terms may be revised periodically. Updated Terms will be published at <a href="{{ url('/') }}">https://mypos.pk/</a> with a revised effective date. Continued use of the Services after publication of revised Terms constitutes acceptance. Customers who do not agree must discontinue use.</p>
        <h2 id="governing-law">20. Governing Law</h2>
        <p>These Terms are governed by the laws of the Islamic Republic of Pakistan. All disputes arising from or related to these Terms shall be subject to the exclusive jurisdiction of the courts of Pakistan.</p>
        <h2 id="contact-information">21. Contact Information</h2>
        <p>For questions or concerns regarding these Terms, please contact us:</p>
        <p><strong>Email:</strong> <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
        <h3>Phone: <a href="tel:{{ config('site.phone_raw') }}">+92 322 4765528</a></h3>
        <p><strong>Website:</strong> <a href="{{ url('/') }}">https://mypos.pk/</a></p>
        <p>myPOS is committed to delivering reliable, compliant, and future-ready software that empowers Pakistani businesses to grow with confidence. We value every Customer partnership and remain dedicated to providing the tools and support needed to streamline operations and meet evolving compliance standards.</p>
      </article>

      <div class="addon-card reveal" style="margin-top:56px; max-width:760px;">
        <h3>Questions about this policy?</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:20px;">Our team is happy to help — call, WhatsApp or email us at <a href="mailto:{{ config('site.email') }}" style="color:var(--coral-deep);">{{ config('site.email') }}</a>.</p>
        <div class="btn-row">
          <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary btn-sm">Contact Us</a>
          <a href="{{ wa_link() }}" class="btn btn-wa btn-sm" target="_blank" rel="noopener">WhatsApp</a>
          <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline btn-sm">Call {{ config('site.phone') }}</a>
        </div>
        <nav class="related-links" aria-label="Other policies">
          <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
          <a href="{{ url('/support-policy') }}">Support Policy</a>
          <a href="{{ url('/security-policy') }}">Security Policy</a>
          <a href="{{ url('/cookie-policy') }}">Cookie Policy</a>
        </nav>
      </div>
    </div>

    <aside class="article-aside hide-mobile">
      <nav class="toc" aria-label="On this page">
        <h4>ON THIS PAGE</h4>
        <a href="#definitions">1. Definitions</a>
        <a href="#acceptance-of-terms">2. Acceptance of Terms</a>
        <a href="#services-provided">3. Services Provided</a>
        <a href="#account-registration-and-responsibilities">4. Account Registration and Responsibilities</a>
        <a href="#software-license">5. Software License</a>
        <a href="#fbr-and-pra-integration-services">6. FBR and PRA Integration Services</a>
        <a href="#customer-obligations">7. Customer Obligations</a>
        <a href="#fees-and-payments">8. Fees and Payments</a>
        <a href="#refund-policy">9. Refund Policy</a>
        <a href="#data-ownership-and-customer-data">10. Data Ownership and Customer Data</a>
        <a href="#privacy-and-security">11. Privacy and Security</a>
        <a href="#software-availability">12. Software Availability</a>
        <a href="#intellectual-property-rights">13. Intellectual Property Rights</a>
        <a href="#third-party-services">14. Third-Party Services</a>
        <a href="#limitation-of-liability">15. Limitation of Liability</a>
        <a href="#indemnification">16. Indemnification</a>
        <a href="#suspension-and-termination">17. Suspension and Termination</a>
        <a href="#modifications-to-services">18. Modifications to Services</a>
        <a href="#changes-to-terms">19. Changes to Terms</a>
        <a href="#governing-law">20. Governing Law</a>
        <a href="#contact-information">21. Contact Information</a>
      </nav>
    </aside>
  </div>
</section>
<x-cta-band title="Need a POS that stays compliant?" text="Book a free demo — we set up the software, FBR and PRA integration, and train your staff." primary="Book a Free Demo" />
@endsection
