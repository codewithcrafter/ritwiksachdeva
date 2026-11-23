<?php
$html = file_get_contents(__DIR__ . '/raw_home_body.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

$sections = $xpath->query('//section');
foreach ($sections as $s) {
    echo "=========================================================\n";
    echo "SECTION ID: #" . $s->getAttribute('id') . "\n";
    echo "CLASS: " . $s->getAttribute('class') . "\n";

    // Headings
    $h = $xpath->query('.//h1 | .//h2 | .//h3', $s);
    foreach ($h as $node) {
        echo "  " . $node->nodeName . ": " . trim(preg_replace('/\s+/', ' ', $node->textContent)) . "\n";
    }

    // Links / buttons
    $links = $xpath->query('.//a', $s);
    foreach ($links as $a) {
        echo "  LINK: " . trim($a->textContent) . " => " . $a->getAttribute('href') . "\n";
    }
}

