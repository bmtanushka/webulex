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
        '/contact' => ['pages/contact', ['page_name' => 'Contact']],
        '/free-consultation' => ['pages/free-consultation', ['page_name' => 'Free consultation']],
        '/how-we-work' => ['pages/how-we-work', ['page_name' => 'How we work']],
        '/about' => ['pages/about', ['page_name' => 'About']],
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

    if (in_array($path, ['/privacy', '/terms', '/cookies'], true)) {
        return ['template' => 'pages/legal', 'vars' => ['doc' => ltrim($path, '/'), 'page_name' => ucfirst(ltrim($path, '/'))], 'status' => 200];
    }

    // /blog and /blog/{slug} (drafts are reachable by URL for review, marked noindex)
    if ($path === '/blog') {
        return ['template' => 'pages/blog', 'vars' => ['page_name' => 'Blog'], 'status' => 200];
    }
    if (preg_match('#^/blog/([a-z0-9-]+)$#', $path, $m)) {
        require_once APP_ROOT . '/app/blog.php';
        if (isset(blog_all()[$m[1]])) {
            return ['template' => 'pages/post', 'vars' => ['post' => blog_all()[$m[1]], 'page_name' => blog_all()[$m[1]]['title']], 'status' => 200];
        }
    }

    // /regions/{code}
    if (preg_match('#^/regions/([a-z]{2})$#', $path, $m) && isset(content('regions')[$m[1]])) {
        return ['template' => 'pages/region', 'vars' => ['code' => $m[1], 'region' => content('regions')[$m[1]], 'page_name' => content('regions')[$m[1]]['name']], 'status' => 200];
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

    return ['template' => 'pages/404', 'vars' => ['page_name' => 'Page not found'], 'status' => 404];
}
