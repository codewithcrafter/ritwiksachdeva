<?php
$html = file_get_contents(__DIR__ . '/live_home.html');
$pos = strpos($html, '.dm-service-card');
if ($pos !== false) {
    // Find style tag boundaries
    $start = strrpos(substr($html, 0, $pos), '<style');
    $end = strpos($html, '</style>', $pos);
    echo substr($html, $start, ($end - $start + 8));
} else {
    echo "not found";
}

