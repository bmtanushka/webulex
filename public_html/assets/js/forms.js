// Lead form: client-side checks, UTM capture, country/currency guess and fetch submit.
// The form still works without JS: it posts normally and the server redirects back with any errors.
import { guessRegion } from './region.js';
import { track } from './consent.js';

const REGION_TO_COUNTRY = { us: 'US', uk: 'GB', sg: 'SG', au: 'AU' };
const UTM_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

function rememberUtm() {
  try {
    const params = new URLSearchParams(location.search);
    const found = UTM_KEYS.filter((k) => params.get(k));
    if (found.length) sessionStorage.setItem('wbx_utm', JSON.stringify(Object.fromEntries(found.map((k) => [k, params.get(k)]))));
  } catch {
    /* storage blocked: UTM capture is best effort */
  }
}

function fillUtm(form) {
  let saved = {};
  try {
    saved = JSON.parse(sessionStorage.getItem('wbx_utm') || '{}');
  } catch {
    saved = {};
  }
  form.querySelectorAll('[data-utm]').forEach((input) => {
    if (!input.value && saved[input.dataset.utm]) input.value = saved[input.dataset.utm];
  });
}

function setFieldError(form, name, message) {
  const input = form.querySelector(`[name="${name}"]`);
  if (!input) return;
  const field = input.closest('.field');
  let el = field?.querySelector(`#err-${name}`);
  if (!message) {
    el?.remove();
    input.removeAttribute('aria-invalid');
    const desc = (input.getAttribute('aria-describedby') || '').split(' ').filter((d) => d && d !== `err-${name}`).join(' ');
    desc ? input.setAttribute('aria-describedby', desc) : input.removeAttribute('aria-describedby');
    return;
  }
  if (!el) {
    el = document.createElement('p');
    el.className = 'field__error';
    el.id = `err-${name}`;
    field?.appendChild(el);
  }
  el.textContent = message;
  input.setAttribute('aria-invalid', 'true');
  const ids = new Set((input.getAttribute('aria-describedby') || '').split(' ').filter(Boolean));
  ids.add(`err-${name}`);
  input.setAttribute('aria-describedby', [...ids].join(' '));
}

function clientErrors(form) {
  const errors = {};
  const v = (n) => (form.querySelector(`[name="${n}"]`)?.value || '').trim();
  if (!v('name')) errors.name = 'Please enter your name.';
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v('email'))) errors.email = 'Please enter a valid email address, like name@company.com.';
  if (v('phone') && !/^[+0-9 ()\-.]{6,40}$/.test(v('phone'))) errors.phone = 'Please use digits, spaces and an optional + only.';
  if (!v('country')) errors.country = 'Please choose your country.';
  const msg = form.querySelector('[name="message"]');
  if (msg?.required && v('message').length < 10) errors.message = 'Please tell us a little about your project (at least 10 characters).';
  if (!form.querySelector('[name="consent"]')?.checked) errors.consent = 'Please agree to the privacy policy so we can reply.';
  return errors;
}

function showErrors(form, errors, summary) {
  ['name', 'email', 'phone', 'country', 'message', 'consent', 'turnstile'].forEach((n) => setFieldError(form, n, errors[n]));
  const alert = form.querySelector('[data-form-alert]');
  const keys = Object.keys(errors).filter((k) => k !== '_form');
  if (alert) {
    alert.hidden = false;
    alert.innerHTML = '';
    const strong = document.createElement('strong');
    strong.textContent = summary || 'Please check the highlighted fields.';
    const wrap = document.createElement('div');
    wrap.appendChild(strong);
    if (keys.length) {
      const ul = document.createElement('ul');
      keys.forEach((k) => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = `#f-${k}`;
        a.textContent = errors[k];
        li.appendChild(a);
        ul.appendChild(li);
      });
      wrap.appendChild(ul);
    }
    alert.appendChild(wrap);
  }
  const first = keys.length ? form.querySelector(`#f-${keys[0]}`) : null;
  (first || alert)?.focus();
}

