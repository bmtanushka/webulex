# Webulex website: to-do list

Everything that is waiting on the owner, or deferred until later, in one place.
Tick items off as they are done. Updated at the end of every build phase.

**Build progress:** Phases 1–7 done (everything in the brief is built and tested locally).
Next: Phase 8 (deploy to Hostinger). See also **LAUNCH_CHECKLIST.md** for the technical go-live list and every `TODO(owner)` / `REVIEW(owner)` marker in the code.

---

## 1. Hosting and launch (blocks going live)

- [ ] **Point webulexpro.com's DNS at Hostinger.** The domain is not registered in the Hostinger account, so change it at the current registrar: either Hostinger's nameservers, or an A record to the website's IP shown in hPanel. *(The empty website was created on the jello.lk plan on 17 Nov 2026; the other sites on that plan were not touched.)*
- [ ] **Turn on free SSL** for webulexpro.com in hPanel once DNS points to Hostinger.
- [ ] **Set PHP to 8.2 or later** for webulexpro.com (hPanel → Advanced → PHP Configuration) and enable `curl`, `mbstring`, `openssl`, `fileinfo`.
- [x] **GitHub repo:** `bmtanushka/webulex`. All work is pushed to `main` at the end of each phase.
- [ ] **Check the repo is private** on GitHub (Settings → General → Danger Zone → Change visibility), since it will hold the site's code.
- [ ] **Connect GitHub to Hostinger once** in hPanel → Advanced → Git, so deploys can run from the repo. The web root is `public_html/`, so Phase 8 will publish a `deploy` branch containing only that folder's contents.
- [ ] **Confirm the live deploy** when asked (Phase 8). Nothing is uploaded to the live domain without your go-ahead.
- [ ] **Upload `config.php`** one level above `public_html` with the real secrets (template: `config.sample.php`). Claude will guide this in Phase 8.
- [ ] **Submit the sitemap** in Google Search Console after launch.
- [ ] *(Optional)* Put the domain behind Cloudflare (free plan) for a CDN, Turnstile and visitor-country detection.

## 2. Accounts and keys for the forms, booking and analytics (all go in `config.php` on the server)

The forms are built and tested in test mode. Each feature switches on as soon as its key is added; nothing else needs changing.

- [ ] **Mailbox `info@webulexpro.com`** (Hostinger Email or your existing provider) and its SMTP password → `SMTP_USER`, `SMTP_PASS`. Without it, no notification or confirmation emails are sent.
- [ ] **n8n webhook URL** for new leads → `N8N_LEAD_WEBHOOK_URL`. Each lead arrives as JSON with name, email, phone, country, currency, business type, interests, budget, message, package/service, source page, UTM tags and timestamp.
- [ ] **Cloudflare Turnstile** site key and secret → `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET`. Until then the form relies on CSRF, a hidden spam trap and the 5-per-hour limit.
- [ ] **Booking link** (Cal.com or Calendly) → `BOOKING_URL`. Until then the booking box asks people to suggest a time on WhatsApp.
- [ ] **Google Analytics 4 ID** (G-…) → `GA4_ID`. The cookie banner only appears once this is set; GA loads only after a visitor accepts. Events sent: `generate_lead`, `book_consultation_click`, `whatsapp_click`, `package_quote_click`.
- [ ] *(Optional)* **Chatbot widget script URL** → `CHATBOT_SCRIPT_URL` (loads after the first interaction or 5 seconds).
- [ ] *(Optional)* If the site goes behind Cloudflare, set `TRUST_CLOUDFLARE => true` so the visitor's country is pre-selected on the form.
- [ ] **Check `storage/logs/`** on the server now and then (one level above `public_html`). If both n8n and email ever fail, leads are saved to `failed-leads.log` so none are lost.

## 3. Facts to confirm (shown on the site as draft wording)

- [ ] **Working hours and time-zone overlap** for each region. ⚠ The time-zone table on `/how-we-work` and the regional pages shows that a US 09:00–17:00 day is 19:30–03:30 in Sri Lanka. Confirm the hours you will actually cover for US clients, then adjust the US wording. Draft lines on the home page region tiles: "US: your morning, with flexible evening calls", "UK: your morning and early afternoon", "Singapore: most of your working day", "Australia: your afternoon". → `public_html/content/home.php`
- [ ] **Reply-time promise:** "within one business day" now appears on the contact page, the form, the thank-you message and the confirmation email.
- [ ] **Working hours (Sri Lanka time)** for the "We're online now" note on the contact page. Draft: Mon–Fri 09:00–18:00. → `working_hours` in `public_html/content/site.php`
- [ ] **Invoicing currencies** (FAQ says USD, GBP, SGD or AUD) and payment methods. → `public_html/content/faqs.php`
- [ ] **Prices** per package and per industry tier, in each currency if they differ. All packages show "Price on request" until then. → add `'prices'` in `public_html/content/packages.php` / `industries.php`, then set `SHOW_PRICES => true` in `config.php`.
- [ ] **Accounting services:** the company name includes "Accounting". Decide whether to add bookkeeping and cloud accounting as a service area, or a line explaining the name on the About page (not added yet).

