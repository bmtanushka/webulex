<?php
declare(strict_types=1);
$data = content('services');
$byArea = [];
foreach ($data['services'] as $slug => $s) {
    $byArea[$s['area']][$slug] = $s;
}
?>
<div class="mega" id="mega-services">
  <div class="mega__inner mega__inner--4">
    <?php foreach ($data['areas'] as $areaSlug => $area): ?>
      <div class="mega__col mega__col--<?= e($area['accent']) ?>">
        <a class="mega__heading" href="/services/<?= e($areaSlug) ?>">
          <span class="mega__icon"><?= icon($area['icon']) ?></span>
          <span><span class="mega__kicker"><?= e($area['short']) ?></span><?= e($area['title']) ?></span>
        </a>
        <ul role="list" class="mega__links">
          <?php foreach ($byArea[$areaSlug] ?? [] as $slug => $s): ?>
            <li><a href="/services/<?= e($slug) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="mega__foot">
    <a href="/services">All services <?= icon('arrow-right') ?></a>
    <a href="/free-consultation">Not sure what you need? Book a free consultation <?= icon('arrow-right') ?></a>
  </div>
</div>
