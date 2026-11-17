<?php
declare(strict_types=1);
?>
<div class="form-success card" id="form" role="status" tabindex="-1" data-form-success>
  <span class="form-success__icon"><?= icon('circle-check') ?></span>
  <h2>Thanks, we've got your message.</h2>
  <p>We'll reply within one business day. Want to talk sooner? Book a free 30-minute call below, or message us on WhatsApp.</p>
  <div class="hero__ctas">
    <a class="btn btn--primary" href="#book" data-event="book_consultation_click">Book a call</a>
    <a class="btn btn--ghost" href="<?= e(whatsapp_url('thank you')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp us</a>
  </div>
</div>
