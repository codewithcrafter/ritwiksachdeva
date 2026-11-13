<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, 'Proven Digital Impact');
echo substr($html, $pos - 50, 1500) . "\n";

