<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, 'WHO WE ARE');
if ($pos !== false) {
    echo substr($html, max(0, $pos - 300), 2000);
} else {
    echo "WHO WE ARE not found";
}


