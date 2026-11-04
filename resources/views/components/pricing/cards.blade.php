@props(['group'])
@foreach (\App\Models\PricingPlan::shown($group)->get() as $i => $plan)
      <div class="price-card{{ $plan->is_featured ? ' featured' : '' }} reveal-scale" style="--i:{{ $i }}">
        <div class="pc-badge">{{ $plan->badge }}</div>
        <div class="h3">{{ $plan->name }}</div>
        <div class="pc-price">{{ $plan->price_label }}</div>
        <div class="pc-sub">{{ $plan->subtitle }}</div>
        <ul>
@foreach ($plan->features ?? [] as $feature)
          <li><svg width="16" height="16" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8.5" stroke="currentColor"/><path d="M5 9.2L7.7 12L13 6" stroke="currentColor" stroke-width="1.6"/></svg>{!! $feature !!}</li>
@endforeach
        </ul>
        <a href="{!! attr_url($plan->cta_url) !!}"@if ($plan->cta_new_tab) target="_blank" rel="noopener"@endif class="btn {{ $plan->cta_style }}">{{ $plan->cta_label }}</a>
      </div>{!! $loop->last ? '' : "\n" !!}@endforeach
