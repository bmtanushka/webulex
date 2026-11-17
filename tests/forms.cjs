// Lead form tests (run with FORM_TEST_MODE => true in config.php). Clears nothing on the server;
// delete storage/ratelimit.json before running so the 5-per-hour limit starts fresh.
'use strict';
const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');
const BASE = process.argv[2] || 'http://127.0.0.1:8000';
let failed = 0;
const check = (ok, msg) => { console.log(`${ok ? 'PASS' : 'FAIL'}  ${msg}`); if (!ok) failed++; };
const LOG = path.join(__dirname, '..', 'storage', 'logs', 'test-leads.log');

async function fill(page, extra = {}) {
  await page.fill('#f-name', extra.name ?? 'Test Person');
  await page.fill('#f-email', extra.email ?? 'test@example.com');
  await page.selectOption('#f-country', extra.country ?? 'GB');
  if (await page.locator('#f-message').count()) await page.fill('#f-message', extra.message ?? 'We need a new website with online booking.');
  if (extra.consent !== false) await page.check('#f-consent');
}

(async () => {
  const b = await chromium.launch();
  const before = fs.existsSync(LOG) ? fs.readFileSync(LOG, 'utf8').split('\n').filter(Boolean).length : 0;

  // 1. JS: client-side errors, then a successful fetch submit with a pre-selected package
  let ctx = await b.newContext({ viewport: { width: 1280, height: 900 } });
  let p = await ctx.newPage();
  await p.goto(BASE + '/contact?package=cleaning-companies:clean-growth&utm_source=test&utm_campaign=spring');
  check(await p.locator('.form-context').innerText().then((t) => t.includes('Clean Growth')), 'package from the link is shown');
  check(await p.locator('input[value="industry:cleaning-companies"]').isChecked(), 'matching interest is pre-ticked');
  await p.locator('[data-cookie="reject"]').click();
  await p.click('[data-submit]');
  check(await p.locator('#err-name').isVisible() && await p.locator('#err-consent').isVisible(), 'empty submit shows field errors');
  check((await p.locator('#f-name').getAttribute('aria-describedby') || '').includes('err-name'), 'errors are linked with aria-describedby');
  await fill(p);
  await p.click('[data-submit]');
  await p.locator('[data-form-success]').waitFor({ timeout: 8000 });
  check(true, 'JS submit shows the success message');
  await ctx.close();

  // 2. No JS: errors come back from the server with input kept, then success redirect
  ctx = await b.newContext({ javaScriptEnabled: false, viewport: { width: 1280, height: 900 } });
  p = await ctx.newPage();
  await p.goto(BASE + '/contact');
  await fill(p, { email: 'not-an-email', consent: false });
  await p.click('[data-submit]');
  await p.waitForLoadState();
  check(p.url().includes('/contact'), 'no-JS error post returns to the contact page');
  check(await p.locator('.form-alert--error').isVisible(), 'server error summary is shown');
  check(await p.locator('#err-email').isVisible() && await p.locator('#err-consent').isVisible(), 'server field errors are shown');
  check((await p.inputValue('#f-name')) === 'Test Person', 'typed input is kept after an error');
  await p.fill('#f-email', 'nojs@example.com');
  await p.check('#f-consent');
  await p.click('[data-submit]');
  await p.waitForLoadState();
  check(p.url().includes('sent=1') && await p.locator('[data-form-success]').isVisible(), 'no-JS success redirects to the thank-you state');
  await ctx.close();

  // 3. Consultation short form (message optional)
  ctx = await b.newContext({ viewport: { width: 390, height: 844 } });
  p = await ctx.newPage();
  await p.goto(BASE + '/free-consultation');
  check(await p.locator('.primary-nav').count() === 0, 'consultation page has no main navigation');
  await p.locator('[data-cookie="accept"]').click();
  await fill(p, { message: '' });
  await p.click('[data-submit]');
  await p.locator('[data-form-success]').waitFor({ timeout: 8000 });
  check(true, 'consultation form submits without a message');
  const consent = (await ctx.cookies()).find((c) => c.name === 'wbx_consent');
  check(!!consent && decodeURIComponent(consent.value).includes('"analytics":true'), 'cookie choice is stored');
  await ctx.close();

  // 4. Security: no CSRF token, honeypot, wrong method
  const api = await b.newContext();
  let r = await api.request.post(BASE + '/api/lead.php', { headers: { Accept: 'application/json' }, form: { name: 'x', email: 'x@example.com', country: 'GB', message: 'hello there friend', consent: '1' } });
  check(r.status() === 419, `missing CSRF token is rejected (${r.status()})`);
  r = await api.request.post(BASE + '/api/lead.php', { headers: { Accept: 'application/json' }, form: { website: 'spam.example', name: 'bot' } });
  check(r.status() === 200 && (await r.json()).ok === true, 'honeypot submissions are silently dropped');
  r = await api.request.get(BASE + '/api/lead.php');
  check(r.status() === 405, 'GET on the endpoint returns 405');
  await api.close();

  // 5. Leads were logged in test mode
  const after = fs.existsSync(LOG) ? fs.readFileSync(LOG, 'utf8').split('\n').filter(Boolean) : [];
  check(after.length - before === 3, `3 test leads logged (${after.length - before})`);
  const first = JSON.parse(after[before] || '{}');
  check(first.utm_source === 'test' && first.package === 'cleaning-companies:clean-growth' && first.country === 'GB' && first.currency === 'GBP', 'lead carries UTM, package, country and currency');

  // 6. Rate limit: 5 per hour per IP (3 used above)
  ctx = await b.newContext();
  p = await ctx.newPage();
  let last = 0;
  for (let i = 0; i < 3; i++) {
    await p.goto(BASE + '/contact');
    const token = await p.inputValue('input[name="csrf"]');
    const res = await p.request.post(BASE + '/api/lead.php', { headers: { Accept: 'application/json' }, form: { csrf: token, name: 'R', email: 'r@example.com', country: 'US', message: 'rate limit test message', consent: '1' } });
    last = res.status();
  }
  check(last === 429, `6th submission in an hour is rate-limited (${last})`);
  await ctx.close();

  await b.close();
  console.log(failed ? `\n${failed} check(s) failed` : '\nAll form checks passed');
  process.exit(failed ? 1 : 0);
})();
