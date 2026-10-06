@props([
    'eyebrow' => 'GET IN TOUCH',
    'title' => 'Request a free myPOS consultation.',
    'text' => 'Tell us about your business and requirements — our team will get back to you with the right solution, pricing and support details.',
    'type' => null,
    'id' => 'contact',
])
<section id="{{ $id }}" class="contact">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="eyebrow-line"><span class="bar"></span><span style="color:var(--coral-soft);">{{ $eyebrow }}</span></div>
      <h2>{!! $title !!}</h2>
      <p>{!! $text !!}</p>
    </div>
    <div class="contact-grid">
      <div class="reveal-left">
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 2.5c1 0 2 .3 2 1.2 0 .8-.7 1-.7 1.7 0 1.3 2.3 3.6 3.6 3.6.7 0 .9-.7 1.7-.7.9 0 1.2 1 1.2 2 0 1-1.3 2.2-2.3 2.2C6 12.5 3 9.5 2.8 7 2.7 5.9 2 4.9 2 4c0-1 .4-1.5 1-1.5z" stroke="#fff" stroke-width="1.2"/></svg></div>
          <div><div class="lbl">Phone / WhatsApp</div><div class="val"><a href="tel:{{ config('site.phone_raw') }}">{{ config('site.phone') }}</a></div></div>
        </div>
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 3l6 4.5L14 3M2 3h12v10H2V3z" stroke="#fff" stroke-width="1.3"/></svg></div>
          <div><div class="lbl">Email</div><div class="val"><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></div></div>
        </div>
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 14s5-4.2 5-8a5 5 0 10-10 0c0 3.8 5 8 5 8z" stroke="#fff" stroke-width="1.3"/><circle cx="8" cy="6" r="1.7" stroke="#fff" stroke-width="1.2"/></svg></div>
          <div><div class="lbl">Office</div><div class="val">{{ config('site.address') }}</div></div>
        </div>
        <div class="contact-info-row">
          <div class="ic"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6.2" stroke="#fff" stroke-width="1.3"/><path d="M8 4.8V8l2.2 1.4" stroke="#fff" stroke-width="1.3"/></svg></div>
          <div><div class="lbl">Support hours</div><div class="val">{{ config('site.hours') }}</div></div>
        </div>
        <div class="btn-row" style="margin-top:26px;">
          <a href="https://wa.me/{{ config('site.whatsapp') }}" class="btn btn-wa" target="_blank" rel="noopener">WhatsApp Us</a>
          <a href="tel:{{ config('site.phone_raw') }}" class="btn btn-outline">Call Now</a>
        </div>
        {{ $slot }}
      </div>
      <div class="reveal-right">
        <x-enquiry-form :type="$type" />
      </div>
    </div>
  </div>
</section>
