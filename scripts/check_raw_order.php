<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
preg_match_all('/<h[12][^>]*>(.*?)<\/h[12]>/is', $html, $headings);
foreach ($headings[1] as $i => $h) {
    echo ($i+1) . ". " . trim(preg_replace('/\s+/', ' ', strip_tags($h))) . "\n";
}

