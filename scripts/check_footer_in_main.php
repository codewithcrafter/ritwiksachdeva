<?php
$html = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');
$pos = strpos($html, '<footer');
echo "Footer pos in clean_best_consultant_main.html: " . ($pos !== false ? $pos : 'NOT FOUND') . "\n";
if ($pos !== false) {
    echo substr($html, $pos, 1500) . "\n";
}

