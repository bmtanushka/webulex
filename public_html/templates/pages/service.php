<?php
declare(strict_types=1);
/** @var array $service */
$s = $service;
$area = content('services')['areas'][$s['area']];
$related = array_slice(array_filter(services_in_area($s['area']), static fn(string $k): bool => $k !== $s['slug'], ARRAY_FILTER_USE_KEY), 0, 3, true);
$path = '/services/' . $s['slug'];
$title = $s['title'] . ' | Webulex';
if (mb_strlen($title) > 60) {
    $title = $s['title'];
}
$GLOBALS['page_meta'] = [
    'title' => $title,
    'description' => mb_strimwidth($s['description'] . ' For businesses in the US, UK, Singapore and Australia.', 0, 155, '…'),
    'path' => $path,
    'image' => '/assets/img/og/' . $s['area'] . '.png',
    'schema' => [[
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $s['title'],
        'description' => $s['description'],
        'serviceType' => $s['title'],
        'url' => absolute_url($path),
        'provider' => ['@id' => absolute_url('/') . '#organization'],
        'areaServed' => ['US', 'GB', 'SG', 'AU', 'LK'],
        'category' => $area['title'],
    ]],
];
?>
<section class="page-hero page-hero--split">
  <div class="container page-hero__grid">
    <div>
      <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Services', '/services'], [$area['short'], '/services/' . $s['area']], [$s['title'], $path]]]) ?>
      <p class="kicker kicker--cyan"><?= e($area['short']) ?> · <?= e($area['title']) ?></p>
      <h1 class="page-hero__title--service"><?= e($s['title']) ?></h1>
      <p class="page-hero__sub"><?= e($s['description']) ?></p>
      <div class="hero__ctas">
        <a class="btn btn--accent" href="/contact?service=<?= e($s['slug']) ?>" data-event="generate_lead_click">Get a quote <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost-light" href="/free-consultation" data-event="book_consultation_click">Book a free consultation</a>
      </div>
    </div>
    <div class="page-hero__art"><?= illustration($s['area'], '') ?></div>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container">
    <aside class="summary card" aria-labelledby="summary-title" data-reveal>
      <h2 id="summary-title" class="summary__title"><?= icon('file-text') ?> In summary</h2>
      <dl class="summary__list">
        <div><dt>What it is</dt><dd><?= e($s['description']) ?></dd></div>
        <div><dt>Who it's for</dt><dd><?= e(ucfirst($s['for'] ?? 'small and growing businesses')) ?>.</dd></div>
        <div><dt>What's included</dt><dd><?= e(implode('; ', $s['includes'])) ?>.</dd></div>
      </dl>
    </aside>
  </div>
</section>

<section class="section section--flush-top" aria-labelledby="included-title">
  <div class="container included">
    <div data-reveal>
      <?= partial('section-heading', ['kicker' => "What's included", 'title' => 'Everything you need, handled for you', 'id' => 'included-title']) ?>
      <ul class="check-grid" role="list">
        <?php foreach ($s['includes'] as $inc): ?>
          <li><span class="check-grid__icon"><?= icon('check') ?></span><?= e($inc) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php if ($s['outcomes']): ?>
      <div class="outcomes" data-reveal>
        <h2 class="outcomes__title">What you get</h2>
        <ul role="list">
          <?php foreach ($s['outcomes'] as $o): ?>
            <li><?= icon('circle-check') ?><span><?= e($o) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--tint" aria-labelledby="process-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'How it works', 'title' => 'From first call to results', 'id' => 'process-title', 'align' => 'center']) ?>
    <?= partial('process', ['steps' => $s['process']]) ?>
  </div>
</section>

<?php if ($related): ?>
<section class="section" aria-labelledby="related-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Related services', 'title' => 'Often paired with ' . $s['title'], 'id' => 'related-title']) ?>
    <div class="grid grid--3 service-grid">
      <?php foreach ($related as $slug => $r): ?>
        <?= partial('service-card', ['slug' => $slug, 's' => $r]) ?>
      <?php endforeach; ?>
    </div>
    <p class="center-note"><a href="/services/<?= e($s['area']) ?>">All <?= e($area['title']) ?> services</a></p>
  </div>
</section>
<?php endif; ?>

<?= partial('package-links', ['packages' => packages_including([$s['slug']]), 'title' => 'Packages that include ' . $s['title']]) ?>

<?php if ($s['faqs']): ?>
<section class="section" aria-labelledby="service-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions about ' . $s['title'], 'id' => 'service-faq-title']) ?></div>
    <?= partial('faq', ['items' => $s['faqs'], 'id' => 'service-faq']) ?>
  </div>
</section>
<?php endif; ?>

<?= partial('cta-band', ['page' => $s['title'], 'title' => 'Talk to us about ' . $s['title'], 'text' => 'Book a free 30-minute consultation and get a clear plan and a fixed quote, with no obligation.']) ?>
