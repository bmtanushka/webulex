// Cookie banner + Google Consent Mode v2. GA4 (gtag.js) is loaded only after the visitor accepts analytics.
// The choice is stored in a first-party cookie for 12 months.
const COOKIE = 'wbx_consent';

function readConsent() {
  const m = document.cookie.match(/(?:^|; )wbx_consent=([^;]*)/);
  if (!m) return null;
  try {
    return JSON.parse(decodeURIComponent(m[1]));
  } catch {
    return null;
  }
}

function writeConsent(c) {
  const value = encodeURIComponent(JSON.stringify({ ...c, v: 1, t: Date.now() }));
  const secure = location.protocol === 'https:' ? '; Secure' : '';
  document.cookie = `${COOKIE}=${value}; Max-Age=${60 * 60 * 24 * 365}; Path=/; SameSite=Lax${secure}`;
}

let gaLoaded = false;
function applyConsent(c) {
  if (typeof window.gtag !== 'function' || !window.WBX_GA4) return;
  window.gtag('consent', 'update', {
    analytics_storage: c.analytics ? 'granted' : 'denied',
    ad_storage: c.marketing ? 'granted' : 'denied',
    ad_user_data: c.marketing ? 'granted' : 'denied',
    ad_personalization: c.marketing ? 'granted' : 'denied',
  });
  if (c.analytics && !gaLoaded) {
    gaLoaded = true;
    const s = document.createElement('script');
    s.async = true;
    s.nonce = document.querySelector('script[nonce]')?.nonce || '';
    s.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(window.WBX_GA4)}`;
    document.head.appendChild(s);
    window.gtag('js', new Date());
    window.gtag('config', window.WBX_GA4, { anonymize_ip: true });
  }
}

/** Send a GA4 event if analytics is running; otherwise do nothing. */
export function track(name, params = {}) {
  if (gaLoaded && typeof window.gtag === 'function') window.gtag('event', name, params);
}

export function initConsent() {
  const banner = document.querySelector('[data-cookie-banner]');
  const saved = readConsent();
  if (saved) applyConsent(saved);

  // Click tracking for links marked with data-event.
  document.addEventListener('click', (e) => {
    const el = e.target.closest('[data-event]');
    if (!el) return;
    const params = el.dataset.package ? { package_name: el.dataset.package } : {};
    track(el.dataset.event, { ...params, link_url: el.getAttribute('href') || undefined, page: location.pathname });
  });

  if (!banner) return;
  const panel = banner.querySelector('[data-cookie-panel]');
  const btn = (k) => banner.querySelector(`[data-cookie="${k}"]`);
  const boxes = () => Object.fromEntries([...banner.querySelectorAll('[data-consent]')].map((b) => [b.dataset.consent, b.checked]));

  const open = (withSettings = false) => {
    const c = readConsent() || { analytics: false, marketing: false };
    banner.querySelectorAll('[data-consent]').forEach((b) => (b.checked = !!c[b.dataset.consent]));
    banner.classList.add('is-open');
    panel.hidden = !withSettings;
    btn('save').hidden = !withSettings;
    btn('settings').setAttribute('aria-expanded', String(withSettings));
    document.documentElement.classList.add('has-cookie-banner');
    (withSettings ? banner.querySelector('[data-consent]') : btn('accept'))?.focus({ preventScroll: true });
  };
  const close = (c) => {
    writeConsent(c);
    applyConsent(c);
    banner.classList.remove('is-open', 'cookie-banner--pending');
    document.documentElement.classList.remove('has-cookie-banner');
  };

  btn('accept').addEventListener('click', () => close({ analytics: true, marketing: true }));
  btn('reject').addEventListener('click', () => close({ analytics: false, marketing: false }));
  btn('save').addEventListener('click', () => close({ analytics: false, marketing: false, ...boxes() }));
  btn('settings').addEventListener('click', () => open(panel.hidden));
  document.querySelectorAll('[data-cookie-settings]').forEach((b) => b.addEventListener('click', () => open(true)));

  if (!saved) {
    open(false);
  } else {
    banner.classList.remove('cookie-banner--pending');
  }
}
