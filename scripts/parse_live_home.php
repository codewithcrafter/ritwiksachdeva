<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

echo "=== TITLE & META ===\n";
$titles = $xpath->query('//title');
if ($titles->length > 0)
    echo "Title: " . trim($titles->item(0)->textContent) . "\n";

$metas = $xpath->query('//meta[@name="description"]/@content');
if ($metas->length > 0)
    echo "Meta Desc: " . trim($metas->item(0)->textContent) . "\n";

echo "\n=== ALL HEADINGS (H1, H2, H3, H4) ===\n";
$headings = $xpath->query('//h1 | //h2 | //h3 | //h4');
foreach ($headings as $h) {
    echo $h->nodeName . ": " . trim(preg_replace('/\s+/', ' ', $h->textContent)) . "\n";
}

echo "\n=== ALL SECTIONS / BLOCKS ===\n";
$sections = $xpath->query('//section | //main | //article | //div[contains(@class, "elementor-section")]');
echo "Found " . $sections->length . " structural sections\n";

