<?php
declare(strict_types=1);
/** @var string $body @var array $meta */
$meta += ['schema' => []];
array_unshift($meta['schema'], schema_organization());
$minimal = !empty($meta['minimal']);
$cssFiles = is_file(APP_ROOT . '/assets/css/site.css') && !config('DEV')
    ? ['site.css']
    : ['base.css', 'layout.css', 'components.css', 'pages.css'];
?>
<!doctype html>
<html lang="en-GB" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.classList.replace('no-js','js')</script>
<?= seo($meta) ?>
<meta name="theme-color" content="#141A4A">
<link rel="icon" href="<?= e(asset('brand/favicon.svg')) ?>" type="image/svg+xml">
<link rel="manifest" href="/site.webmanifest">
<link rel="preload" href="/assets/fonts/outfit-latin-700-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/inter-latin-400-normal.woff2" as="font" type="font/woff2" crossorigin>
<?php foreach ($cssFiles as $css): ?>
<link rel="stylesheet" href="<?= e(asset('css/' . $css)) ?>">
<?php endforeach; ?>
<script type="module" src="<?= e(asset('js/main.js')) ?>"></script>
</head>
<body id="top">
<a class="skip-link" href="#main">Skip to content</a>
<?= partial($minimal ? 'header-minimal' : 'header') ?>
<?= $minimal ? '' : partial('mobile-nav') ?>
<main id="main" tabindex="-1">
<?= $body ?>
</main>
<?= partial($minimal ? 'footer-minimal' : 'footer') ?>
</body>
</html>
