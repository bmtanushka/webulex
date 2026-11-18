<?php
declare(strict_types=1);

$GLOBALS['page_meta'] = [
    'title' => 'Webulex | Websites, SEO, Ads & AI Automation',
    'description' => 'Websites, SEO, AIEO, ads and AI automation for small businesses in the US, UK, Singapore and Australia. One accountable team. Book a free consultation.',
    'path' => '/',
    'alternates' => region_alternates(),
    'schema' => [[
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Webulex',
        'url' => absolute_url('/'),
    ]],
];
$regions = (array) site('regions');
$home = content('home');
$areas = content('services')['areas'];
$industries = content('industries');
?>
<section class="hero" aria-labelledby="hero-title">
  <div class="hero__bg" aria-hidden="true">
    <span class="blob blob--1"></span>
    <span class="blob blob--2"></span>
    <span class="blob blob--3"></span>
    <div class="hero__map">
      <div class="hero__dots" style="--map-mask: url('<?= e(asset('img/world-dots-mask.svg')) ?>')"></div>
      <?= partial('world-pins') ?>
    </div>
  </div>

  <div class="container hero__grid">
    <div class="hero__copy">
      <p class="kicker kicker--cyan">Web · SEO · Ads · AI Automation</p>
      <h1 class="hero__title" id="hero-title">Build. Grow. Promote. <span class="gradient-text">Automate.</span></h1>
      <p class="hero__sub">Your complete digital partner for websites, marketing and AI-powered automation, serving businesses across the US, UK, Singapore and Australia.</p>
      <div class="hero__ctas">
        <a class="btn btn--accent btn--lg" href="/free-consultation" data-event="book_consultation_click">Book a free consultation <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost-light btn--lg" href="/packages">See our packages</a>
      </div>
      <ul class="region-chips" role="list" aria-label="Markets we serve">
        <?php foreach ($regions as $code => $r): ?>
          <li><a class="region-chip" href="/regions/<?= e($code) ?>" data-region="<?= e($code) ?>"><?= partial('flag', ['code' => $r['flag']]) ?><?= e($r['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="hero__visual">
      <?php if (is_file(APP_ROOT . '/assets/illustrations/hero-team.svg')): ?>
        <div class="hero__art glass"><?= illustration('hero-team', '') ?></div>
      <?php else: ?>
        <div class="hero__art glass mock" aria-hidden="true">
          <div class="mock__bar"><span></span><span></span><span></span><i>yourbusiness.com</i></div>
          <div class="mock__body">
            <div class="mock__hero">
              <span class="mock__line mock__line--lg"></span>
              <span class="mock__line"></span>
              <span class="mock__line mock__line--sm"></span>
              <span class="mock__btn">Book now</span>
            </div>
            <div class="mock__cards">
              <span class="mock__card"><?= icon('calendar-check') ?></span>
              <span class="mock__card"><?= icon('search') ?></span>
              <span class="mock__card"><?= icon('bot') ?></span>
            </div>
            <div class="mock__chart">
              <svg viewBox="0 0 200 60" preserveAspectRatio="none"><defs><linearGradient id="mockfill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#29B6F6" stop-opacity=".45"/><stop offset="1" stop-color="#29B6F6" stop-opacity="0"/></linearGradient></defs><path d="M0 52 L25 46 L50 48 L75 36 L100 38 L125 26 L150 22 L175 12 L200 6 L200 60 L0 60Z" fill="url(#mockfill)"/><path d="M0 52 L25 46 L50 48 L75 36 L100 38 L125 26 L150 22 L175 12 L200 6" fill="none" stroke="#29B6F6" stroke-width="2.5" stroke-linejoin="round"/></svg>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="float-cards" aria-hidden="true">
        <div class="float-card float-card--1"><span class="float-card__icon float-card__icon--cyan"><?= icon('calendar-check') ?></span><span><strong>New booking confirmed</strong><small>Tue 10:00</small></span></div>
        <div class="float-card float-card--2"><span class="float-card__icon float-card__icon--magenta"><?= icon('inbox') ?></span><span><strong>Lead captured</strong><small>from Google Ads</small></span></div>
        <div class="float-card float-card--3"><span class="float-card__stars"><?= str_repeat(icon('star'), 5) ?></span><span><strong>New Google review</strong></span></div>
        <div class="float-card float-card--4"><span class="float-card__icon float-card__icon--cyan"><?= icon('trending-up') ?></span><span><strong>#1</strong><small>for ‘cleaners near me’</small></span></div>
      </div>
    </div>
  </div>
</section>

<!-- What we do -->
<section class="section" aria-labelledby="what-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'What we do', 'title' => 'One team for everything your business needs online', 'id' => 'what-title', 'align' => 'center']) ?>
    <div class="grid grid--4 area-grid">
      <?php foreach ($areas as $slug => $area): ?>
        <a class="card area-card area-card--<?= e($area['accent']) ?>" href="/services/<?= e($slug) ?>" data-reveal>
          <?= illustration($slug, '', 'area-card__art') ?>
          <span class="area-card__body">
            <span class="kicker kicker--<?= e($area['accent'] === 'cyan' ? 'navy' : 'magenta') ?>"><?= e($area['short']) ?></span>
            <span class="area-card__title"><?= e($area['title']) ?></span>
            <span class="area-card__text"><?= e($area['summary']) ?></span>
            <span class="card-link">Explore <?= e(strtolower($area['short'])) ?> <?= icon('arrow-right') ?></span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Problems we solve -->
<section class="section section--tint" aria-labelledby="problems-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Problems we solve', 'title' => 'Sound familiar?', 'id' => 'problems-title', 'align' => 'center']) ?>
    <div class="grid grid--2">
      <?php foreach ($home['problems'] as $p): ?>
        <article class="card problem-card" data-reveal>
          <span class="icon-tile"><?= icon($p['icon']) ?></span>
          <div>
            <h3 class="problem-card__problem">&ldquo;<?= e($p['problem']) ?>&rdquo;</h3>
            <p class="problem-card__solution"><?= icon('arrow-right', 'problem-card__arrow') ?><span><?= e($p['solution']) ?></span></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Flagship package teaser -->
<section class="section" aria-labelledby="flagship-title">
  <div class="container flagship">
    <div class="flagship__copy" data-reveal>
      <p class="kicker kicker--magenta">Flagship package</p>
      <h2 id="flagship-title">From scratch to a fully working online business in 4 months</h2>
      <p class="lead">A website that takes bookings, marketing that brings in leads, and AI that follows them up for you, delivered month by month by one team.</p>
      <ol class="roadmap-mini" role="list">
        <?php foreach ($home['roadmap'] as $i => $m): ?>
          <li class="roadmap-mini__step">
            <span class="roadmap-mini__num" aria-hidden="true"><?= $i + 1 ?></span>
            <span><span class="roadmap-mini__month"><?= e($m['month']) ?></span><strong><?= e($m['title']) ?></strong></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
    <aside class="flagship__card" data-reveal aria-label="Complete Business Launch">
      <span class="badge">4 months · one team</span>
      <h3>Complete Business Launch</h3>
      <ul role="list" class="tick-list tick-list--light">
        <li><?= icon('check') ?>Website with booking and landing pages</li>
        <li><?= icon('check') ?>SEO, Local SEO and AIEO</li>
        <li><?= icon('check') ?>Google and social media ads</li>
        <li><?= icon('check') ?>AI chatbot, call agent and CRM follow-up</li>
      </ul>
      <a class="btn btn--accent" href="/packages/complete-business-launch">Explore the Complete Business Launch <?= icon('arrow-right') ?></a>
      <p class="flagship__note">Price on request. Ad budgets and third-party costs are quoted separately.</p>
    </aside>
  </div>
</section>

<!-- Packages for your type of business -->
<section class="section section--surface" aria-labelledby="industries-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'By business type', 'title' => 'Packages built around how you work', 'id' => 'industries-title', 'align' => 'center']) ?>
    <div class="grid grid--3">
      <?php foreach ($home['industry_cards'] as $slug => $line): $ind = $industries[$slug]; ?>
        <a class="card industry-card" href="/industries/<?= e($slug) ?>" data-reveal>
          <span class="industry-card__art" aria-hidden="true">
            <?php if (is_file(APP_ROOT . '/assets/illustrations/' . $ind['illustration'] . '.svg')): ?>
              <?= illustration($ind['illustration']) ?>
            <?php else: ?>
              <span class="industry-card__icon"><?= icon($ind['icon']) ?></span>
            <?php endif; ?>
          </span>
          <span class="industry-card__title"><?= e($ind['title']) ?></span>
          <span class="industry-card__line"><?= e($line) ?></span>
          <span class="card-link">See the packages <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="center-note">Don't see your industry? <a href="/contact">We tailor every package.</a></p>
  </div>
</section>

<!-- Global delivery -->
<section class="section global" aria-labelledby="global-title">
  <div class="container global__grid">
    <div class="global__copy" data-reveal>
      <p class="kicker kicker--magenta">Global delivery</p>
      <h2 id="global-title">Based in Sri Lanka. Working in your time zone.</h2>
      <p class="lead">Our team works with clients in the US, UK, Singapore and Australia. We plan our hours to overlap your working day, reply quickly on email and WhatsApp, and keep you updated with clear weekly progress notes.</p>
    </div>
    <div class="global__map" data-reveal>
      <img src="<?= e(asset('img/world-dots-light.svg')) ?>" alt="World map with pins on the United States, United Kingdom, Singapore and Australia, connected to Sri Lanka" width="1380" height="640" loading="lazy" decoding="async">
    </div>
  </div>
  <div class="container">
    <ul class="grid grid--4 region-tiles" role="list">
      <?php foreach ($regions as $code => $r): $h = $home['regions'][$code]; ?>
        <li data-reveal>
          <a class="card region-tile" href="/regions/<?= e($code) ?>" data-region="<?= e($code) ?>">
            <span class="region-tile__head"><?= partial('flag', ['code' => $r['flag']]) ?><strong><?= e($r['long']) ?></strong></span>
            <span class="region-tile__overlap"><?= e($h['overlap']) ?></span>
            <span class="region-tile__time" data-tz="<?= e($h['tz']) ?>" data-tz-label="<?= e($h['tz_label']) ?>"></span>
            <span class="card-link">Webulex in <?= e($r['name']) ?> <?= icon('arrow-right') ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- How we work -->
<section class="section section--tint" aria-labelledby="process-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'How we work', 'title' => 'A clear process, from first call to ongoing support', 'id' => 'process-title', 'align' => 'center']) ?>
    <ol class="steps" role="list">
      <?php foreach ($home['steps'] as $i => $st): ?>
        <li class="steps__item" data-reveal>
          <span class="steps__num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3><?= e($st['title']) ?></h3>
          <p><?= e($st['text']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
    <p class="center-note"><a href="/how-we-work">More about how we work</a></p>
  </div>
</section>

<!-- Why Webulex -->
<section class="section" aria-labelledby="why-title">
  <div class="container why">
    <div class="why__intro" data-reveal>
      <p class="kicker kicker--magenta">Why Webulex</p>
      <h2 id="why-title">Senior engineering and marketing, one accountable team</h2>
      <p class="lead">You get one team that understands both the technology and the growth side of your business.</p>
      <a class="btn btn--primary" href="/about">About Webulex <?= icon('arrow-right') ?></a>
    </div>
    <ul class="why__list" role="list">
      <?php foreach ($home['why'] as $w): ?>
        <li class="why__item" data-reveal>
          <span class="icon-tile"><?= icon($w['icon']) ?></span>
          <div><h3><?= e($w['title']) ?></h3><p><?= e($w['text']) ?></p></div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?= partial('testimonials') ?>

<!-- FAQ -->
<section class="section section--surface" aria-labelledby="faq-title">
  <div class="container faq-layout">
    <div data-reveal>
      <?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions we often hear', 'id' => 'faq-title', 'intro' => "Can't find your answer? Ask us on WhatsApp or email and we'll reply quickly."]) ?>
      <a class="btn btn--ghost" href="/contact">Ask a question</a>
    </div>
    <?= partial('faq', ['items' => content('faqs')['home'], 'id' => 'home-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => 'home']) ?>
