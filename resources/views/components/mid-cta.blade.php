@props([
    'text' => 'See it on your own counter — free demo, setup included.',
])
<section class="mid-cta">
  <div class="wrap">
    <div class="free-band">
      <div class="fb-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 16 16" fill="none"><path d="M3.5 8.4l2.9 2.9 6-6.6" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <div>
        <h3>{{ $text }}</h3>
        <p>WhatsApp reply in minutes. No obligation.</p>
      </div>
      <div class="btn-row">
        <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary">Book a Free Demo</a>
        <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp</a>
      </div>
      <x-cta-proof tone="light" />
    </div>
  </div>
</section>
