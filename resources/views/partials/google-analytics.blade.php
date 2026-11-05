{{-- Google Analytics 4. Only on the hosts in services.google_analytics.hosts, so local visits are never counted. --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', @json($gaId));
</script>
