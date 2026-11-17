# Webulex website: to-do list

Everything that is waiting on the owner, or deferred until later, in one place.
Tick items off as they are done. Updated at the end of every build phase.

**Build progress:** Phases 1–4 done (foundation, home, services, packages and industries).
Next: Phase 5 (contact, forms, booking, analytics) → 6 (content and trust pages) → 7 (SEO and hardening) → 8 (deploy).

---

## 1. Hosting and launch (blocks going live)

- [ ] **Point webulexpro.com's DNS at Hostinger.** The domain is not registered in the Hostinger account, so change it at the current registrar: either Hostinger's nameservers, or an A record to the website's IP shown in hPanel. *(The empty website was created on the jello.lk plan on 17 Nov 2026; the other sites on that plan were not touched.)*
- [ ] **Turn on free SSL** for webulexpro.com in hPanel once DNS points to Hostinger.
- [ ] **Set PHP to 8.2 or later** for webulexpro.com (hPanel → Advanced → PHP Configuration) and enable `curl`, `mbstring`, `openssl`, `fileinfo`.
- [ ] **Create a private GitHub repo** and tell Claude its name. Hostinger's tools deploy from Git, and the cloud container this site is built in is temporary.
- [ ] **Connect GitHub to Hostinger once** in hPanel → Advanced → Git, so deploys can run from the repo.
- [ ] **Confirm the live deploy** when asked (Phase 8). Nothing is uploaded to the live domain without your go-ahead.
- [ ] **Upload `config.php`** one level above `public_html` with the real secrets (template: `config.sample.php`). Claude will guide this in Phase 8.
- [ ] **Submit the sitemap** in Google Search Console after launch.
- [ ] *(Optional)* Put the domain behind Cloudflare (free plan) for a CDN, Turnstile and visitor-country detection.

## 2. Accounts and keys needed for Phase 5 (forms, booking, analytics)

- [ ] Mailbox `info@webulexpro.com` (Hostinger Email or your existing provider) and its SMTP password.
- [ ] n8n webhook URL for new leads.
- [ ] Cloudflare Turnstile site key and secret.
- [ ] Booking link (Cal.com or Calendly).
- [ ] Google Analytics 4 measurement ID (G-…).
- [ ] *(Optional)* Chatbot widget script URL.

## 3. Facts to confirm (shown on the site as draft wording)

- [ ] **Working hours and time-zone overlap** for each region. Draft lines on the home page region tiles: "US: your morning, with flexible evening calls", "UK: your morning and early afternoon", "Singapore: most of your working day", "Australia: your afternoon". → `public_html/content/home.php`
- [ ] **Reply-time promise** ("within one business day" is planned for the contact page in Phase 5).
- [ ] **Invoicing currencies** (FAQ says USD, GBP, SGD or AUD) and payment methods. → `public_html/content/faqs.php`
- [ ] **Prices** per package and per industry tier, in each currency if they differ. All packages show "Price on request" until then. → add `'prices'` in `public_html/content/packages.php` / `industries.php`, then set `SHOW_PRICES => true` in `config.php`.
- [ ] **Accounting services:** the company name includes "Accounting". Decide whether to add bookkeeping and cloud accounting as a service area, or explain the name on the About page (Phase 6).

## 4. Content to review (drafted by Claude, marked `REVIEW(owner)` in the files)

- [ ] **Service pages:** "who it's for", 2–3 outcomes and 3 FAQs for each of the 27 services. → `public_html/content/service-details.php`
- [ ] **Area pages:** 4-step process and 3 FAQs for each of Build, Grow, Promote and Automate. → same file
- [ ] **Packages FAQs** (5). → `public_html/content/package-extras.php`
- [ ] **Industry FAQs** (3 each for cleaning, handyman, sole traders). → `public_html/content/industries.php`
- [ ] **Industry hero labels** (illustrative notification chips such as "New booking · Fri 09:00"). → `public_html/content/industries.php`
- [ ] Page titles and descriptions: written to fit search limits; check the wording reads well for you.

## 5. Brand and assets

- [ ] **Original logo file:** the site uses an SVG rebuilt from your logo (`tools/make-logo.py`). Check it matches; the original PNG was not recoverable from the other session.
- [ ] **Industry illustrations** (cleaning, handyman, sole traders), plus booking, global and contact. Pages currently use icon-based art. Either: download unDraw SVGs yourself into `public_html/assets/illustrations/` with the names in the brief §6.6, or ask Claude to draw more in `tools/draw-illustrations.mjs`.
- [ ] **Favicon / app icon:** an SVG favicon is generated; supply a PNG/ICO version if you want one for older browsers.
- [ ] **Social media profile URLs** (Facebook, Instagram, LinkedIn, X, YouTube). → `public_html/content/site.php`

## 6. Trust content (hidden until supplied)

- [ ] **Testimonials, client logos or case studies**, with permission. Then set `SHOW_TESTIMONIALS => true`. → `public_html/content/testimonials.php`
- [ ] **Founder / team bio and photo** for the About page (optional; hidden until supplied, Phase 6).

## 7. Legal (Phase 6 drafts)

- [ ] Legal review of the privacy policy, cookie policy and terms before launch. Claude's drafts will be clearly marked as drafts, not legal advice.

## 8. Technical items deferred to later phases

- [ ] **Phase 5:** install PHPMailer and Parsedown. Composer is restricted in the build container; plan is to vendor them another way or install from the repo.
- [ ] **Phase 5:** "Get a quote" links (`/contact?service=…`, `/contact?package=…`) will pre-fill the contact form. Until then they reach a "Coming soon" page.
- [ ] **Phase 6:** About, How we work, regional pages, blog (with 3 draft posts) and legal pages. Until then these show a "Coming soon" page that is hidden from search engines.
- [ ] **Phase 7:** Open Graph images per area, package and industry (`assets/img/og/`); sitemap route; `llms.txt`; security headers (HSTS, Content-Security-Policy); `LAUNCH_CHECKLIST.md`.
- [ ] **Phase 7:** remove the unused `world-dots-dark.svg` output, or keep it for other pages.
- [ ] Save the brief into the repo as `BRIEF.md`.
- [ ] Re-measure Lighthouse on the live site after deploy (local scores: 100 across the board on every page type built so far).
