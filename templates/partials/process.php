<?php
declare(strict_types=1);
/** @var array<int,array{title:string,text:string}> $steps */
?>
<ol class="steps steps--<?= count($steps) ?>" role="list">
  <?php foreach ($steps as $i => $st): ?>
    <li class="steps__item" data-reveal>
      <span class="steps__num" aria-hidden="true"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
      <h3><?= e($st['title']) ?></h3>
      <p><?= e($st['text']) ?></p>
    </li>
  <?php endforeach; ?>
</ol>
