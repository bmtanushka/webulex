<?php
declare(strict_types=1);
/** Sticky mobile CTA, cookie banner and chatbot slot. Rendered once at the end of <body>. @var bool $minimal */
$ga = (string) config('GA4_ID', '');
$chat = (string) config('CHATBOT_SCRIPT_URL', '');
?>
<?php if (empty($minimal)): ?>
<div class="sticky-cta" data-sticky-cta>
  <a class="sticky-cta__btn sticky-cta__btn--wa" href="<?= e(whatsapp_url(current_path())) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp</a>
  <a class="sticky-cta__btn sticky-cta__btn--book" href="/free-consultation" data-event="book_consultation_click"><?= icon('calendar-check') ?> Book a call</a>
</div>
<?php endif; ?>

<?php if ($ga !== ''): ?>
<?php // Shown on first paint (via CSS, only when JS runs) if no choice has been saved yet. ?>
<div class="cookie-banner<?= empty($_COOKIE['wbx_consent']) ? ' cookie-banner--pending' : '' ?>" role="dialog" aria-modal="false" aria-labelledby="cookie-title" aria-describedby="cookie-text" data-cookie-banner>
  <div class="cookie-banner__inner">
    <div>
      <h2 id="cookie-title" class="cookie-banner__title">Cookies on this site</h2>
      <p id="cookie-text">We use essential cookies to make the site work. With your permission we'd also like to use analytics cookies (Google Analytics) to see how the site is used and improve it. <a href="/cookies">Cookie policy</a></p>
      <div class="cookie-banner__settings" data-cookie-panel hidden>
        <label class="check"><input type="checkbox" checked disabled> <span><strong>Essential</strong>: always on, needed for forms and security.</span></label>
        <label class="check"><input type="checkbox" data-consent="analytics"> <span><strong>Analytics</strong>: anonymous usage statistics (Google Analytics 4).</span></label>
        <label class="check"><input type="checkbox" data-consent="marketing"> <span><strong>Marketing</strong>: measuring ad campaigns (Google Ads, Meta).</span></label>
      </div>
    </div>
    <div class="cookie-banner__actions">
      <button type="button" class="btn btn--primary btn--sm" data-cookie="accept">Accept all</button>
      <button type="button" class="btn btn--ghost btn--sm" data-cookie="reject">Reject non-essential</button>
      <button type="button" class="btn btn--ghost btn--sm" data-cookie="settings" aria-expanded="false">Settings</button>
      <button type="button" class="btn btn--primary btn--sm" data-cookie="save" hidden>Save choices</button>
    </div>
  </div>
</div>
<?php endif; ?>

<div id="chatbot-slot" data-chatbot-src="<?= e($chat) ?>" hidden></div>
