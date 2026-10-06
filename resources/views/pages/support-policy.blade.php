@extends('layouts.app')

@section('page', 'support-policy')
@section('title', 'Support Policy - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'Last Updated: June 22, 2026')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Support Policy" eyebrow="LEGAL" crumb="Support Policy">
  <span class="legal-updated reveal">Last Updated: June 22, 2026</span>
</x-page-header>

<section class="section-tight">
  <div class="wrap article-layout">
    <div>
      <article class="prose">
        <p>myPOS is committed to providing reliable technical support for its POS software, inventory systems, FBR integration services, and all associated products. This Support Policy outlines the scope, processes, and expectations that govern the support experience for our customers.</p>
        <h2 id="purpose-of-this-policy">1. Purpose of This Policy</h2>
        <p>This policy defines the terms under which myPOS provides technical support. It applies to all customers using myPOS software, integrations, and related services, regardless of subscription tier. It sets clear expectations for both parties and ensures support resources are used efficiently.</p>
        <h2 id="scope-of-support">2. Scope of Support</h2>
        <p>myPOS provides support for the following areas, subject to the customer’s active subscription or service agreement:</p>
        <ul><li>POS Software (Retail, Restaurant, Salon, Pharmacy, etc)</li> <li>Cloud POS Applications and offline POS systems</li> <li>FBR POS Integration and Digital Invoicing</li> <li>PRA Integration and KPRA, SBR – related configuration</li> <li>Inventory Management and Accounting modules</li> <li>Reporting and analytics tools</li> <li>User account access and permission management</li> <li>Software errors, bugs, and unexpected behaviour</li> <li>Installation assistance and initial configuration guidance</li></ul>
        <p>The level and availability of support may vary depending on the customer’s subscription plan or any separate service agreement in place.</p>
        <h2 id="support-channels">3. Support Channels</h2>
        <p>Customers may reach the myPOS support team through the following channels:</p>
        <ul><li>Email Support: For non-urgent queries, documentation requests, and follow-ups.</li> <li>Phone Support: For direct assistance during business hours.</li> <li>WhatsApp Support: For quick queries and real-time communication during business hours.</li> <li>Remote Assistance: For hands-on troubleshooting via screen-sharing tools.</li> <li>Ticket-Based Support: For tracked, documented issue resolution.</li></ul>
        <p><strong>Email:</strong> <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
        <p><strong>Phone:</strong> <a href="tel:{{ config('site.phone_raw') }}">+92 322 4765528</a></p>
        <p><strong>Website:</strong> <a href="{{ url('/') }}">https://mypos.pk</a></p>
        <h2 id="support-hours">4. Support Hours</h2>
        <p>Standard support is available during the following hours:</p>
        <ul><li>Monday to Friday: 10:00 AM – 6:00 PM (Pakistan Standard Time)</li> <li>Saturday: Limited support availability (urgent issues only)</li> <li>Sunday and Public Holidays: No standard support available</li></ul>
        <p>Support availability may be reduced or adjusted on public holidays and during special occasions. Customers will be informed of any planned changes to support hours in advance where possible.</p>
        <h2 id="response-time-targets">5. Response Time Targets</h2>
        <p>myPOS aims to respond to support requests within the following timeframes based on issue priority. These are target response times, not guaranteed resolution times. Resolution time will vary depending on the complexity of the issue.</p>
        <table>
        <thead><tr><th scope="col">Priority Level</th><th scope="col">Example Scenario</th><th scope="col">Response Target</th></tr></thead>
        <tbody>
        <tr><td><strong>Critical</strong></td><td>POS system completely down, FBR invoicing failure during active trading hours</td><td>Within 2 Hours</td></tr>
        <tr><td><strong>High</strong></td><td>Software error blocking key business functions, integration authentication failure</td><td>Within 4 Business Hours</td></tr>
        <tr><td><strong>Medium</strong></td><td>Reporting discrepancy, configuration issue, non-critical feature malfunction</td><td>Within 1 Business Day</td></tr>
        <tr><td><strong>Low</strong></td><td>General guidance, feature queries, minor UI questions</td><td>Within 2 Business Days</td></tr>
        </tbody></table>
        <p>Priority classification is determined by myPOS based on the nature and business impact of the reported issue.</p>
        <h2 id="what-is-covered">6. What Is Covered</h2>
        <p>Support includes reasonable efforts to diagnose and resolve the following:</p>
        <ul><li>Login and user access problems within the Software</li> <li>Software functionality issues and unexpected error messages</li> <li>Configuration assistance for POS terminals, printers, and peripherals</li> <li>Reporting discrepancies and data display issues</li> <li>FBR and PRA integration troubleshooting</li> <li>Software update installation and version migration assistance</li> <li>User account creation, permission management, and access control</li> <li>General guidance on using Software features correctly</li></ul>
        <h2 id="what-is-not-covered">7. What Is Not Covered</h2>
        <p>The following are outside the scope of standard support. Additional charges may apply if assistance with these areas is specifically requested:</p>
        <ul><li>Customer hardware failures, including damaged POS terminals, printers, or cash drawers</li> <li>Internet outages, slow connectivity, or ISP-related issues</li> <li>Power failures, UPS malfunctions, or electrical infrastructure problems</li> <li>Third-party software conflicts, operating system issues, or driver problems</li> <li>Virus, malware, or ransomware infections on customer devices</li> <li>Unauthorized modifications to the Software or database</li> <li>Custom code or integrations developed by the customer or a third party</li> <li>Data recovery required due to customer-initiated deletion or hardware damage</li> <li>Training beyond initial onboarding (available as a separate service)</li></ul>
        <h2 id="fbr-and-pra-integration-support">8. FBR and PRA Integration Support</h2>
        <p>myPOS assists with configuration and troubleshooting of FBR POS Integration, Digital Invoicing, and PRA Integration. Customers must be aware of the following limitations:</p>
        <ul><li>FBR, PRAL, PRA, and all associated government portals and APIs are operated independently by the respective government authorities. myPOS has no control over their uptime, performance, or availability.</li> <li>Government systems may experience outages, maintenance periods, or API failures without prior notice. myPOS cannot be held responsible for delays or failures resulting from government system unavailability.</li> <li>Regulatory requirements, invoice formats, and API specifications may change at any time. While myPOS makes reasonable efforts to update integrations promptly, immediate compliance with all regulatory changes cannot be guaranteed.</li> <li>Tax compliance, digital invoicing obligations, and regulatory filings remain the sole responsibility of the Customer.</li></ul>
        <p>myPOS cannot guarantee government API availability, portal uptime, processing times, or policy stability. Customers are advised to maintain independent records of all tax transactions and filings.</p>
        <h2 id="software-updates-and-maintenance">9. Software Updates and Maintenance</h2>
        <p>myPOS regularly releases updates covering bug fixes, security patches, performance improvements, and compliance changes. Scheduled maintenance windows will be communicated in advance where possible. Emergency security patches may be deployed without prior notice. Customers are encouraged to keep their software updated at all times.</p>
        <h2 id="remote-support-services">10. Remote Support Services</h2>
        <p>Where on-site attendance is not required or practical, myPOS support staff may use remote access or screen-sharing tools to diagnose and resolve issues. Remote support sessions will only be initiated with the Customer’s explicit consent. Customers are encouraged to supervise all remote access sessions and to revoke access immediately upon completion of the session.</p>
        <h2 id="onsite-support">11. Onsite Support</h2>
        <p>Onsite support visits may be available in certain situations where remote assistance is insufficient to resolve an issue. Onsite availability is subject to geographic location, engineer availability, and scheduling. Travel and onsite service charges may apply and will be communicated to the Customer in advance of any scheduled visit.</p>
        <h2 id="customer-responsibilities">12. Customer Responsibilities</h2>
        <p>To enable efficient and effective support, Customers are responsible for the following:</p>
        <ul><li>Maintaining a valid, active subscription or service agreement with myPOS</li> <li>Providing accurate, detailed information when raising a support request, including a clear description of the issue, screenshots where applicable, and steps to reproduce.</li> <li>Cooperating with support staff during troubleshooting, including providing timely responses to follow-up queries.</li> <li>Ensuring stable internet connectivity during remote support sessions.</li> <li>Keeping devices, operating systems, and software updated to supported versions.</li> <li>Maintaining regular backups of critical business data.</li></ul>
        <p>Delays in customer cooperation may affect resolution timelines. myPOS may close unresolved tickets where a Customer has not responded within five (5) business days of a follow-up request.</p>
        <h2 id="data-backup-responsibility">13. Data Backup Responsibility</h2>
        <p>Customers are solely responsible for maintaining regular backups of all critical business data, including sales records, inventory, and financial reports. While myPOS may provide backup tools within the Software, complete data recovery cannot be guaranteed in all situations. Customers should not rely solely on myPOS infrastructure for the preservation of essential records.</p>
        <h2 id="service-limitations">14. Service Limitations</h2>
        <p>Support is provided on a reasonable-efforts basis. myPOS does not guarantee immediate resolution of all issues, uninterrupted support availability, or error-free operation of the Software. Compatibility with all third-party hardware or software environments is not warranted. Some issues may require extended investigation or software development to resolve.</p>
        <h2 id="suspension-of-support">15. Suspension of Support</h2>
        <p>myPOS reserves the right to suspend support services in the following circumstances:</p>
        <ul><li>Non-payment of outstanding subscription or service fees.</li> <li>Abusive, threatening, or inappropriate conduct directed at support staff.</li> <li>Security concerns or suspected misuse of the Software or support channels.</li> <li>Violation of myPOS’ Terms of Service or this Support Policy.</li></ul>
        <p>Support will be reinstated once the relevant issue has been resolved to the Company’s satisfaction.</p>
        <h2 id="custom-development-support">16. Custom Development Support</h2>
        <p>Software features or modules developed specifically for a Customer under a custom development agreement may be subject to a separate support arrangement. Enhancement requests, feature additions, and workflow customizations are not treated as bug fixes and do not fall under standard support. Any additional development work required will be scoped and quoted separately.</p>
        <h2 id="policy-changes">17. Policy Changes</h2>
        <p>myPOS may update this Support Policy from time to time to reflect changes in services, operations, or regulatory requirements. The revised policy will be published on our website with an updated effective date. Continued use of myPOS services following any revision constitutes acceptance of the updated policy.</p>
        <h2 id="contact-information">18. Contact Information</h2>
        <p>To raise a support request or contact the myPOS team:</p>
        <p><strong>Email:</strong> <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
        <p><strong>Phone:</strong> <a href="tel:{{ config('site.phone_raw') }}">+92 322 4765528</a></p>
        <p><strong>Website:</strong> <a href="{{ url('/') }}">https://mypos.pk/</a><br><strong>Support:</strong> <a href="{{ url('/tickets') }}">https://mypos.pk/tickets/</a><br></p>
        <p>At myPOS, we understand that your POS system, inventory management, and FBR compliance tools are central to your daily business operations. Our support team is dedicated to helping you resolve issues quickly, maintain uninterrupted operations, and get the most from your software investment. We are committed to being a reliable technology partner for businesses across Pakistan.</p>
      </article>

      <div class="addon-card reveal" style="margin-top:56px; max-width:760px;">
        <h3>Questions about this policy?</h3>
        <p style="color:var(--text-mute-ink); margin-bottom:20px;">Our team is happy to help — call, WhatsApp or email us at <a href="mailto:{{ config('site.email') }}" style="color:var(--coral-deep);">{{ config('site.email') }}</a>.</p>
        <div class="btn-row">
          <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary btn-sm">Contact Us</a>
          <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa btn-sm" target="_blank" rel="noopener">WhatsApp</a>
          <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline btn-sm">Call {{ config('site.phone') }}</a>
        </div>
        <nav class="related-links" aria-label="Other policies">
          <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
          <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
          <a href="{{ url('/security-policy') }}">Security Policy</a>
          <a href="{{ url('/cookie-policy') }}">Cookie Policy</a>
        </nav>
      </div>
    </div>

    <aside class="article-aside hide-mobile">
      <nav class="toc" aria-label="On this page">
        <h4>ON THIS PAGE</h4>
        <a href="#purpose-of-this-policy">1. Purpose of This Policy</a>
        <a href="#scope-of-support">2. Scope of Support</a>
        <a href="#support-channels">3. Support Channels</a>
        <a href="#support-hours">4. Support Hours</a>
        <a href="#response-time-targets">5. Response Time Targets</a>
        <a href="#what-is-covered">6. What Is Covered</a>
        <a href="#what-is-not-covered">7. What Is Not Covered</a>
        <a href="#fbr-and-pra-integration-support">8. FBR and PRA Integration Support</a>
        <a href="#software-updates-and-maintenance">9. Software Updates and Maintenance</a>
        <a href="#remote-support-services">10. Remote Support Services</a>
        <a href="#onsite-support">11. Onsite Support</a>
        <a href="#customer-responsibilities">12. Customer Responsibilities</a>
        <a href="#data-backup-responsibility">13. Data Backup Responsibility</a>
        <a href="#service-limitations">14. Service Limitations</a>
        <a href="#suspension-of-support">15. Suspension of Support</a>
        <a href="#custom-development-support">16. Custom Development Support</a>
        <a href="#policy-changes">17. Policy Changes</a>
        <a href="#contact-information">18. Contact Information</a>
      </nav>
    </aside>
  </div>
</section>
@endsection
