// Fades sections up once as they scroll into view. Without JS (or IntersectionObserver) everything is visible.
export function initReveal() {
  const els = document.querySelectorAll('[data-reveal]');
  if (!els.length) return;
  if (!('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) {
    els.forEach((el) => el.classList.add('is-visible'));
    return;
  }
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        // Small stagger for siblings revealed together.
        const idx = [...(el.parentElement?.children || [])].filter((c) => c.hasAttribute('data-reveal')).indexOf(el);
        el.style.transitionDelay = `${Math.min(Math.max(idx, 0), 4) * 70}ms`;
        el.classList.add('is-visible');
        io.unobserve(el);
      });
    },
    { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
  );
  els.forEach((el) => io.observe(el));
}
