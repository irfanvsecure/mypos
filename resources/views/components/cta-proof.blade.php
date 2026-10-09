@props([
    'tone' => 'dark',
    'caption' => true,
])
@php
    $logos = [
        ['2026/07/mitti-di-handi-logo-revise.jpeg', 'Mitti Di Handi'],
        ['2026/07/meadows-grammar-school-logo-revise.jpeg', 'Meadows Grammar School'],
        ['2026/07/hyundai-blue-logo-revise.jpeg', 'Hyundai'],
        ['2026/07/snt-foods-logo-revise.jpeg', 'SNT Foods'],
        ['2026/07/chemcos-logo-revise.jpeg', 'Chemcos'],
    ];
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
