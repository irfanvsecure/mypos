{{-- Side card inside a header dropdown. $promo = [title, text]. --}}
<aside class="dd-promo">
  <span class="ddp-tag">Free demo</span>
  <b>{{ $promo[0] }}</b>
  <p>{{ $promo[1] }}</p>
  <a href="{{ url('/contact') }}#enquiry" class="btn btn-primary btn-sm">Book a Free Demo</a>
  <a href="{{ wa_link() }}" class="ddp-wa" target="_blank" rel="noopener">or WhatsApp us →</a>
  <span class="ddp-trust"><b>15,000+</b> businesses · <b>4.9/5</b> rating</span>
</aside>
