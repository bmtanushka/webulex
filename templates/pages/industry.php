<?php
declare(strict_types=1);
/** @var string $slug @var array $industry */
$ind = $industry;
$path = '/industries/' . $slug;
$GLOBALS['page_meta'] = [
    'title' => 'Digital Packages for ' . $ind['title'] . ' | Webulex',
    'description' => mb_strimwidth(implode(' ', $ind['headline']) . ' ' . $ind['intro'], 0, 155, '…'),
    'path' => $path,
    'image' => '/assets/img/og/' . $slug . '.png',
    'schema' => array_map(static fn(array $t): array => schema_package($t['name'] . ' (' . $ind['title'] . ')', $t['tagline'] . '. ' . $t['ideal'], $path, $t['prices'] ?? null), $ind['tiers']),
];
$hasArt = is_file(APP_ROOT . '/assets/illustrations/' . $ind['illustration'] . '.svg');
?>
<section class="page-hero page-hero--split">
  <div class="container page-hero__grid">
    <div>
      <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Industries', '/industries'], [$ind['title'], $path]]]) ?>
      <p class="kicker kicker--cyan"><?= e($ind['kicker']) ?></p>
      <h1><?= e($ind['headline'][0]) ?><br><span class="text-cyan"><?= e($ind['headline'][1]) ?></span></h1>
      <p class="page-hero__sub"><?= e($ind['intro']) ?></p>
      <div class="hero__ctas">
        <a class="btn btn--accent btn--lg" href="#tiers">Compare packages <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost-light btn--lg" href="/free-consultation" data-event="book_consultation_click">Book a free consultation</a>
      </div>
    </div>
    <div class="page-hero__art">
      <?php if ($hasArt): ?><?= illustration($ind['illustration'], '') ?><?php else: ?>
        <div class="industry-hero-art" aria-hidden="true">
          <span class="industry-hero-art__icon"><?= icon($ind['icon']) ?></span>
          <?php foreach ($ind['chips'] as $k => [$chipIcon, $chipText]): ?>
            <span class="industry-hero-art__chip industry-hero-art__chip--<?= $k ?>"><?= icon($chipIcon) ?><?= e($chipText) ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section section--tint" aria-labelledby="ind-problems-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Problems we solve', 'title' => 'Sound familiar?', 'id' => 'ind-problems-title', 'align' => 'center']) ?>
    <div class="grid grid--2">
      <?php foreach ($ind['problems'] as $pr): ?>
        <article class="card problem-card" data-reveal>
          <span class="icon-tile"><?= icon($pr['icon']) ?></span>
          <div>
            <h3 class="problem-card__problem">&ldquo;<?= e($pr['problem']) ?>&rdquo;</h3>
            <p class="problem-card__solution"><?= icon('arrow-right', 'problem-card__arrow') ?><span><?= e($pr['solution']) ?></span></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="tiers" aria-labelledby="tiers-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Packages', 'title' => 'Three ways to grow your ' . $ind['business_noun'] . ' business', 'id' => 'tiers-title', 'align' => 'center', 'intro' => 'Each package builds on the one before. Every package can be tailored.']) ?>
    <?= partial('tier-cards', ['tiers' => $ind['tiers'], 'slug' => $slug, 'industry' => $ind['title']]) ?>
  </div>
</section>

<section class="section section--surface" aria-labelledby="compare-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Compare', 'title' => 'Side by side', 'id' => 'compare-title']) ?>
    <?= partial('comparison', ['tiers' => $ind['tiers'], 'id' => 'compare-' . $slug]) ?>
  </div>
</section>

<section class="section" aria-labelledby="ind-addons-title">
  <div class="container addons-layout">
    <div><?= partial('section-heading', ['kicker' => 'Add-ons', 'title' => 'Useful extras', 'id' => 'ind-addons-title', 'intro' => 'Add any of these to your package.']) ?></div>
    <ul class="addons" role="list">
      <?php foreach ($ind['addons'] as $a): ?><li data-reveal><span class="icon-tile"><?= icon('sparkles') ?></span><span><?= e($a) ?></span></li><?php endforeach; ?>
    </ul>
  </div>
  <div class="container"><?= partial('note-box') ?></div>
</section>

<section class="section section--surface" aria-labelledby="ind-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions from ' . lcfirst($ind['title']), 'id' => 'ind-faq-title']) ?></div>
    <?= partial('faq', ['items' => $ind['faqs'], 'id' => 'ind-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => $ind['title'], 'title' => $ind['cta']]) ?>
