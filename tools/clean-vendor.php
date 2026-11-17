<?php
declare(strict_types=1);

// Runs after `composer install` / `composer update` (see composer.json "scripts").
// Removes what the live site never needs from public_html/vendor: git checkouts,
// docs, examples, tests and helper scripts. Only src/ code, licences and autoload stay.

$vendor = __DIR__ . '/../public_html/vendor';
$remove = ['.git', '.github', '.gitignore', '.gitattributes', '.editorconfig', 'docs', 'examples', 'test', 'tests', 'get_oauth_token.php', 'phpunit.xml.dist', 'phpcs.xml.dist', 'phpdoc.dist.xml'];

function rrmdir(string $path): void
{
    if (is_link($path) || is_file($path)) {
        unlink($path);
        return;
    }
    if (!is_dir($path)) {
        return;
    }
    foreach (scandir($path) ?: [] as $item) {
        if ($item !== '.' && $item !== '..') {
            rrmdir($path . '/' . $item);
        }
    }
    rmdir($path);
}

$count = 0;
foreach (glob($vendor . '/*/*', GLOB_ONLYDIR) ?: [] as $pkg) {
    foreach ($remove as $name) {
        if (file_exists($pkg . '/' . $name)) {
            rrmdir($pkg . '/' . $name);
            $count++;
        }
    }
}
// Keep the folder blocked from the web even after Composer recreates it.
file_put_contents($vendor . '/.htaccess', "Require all denied\n");
echo "clean-vendor: removed $count item(s)\n";
