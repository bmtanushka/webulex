<?php
declare(strict_types=1);
require_once APP_ROOT . '/app/forms.php';
$sent = isset($_GET['sent']);
// REVIEW(owner): drafted FAQs for the consultation page.
$faqs = [
    ['q' => 'Is the consultation really free?', 'a' => 'Yes. It is a free 30-minute video call with no obligation to buy anything.'],
    ['q' => 'What happens on the call?', 'a' => 'We look at your current website and online presence, talk about your goals and suggest a few quick wins. Afterwards we can send a clear plan and a fixed quote.'],
    ['q' => 'What times are available?', 'a' => 'We schedule calls at times that suit you in the US, UK, Singapore and Australia. Pick a slot in the calendar, or tell us a few times that work for you.'],
];
$GLOBALS['page_meta'] = [
    'title' => 'Book Your Free 30-Minute Consultation | Webulex',
    'description' => 'A free 30-minute call: a review of your online presence, a plan of quick wins and a fixed quote, with no obligation. For the US, UK, Singapore and Australia.',
    'path' => '/free-consultation',
    'minimal' => true,
    'noindex' => $sent,
    'forms' => true,
];
?>
<section class="page-hero page-hero--consult">
  <div class="container consult-hero">
    <div>
      <p class="kicker kicker--cyan">Free consultation</p>
      <h1>Book your free 30-minute consultation</h1>
      <ul class="consult-benefits" role="list">
        <li><?= icon('search') ?><span>A review of your current online presence</span></li>
        <li><?= icon('lightbulb') ?><span>A clear plan of quick wins</span></li>
        <li><?= icon('receipt') ?><span>A fixed quote, with no obligation</span></li>
      </ul>
    </div>
  </div>
</section>

<section class="section section--tight-top">
  <div class="container contact-layout contact-layout--consult">
    <div class="contact-main">
      <?= partial('booking', ['title' => 'Pick a time that suits you']) ?>
    </div>
    <aside class="contact-side">
      <?php if ($sent): ?>
        <?= partial('form-success') ?>
      <?php else: ?>
        <div class="card form-card">
          <h2 class="form-card__title">Prefer us to contact you?</h2>
          <p class="form-card__intro">Leave your details and we'll email you to arrange a time.</p>
          <?= partial('lead-form', ['type' => 'consultation', 'return_to' => '/free-consultation', 'source_page' => '/free-consultation']) ?>
        </div>
      <?php endif; ?>
    </aside>
  </div>
</section>

<section class="section section--surface" aria-labelledby="consult-faq-title">
  <div class="container faq-layout">
    <div><?= partial('section-heading', ['kicker' => 'FAQ', 'title' => 'About the consultation', 'id' => 'consult-faq-title']) ?></div>
    <?= partial('faq', ['items' => $faqs, 'id' => 'consult-faq']) ?>
  </div>
</section>
