<?php
declare(strict_types=1);
/** Small simplified SVG flags (decorative; the country name is always shown next to them). @var string $code */
$flags = [
    'us' => '<rect width="30" height="20" fill="#fff"/><g fill="#B22234"><rect y="0" width="30" height="1.54"/><rect y="3.08" width="30" height="1.54"/><rect y="6.16" width="30" height="1.54"/><rect y="9.24" width="30" height="1.54"/><rect y="12.32" width="30" height="1.54"/><rect y="15.4" width="30" height="1.54"/><rect y="18.46" width="30" height="1.54"/></g><rect width="12" height="10.78" fill="#3C3B6E"/><g fill="#fff"><circle cx="2" cy="2" r=".6"/><circle cx="5" cy="2" r=".6"/><circle cx="8" cy="2" r=".6"/><circle cx="10.5" cy="2" r=".6"/><circle cx="3.5" cy="4.5" r=".6"/><circle cx="6.5" cy="4.5" r=".6"/><circle cx="9.3" cy="4.5" r=".6"/><circle cx="2" cy="7" r=".6"/><circle cx="5" cy="7" r=".6"/><circle cx="8" cy="7" r=".6"/><circle cx="10.5" cy="7" r=".6"/><circle cx="3.5" cy="9.3" r=".6"/><circle cx="6.5" cy="9.3" r=".6"/><circle cx="9.3" cy="9.3" r=".6"/></g>',
    'gb' => '<rect width="30" height="20" fill="#012169"/><path d="M0 0l30 20M30 0L0 20" stroke="#fff" stroke-width="4"/><path d="M0 0l30 20M30 0L0 20" stroke="#C8102E" stroke-width="1.4"/><path d="M15 0v20M0 10h30" stroke="#fff" stroke-width="6"/><path d="M15 0v20M0 10h30" stroke="#C8102E" stroke-width="3.4"/>',
    'sg' => '<rect width="30" height="20" fill="#fff"/><rect width="30" height="10" fill="#EF3340"/><circle cx="7" cy="5" r="3.4" fill="#fff"/><circle cx="8.3" cy="5" r="3.1" fill="#EF3340"/><g fill="#fff"><circle cx="11" cy="2.9" r=".55"/><circle cx="12.6" cy="4.2" r=".55"/><circle cx="12" cy="6.2" r=".55"/><circle cx="10" cy="6.2" r=".55"/><circle cx="9.4" cy="4.2" r=".55"/></g>',
    'au' => '<rect width="30" height="20" fill="#012169"/><g><path d="M0 0l15 10M15 0L0 10" stroke="#fff" stroke-width="2"/><path d="M0 0l15 10M15 0L0 10" stroke="#C8102E" stroke-width=".8"/><path d="M7.5 0v10M0 5h15" stroke="#fff" stroke-width="3"/><path d="M7.5 0v10M0 5h15" stroke="#C8102E" stroke-width="1.6"/></g><g fill="#fff"><circle cx="7.5" cy="15" r="1.6"/><circle cx="22.5" cy="4" r=".9"/><circle cx="19" cy="9" r=".9"/><circle cx="26" cy="8" r=".9"/><circle cx="22.5" cy="16.5" r=".9"/><circle cx="24.3" cy="11.5" r=".5"/></g>',
];
$code = strtolower($code ?? '');
if (!isset($flags[$code])) {
    return;
}
?><svg class="flag" viewBox="0 0 30 20" width="21" height="14" aria-hidden="true" focusable="false"><?= $flags[$code] ?></svg>
