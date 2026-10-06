(function(){
  var pages={};
  document.querySelectorAll('.pg').forEach(function(p){pages[p.dataset.page]=p;});
  var navEl=document.querySelector('.nav');

  var io=new IntersectionObserver(function(entries){
    entries.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target);} });
  },{threshold:0.18});

  var counted=new Set();
  var statIo=new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting && !counted.has(e.target)){
        counted.add(e.target);
        var el=e.target;
        if(el.dataset.count){
          var target=parseInt(el.dataset.count,10),cur=0,step=Math.ceil(target/60);
          var t=setInterval(function(){cur+=step; if(cur>=target){cur=target;clearInterval(t);} el.textContent=cur.toLocaleString()+"+";},20);
        } else if(el.dataset.decimal){
          var tg=parseFloat(el.dataset.decimal),c=0;
          var t2=setInterval(function(){c+=0.1; if(c>=tg){c=tg;clearInterval(t2);} el.textContent=c.toFixed(1);},40);
        }
      }
    });
  },{threshold:0.5});

  function observe(root){
    root.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(function(el){ if(!el.classList.contains('in')) io.observe(el); });
    root.querySelectorAll('.num[data-count],.num[data-decimal]').forEach(function(el){ statIo.observe(el); });
  }
  function fixFaq(root){
    root.querySelectorAll('.faq-item').forEach(function(i){
      var a=i.querySelector('.faq-a'); if(!a) return;
      a.style.maxHeight = i.classList.contains('open') ? a.scrollHeight+'px' : null;
    });
  }

  /* FAQ accordion (scoped to its own list) */
  document.addEventListener('click',function(ev){
    var btn=ev.target.closest('.faq-q'); if(!btn) return;
    var item=btn.parentElement, list=item.parentElement, answer=item.querySelector('.faq-a');
    var wasOpen=item.classList.contains('open');
    list.querySelectorAll('.faq-item').forEach(function(i){ i.classList.remove('open'); var a=i.querySelector('.faq-a'); if(a) a.style.maxHeight=null; });
    if(!wasOpen){ item.classList.add('open'); answer.style.maxHeight=answer.scrollHeight+'px'; }
  });

  /* Homepage device tabs */
  var tabData={
    desktop:{title:"Full sales terminal, offline-ready", desc:"Ring up items, split payments, apply discounts and print or send receipts \u2014 even mid-outage. Every FBR invoice files itself the moment you're back online."},
    mobile:{title:"Check every branch from your pocket", desc:"See today's sales, top-performing branches, low-stock alerts and pending approvals \u2014 wherever you are."},
    cloud:{title:"One dashboard, every location", desc:"Consolidated inventory, staff access levels and full sync status across all your branches, live."}
  };
  document.querySelectorAll('.tab-btn').forEach(function(btn){
    btn.addEventListener('click',function(){
      document.querySelectorAll('.tab-btn').forEach(function(b){b.classList.remove('active');});
      btn.classList.add('active');
      var key=btn.dataset.tab;
      document.querySelectorAll('.device-panel').forEach(function(p){p.classList.remove('active');});
      document.querySelector('.device-panel[data-panel="'+key+'"]').classList.add('active');
      document.getElementById('tabTitle').textContent=tabData[key].title;
      document.getElementById('tabDesc').textContent=tabData[key].desc;
    });
  });

  /* Generic tabs: [data-tabs] > [role=tab][data-tab-target] + [role=tabpanel] */
  document.querySelectorAll('[data-tabs]').forEach(function(box){
    var tabs=[].slice.call(box.querySelectorAll('[data-tab-target]'));
    function select(tab, focus){
      tabs.forEach(function(t){
        var on=t===tab, panel=document.getElementById(t.dataset.tabTarget);
        t.classList.toggle('active',on); t.setAttribute('aria-selected',on?'true':'false'); t.tabIndex=on?0:-1;
        if(panel){ panel.hidden=!on; panel.classList.toggle('active',on); }
      });
      if(focus) tab.focus();
      tab.scrollIntoView({block:'nearest',inline:'nearest'});
    }
    tabs.forEach(function(t,i){
      t.tabIndex=t.classList.contains('active')?0:-1;
      t.addEventListener('click',function(){ select(t); });
      t.addEventListener('keydown',function(e){
        var k=e.key, n=null;
        if(k==='ArrowDown'||k==='ArrowRight') n=tabs[(i+1)%tabs.length];
        if(k==='ArrowUp'||k==='ArrowLeft') n=tabs[(i-1+tabs.length)%tabs.length];
        if(n){ e.preventDefault(); select(n,true); }
      });
    });
  });

  /* Review slider arrows */
  var rvTrack=document.querySelector('[data-rv-track]');
  if(rvTrack){
    var prev=document.querySelector('[data-rv-prev]'), next=document.querySelector('[data-rv-next]');
    function step(){ var c=rvTrack.querySelector('.review-card'); return c ? c.getBoundingClientRect().width+20 : rvTrack.clientWidth; }
    function sync(){
      if(!prev) return;
      prev.disabled=rvTrack.scrollLeft<=4;
      next.disabled=rvTrack.scrollLeft+rvTrack.clientWidth>=rvTrack.scrollWidth-4;
    }
    if(prev) prev.addEventListener('click',function(){ rvTrack.scrollBy({left:-step()}); });
    if(next) next.addEventListener('click',function(){ rvTrack.scrollBy({left:step()}); });
    rvTrack.addEventListener('scroll',function(){ window.requestAnimationFrame(sync); },{passive:true});
    window.addEventListener('resize',sync);
    sync();
  }

  /* Mobile menu */
  var toggle=document.querySelector('.nav-toggle');
  if(toggle){
    toggle.addEventListener('click',function(){
      var open=document.body.classList.toggle('nav-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.querySelectorAll('.mobile-menu a').forEach(function(a){
      a.addEventListener('click',function(){ document.body.classList.remove('nav-open'); toggle.setAttribute('aria-expanded','false'); });
    });
  }

  /* Page init: each Laravel route renders one .pg; #section scrolls under the sticky nav */
  var current=document.querySelector('.pg');
  function scrollToHash(smooth){
    var sec=location.hash.replace(/^#/,''); if(!sec || !current) return;
    var target=document.getElementById(sec) || document.getElementById(current.dataset.page+'--'+sec);
    if(!target) return;
    var y=target.getBoundingClientRect().top + window.pageYOffset - (navEl?navEl.offsetHeight:0) - 8;
    window.scrollTo({top:y,behavior: smooth?'smooth':'auto'});
  }
  if(current){ observe(current); fixFaq(current); }
  window.addEventListener('hashchange',function(){ scrollToHash(true); });
  window.addEventListener('resize',function(){ if(current) fixFaq(current); });
  window.addEventListener('load',function(){ if(current) fixFaq(current); scrollToHash(false); });
})();
