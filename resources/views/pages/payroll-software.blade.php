@extends('layouts.app')

@section('page', 'payroll-software')
@section('title', 'Employee Payroll Management System Software Free Download')
@section('description', 'Enhance workforce efficiency with our Biometric Attendance and Payroll Management System. Top-notch payroll software in Pakistan, ensuring seamless attendance and payroll integration.')
@section('og_image', '/uploads/2018/05/mypos-pk-splash-screen-1.png')

@php
  $features = [
    ['2024/01/process_8258064-min-e1705484643889.png', 'Salary Processing', 'Automated salary calculations ensure accurate payments while reducing administrative workload for payroll staff.'],
    ['2024/01/seller_3896976-removebg-preview-min-e1705485577210.png', 'Employee Self-Service', 'Intuitive employee portal provides access to payslips, tax documents and submitting leave/expense reimbursement requests.'],
    ['2024/01/employee-data_11334320-min-e1705485876200.png', 'Role-based Access', 'Secure access ensures transparency while allowing specific payroll processing by designated staff.'],
    ['2024/01/logout_11262058-removebg-preview-min-e1705485358442.png', 'Leave & Attendance Management', 'Seamless integration with attendance data enables efficient leave allocation, encashment and payroll adjustments.'],
    ['2024/01/investors_5717588-min-e1705485711822.png', 'Bank Advice Generation', 'System enables easy creation of payment instructions for direct salary transfers into employee bank accounts.'],
    ['2024/01/analytics_7581144-min-e1705485950574.png', 'Reporting & Analytics', 'In-depth reports on salaries, allowances, deductions etc help with audits, budgeting and decision making.'],
    ['2024/01/tender_12154956-removebg-preview-min-e1705485481805.png', 'Statutory Compliance', 'Comprehensive reporting ensures legal obligations for taxes, social security and labor regulations are fully met.'],
    ['2024/01/money-management_7088842-min-e1705485773524.png', 'Customizable Pay Structures', 'Flexible pay and deduction definitions to handle multiple employee types from monthly, hourly, commission-based.'],
    ['2024/01/scale-modification_11941061-min-e1705486128219.png', 'Scalability', 'MyPOS systems seamlessly scales to manage payroll complexities of large, multi-location organizations.'],
  ];
  $shots = ['2-3-1-1440x860.png', '4-1-1-1440x860.png', '5-1-1-1440x860.png', '6-4-1440x860.png'];
@endphp

@section('content')
<x-page-header title="Payroll Management Software" eyebrow="MYPOS HR &amp; PAYROLL" crumb="Payroll Software"
  lead="MyPOS offers an integrated HR payroll management system to streamline the payroll process for businesses in Pakistan.">
  <div class="btn-row reveal" style="margin-top:26px;">
    <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
    <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
    <a href="#payroll-software--download" class="btn btn-outline">Free Download</a>
  </div>
  <div class="hero-trust">
    <div class="ht-item"><b>15,000+</b><span>Customers across Pakistan</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>4.8</b><span>Editor's rating</span></div>
    <div class="ht-sep"></div>
    <div class="ht-item"><b>24-hour</b><span>Support, always on call</span></div>
  </div>
</x-page-header>

<section id="payroll-software--overview">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="media-frame contain"><img src="{{ asset('uploads/2024/01/HR-Payroll-Management-4-min.png') }}" alt="MyPOS HR payroll management system" loading="lazy" style="height:auto;"></div>
    </div>
    <div class="reveal-right">
      <div class="eyebrow-line"><span class="bar"></span><span>HR PAYROLL</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">MyPOS HR Payroll Management System</h2>
      <p>MyPOS offers an integrated HR payroll management system to streamline the payroll process for businesses in Pakistan.</p>
      <p>By combining payroll functionalities with leave and attendance tracking, the MyPOS system aims to make payroll administration more efficient, timely, and cost-effective.</p>
      <p>As a leading provider of payroll solutions in the country, MyPOS serves clients in all major cities, including Karachi, Lahore, Gujranwala, Multan, Islamabad, and Faisalabad.</p>
      <p>Our goal is to help Pakistani companies improve workplace and business productivity through our HR payroll software.</p>
      <p>By automating and integrating key HR processes like payroll, leave, and attendance, we allow managers and employees to focus less on administrative tasks and more on strategic priorities.</p>
      <p>With features designed specifically for the Pakistani market, MyPOS strives to be an HR software partner that grows along with your organization. Our commitment is to keep innovating new ways to simplify payroll and HR management for businesses of all sizes and industries nationwide.</p>
      <div class="cta-inline"><a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a><span class="num">or call <a href="tel:{{ config('site.phone_raw') }}" style="color:inherit; text-decoration:underline;">{{ config('site.phone') }}</a></span></div>
    </div>
  </div>
</section>

