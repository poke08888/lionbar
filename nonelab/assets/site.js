/* ============================================================
   NONELAB — interactions
   nav scroll state · mobile menu · scroll reveal · parallax
   · number count-up · marquee auto-duplication

   Robust visibility: content reveal can NEVER permanently depend
   on a window-scroll that some hosts (preview iframes that scroll
   an outer container) never fire. We probe whether window can
   scroll; if it can't, we reveal everything up front.
   ============================================================ */
(function(){
  function ready(fn){ if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',fn); else fn(); }

  ready(function(){
    const reduce = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
    const vh = ()=> window.innerHeight || document.documentElement.clientHeight;

    /* ---- nav scroll state ---- */
    const nav = document.querySelector('.nav');
    const navState = ()=>{
      const y = window.scrollY || document.documentElement.scrollTop || 0;
      if(nav) nav.classList.toggle('scrolled', y>20);
    };

    /* ---- mobile menu ---- */
    const burger = document.querySelector('.nav-burger');
    const menu = document.querySelector('.mobile-menu');
    if(burger && menu){
      const toggle = (open)=>{
        menu.classList.toggle('open', open);
        burger.classList.toggle('open', open);
        document.body.style.overflow = open ? 'hidden' : '';
      };
      burger.addEventListener('click', ()=>toggle(!menu.classList.contains('open')));
      menu.querySelectorAll('a').forEach(a=>a.addEventListener('click', ()=>toggle(false)));
    }

    /* ---- collections ---- */
    const revs = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
    const counters = Array.prototype.slice.call(document.querySelectorAll('[data-count]'));

    const inView = (el, bias)=>{
      const r = el.getBoundingClientRect();
      return r.top < vh()*(1-(bias||0.06)) && r.bottom > 0;
    };

    /* ---- count-up ---- */
    const fmt = (v, suf, pre)=> (pre||'') + Math.round(v).toLocaleString('en-US') + (suf||'');
    const animateCount = (el)=>{
      const target = parseFloat(el.dataset.count);
      const suf = el.dataset.suffix||''; const pre = el.dataset.prefix||'';
      if(reduce){ el.textContent = fmt(target, suf, pre); return; }
      const dur = 1500; const start = performance.now();
      const ease = t=>1-Math.pow(1-t,3);
      const step = (now)=>{
        const t = Math.min((now-start)/dur,1);
        el.textContent = fmt(target*ease(t), suf, pre);
        if(t<1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };

    /* ---- reveal helpers ---- */
    const checkReveals = ()=>{
      for(let i=revs.length-1;i>=0;i--){
        if(inView(revs[i])){ revs[i].classList.add('in'); revs.splice(i,1); }
      }
    };
    const checkCounts = ()=>{
      for(let i=counters.length-1;i>=0;i--){
        if(inView(counters[i],0.12)){ animateCount(counters[i]); counters.splice(i,1); }
      }
    };
    const revealAll = ()=>{
      /* Instant show: some hosts (this preview iframe) freeze CSS
         transitions/rAF while backgrounded, trapping .reveal at
         opacity:0 even with .in. Kill the transition so the end
         state (opacity:1) shows immediately, and set counters to
         their final value without rAF.
         IMPORTANT: query the DOM fresh — elements already given .in
         (with a frozen transition) by the initial checkReveals() are
         no longer in the `revs` array, but they still need their
         transition removed, or they stay stuck at opacity:0. */
      document.querySelectorAll('.reveal').forEach(el=>{
        el.style.transition='none'; el.classList.add('in');
      });
      revs.length=0;
      document.querySelectorAll('[data-count]').forEach(el=>{
        el.textContent=fmt(parseFloat(el.dataset.count), el.dataset.suffix, el.dataset.prefix);
      });
      counters.length=0;
    };

    /* ---- parallax ---- */
    const plx = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));
    const doParallax = ()=>{
      if(reduce) return;
      const h = vh();
      plx.forEach(el=>{
        const speed = parseFloat(el.dataset.parallax)||0.15;
        const r = el.getBoundingClientRect();
        const off = ((r.top + r.height/2) - h/2) * -speed;
        el.style.transform = `translate3d(0,${off.toFixed(1)}px,0)`;
      });
    };

    /* ---- marquee: duplicate track for seamless loop ---- */
    document.querySelectorAll('.marquee-track').forEach(tr=>{ tr.innerHTML += tr.innerHTML; });

    /* ---- master scroll handler (real-browser progressive reveal) ---- */
    let ticking=false;
    const onScroll = ()=>{
      if(ticking) return; ticking=true;
      requestAnimationFrame(()=>{
        navState(); checkReveals(); checkCounts(); doParallax();
        ticking=false;
      });
    };
    window.addEventListener('scroll', onScroll, {passive:true});
    document.addEventListener('scroll', onScroll, {passive:true, capture:true});
    window.addEventListener('resize', onScroll, {passive:true});

    /* ---- initial pass (reveals whatever is in the first viewport) ---- */
    if(reduce){ revealAll(); navState(); doParallax(); return; }
    navState(); checkReveals(); checkCounts(); doParallax();

    /* ---- visibility guarantee ----
       Probe whether the window can actually scroll. If it can't
       (this preview host scrolls an outer container, or the page is
       short), nothing below the fold would ever reveal — so reveal
       everything. If it CAN scroll, leave the progressive reveal to
       the scroll handler. */
    const probeAndGuarantee = ()=>{
      if(!revs.length && !counters.length) return;
      const y0 = window.scrollY || document.documentElement.scrollTop || 0;
      window.scrollTo(0, 2);
      const moved = (window.scrollY || document.documentElement.scrollTop ||
                     (document.scrollingElement && document.scrollingElement.scrollTop) || 0) > 0;
      window.scrollTo(0, y0);
      if(!moved){ revealAll(); }      // non-scrolling host or short page → show all
      else { checkReveals(); checkCounts(); }
    };
    setTimeout(probeAndGuarantee, 500);
    setTimeout(probeAndGuarantee, 1500);
    /* earliest possible pass once layout exists, to minimise any blank
       window on hosts that freeze transitions */
    requestAnimationFrame(()=>requestAnimationFrame(probeAndGuarantee));

    /* If the tab is hidden at load, CSS transitions are frozen — show
       everything immediately. Re-check whenever visibility changes. */
    if(document.hidden) revealAll();
    document.addEventListener('visibilitychange', probeAndGuarantee);
  });
})();
