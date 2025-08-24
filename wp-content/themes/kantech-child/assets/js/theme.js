(() => {
  const btn = document.querySelector('[data-menu-toggle]');
  const nav = document.querySelector('[data-main-nav]');
  if (!btn || !nav) return;
  btn.addEventListener('click', () => {
    const open = nav.getAttribute('data-open') === 'true';
    nav.setAttribute('data-open', String(!open));
    btn.setAttribute('aria-expanded', String(!open));
  });

  // Simple responsive: collapse nav under 768px
  const mq = window.matchMedia('(max-width: 768px)');
  function update() {
    if (mq.matches) {
      btn.style.display = 'inline-flex';
      nav.dataset.open ??= 'false';
      nav.style.display = nav.dataset.open === 'true' ? 'flex' : 'none';
      nav.style.flexDirection = 'column';
      nav.style.gap = '8px';
      nav.style.padding = '10px 0';
    } else {
      btn.style.display = 'none';
      nav.style.display = 'flex';
      nav.style.flexDirection = 'row';
      nav.style.gap = '16px';
      nav.style.padding = '0';
    }
  }
  mq.addEventListener('change', update);
  update();
})();
