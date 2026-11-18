<?php
declare(strict_types=1);

/*
 * Blog: Markdown files in content/blog/ with a front-matter block, rendered with Parsedown (MIT).
 *
 *   ---
 *   title: Post title
 *   seo_title: Shorter title for search results (optional, ≤60 characters with " | Webulex")
 *   slug: post-slug
 *   date: 2026-11-17
 *   category: seo            (seo | aieo | social-media | automation | websites)
 *   description: One sentence for search results (≤155 characters).
 *   author: Webulex team
 *   draft: true              (drafts are hidden from the blog index and sitemap; set to false to publish)
 *   ---
 */

const BLOG_CATEGORIES = [
    'seo' => 'SEO',
    'aieo' => 'AIEO',
    'social-media' => 'Social media',
    'automation' => 'Automation',
    'websites' => 'Websites',
];

/** @return array<string,array> all posts keyed by slug, newest first */
function blog_all(): array
{
    static $posts = null;
    if ($posts !== null) {
        return $posts;
    }
    $posts = [];
    foreach (glob(APP_ROOT . '/content/blog/*.md') ?: [] as $file) {
        $raw = (string) file_get_contents($file);
        if (!preg_match('/^---\R(.*?)\R---\R(.*)$/s', $raw, $m)) {
            continue;
        }
        $meta = [];
        foreach (preg_split('/\R/', $m[1]) ?: [] as $line) {
            if (preg_match('/^([a-z_]+):\s*(.*)$/', trim($line), $kv)) {
                $meta[$kv[1]] = trim($kv[2], " \"'");
            }
        }
        $slug = $meta['slug'] ?? basename($file, '.md');
        $words = str_word_count(strip_tags($m[2]));
        $posts[$slug] = [
            'slug' => $slug,
            'title' => $meta['title'] ?? $slug,
            'seo_title' => $meta['seo_title'] ?? '',
            'date' => $meta['date'] ?? date('Y-m-d', (int) filemtime($file)),
            'category' => isset(BLOG_CATEGORIES[$meta['category'] ?? '']) ? $meta['category'] : 'websites',
            'description' => $meta['description'] ?? '',
            'author' => $meta['author'] ?? 'Webulex team',
            'draft' => in_array(strtolower($meta['draft'] ?? 'false'), ['true', 'yes', '1'], true),
            'minutes' => max(1, (int) round($words / 200)),
            'markdown' => $m[2],
        ];
    }
    uasort($posts, static fn(array $a, array $b): int => strcmp($b['date'], $a['date']));
    return $posts;
}

/** Published posts (plus drafts when SHOW_DRAFTS is on, for local review). */
function blog_posts(?string $category = null): array
{
    $show = (bool) config('SHOW_DRAFTS', false);
    return array_filter(blog_all(), static fn(array $p): bool => ($show || !$p['draft']) && ($category === null || $p['category'] === $category));
}

/** Render a post: HTML with ids on h2 headings, and a table of contents. @return array{html:string,toc:array} */
function blog_render(array $post): array
{
    require_once APP_ROOT . '/vendor/autoload.php';
    $pd = new Parsedown();
    $pd->setSafeMode(true);
    $html = $pd->text($post['markdown']);
    $toc = [];
    $used = [];
    $html = (string) preg_replace_callback('#<h2>(.*?)</h2>#s', static function (array $m) use (&$toc, &$used): string {
        $text = html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8');
        $id = trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($text)), '-') ?: 'section';
        $base = $id;
        $n = 2;
        while (isset($used[$id])) {
            $id = $base . '-' . $n++;
        }
        $used[$id] = true;
        $toc[] = ['id' => $id, 'text' => $text];
        return '<h2 id="' . e($id) . '">' . $m[1] . '</h2>';
    }, $html);
    return ['html' => $html, 'toc' => $toc];
}

/** Up to $n other posts, same category first. */
function blog_related(array $post, int $n = 3): array
{
    $others = array_filter(blog_posts(), static fn(array $p): bool => $p['slug'] !== $post['slug']);
    uasort($others, static fn(array $a, array $b): int => ($b['category'] === $post['category']) <=> ($a['category'] === $post['category']));
    return array_slice($others, 0, $n, true);
}
