<?php
declare(strict_types=1);
/** 4-month timeline: horizontal on desktop, vertical on mobile. @var array $months */
?>
<ol class="roadmap" role="list">
  <?php foreach ($months as $i => $m): ?>
    <li class="roadmap__month" data-reveal>
      <div class="roadmap__head">
        <span class="roadmap__num" aria-hidden="true"><?= $i + 1 ?></span>
        <div><span class="roadmap__label"><?= e($m['month']) ?></span><h3><?= e($m['title']) ?></h3></div>
      </div>
      <ul role="list" class="roadmap__items">
        <?php foreach ($m['items'] as $it): ?><li><?= icon('check') ?><?= e($it) ?></li><?php endforeach; ?>
      </ul>
    </li>
  <?php endforeach; ?>
</ol>
