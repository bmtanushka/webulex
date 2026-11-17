<?php
declare(strict_types=1);
$industries = content('industries');
$GLOBALS['page_meta'] = [
    'title' => 'Industries: Packages by Business Type | Webulex',
    'description' => 'Digital packages built for cleaning companies, handyman services and sole traders, and tailored packages for any service business.',
    'path' => '/industries',
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Industries', '/industries']]]) ?>
    <p class="kicker kicker--cyan">Industries</p>
    <h1>Packages built around how you work</h1>
    <p class="page-hero__sub">Three-tier packages designed for specific types of business, each solving the problems that business faces every day.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid--2 industry-index">
      <?php foreach ($industries as $slug => $ind): ?>
        <a class="card industry-card industry-card--wide" href="/industries/<?= e($slug) ?>" data-reveal>
          <span class="industry-card__art" aria-hidden="true">
            <?php if (is_file(APP_ROOT . '/assets/illustrations/' . $ind['illustration'] . '.svg')): ?><?= illustration($ind['illustration']) ?><?php else: ?><span class="industry-card__icon"><?= icon($ind['icon']) ?></span><?php endif; ?>
          </span>
          <span class="kicker kicker--magenta"><?= e($ind['kicker']) ?></span>
          <span class="industry-card__title"><?= e(implode(' ', $ind['headline'])) ?></span>
          <span class="industry-card__line"><?= e($ind['intro']) ?></span>
          <span class="industry-card__tiers"><?= e(implode(' · ', array_column($ind['tiers'], 'name'))) ?></span>
          <span class="card-link">See <?= e(lcfirst($ind['title'])) ?> packages <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
      <a class="card industry-card industry-card--wide industry-card--yours" href="/contact" data-reveal>
        <span class="industry-card__art" aria-hidden="true"><span class="industry-card__icon"><?= icon('building-2') ?></span></span>
        <span class="kicker kicker--magenta">Your industry</span>
        <span class="industry-card__title">Don't see your business?</span>
        <span class="industry-card__line">Clinics, salons, restaurants, tutors, retailers… we tailor packages to any service business.</span>
        <span class="card-link">Talk to us <?= icon('arrow-right') ?></span>
      </a>
    </div>
  </div>
</section>

<?= partial('cta-band', ['page' => 'industries']) ?>
