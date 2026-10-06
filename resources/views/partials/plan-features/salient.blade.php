{{--
  "Salient Feature" list shared by every Standard Plan feature page (identical on all of them in WordPress).
  Params: current (slug), optional img/alt/w/h (shows a framed image beside the list)
--}}
@php
    $salient = ['Easy to configure', 'Touch Screen Ready', 'Multi Registers', 'Customer Debit/Credit', 'Backup/Restore',
        'Bulk Upload Option', 'Barcode Printing', 'Multiple Languages', 'Supplier Management', 'Multiple Payment Option',
        'User Access Levels', 'Customizable Invoice', 'Employee Salary', 'Low Stock Alerts', 'Product Expiry Alerts', 'And much more...'];
@endphp
<section id="{{ $current }}--salient" class="section-tight" @if ($bg ?? false) style="background:var(--paper-2);" @endif>
  <div class="wrap {{ !empty($img) ? 'split' : '' }}" @if (!empty($img)) style="align-items:start;" @endif>
    @if (!empty($img))
      <div class="media-frame reveal-left">
        <img src="{{ asset(ltrim($img, '/')) }}" alt="{{ $alt }}" width="{{ $w }}" height="{{ $h }}" loading="lazy">
      </div>
    @endif
    <div>
      <div class="section-head reveal">
        <div class="eyebrow-line"><span class="bar"></span><span>INCLUDED WITH MYPOS</span></div>
        <h2>Salient Feature</h2>
      </div>
      <ul class="check-grid stagger" @if (!empty($img)) style="grid-template-columns:1fr 1fr;" @endif>
        @foreach ($salient as $i => $s)
          <li class="reveal" style="--i:{{ $i }}"><a href="{{ url('/features') }}" style="color:inherit;">{{ $s }}</a></li>
        @endforeach
      </ul>
      <div class="related-links reveal">
        <a href="{{ url('/pricing') }}">Pricing</a>
        <a href="{{ url('/one-time-pricing') }}">One-time Payment Plan</a>
        <a href="{{ url('/features') }}">All Features</a>
        <a href="{{ url('/stock-management') }}">Stock Management</a>
        <a href="{{ url('/multi-location-integration') }}">Multi-location Integration</a>
        <a href="{{ url('/downloads') }}">Free Download</a>
      </div>
    </div>
  </div>
</section>
