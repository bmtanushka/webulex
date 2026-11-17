<?php
declare(strict_types=1);
$nav = (array) site('nav');
?>
<header class="site-header" data-header>
  <div class="container site-header__inner">
    <a class="logo" href="/" aria-label="Webulex home"><?= logo('light') ?></a>

    <nav class="primary-nav" aria-label="Main">
      <ul class="primary-nav__list" role="list">
        <?php foreach ($nav as $item): ?>
          <?php $active = is_current($item['href']); ?>
          <li class="primary-nav__item<?= isset($item['mega']) ? ' has-mega' : '' ?>" <?= isset($item['mega']) ? 'data-mega' : '' ?>>
            <a class="primary-nav__link" href="<?= e($item['href']) ?>"<?= $active ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
            <?php if (isset($item['mega'])): ?>
              <button class="primary-nav__toggle" type="button" aria-expanded="false" aria-controls="mega-<?= e($item['mega']) ?>">
                <span class="sr-only">Show <?= e($item['label']) ?> menu</span><?= icon('chevron-down') ?>
              </button>
              <?= partial('mega-' . $item['mega']) ?>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="site-header__actions">
      <a class="btn btn--accent btn--sm site-header__cta" href="/free-consultation">Book a free consultation</a>
      <a class="menu-btn" href="#mobile-nav" aria-controls="mobile-nav" data-menu-btn>
        <?= icon('menu', 'menu-btn__open') ?><?= icon('x', 'menu-btn__close') ?><span class="sr-only">Menu</span>
      </a>
    </div>
  </div>
</header>
