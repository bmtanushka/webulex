<?php
declare(strict_types=1);

// Local-only: concatenates and lightly minifies the four stylesheets into assets/css/site.css.
// Run before every deploy: php tools/build-css.php

$dir = __DIR__ . '/../public_html/assets/css/';
$css = '';
foreach (['base.css', 'layout.css', 'components.css', 'pages.css'] as $f) {
    $css .= file_get_contents($dir . $f) . "\n";
}
$css = preg_replace('#/\*.*?\*/#s', '', $css) ?? $css;        // comments
$css = preg_replace('/\s+/', ' ', $css) ?? $css;              // whitespace
$css = preg_replace('/\s*([{}:;,>])\s*/', '$1', $css) ?? $css;
$css = str_replace(';}', '}', $css);
// Restore spaces that matter inside selectors like ".a :focus" are rare; keep "and (" in media queries.
$css = str_replace(['and(', ')and'], ['and (', ') and'], $css);
file_put_contents($dir . 'site.css', trim($css) . "\n");
printf("site.css: %.1f KB\n", strlen($css) / 1024);
