@php
  $reviews = \App\Models\Testimonial::pairs();
  $initials = fn ($n) => strtoupper(collect(preg_split('/\s+/', trim($n)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp
@foreach ($reviews as $i => [$name, $text])
        <figure class="review-card">
          <svg class="rv-quote" width="30" height="30" viewBox="0 0 32 32" aria-hidden="true"><path d="M13 8H6v8h5c0 3-2 5-5 5v3c5 0 9-4 9-9V8zm14 0h-7v8h5c0 3-2 5-5 5v3c5 0 9-4 9-9V8z" fill="currentColor"/></svg>
          <div class="rv-stars" role="img" aria-label="5 out of 5 stars">@for ($s = 0; $s < 5; $s++)<svg><use href="#rv-star"/></svg>@endfor</div>
          <blockquote>{{ $text }}</blockquote>
          <figcaption>
            <span class="rv-avatar">{{ $initials($name) }}</span>
            <span><b>{{ $name }}</b><small>Posted on Google</small></span>
            <svg class="rv-g"><use href="#rv-google"/></svg>
          </figcaption>
        </figure>
      @endforeach