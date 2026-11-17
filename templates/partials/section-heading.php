<?php
declare(strict_types=1);
/** @var string $title @var string|null $kicker @var string|null $intro @var string|null $id @var string|null $align @var string|null $tone */
$align ??= 'left';
$tone ??= 'magenta';
?>
<header class="section-heading section-heading--<?= e($align) ?>">
  <?php if (!empty($kicker)): ?><p class="kicker kicker--<?= e($tone) ?>"><?= e($kicker) ?></p><?php endif; ?>
  <h2<?= !empty($id) ? ' id="' . e($id) . '"' : '' ?>><?= e($title) ?></h2>
  <?php if (!empty($intro)): ?><p class="section-heading__intro"><?= e($intro) ?></p><?php endif; ?>
</header>
