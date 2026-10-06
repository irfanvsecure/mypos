{{--
  One content block of a Standard Plan feature page: framed image + text, side by side.
  All text is passed in from the page file.
  Params: id, img, alt, w, h, eyebrow, title, sub, paras[], reverse (text first), bg (paper-2 band), tags[] (optional chips)
--}}
@php($reverse = $reverse ?? false)
<section id="{{ $id }}" @if ($bg ?? false) class="bg-paper2" style="background:var(--paper-2);" @endif>
  <div class="wrap split">
    @unless ($reverse)
      <div class="media-frame {{ $reverse ? 'reveal-right' : 'reveal-left' }}">
        <img src="{{ asset(ltrim($img, '/')) }}" alt="{{ $alt }}" width="{{ $w }}" height="{{ $h }}" loading="lazy">
      </div>
    @endunless
    <div class="{{ $reverse ? 'reveal-left' : 'reveal-right' }}">
      <div class="eyebrow-line"><span class="bar"></span><span>{{ $eyebrow }}</span></div>
      <h2 style="font-size:clamp(1.6rem, 3vw, 2.3rem); line-height:1.15;">{{ $title }}</h2>
      <p style="font-family:'Space Grotesk',sans-serif; font-weight:600; font-size:1.1rem; color:var(--coral-deep); margin-top:10px;">{{ $sub }}</p>
      @foreach ($paras as $p)
        <p>{{ $p }}</p>
      @endforeach
      @if (!empty($tags))
        <div class="integ-tags" style="display:flex; flex-wrap:wrap; gap:8px; margin-top:22px;">
          @foreach ($tags as $t)<span>{{ $t }}</span>@endforeach
        </div>
      @endif
      <div class="btn-row" style="margin-top:28px; display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
        <a href="{{ url('/features') }}" class="btn btn-ghost btn-sm">See all features</a>
        <a href="{{ url('/pricing') }}" class="link-arrow" style="margin-top:0;">View Standard Plan pricing →</a>
      </div>
    </div>
    @if ($reverse)
      <div class="media-frame reveal-right">
        <img src="{{ asset(ltrim($img, '/')) }}" alt="{{ $alt }}" width="{{ $w }}" height="{{ $h }}" loading="lazy">
      </div>
    @endif
  </div>
</section>
