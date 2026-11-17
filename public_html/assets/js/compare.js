// Tier comparison: on phones, show one package column at a time with tabs.
export function initCompare() {
  const mq = matchMedia('(max-width: 767px)');
  document.querySelectorAll('[data-compare]').forEach((box) => {
    const tabs = box.querySelector('.compare__tabs');
    const buttons = [...box.querySelectorAll('.compare__tab')];
    if (!tabs || !buttons.length) return;
    const show = (col) => {
      buttons.forEach((b) => b.setAttribute('aria-selected', String(b.dataset.col === col)));
      box.querySelectorAll('thead [data-col], tbody [data-col]').forEach((el) => el.classList.toggle('is-active', el.dataset.col === col));
    };
    const apply = () => {
      const on = mq.matches;
      tabs.hidden = !on;
      box.classList.toggle('is-tabbed', on);
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
    show((buttons.find((b) => b.getAttribute('aria-selected') === 'true') || buttons[0]).dataset.col);
    apply();
    mq.addEventListener('change', apply);
  });
}
