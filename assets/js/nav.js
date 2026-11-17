// Desktop mega-menus: open on hover (fine pointers) or on the chevron button; Escape and outside click close.
export function initMegaMenus() {
  const items = [...document.querySelectorAll('[data-mega]')];
  if (!items.length) return;
  const hoverable = window.matchMedia('(hover: hover) and (pointer: fine)');
  let closeTimer;

  const setOpen = (item, open) => {
    const btn = item.querySelector('.primary-nav__toggle');
    if (open) {
      items.forEach((other) => other !== item && setOpen(other, false));
      item.setAttribute('data-open', '');
    } else {
      item.removeAttribute('data-open');
    }
    btn?.setAttribute('aria-expanded', String(open));
  };

  items.forEach((item) => {
    const btn = item.querySelector('.primary-nav__toggle');
    btn?.addEventListener('click', () => setOpen(item, !item.hasAttribute('data-open')));

    item.addEventListener('mouseenter', () => {
      if (!hoverable.matches) return;
      clearTimeout(closeTimer);
      setOpen(item, true);
    });
    item.addEventListener('mouseleave', () => {
      if (!hoverable.matches) return;
      closeTimer = setTimeout(() => setOpen(item, false), 180);
    });
    item.addEventListener('focusout', (e) => {
      if (!item.contains(e.relatedTarget)) setOpen(item, false);
    });
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && item.hasAttribute('data-open')) {
        setOpen(item, false);
        btn?.focus();
      }
    });
  });

  document.addEventListener('click', (e) => {
    items.forEach((item) => !item.contains(e.target) && setOpen(item, false));
  });
}
