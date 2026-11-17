<?php
declare(strict_types=1);
/** @var string|null $title @var string|null $text @var string|null $page */
$title ??= "Let's grow your business";
$text ??= 'Book a free 30-minute consultation and get a clear plan, with no obligation.';
?>
<section class="cta-band" aria-labelledby="cta-band-title">
  <div class="container cta-band__inner" data-reveal>
    <div>
      <h2 id="cta-band-title"><?= e($title) ?></h2>
      <p><?= e($text) ?></p>
    </div>
    <div class="cta-band__actions">
      <a class="btn btn--accent btn--lg" href="/free-consultation" data-event="book_consultation_click">Book a free consultation <?= icon('arrow-right') ?></a>
      <a class="btn btn--ghost-light btn--lg" href="<?= e(whatsapp_url($page ?? '')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp us</a>
    </div>
  </div>
</section>
