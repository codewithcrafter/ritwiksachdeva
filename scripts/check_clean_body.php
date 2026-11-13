<?php
$h = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');
preg_match_all('/<img[^>]+>/i', $h, $m);
foreach ($m[0] as $img) {
    echo $img . "\n";
}

