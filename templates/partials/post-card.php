<?php
declare(strict_types=1);
/** @var array $p */
?>
<article class="card post-card" data-reveal>
  <p class="post-card__meta">
    <span class="badge-light"><?= e(BLOG_CATEGORIES[$p['category']]) ?></span>
    <?php if ($p['draft']): ?><span class="badge-draft">Draft</span><?php endif; ?>
  </p>
  <h2 class="post-card__title"><a href="/blog/<?= e($p['slug']) ?>"><?= e($p['title']) ?></a></h2>
  <p class="post-card__text"><?= e($p['description']) ?></p>
  <p class="post-card__foot"><time datetime="<?= e($p['date']) ?>"><?= e(format_date($p['date'])) ?></time> · <?= (int) $p['minutes'] ?> min read</p>
</article>
