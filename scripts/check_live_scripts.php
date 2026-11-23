<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
preg_match_all('/<script[^>]*>.*?<\/script>/is', $html, $scripts);
echo "Total scripts: " . count($scripts[0]) . "\n";
foreach ($scripts[0] as $i => $s) {
    if (strpos($s, 'counter') !== false || strpos($s, 'count') !== false || strpos($s, 'swiper') !== false || strpos($s, 'splide') !== false || strpos($s, 'carousel') !== false || strlen($s) < 2000) {
        echo "Script $i (" . strlen($s) . " bytes):\n";
        echo substr(strip_tags($s), 0, 300) . "\n---\n";
    }
}


