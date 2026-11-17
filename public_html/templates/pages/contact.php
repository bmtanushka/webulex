<?php
declare(strict_types=1);
require_once APP_ROOT . '/app/forms.php';
$s = content('site');
$sent = isset($_GET['sent']);
$GLOBALS['page_meta'] = [
    'title' => 'Contact Webulex | Get a Quote or Book a Call',
    'description' => 'Tell us about your project and get a reply within one business day. Phone, WhatsApp and email for clients in the US, UK, Singapore and Australia.',
    'path' => '/contact',
    'noindex' => $sent,
    'forms' => true,
];
?>
<section class="page-hero page-hero--compact">
  <div class="container">
    <?= partial('breadcrumbs', ['trail' => [['Home', '/'], ['Contact', '/contact']]]) ?>
    <p class="kicker kicker--cyan">Contact</p>
    <h1>Let's talk about your project</h1>
    <p class="page-hero__sub">Tell us what you need and we'll reply within one business day with next steps, or book a free 30-minute call.</p>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container contact-layout">
    <div class="contact-main">
      <?php if ($sent): ?>
        <?= partial('form-success') ?>
      <?php else: ?>
        <div class="card form-card">
          <h2 class="form-card__title">Send us a message</h2>
          <?= partial('lead-form', ['type' => 'contact', 'return_to' => '/contact', 'source_page' => '/contact']) ?>
        </div>
      <?php endif; ?>
    </div>

    <aside class="contact-side" aria-label="Other ways to reach us">
      <div class="card contact-methods">
        <h2 class="contact-methods__title">Other ways to reach us</h2>
        <ul role="list">
          <li><a href="<?= e(whatsapp_url('contact')) ?>" rel="noopener" data-event="whatsapp_click"><span class="icon-tile"><?= icon('message-circle') ?></span><span><strong>WhatsApp</strong><?= e($s['phone_display']) ?></span></a></li>
          <li><a href="tel:<?= e($s['phone_e164']) ?>"><span class="icon-tile"><?= icon('phone') ?></span><span><strong>Phone</strong><?= e($s['phone_display']) ?></span></a></li>
          <li><a href="mailto:<?= e($s['email']) ?>"><span class="icon-tile"><?= icon('mail') ?></span><span><strong>Email</strong><?= e($s['email']) ?></span></a></li>
          <li><span class="contact-methods__static"><span class="icon-tile"><?= icon('map-pin') ?></span><span><strong>Office</strong><?= e($s['address']['one_line']) ?></span></span></li>
        </ul>
        <p class="contact-methods__note" data-online-status="<?= e((string) json_encode($s['working_hours'])) ?>">We work across time zones: Sri Lanka (GMT+5:30) with hours that overlap the US, UK, Singapore and Australia.</p>
      </div>
      <?= partial('booking') ?>
    </aside>
  </div>
</section>
