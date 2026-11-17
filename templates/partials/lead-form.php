<?php
declare(strict_types=1);
/**
 * Lead form. Posts to /api/lead.php; works without JS (redirect back with errors) and with JS (fetch + JSON).
 * @var string $type 'contact' | 'consultation' @var string $return_to @var string $source_page
 */
$o = lead_options();
$errors = (array) flash_get('form_errors', []);
$old = (array) flash_get('form_old', []);
$full = $type === 'contact';

// Pre-fill from links such as /contact?service=seo or /contact?package=cleaning-companies:clean-growth
$qService = isset($_GET['service']) && is_string($_GET['service']) && service($_GET['service']) ? $_GET['service'] : '';
$qPackage = isset($_GET['package']) && is_string($_GET['package']) && preg_match('/^[a-z0-9-]+(:[a-z0-9-]+)?$/', $_GET['package']) ? $_GET['package'] : '';
$preInterests = [];
if ($qService) {
    $preInterests[] = 'area:' . service($qService)['area'];
}
if ($qPackage) {
    $base = explode(':', $qPackage)[0];
    if (isset(content('packages')[$base])) {
        $preInterests[] = 'package:' . $base;
    } elseif (isset(content('industries')[$base])) {
        $preInterests[] = 'industry:' . $base;
    }
}

$val = static fn(string $k, string $d = ''): string => is_string($old[$k] ?? null) ? $old[$k] : $d;
$interests = isset($old['interests']) ? (array) $old['interests'] : $preInterests;
$country = $val('country', visitor_country());
$err = static fn(string $k): string => isset($errors[$k]) ? '<p class="field__error" id="err-' . e($k) . '">' . icon('x') . e($errors[$k]) . '</p>' : '';
$aria = static fn(string $k, string $hint = ''): string => trim(($hint ? $hint . ' ' : '') . (isset($errors[$k]) ? 'err-' . $k : '')) !== ''
    ? ' aria-describedby="' . e(trim(($hint ? $hint . ' ' : '') . (isset($errors[$k]) ? 'err-' . $k : ''))) . '"' . (isset($errors[$k]) ? ' aria-invalid="true"' : '')
    : '';
