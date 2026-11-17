<?php
declare(strict_types=1);
/**
 * Tier comparison table. Desktop: full table with a sticky header.
 * Mobile with JS: tabs show one tier at a time. Without JS: the table scrolls sideways inside its box.
 * @var array $tiers @var string $id
 */
$rows = tier_rows($tiers);
?>
<div class="compare" data-compare>
  <div class="compare__tabs" role="tablist" aria-label="Choose a package to compare" hidden>
    <?php foreach ($tiers as $i => $t): ?>
      <button type="button" role="tab" class="compare__tab" aria-selected="<?= !empty($t['popular']) ? 'true' : 'false' ?>" data-col="<?= $i ?>"><?= e($t['name']) ?></button>
    <?php endforeach; ?>
  </div>
  <div class="compare__scroll" tabindex="0" role="region" aria-labelledby="<?= e($id) ?>-caption">
    <table class="compare__table">
      <caption id="<?= e($id) ?>-caption" class="sr-only">What each package includes</caption>
      <thead>
        <tr>
          <th scope="col">What's included</th>
          <?php foreach ($tiers as $i => $t): ?>
            <th scope="col" data-col="<?= $i ?>"<?= !empty($t['popular']) ? ' class="is-popular"' : '' ?>><?= e($t['name']) ?><span><?= e($t['timeline']) ?></span></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <th scope="row"><?= e($r['item']) ?></th>
            <?php foreach ($tiers as $i => $t): ?>
              <td data-col="<?= $i ?>"<?= !empty($t['popular']) ? ' class="is-popular"' : '' ?>>
                <?php if ($i >= $r['from']): ?><span class="compare__yes"><?= icon('check', '', 'Included') ?></span><?php else: ?><span class="compare__no" aria-hidden="true">–</span><span class="sr-only">Not included</span><?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
