@extends('layouts.app')

@section('page', 'security-policy')
@section('title', 'Security Policy - Free POS System - Pakistan Leading Retail, Restaurant, Salon')
@section('description', 'myPOS.pk  |  Pakistan\'s Trusted POS Software Provider')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@section('content')
<x-page-header title="Security Policy" eyebrow="LEGAL" crumb="Security Policy" lead="myPOS.pk | Pakistan’s Trusted POS Software Provider">
  <span class="legal-updated reveal">Last Reviewed: June 2026</span>
</x-page-header>

<section class="section-tight">
  <div class="wrap article-layout">
    <div>
      <article class="prose">
        <p>myPOS is committed to maintaining the confidentiality, integrity, and availability of customer information and software systems. As a provider of POS Software, Cloud and Offline POS, Inventory Management, FBR POS Integration, FBR Digital Invoicing, and Business Automation Solutions, we recognise that the data passing through our systems is central to the daily operations of the businesses we serve.</p>
        <p>This Security Policy outlines the measures myPOS takes to protect customer data, secure its software, and manage risks associated with its technology infrastructure. We ask that all customers read this policy and understand their own responsibilities in maintaining a secure operating environment.</p>
        <h2 id="purpose-of-this-policy">1. Purpose of This Policy</h2>
        <p>This Security Policy defines how myPOS approaches information security across its products, platforms, and operations. It applies to all myPOS software solutions, including cloud-based and offline POS systems, inventory and retail management tools, restaurant and salon software, pharmacy management systems, and government-integrated solutions such as FBR POS Integration and PRA Integration.</p>
        <p>The purpose of this policy is to describe the security practices in place, set expectations for our customers, and demonstrate our commitment to responsible data handling. This policy does not form a legally binding service level agreement but reflects our genuine commitment to operating securely and transparently.</p>
        <h2 id="information-security-principles">2. Information Security Principles</h2>
        <p>The myPOS security framework is guided by three core principles:</p>
        <p><strong>Confidentiality:</strong> Customer data, business records, and transaction information are treated as confidential. Access to this information is restricted to authorised personnel and is not disclosed to third parties except where required by law or necessary for service delivery.</p>
        <p><strong>Integrity:</strong> myPOS takes measures to protect the accuracy and completeness of data processed through its systems. Controls are in place to prevent unauthorised modification of records, transactions, and configuration settings.</p>
        <p><strong>Availability:</strong> We aim to maintain the availability of our software and services so that businesses can operate without unnecessary interruption. Where planned maintenance or unplanned outages occur, we work to restore services as quickly as reasonably possible.</p>
        <h2 id="data-protection-measures">3. Data Protection Measures</h2>
        <p>myPOS implements a range of controls to protect customer data within its systems:</p>
        <ul><li><strong>Access Controls:</strong> Access to internal systems and customer data is restricted based on defined roles and operational requirements.</li><li><strong>User Authentication:</strong> myPOS software requires user login credentials before granting access to business data and system functions.</li><li><strong>Role-Based Permissions:</strong> Business owners can configure different access levels for staff, ensuring employees only interact with the parts of the system relevant to their responsibilities.</li><li><strong>Password Protection:</strong> User accounts are protected by passwords. Customers are encouraged to enforce strong password practices within their organisations.</li><li><strong>Secure Data Storage:</strong> Data stored within myPOS cloud systems is maintained on hosted infrastructure with access restrictions and standard storage security practices in place.</li></ul>
        <p>myPOS does not claim to provide impenetrable or absolute security. Our controls are designed to reflect reasonable and current industry practices appropriate for business management software.</p>
        <h2 id="network-and-infrastructure-security">4. Network and Infrastructure Security</h2>
        <p>myPOS implements reasonable technical safeguards to protect the network and infrastructure supporting its cloud services. These include:</p>
        <ul><li>Firewalls to restrict unauthorised network access.</li><li>Network monitoring to detect unusual activity or potential threats.</li><li>System hardening practices to reduce unnecessary exposure.</li><li>Regular application of security updates and patches to supported systems.</li><li>Restricted administrative access limited to authorised personnel.</li></ul>
        <p>For offline POS installations, network security within the customer’s premises is the responsibility of the customer. myPOS recommends that customers secure their local networks and restrict physical access to devices running myPOS software.</p>
        <h2 id="software-security">5. Software Security</h2>
        <p>myPOS follows software development and maintenance practices aimed at reducing security vulnerabilities in its products. These practices include:</p>
        <ul><li>Internal testing procedures prior to releasing updates and new features.</li><li>Identification and remediation of known software bugs and security issues.</li><li>Release of software updates to address vulnerabilities and improve stability.</li><li>Version management to ensure customers have access to supported, up-to-date software.</li></ul>
        <p>Customers are encouraged to apply available software updates in a timely manner. Running outdated versions of any software, including myPOS, may increase exposure to known vulnerabilities that have been addressed in later releases.</p>
        <h2 id="customer-account-security">6. Customer Account Security</h2>
        <p>The security of individual business accounts depends significantly on the actions taken by the customer. Customers are responsible for:</p>
        <ul><li>Protecting login credentials and not sharing passwords with unauthorised individuals.</li><li>Managing user accounts, including removing access for staff who are no longer employed or authorised.</li><li>Restricting physical access to devices and terminals running myPOS software.</li><li>Reporting suspected unauthorised access, data breaches, or unusual system behaviour to myPOS promptly.</li></ul>
        <p>myPOS recommends that customers review active user accounts periodically and enforce strong password policies within their organisations. Failure to manage account access appropriately may expose business data to avoidable risk.</p>
        <h2 id="data-backup-and-recovery">7. Data Backup and Recovery</h2>
        <p>myPOS cloud-based solutions benefit from server-side backup procedures maintained as part of the hosting infrastructure. For offline POS installations, backup functionality may be available within the software, allowing customers to schedule regular local backups of their data.</p>
        <p>While myPOS takes reasonable steps to support data continuity, customers are strongly advised to maintain independent backups of all critical business records. This includes transaction histories, inventory data, customer records, and any other information essential to business operations. myPOS cannot guarantee complete data recovery in all circumstances, and independent backups remain the most reliable protection against data loss.</p>
        <h2 id="fbr-and-government-integrations">8. FBR and Government Integrations</h2>
        <p>myPOS supports integration with government tax systems including FBR POS Integration, FBR Digital Invoicing, and PRA Integration. These integrations allow businesses to fulfil their tax reporting obligations by transmitting data to government-operated systems.</p>
        <p>Customers should be aware that government systems such as FBR and PRA operate independently of myPOS. Their availability, security, and performance are outside our control. myPOS cannot guarantee the uptime, data handling practices, or security of any government-operated system or third-party portal.</p>
        <p><em>myPOS is not responsible for interruptions, data handling, or security incidents originating within FBR, PRA, or any other government-operated system. Customers should direct questions regarding government system security to the relevant authorities.</em></p>
        <p>myPOS will make reasonable efforts to maintain compatibility with government system requirements as they are updated, and will communicate significant changes to affected customers where possible.</p>
        <h2 id="third-party-services">9. Third-Party Services</h2>
        <p>To deliver its software and services, myPOS may engage third-party providers, which can include cloud hosting and infrastructure providers, email and communication services, and SMS notification providers. These providers are selected with regard to their reliability and maintain their own security policies and practices.</p>
        <p>myPOS does not share customer data with third parties for marketing purposes. Where third-party providers process customer data as part of service delivery, they do so within the scope of their role and in accordance with their own applicable policies. myPOS is not liable for the security practices of independent third-party providers.</p>
        <h2 id="security-incident-management">10. Security Incident Management</h2>
        <p>In the event of a suspected security incident affecting myPOS systems or customer data, our team will take reasonable steps to investigate the matter, contain and mitigate the risk, restore affected systems or services where possible, and review internal controls to reduce the likelihood of recurrence.</p>
        <p>Customers who become aware of suspected security incidents, data breaches, or unauthorised access involving their myPOS accounts should contact us immediately using the details provided in Section 15 of this policy. Prompt reporting assists in containing potential incidents and protecting affected data.</p>
        <p><em>myPOS will manage incidents with appropriate urgency and care. Notification obligations in the event of a security incident will be assessed in accordance with applicable legal requirements.</em></p>
        <h2 id="employee-and-contractor-access">11. Employee and Contractor Access</h2>
        <p>Access to myPOS internal systems, infrastructure, and customer information is restricted to employees and contractors who require that access to perform their responsibilities. Access rights are reviewed and adjusted in line with changes to roles or employment status.</p>
        <p>Staff with access to customer data are expected to handle that information with care and in accordance with myPOS’ internal policies. Access to sensitive systems is not granted by default and is subject to business justification.</p>
        <h2 id="customer-responsibilities">12. Customer Responsibilities</h2>
        <p>myPOS provides tools and controls to support a secure operating environment, but security is a shared responsibility. Customers are expected to:</p>
        <ul><li>Maintain secure, updated devices and operating systems for all terminals running myPOS software.</li><li>Install myPOS software updates as they become available.</li><li>Protect login credentials and enforce strong password practices within their organisations.</li><li>Maintain independent backups of critical business data.</li><li>Restrict access to myPOS terminals to authorised staff only.</li><li>Report any suspected security issues, unusual activity, or data concerns to myPOS promptly.</li><li>Follow general cybersecurity best practices appropriate for their business environment.</li></ul>
        <p>myPOS is not liable for security incidents that result from a customer’s failure to follow reasonable security practices or implement available updates.</p>
        <h2 id="limitations-of-security">13. Limitations of Security</h2>
        <p><em>No software, system, or security measure can guarantee complete protection against all cyber threats, unauthorised access attempts, service disruptions, hardware failures, human error, or emerging security risks. myPOS implements reasonable safeguards appropriate to its operating environment and the nature of its services, but cannot warrant that its systems will be free from all vulnerabilities or incidents at all times. Customers should operate with this understanding and take appropriate independent measures to protect their business data.</em></p>
        <h2 id="policy-updates">14. Policy Updates</h2>
        <p>myPOS may update this Security Policy from time to time to reflect changes in our practices, technology, legal requirements, or business operations. When material changes are made, we will endeavour to notify active customers through appropriate channels, such as email or an in-software notice.</p>
        <p>We encourage customers to review this policy periodically. Continued use of myPOS software following an update to this policy constitutes acceptance of the revised terms.</p>
        <h2 id="contact-information">15. Contact Information</h2>
        <p>If you have questions about this Security Policy, wish to report a security concern, or need to contact our team regarding a suspected incident, please use the following details:</p>
        <p><strong>Email:</strong> <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
        <p><strong>Phone / WhatsApp:</strong> <a href="tel:{{ config('site.phone_raw') }}">+92 322 4765528</a></p>
        <p><strong>Website:</strong> <a href="{{ url('/') }}">https://mypos.pk</a></p>
        <h2 id="our-commitment-to-security">Our Commitment to Security</h2>
        <p>Security is not a feature at myPOS. It is a responsibility we take seriously across every product we build and every customer we serve. Whether your business processes retail transactions, manages restaurant operations, runs a salon, or fulfils FBR tax reporting obligations, you can trust that myPOS is working to protect the integrity and confidentiality of your business data. We are committed to continuous improvement of our security practices and to being a reliable technology partner for businesses across Pakistan.</p>
        <p><em>myPOS.pk | <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a> | <a href="tel:{{ config('site.phone_raw') }}">+92 322 4765528</a></em></p>
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
          <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
          <a href="{{ url('/support-policy') }}">Support Policy</a>
          <a href="{{ url('/cookie-policy') }}">Cookie Policy</a>
        </nav>
      </div>
    </div>

    <aside class="article-aside hide-mobile">
      <nav class="toc" aria-label="On this page">
        <h4>ON THIS PAGE</h4>
        <a href="#purpose-of-this-policy">1. Purpose of This Policy</a>
        <a href="#information-security-principles">2. Information Security Principles</a>
        <a href="#data-protection-measures">3. Data Protection Measures</a>
        <a href="#network-and-infrastructure-security">4. Network and Infrastructure Security</a>
        <a href="#software-security">5. Software Security</a>
        <a href="#customer-account-security">6. Customer Account Security</a>
        <a href="#data-backup-and-recovery">7. Data Backup and Recovery</a>
        <a href="#fbr-and-government-integrations">8. FBR and Government Integrations</a>
        <a href="#third-party-services">9. Third-Party Services</a>
        <a href="#security-incident-management">10. Security Incident Management</a>
        <a href="#employee-and-contractor-access">11. Employee and Contractor Access</a>
        <a href="#customer-responsibilities">12. Customer Responsibilities</a>
        <a href="#limitations-of-security">13. Limitations of Security</a>
        <a href="#policy-updates">14. Policy Updates</a>
        <a href="#contact-information">15. Contact Information</a>
        <a href="#our-commitment-to-security">Our Commitment to Security</a>
      </nav>
    </aside>
  </div>
</section>
<x-cta-band title="Need a POS that stays compliant?" text="Book a free demo — we set up the software, FBR and PRA integration, and train your staff." primary="Book a Free Demo" />
@endsection
