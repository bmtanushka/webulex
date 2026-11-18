<?php
declare(strict_types=1);

/*
 * Security headers for HTML responses (BRIEF.md §7 Phase 7).
 * The Content-Security-Policy only allows the third parties that are configured in config.php:
 * GA4 (GA4_ID), Cloudflare Turnstile (TURNSTILE_SITE_KEY), the booking calendar (BOOKING_URL) and the chatbot
 * (CHATBOT_SCRIPT_URL). Inline scripts carry a per-request nonce. Extra hosts a chatbot needs can be added with
 * CSP_EXTRA => ['script-src' => [...], 'connect-src' => [...], 'frame-src' => [...], 'img-src' => [...]].
 */

function csp_nonce(): string
{
    static $nonce = null;
    $nonce ??= rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
    return $nonce;
}

function origin_of(string $url): ?string
{
    $p = parse_url($url);
    if (empty($p['scheme']) || empty($p['host']) || !in_array($p['scheme'], ['https', 'http'], true)) {
        return null;
    }
    return $p['scheme'] . '://' . $p['host'] . (isset($p['port']) ? ':' . $p['port'] : '');
}

function is_https(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
}

function content_security_policy(): string
{
    $d = [
        'default-src' => ["'self'"],
        'script-src' => ["'self'", "'nonce-" . csp_nonce() . "'"],
        'style-src' => ["'self'", "'unsafe-inline'"],
        'img-src' => ["'self'", 'data:'],
        'font-src' => ["'self'"],
        'connect-src' => ["'self'"],
        'frame-src' => ["'none'"],
        'form-action' => ["'self'"],
        'base-uri' => ["'self'"],
        'frame-ancestors' => ["'self'"],
        'object-src' => ["'none'"],
        'manifest-src' => ["'self'"],
    ];
    $frames = [];
    if (config('GA4_ID')) {
        $d['script-src'][] = 'https://www.googletagmanager.com';
        array_push($d['img-src'], 'https://www.googletagmanager.com', 'https://*.google-analytics.com');
        array_push($d['connect-src'], 'https://*.google-analytics.com', 'https://*.analytics.google.com', 'https://www.googletagmanager.com');
    }
    if (config('TURNSTILE_SITE_KEY') && !config('FORM_TEST_MODE')) {
        $d['script-src'][] = 'https://challenges.cloudflare.com';
        $frames[] = 'https://challenges.cloudflare.com';
    }
    if ($o = origin_of((string) config('BOOKING_URL', ''))) {
        $frames[] = $o;
    }
    if ($o = origin_of((string) config('CHATBOT_SCRIPT_URL', ''))) {
        $d['script-src'][] = $o;
        $d['connect-src'][] = $o;
        $frames[] = $o;
    }
    foreach ((array) config('CSP_EXTRA', []) as $dir => $hosts) {
        if (isset($d[$dir])) {
            $d[$dir] = array_merge($d[$dir], array_values(array_filter((array) $hosts, 'is_string')));
        }
    }
    if ($frames) {
        $d['frame-src'] = array_values(array_unique($frames));
    }
    $parts = [];
    foreach ($d as $k => $v) {
        $parts[] = $k . ' ' . implode(' ', array_unique($v));
    }
    if (is_https()) {
        $parts[] = 'upgrade-insecure-requests';
    }
    return implode('; ', $parts);
}

function send_security_headers(): void
{
    header('Content-Security-Policy: ' . content_security_policy());
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(self), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    if (is_https()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}
