<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

echo "=== TITLE & META ===\n";
$titles = $xpath->query('//title');
if ($titles->length > 0) echo "Title: " . trim($titles->item(0)->textContent) . "\n";

$metas = $xpath->query('//meta[@name="description"]/@content');
if ($metas->length > 0) echo "Meta Desc: " . trim($metas->item(0)->textContent) . "\n";

echo "\n=== ALL HEADINGS ===\n";
$headings = $xpath->query('//h1 | //h2 | //h3 | //h4');
foreach ($headings as $h) {
    echo $h->nodeName . ": " . trim(preg_replace('/\s+/', ' ', $h->textContent)) . "\n";
}

echo "\n=== IMAGES IN PAGE ===\n";
$images = $xpath->query('//img/@src');
foreach ($images as $img) {
    $src = $img->textContent;
    if (strpos($src, 'http') === 0) {
        echo "IMG: " . $src . "\n";
    }
}