## 4. Content to review (drafted by Claude, marked `REVIEW(owner)` in the files)

- [ ] **Service pages:** "who it's for", 2–3 outcomes and 3 FAQs for each of the 27 services. → `public_html/content/service-details.php`
- [ ] **Area pages:** 4-step process and 3 FAQs for each of Build, Grow, Promote and Automate. → same file
- [ ] **Packages FAQs** (5). → `public_html/content/package-extras.php`
- [ ] **Industry FAQs** (3 each for cleaning, handyman, sole traders). → `public_html/content/industries.php`
- [ ] **Free consultation FAQs** (3). → `public_html/templates/pages/free-consultation.php`
- [ ] **Confirmation email wording** sent to visitors. → `deliver_lead()` in `public_html/app/forms.php`
- [ ] **Industry hero labels** (illustrative notification chips such as "New booking · Fri 09:00"). → `public_html/content/industries.php`
- [ ] Page titles and descriptions: written to fit search limits; check the wording reads well for you.

- [ ] **About page story** (3 paragraphs). → `public_html/templates/pages/about.php`
- [ ] **How we work:** expanded step descriptions and the four commitments (reply within one business day, weekly update, shared project board, you own everything). → `public_html/templates/pages/how-we-work.php`
- [ ] **Regional pages** (US, UK, Singapore, Australia): intro, three focus points, time-zone note and 3 FAQs each. Each is 70–76% unique. → `public_html/content/regions.php`
- [ ] **Blog posts:** review the three drafts, then publish each by changing `draft: true` to `draft: false`. → `public_html/content/blog/*.md`

## 5. Brand and assets

- [ ] **Original logo file:** the site uses an SVG rebuilt from your logo (`tools/make-logo.py`). Check it matches; the original PNG was not recoverable from the other session.
- [ ] **Industry illustrations** (cleaning, handyman, sole traders), plus booking, global and contact. Pages currently use icon-based art. Either: download unDraw SVGs yourself into `public_html/assets/illustrations/` with the names in the brief §6.6, or ask Claude to draw more in `tools/draw-illustrations.mjs`.
- [x] Favicon (SVG + ICO) and app icons (180, 192, 512 px) generated from the logo mark. Replace them if you have an official icon.
- [ ] **Social media profile URLs** (Facebook, Instagram, LinkedIn, X, YouTube). → `public_html/content/site.php`

## 6. Trust content (hidden until supplied)

- [ ] **Testimonials, client logos or case studies**, with permission. Then set `SHOW_TESTIMONIALS => true`. → `public_html/content/testimonials.php`
- [ ] **Founder / team bio and photo** for the About page (optional). Add `public_html/content/team.php` and set `SHOW_TEAM => true`.

## 7. Legal

- [ ] **Legal review** of `/privacy`, `/cookies` and `/terms` before launch. The drafts cover UK GDPR and EU GDPR, Australia's Privacy Act, Singapore's PDPA, US state laws (e.g. CCPA/CPRA) and Sri Lanka's PDPA, but they are not legal advice. Each page shows a "Draft: pending legal review" notice until you set `LEGAL_REVIEWED => true` in `config.php`. → `public_html/content/legal/*.md`
- [ ] **Name the providers** in the privacy and cookie policies once chosen (booking, CRM, chatbot, any ad pixels).
- [ ] **Data retention periods** in the privacy policy (draft: enquiries kept up to 24 months).

## 8. Technical items deferred to later phases

- [x] PHPMailer and Parsedown installed in `public_html/vendor/` (trimmed to 856 KB by `tools/clean-vendor.php`).
- [x] "Get a quote" links pre-fill the contact form with the service or package.
- [x] The Content-Security-Policy adds Turnstile, GA4, the booking domain and the chatbot domain automatically when their keys are in `config.php`. If a chatbot needs extra hosts, add them with `CSP_EXTRA` (see `app/security.php`).
- [ ] **Phase 8:** send a real test lead on the live site and confirm it reaches n8n and the inbox.
- [x] About, How we work, regional pages, blog (3 draft posts) and legal pages built; the temporary "Coming soon" pages are gone.
- [x] Asset budgets met: CSS 57 KB (12 KB compressed, budget 60 KB), JavaScript 21 KB (budget 30 KB).
- [x] Share images (13), sitemap, `llms.txt`, security headers with a nonce-based Content-Security-Policy, favicon and app icons, `LAUNCH_CHECKLIST.md`.
- [ ] Save the brief into the repo as `BRIEF.md` (paste it in, or ask Claude to add it from the conversation).
- [ ] **Share images:** check the 13 images in `public_html/assets/img/og/`. Regenerate after title changes with `node tools/make-og.cjs` then `python3 tools/shrink-png.py public_html/assets/img/og/*.png`.
- [ ] Re-measure Lighthouse on the live site after deploy (local scores: 100 across the board on every page type built so far).
