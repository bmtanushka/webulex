<?php
declare(strict_types=1);
/** @var string $code @var array $region */
$r = $region;
$us = !empty($r['us_english']);
$industries = content('industries');
$GLOBALS['page_meta'] = [
    'title' => mb_strlen($r['title']) <= 60 ? $r['title'] : $r['h1'],
    'description' => $r['description'],
    'path' => '/regions/' . $code,
    'lang' => $r['hreflang'],
    'alternates' => region_alternates(),
];
$programs = $us ? 'programs' : 'programmes';
?>
<section class="page-hero page-hero--split">
  <div class="container page-hero__grid">
    <div>
      <?= partial('breadcrumbs', ['trail' => [['Home', '/'], [$r['name'], '/regions/' . $code]]]) ?>
      <p class="kicker kicker--cyan region-kicker"><?= partial('flag', ['code' => $r['flag']]) ?> Webulex in <?= e($r['name']) ?></p>
      <h1><?= e($r['h1']) ?></h1>
      <p class="page-hero__sub"><?= e($r['intro']) ?></p>
      <div class="hero__ctas">
        <a class="btn btn--accent btn--lg" href="/free-consultation" data-event="book_consultation_click">Book a free consultation <?= icon('arrow-right') ?></a>
        <a class="btn btn--ghost-light btn--lg" href="#region-packages">See packages</a>
      </div>
    </div>
    <div class="page-hero__art">
      <div class="tz-card" aria-labelledby="tz-card-title">
        <p class="tz-card__title" id="tz-card-title"><?= icon('clock') ?> Your working day, in our time</p>
        <ul role="list">
          <?php foreach ($r['zones'] as [$tz, $label]): $z = zone_row($tz); ?>
            <li data-tz-row="<?= e($tz) ?>"><strong><?= e($label) ?></strong><span>09:00–17:00 your time = <span data-tz-colombo><?= e($z['colombo']) ?></span> in Sri Lanka</span></li>
          <?php endforeach; ?>
        </ul>
        <p class="tz-card__note"><?= e($r['local']) ?></p>
      </div>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="region-points-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'For ' . $r['short'] . ' businesses', 'title' => 'What we focus on in ' . ($code === 'uk' || $code === 'us' ? 'the ' : '') . $r['name'], 'id' => 'region-points-title']) ?>
    <div class="grid grid--3">
      <?php foreach ($r['points'] as $pt): ?>
        <article class="card expect-card" data-reveal><span class="icon-tile"><?= icon($pt['icon']) ?></span><h3><?= e($pt['title']) ?></h3><p><?= e($pt['text']) ?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--surface" id="region-packages" aria-labelledby="region-pkg-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Packages', 'title' => 'Packages for ' . $r['short'] . ' businesses', 'id' => 'region-pkg-title', 'intro' => 'Every package is quoted in ' . $r['currency'] . ' and can be tailored to your business.']) ?>
    <div class="grid grid--3">
      <?php foreach ($industries as $slug => $ind): ?>
        <a class="card package-link" href="/industries/<?= e($slug) ?>" data-reveal>
          <span class="package-link__type">By business type</span>
          <span class="package-link__title"><?= e($ind['title']) ?></span>
          <span class="package-link__text"><?= e(implode(' ', $ind['headline'])) ?></span>
          <span class="card-link">See packages <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="center-note"><a href="/packages/complete-business-launch">The 4-month Complete Business Launch</a> · <a href="/packages">All packages and <?= e($programs) ?></a></p>
  </div>
</section>

<section class="section" aria-labelledby="region-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'Questions from ' . $r['short'] . ' clients', 'id' => 'region-faq-title']) ?></div>
    <?= partial('faq', ['items' => $r['faqs'], 'id' => 'region-faq']) ?>
  </div>
</section>

<?= partial('cta-band', ['page' => 'Webulex ' . $r['short'], 'title' => $us ? "Let's grow your business" : "Let's grow your business", 'text' => 'Book a free 30-minute consultation at a time that suits you in ' . $r['name'] . '. You get a clear plan and a fixed quote in ' . $r['currency'] . ', with no obligation.']) ?>
