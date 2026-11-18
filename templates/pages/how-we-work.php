<?php
declare(strict_types=1);
$home = content('home');
// REVIEW(owner): expanded step descriptions are drafts.
$steps = [
    ['title' => 'Discover', 'text' => 'We learn about your business, customers and goals. In a free 30-minute call we look at your current website, listings and marketing and ask what success looks like for you. You leave with a few quick wins either way.'],
    ['title' => 'Plan', 'text' => 'A clear proposal with scope, timeline and fixed pricing. It lists exactly what we will deliver, when, and what third-party costs (such as ad budgets or software) you should expect, so there are no surprises.'],
    ['title' => 'Build & launch', 'text' => 'Design, development and testing, with your feedback at each stage. You see designs before anything is built, review a working version before launch, and we test speed, security and accessibility before going live.'],
    ['title' => 'Grow & report', 'text' => 'Marketing, SEO and automation, measured with regular reports. Each month you get a plain-English summary of rankings, traffic, leads and ad performance, with what we will do next.'],
    ['title' => 'Support', 'text' => 'Ongoing maintenance, updates and improvements. Your website stays secure and up to date, and you can reach the team directly by email, phone or WhatsApp when something needs to change.'],
];
$models = [
    ['icon' => 'briefcase', 'title' => 'One-off projects', 'text' => 'A website, web app or automation delivered to a fixed scope and quote.'],
    ['icon' => 'trending-up', 'title' => 'Monthly marketing plans', 'text' => 'SEO, AIEO, social media and ads, managed month by month.'],
    ['icon' => 'server', 'title' => 'Website care plans', 'text' => 'Hosting, updates, backups, monitoring and small changes.'],
    ['icon' => 'layers', 'title' => 'Ready-made packages', 'text' => 'Combined services on one timeline, tailored to your business.', 'href' => '/packages'],
    ['icon' => 'calendar-check', 'title' => 'Free consultation', 'text' => 'Not sure where to start? A 30-minute call to find your quick wins.', 'href' => '/free-consultation'],
];
$zones = [
    ['America/New_York', 'US East (New York)'], ['America/Los_Angeles', 'US West (Los Angeles)'], ['Europe/London', 'UK (London)'],
    ['Asia/Singapore', 'Singapore'], ['Australia/Sydney', 'Australia (Sydney)'], ['Australia/Perth', 'Australia (Perth)'],
];
$GLOBALS['page_meta'] = [
    'title' => 'How We Work: Process, Plans & Time Zones | Webulex',
    'description' => 'Our five-step process, the ways you can work with us, and how we cover US, UK, Singapore and Australian time zones from Sri Lanka.',
    'path' => '/how-we-work',
];
?>
<section class="page-hero">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['How we work', '/how-we-work']]]) ?>
    <p class="kicker kicker--cyan">How we work</p>
    <h1>A clear process, from first call to ongoing support</h1>
    <p class="page-hero__sub">Fixed quotes, regular updates and one accountable team, wherever you are in the world.</p>
  </div>
</section>

<section class="section" aria-labelledby="steps-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Our process', 'title' => 'Five steps', 'id' => 'steps-title']) ?>
    <ol class="process-long" role="list">
      <?php foreach ($steps as $i => $st): ?>
        <li class="process-long__item" data-reveal>
          <span class="process-long__num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div><h3><?= e($st['title']) ?></h3><p><?= e($st['text']) ?></p></div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section section--surface" aria-labelledby="models-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Engagement models', 'title' => 'Ways to work with us', 'id' => 'models-title']) ?>
    <div class="grid grid--3">
      <?php foreach ($models as $m): $tag = isset($m['href']) ? 'a' : 'div'; ?>
        <<?= $tag ?> class="card service-card"<?= isset($m['href']) ? ' href="' . e($m['href']) . '"' : '' ?> data-reveal>
          <span class="icon-tile"><?= icon($m['icon']) ?></span>
          <span class="service-card__title"><?= e($m['title']) ?></span>
          <span class="service-card__text"><?= e($m['text']) ?></span>
          <?php if (isset($m['href'])): ?><span class="card-link">Learn more <?= icon('arrow-right') ?></span><?php endif; ?>
        </<?= $tag ?>>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="tz-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Time zones', 'title' => 'Working across time zones', 'id' => 'tz-title', 'intro' => 'Our team is in Sri Lanka (GMT+5:30). This table shows a typical 9:00–17:00 working day in your city converted to Sri Lanka time, for today. It updates automatically when your clocks change.']) ?>
    <div class="compare__scroll" tabindex="0" role="region" aria-labelledby="tz-caption">
      <table class="compare__table tz-table" data-tz-table>
        <caption id="tz-caption" class="sr-only">Your working day in Sri Lanka time</caption>
        <thead><tr><th scope="col">Your location</th><th scope="col">Your time zone today</th><th scope="col">Your 09:00–17:00</th><th scope="col">In Sri Lanka time</th><th scope="col">Typical check-in window</th></tr></thead>
        <tbody>
          <?php foreach ($zones as [$tz, $label]): $r = zone_row($tz); $regionKey = str_starts_with($tz, 'America') ? 'us' : (str_starts_with($tz, 'Europe') ? 'uk' : (str_starts_with($tz, 'Asia') ? 'sg' : 'au')); ?>
            <tr data-tz-row="<?= e($tz) ?>">
              <th scope="row"><?= e($label) ?></th>
              <td data-tz-offset><?= e($r['offset']) ?></td>
              <td><?= e($r['local']) ?></td>
              <td data-tz-colombo><?= e($r['colombo']) ?></td>
              <td><?= e(preg_replace('/^[^:]+:\s*/', '', $home['regions'][$regionKey]['overlap'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="table-note">Check-in windows are typical and agreed with each client. <!-- TODO(owner): confirm working hours --></p>
  </div>
</section>

<section class="section section--tint" aria-labelledby="expect-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'What you can expect', 'title' => 'Our commitments to you', 'id' => 'expect-title', 'align' => 'center']) ?>
    <div class="grid grid--4">
      <?php foreach ([['message-circle', 'A reply within one business day', 'Email, phone or WhatsApp: we get back to you quickly.'], ['calendar-days', 'A weekly progress update', 'A short written note on what was done and what is next.'], ['layout-template', 'A shared project board', 'See tasks, files and feedback in one place.'], ['lock', 'You own everything', 'Domains, websites, ad accounts and data are set up in your name.']] as [$ic, $t, $tx]): ?>
        <article class="card expect-card" data-reveal>
          <span class="icon-tile"><?= icon($ic) ?></span>
          <h3><?= e($t) ?></h3>
          <p><?= e($tx) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?= partial('cta-band', ['page' => 'how we work']) ?>
