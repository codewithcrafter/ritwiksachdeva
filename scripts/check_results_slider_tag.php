<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, 'ðŸš€ Our Results');
$start = strrpos(substr($html, 0, $pos), '<section');
$end = strpos($html, '</section>', $pos) + 10;
echo substr($html, $start, 300) . "\n...\n";
echo substr($html, $end - 200, 200) . "\n";


