// Loads the booking calendar iframe only when it scrolls into view.
export function initBooking() {
  const slots = document.querySelectorAll('[data-booking][data-src]');
  if (!slots.length) return;
  const load = (slot) => {
    if (slot.dataset.loaded) return;
    slot.dataset.loaded = '1';
    const iframe = document.createElement('iframe');
    iframe.src = slot.dataset.src;
    iframe.title = 'Booking calendar';
    iframe.loading = 'lazy';
    iframe.setAttribute('allow', 'payment');
    slot.replaceChildren(iframe);
  };
  if (!('IntersectionObserver' in window)) {
    slots.forEach(load);
    return;
  }
  const io = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
      if (en.isIntersecting) {
        load(en.target);
        io.unobserve(en.target);
      }
    });
  }, { rootMargin: '300px 0px' });
  slots.forEach((s) => io.observe(s));
}
