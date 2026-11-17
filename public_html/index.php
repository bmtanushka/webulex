<?php
declare(strict_types=1);

/*
 * Front controller. Every page request is rewritten here by .htaccess.
 * With PHP's built-in server: php -S localhost:8000 -t public_html public_html/index.php
 */

// Built-in dev server: let real files (CSS, JS, fonts, images) be served directly,
// but never the private folders.
if (PHP_SAPI === 'cli-server') {
    $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    if (preg_match('#^/(app|content|templates|vendor)(/|$)#', $p)) {
        http_response_code(403);
        echo 'Forbidden';
        return true;
    }
    if ($p !== '/' && is_file(__DIR__ . $p) && !str_ends_with($p, '.php')) {
        return false;
    }
}

require __DIR__ . '/app/bootstrap.php';

$path = current_path();

// One canonical form: no trailing slash (except the home page).
$rawPath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if ($rawPath !== '/' && str_ends_with($rawPath, '/')) {
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: ' . rtrim($rawPath, '/') . ($qs !== '' ? '?' . $qs : ''), true, 301);
    exit;
}

$match = route($path);
http_response_code($match['status']);
header('Content-Type: text/html; charset=UTF-8');

$body = render($match['template'], $match['vars']);
echo render('layout', $match['vars'] + ['body' => $body, 'meta' => $GLOBALS['page_meta'] ?? []]);
