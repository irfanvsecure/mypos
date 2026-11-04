@props(['types' => [], 'addons' => null])
@php
    // Prices come from pricing_plans (single source): the monthly plan, the RetailPro one-time licences and the add-ons.
    $addons ??= \App\Models\PricingPlan::shown('addons')->get()->map(fn ($a) => [$a->extra['key'] ?? $a->plan_key, $a->name, (int) $a->price_pkr])->all();
    $monthly = \App\Models\PricingPlan::price('retailpro-monthly');
    $basic = \App\Models\PricingPlan::price('retailpro-onetime-basic');
    $standard = \App\Models\PricingPlan::price('retailpro-onetime-standard');
@endphp
<form class="bld reveal-3d" method="POST" action="{{ route('enquiry.store') }}#builder" data-builder data-monthly="{{ (int) $monthly }}" data-onetime-basic="{{ (int) $basic }}" data-onetime-standard="{{ (int) $standard }}" novalidate>
      @csrf
      <input type="hidden" name="page" value="home (price builder)">
      <input type="hidden" name="type" value="Price Builder">
      <input type="hidden" name="message" data-bld-message>
      <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <ol class="bld-steps" aria-hidden="true"><li class="on">Business</li><li>Branches</li><li>Plan</li><li>Modules</li><li>Your price</li></ol>

      <fieldset class="bld-step on" data-step="0">
        <legend>What kind of business is it?</legend>
        <div class="bld-chips">
          @foreach ($types as $i => $bt)
            <label class="bld-chip"><input type="radio" name="bld_business" value="{{ $bt }}" @checked($i === 0)><span>{{ $bt }}</span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="1">
        <legend>How many branches?</legend>
        <div class="bld-chips">
          @foreach (['1' => '1 branch', '2-3' => '2–3 branches', '4-10' => '4–10 branches', '10+' => '10+ branches'] as $v => $l)
            <label class="bld-chip"><input type="radio" name="bld_branches" value="{{ $v }}" @checked($v === '1')><span>{{ $l }}</span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="2">
        <legend>How would you like to pay?</legend>
        <div class="bld-chips bld-chips--big">
          <label class="bld-chip"><input type="radio" name="bld_plan" value="monthly" checked><span><b>Monthly</b><small>Rs {{ number_format($monthly) }}/month · 14 days free</small></span></label>
          <label class="bld-chip"><input type="radio" name="bld_plan" value="onetime"><span><b>One-time licence</b><small>From Rs {{ number_format($basic) }}, pay once</small></span></label>
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="3">
        <legend>Which add-ons do you need? <small>(optional)</small></legend>
        <div class="bld-chips bld-chips--mods">
          @foreach ($addons as [$key, $name, $price])
            <label class="bld-chip"><input type="checkbox" name="bld_mod" value="{{ $key }}" data-name="{{ $name }}" data-price="{{ $price }}"><span>{{ $name }} <small>+Rs {{ number_format($price) }}/mo</small></span></label>
          @endforeach
        </div>
      </fieldset>
      <fieldset class="bld-step" data-step="4">
        <legend>Your estimated price</legend>
        <div class="bld-result">
          <div class="bld-price" aria-live="polite"><span data-bld-price>Rs {{ number_format($monthly) }}</span><small data-bld-per>/month</small></div>
          <p class="bld-plan" data-bld-plan>Standard monthly plan · first 14 days free</p>
          <ul class="bld-summary" data-bld-summary></ul>
        </div>
        <div class="bld-contact">
          <p>Get this exact quote and a free demo — we'll confirm on WhatsApp.</p>
          <div class="form-row">
            <div class="field"><label for="b-name">Full name <span class="req">*</span></label><input id="b-name" type="text" name="name" placeholder="Your name" required autocomplete="name"></div>
            <div class="field"><label for="b-phone">Phone / WhatsApp <span class="req">*</span></label><input id="b-phone" type="tel" name="phone" placeholder="03XX XXXXXXX" required autocomplete="tel" inputmode="tel"></div>
          </div>
          <div class="btn-row">
            <button class="btn btn-primary" type="submit">Send me this quote</button>
            <a href="{{ wa_link() }}" class="btn btn-wa" target="_blank" rel="noopener" data-bld-wa>Or send on WhatsApp</a>
          </div>
        </div>
      </fieldset>

      <div class="bld-nav">
        <button type="button" class="btn btn-ghost" data-bld-back hidden>← Back</button>
        <button type="button" class="btn btn-primary" data-bld-next>Next →</button>
      </div>
      <p class="bld-note">Prices from our pricing pages. Multi-branch and FBR setups on a one-time licence are quoted individually.</p>
    </form>