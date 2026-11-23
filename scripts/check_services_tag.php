<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, 'Our Digital Marketing Services');
$start = strrpos(substr($html, 0, $pos), '<section');
$end = strpos($html, '</section>', $pos) + 10;
echo "Start: " . substr($html, $start, 150) . "\n";
echo "End: " . substr($html, $end - 100, 100) . "\n";


