// Tier comparison: on phones, CSS shows one package column at a time (the server marks the "Most popular"
// column active, so nothing shifts on load). This script just switches the active column from the tabs.
export function initCompare() {
  document.querySelectorAll('[data-compare]').forEach((box) => {
    const buttons = [...box.querySelectorAll('.compare__tab')];
    if (!buttons.length) return;
    const show = (col) => {
      buttons.forEach((b) => b.setAttribute('aria-selected', String(b.dataset.col === col)));
      box.querySelectorAll('thead [data-col], tbody [data-col]').forEach((el) => el.classList.toggle('is-active', el.dataset.col === col));
    };
    buttons.forEach((b, i) => {
      b.addEventListener('click', () => show(b.dataset.col));
      b.addEventListener('keydown', (e) => {
        if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
        const next = buttons[(i + (e.key === 'ArrowRight' ? 1 : buttons.length - 1)) % buttons.length];
        next.focus();
        show(next.dataset.col);
      });
    });
  });
}
