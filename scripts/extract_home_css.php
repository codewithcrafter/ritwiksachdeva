<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

// Let's find all styles that have #trusted-businesses-searching or .dm-service-card or #dm-faq
$pos = strpos($html, '.dm-services-grid');
if ($pos !== false) {
    // Look backward to find the opening of this style block
    $start = strrpos(substr($html, 0, $pos), '<style');
    // Or if it's inline in a style attribute, check
    $chunk = substr($html, max(0, $pos - 2000), 12000);
    file_put_contents(__DIR__ . '/home_css_extracted.txt', $chunk);
    echo "Saved home_css_extracted.txt (" . strlen($chunk) . " bytes)\n";
} else {
    echo "not found";
}


