<?php
declare(strict_types=1);
/** @var array<int,array{title:string,url:string,meta:string,type:string,text:string}> $packages @var string $title @var string|null $intro */
if (!$packages) {
    return;
}
?>
<section class="section section--surface" aria-labelledby="pkg-links-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Packages', 'title' => $title, 'id' => 'pkg-links-title', 'intro' => $intro ?? 'Get this as part of a ready-made package, with one timeline and one team. Every package can be tailored.']) ?>
    <div class="grid grid--3">
      <?php foreach ($packages as $p): ?>
        <a class="card package-link" href="<?= e($p['url']) ?>" data-reveal>
          <span class="package-link__type"><?= e($p['type']) ?> · <?= e($p['meta']) ?></span>
          <span class="package-link__title"><?= e($p['title']) ?></span>
          <span class="package-link__text"><?= e($p['text']) ?></span>
          <span class="card-link">View <?= icon('arrow-right') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
