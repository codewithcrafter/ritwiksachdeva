<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, 'Our Digital Marketing Services');
if ($pos !== false) {
    echo substr($html, $pos, 2500) . "\n";
}


