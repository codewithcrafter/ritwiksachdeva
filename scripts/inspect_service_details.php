<?php
// inspect_service_details.php

$files = [
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-seo-expert.html',
    'service-ecommerce-management.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-website-designer.html',
    'service-best-marketing-consultant.html'
];

foreach ($files as $file) {
    $filePath = __DIR__ . '/../' . $file;
    if (!file_exists($filePath)) continue;
    $html = file_get_contents($filePath);
    $dom = new DOMDocument();
    @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $xpath = new DOMXPath($dom);

    $h1 = $xpath->query('//h1')->item(0);
    $h1Text = $h1 ? trim($h1->textContent) : 'No H1';
    $stats = $xpath->query('//*[contains(@class, "stat-item")]');
    $delivs = $xpath->query('//*[contains(@class, "deliverable-card")]');
    $faqs = $xpath->query('//*[contains(@class, "faq-item")]');

    echo "=== $file ===\n";
    echo "H1: $h1Text\n";
    echo "Stats count: " . $stats->length . "\n";
    echo "Deliverables count: " . $delivs->length . "\n";
    echo "FAQs count: " . $faqs->length . "\n\n";
}
