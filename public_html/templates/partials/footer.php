<?php
declare(strict_types=1);
$s = content('site');
$areas = content('services')['areas'];
$industries = content('industries');
?>
<footer class="site-footer">
  <div class="container site-footer__grid">
    <div class="site-footer__brand">
      <a class="logo" href="/" aria-label="Webulex home"><?= logo('light') ?></a>
      <p class="site-footer__tagline"><?= e($s['tagline']) ?></p>
      <p>Websites, marketing and AI-powered automation for small businesses in the US, UK, Singapore and Australia.</p>
      <ul role="list" class="site-footer__contact">
        <li><a href="tel:<?= e($s['phone_e164']) ?>"><?= icon('phone') ?> <?= e($s['phone_display']) ?></a></li>
        <li><a href="<?= e(whatsapp_url('footer')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp</a></li>
        <li><a href="mailto:<?= e($s['email']) ?>"><?= icon('mail') ?> <?= e($s['email']) ?></a></li>
      </ul>
    </div>

    <div>
      <h2 class="site-footer__heading">Services</h2>
      <ul role="list">
        <?php foreach ($areas as $slug => $a): ?>
          <li><a href="/services/<?= e($slug) ?>"><?= e($a['short']) ?>: <?= e($a['title']) ?></a></li>
        <?php endforeach; ?>
        <li><a href="/services">All services</a></li>
      </ul>
    </div>

    <div>
      <h2 class="site-footer__heading">Packages</h2>
      <ul role="list">
        <li><a href="/packages/complete-business-launch">Complete Business Launch</a></li>
        <?php foreach ($industries as $slug => $i): ?>
          <li><a href="/industries/<?= e($slug) ?>">For <?= e(lcfirst($i['title'])) ?></a></li>
        <?php endforeach; ?>
        <li><a href="/packages">All packages</a></li>
      </ul>
    </div>

    <div>
      <h2 class="site-footer__heading">Company</h2>
      <ul role="list">
        <li><a href="/how-we-work">How we work</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/blog">Blog</a></li>
        <li><a href="/contact">Contact</a></li>
        <li><a href="/free-consultation">Free consultation</a></li>
      </ul>
      <h2 class="site-footer__heading site-footer__heading--spaced">Where we work</h2>
      <ul role="list" class="site-footer__regions">
        <?php foreach ($s['regions'] as $code => $r): ?>
          <li><a href="/regions/<?= e($code) ?>"><?= partial('flag', ['code' => $r['flag']]) ?> <?= e($r['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="container site-footer__legal">
    <p>&copy; <?= e(date('Y')) ?> <?= e($s['legal_name']) ?>. <?= e($s['registration']) ?>. <?= e($s['address']['one_line']) ?>.</p>
    <ul role="list">
      <li><a href="/privacy">Privacy</a></li>
      <li><a href="/cookies">Cookies</a></li>
      <li><a href="/terms">Terms</a></li>
      <li><button type="button" class="link-btn" data-cookie-settings>Cookie settings</button></li>
    </ul>
  </div>
</footer>
