<?php
declare(strict_types=1);

// Copy to config.php ONE LEVEL ABOVE public_html on the server
// (e.g. /home/USER/domains/webulexpro.com/config.php). Never commit the real file.

return [
    'DEV' => false,                 // true locally: shows errors, loads the unbundled CSS

    // Feature flags (keep false until the owner supplies real content)
    'SHOW_TESTIMONIALS' => false,
    'SHOW_TEAM' => false,
    'SHOW_PRICES' => false,
    'SHOW_DRAFTS' => false,        // true locally: list draft blog posts on /blog
    'LEGAL_REVIEWED' => false,     // true once a lawyer has approved the legal pages (removes the draft notice)

    // Forms (Phase 5)
    'N8N_LEAD_WEBHOOK_URL' => '',
    'TURNSTILE_SITE_KEY' => '',
    'TURNSTILE_SECRET' => '',
    'SMTP_HOST' => 'smtp.hostinger.com',
    'SMTP_PORT' => 465,
    'SMTP_USER' => 'info@webulexpro.com',
    'SMTP_PASS' => '',
    'LEAD_NOTIFY_TO' => 'info@webulexpro.com',
    'FORM_TEST_MODE' => false,      // true: skips Turnstile, n8n and email (local tests)

    // Set to true only when the site is behind Cloudflare: then the visitor's country (CF-IPCountry)
    // pre-selects the form's country and CF-Connecting-IP is used for rate limiting.
    'TRUST_CLOUDFLARE' => false,

    // Integrations
    'BOOKING_URL' => '',            // Cal.com or Calendly link
    'CHATBOT_SCRIPT_URL' => '',
    'GA4_ID' => '',                 // G-XXXXXXX

    // Extra hosts for the Content-Security-Policy, if a chatbot or embed needs more than its own domain, e.g.
    // 'CSP_EXTRA' => ['connect-src' => ['wss://chat.example.com'], 'img-src' => ['https://cdn.example.com']],
    'CSP_EXTRA' => [],
];
