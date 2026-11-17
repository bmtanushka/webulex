<?php
declare(strict_types=1);
$notes = content('package-extras')['note'];
?>
<aside class="note-box" aria-labelledby="note-title">
  <h2 id="note-title" class="note-box__title"><?= icon('lightbulb') ?> Please note</h2>
  <ul role="list">
    <?php foreach ($notes as $n): ?><li><?= e($n) ?></li><?php endforeach; ?>
  </ul>
</aside>
