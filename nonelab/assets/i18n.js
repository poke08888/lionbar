/* ============================================================
   NONELAB — i18n engine
   - window.NL_COMMON : nav + footer strings (shared on every page)
   - window.PAGE_I18N : page-specific strings (defined inline per page
                        BEFORE this script loads)
   Markup: any element with data-i18n="key" gets its text replaced.
   Persists choice to localStorage('nl_lang').
   ============================================================ */
(function(){
  const NL_COMMON = {
    en:{
      "nav.about":"About","nav.brands":"Brands","nav.partners":"Partners","nav.contact":"Contact","nav.cta":"Partner with us",
      "foot.tag":"A Vietnamese beauty &amp; wellness group developing and distributing the brands that define modern self-care.",
      "foot.explore":"Explore","foot.home":"Home","foot.about":"About us","foot.brands":"Our brands","foot.partners":"Partners","foot.contact":"Contact",
      "foot.brandsCol":"Our brands","foot.reach":"Reach us",
      "foot.hn":"Hanoi","foot.hotlineLabel":"Hotline","foot.hotline":"1900 4628","foot.hnAddr":"43 ngõ 100 Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam","foot.emailLabel":"Email","foot.email":"hello@nonelab.net",
      "foot.rights":"© 2025 Nonelab Group. All rights reserved.","foot.beauty":"Beauty in your own way."
    },
    vi:{
      "nav.about":"Giới thiệu","nav.brands":"Thương hiệu","nav.partners":"Đối tác","nav.contact":"Liên hệ","nav.cta":"Hợp tác cùng chúng tôi",
      "foot.tag":"Tập đoàn beauty &amp; wellness Việt Nam phát triển và phân phối những thương hiệu định hình phong cách chăm sóc bản thân hiện đại.",
      "foot.explore":"Khám phá","foot.home":"Trang chủ","foot.about":"Giới thiệu","foot.brands":"Thương hiệu","foot.partners":"Đối tác","foot.contact":"Liên hệ",
      "foot.brandsCol":"Thương hiệu","foot.reach":"Liên hệ",
      "foot.hn":"Hà Nội","foot.hotlineLabel":"Hotline","foot.hotline":"1900 4628","foot.hnAddr":"43 ngõ 100 Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam","foot.emailLabel":"Email","foot.email":"hello@nonelab.net",
      "foot.rights":"© 2025 Nonelab Group. Bảo lưu mọi quyền.","foot.beauty":"Đẹp theo cách của bạn."
    },
    zh:{
      "nav.about":"关于我们","nav.brands":"品牌","nav.partners":"合作伙伴","nav.contact":"联系我们","nav.cta":"与我们合作",
      "foot.tag":"一家越南美妆与健康集团，致力于打造并分销定义现代自我护理的品牌。",
      "foot.explore":"探索","foot.home":"首页","foot.about":"关于我们","foot.brands":"我们的品牌","foot.partners":"合作伙伴","foot.contact":"联系我们",
      "foot.brandsCol":"我们的品牌","foot.reach":"联系方式",
      "foot.hn":"河内","foot.hotlineLabel":"热线","foot.hotline":"1900 4628","foot.hnAddr":"43 ngõ 100 Dịch Vọng Hậu, Cầu Giấy, 河内, 越南","foot.emailLabel":"邮箱","foot.email":"hello@nonelab.net",
      "foot.rights":"© 2025 Nonelab 集团。版权所有。","foot.beauty":"以你的方式，绽放美丽。"
    }
  };
  window.NL_COMMON = NL_COMMON;

  function dict(lang){
    const page = window.PAGE_I18N || {en:{},vi:{},zh:{}};
    return Object.assign({}, NL_COMMON[lang]||{}, page[lang]||{});
  }

  function apply(lang){
    const d = dict(lang);
    document.documentElement.setAttribute('lang', lang);
    document.querySelectorAll('[data-i18n]').forEach(el=>{
      const k = el.getAttribute('data-i18n');
      if(d[k]!=null) el.innerHTML = d[k];
    });
    document.querySelectorAll('[data-i18n-ph]').forEach(el=>{
      const k = el.getAttribute('data-i18n-ph');
      if(d[k]!=null) el.setAttribute('placeholder', d[k]);
    });
    document.querySelectorAll('.lang button, .mm-lang button').forEach(b=>{
      b.classList.toggle('on', b.dataset.lang===lang);
    });
    try{ localStorage.setItem('nl_lang', lang); }catch(e){}
  }

  function init(){
    let lang='en';
    try{ lang = localStorage.getItem('nl_lang') || 'en'; }catch(e){}
    if(!['en','vi','zh'].includes(lang)) lang='en';
    apply(lang);
    document.querySelectorAll('.lang button, .mm-lang button').forEach(b=>{
      b.addEventListener('click', ()=>apply(b.dataset.lang));
    });
  }
  window.NL_setLang = apply;

  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
