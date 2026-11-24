<?php
// remove_trailing_slashes.php

$files = array_merge(
    glob(__DIR__ . '/../*.html'),
    glob(__DIR__ . '/../*.php'),
    glob(__DIR__ . '/../*.js'),
    glob(__DIR__ . '/../*.xml'),
    glob(__DIR__ . '/../*.txt'),
    glob(__DIR__ . '/../*.md'),
    glob(__DIR__ . '/../admin/*.php'),
    glob(__DIR__ . '/../admin/includes/*.php'),
    glob(__DIR__ . '/../services/*.md'),
    glob(__DIR__ . '/../blog/*.md')
);

// Map of replacements for internal paths and full URLs
$slugs = [
    'ecommerce-management',
    'graphic-designer',
    'performance-marketing',
    'ppc-expert',
    'product-shoot',
    'seo-expert',
    'smo-services',
    'social-media-marketing',
    'video-editing',
    'website-designer',
    'marketing-consultant'
];

$blogSlugs = [
    'business-growth-strategy',
    'ai-in-business',
    'digital-transformation-strategies',
    'leadership-skills',
    'marketing-strategies'
];

$pages = [
    'about',
    'services',
    'contact',
    'blog',
    'privacy-policy',
    'terms',
    'admin'
];

foreach ($files as $file) {
    if (is_dir($file)) continue;
    $content = file_get_contents($file);
    $orig = $content;

    // Services
    foreach ($slugs as $slug) {
        $content = str_replace(
            ["href=\"/services/{$slug}/\"", "href='/services/{$slug}/'", "\"/services/{$slug}/\"", "'/services/{$slug}/'"],
            ["href=\"/services/{$slug}\"", "href='/services/{$slug}'", "\"/services/{$slug}\"", "'/services/{$slug}'"],
            $content
        );
        $content = str_replace(
            "https://www.ritwiksachdeva.in/services/{$slug}/",
            "https://www.ritwiksachdeva.in/services/{$slug}",
            $content
        );
    }

    // Blogs
    foreach ($blogSlugs as $slug) {
        $content = str_replace(
            ["href=\"/blog/{$slug}/\"", "href='/blog/{$slug}/'", "\"/blog/{$slug}/\"", "'/blog/{$slug}/'"],
            ["href=\"/blog/{$slug}\"", "href='/blog/{$slug}'", "\"/blog/{$slug}\"", "'/blog/{$slug}'"],
            $content
        );
        $content = str_replace(
            "https://www.ritwiksachdeva.in/blog/{$slug}/",
            "https://www.ritwiksachdeva.in/blog/{$slug}",
            $content
        );
    }

    // Core pages
    foreach ($pages as $page) {
        $content = str_replace(
            ["href=\"/{$page}/\"", "href='/{$page}/'", "\"/{$page}/\"", "'/{$page}/'"],
            ["href=\"/{$page}\"", "href='/{$page}'", "\"/{$page}\"", "'/{$page}'"],
            $content
        );
        $content = str_replace(
            "https://www.ritwiksachdeva.in/{$page}/",
            "https://www.ritwiksachdeva.in/{$page}",
            $content
        );
    }

    // Regex for any remaining canonical / og:url / loc in sitemap
    // Only if not root https://www.ritwiksachdeva.in/
    $content = preg_replace_callback(
        '#https://www\.ritwiksachdeva\.in/([a-zA-Z0-9_\-\/]+)/#',
        function ($m) {
            // Trim all trailing slashes from the path
            return 'https://www.ritwiksachdeva.in/' . trim($m[1], '/');
        },
        $content
    );

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Updated trailing slashes in: " . basename($file) . "\n";
    }
}

echo "Done removing trailing slashes.\n";
