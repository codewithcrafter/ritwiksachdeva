<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
$pos = strpos($html, '<section id="growth-cta"');
if ($pos === false) {
    $pos = strpos($html, 'growth-cta-title');
}
echo "HTML pos: $pos\n";
echo substr($html, $pos - 400, 800) . "\n";

