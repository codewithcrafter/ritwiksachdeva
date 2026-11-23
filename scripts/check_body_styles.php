<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $styles);
echo "Internal style tags inside body: " . count($styles[0]) . "\n";
foreach ($styles[0] as $i => $s) {
    echo "Style $i length: " . strlen($s) . "\n";
    echo substr(strip_tags($s), 0, 150) . "...\n---\n";
}


