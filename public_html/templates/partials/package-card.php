<?php
declare(strict_types=1);
/** @var string $slug @var array $p */
?>
<article class="card package-card<?= !empty($p['popular']) ? ' package-card--popular' : '' ?>" data-reveal>
  <?php if (!empty($p['popular'])): ?><span class="ribbon">Most popular</span><?php endif; ?>
  <span class="icon-tile"><?= icon($p['icon'] ?? 'layers') ?></span>
  <h3 class="package-card__title"><a href="/packages/<?= e($slug) ?>"><?= e($p['title']) ?></a></h3>
  <p class="package-card__meta"><?= icon('clock') ?> <?= e($p['timeline']) ?></p>
  <p class="package-card__ideal"><?= e($p['ideal_for']) ?></p>
  <ul class="tick-list" role="list">
    <?php foreach ($p['includes'] as $inc): ?><li><?= icon('check') ?><?= e($inc) ?></li><?php endforeach; ?>
  </ul>
  <div class="package-card__foot">
    <p class="price"><?= e(package_price($p)) ?></p>
    <div class="package-card__actions">
      <a class="btn btn--primary btn--sm" href="/contact?package=<?= e($slug) ?>" data-event="package_quote_click" data-package="<?= e($p['title']) ?>">Get a quote</a>
      <a class="btn btn--ghost btn--sm" href="/packages/<?= e($slug) ?>">Details<span class="sr-only"> of <?= e($p['title']) ?></span></a>
    </div>
  </div>
</article>
