<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
$pos = strpos($html, 'growth-cta');
echo substr($html, $pos - 300, 700) . "\n";


