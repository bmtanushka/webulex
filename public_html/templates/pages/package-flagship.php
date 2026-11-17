<?php
declare(strict_types=1);
/** @var string $slug @var array $package */
$p = $package;
$path = '/packages/' . $slug;
$GLOBALS['page_meta'] = [
    'title' => 'Complete Business Launch: 4-Month Package | Webulex',
    'description' => 'Website, booking, SEO, AIEO, Google and social ads, AI chatbot, call agent and CRM, delivered month by month in four months by one team.',
    'path' => $path,
    'image' => '/assets/img/og/' . $slug . '.png',
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'Product', 'name' => $p['title'], 'description' => $p['intro'],
        'brand' => ['@type' => 'Brand', 'name' => 'Webulex'], 'category' => 'Digital marketing and automation package', 'url' => absolute_url($path),
    ]],
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Packages', '/packages'], [$p['title'], $path]]]) ?>
    <p class="kicker kicker--cyan">Flagship package · <?= e($p['timeline']) ?></p>
    <h1><?= e($p['title']) ?></h1>
    <p class="page-hero__sub"><?= e($p['intro']) ?></p>
    <div class="hero__ctas">
      <a class="btn btn--accent btn--lg" href="/contact?package=<?= e($slug) ?>" data-event="package_quote_click" data-package="<?= e($p['title']) ?>">Get a quote <?= icon('arrow-right') ?></a>
      <a class="btn btn--ghost-light btn--lg" href="/free-consultation" data-event="book_consultation_click">Book a free consultation</a>
    </div>
    <p class="price price--light"><?= e(package_price($p)) ?></p>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container">
    <aside class="summary card" aria-labelledby="summary-title" data-reveal>
      <h2 id="summary-title" class="summary__title"><?= icon('file-text') ?> In summary</h2>
      <dl class="summary__list">
        <div><dt>What it is</dt><dd>A <?= e($p['timeline']) ?> package that builds your website, marketing and AI follow-up, delivered month by month by one team.</dd></div>
        <div><dt>Who it's for</dt><dd><?= e($p['ideal_for']) ?></dd></div>
        <div><dt>What's included</dt><dd>Website, landing and booking pages; SEO, AIEO and Local SEO; Google and social ads; AI chatbot, AI call agent, CRM and automated follow-ups.</dd></div>
      </dl>
    </aside>
  </div>
</section>

<section class="section section--flush-top" aria-labelledby="groups-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => "What's included", 'title' => 'Four parts, one team', 'id' => 'groups-title']) ?>
    <div class="grid grid--4 groups">
      <?php foreach ($p['groups'] as $i => $g): ?>
        <article class="card group-card<?= $i % 2 ? ' card--magenta' : '' ?>" data-reveal>
          <span class="icon-tile"><?= icon($g['icon']) ?></span>
          <h3><?= e($g['title']) ?></h3>
          <ul class="tick-list" role="list"><?php foreach ($g['items'] as $it): ?><li><?= icon('check') ?><?= e($it) ?></li><?php endforeach; ?></ul>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--tint" aria-labelledby="roadmap-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Roadmap', 'title' => 'Month by month', 'id' => 'roadmap-title', 'align' => 'center', 'intro' => 'You always know what is happening this month and what comes next.']) ?>
    <?= partial('roadmap', ['months' => $p['roadmap']]) ?>
  </div>
</section>

<section class="section" aria-labelledby="end-title">
  <div class="container included">
    <div class="outcomes" data-reveal>
      <h2 class="outcomes__title" id="end-title">By the end of month 4</h2>
      <ul role="list"><?php foreach ($p['outcomes'] as $o): ?><li><?= icon('circle-check') ?><span><?= e($o) ?>.</span></li><?php endforeach; ?></ul>
    </div>
    <div data-reveal>
      <h2 class="h3-like">Ideal for</h2>
      <p class="lead"><?= e($p['ideal_for']) ?></p>
      <?= partial('note-box') ?>
    </div>
  </div>
</section>

<section class="section section--surface" aria-labelledby="flag-svc-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Services in this package', 'title' => 'Learn more about each part', 'id' => 'flag-svc-title']) ?>
    <ul class="chip-links" role="list">
      <?php foreach ($p['services'] as $sSlug): $sv = service($sSlug); if (!$sv) { continue; } ?>
        <li><a href="/services/<?= e($sSlug) ?>"><?= icon($sv['icon']) ?><?= e($sv['title']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="section" aria-labelledby="flag-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions about this package', 'id' => 'flag-faq-title']) ?></div>
    <?= partial('faq', ['items' => content('package-extras')['faqs'], 'id' => 'flag-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => $p['title'], 'title' => 'Ready to launch your business properly?', 'text' => 'Book a free 30-minute consultation. We will map your four months and give you a fixed quote, with no obligation.']) ?>
