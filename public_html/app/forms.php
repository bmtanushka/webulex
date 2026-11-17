<?php
declare(strict_types=1);

/*
 * Lead form: options, CSRF, validation and delivery (BRIEF.md §8).
 * Delivery order: Turnstile check → n8n webhook → email to the team → confirmation email to the visitor.
 * If n8n fails, email still goes out. If everything fails, the lead is written to a private log so it is never lost.
 * FORM_TEST_MODE skips Turnstile, n8n and email and logs the lead instead (local testing).
 */

/** Start the session only on pages that need it (forms), so other pages stay cookie-free. */
function ensure_session(): void
{
    if (session_status() === PHP_SESSION_NONE && PHP_SAPI !== 'cli') {
        session_start();
    }
}

function csrf_token(): string
{
    ensure_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf'];
}

function csrf_valid(string $token): bool
{
    ensure_session();
    return !empty($_SESSION['csrf']) && hash_equals((string) $_SESSION['csrf'], $token);
}

/** Options shown in the form. Keys are what we store; labels are what people see. */
function lead_options(): array
{
    $interests = [];
    foreach (content('services')['areas'] as $slug => $a) {
        $interests['Services']['area:' . $slug] = $a['short'] . ': ' . $a['title'];
    }
    foreach (content('packages') as $slug => $p) {
        $interests['Packages']['package:' . $slug] = $p['title'];
    }
    foreach (content('industries') as $slug => $i) {
        $interests['Packages']['industry:' . $slug] = 'Packages for ' . lcfirst($i['title']);
    }

    return [
        'countries' => ['US' => 'United States', 'GB' => 'United Kingdom', 'SG' => 'Singapore', 'AU' => 'Australia', 'LK' => 'Sri Lanka', 'OTHER' => 'Other'],
        'currency' => ['US' => 'USD', 'GB' => 'GBP', 'SG' => 'SGD', 'AU' => 'AUD', 'LK' => 'USD', 'OTHER' => 'USD'],
        'business_types' => [
            '' => 'Choose one (optional)', 'cleaning' => 'Cleaning company', 'handyman' => 'Handyman / home repair', 'sole-trader' => 'Sole trader / freelancer',
            'clinic' => 'Clinic or healthcare', 'beauty' => 'Salon, beauty or wellness', 'consultant' => 'Consultant or coach', 'retail' => 'Retail or eCommerce',
            'hospitality' => 'Restaurant or hospitality', 'agency' => 'Agency or SaaS (white-label)', 'other' => 'Other',
        ],
        'interests' => $interests,
        // Budget ranges are stored as keys; the currency follows the country.
        'budgets' => ['' => 'Not sure yet', 'lt1k' => 'Under 1,000', '1k-3k' => '1,000 – 3,000', '3k-10k' => '3,000 – 10,000', '10k+' => '10,000 or more'],
    ];
}

/** Country guess from Cloudflare (only trusted when TRUST_CLOUDFLARE is on). */
function visitor_country(): string
{
    if (config('TRUST_CLOUDFLARE')) {
        $cf = strtoupper((string) ($_SERVER['HTTP_CF_IPCOUNTRY'] ?? ''));
        if ($cf === 'GB' || $cf === 'US' || $cf === 'SG' || $cf === 'AU' || $cf === 'LK') {
            return $cf;
        }
    }
    return '';
}

/** Flash data (errors and old input) carried across the no-JS redirect. */
function flash_set(string $key, mixed $value): void
{
    ensure_session();
    $_SESSION['flash'][$key] = $value;
}

function flash_get(string $key, mixed $default = null): mixed
{
    ensure_session();
    $v = $_SESSION['flash'][$key] ?? $default;
    unset($_SESSION['flash'][$key]);
    return $v;
}

function storage_path(string $file): string
{
    $dir = PROJECT_ROOT . '/storage/' . dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }
    return PROJECT_ROOT . '/storage/' . $file;
}

function log_line(string $file, array $data): void
{
    $data = ['time' => date('c')] + $data;
    @file_put_contents(storage_path('logs/' . $file), json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);
}

