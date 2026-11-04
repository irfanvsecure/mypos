@props([
    'tone' => 'dark',
    'caption' => true,
])
@php
    $logos = \App\Models\ClientLogo::pairs('proof') ?: config('site.proof_logos');
@endphp
<div {{ $attributes->merge(['class' => 'proof-row proof-' . $tone]) }}>
  <div class="proof-logos">
    @foreach ($logos as [$logo, $name])
      <img src="{{ asset('uploads/' . $logo) }}" alt="{{ $name }}" width="84" height="52" loading="lazy">
    @endforeach
  </div>
  @if ($caption)
    <p class="proof-caption">Trusted by <strong>15,000+</strong> businesses · <strong>4.9/5</strong> rating</p>
  @endif
</div>
