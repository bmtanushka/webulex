<?php
declare(strict_types=1);
/**
 * Legal pages rendered from content/legal/{doc}.md.
 * TODO(owner): legal review before launch. Set LEGAL_REVIEWED => true in config.php to remove the draft notice.
 * @var string $doc
 */
require_once APP_ROOT . '/vendor/autoload.php';
$raw = (string) file_get_contents(APP_ROOT . '/content/legal/' . $doc . '.md');
preg_match('/^---\R(.*?)\R---\R(.*)$/s', $raw, $m);
$meta = [];
foreach (preg_split('/\R/', $m[1] ?? '') ?: [] as $line) {
    if (preg_match('/^([a-z_]+):\s*(.*)$/', trim($line), $kv)) {
        $meta[$kv[1]] = trim($kv[2], " \"'");
    }
}
$body = (string) preg_replace('/<!--.*?-->/s', '', $m[2] ?? '');
$pd = new Parsedown();
$pd->setSafeMode(true);
$GLOBALS['page_meta'] = [
    'title' => ($meta['title'] ?? ucfirst($doc)) . ' | Webulex',
    'description' => $meta['description'] ?? '',
    'path' => '/' . $doc,
];
?>
<section class="page-hero page-hero--compact">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], [$meta['title'] ?? ucfirst($doc), '/' . $doc]]]) ?>
    <p class="kicker kicker--cyan">Legal</p>
    <h1><?= e($meta['title'] ?? ucfirst($doc)) ?></h1>
    <p class="page-hero__sub">Last updated <time datetime="<?= e($meta['updated'] ?? '') ?>"><?= e(format_date($meta['updated'] ?? date('Y-m-d'))) ?></time></p>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container legal-layout">
    <?php if (!config('LEGAL_REVIEWED')): ?>
      <p class="draft-banner draft-banner--light" role="note"><?= icon('file-text') ?> <span><strong>Draft:</strong> this document is pending legal review and is provided for information only. It is not legal advice.</span></p>
    <?php endif; ?>
    <article class="prose"><?= $pd->text($body) ?></article>
  </div>
</section>
