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

  /* Home hero: interactive POS demo (tap items, Charge -> FBR receipt). Auto-plays until the visitor touches it. */
  var demo=document.querySelector('[data-pos-demo]');
  if(demo){
    var fmt=function(n){ return n.toLocaleString('en-US'); };
    var items={};
    demo.querySelectorAll('.hx-item').forEach(function(b){ items[b.dataset.id]={el:b, name:b.querySelector('b').textContent, price:+b.dataset.price}; });
    var cart=[['zinger',2],['fries',1],['drink',2]];   // same order the page renders server-side
    var order=1042, today=412600, busy=false, auto=!window.matchMedia('(prefers-reduced-motion: reduce)').matches, timer=null, step=0;
    var linesEl=demo.querySelector('[data-lines]'), doneEl=demo.querySelector('[data-done]'), payBtn=demo.querySelector('[data-pay]');
    var fbrText=demo.querySelector('[data-fbr-text]'), fbrChip=demo.querySelector('[data-fbr-chip]'), todayEl=demo.querySelector('[data-today]');

    function lineOf(id){ for(var i=0;i<cart.length;i++){ if(cart[i][0]===id) return i; } return -1; }
    function render(newId){
      var sub=0; linesEl.innerHTML='';
      cart.forEach(function(l){
        var it=items[l[0]], amt=it.price*l[1]; sub+=amt;
        var li=document.createElement('li'); if(l[0]===newId) li.className='is-new';
        li.innerHTML='<button type="button" class="hx-dec" data-dec="'+l[0]+'" aria-label="Remove one '+it.name+'">&minus;</button><span>'+it.name+(l[1]>1?' <em>&times;'+l[1]+'</em>':'')+'</span><b>'+fmt(amt)+'</b>';
        linesEl.appendChild(li);
      });
      if(!cart.length) linesEl.innerHTML='<li class="hx-empty">Tap an item to start an order</li>';
      var tax=Math.round(sub*0.16);
      demo.querySelector('[data-sub]').textContent=fmt(sub);
      demo.querySelector('[data-tax]').textContent=fmt(tax);
      demo.querySelectorAll('[data-total]').forEach(function(e){ e.textContent=fmt(sub+tax); });
      payBtn.disabled=!cart.length;
      linesEl.scrollTop=linesEl.scrollHeight;
      return sub+tax;
    }
    function add(id){
      if(busy || !items[id]) return;
      var i=lineOf(id); if(i<0) cart.push([id,1]); else cart[i][1]++;
      var el=items[id].el; el.classList.remove('is-tap'); void el.offsetWidth; el.classList.add('is-tap');
      render(id);
    }
    function dec(id){
      var i=lineOf(id); if(busy || i<0) return;
      if(--cart[i][1]<=0) cart.splice(i,1);
      render();
    }
    function countTo(from,to){
      var t0=null;
      (function frame(t){ if(!t0) t0=t; var p=Math.min(1,(t-t0)/900); todayEl.textContent=fmt(Math.round(from+(to-from)*(1-Math.pow(1-p,3)))); if(p<1) requestAnimationFrame(frame); })(performance.now());
    }
    function charge(){
      if(busy || !cart.length) return;
      busy=true;
      var total=render(), inv='MP-'+order+'-'+String(Math.floor(Math.random()*9000)+1000);
      demo.querySelector('[data-inv]').textContent='#'+inv;
      doneEl.hidden=false; demo.classList.add('is-paid');
      fbrText.textContent='Invoice '+inv.slice(-4)+' synced'; fbrChip.classList.add('is-flash');
      countTo(today, today+total); today+=total;
      setTimeout(function(){
        cart=[]; order++; demo.querySelector('[data-order]').textContent=order;
        doneEl.hidden=true; demo.classList.remove('is-paid'); fbrChip.classList.remove('is-flash');
        fbrText.textContent='Verified & synced';
        todayEl.textContent=fmt(today);
        busy=false; render();
      },2600);
    }

    demo.addEventListener('click',function(e){
      var t;
      if((t=e.target.closest('.hx-item'))) add(t.dataset.id);
      else if((t=e.target.closest('[data-dec]'))) dec(t.dataset.dec);
      else if(e.target.closest('[data-pay]')) charge();
      else if((t=e.target.closest('[data-cat]'))){
        demo.querySelectorAll('.hx-cats [data-cat]').forEach(function(b){ b.classList.toggle('on', b===t); b.setAttribute('aria-pressed', b===t ? 'true' : 'false'); });
        Object.keys(items).forEach(function(id){ var el=items[id].el; el.hidden = t.dataset.cat!=='all' && el.dataset.cat!==t.dataset.cat; });
      }
    });

    // Auto-play: ring up a few orders on its own until the visitor interacts, and only while the hero is on screen.
    var script=['PAY','zinger','fries','drink','drink','PAY','pizza','chai','chai','cake','PAY'];
    function tick(){
      timer=null; if(!auto) return;
      var s=script[step++ % script.length];
      if(s==='PAY') charge(); else add(s);
      timer=setTimeout(tick, s==='PAY' ? 3400 : 950);
    }
    function stopAuto(){ auto=false; clearTimeout(timer); timer=null; demo.classList.add('is-user'); }
    ['pointerdown','keydown'].forEach(function(ev){ demo.addEventListener(ev,stopAuto,{once:true}); });
    if('IntersectionObserver' in window){
      new IntersectionObserver(function(en){
        if(en[0].isIntersecting){ if(auto && !timer) timer=setTimeout(tick,2400); }
        else { clearTimeout(timer); timer=null; }
      },{threshold:0.4}).observe(demo);
    }
  }

  /* Page init: each Laravel route renders one .pg; #section scrolls under the sticky nav */
  var current=document.querySelector('.pg');
  function scrollToHash(smooth){
    var sec=location.hash.replace(/^#/,''); if(!sec || !current) return;
    var target=document.getElementById(sec) || document.getElementById(current.dataset.page+'--'+sec);
    if(!target) return;
    // scroll-margin-top (CSS) keeps the target clear of the sticky nav; scrollIntoView also stays correct under html{zoom}.
    target.scrollIntoView({block:'start',behavior: smooth?'smooth':'auto'});
  }
  if(current){ observe(current); fixFaq(current); }
  window.addEventListener('hashchange',function(){ scrollToHash(true); });
  window.addEventListener('resize',function(){ if(current) fixFaq(current); });
  window.addEventListener('load',function(){ if(current) fixFaq(current); scrollToHash(false); });
})();
