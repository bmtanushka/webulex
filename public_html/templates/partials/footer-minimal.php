<?php
declare(strict_types=1);
$s = content('site');
?>
<footer class="site-footer site-footer--minimal">
  <div class="container site-footer__legal">
    <p>&copy; <?= e(date('Y')) ?> <?= e($s['legal_name']) ?>. <?= e($s['registration']) ?>.</p>
    <ul role="list">
      <li><a href="/">Home</a></li>
      <li><a href="/privacy">Privacy</a></li>
      <li><button type="button" class="link-btn" data-cookie-settings>Cookie settings</button></li>
    </ul>
  </div>
</footer>
