{{-- Proof block shown above the demo form on sales pages: numbers, how it works, and three Google reviews. --}}
@php
    $picks = collect(config('site.reviews'))->filter(fn ($r) => mb_strlen($r[1]) > 90)->values();
    // Rotate the reviews by page so neighbouring pages don't all show the same three.
    $offset = crc32(request()->path()) % max(1, $picks->count());
    $picks = $picks->slice($offset)->concat($picks->take($offset))->take(3);
    $initials = fn ($n) => strtoupper(collect(preg_split('/\s+/', trim($n)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp
<section class="sproof">
  <div class="wrap">
    <div class="sp-stats stagger">
      <div class="sp-stat reveal-3d" style="--i:0"><b>15,000+</b><span>Businesses on myPOS</span></div>
      <div class="sp-stat reveal-3d" style="--i:1"><b>4.9<small>/5</small></b><span>Average customer rating</span></div>
      <div class="sp-stat reveal-3d" style="--i:2"><b>1–3 days</b><span>From demo to going live</span></div>
      <div class="sp-stat reveal-3d" style="--i:3"><b>&lt;2 min</b><span>Reply on phone &amp; WhatsApp</span></div>
    </div>

    <ol class="sp-steps">
      <li class="reveal-3d" style="--i:0"><span>1</span><div><b>Book a free demo</b><small>See myPOS on your own products.</small></div></li>
      <li class="reveal-3d" style="--i:1"><span>2</span><div><b>We set it up</b><small>Install, data upload, FBR / PRA &amp; training.</small></div></li>
      <li class="reveal-3d" style="--i:2"><span>3</span><div><b>Start selling</b><small>24-hour support stays on call.</small></div></li>
    </ol>

    <div class="sp-reviews">
      @foreach ($picks as $i => [$name, $text])
        <figure class="sp-review reveal-3d tilt" data-tilt style="--i:{{ $i }}">
          <div class="sp-stars" aria-label="5 out of 5 stars">★★★★★</div>
          <blockquote>{{ \Illuminate\Support\Str::limit($text, 190) }}</blockquote>
          <figcaption><span class="rv-avatar">{{ $initials($name) }}</span><span><b>{{ $name }}</b><small>Google review</small></span></figcaption>
        </figure>
      @endforeach
    </div>
  </div>
</section>
