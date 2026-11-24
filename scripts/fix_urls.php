<?php
// fix_urls.php

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

$services = [
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

$blogs = [
    'business-growth-strategy',
    'ai-in-business',
    'digital-transformation-strategies',
    'leadership-skills',
    'marketing-strategies'
];

foreach ($files as $file) {
    if (is_dir($file)) continue;
    $content = file_get_contents($file);
    $orig = $content;

    // Fix /services<slug> -> /services/<slug>
    foreach ($services as $s) {
        $content = str_replace("/services{$s}", "/services/{$s}", $content);
        $content = str_replace("services{$s}", "services/{$s}", $content);
        // Fix trailing slash if created
        $content = str_replace("/services/{$s}/", "/services/{$s}", $content);
        $content = str_replace("/services/{$s}\"", "/services/{$s}\"", $content);
    }

    // Fix /blog<slug> -> /blog/<slug>
    foreach ($blogs as $b) {
        $content = str_replace("/blog{$b}", "/blog/{$b}", $content);
        $content = str_replace("blog{$b}", "blog/{$b}", $content);
        $content = str_replace("/blog/{$b}/", "/blog/{$b}", $content);
    }

    // Remove double slashes like /services// or https://www.ritwiksachdeva.in//
    $content = preg_replace('#(?<!:)//+#', '/', $content);

    // Make sure canonical and links have no trailing slash except root
    $content = str_replace('https://www.ritwiksachdeva.in/about/', 'https://www.ritwiksachdeva.in/about', $content);
    $content = str_replace('https://www.ritwiksachdeva.in/services/', 'https://www.ritwiksachdeva.in/services', $content);
    $content = str_replace('https://www.ritwiksachdeva.in/contact/', 'https://www.ritwiksachdeva.in/contact', $content);
    $content = str_replace('https://www.ritwiksachdeva.in/blog/', 'https://www.ritwiksachdeva.in/blog', $content);
    $content = str_replace('https://www.ritwiksachdeva.in/privacy-policy/', 'https://www.ritwiksachdeva.in/privacy-policy', $content);
    $content = str_replace('https://www.ritwiksachdeva.in/terms/', 'https://www.ritwiksachdeva.in/terms', $content);

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Cleaned URLs in: " . basename($file) . "\n";
    }
}

// Generate canonical sitemap.xml
$urls = [
    ['loc' => 'https://www.ritwiksachdeva.in/', 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['loc' => 'https://www.ritwiksachdeva.in/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => 'https://www.ritwiksachdeva.in/services', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => 'https://www.ritwiksachdeva.in/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['loc' => 'https://www.ritwiksachdeva.in/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => 'https://www.ritwiksachdeva.in/privacy-policy', 'priority' => '0.5', 'changefreq' => 'yearly'],
    ['loc' => 'https://www.ritwiksachdeva.in/terms', 'priority' => '0.5', 'changefreq' => 'yearly'],
];

foreach ($services as $s) {
    if ($s === 'marketing-consultant') continue;
    $urls[] = [
        'loc' => "https://www.ritwiksachdeva.in/services/{$s}",
        'priority' => '0.85',
        'changefreq' => 'monthly'
    ];
}

foreach ($blogs as $b) {
    $urls[] = [
        'loc' => "https://www.ritwiksachdeva.in/blog/{$b}",
        'priority' => '0.8',
        'changefreq' => 'monthly'
    ];
}

$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
$today = date('Y-m-d');
foreach ($urls as $u) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$u['loc']}</loc>\n";
    $xml .= "    <lastmod>{$today}</lastmod>\n";
    $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
    $xml .= "    <priority>{$u['priority']}</priority>\n";
    $xml .= "  </url>\n";
}
$xml .= "</urlset>\n";

file_put_contents(__DIR__ . '/../sitemap.xml', $xml);
echo "Clean sitemap.xml generated with " . count($urls) . " URLs.\n";
