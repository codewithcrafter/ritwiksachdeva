<?php
$h = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
echo "Length: " . strlen($h) . "\n";
preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', $h, $m);
foreach ($m[0] as $h) {
    echo strip_tags($h) . "\n";
}


