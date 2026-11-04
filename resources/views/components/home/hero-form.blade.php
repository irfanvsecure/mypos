@props(['types' => []])
<form class="hx-form" method="POST" action="{{ route('enquiry.store') }}#hero-demo" id="hero-demo" novalidate>
        @csrf
        <input type="hidden" name="page" value="home (hero)">
        <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="hx-form-title"><span class="pulse-dot"></span>Get a free demo on your own products</div>
        <div class="hx-form-row">
          <label class="sr-only" for="h-name">Your name</label>
          <input id="h-name" type="text" name="name" value="{{ old('name') }}" placeholder="Your name" required autocomplete="name">
          <label class="sr-only" for="h-phone">Phone / WhatsApp</label>
          <input id="h-phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel">
          <label class="sr-only" for="h-type">Business type</label>
          <select id="h-type" name="type">
            @foreach ($types as $bt)<option value="Free Demo · {{ $bt }}" @selected(old('type') === "Free Demo · $bt")>{{ $bt }}</option>@endforeach
          </select>
          <button class="btn btn-primary hx-btn" type="submit">Get My Free Demo <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        </div>
        @if ($errors->any())<p class="hx-form-err" role="alert">{{ $errors->first() }}</p>@endif
        <ul class="hx-assure">
          <li>Free version available</li><li>Works offline</li><li>Reply within minutes</li>
        </ul>
      </form>