<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

$pos1 = strpos($html, '#hero');
$pos2 = strpos($html, '#site-footer-custom');

if ($pos1 !== false && $pos2 !== false) {
    $css = substr($html, $pos1, $pos2 - $pos1);
    file_put_contents(__DIR__ . '/../css/home-live.css', $css);
    echo "Saved home-live.css (" . strlen($css) . " bytes)\n";
} else {
    echo "Could not find slice boundaries\n";
}

