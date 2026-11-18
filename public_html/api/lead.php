<?php
declare(strict_types=1);

/*
 * Lead form endpoint (POST only). BRIEF.md §8.
 * - fetch() requests (Accept: application/json) get JSON back.
 * - Normal form posts redirect: success → /contact?sent=1 (or the page's own thank-you state),
 *   errors → back to the form with the messages and the visitor's input kept.
 */

require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/forms.php';

header('X-Robots-Tag: noindex');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'none'; frame-ancestors 'none'");
header('Cache-Control: no-store');

$wantsJson = str_contains((string) ($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json');

/** Send the response and stop. */
function respond(bool $ok, int $status, string $message, array $errors, array $old, string $back, bool $wantsJson): never
{
    if ($wantsJson) {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['ok' => $ok, 'message' => $message, 'errors' => (object) $errors], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($ok) {
        header('Location: ' . $back . (str_contains($back, '?') ? '&' : '?') . 'sent=1#form', true, 303);
        exit;
    }
    flash_set('form_errors', $errors ?: ['_form' => $message]);
    flash_set('form_old', $old);
    header('Location: ' . $back . '#form', true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

// Only send people back to our own form pages.
$back = (string) ($_POST['return_to'] ?? '/contact');
if (!in_array(parse_url($back, PHP_URL_PATH), ['/contact', '/free-consultation'], true)) {
    $back = '/contact';
}

$old = $_POST;
unset($old['csrf'], $old['cf-turnstile-response'], $old['website']);

// 1. Spam trap: real people never fill the hidden "website" field. Pretend success.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    log_line('spam.log', ['reason' => 'honeypot']);
    respond(true, 200, 'Thanks', [], [], $back, $wantsJson);
}

// 2. CSRF
if (!csrf_valid((string) ($_POST['csrf'] ?? ''))) {
    respond(false, 419, 'Your session expired. Please try sending the form again.', [], $old, $back, $wantsJson);
}

// 3. Rate limit
$ip = client_ip();
if (rate_limited($ip)) {
    respond(false, 429, "You've sent several messages in the last hour. Please email us at " . site('email') . ' or message us on WhatsApp instead.', [], $old, $back, $wantsJson);
}

// 4. Validation
['data' => $data, 'errors' => $errors] = validate_lead($_POST);
if ($errors) {
    respond(false, 422, 'Please check the highlighted fields.', $errors, $old, $back, $wantsJson);
}

// 5. Turnstile (skipped in test mode)
if (!config('FORM_TEST_MODE') && !verify_turnstile((string) ($_POST['cf-turnstile-response'] ?? ''), $ip)) {
    respond(false, 422, 'Please complete the security check and send the form again.', ['turnstile' => 'Please complete the security check.'], $old, $back, $wantsJson);
}

// 6. Deliver (n8n, email; private log as last resort)
if (!deliver_lead($data)) {
    respond(false, 502, "Sorry, we couldn't send your message just now. Please email " . site('email') . ' or message us on WhatsApp on ' . site('phone_display') . '.', [], $old, $back, $wantsJson);
}

respond(true, 200, "Thanks, we've got your message. We'll reply within one business day.", [], [], $back, $wantsJson);
