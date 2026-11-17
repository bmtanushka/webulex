<?php
declare(strict_types=1);
?>
<header class="site-header site-header--minimal">
  <div class="container site-header__inner">
    <a class="logo" href="/" aria-label="Webulex home"><?= logo('light') ?></a>
    <a class="btn btn--ghost-light btn--sm" href="<?= e(whatsapp_url('free consultation')) ?>" rel="noopener" data-event="whatsapp_click"><?= icon('message-circle') ?> WhatsApp</a>
  </div>
</header>
