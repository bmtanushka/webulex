<?php
declare(strict_types=1);

/**
 * Prints the head metadata for a page: title, description, canonical, Open Graph,
 * Twitter and JSON-LD. Expanded in Phase 7.
 *
 * @param array{title?:string,description?:string,path?:string,image?:string,noindex?:bool,schema?:array,type?:string} $meta
 */
function seo(array $meta): string
{
    $siteName = (string) site('trading_name');
    $title = (string) ($meta['title'] ?? $siteName);
    $description = (string) ($meta['description'] ?? site('default_description'));
    $path = (string) ($meta['path'] ?? current_path());
    $canonical = absolute_url($path);
    $imagePath = (string) ($meta['image'] ?? '/assets/img/og/default.png');
    if (!is_file(APP_ROOT . $imagePath)) {
        $imagePath = '/assets/img/og/default.png';
    }
    $image = absolute_url($imagePath);

    $out = [];
    $out[] = '<title>' . e($title) . '</title>';
    $out[] = '<meta name="description" content="' . e($description) . '">';
    if (!empty($meta['noindex'])) {
        $out[] = '<meta name="robots" content="noindex, follow">';
    } else {
        $out[] = '<link rel="canonical" href="' . e($canonical) . '">';
    }
    $out[] = '<meta property="og:site_name" content="' . e($siteName) . '">';
    $out[] = '<meta property="og:type" content="' . e((string) ($meta['type'] ?? 'website')) . '">';
    $out[] = '<meta property="og:title" content="' . e($title) . '">';
    $out[] = '<meta property="og:description" content="' . e($description) . '">';
    $out[] = '<meta property="og:url" content="' . e($canonical) . '">';
    $out[] = '<meta property="og:image" content="' . e($image) . '">';
    $out[] = '<meta property="og:image:width" content="1200">';
    $out[] = '<meta property="og:image:height" content="630">';
    $out[] = '<meta property="og:image:alt" content="' . e($title) . '">';
    $out[] = '<meta property="og:locale" content="' . e(str_replace('-', '_', (string) ($meta['lang'] ?? 'en-GB'))) . '">';
    foreach ((array) ($meta['alternates'] ?? []) as $hreflang => $altPath) {
        $out[] = '<link rel="alternate" hreflang="' . e((string) $hreflang) . '" href="' . e(absolute_url((string) $altPath)) . '">';
    }
    $out[] = '<meta name="twitter:card" content="summary_large_image">';

    foreach ((array) ($meta['schema'] ?? []) as $schema) {
        $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
        if ($json !== false) {
            $out[] = '<script type="application/ld+json">' . $json . '</script>';
        }
    }
    return implode("\n", $out) . "\n";
}

/** Organization + ProfessionalService schema, shared by every page. */
function schema_organization(): array
{
    $s = content('site');
    return [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'ProfessionalService'],
        '@id' => absolute_url('/') . '#organization',
        'name' => $s['trading_name'],
        'legalName' => $s['legal_name'],
        'url' => absolute_url('/'),
        'logo' => absolute_url('/assets/brand/icon-512.png'),
        'image' => absolute_url('/assets/img/og/default.png'),
        'email' => $s['email'],
        'telephone' => $s['phone_e164'],
        'slogan' => $s['tagline'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $s['address']['street'],
            'addressLocality' => $s['address']['locality'],
            'postalCode' => $s['address']['postcode'],
            'addressCountry' => 'LK',
        ],
        'areaServed' => ['US', 'GB', 'SG', 'AU', 'LK'],
    ];
}

/** hreflang alternates: only between the home page and the regional landing pages (BRIEF.md §7.9). */
function region_alternates(): array
{
    $alts = [];
    foreach (content('regions') as $code => $r) {
        $alts[$r['hreflang']] = '/regions/' . $code;
    }
    $alts['x-default'] = '/';
    return $alts;
}

/** Schema for a package or tier: a Service offered by Webulex, with an Offer that has no price until prices exist. */
function schema_package(string $name, string $description, string $path, ?array $prices = null): array
{
    $offer = ['@type' => 'Offer', 'url' => absolute_url($path), 'availability' => 'https://schema.org/InStock', 'seller' => ['@id' => absolute_url('/') . '#organization']];
    if (feature('SHOW_PRICES') && $prices) {
        $offer['priceCurrency'] = (string) array_key_first($prices);
        $offer['price'] = (string) reset($prices);
    }
    return [
        '@context' => 'https://schema.org', '@type' => 'Service', 'name' => $name, 'description' => $description,
        'url' => absolute_url($path), 'provider' => ['@id' => absolute_url('/') . '#organization'],
        'areaServed' => ['US', 'GB', 'SG', 'AU', 'LK'], 'offers' => $offer,
    ];
}
