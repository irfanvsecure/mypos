@props([
    'title' => 'Ready to see myPOS in action?',
    'text' => 'Book a free demo — our team will set up the right POS for your business, including FBR & PRA integration, and train your staff.',
    'primary' => 'Book a Free Demo',
    'primaryUrl' => '/contact#enquiry',
    'bg' => true,   // wrap in a paper-2 section
])
@if ($bg)<section class="section-tight bg-paper2"><div class="wrap">@endif
  <div class="cta-band reveal">
    <h2>{!! $title !!}</h2>
    <p>{!! $text !!}</p>
    <div class="btn-row" style="justify-content:center;">
      <a href="{{ url($primaryUrl) }}" class="btn btn-primary">{{ $primary }}</a>
      <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
      <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call {{ config('site.phone') }}</a>
    </div>
    {{ $slot }}
  </div>
@if ($bg)</div></section>@endif
