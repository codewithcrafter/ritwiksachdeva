<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');

$p1 = strpos($html, 'results-stats-section');
$p2 = strpos($html, 'strategy-call-section');

echo substr($html, $p1, $p2 - $p1) . "\n";

