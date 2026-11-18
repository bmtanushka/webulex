// Local smoke + accessibility tests. Needs the dev server running:
//   php -S 127.0.0.1:8000 -t public_html public_html/index.php
// Run: NODE_PATH=tools/node_modules node tests/smoke.cjs [base-url]
'use strict';
const { chromium } = require('playwright');
const { AxeBuilder } = require('@axe-core/playwright');

const BASE = process.argv[2] || 'http://127.0.0.1:8000';
let failed = 0;
const check = (ok, msg) => {
  console.log(`${ok ? 'PASS' : 'FAIL'}  ${msg}`);
  if (!ok) failed++;
};

(async () => {
  const browser = await chromium.launch();
  const ctx = await browser.newContext();
  const page = await ctx.newPage();

  // Status codes
  const expect = {
    '/': 200, '/services': 200, '/services/build': 200, '/services/seo': 200,
    '/packages': 200, '/packages/complete-business-launch': 200, '/packages/starter-online-presence': 200,
    '/packages/growth-marketing-plan': 200, '/packages/ai-sales-assistant': 200, '/packages/ecommerce-launch': 200, '/packages/nope': 404,
    '/industries': 200, '/industries/cleaning-companies': 200, '/industries/handyman-services': 200, '/industries/sole-traders': 200, '/industries/nope': 404,
    '/regions/us': 200, '/regions/uk': 200, '/regions/sg': 200, '/regions/au': 200, '/regions/xx': 404,
    '/how-we-work': 200, '/about': 200, '/blog': 200, '/blog/what-is-aieo': 200, '/blog/nope': 404,
    '/privacy': 200, '/terms': 200, '/cookies': 200, '/contact': 200, '/free-consultation': 200, '/api/lead.php': 405, '/definitely-not-a-page': 404,
    '/app/helpers.php': 403, '/content/site.php': 403, '/templates/layout.php': 403, '/robots.txt': 200,
  };
  for (const [path, status] of Object.entries(expect)) {
    const res = await page.request.get(BASE + path, { maxRedirects: 0 });
    check(res.status() === status, `${path} → ${res.status()} (expected ${status})`);
  }

  // Every service and area page returns 200 with one H1 (slugs read from the services overview links)
  await page.goto(BASE + '/services');
  const svcLinks = [...new Set(await page.$$eval('a[href^="/services/"]', (as) => as.map((a) => a.getAttribute('href'))))];
  let svcOk = 0;
  for (const href of svcLinks) {
    const res = await page.request.get(BASE + href);
    const html = await res.text();
    if (res.status() === 200 && (html.match(/<h1/g) || []).length === 1) svcOk++;
    else console.log('  bad:', href, res.status());
  }
  check(svcOk === svcLinks.length && svcLinks.length >= 31, `${svcOk}/${svcLinks.length} service and area pages OK`);

  // Home: one H1, no console errors, no horizontal scroll at phone widths
  const errors = [];
  page.on('pageerror', (e) => errors.push(e.message));
  page.on('console', (m) => m.type() === 'error' && errors.push(m.text()));
  for (const width of [360, 768, 1024, 1440]) {
    await page.setViewportSize({ width, height: 900 });
    await page.goto(BASE + '/', { waitUntil: 'networkidle' });
    const sw = await page.evaluate(() => document.documentElement.scrollWidth);
    check(sw <= width, `no horizontal scroll at ${width}px (scrollWidth ${sw})`);
  }
  check((await page.locator('h1').count()) === 1, 'home has exactly one H1');
  check(errors.length === 0, `no console errors ${errors.join(' | ')}`);

  // Mega-menu opens by keyboard and closes with Escape
  await page.setViewportSize({ width: 1440, height: 900 });
  await page.goto(BASE + '/');
  const toggle = page.locator('.primary-nav__toggle').first();
  await toggle.focus();
  await page.keyboard.press('Enter');
  check(await page.locator('#mega-services').isVisible(), 'services mega-menu opens with keyboard');
  await page.keyboard.press('Escape');
  await page.waitForTimeout(250);
  check(!(await page.locator('#mega-services').isVisible()), 'mega-menu closes with Escape');

  // Mobile menu
  await page.setViewportSize({ width: 375, height: 800 });
  await page.goto(BASE + '/');
  await page.locator('[data-menu-btn]').click();
  check(await page.locator('#mobile-nav').isVisible(), 'mobile menu opens');
  check((await page.locator('[data-menu-btn]').getAttribute('aria-expanded')) === 'true', 'mobile menu button reports expanded');

  // axe on key templates at desktop and mobile
  for (const width of [375, 1440]) {
    await page.setViewportSize({ width, height: 900 });
    for (const path of ['/', '/services', '/services/grow', '/services/seo', '/packages', '/packages/complete-business-launch', '/packages/ai-sales-assistant', '/industries', '/industries/cleaning-companies', '/contact', '/free-consultation', '/how-we-work', '/about', '/regions/us', '/blog', '/blog/local-seo-for-cleaning-companies', '/privacy', '/definitely-not-a-page']) {
      await page.goto(BASE + path, { waitUntil: 'networkidle' });
      const res = await new AxeBuilder({ page }).withTags(['wcag2a', 'wcag2aa', 'wcag21aa', 'wcag22aa']).analyze();
      const serious = res.violations.filter((v) => ['serious', 'critical'].includes(v.impact));
      check(serious.length === 0, `axe ${path} @${width}px: ${serious.map((v) => v.id + ' (' + v.nodes.length + ')').join(', ') || 'no serious issues'}`);
    }
  }

  // Feeds and security headers
  let res = await page.request.get(BASE + '/sitemap.xml');
  const xml = await res.text();
  check(res.status() === 200 && (res.headers()['content-type'] || '').includes('xml') && (xml.match(/<url>/g) || []).length >= 50, `sitemap.xml lists ${(xml.match(/<url>/g) || []).length} pages`);
  check(!xml.includes('/blog/what-is-aieo'), 'draft posts are not in the sitemap');
  res = await page.request.get(BASE + '/llms.txt');
  check(res.status() === 200 && (await res.text()).startsWith('# Webulex'), 'llms.txt is served');
  res = await page.request.get(BASE + '/');
  const h = res.headers();
  check((h['content-security-policy'] || '').includes("nonce-") && (h['content-security-policy'] || '').includes("object-src 'none'"), 'home sends a Content-Security-Policy with a nonce');
  check(h['x-content-type-options'] === 'nosniff' && !!h['referrer-policy'] && !!h['permissions-policy'], 'home sends the other security headers');
  const og = await page.goto(BASE + '/industries/sole-traders').then(() => page.getAttribute('meta[property="og:image"]', 'content'));
  check(og.endsWith('/assets/img/og/sole-traders.png') && (await page.request.get(BASE + '/assets/img/og/sole-traders.png')).status() === 200, 'pages point to their own share image');

  // hreflang only between home and regional pages; US page uses en-US
  await page.goto(BASE + '/regions/us');
  check((await page.getAttribute('html', 'lang')) === 'en-US' && (await page.locator('link[hreflang]').count()) === 5, 'US page is en-US with 5 hreflang links');
  await page.goto(BASE + '/services');
  check((await page.locator('link[hreflang]').count()) === 0, 'non-regional pages have no hreflang');

  // Comparison table: tabs on phones, full table on desktop
  await page.setViewportSize({ width: 375, height: 900 });
  await page.goto(BASE + '/industries/handyman-services', { waitUntil: 'networkidle' });
  await page.locator('.compare__tab').first().click();
  check((await page.locator('.compare__table tbody tr:first-child td:visible').count()) === 1, 'comparison shows one tier at a time on phones');
  await page.setViewportSize({ width: 1440, height: 900 });
  await page.goto(BASE + '/industries/handyman-services', { waitUntil: 'networkidle' });
  check((await page.locator('.compare__table tbody tr:first-child td:visible').count()) === 3 && !(await page.locator('.compare__tabs').isVisible()), 'comparison shows all tiers on desktop');

  // No-JS: mega-menu reachable via focus, mobile menu via :target
  const nojs = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 375, height: 800 } });
  const p2 = await nojs.newPage();
  await p2.goto(BASE + '/');
  await p2.locator('[data-menu-btn]').click();
  check(await p2.locator('#mobile-nav').isVisible(), 'mobile menu opens without JS');
  await nojs.close();

  await browser.close();
  console.log(failed ? `\n${failed} check(s) failed` : '\nAll checks passed');
  process.exit(failed ? 1 : 0);
})();
