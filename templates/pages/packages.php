<?php
declare(strict_types=1);
$packages = content('packages');
$industries = content('industries');
$extras = content('package-extras');
$flag = $packages['complete-business-launch'];
$GLOBALS['page_meta'] = [
    'title' => 'Packages for Websites, Marketing & AI | Webulex',
    'description' => 'Ready-made packages that combine websites, SEO, ads and AI automation into one clear timeline, including packages for cleaners, handymen and sole traders.',
    'path' => '/packages',
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Packages', '/packages']]]) ?>
    <p class="kicker kicker--cyan">Packages</p>
    <h1>Packages that grow with your business</h1>
    <p class="page-hero__sub">Ready-made plans that combine our services into one clear timeline and one team. Every package can be tailored.</p>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container">
    <article class="flagship-hero" data-reveal aria-labelledby="flagship-hero-title">
      <div>
        <span class="badge">Flagship · <?= e($flag['timeline']) ?></span>
        <h2 id="flagship-hero-title"><?= e($flag['title']) ?></h2>
        <p><?= e($flag['intro']) ?></p>
        <div class="hero__ctas">
          <a class="btn btn--accent" href="/packages/complete-business-launch">See the 4-month roadmap <?= icon('arrow-right') ?></a>
          <a class="btn btn--ghost-light" href="/contact?package=complete-business-launch" data-event="package_quote_click" data-package="<?= e($flag['title']) ?>">Get a quote</a>
        </div>
      </div>
      <ol class="flagship-hero__months" role="list">
        <?php foreach ($flag['roadmap'] as $i => $m): ?>
          <li><span><?= $i + 1 ?></span><div><small><?= e($m['month']) ?></small><strong><?= e($m['title']) ?></strong></div></li>
        <?php endforeach; ?>
      </ol>
    </article>
  </div>
</section>

<section class="section" aria-labelledby="general-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'General packages', 'title' => 'Pick a starting point', 'id' => 'general-title', 'intro' => 'Each package has a clear scope and timeline. We tailor it to your business after a free consultation.']) ?>
    <div class="grid grid--2 package-grid">
      <?php foreach ($packages as $slug => $p): if (!empty($p['flagship'])) { continue; } ?>
        <?= partial('package-card', ['slug' => $slug, 'p' => $p]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--surface" aria-labelledby="by-type-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'By business type', 'title' => 'Packages built around how you work', 'id' => 'by-type-title']) ?>
    <div class="grid grid--3">
      <?php foreach ($industries as $slug => $ind): ?>
        <a class="card industry-card" href="/industries/<?= e($slug) ?>" data-reveal>
          <span class="industry-card__art" aria-hidden="true"><span class="industry-card__icon"><?= icon($ind['icon']) ?></span></span>
          <span class="industry-card__title"><?= e($ind['title']) ?></span>
          <span class="industry-card__line"><?= e(implode(' ', $ind['headline'])) ?></span>
          <span class="industry-card__tiers"><?= e(implode(' · ', array_column($ind['tiers'], 'name'))) ?></span>
          <span class="card-link">See the packages <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="addons-title">
  <div class="container addons-layout">
    <div>
      <?= partial('section-heading', ['kicker' => 'Add-ons', 'title' => 'Popular add-ons', 'id' => 'addons-title', 'intro' => 'Add any of these to a package.']) ?>
    </div>
    <ul class="addons" role="list">
      <?php foreach ($extras['addons'] as $a): ?>
        <li data-reveal>
          <span class="icon-tile"><?= icon($a['icon']) ?></span>
          <?php if ($a['service']): ?><a href="/services/<?= e($a['service']) ?>"><?= e($a['title']) ?></a><?php else: ?><span><?= e($a['title']) ?></span><?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="container"><?= partial('note-box') ?></div>
</section>

<section class="section section--surface" aria-labelledby="pkg-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions about packages', 'id' => 'pkg-faq-title']) ?></div>
    <?= partial('faq', ['items' => $extras['faqs'], 'id' => 'pkg-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => 'packages', 'title' => 'Not sure which package fits?', 'text' => 'Book a free 30-minute consultation and we will recommend a package, or tailor one, with a fixed quote.']) ?>