function initCountry(form) {
  const select = form.querySelector('[data-country]');
  const label = form.querySelector('[data-currency-label]');
  if (!select) return;
  if (!select.value) {
    const r = guessRegion();
    if (r && REGION_TO_COUNTRY[r]) select.value = REGION_TO_COUNTRY[r];
  }
  const sync = () => {
    if (label) label.textContent = select.selectedOptions[0]?.dataset.currency || 'USD';
  };
  select.addEventListener('change', sync);
  sync();
}

export function initForms() {
  rememberUtm();
  document.querySelectorAll('[data-lead-form]').forEach((form) => {
    fillUtm(form);
    initCountry(form);
    const src = form.querySelector('[data-source-page]');
    if (src && document.referrer && new URL(document.referrer).origin === location.origin) {
      src.value = `${src.value} (from ${new URL(document.referrer).pathname})`;
    }

    form.addEventListener('submit', async (e) => {
      const errors = clientErrors(form);
      if (Object.keys(errors).length) {
        e.preventDefault();
        showErrors(form, errors);
        return;
      }
      if (!window.fetch || !window.FormData) return; // fall back to a normal post
      e.preventDefault();
      const btn = form.querySelector('[data-submit]');
      const label = form.querySelector('[data-submit-label]');
      const original = label?.textContent;
      btn?.setAttribute('disabled', '');
      if (label) label.textContent = 'Sending…';
      try {
        const res = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' }, credentials: 'same-origin' });
        let json;
        try {
          json = await res.json();
        } catch {
          // Not JSON (e.g. a proxy error page). Don't re-post: the server may already have saved the lead.
          json = { ok: false, errors: {}, message: "Sorry, something went wrong sending your message. Please email info@webulexpro.com or message us on WhatsApp." };
        }
        if (json.ok) {
          track('generate_lead', { form_type: form.querySelector('[name="form_type"]')?.value, package: form.querySelector('[name="package"]')?.value || undefined });
          const tpl = form.parentElement?.querySelector('[data-success-template]') || document.querySelector('[data-success-template]');
          const card = form.closest('.form-card') || form;
          if (tpl) {
            const success = tpl.content.firstElementChild.cloneNode(true);
            card.replaceWith(success);
            success.focus();
          }
          return;
        }
        showErrors(form, json.errors || {}, json.message);
        window.turnstile?.reset?.();
      } catch {
        // Network problem: let the browser post the form the normal way.
        form.submit();
        return;
      } finally {
        btn?.removeAttribute('disabled');
        if (label && original) label.textContent = original;
      }
    });
  });

  // Focus the server-rendered error summary after a no-JS style redirect.
  const alert = document.querySelector('[data-form-alert]:not([hidden])');
  if (alert) alert.focus();
  const success = document.querySelector('[data-form-success]');
  if (success && location.search.includes('sent=1')) {
    success.focus();
    track('generate_lead', { form_type: 'post' });
  }
}

// "We're online now" note, using the visitor's clock and our Sri Lanka working hours.
export function initOnlineStatus() {
  const el = document.querySelector('[data-online-status]');
  if (!el) return;
  let hours;
  try {
    hours = JSON.parse(el.dataset.onlineStatus);
  } catch {
    return;
  }
  const parts = new Intl.DateTimeFormat('en-GB', { timeZone: 'Asia/Colombo', hour: 'numeric', hour12: false, weekday: 'short' }).formatToParts(new Date());
  const hour = Number(parts.find((p) => p.type === 'hour')?.value);
  const day = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].indexOf(parts.find((p) => p.type === 'weekday')?.value);
  const online = hours.days.includes(day) && hour >= hours.start && hour < hours.end;
  const start = new Date();
  const local = new Intl.DateTimeFormat(undefined, { hour: 'numeric', minute: '2-digit' }).format(start);
  el.innerHTML = '';
  const dot = document.createElement('span');
  dot.className = `status-dot${online ? ' status-dot--on' : ''}`;
  el.append(dot, online ? `We're online now (your time: ${local}). Expect a quick reply.` : `We're offline right now (your time: ${local}). Leave a message and we'll reply within one business day.`);
}
