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
      <h2 class="u-font-size-clamp-1-6r-c0329">{{ $title }}</h2>
      <p class="u-font-family-space-gr-634a3">{{ $sub }}</p>
      @foreach ($paras as $p)
        <p>{{ $p }}</p>
      @endforeach
      @if (!empty($tags))
        <div class="u-display-flex-flex-wr-93cba integ-tags">
          @foreach ($tags as $t)<span>{{ $t }}</span>@endforeach
        </div>
      @endif
      <div class="u-margin-top-28px-disp-349d1 btn-row">
        <a href="{{ url('/features') }}" class="btn btn-ghost btn-sm">See all features</a>
        <a href="{{ url('/pricing') }}" class="u-margin-top-0 link-arrow">View Standard Plan pricing →</a>
      </div>
    </div>
    @if ($reverse)
      <div class="media-frame reveal-right">
        <img src="{{ asset(ltrim($img, '/')) }}" alt="{{ $alt }}" width="{{ $w }}" height="{{ $h }}" loading="lazy">
      </div>
    @endif
  </div>
</section>
