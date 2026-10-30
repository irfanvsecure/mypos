(function(){
  var scriptSrc=document.currentScript && document.currentScript.src;
  var reduceMotion=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
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
    root.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale,.reveal-3d').forEach(function(el){ if(!el.classList.contains('in')) io.observe(el); });
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

  var fmtRs=function(n){ return Math.round(n).toLocaleString('en-US'); };

  /* "Get a demo" buttons that pre-fill the page's demo form with what the visitor picked */
  document.addEventListener('click',function(ev){
    var btn=ev.target.closest('[data-prefill]'); if(!btn) return;
    var form=document.getElementById('enquiry'); if(!form) return;
    ev.preventDefault();
    var msg=form.querySelector('[name="message"]'); if(msg) msg.value=btn.dataset.prefill;
    var type=form.querySelector('select[name="type"]');
    if(type){ [].forEach.call(type.options,function(o){ if(o.value==='Free Demo') type.value=o.value; }); }
    form.scrollIntoView({behavior:reduceMotion?'auto':'smooth',block:'start'});
    form.classList.remove('is-pulse'); void form.offsetWidth; form.classList.add('is-pulse');
    var first=form.querySelector('[name="name"]'); if(first) setTimeout(function(){ first.focus({preventScroll:true}); },reduceMotion?0:600);
  });

  /* Savings calculator */
  var calc=document.querySelector('[data-calc]');
  if(calc){
    var calcRoot=calc.closest('section');
    var out=function(k,v){ calcRoot.querySelectorAll('[data-out="'+k+'"]').forEach(function(e){ e.textContent=v; }); };
    var val=function(k){ return parseFloat(calc.querySelector('[data-in="'+k+'"]').value); };
    var shown=0;
    var runCalc=function(){
      var sales=val('sales'), staff=val('staff'), hours=val('hours'), wage=val('wage');
      var time=staff*hours*26*wage*0.6, leak=sales*0.015, total=time+leak;
      out('sales','Rs '+fmtRs(sales)); out('staff',staff); out('hours',hours); out('wage','Rs '+fmtRs(wage));
      out('time',fmtRs(time)); out('leak',fmtRs(leak)); out('roi',Math.max(1,Math.floor(total/2000))+'×');
      var from=shown, t0=null; shown=total;
      if(reduceMotion){ out('total',fmtRs(total)); return; }
      requestAnimationFrame(function f(t){ if(!t0) t0=t; var p=Math.min(1,(t-t0)/500); out('total',fmtRs(from+(total-from)*(1-Math.pow(1-p,3)))); if(p<1) requestAnimationFrame(f); });
    };
    calc.addEventListener('input',runCalc); runCalc();
  }

  /* One-minute price builder (prices mirror the /pricing and /one-time-pricing pages) */
  var bld=document.querySelector('[data-builder]');
  if(bld){
    var steps=[].slice.call(bld.querySelectorAll('.bld-step')), dots=[].slice.call(bld.querySelectorAll('.bld-steps li'));
    var back=bld.querySelector('[data-bld-back]'), next=bld.querySelector('[data-bld-next]'), at=0;
    var pick=function(n){ var c=bld.querySelector('[name="'+n+'"]:checked'); return c ? c.value : ''; };
    var quote=function(){
      var mods=[].slice.call(bld.querySelectorAll('[name="bld_mod"]:checked'));
      var business=pick('bld_business'), branches=pick('bld_branches'), plan=pick('bld_plan');
      var names=mods.map(function(m){ return m.dataset.name; }), q={business:business, branches:branches, mods:names};
      var wantsFbr=mods.some(function(m){ return /^fbr/.test(m.value); });
      if(branches!=='1' || (plan==='onetime' && wantsFbr)){
        q.price='Custom quote'; q.per=''; q.plan='Premium — multi-location / FBR setup, quoted for your business';
      } else if(plan==='monthly'){
        var sum=2000; mods.forEach(function(m){ sum+=+m.dataset.price; });
        q.price='Rs '+fmtRs(sum); q.per='/month'; q.plan='Standard monthly plan'+(names.length?' + '+names.length+' add-on'+(names.length>1?'s':''):'')+' · first 14 days free';
      } else {
        var std=mods.some(function(m){ return /accounting|whatsapp|mobile|instalment|manufacturing|woocommerce|catalogue|offline/.test(m.value); });
        q.price=std?'Rs 36,500':'Rs 24,000'; q.per=' one-time'; q.plan=(std?'Standard':'Basic')+' one-time licence · single location';
      }
      return q;
    };
    var paint=function(){
      var q=quote();
      bld.querySelector('[data-bld-price]').textContent=q.price;
      bld.querySelector('[data-bld-per]').textContent=q.per;
      bld.querySelector('[data-bld-plan]').textContent=q.plan;
      var lines=['Business: '+q.business,'Branches: '+q.branches].concat(q.mods.length?['Add-ons: '+q.mods.join(', ')]:[]);
      bld.querySelector('[data-bld-summary]').innerHTML=lines.map(function(l){ return '<li>'+l.replace(/</g,'&lt;')+'</li>'; }).join('');
      var text='Price builder: '+lines.join(' | ')+' | Estimate: '+q.price+q.per+' ('+q.plan+')';
      bld.querySelector('[data-bld-message]').value=text;
      var wa=bld.querySelector('[data-bld-wa]'); wa.href=wa.href.replace(/text=[^&]*/,'text='+encodeURIComponent('Hi myPOS, please confirm this quote. '+text));
    };
    var go=function(i){
      at=Math.max(0,Math.min(steps.length-1,i));
      steps.forEach(function(s,k){ s.classList.toggle('on',k===at); });
      dots.forEach(function(d,k){ d.classList.toggle('on',k<=at); });
      back.hidden=at===0; next.hidden=at===steps.length-1;
      paint();
    };
    bld.classList.add('is-js');
    back.addEventListener('click',function(){ go(at-1); });
    next.addEventListener('click',function(){ go(at+1); });
    bld.addEventListener('change',paint);
    bld.addEventListener('submit',paint);
    go(0);
  }

  /* 3D tilt on cards that follow the pointer (mouse only) */
  if(!reduceMotion && window.matchMedia('(hover: hover) and (pointer: fine)').matches){
    document.querySelectorAll('[data-tilt]').forEach(function(el){
      el.addEventListener('pointermove',function(e){
        var r=el.getBoundingClientRect(), x=(e.clientX-r.left)/r.width-0.5, y=(e.clientY-r.top)/r.height-0.5;
        el.style.setProperty('--rx',(-y*8).toFixed(2)+'deg'); el.style.setProperty('--ry',(x*10).toFixed(2)+'deg');
        el.style.setProperty('--mx',((x+0.5)*100).toFixed(1)+'%'); el.style.setProperty('--my',((y+0.5)*100).toFixed(1)+'%');
      });
      el.addEventListener('pointerleave',function(){ el.style.setProperty('--rx','0deg'); el.style.setProperty('--ry','0deg'); });
    });
  }

  /* Scroll progress bar */
  var bar=document.querySelector('[data-progress]');
  if(bar){
    var pr=function(){ var h=document.documentElement; bar.style.transform='scaleX('+(h.scrollTop/((h.scrollHeight-h.clientHeight)||1)).toFixed(4)+')'; };
    window.addEventListener('scroll',function(){ requestAnimationFrame(pr); },{passive:true}); pr();
  }

  /* Offer bar: stays dismissed for this visitor */
  var offer=document.querySelector('[data-offer]');
  if(offer){
    try{ if(localStorage.getItem('offerClosed')==='1') offer.hidden=true; }catch(e){}
    offer.querySelector('[data-offer-close]').addEventListener('click',function(){ offer.hidden=true; try{ localStorage.setItem('offerClosed','1'); }catch(e){} });
  }

  /* Cinematic 3D hero backdrop: loaded after the page settles, skipped for reduced motion or no WebGL */
  var host3d=document.querySelector('[data-hero3d]');
  if(host3d && scriptSrc && !reduceMotion && window.WebGLRenderingContext && (function(){ try{ return !!document.createElement('canvas').getContext('webgl2'); }catch(e){ return false; } })()){
    var load3d=function(){ import(new URL('hero3d.js',scriptSrc).href.replace(/\?.*$/,'')+(scriptSrc.match(/\?.*$/)||[''])[0]).then(function(m){ m.mount(host3d); }).catch(function(){}); };
    if(document.readyState==='complete') setTimeout(load3d,200); else window.addEventListener('load',function(){ setTimeout(load3d,200); });
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
