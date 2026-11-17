// Third-party chatbot: loaded only after the first interaction or 5 seconds, so it never slows the first paint.
export function initChatbot() {
  const slot = document.getElementById('chatbot-slot');
  const src = slot?.dataset.chatbotSrc;
  if (!src) return;
  let done = false;
  const load = () => {
    if (done) return;
    done = true;
    events.forEach((ev) => removeEventListener(ev, load));
    const s = document.createElement('script');
    s.src = src;
    s.async = true;
    document.body.appendChild(s);
  };
  const events = ['pointerdown', 'keydown', 'scroll', 'touchstart'];
  events.forEach((ev) => addEventListener(ev, load, { once: true, passive: true }));
  setTimeout(load, 5000);
}