<section id="payroll-software--features" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>Explore All Features</span></div>
      <h2>Key Features For HR Payroll Management System</h2>
      <p>MyPOS offers an integrated payroll management system with leave &amp; attendance tracking to simplify payroll administration for Pakistani businesses.</p>
    </div>
    <div class="feat-grid-9 stagger">
      @foreach ($features as $i => [$img, $title, $desc])
        <div class="feat-tile reveal-scale" style="--i:{{ $i }}">
          <div class="ft-icon" style="background:#fff; border:1px solid var(--paper-line);"><img src="{{ asset('uploads/' . $img) }}" alt="{{ $title }} &ndash; payroll management software" loading="lazy" style="width:28px; height:28px; object-fit:contain;"></div>
          <h3>{{ $title }}</h3>
          <p>{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="payroll-software--efficient">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>CLOUD PAYROLL</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Efficient HR Payroll Software for Seamless Business Operations</h2>
      <p>MyPOS offers a comprehensive, cloud-based payroll software specifically designed for Pakistani companies.</p>
      <ul class="check-list">
        <li>By automating complex salary calculations and integrating with attendance tracking, we ensure accurate, timely payments to employees while reducing administrative hassles.</li>
        <li>Our customizable software handles multiple pay structures and deduction rules as per Pakistan regulations.</li>
        <li>Robust reporting provides insights into payroll expenses for informed decision-making while ensuring legal compliance.</li>
        <li>Role-based access and automation promote transparency between finance teams and employees.</li>
      </ul>
      <p>With MyPOS payroll software, save time and costs while empowering employees through self-service and promoting productivity across your organization. Contact our team today to modernize operations and uncover new opportunities for your evolving business. <strong>Sign up now for a free demo.</strong></p>
      <div class="btn-row" style="margin-top:22px;">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Get Free Demo</a>
        <a href="{{ url('/employee-management') }}" class="btn btn-outline">Employee Management</a>
      </div>
    </div>
    <div class="reveal-right">
      <img src="{{ asset('uploads/2024/01/9898504-removebg-preview-min-1.png') }}" alt="Efficient HR payroll software illustration" loading="lazy" style="height:auto; object-fit:contain;">
    </div>
  </div>
</section>

<section id="payroll-software--screenshots" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>INSIDE THE SOFTWARE</span></div>
      <h2>See myPOS in action.</h2>
    </div>
    <div class="benefit-cards stagger">
      @foreach ($shots as $i => $file)
        <div class="media-frame reveal-scale" style="--i:{{ $i }}"><img src="{{ asset('uploads/2022/10/' . $file) }}" alt="myPOS payroll and HR software screenshot {{ $i + 1 }}" loading="lazy" style="height:auto; aspect-ratio:1440/860;"></div>
      @endforeach
    </div>
  </div>
</section>

<section id="payroll-software--download">
  <div class="wrap split">
    <div class="reveal-left">
      <div class="eyebrow-line"><span class="bar"></span><span>FREE DOWNLOAD</span></div>
      <h2 style="font-size:clamp(1.6rem, 2.8vw, 2.3rem); line-height:1.15;">Employee Payroll Management System Software Free Download</h2>
      <p>Enhance workforce efficiency with our Biometric Attendance and Payroll Management System. Top-notch payroll software in Pakistan, ensuring seamless attendance and payroll integration.</p>
      <div class="btn-row" style="margin-top:22px;">
        <a href="{{ url('/downloads') }}" class="btn btn-primary">Go to Downloads</a>
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-outline">Ask for a Demo</a>
      </div>
    </div>
    <div class="download-card reveal-right">
      <div style="display:flex; gap:20px; align-items:center;">
        <img src="{{ asset('uploads/2018/05/mypos-pk-splash-screen-1-246x300.png') }}" alt="myPOS software splash screen" loading="lazy" style="width:96px; height:auto; border-radius:8px; flex-shrink:0;">
        <div>
          <h3 style="font-size:1.1rem;">myPOS Payroll Management</h3>
          <p style="font-size:0.9rem; color:var(--text-mute-ink);">Editor's Rating: 4.8</p>
        </div>
      </div>
      <ul class="check-list" style="margin-top:6px;">
        <li><span><strong>Price:</strong> 2000</span></li>
        <li><span>Operating System: Windows 7</span></li>
        <li><span>Application Category: POS, Point Of Sale</span></li>
      </ul>
    </div>
  </div>
</section>

<section id="payroll-software--related" class="section-tight" style="background:var(--paper-2);">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span>RELATED</span></div>
      <h2>Explore more myPOS business software.</h2>
    </div>
    <div class="related-links reveal">
      <a href="{{ url('/employee-management') }}">Employee Management</a>
      <a href="{{ url('/accounting-software') }}">Accounting Software</a>
      <a href="{{ url('/pricing') }}">Pricing</a>
      <a href="{{ url('/downloads') }}">Downloads</a>
      <a href="{{ url('/fbr-pos-integration') }}">FBR POS Integration</a>
      <a href="{{ url('/features') }}">All Features</a>
    </div>
  </div>
</section>

<x-cta-band title="Give Us a Call to find out more about our Point of Sale Software."
  text="<a href='tel:{{ config('site.phone_raw') }}' style='color:inherit; font-weight:700;'>{{ config('site.phone') }}</a> &mdash; Call us anytime. Book a free demo of MyPOS payroll, leave and attendance management." primary="Get In Touch" />
@endsection
