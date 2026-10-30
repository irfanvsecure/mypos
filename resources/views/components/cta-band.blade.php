@props([
    'title' => 'Ready to see myPOS in action?',
    'text' => 'Book a free demo — our team will set up the right POS for your business, including FBR & PRA integration, and train your staff.',
    'primary' => 'Book a Free Demo',
    'primaryUrl' => '/contact#enquiry',
    'bg' => true,   // wrap in a paper-2 section
    'form' => null, // inline demo form instead of the primary button; defaults to has_lead_form()
])
@php $form ??= has_lead_form(); @endphp
@if ($form && $bg)<x-sales-proof />@endif
@if ($bg)<section class="section-tight bg-paper2"><div class="wrap">@endif
  <div class="cta-band reveal{{ $form ? ' cta-band--form' : '' }}">
    <div class="h2">{!! $title !!}</div>
    <p>{!! $text !!}</p>
    @if ($form)
      <x-enquiry-form compact :button="$primary" />
      <div class="btn-row cta-alt">
        <span>Prefer to talk?</span>
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
        <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
      </div>
    @else
    <div class="btn-row" style="justify-content:center;">
      <a href="{{ url($primaryUrl) }}" class="btn btn-primary">{{ $primary }}</a>
      <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
    </div>
    @endif
    <x-cta-proof class="proof-center" />
    {{ $slot }}
  </div>
@if ($bg)</div></section>@endif