function client_ip(): string
{
    if (config('TRUST_CLOUDFLARE') && !empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return (string) $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

/** 5 submissions per hour per IP (IP is hashed before it is stored). */
function rate_limited(string $ip, int $max = 5, int $window = 3600): bool
{
    $file = storage_path('ratelimit.json');
    $fh = @fopen($file, 'c+');
    if ($fh === false) {
        // Storage not writable: fall back to the session.
        ensure_session();
        $_SESSION['rl'] = array_filter((array) ($_SESSION['rl'] ?? []), static fn($t) => $t > time() - $window);
        if (count($_SESSION['rl']) >= $max) {
            return true;
        }
        $_SESSION['rl'][] = time();
        return false;
    }
    flock($fh, LOCK_EX);
    $data = json_decode((string) stream_get_contents($fh), true) ?: [];
    $key = hash('sha256', $ip . '|' . (string) config('TURNSTILE_SECRET', 'wbx'));
    $now = time();
    foreach ($data as $k => $times) {
        $data[$k] = array_values(array_filter((array) $times, static fn($t) => $t > $now - $window));
        if (!$data[$k]) {
            unset($data[$k]);
        }
    }
    $limited = count($data[$key] ?? []) >= $max;
    if (!$limited) {
        $data[$key][] = $now;
    }
    ftruncate($fh, 0);
    rewind($fh);
    fwrite($fh, (string) json_encode($data));
    flock($fh, LOCK_UN);
    fclose($fh);
    return $limited;
}

/** Trim, strip control characters and cap length. */
function clean_text(mixed $v, int $max): string
{
    $v = is_string($v) ? $v : '';
    $v = preg_replace('/[^\P{C}\n\t]/u', '', $v) ?? '';
    $v = trim($v);
    return mb_substr($v, 0, $max);
}

/**
 * Validate a submitted lead.
 * @return array{data: array<string,mixed>, errors: array<string,string>}
 */
function validate_lead(array $in): array
{
    $o = lead_options();
    $type = ($in['form_type'] ?? '') === 'consultation' ? 'consultation' : 'contact';
    $d = [
        'form_type' => $type,
        'name' => clean_text($in['name'] ?? '', 100),
        'email' => clean_text($in['email'] ?? '', 160),
        'phone' => clean_text($in['phone'] ?? '', 40),
        'country' => clean_text($in['country'] ?? '', 8),
        'business_type' => clean_text($in['business_type'] ?? '', 40),
        'interests' => [],
        'budget' => clean_text($in['budget'] ?? '', 10),
        'message' => clean_text($in['message'] ?? '', 3000),
        'consent' => !empty($in['consent']),
        'service' => clean_text($in['service'] ?? '', 60),
        'package' => clean_text($in['package'] ?? '', 80),
        'source_page' => clean_text($in['source_page'] ?? '', 200),
    ];
    foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'] as $u) {
        $d[$u] = clean_text($in[$u] ?? '', 120);
    }
    $allInterests = array_merge(...array_values($o['interests']));
    foreach ((array) ($in['interests'] ?? []) as $i) {
        if (is_string($i) && isset($allInterests[$i])) {
            $d['interests'][] = $i;
        }
    }

    $e = [];
    if ($d['name'] === '') {
        $e['name'] = 'Please enter your name.';
    }
    if ($d['email'] === '' || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
        $e['email'] = 'Please enter a valid email address, like name@company.com.';
    }
    if ($d['phone'] !== '' && !preg_match('/^[+0-9 ()\-.]{6,40}$/', $d['phone'])) {
        $e['phone'] = 'Please use digits, spaces and an optional + only.';
    }
    if (!isset($o['countries'][$d['country']])) {
        $e['country'] = 'Please choose your country.';
    }
    if (!isset($o['business_types'][$d['business_type']])) {
        $d['business_type'] = '';
    }
    if (!isset($o['budgets'][$d['budget']])) {
        $d['budget'] = '';
    }
    if ($type === 'contact' && mb_strlen($d['message']) < 10) {
        $e['message'] = 'Please tell us a little about your project (at least 10 characters).';
    }
    if (!$d['consent']) {
        $e['consent'] = 'Please agree to the privacy policy so we can reply.';
    }
    if ($d['service'] !== '' && service($d['service']) === null) {
        $d['service'] = '';
    }
    if ($d['package'] !== '' && !preg_match('/^[a-z0-9-]+(:[a-z0-9-]+)?$/', $d['package'])) {
        $d['package'] = '';
    }
    $d['currency'] = $o['currency'][$d['country']] ?? 'USD';
    return ['data' => $d, 'errors' => $e];
}

function verify_turnstile(string $token, string $ip): bool
{
    $secret = (string) config('TURNSTILE_SECRET', '');
    if ($secret === '') {
        return true; // Not configured yet: honeypot, CSRF and rate limit still apply. TODO(owner): Turnstile keys.
    }
    if ($token === '') {
        return false;
    }
    $res = http_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', ['secret' => $secret, 'response' => $token, 'remoteip' => $ip], false, 8);
    $json = json_decode((string) ($res['body'] ?? ''), true);
    return ($res['ok'] ?? false) && !empty($json['success']);
}

/** Minimal cURL POST. @return array{ok:bool,status:int,body:string,error:string} */
function http_post(string $url, array $data, bool $asJson, int $timeout): array
{
    if (!function_exists('curl_init')) {
        return ['ok' => false, 'status' => 0, 'body' => '', 'error' => 'curl extension missing'];
    }
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_HTTPHEADER => $asJson ? ['Content-Type: application/json'] : [],
        CURLOPT_POSTFIELDS => $asJson ? (string) json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : http_build_query($data),
    ]);
    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    return ['ok' => $body !== false && $status >= 200 && $status < 300, 'status' => $status, 'body' => (string) $body, 'error' => $err];
}

