<?php
$html = file_get_contents(__DIR__ . '/raw_home_body.html');

// Let's inspect the sections
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

$sections = $xpath->query('//section');
echo "Sections count: " . $sections->length . "\n";

foreach ($sections as $s) {
    echo "ID: #" . $s->getAttribute('id') . "\n";
    // Check if there are outer elementor containers
}


