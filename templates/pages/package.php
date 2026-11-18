<?php
declare(strict_types=1);
/** @var string $slug @var array $package */
$p = $package;
$path = '/packages/' . $slug;
$others = array_filter(content('packages'), static fn(array $o, string $k): bool => $k !== $slug && empty($o['flagship']), ARRAY_FILTER_USE_BOTH);
$GLOBALS['page_meta'] = [
    'title' => $p['title'] . ' Package | Webulex',
    'description' => mb_strimwidth($p['title'] . ' (' . $p['timeline'] . '): ' . human_list(array_slice($p['includes'], 0, 4)) . '. ' . $p['ideal_for'], 0, 155, '…'),
    'path' => $path,
    'image' => '/assets/img/og/' . $slug . '.png',
    'schema' => [schema_package($p['title'], $p['ideal_for'] . ' Includes: ' . implode(', ', $p['includes']) . '.', $path, $p['prices'] ?? null)],
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Packages', '/packages'], [$p['title'], $path]]]) ?>
    <p class="kicker kicker--cyan">Package · <?= e($p['timeline']) ?></p>
    <h1><?= e($p['title']) ?></h1>
    <p class="page-hero__sub"><?= e($p['tagline']) ?> <?= e($p['ideal_for']) ?></p>
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
        <div><dt>What it is</dt><dd>A <?= e($p['timeline']) ?> package from Webulex. <?= e($p['tagline']) ?></dd></div>
        <div><dt>Who it's for</dt><dd><?= e($p['ideal_for']) ?></dd></div>
        <div><dt>What's included</dt><dd><?= e(implode('; ', $p['includes'])) ?>.</dd></div>
      </dl>
    </aside>
  </div>
</section>

<section class="section section--flush-top" aria-labelledby="included-title">
  <div class="container included">
    <div data-reveal>
      <?= partial('section-heading', ['kicker' => "What's included", 'title' => 'Everything in ' . $p['title'], 'id' => 'included-title']) ?>
      <ul class="check-grid" role="list">
        <?php foreach ($p['includes'] as $inc): ?><li><span class="check-grid__icon"><?= icon('check') ?></span><?= e($inc) ?></li><?php endforeach; ?>
      </ul>
    </div>
    <div data-reveal>
      <div class="timeline-box"><?= icon('calendar-days') ?><div><small>Timeline</small><strong><?= e($p['timeline']) ?></strong></div></div>
      <?= partial('note-box') ?>
    </div>
  </div>
</section>

<section class="section section--surface" aria-labelledby="pkg-svc-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Services in this package', 'title' => 'Learn more about each part', 'id' => 'pkg-svc-title']) ?>
    <ul class="chip-links" role="list">
      <?php foreach ($p['services'] as $sSlug): $sv = service($sSlug); if (!$sv) { continue; } ?>
        <li><a href="/services/<?= e($sSlug) ?>"><?= icon($sv['icon']) ?><?= e($sv['title']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="section" aria-labelledby="other-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Compare', 'title' => 'Other packages', 'id' => 'other-title']) ?>
    <div class="grid grid--3">
      <a class="card package-link" href="/packages/complete-business-launch" data-reveal>
        <span class="package-link__type">Flagship package · 4 months</span>
        <span class="package-link__title">Complete Business Launch</span>
        <span class="package-link__text">Website, marketing and AI follow-up, delivered month by month.</span>
        <span class="card-link">View <?= icon('arrow-right') ?></span>
      </a>
      <?php foreach (array_slice($others, 0, 2, true) as $oSlug => $o): ?>
        <a class="card package-link" href="/packages/<?= e($oSlug) ?>" data-reveal>
          <span class="package-link__type">Package · <?= e($o['timeline']) ?></span>
          <span class="package-link__title"><?= e($o['title']) ?></span>
          <span class="package-link__text"><?= e($o['tagline']) ?></span>
          <span class="card-link">View <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="center-note"><a href="/packages">All packages</a></p>
  </div>
</section>

<section class="section section--surface" aria-labelledby="p-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions about packages', 'id' => 'p-faq-title']) ?></div>
    <?= partial('faq', ['items' => content('package-extras')['faqs'], 'id' => 'p-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => $p['title'], 'title' => 'Get a quote for ' . $p['title'], 'text' => 'Book a free 30-minute consultation and get a fixed quote tailored to your business, with no obligation.']) ?>