/** Human-readable labels for a lead (used in emails). */
function lead_summary(array $d): array
{
    $o = lead_options();
    $allInterests = array_merge(...array_values($o['interests']));
    return [
        'Name' => $d['name'],
        'Email' => $d['email'],
        'Phone / WhatsApp' => $d['phone'] ?: '–',
        'Country' => $o['countries'][$d['country']] ?? $d['country'],
        'Business type' => $o['business_types'][$d['business_type']] ?: '–',
        'Interested in' => $d['interests'] ? implode(', ', array_map(static fn($k) => $allInterests[$k], $d['interests'])) : '–',
        'Service page' => $d['service'] ?: '–',
        'Package' => $d['package'] ?: '–',
        'Budget' => $d['budget'] !== '' ? $d['currency'] . ' ' . $o['budgets'][$d['budget']] : 'Not sure yet',
        'Message' => $d['message'] ?: '–',
        'Form' => $d['form_type'],
        'Source page' => $d['source_page'] ?: '–',
        'UTM' => trim(implode(' / ', array_filter([$d['utm_source'], $d['utm_medium'], $d['utm_campaign']]))) ?: '–',
    ];
}

/** Send an email through Hostinger SMTP with PHPMailer. */
function send_mail(string $to, string $subject, string $text, ?string $replyTo = null, ?string $replyName = null): bool
{
    if ((string) config('SMTP_PASS', '') === '') {
        return false;
    }
    $autoload = APP_ROOT . '/vendor/autoload.php';
    if (!is_file($autoload)) {
        return false;
    }
    require_once $autoload;
    $m = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $m->isSMTP();
        $m->Host = (string) config('SMTP_HOST', 'smtp.hostinger.com');
        $m->Port = (int) config('SMTP_PORT', 465);
        $m->SMTPAuth = true;
        $m->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $m->Username = (string) config('SMTP_USER');
        $m->Password = (string) config('SMTP_PASS');
        $m->Timeout = 10;
        $m->CharSet = 'UTF-8';
        $m->setFrom((string) config('SMTP_USER'), 'Webulex');
        $m->addAddress($to);
        if ($replyTo) {
            $m->addReplyTo($replyTo, (string) $replyName);
        }
        $m->Subject = $subject;
        $m->Body = $text;
        $m->isHTML(false);
        $m->send();
        return true;
    } catch (Throwable $ex) {
        log_line('lead-errors.log', ['stage' => 'email', 'to' => $to === $replyTo ? 'visitor' : 'team', 'error' => $m->ErrorInfo ?: $ex->getMessage()]);
        return false;
    }
}

/**
 * Deliver a validated lead. Returns true if at least one channel (n8n or email) received it.
 */
function deliver_lead(array $d): bool
{
    $payload = $d + ['timestamp' => date('c'), 'site' => site('base_url')];
    unset($payload['consent']);
    $payload['consent_given'] = true;

    if (config('FORM_TEST_MODE')) {
        log_line('test-leads.log', $payload);
        return true;
    }

    $n8nOk = false;
    $url = (string) config('N8N_LEAD_WEBHOOK_URL', '');
    if ($url !== '') {
        $res = http_post($url, $payload, true, 8);
        $n8nOk = $res['ok'];
        if (!$n8nOk) {
            log_line('lead-errors.log', ['stage' => 'n8n', 'status' => $res['status'], 'error' => $res['error']]);
        }
    }

    $lines = [];
    foreach (lead_summary($d) as $k => $v) {
        $lines[] = str_pad($k . ':', 18) . $v;
    }
    $mailOk = send_mail(
        (string) config('LEAD_NOTIFY_TO', site('email')),
        'New ' . ($d['form_type'] === 'consultation' ? 'consultation request' : 'enquiry') . ' from ' . $d['name'] . ' (' . (lead_options()['countries'][$d['country']] ?? '') . ')',
        "New lead from webulexpro.com\n\n" . implode("\n", $lines) . "\n",
        $d['email'],
        $d['name']
    );

    if ($n8nOk || $mailOk) {
        // Short confirmation to the visitor (best effort).
        send_mail(
            $d['email'],
            'Thanks for contacting Webulex',
            "Hi {$d['name']},\n\nThanks for getting in touch. We've got your message and will reply within one business day.\n\nIf it's urgent, you can reach us on WhatsApp: " . site('phone_display') . "\n\nThe Webulex team\n" . site('base_url') . "\n"
        );
        return true;
    }

    // Nothing reached us: keep the lead in a private log so it is not lost.
    log_line('failed-leads.log', $payload);
    return false;
}
