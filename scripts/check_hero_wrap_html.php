<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
$pos = strpos($html, 'marketing-hero-wrap');
while ($pos !== false) {
    echo "Found at $pos: " . substr($html, $pos, 200) . "\n---\n";
    $pos = strpos($html, 'marketing-hero-wrap', $pos + 1);
}


