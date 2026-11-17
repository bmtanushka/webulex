<?php
declare(strict_types=1);
// Works without JS: the menu button links to #mobile-nav (CSS :target opens it) and the
// sub-menus are native <details> elements. JS upgrades it to a proper toggle with focus handling.
$services = content('services');
$packages = content('packages');
$industries = content('industries');
?>
<div class="mobile-nav" id="mobile-nav" data-mobile-nav>
  <nav class="mobile-nav__panel" aria-label="Mobile">
    <details class="mobile-nav__group">
      <summary>Services <?= icon('chevron-down') ?></summary>
      <ul role="list">
        <li><a href="/services">All services</a></li>
        <?php foreach ($services['areas'] as $slug => $area): ?>
          <li><a href="/services/<?= e($slug) ?>"><strong><?= e($area['short']) ?></strong> · <?= e($area['title']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </details>
    <details class="mobile-nav__group">
      <summary>Packages <?= icon('chevron-down') ?></summary>
      <ul role="list">
        <li><a href="/packages">All packages</a></li>
        <?php foreach ($packages as $slug => $p): ?>
          <li><a href="/packages/<?= e($slug) ?>"><?= e($p['title']) ?></a></li>
        <?php endforeach; ?>
        <?php foreach ($industries as $slug => $i): ?>
          <li><a href="/industries/<?= e($slug) ?>">For <?= e(lcfirst($i['title'])) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </details>
    <ul role="list" class="mobile-nav__links">
      <?php foreach ((array) site('nav') as $item): if (isset($item['mega'])) { continue; } ?>
        <li><a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a></li>
      <?php endforeach; ?>
      <li><a href="/contact">Contact</a></li>
    </ul>
    <div class="mobile-nav__cta">
      <a class="btn btn--accent" href="/free-consultation">Book a free consultation</a>
      <a class="btn btn--ghost-light" href="<?= e(whatsapp_url('menu')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp us</a>
    </div>
    <a class="mobile-nav__close" href="#top" data-menu-close><?= icon('x') ?> Close menu</a>
  </nav>
</div>
