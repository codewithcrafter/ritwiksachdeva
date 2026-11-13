<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

// Let's dump all text and elements in order under main or article or body
// Let's inspect images in the hero as well
$images = $xpath->query('//img/@src');
echo "=== IMAGES IN LIVE PAGE ===\n";
foreach ($images as $img) {
    echo $img->textContent . "\n";
}

// Let's dump the text grouped by sections
echo "\n=== SECTIONS CONTENT ===\n";
$headings = $xpath->query('//h1 | //h2');
foreach ($headings as $h) {
    echo "\n------------------------------------------------------------\n";
    echo "HEADING (" . $h->nodeName . "): " . trim($h->textContent) . "\n";
    
    // Find parent element or next siblings
    $parent = $h->parentNode;
    while ($parent && $parent->nodeName !== 'section' && $parent->nodeName !== 'body' && !strpos($parent->getAttribute('class'), 'elementor-section')) {
        $parent = $parent->parentNode;
    }
    
    if ($parent) {
        $texts = $xpath->query('.//p | .//li | .//h3 | .//a[@class="elementor-button-link" or contains(@class, "btn")]', $parent);
        foreach ($texts as $t) {
            $val = trim(preg_replace('/\s+/', ' ', $t->textContent));
            if ($val) {
                echo "  [" . $t->nodeName . "]: " . $val . "\n";
            }
        }
    }
}

