<?php
declare(strict_types=1);
/**
 * Booking embed (Cal.com or Calendly). The iframe only loads when it scrolls into view.
 * Without a BOOKING_URL in config, a simple fallback is shown. TODO(owner): booking link.
 * @var string|null $title
 */
$url = (string) config('BOOKING_URL', '');
$title ??= 'Book a free 30-minute call';
?>
<div class="booking card" id="book">
  <h2 class="booking__title"><?= icon('calendar-check') ?> <?= e($title) ?></h2>
  <?php if ($url !== ''): ?>
    <div class="booking__frame" data-booking data-src="<?= e($url) ?>">
      <p class="booking__loading">Loading the calendar…</p>
    </div>
    <p class="booking__alt"><a href="<?= e($url) ?>" target="_blank" rel="noopener" data-event="book_consultation_click">Open the booking calendar in a new tab</a></p>
  <?php else: ?>
    <p class="booking__fallback">Online booking will be available here soon. In the meantime, send us a message or WhatsApp us with a few times that suit you, and we'll confirm a slot.</p>
    <a class="btn btn--accent" href="<?= e(whatsapp_url('booking')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> Suggest a time on WhatsApp</a>
  <?php endif; ?>
</div>
