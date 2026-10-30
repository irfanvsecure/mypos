/* Meta Pixel events for clicks, scroll depth and engaged visits. The base code, PageView, ViewContent and
   server-confirmed Lead live in resources/views/partials/meta-pixel.blade.php. No personal data is sent. */
(function(){
  if(typeof window.fbq!=='function') return;
  var page=location.pathname.replace(/^\/+|\/+$/g,'')||'home';

  function track(name, params){ window.fbq('track', name, params||{}); }
  function custom(name, params){ window.fbq('trackCustom', name, params||{}); }

  // Where on the page a link sits, so WhatsApp in the header and the floating button can be told apart.
  function placement(el){
    if(el.closest('.wa-float')) return 'floating_button';
    if(el.closest('header.site-header, .nav, nav')) return 'header';
    if(el.closest('footer')) return 'footer';
    if(el.closest('.offer-bar')) return 'offer_bar';
    var sec=el.closest('section[id], header[id], [id].hero');
    return sec ? sec.id : 'page';
  }
  function label(el){ return (el.getAttribute('aria-label')||el.textContent||'').replace(/\s+/g,' ').trim().slice(0,80); }

  // One event per action: ignore a second click on the same link within 1.5s (double-clicks, touch + click).
  var last=new WeakMap();
  function once(el){ var t=Date.now(), p=last.get(el); last.set(el,t); return !(p && t-p<1500); }

  function onClick(ev){
    var a=ev.target.closest && ev.target.closest('a[href]');
    if(!a || !once(a)) return;
    var href=a.getAttribute('href')||'', where=placement(a), base={page:page, placement:where};

    if(/wa\.me\/|api\.whatsapp\.com|whatsapp:\/\//i.test(href)){
      track('Contact',{content_name:'whatsapp', content_category:where});
      custom('WhatsAppClick',base);
    } else if(/^tel:/i.test(href)){
      track('Contact',{content_name:'phone_call', content_category:where});
      custom('CallClick',base);
    } else if(/^mailto:/i.test(href)){
      track('Contact',{content_name:'email', content_category:where});
      custom('EmailClick',base);
    } else if(/drive\.google\.com/i.test(href)){
      // Free-version / product installers are hosted on Google Drive.
      var product=a.getAttribute('data-product')||(page.indexOf('download/')===0 ? page.slice(9) : label(a));
      track('StartTrial',{content_name:'free_download', content_category:product, value:0, currency:'PKR'});
      custom('DownloadFreeVersion',{page:page, placement:where, product:product});
    } else if(/erp\.mypos\.pk\/business\/register/i.test(href)){
      track('StartTrial',{content_name:'14_day_trial', value:0, currency:'PKR'});
      custom('TrialSignupClick',base);
    } else if(/#enquiry$|#hero-demo$/.test(href) || /\bdemo\b/i.test(label(a))){
      custom('BookDemoClick',{page:page, placement:where, button:label(a)});
    }
  }
  document.addEventListener('click',onClick,true);
  // Middle-click / ctrl-click opens a new tab without a "click" on some browsers.
  document.addEventListener('auxclick',function(ev){ if(ev.button===1) onClick(ev); },true);

  // Scroll depth: 50% and 90%, once each per page view.
  var marks=[50,90], hit={};
  function onScroll(){
    var h=document.documentElement, max=h.scrollHeight-h.clientHeight;
    if(max<=0) return;
    var pct=(h.scrollTop||document.body.scrollTop)/max*100;
    marks.forEach(function(m){ if(pct>=m && !hit[m]){ hit[m]=1; custom('ScrollDepth',{page:page, percent:m}); } });
    if(hit[90]) window.removeEventListener('scroll',onScroll);
  }
  window.addEventListener('scroll',onScroll,{passive:true});

  // Engaged visitor: 60 seconds with the tab actually visible.
  var seen=0, timer=setInterval(function(){
    if(document.visibilityState!=='visible') return;
    if(++seen>=60){ clearInterval(timer); custom('EngagedVisitor',{page:page, seconds:60}); }
  },1000);
})();
