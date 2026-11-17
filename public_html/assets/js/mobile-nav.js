// Mobile menu: upgrades the #mobile-nav link into a real toggle button with focus handling.
export function initMobileNav() {
  const btn = document.querySelector('[data-menu-btn]');
  const panel = document.querySelector('[data-mobile-nav]');
  if (!btn || !panel) return;
  const root = document.documentElement;

  btn.setAttribute('role', 'button');
  btn.setAttribute('aria-expanded', 'false');
  btn.removeAttribute('href');
  btn.tabIndex = 0;

  const isOpen = () => root.classList.contains('menu-open');
  const setOpen = (open) => {
    root.classList.toggle('menu-open', open);
    btn.setAttribute('aria-expanded', String(open));
    btn.querySelector('.sr-only').textContent = open ? 'Close menu' : 'Menu';
    if (open) panel.querySelector('summary, a')?.focus();
  };

  btn.addEventListener('click', () => setOpen(!isOpen()));
  btn.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      setOpen(!isOpen());
    }
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen()) {
      setOpen(false);
      btn.focus();
    }
  });
  panel.addEventListener('click', (e) => {
    if (e.target.closest('a')) setOpen(false);
  });
  window.matchMedia('(min-width: 1100px)').addEventListener('change', (e) => e.matches && setOpen(false));
}
