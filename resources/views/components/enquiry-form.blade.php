@props([
    'title' => null,
    'sub' => null,
    'button' => 'Send Enquiry',
    'type' => null,   // preselected enquiry type
])
<form class="form-card" method="POST" action="{{ route('enquiry.store') }}#enquiry" id="enquiry" novalidate {{ $attributes }}>
  @csrf
  <input type="hidden" name="page" value="{{ request()->path() }}">
  <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
  @if ($title)<div class="form-title">{{ $title }}</div>@endif
  @if ($sub)<div class="form-sub">{{ $sub }}</div>@endif

  @if (session('enquiry_ok'))
    <div class="form-alert ok" role="status"><strong>Thank you!</strong> {{ session('enquiry_ok') }}</div>
  @elseif ($errors->any())
    <div class="form-alert bad" role="alert">Please check the highlighted fields and try again.</div>
  @endif

  <div class="form-row">
    <div class="field"><label for="f-name">Full name <span class="req">*</span></label>
      <input id="f-name" type="text" name="name" value="{{ old('name') }}" placeholder="Your name" required autocomplete="name">
      @error('name')<span class="err">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="f-business">Business name</label>
      <input id="f-business" type="text" name="business" value="{{ old('business') }}" placeholder="Your business" autocomplete="organization">
      @error('business')<span class="err">{{ $message }}</span>@enderror</div>
  </div>
  <div class="form-row">
    <div class="field"><label for="f-phone">Phone / WhatsApp <span class="req">*</span></label>
      <input id="f-phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel">
      @error('phone')<span class="err">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="f-email">Email</label>
      <input id="f-email" type="email" name="email" value="{{ old('email') }}" placeholder="you@business.com" autocomplete="email">
      @error('email')<span class="err">{{ $message }}</span>@enderror</div>
  </div>
  <div class="field"><label for="f-type">Enquiry type</label>
    <select id="f-type" name="type">
      @foreach (config('site.enquiry_types') as $t)
        <option @selected(old('type', $type) === $t)>{{ $t }}</option>
      @endforeach
    </select></div>
  <div class="field"><label for="f-message">Message</label>
    <textarea id="f-message" name="message" placeholder="Tell us about your business — type, number of branches, FBR/PRA requirement…">{{ old('message') }}</textarea>
    @error('message')<span class="err">{{ $message }}</span>@enderror</div>
  <button class="btn btn-primary" type="submit">{{ $button }}</button>
  <div class="form-note">We usually reply within minutes on WhatsApp · Your details are never shared.</div>
</form>
