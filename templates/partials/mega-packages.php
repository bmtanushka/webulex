<?php
declare(strict_types=1);
$packages = content('packages');
$industries = content('industries');
$flagship = $packages['complete-business-launch'] ?? null;
?>
<div class="mega" id="mega-packages">
  <div class="mega__inner mega__inner--3">
    <?php if ($flagship): ?>
      <a class="mega__feature" href="/packages/complete-business-launch">
        <span class="mega__kicker">Flagship · <?= e($flagship['timeline']) ?></span>
        <strong><?= e($flagship['title']) ?></strong>
        <span><?= e($flagship['tagline']) ?></span>
        <span class="mega__feature-link">Explore the package <?= icon('arrow-right') ?></span>
      </a>
    <?php endif; ?>
    <div class="mega__col mega__col--cyan">
      <p class="mega__heading mega__heading--plain"><span class="mega__icon"><?= icon('layers') ?></span><span>General packages</span></p>
      <ul role="list" class="mega__links">
        <?php foreach ($packages as $slug => $p): if (!empty($p['flagship'])) { continue; } ?>
          <li><a href="/packages/<?= e($slug) ?>"><?= e($p['title']) ?> <span class="mega__meta"><?= e($p['timeline']) ?></span></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="mega__col mega__col--magenta">
      <p class="mega__heading mega__heading--plain"><span class="mega__icon"><?= icon('briefcase') ?></span><span>By business type</span></p>
      <ul role="list" class="mega__links">
        <?php foreach ($industries as $slug => $i): ?>
          <li><a href="/industries/<?= e($slug) ?>"><?= e($i['title']) ?> <span class="mega__meta"><?= e(implode(' ', $i['headline'])) ?></span></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <div class="mega__foot">
    <a href="/packages">All packages <?= icon('arrow-right') ?></a>
    <a href="/contact">Every package can be tailored. Talk to us <?= icon('arrow-right') ?></a>
  </div>
</div>
