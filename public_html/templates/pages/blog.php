<?php
declare(strict_types=1);
require_once APP_ROOT . '/app/blog.php';
$cat = isset($_GET['category']) && is_string($_GET['category']) && isset(BLOG_CATEGORIES[$_GET['category']]) ? $_GET['category'] : null;
$posts = blog_posts($cat);
$GLOBALS['page_meta'] = [
    'title' => ($cat ? BLOG_CATEGORIES[$cat] . ' Articles' : 'Blog: SEO, AIEO, Ads & Automation Tips') . ' | Webulex',
    'description' => 'Practical guides on SEO, AI search visibility, social media, automation and websites for small businesses in the US, UK, Singapore and Australia.',
    'path' => '/blog',
    'noindex' => $cat !== null,
];
?>
<section class="page-hero page-hero--compact">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Blog', '/blog']]]) ?>
    <p class="kicker kicker--cyan">Blog</p>
    <h1><?= $cat ? e(BLOG_CATEGORIES[$cat]) . ' articles' : 'Guides for growing your business online' ?></h1>
    <p class="page-hero__sub">Practical advice on getting found, winning customers and saving time with automation.</p>
    <nav class="area-jump" aria-label="Blog categories">
      <a href="/blog"<?= $cat === null ? ' aria-current="page"' : '' ?>>All</a>
      <?php foreach (BLOG_CATEGORIES as $k => $label): ?>
        <a href="/blog?category=<?= e($k) ?>"<?= $cat === $k ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (!$posts): ?>
      <div class="card empty-state">
        <span class="icon-tile"><?= icon('file-text') ?></span>
        <h2>New articles are on the way</h2>
        <p>We're preparing our first guides. In the meantime, book a free consultation and ask us anything.</p>
        <a class="btn btn--primary" href="/free-consultation">Book a free consultation</a>
      </div>
    <?php else: ?>
      <div class="grid grid--3">
        <?php foreach ($posts as $p): ?>
          <?= partial('post-card', ['p' => $p]) ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?= partial('cta-band', ['page' => 'blog']) ?>
