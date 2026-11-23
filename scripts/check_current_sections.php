<?php
$html = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');

// Let's list all sections currently in clean_best_consultant_main.html
preg_match_all('/<h[12][^>]*>(.*?)<\/h[12]>/is', $html, $headings);
foreach ($headings[1] as $i => $h) {
    echo ($i+1) . ". " . trim(preg_replace('/\s+/', ' ', strip_tags($h))) . "\n";
}


