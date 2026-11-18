<?php
declare(strict_types=1);
$s = content('site');
$GLOBALS['page_meta'] = [
    'title' => 'About Webulex: A Global Digital Partner from Sri Lanka',
    'description' => 'Webulex is a registered Sri Lankan company helping small businesses in the US, UK, Singapore and Australia build, grow, promote and automate online.',
    'path' => '/about',
];
$values = [
    ['icon' => 'message-circle', 'title' => 'Clear communication', 'text' => 'Plain English, regular updates and quick replies.'],
    ['icon' => 'receipt', 'title' => 'Honest pricing', 'text' => 'Fixed quotes, with third-party costs shown separately.'],
    ['icon' => 'shield-check', 'title' => 'Secure by design', 'text' => 'Security and privacy are built in from the start.'],
    ['icon' => 'chart-line', 'title' => 'Measurable results', 'text' => 'We track what matters and report it openly.'],
];
?>
<section class="page-hero page-hero--split">
  <div class="container page-hero__grid">
    <div>
      <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['About', '/about']]]) ?>
      <p class="kicker kicker--cyan">About us</p>
      <h1>A global digital partner, built in Sri Lanka</h1>
      <p class="page-hero__sub">One team for your website, your visibility on Google and AI search, your ads and your AI-powered follow-up.</p>
    </div>
    <div class="page-hero__art">
      <?php if (is_file(APP_ROOT . '/assets/illustrations/global.svg')): ?><?= illustration('global', '') ?><?php else: ?>
        <div class="about-map" aria-hidden="true">
          <div class="hero__dots" style="--map-mask: url('<?= e(asset('img/world-dots-mask.svg')) ?>')"></div>
          <?= partial('world-pins') ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="story-title">
  <div class="container about-story">
    <div data-reveal>
      <p class="kicker kicker--magenta">Our story</p>
      <h2 id="story-title">Technology and growth, under one roof</h2>
      <?php /* REVIEW(owner): draft story. */ ?>
      <p class="lead">Webulex is a registered Sri Lankan company that helps small and growing businesses abroad compete online.</p>
      <p>The company combines software engineering, information security and AI automation expertise with practical digital marketing, so clients get one team that understands both the technology and the growth side.</p>
      <p>Most of our clients are in the United States, the United Kingdom, Singapore and Australia. We work remotely, plan our hours to overlap with theirs and keep every project on a clear, fixed scope.</p>
    </div>
    <aside class="card company-card" aria-labelledby="company-title" data-reveal>
      <h2 id="company-title" class="company-card__title"><?= icon('building-2') ?> Company details</h2>
      <dl>
        <div><dt>Legal name</dt><dd><?= e($s['legal_name']) ?></dd></div>
        <div><dt>Trading name</dt><dd><?= e($s['trading_name']) ?></dd></div>
        <div><dt>Registration</dt><dd><?= e($s['registration']) ?></dd></div>
        <div><dt>Address</dt><dd><?= e($s['address']['one_line']) ?></dd></div>
        <div><dt>Phone / WhatsApp</dt><dd><a href="tel:<?= e($s['phone_e164']) ?>"><?= e($s['phone_display']) ?></a></dd></div>
        <div><dt>Email</dt><dd><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></dd></div>
      </dl>
    </aside>
  </div>
</section>

<section class="section section--surface" aria-labelledby="values-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Our values', 'title' => 'How we do business', 'id' => 'values-title', 'align' => 'center']) ?>
    <div class="grid grid--4">
      <?php foreach ($values as $v): ?>
        <article class="card expect-card" data-reveal><span class="icon-tile"><?= icon($v['icon']) ?></span><h3><?= e($v['title']) ?></h3><p><?= e($v['text']) ?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section global" aria-labelledby="where-title">
  <div class="container global__grid">
    <div data-reveal>
      <p class="kicker kicker--magenta">Where we work</p>
      <h2 id="where-title">Local team, global clients</h2>
      <p class="lead">From Malabe, near Colombo, we work with businesses across four markets and plan our hours around theirs.</p>
      <ul class="chip-links" role="list">
        <?php foreach ($s['regions'] as $code => $r): ?>
          <li><a href="/regions/<?= e($code) ?>"><?= partial('flag', ['code' => $r['flag']]) ?><?= e($r['long']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="global__map" data-reveal>
      <img src="<?= e(asset('img/world-dots-light.svg')) ?>" alt="World map with pins on the United States, United Kingdom, Singapore and Australia, connected to Sri Lanka" width="1380" height="640" loading="lazy" decoding="async">
    </div>
  </div>
</section>

<?php if (feature('SHOW_TEAM')): ?>
<section class="section" aria-labelledby="team-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Team', 'title' => 'The people behind Webulex', 'id' => 'team-title']) ?>
    <?php /* TODO(owner): founder and team details. Add to content/team.php and set SHOW_TEAM => true. */ ?>
    <div class="grid grid--3">
      <?php foreach ((array) (is_file(APP_ROOT . '/content/team.php') ? content('team') : []) as $m): ?>
        <article class="card team-card"><h3><?= e($m['name']) ?></h3><p class="team-card__role"><?= e($m['role']) ?></p><p><?= e($m['bio']) ?></p></article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?= partial('cta-band', ['page' => 'about']) ?>
