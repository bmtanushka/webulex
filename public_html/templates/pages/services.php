<?php
declare(strict_types=1);
$data = content('services');
$GLOBALS['page_meta'] = [
    'title' => 'Our Services: Web, SEO, Ads & AI Automation | Webulex',
    'description' => 'Websites, SEO and AIEO, social media and ads, and AI automation: 27 services in four areas, from one accountable team. See what fits your business.',
    'path' => '/services',
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Services', '/services']]]) ?>
    <p class="kicker kicker--cyan">Build · Grow · Promote · Automate</p>
    <h1>Our services</h1>
    <p class="page-hero__sub">Everything you need to build, grow, promote and automate your business online.</p>
    <ul class="area-jump" role="list">
      <?php foreach ($data['areas'] as $slug => $a): ?>
        <li><a href="#area-<?= e($slug) ?>"><?= icon($a['icon']) ?><?= e($a['short']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php $i = 0; foreach ($data['areas'] as $slug => $a): $i++; ?>
<section class="section<?= $i % 2 === 0 ? ' section--surface' : '' ?>" id="area-<?= e($slug) ?>" aria-labelledby="area-<?= e($slug) ?>-title">
  <div class="container">
    <div class="area-intro<?= $i % 2 === 0 ? ' area-intro--flip' : '' ?>">
      <div data-reveal>
        <p class="kicker kicker--<?= $a['accent'] === 'cyan' ? 'navy' : 'magenta' ?>"><?= e($a['short']) ?></p>
        <h2 id="area-<?= e($slug) ?>-title"><?= e($a['title']) ?></h2>
        <p class="lead"><?= e($a['intro']) ?></p>
        <a class="btn btn--primary" href="/services/<?= e($slug) ?>">Explore <?= e(strtolower($a['short'])) ?> services <?= icon('arrow-right') ?></a>
      </div>
      <div class="area-intro__art" data-reveal><?= illustration($slug, '') ?></div>
    </div>
    <div class="grid grid--3 service-grid">
      <?php foreach (services_in_area($slug) as $sSlug => $s): ?>
        <?= partial('service-card', ['slug' => $sSlug, 's' => $s]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?= partial('cta-band', ['page' => 'services', 'title' => 'Not sure which services you need?', 'text' => 'Book a free 30-minute consultation. We will look at your business and suggest a clear plan, with no obligation.']) ?>
