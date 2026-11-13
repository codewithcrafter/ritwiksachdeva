<?php
$html = file_get_contents(__DIR__ . '/raw_home_body.html');
preg_match_all('#<svg[^>]*>.*?</svg>#is', $html, $svgs);
echo "Total SVGs in raw_home_body.html: " . count($svgs[0]) . "\n";
foreach (array_slice($svgs[0], 0, 5) as $idx => $s) {
    echo "SVG $idx: " . substr($s, 0, 100) . "...\n";
}

