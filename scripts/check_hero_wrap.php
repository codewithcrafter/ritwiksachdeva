<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
$pos = strpos($html, 'marketing-section');
if ($pos !== false) {
    echo substr($html, max(0, $pos - 400), 800) . "\n";
}


