<?php
declare(strict_types=1);

/*
 * Loads config, sets error handling and starts the session.
 * config.php lives one level above public_html on the server and is never committed.
 */

define('APP_ROOT', dirname(__DIR__));          // public_html
define('PROJECT_ROOT', dirname(APP_ROOT));     // one level above public_html

$configFile = PROJECT_ROOT . '/config.php';
$GLOBALS['config'] = is_file($configFile) ? (array) require $configFile : [];

$isDev = (bool) ($GLOBALS['config']['DEV'] ?? false);

error_reporting(E_ALL);
ini_set('display_errors', $isDev ? '1' : '0');
ini_set('log_errors', '1');
$logDir = PROJECT_ROOT . '/storage/logs';
if (is_dir($logDir) && is_writable($logDir)) {
    ini_set('error_log', $logDir . '/php-error.log');
}

date_default_timezone_set('Asia/Colombo');
mb_internal_encoding('UTF-8');

if (session_status() === PHP_SESSION_NONE && PHP_SAPI !== 'cli') {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    session_name('wbx');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

require __DIR__ . '/helpers.php';
require __DIR__ . '/seo.php';
require __DIR__ . '/router.php';
