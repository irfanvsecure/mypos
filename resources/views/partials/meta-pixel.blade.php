{{--
  Meta Pixel base code: PageView on every page, ViewContent on product/industry/pricing pages,
  and any server-confirmed events flashed as session('pixel_events') (e.g. Lead after an enquiry is saved).
  Click, scroll and engagement events live in public/js/pixel-events.js.
--}}
@php
    $path = trim(request()->path(), '/');
    $viewCategory = match (true) {
        $path === '' || $path === 'thank-you' => null,
        in_array($path, ['contact', 'about-us', 'reseller', 'tickets', 'support', 'on-call-support', 'cookie-policy', 'privacy-policy', 'security-policy', 'support-policy', 'terms-of-service', 'frequently-asked-questions', 'customers', 'clients', 'blogs'], true) => null,
        str_contains($path, 'pricing') => 'pricing',
        $path === 'downloads' || str_starts_with($path, 'download/') => 'download',
        str_starts_with($path, 'portfolio-item/') => 'client_story',
        str_contains($path, 'fbr') || str_contains($path, 'pra') || str_contains($path, 'srb') || str_contains($path, 'kpra') || str_contains($path, 'invoicing') => 'tax_integration',
        default => 'product',
    };
    // A view can set its own category, e.g. @section('pixel_category', 'blog') on blog posts.
    if (trim($__env->yieldContent('pixel_category')) !== '') {
        $viewCategory = trim($__env->yieldContent('pixel_category'));
    }
    $viewName = trim(preg_replace('/\s*[—|-]\s*myPOS.*$/u', '', html_entity_decode(trim($__env->yieldContent('title')) ?: $path, ENT_QUOTES)));
    $pixelEvents = collect(session('pixel_events', []))->filter(fn ($e) => is_array($e) && ! empty($e['name']))->values();
@endphp
<!-- Meta Pixel Code -->
<script>
@if ($pixelMode === 'live')
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
@else
// Debug mode (not a production host): nothing is sent to Meta, every call is logged instead.
window.__pixelLog=[];
window.fbq=function(){ var a=JSON.stringify([].slice.call(arguments)); window.__pixelLog.push(a); console.info('[Meta Pixel debug] '+a); };
@endif
fbq('init', @json($pixelId));
fbq('track', 'PageView');
@if ($viewCategory)
fbq('track', 'ViewContent', @json(['content_name' => $viewName, 'content_category' => $viewCategory, 'content_type' => 'product']));
@endif
@foreach ($pixelEvents as $event)
fbq('track', @json($event['name']), @json((object) ($event['params'] ?? [])){!! ! empty($event['event_id']) ? ', ' . json_encode(['eventID' => $event['event_id']]) : '' !!});
@endforeach
</script>
@if ($pixelMode === 'live')
<noscript><img height="1" width="1" style="display:none" alt=""
src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"
/></noscript>
@endif
<!-- End Meta Pixel Code -->
