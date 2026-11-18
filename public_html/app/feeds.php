<?php
declare(strict_types=1);

/*
 * Machine-readable feeds generated from the content arrays, so they never drift from the pages:
 *   /sitemap.xml  every indexable page (draft blog posts and noindex pages are left out)
 *   /llms.txt     a plain Markdown summary of the company for AI crawlers
 */

/** @return array<int,array{path:string,lastmod:string,priority:string}> */
function sitemap_entries(): array
{
    require_once APP_ROOT . '/app/blog.php';
    $c = APP_ROOT . '/content/';
    $mod = static fn(string $file): string => date('Y-m-d', (int) (is_file($c . $file) ? filemtime($c . $file) : time()));

    $add = static function (string $path, string $lastmod, string $priority) use (&$entries): void {
        $entries[] = ['path' => $path, 'lastmod' => $lastmod, 'priority' => $priority];
    };
    $entries = [];
    $add('/', $mod('home.php'), '1.0');
    foreach (['/services' => 'services.php', '/packages' => 'packages.php', '/industries' => 'industries.php'] as $p => $f) {
        $add($p, $mod($f), '0.9');
    }
    foreach (array_keys(content('services')['areas']) as $slug) {
        $add('/services/' . $slug, $mod('service-details.php'), '0.8');
    }
    foreach (array_keys(content('services')['services']) as $slug) {
        $add('/services/' . $slug, $mod('service-details.php'), '0.7');
    }
    foreach (array_keys(content('packages')) as $slug) {
        $add('/packages/' . $slug, $mod('packages.php'), '0.8');
    }
    foreach (array_keys(content('industries')) as $slug) {
        $add('/industries/' . $slug, $mod('industries.php'), '0.8');
    }
    foreach (array_keys(content('regions')) as $code) {
        $add('/regions/' . $code, $mod('regions.php'), '0.7');
    }
    foreach (['/how-we-work', '/about', '/contact', '/free-consultation'] as $p) {
        $add($p, $mod('site.php'), '0.6');
    }
    $published = array_filter(blog_all(), static fn(array $p): bool => !$p['draft']);
    $add('/blog', $published ? max(array_column($published, 'date')) : $mod('site.php'), '0.6');
    foreach ($published as $post) {
        $add('/blog/' . $post['slug'], $post['date'], '0.6');
    }
    foreach (['privacy', 'cookies', 'terms'] as $doc) {
        $add('/' . $doc, $mod('legal/' . $doc . '.md'), '0.2');
    }
    return $entries;
}

function sitemap_xml(): string
{
    $out = ['<?xml version="1.0" encoding="UTF-8"?>', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'];
    $alts = region_alternates();
    $altPaths = array_flip($alts);
    foreach (sitemap_entries() as $e) {
        $out[] = '  <url>';
        $out[] = '    <loc>' . e(absolute_url($e['path'])) . '</loc>';
        $out[] = '    <lastmod>' . e($e['lastmod']) . '</lastmod>';
        $out[] = '    <priority>' . e($e['priority']) . '</priority>';
        if (isset($altPaths[$e['path']])) {
            foreach ($alts as $lang => $p) {
                $out[] = '    <xhtml:link rel="alternate" hreflang="' . e((string) $lang) . '" href="' . e(absolute_url($p)) . '"/>';
            }
        }
        $out[] = '  </url>';
    }
    $out[] = '</urlset>';
    return implode("\n", $out) . "\n";
}

function llms_txt(): string
{
    $s = content('site');
    $svc = content('services');
    $L = [];
    $L[] = '# ' . $s['trading_name'];
    $L[] = '';
    $L[] = '> ' . $s['trading_name'] . ' (' . $s['legal_name'] . ', ' . $s['registration'] . ') is a full-service digital agency based in Sri Lanka that builds, markets and automates small businesses in the United States, United Kingdom, Singapore and Australia. One accountable team handles websites, visibility on Google and AI search, advertising and AI-powered follow-up.';
    $L[] = '';
    $L[] = '- Tagline: ' . $s['tagline'];
    $L[] = '- Markets served: United States, United Kingdom, Singapore, Australia and Sri Lanka';
    $L[] = '- Home time zone: Sri Lanka (GMT+5:30); hours planned to overlap clients\' working days';
    $L[] = '- Pricing: fixed quotes after a free 30-minute consultation; advertising budgets and third-party costs are separate';
    $L[] = '- Clients own their domains, websites, ad accounts and data';
    $L[] = '';
    $L[] = '## Contact';
    $L[] = '';
    $L[] = '- Email: ' . $s['email'];
    $L[] = '- Phone / WhatsApp: ' . $s['phone_display'];
    $L[] = '- Address: ' . $s['address']['one_line'];
    $L[] = '- Website: ' . $s['base_url'];
    $L[] = '- [Book a free consultation](' . absolute_url('/free-consultation') . ')';
    $L[] = '- [Contact form](' . absolute_url('/contact') . ')';
    $L[] = '';
    $L[] = '## Services';
    foreach ($svc['areas'] as $areaSlug => $area) {
        $L[] = '';
        $L[] = '### [' . $area['short'] . ': ' . $area['title'] . '](' . absolute_url('/services/' . $areaSlug) . ')';
        $L[] = '';
        $L[] = $area['intro'];
        $L[] = '';
        foreach (services_in_area($areaSlug) as $slug => $sv) {
            $L[] = '- [' . $sv['title'] . '](' . absolute_url('/services/' . $slug) . '): ' . $sv['description'];
        }
    }
    $L[] = '';
    $L[] = '## Packages';
    $L[] = '';
    foreach (content('packages') as $slug => $p) {
        $L[] = '- [' . $p['title'] . '](' . absolute_url('/packages/' . $slug) . ') (' . $p['timeline'] . '): ' . $p['ideal_for'];
    }
    $L[] = '';
    $L[] = '### Packages by business type';
    $L[] = '';
    foreach (content('industries') as $slug => $i) {
        $L[] = '- [' . $i['title'] . '](' . absolute_url('/industries/' . $slug) . '): ' . implode(', ', array_map(static fn(array $t): string => $t['name'] . ' (' . $t['timeline'] . ')', $i['tiers'])) . '. ' . implode(' ', $i['headline']);
    }
    $L[] = '';
    $L[] = '## Regions';
    $L[] = '';
    foreach (content('regions') as $code => $r) {
        $L[] = '- [' . $r['name'] . '](' . absolute_url('/regions/' . $code) . '): quotes in ' . $r['currency'];
    }
    $L[] = '';
    $L[] = '## More';
    $L[] = '';
    $L[] = '- [How we work](' . absolute_url('/how-we-work') . ')';
    $L[] = '- [About](' . absolute_url('/about') . ')';
    $L[] = '- [Sitemap](' . absolute_url('/sitemap.xml') . ')';
    return implode("\n", $L) . "\n";
}
