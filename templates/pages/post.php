<?php
declare(strict_types=1);
/** @var array $post */
$p = $post;
['html' => $html, 'toc' => $toc] = blog_render($p);
$path = '/blog/' . $p['slug'];
$GLOBALS['page_meta'] = [
    'title' => ($p['seo_title'] ?: $p['title']) . (mb_strlen(($p['seo_title'] ?: $p['title']) . ' | Webulex') <= 60 ? ' | Webulex' : ''),
    'description' => $p['description'],
    'path' => $path,
    'type' => 'article',
    'noindex' => $p['draft'],
    'schema' => [[
        '@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $p['title'], 'description' => $p['description'],
        'datePublished' => $p['date'], 'dateModified' => $p['date'], 'author' => ['@type' => 'Organization', 'name' => $p['author']],
        'publisher' => ['@id' => absolute_url('/') . '#organization'], 'mainEntityOfPage' => absolute_url($path),
        'articleSection' => BLOG_CATEGORIES[$p['category']],
    ]],
];
$related = blog_related($p);
?>
<section class="page-hero page-hero--compact">
  <div class="container post-hero">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Blog', '/blog'], [$p['title'], $path]]]) ?>
    <?php if ($p['draft']): ?><p class="draft-banner"><?= icon('file-text') ?> Draft: not listed on the blog or in search results until it is published.</p><?php endif; ?>
    <p class="kicker kicker--cyan"><a href="/blog?category=<?= e($p['category']) ?>"><?= e(BLOG_CATEGORIES[$p['category']]) ?></a></p>
    <h1><?= e($p['title']) ?></h1>
    <p class="post-hero__meta">By <?= e($p['author']) ?> · <time datetime="<?= e($p['date']) ?>"><?= e(format_date($p['date'])) ?></time> · <?= (int) $p['minutes'] ?> min read</p>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container post-layout">
    <?php if (count($toc) > 1): ?>
      <nav class="toc card" aria-labelledby="toc-title">
        <h2 id="toc-title" class="toc__title">In this article</h2>
        <ol role="list">
          <?php foreach ($toc as $t): ?><li><a href="#<?= e($t['id']) ?>"><?= e($t['text']) ?></a></li><?php endforeach; ?>
        </ol>
      </nav>
    <?php endif; ?>
    <article class="prose">
      <?= $html /* Parsedown output in safe mode: raw HTML in the Markdown is escaped. */ ?>
      <aside class="post-cta" aria-labelledby="post-cta-title">
        <h2 id="post-cta-title">Want help with this?</h2>
        <p>Book a free 30-minute consultation. We'll look at your business and suggest a clear plan, with no obligation.</p>
        <a class="btn btn--accent" href="/free-consultation" data-event="book_consultation_click">Book a free consultation <?= icon('arrow-right') ?></a>
      </aside>
    </article>
  </div>
</section>

<?php if ($related): ?>
<section class="section section--surface" aria-labelledby="related-posts-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Keep reading', 'title' => 'Related articles', 'id' => 'related-posts-title']) ?>
    <div class="grid grid--3">
      <?php foreach ($related as $r): ?><?= partial('post-card', ['p' => $r]) ?><?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
