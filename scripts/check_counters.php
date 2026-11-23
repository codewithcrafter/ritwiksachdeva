<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
preg_match_all('/class="[^"]*(?:counter|number|stat|metric)[^"]*"[^>]*>.*?<\/[^>]+>/is', $html, $m);
foreach ($m[0] as $match) {
    echo trim(strip_tags($match)) . " ==> " . substr($match, 0, 150) . "\n";
}


