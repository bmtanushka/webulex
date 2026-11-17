<?php
declare(strict_types=1);
/** @var array<int,array{0:string,1:string}> $trail [label, path]; the last item is the current page. */
$GLOBALS['page_meta']['schema'][] = breadcrumb_schema($trail);
$last = count($trail) - 1;
?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
  <ol role="list">
    <?php foreach ($trail as $i => [$label, $path]): ?>
      <li><?php if ($i === $last): ?><span aria-current="page"><?= e($label) ?></span><?php else: ?><a href="<?= e($path) ?>"><?= e($label) ?></a><?php endif; ?></li>
    <?php endforeach; ?>
  </ol>
</nav>
