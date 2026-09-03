/* Ganesha Flame — interaksi UI */
(function () {
  'use strict';

  if (window.__ganeshaInit) return;
  window.__ganeshaInit = true;

  // --- Mobile nav (toggle sederhana; tanpa handler "klik di luar" agar tak menutup sendiri) ---
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if (toggle && links) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const open = links.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // Menutup menu saat sebuah tautan navigasi diklik
    links.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        links.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // --- Scroll reveal ---
  const reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && reveals.length) {
    const io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) {
            e.target.classList.add('in');
            io.unobserve(e.target);
          }
        });
      },
      { threshold: 0.12 }
    );
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('in'); });
  }

  // --- FAQ accordion ---
  document.querySelectorAll('.qa-q').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const item = btn.closest('.qa');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.qa.open').forEach(function (q) { q.classList.remove('open'); });
      if (!isOpen) item.classList.add('open');
      btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
    });
  });

  // --- Project lightbox + slider ---
  const lb = document.querySelector('.lightbox');
  if (lb) {
    const lbImg = lb.querySelector('img');
    const lbTitle = lb.querySelector('h3');
    const lbMeta = lb.querySelector('.lb-meta');

    const mkBtn = function (cls, html) {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = cls;
      b.innerHTML = html;
      lb.appendChild(b);
      return b;
    };
    const prevBtn = mkBtn('lb-prev', '&#8249;');
    const nextBtn = mkBtn('lb-next', '&#8250;');
    const dotsWrap = document.createElement('div');
    dotsWrap.className = 'lb-dots';
    lb.appendChild(dotsWrap);

    let imgs = [];
    let idx = 0;
    let timer = null;

    const stopAuto = function () { if (timer) { clearInterval(timer); timer = null; } };
    const startAuto = function () { stopAuto(); if (imgs.length > 1) timer = setInterval(function () { go(idx + 1); }, 4000); };

    const paintDots = function () {
      dotsWrap.querySelectorAll('button').forEach(function (d, i) { d.classList.toggle('on', i === idx); });
    };
    const render = function () { if (lbImg) lbImg.src = imgs[idx] || ''; paintDots(); };
    const go = function (n) { if (!imgs.length) return; idx = (n + imgs.length) % imgs.length; render(); };

    const buildDots = function () {
      dotsWrap.innerHTML = '';
      imgs.forEach(function (_, i) {
        const d = document.createElement('button');
        d.type = 'button';
        d.addEventListener('click', function (ev) { ev.stopPropagation(); stopAuto(); go(i); startAuto(); });
        dotsWrap.appendChild(d);
      });
    };

    const openLb = function (el) {
      imgs = [];
      try { imgs = JSON.parse(el.dataset.images || '[]'); } catch (e) { imgs = []; }
      if (!imgs.length && el.dataset.img) imgs = [el.dataset.img];
      idx = 0;
      if (lbTitle) lbTitle.textContent = el.dataset.client || '';
      if (lbMeta) lbMeta.innerHTML = el.dataset.meta || '';
      buildDots();
      render();
      const multi = imgs.length > 1;
      prevBtn.style.display = nextBtn.style.display = dotsWrap.style.display = multi ? '' : 'none';
      lb.classList.add('open');
      document.body.style.overflow = 'hidden';
      startAuto();
    };
    const closeLb = function () {
      stopAuto();
      lb.classList.remove('open');
      document.body.style.overflow = '';
    };

    prevBtn.addEventListener('click', function (e) { e.stopPropagation(); stopAuto(); go(idx - 1); startAuto(); });
    nextBtn.addEventListener('click', function (e) { e.stopPropagation(); stopAuto(); go(idx + 1); startAuto(); });
    lb.addEventListener('mouseenter', stopAuto);
    lb.addEventListener('mouseleave', startAuto);

    document.querySelectorAll('.proj').forEach(function (p) {
      p.addEventListener('click', function () { openLb(p); });
      p.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLb(p); }
      });
    });
    lb.addEventListener('click', function (e) {
      if (e.target === lb || e.target.closest('.lb-close')) closeLb();
    });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') closeLb();
      else if (e.key === 'ArrowRight') { stopAuto(); go(idx + 1); startAuto(); }
      else if (e.key === 'ArrowLeft') { stopAuto(); go(idx - 1); startAuto(); }
    });
  }

  // --- Back to top ---
  const top = document.querySelector('.to-top');
  if (top) {
    const onScroll = function () { top.classList.toggle('show', window.scrollY > 600); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
  }
})();
