<?php
/**
 * VERIFY ALL PAGES, HTTP STATUS, AND SERVICES INTEGRATION
 */

$baseUrl = 'http://localhost:8000';

$services = [
    'service-ecommerce-management.html',
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-seo-expert.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-best-marketing-consultant.html',
    'service-website-designer.html'
];

$mainPages = [
    'index.html',
    'about.html',
    'services.html',
    'blog.html',
    'contact.html',
    'sitemap.xml'
];

echo "=== 1. VERIFYING LOCAL FILES ===\n";
foreach (array_merge($mainPages, $services) as $file) {
    $path = __DIR__ . '/../' . $file;
    if (file_exists($path)) {
        $size = filesize($path);
        echo " [OK] $file exists (" . round($size / 1024, 1) . " KB)\n";
    } else {
        echo " [FAIL] $file DOES NOT EXIST!\n";
    }
}

echo "\n=== 2. VERIFYING HTTP 200 ON LOCAL WEB SERVER ===\n";
foreach (array_merge($mainPages, $services) as $file) {
    $url = $baseUrl . '/' . $file;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code == 200) {
        echo " [HTTP 200] $url\n";
    } else {
        echo " [ERROR $code] $url\n";
    }
}

echo "\n=== 3. VERIFYING DROPDOWN IN ALL MAIN PAGES ===\n";
foreach ($mainPages as $file) {
    if ($file === 'sitemap.xml') continue;
    $content = file_get_contents(__DIR__ . '/../' . $file);
    $foundCount = 0;
    foreach ($services as $sf) {
        if (strpos($content, $sf) !== false) {
            $foundCount++;
        }
    }
    echo " $file: $foundCount / 11 services linked in page\n";
}

echo "\n=== 4. VERIFYING DROPDOWN IN ALL 11 SERVICE PAGES ===\n";
foreach ($services as $file) {
    $content = file_get_contents(__DIR__ . '/../' . $file);
    $foundCount = 0;
    foreach ($services as $sf) {
        if (strpos($content, $sf) !== false) {
            $foundCount++;
        }
    }
    echo " $file: $foundCount / 11 services linked in page\n";
}

echo "\nVerification complete!\n";


