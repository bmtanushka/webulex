<?php
declare(strict_types=1);

/**
 * Maps a request path to a page template and its data.
 * Returns ['template' => ..., 'vars' => [...], 'status' => int].
 */
function route(string $path): array
{
    $static = [
        '/' => ['pages/home', ['page_name' => 'Home']],
        '/services' => ['pages/services', ['page_name' => 'Services']],
        '/packages' => ['pages/packages', ['page_name' => 'Packages']],
        '/industries' => ['pages/industries', ['page_name' => 'Industries']],
    ];

    if (isset($static[$path])) {
        [$template, $vars] = $static[$path];
        return ['template' => $template, 'vars' => $vars, 'status' => 200];
    }

    // /services/{area} and /services/{service}
    if (preg_match('#^/services/([a-z0-9-]+)$#', $path, $m)) {
        $areas = content('services')['areas'];
        if (isset($areas[$m[1]])) {
            return ['template' => 'pages/area', 'vars' => ['area_slug' => $m[1], 'page_name' => $areas[$m[1]]['title']], 'status' => 200];
        }
        if (($service = service($m[1])) !== null) {
            return ['template' => 'pages/service', 'vars' => ['service' => $service, 'page_name' => $service['title']], 'status' => 200];
        }
    }

    // /packages/{slug}
    if (preg_match('#^/packages/([a-z0-9-]+)$#', $path, $m) && isset(content('packages')[$m[1]])) {
        $p = content('packages')[$m[1]];
        return ['template' => !empty($p['flagship']) ? 'pages/package-flagship' : 'pages/package', 'vars' => ['slug' => $m[1], 'package' => $p, 'page_name' => $p['title']], 'status' => 200];
    }

    // /industries/{slug}
    if (preg_match('#^/industries/([a-z0-9-]+)$#', $path, $m) && isset(content('industries')[$m[1]])) {
        $i = content('industries')[$m[1]];
        return ['template' => 'pages/industry', 'vars' => ['slug' => $m[1], 'industry' => $i, 'page_name' => $i['title']], 'status' => 200];
    }

    // Pages planned for later phases. Shown as a noindex "coming soon" page during the build
    // so the navigation can be reviewed. Each one is replaced by its real template in its phase.
    $planned = planned_pages();
    if (isset($planned[$path])) {
        return ['template' => 'pages/placeholder', 'vars' => ['page_title' => $planned[$path], 'page_name' => $planned[$path]], 'status' => 200];
    }

    return ['template' => 'pages/404', 'vars' => ['page_name' => 'Page not found'], 'status' => 404];
}

/** @return array<string,string> path => page title */
function planned_pages(): array
{
    $pages = [
        '/how-we-work' => 'How we work',
        '/about' => 'About Webulex',
        '/blog' => 'Blog',
        '/contact' => 'Contact',
        '/free-consultation' => 'Book a free consultation',
        '/privacy' => 'Privacy policy',
        '/terms' => 'Terms of use',
        '/cookies' => 'Cookie policy',
        '/regions/us' => 'United States',
        '/regions/uk' => 'United Kingdom',
        '/regions/sg' => 'Singapore',
        '/regions/au' => 'Australia',
    ];
    return $pages;
}
