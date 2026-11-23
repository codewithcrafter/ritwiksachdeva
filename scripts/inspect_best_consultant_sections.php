<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

echo "=== SECTIONS IN RAW BODY ===\n";
$headings = $xpath->query('//h1 | //h2 | //h4');
foreach ($headings as $h) {
    echo "HEADING (" . $h->nodeName . "): " . trim(preg_replace('/\s+/', ' ', $h->textContent)) . "\n";
}

echo "\n=== IMAGES IN RAW BODY ===\n";
$images = $xpath->query('//img');
foreach ($images as $img) {
    echo "IMG: " . $img->getAttribute('src') . " | ALT: " . $img->getAttribute('alt') . "\n";
}

echo "\n=== SVG ICONS ===\n";
$svgs = $xpath->query('//svg');
echo "Total SVGs: " . $svgs->length . "\n";


