<?php
declare(strict_types=1);
/** @var string $page_title */
$GLOBALS['page_meta'] = [
    'title' => $page_title . ' | Webulex',
    'description' => 'This page is being built. Book a free consultation with Webulex in the meantime.',
    'noindex' => true,
];
?>
<section class="page-hero">
  <div class="container">
    <p class="kicker kicker--cyan">Coming soon</p>
    <h1><?= e($page_title) ?></h1>
    <p class="page-hero__sub">We're still building this page. In the meantime, we're happy to talk about your project.</p>
    <div class="hero__ctas">
      <a class="btn btn--accent" href="/free-consultation">Book a free consultation</a>
      <a class="btn btn--ghost-light" href="/">Back to the home page</a>
    </div>
  </div>
</section>
