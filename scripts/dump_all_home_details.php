<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

echo "=== WHO THIS IS FOR ===\n";
$whoNode = $xpath->query('//*[contains(text(), "Who This Is For")]');
if ($whoNode->length > 0) {
    $parent = $whoNode->item(0)->parentNode;
    while ($parent && !strpos($parent->getAttribute('class'), 'elementor-section') && $parent->nodeName !== 'body') {
        $parent = $parent->parentNode;
    }
    if ($parent) {
        echo trim($parent->textContent) . "\n";
    }
}

echo "\n=== FAQS ===\n";
$faqNodes = $xpath->query('//div[contains(@class, "elementor-accordion-item")] | //div[contains(@class, "e-n-accordion-item")] | //details | //div[contains(@class, "schema-faq-section")]');
echo "Found " . $faqNodes->length . " faq items\n";
if ($faqNodes->length > 0) {
    foreach ($faqNodes as $f) {
        echo "--- FAQ ---\n";
        echo trim(preg_replace('/\s+/', ' ', $f->textContent)) . "\n";
    }
} else {
    // Search for FAQ text around Frequently Asked Questions
    $faqHead = $xpath->query('//*[contains(text(), "Frequently Asked Questions")]');
    if ($faqHead->length > 0) {
        $p = $faqHead->item(0)->parentNode;
        while ($p && !strpos($p->getAttribute('class'), 'elementor-section') && $p->nodeName !== 'body') {
            $p = $p->parentNode;
        }
        if ($p) {
            echo trim($p->textContent) . "\n";
        }
    }
}

echo "\n=== BUTTONS & CTAS ===\n";
$buttons = $xpath->query('//a[contains(@class, "elementor-button") or contains(@class, "btn")]');
foreach ($buttons as $b) {
    echo "Button: " . trim($b->textContent) . " -> " . $b->getAttribute('href') . "\n";
}