$siteKey = (string) config('TURNSTILE_SITE_KEY', '');
$preLabel = '';
if ($qService) {
    $preLabel = service($qService)['title'];
} elseif ($qPackage) {
    [$b, $tier] = array_pad(explode(':', $qPackage), 2, '');
    $preLabel = content('packages')[$b]['title'] ?? (isset(content('industries')[$b]) ? ($tier ? ucwords(str_replace('-', ' ', $tier)) . ' (' . content('industries')[$b]['title'] . ')' : 'Packages for ' . lcfirst(content('industries')[$b]['title'])) : '');
}
?>
<form class="lead-form" id="form" action="/api/lead.php" method="post" novalidate data-lead-form>
  <?php if ($errors): ?>
    <div class="form-alert form-alert--error" role="alert" tabindex="-1" data-form-alert>
      <?= icon('x') ?>
      <div>
        <strong><?= e($errors['_form'] ?? 'Please check the highlighted fields.') ?></strong>
        <?php $fieldErrors = array_diff_key($errors, ['_form' => 1]); if ($fieldErrors): ?>
          <ul><?php foreach ($fieldErrors as $k => $msg): ?><li><a href="#f-<?= e($k) ?>"><?= e($msg) ?></a></li><?php endforeach; ?></ul>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="form-alert form-alert--error" role="alert" tabindex="-1" data-form-alert hidden></div>
  <?php endif; ?>

  <?php if ($preLabel !== ''): ?>
    <p class="form-context"><?= icon('circle-check') ?> You're asking about: <strong><?= e($preLabel) ?></strong></p>
  <?php endif; ?>

  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
  <input type="hidden" name="form_type" value="<?= e($type) ?>">
  <input type="hidden" name="return_to" value="<?= e($return_to) ?>">
  <input type="hidden" name="source_page" value="<?= e($source_page) ?>" data-source-page>
  <input type="hidden" name="service" value="<?= e($val('service', $qService)) ?>">
  <input type="hidden" name="package" value="<?= e($val('package', $qPackage)) ?>">
  <?php foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'] as $u): ?>
    <input type="hidden" name="<?= $u ?>" value="<?= e($val($u)) ?>" data-utm="<?= $u ?>">
  <?php endforeach; ?>

  <!-- Spam trap: hidden from people, left empty by them. -->
  <div class="hp" aria-hidden="true">
    <label for="f-website">Website</label>
    <input type="text" id="f-website" name="website" tabindex="-1" autocomplete="off">
  </div>

  <div class="form-grid">
    <div class="field">
      <label for="f-name">Name <span class="req" aria-hidden="true">*</span></label>
      <input id="f-name" name="name" type="text" autocomplete="name" required maxlength="100" value="<?= e($val('name')) ?>"<?= $aria('name') ?>>
      <?= $err('name') ?>
    </div>
    <div class="field">
      <label for="f-email">Email <span class="req" aria-hidden="true">*</span></label>
      <input id="f-email" name="email" type="email" autocomplete="email" required maxlength="160" value="<?= e($val('email')) ?>"<?= $aria('email') ?>>
      <?= $err('email') ?>
    </div>
    <div class="field">
      <label for="f-phone">Phone or WhatsApp <span class="opt">(optional)</span></label>
      <input id="f-phone" name="phone" type="tel" autocomplete="tel" maxlength="40" value="<?= e($val('phone')) ?>"<?= $aria('phone', 'hint-phone') ?>>
      <p class="field__hint" id="hint-phone">Include your country code, e.g. +44 20 7946 0000.</p>
      <?= $err('phone') ?>
    </div>
    <div class="field">
      <label for="f-country">Country <span class="req" aria-hidden="true">*</span></label>
      <select id="f-country" name="country" required autocomplete="country" data-country<?= $aria('country') ?>>
        <option value="">Choose your country</option>
        <?php foreach ($o['countries'] as $code => $label): ?>
          <option value="<?= e($code) ?>" data-currency="<?= e($o['currency'][$code]) ?>"<?= $country === $code ? ' selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
      <?= $err('country') ?>
    </div>

    <?php if ($full): ?>
      <div class="field">
        <label for="f-business">Business type <span class="opt">(optional)</span></label>
        <select id="f-business" name="business_type">
          <?php foreach ($o['business_types'] as $k => $label): ?>
            <option value="<?= e($k) ?>"<?= $val('business_type') === $k ? ' selected' : '' ?>><?= e($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label for="f-budget">Budget range <span class="opt">(optional)</span> <span class="currency" data-currency-label>USD</span></label>
        <select id="f-budget" name="budget"<?= $aria('budget', 'hint-budget') ?>>
          <?php foreach ($o['budgets'] as $k => $label): ?>
            <option value="<?= e($k) ?>"<?= $val('budget') === $k ? ' selected' : '' ?>><?= e($label) ?></option>
          <?php endforeach; ?>
        </select>
        <p class="field__hint" id="hint-budget">In your local currency, based on the country you choose.</p>
      </div>

      <fieldset class="field field--full interests">
        <legend>Interested in <span class="opt">(optional, choose any)</span></legend>
        <?php foreach ($o['interests'] as $group => $items): ?>
          <p class="interests__group"><?= e($group) ?></p>
          <div class="interests__grid">
            <?php foreach ($items as $k => $label): $id = 'f-int-' . preg_replace('/[^a-z0-9]/', '-', $k); ?>
              <label class="check" for="<?= e($id) ?>">
                <input type="checkbox" id="<?= e($id) ?>" name="interests[]" value="<?= e($k) ?>"<?= in_array($k, $interests, true) ? ' checked' : '' ?>>
                <span><?= e($label) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </fieldset>
    <?php endif; ?>

    <div class="field field--full">
      <label for="f-message"><?= $full ? 'Your project' : 'Anything we should know?' ?> <?= $full ? '<span class="req" aria-hidden="true">*</span>' : '<span class="opt">(optional)</span>' ?></label>
      <textarea id="f-message" name="message" rows="<?= $full ? 6 : 3 ?>" maxlength="3000"<?= $full ? ' required' : '' ?><?= $aria('message', 'hint-message') ?>><?= e($val('message')) ?></textarea>
      <p class="field__hint" id="hint-message"><?= $full ? 'What would you like to achieve? Any deadlines or current website we should look at?' : 'Your website address and what you would like help with.' ?></p>
      <?= $err('message') ?>
    </div>

    <div class="field field--full">
      <label class="check check--consent" for="f-consent">
        <input type="checkbox" id="f-consent" name="consent" value="1" required<?= !empty($old['consent']) ? ' checked' : '' ?><?= $aria('consent') ?>>
        <span>I agree to the <a href="/privacy">privacy policy</a>. <span class="req" aria-hidden="true">*</span></span>
      </label>
      <?= $err('consent') ?>
    </div>

    <?php if ($siteKey !== '' && !config('FORM_TEST_MODE')): ?>
      <div class="field field--full">
        <div class="cf-turnstile" data-sitekey="<?= e($siteKey) ?>" data-theme="light"></div>
        <?= $err('turnstile') ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn--primary btn--lg" data-submit>
      <span data-submit-label><?= $full ? 'Send message' : 'Request my consultation' ?></span> <?= icon('send') ?>
    </button>
    <p class="form-actions__note"><span class="req" aria-hidden="true">*</span> Required. We reply within one business day.</p>
  </div>
</form>
<template data-success-template><?= partial('form-success') ?></template>
<?php if ($siteKey !== '' && !config('FORM_TEST_MODE')): ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif; ?>
