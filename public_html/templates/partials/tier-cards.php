<?php
declare(strict_types=1);
/** @var array $tiers @var string $slug @var string $industry */
?>
<div class="tiers">
  <?php foreach ($tiers as $i => $t): ?>
    <article class="card tier<?= !empty($t['popular']) ? ' tier--popular' : '' ?>" data-reveal>
      <?php if (!empty($t['popular'])): ?><span class="ribbon">Most popular</span><?php endif; ?>
      <p class="tier__meta"><?= icon('clock') ?> <?= e($t['timeline']) ?></p>
      <h3 class="tier__name"><?= e($t['name']) ?></h3>
      <p class="tier__tagline"><?= e($t['tagline']) ?></p>
      <?php if ($i > 0): ?><p class="tier__plus">Everything in <?= e($tiers[$i - 1]['name']) ?>, plus:</p><?php endif; ?>
      <ul class="tick-list" role="list">
        <?php foreach ($t['items'] as $it): ?><li><?= icon('check') ?><?= e($it) ?></li><?php endforeach; ?>
      </ul>
      <p class="tier__ideal"><?= e($t['ideal']) ?></p>
      <div class="tier__foot">
        <p class="price"><?= e(package_price($t)) ?></p>
        <a class="btn <?= !empty($t['popular']) ? 'btn--accent' : 'btn--primary' ?>" href="/contact?package=<?= e($slug . ':' . strtolower(str_replace(' ', '-', $t['name']))) ?>" data-event="package_quote_click" data-package="<?= e($t['name']) ?>">Get a quote<span class="sr-only"> for <?= e($t['name']) ?></span></a>
      </div>
    </article>
  <?php endforeach; ?>
</div>
