<?php
declare(strict_types=1);
/** @var string $slug @var array $s */
$accent = content('services')['areas'][$s['area']]['accent'] ?? 'cyan';
?>
<a class="card service-card card--<?= e($accent) ?>" href="/services/<?= e($slug) ?>" data-reveal>
  <span class="icon-tile"><?= icon($s['icon']) ?></span>
  <span class="service-card__title"><?= e($s['title']) ?></span>
  <span class="service-card__text"><?= e($s['description']) ?></span>
  <span class="card-link">Learn more <span class="sr-only">about <?= e($s['title']) ?></span><?= icon('arrow-right') ?></span>
</a>
