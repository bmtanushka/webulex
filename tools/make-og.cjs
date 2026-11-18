// Local-only: generates 1200×630 Open Graph images into public_html/assets/img/og/.
// One default image, one per service area, package and industry. Re-run after changing titles.
// Run from the project root: node tools/make-og.cjs   (needs Playwright; php is used to read the content arrays)
'use strict';
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');
const { chromium } = require('playwright');

const root = path.join(__dirname, '..');
const pub = path.join(root, 'public_html');
const out = path.join(pub, 'assets', 'img', 'og');
fs.mkdirSync(out, { recursive: true });

// Read the content arrays through PHP so titles always match the site.
const data = JSON.parse(execFileSync('php', ['-r', `
  define('APP_ROOT', ${JSON.stringify(pub)});
  $s = require APP_ROOT . '/content/services.php';
  $p = require APP_ROOT . '/content/packages.php';
  $i = require APP_ROOT . '/content/industries.php';
  echo json_encode(['areas' => $s['areas'], 'packages' => $p, 'industries' => $i]);
`]).toString());

const b64 = (f) => fs.readFileSync(f).toString('base64');
const font = (f) => `url(data:font/woff2;base64,${b64(path.join(pub, 'assets', 'fonts', f))}) format('woff2')`;
const logo = `data:image/svg+xml;base64,${b64(path.join(pub, 'assets', 'brand', 'webulex-logo-light.svg'))}`;
const ill = (name) => {
  const f = path.join(pub, 'assets', 'illustrations', `${name}.svg`);
  return fs.existsSync(f) ? `data:image/svg+xml;base64,${b64(f)}` : null;
};

const jobs = [{ file: 'default', kicker: 'Web · SEO · Ads · AI Automation', title: 'Build. Grow. Promote. <span>Automate.</span>', sub: 'Websites, marketing and AI automation for businesses in the US, UK, Singapore and Australia.', art: ill('hero-team') }];
for (const [slug, a] of Object.entries(data.areas)) {
  jobs.push({ file: slug, kicker: `${a.short} · Services`, title: a.title, sub: a.intro, art: ill(slug) });
}
for (const [slug, p] of Object.entries(data.packages)) {
  jobs.push({ file: slug, kicker: `${p.flagship ? 'Flagship package' : 'Package'} · ${p.timeline}`, title: p.title, sub: p.ideal_for, art: null, chips: (p.includes || p.groups.map((g) => g.title)).slice(0, 4) });
}
for (const [slug, i] of Object.entries(data.industries)) {
  jobs.push({ file: slug, kicker: i.kicker, title: `${i.headline[0]} <span>${i.headline[1]}</span>`, sub: i.intro, art: ill(i.illustration), chips: i.tiers.map((t) => `${t.name} · ${t.timeline}`) });
}

const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
const html = (j) => `<!doctype html><html><head><style>
@font-face{font-family:Outfit;font-weight:700;src:${font('outfit-latin-700-normal.woff2')}}
@font-face{font-family:Inter;font-weight:400;src:${font('inter-latin-400-normal.woff2')}}
@font-face{font-family:Inter;font-weight:600;src:${font('inter-latin-600-normal.woff2')}}
*{box-sizing:border-box;margin:0}
body{width:1200px;height:630px;overflow:hidden;font-family:Inter;color:#fff;
 background:radial-gradient(70% 90% at 100% 0%,rgba(41,182,246,.45),transparent 60%),radial-gradient(60% 80% at 0% 100%,rgba(217,70,239,.35),transparent 60%),#141A4A;
 display:grid;grid-template-columns:${j.art ? '1.25fr 1fr' : '1fr'};gap:40px;padding:64px 72px;align-items:center}
.logo{height:44px;margin-bottom:46px}
.k{font-weight:600;font-size:20px;letter-spacing:.12em;text-transform:uppercase;color:#29B6F6;margin-bottom:18px}
h1{font-family:Outfit;font-weight:700;font-size:${j.title.length > 40 ? 58 : 68}px;line-height:1.04;letter-spacing:-.02em;margin-bottom:22px}
h1 span{background:linear-gradient(100deg,#29B6F6,#7FD3FA 35%,#D946EF);-webkit-background-clip:text;color:transparent}
p{font-size:24px;line-height:1.45;color:rgba(255,255,255,.85);max-width:640px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.chips{display:flex;flex-wrap:wrap;gap:10px;margin-top:26px}.chips span{padding:8px 16px;border-radius:999px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);font-size:18px;font-weight:600}
.art{background:linear-gradient(160deg,rgba(255,255,255,.14),rgba(255,255,255,.04));border:1px solid rgba(255,255,255,.18);border-radius:28px;padding:18px}
.art img{width:100%;display:block}
.url{position:absolute;left:72px;bottom:40px;font-size:20px;font-weight:600;color:rgba(255,255,255,.7)}
</style></head><body>
<div><img class="logo" src="${logo}" alt=""><div class="k">${esc(j.kicker)}</div><h1>${j.title}</h1><p>${esc(j.sub)}</p>
${j.chips ? `<div class="chips">${j.chips.map((c) => `<span>${esc(c)}</span>`).join('')}</div>` : ''}</div>
${j.art ? `<div class="art"><img src="${j.art}" alt=""></div>` : ''}
<div class="url">webulexpro.com</div></body></html>`;

(async () => {
  const b = await chromium.launch();
  const p = await b.newPage({ viewport: { width: 1200, height: 630 } });
  for (const j of jobs) {
    await p.setContent(html(j), { waitUntil: 'load' });
    await p.evaluate(() => document.fonts.ready);
    const file = path.join(out, `${j.file}.png`);
    await p.screenshot({ path: file });
    console.log(`${j.file}.png  ${(fs.statSync(file).size / 1024).toFixed(0)} KB`);
  }
  await b.close();
})();
// After generating, shrink the PNGs: python3 tools/shrink-png.py public_html/assets/img/og/*.png
