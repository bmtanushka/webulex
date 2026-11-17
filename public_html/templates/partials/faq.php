<?php
declare(strict_types=1);
/**
 * FAQ accordion using native <details> (works without JS) plus FAQPage schema.
 * @var array<int,array{q:string,a:string}> $items @var string $id
 */
$GLOBALS['page_meta']['schema'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn(array $f): array => [
        '@type' => 'Question',
        'name' => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ], $items),
];
?>
<div class="faq" id="<?= e($id ?? 'faq-list') ?>">
  <?php foreach ($items as $i => $f): ?>
    <details class="faq__item"<?= $i === 0 ? ' open' : '' ?>>
      <summary class="faq__q"><span><?= e($f['q']) ?></span><span class="faq__icon" aria-hidden="true"></span></summary>
      <div class="faq__a"><p><?= e($f['a']) ?></p></div>
    </details>
  <?php endforeach; ?>
</div>
