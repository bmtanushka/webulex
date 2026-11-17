<?php
declare(strict_types=1);
// Hidden until the owner supplies real testimonials and sets SHOW_TESTIMONIALS => true in config.php.
if (!feature('SHOW_TESTIMONIALS')) {
    return;
}
$t = content('testimonials');
?>
<section class="section section--surface" aria-labelledby="testimonials-title">
  <div class="container">
    <?= partial('section-heading', ['kicker' => 'Clients', 'title' => 'What our clients say', 'id' => 'testimonials-title', 'align' => 'center']) ?>
    <?php if (!empty($t['logos'])): ?>
      <ul class="trust-strip" role="list">
        <?php foreach ($t['logos'] as $logo): ?>
          <li><img src="<?= e(asset($logo['file'])) ?>" alt="<?= e($logo['name']) ?>" loading="lazy" height="40"></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <div class="grid grid--3">
      <?php foreach ($t['quotes'] as $q): ?>
        <figure class="card testimonial" data-reveal>
          <blockquote><p><?= e($q['quote']) ?></p></blockquote>
          <figcaption><strong><?= e($q['name']) ?></strong> <span><?= e($q['role']) ?></span></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
