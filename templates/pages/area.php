<?php
declare(strict_types=1);
/** @var string $area_slug */
$area = content('services')['areas'][$area_slug];
$details = content('service-details')['areas'][$area_slug];
$services = services_in_area($area_slug);
$GLOBALS['page_meta'] = [
    'title' => $area['title'] . ' | Webulex',
    'description' => $area['intro'],
    'path' => '/services/' . $area_slug,
    'image' => '/assets/img/og/' . $area_slug . '.png',
];
?>
<section class="page-hero page-hero--split">
  <div class="container page-hero__grid">
    <div>
      <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Services', '/services'], [$area['short'], '/services/' . $area_slug]]]) ?>
      <p class="kicker kicker--cyan"><?= e($area['short']) ?></p>
      <h1><?= e($area['title']) ?></h1>
      <p class="page-hero__sub"><?= e($area['intro']) ?></p>
      <div class="hero__ctas">
        <a class="btn btn--accent" href="/free-consultation" data-event="book_consultation_click">Book a free consultation <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost-light" href="#area-services">See the services</a>
      </div>
    </div>
    <div class="page-hero__art"><?= illustration($area_slug, '') ?></div>
  </div>
</section>

<section class="section" id="area-services" aria-labelledby="area-services-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => count($services) . ' services', 'title' => 'What we can do for you', 'id' => 'area-services-title']) ?>
    <div class="grid grid--3 service-grid">
      <?php foreach ($services as $slug => $s): ?>
        <?= partial('service-card', ['slug' => $slug, 's' => $s]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--tint" aria-labelledby="area-process-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'How it works', 'title' => 'A simple, transparent process', 'id' => 'area-process-title', 'align' => 'center']) ?>
    <?= partial('process', ['steps' => $details['process']]) ?>
  </div>
</section>

<?= partial('package-links', ['packages' => packages_including(array_keys($services)), 'title' => 'Popular packages that include this']) ?>

<section class="section" aria-labelledby="area-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Common questions', 'id' => 'area-faq-title']) ?></div>
    <?= partial('faq', ['items' => $details['faqs'], 'id' => 'area-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => $area['title']]) ?>
