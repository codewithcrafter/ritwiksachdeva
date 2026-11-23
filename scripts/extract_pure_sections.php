<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');

// 1. Services section pure markup
preg_match('/<section[^>]*class="[^"]*services-section[^"]*"[^>]*>.*?<\/section>/is', $html, $mServices);
if (empty($mServices)) {
    // Look for services-grid
    $pos = strpos($html, 'Our Digital Marketing Services');
    $start = strrpos(substr($html, 0, $pos), '<div class="services-container"');
    if ($start === false) $start = strrpos(substr($html, 0, $pos), '<div');
    $end = strpos($html, '</div></div>', $pos);
    echo "Services pos: $pos, start: $start, end: $end\n";
} else {
    echo "Services section matched length: " . strlen($mServices[0]) . "\n";
}

// 2. Client slider pure markup
preg_match('/<section[^>]*class="[^"]*client-slider-section[^"]*"[^>]*>.*?<\/section>/is', $html, $mBrands);
echo "Brands section matched: " . (!empty($mBrands) ? strlen($mBrands[0]) : "NO") . "\n";

// 3. Results slider pure markup
preg_match('/<section[^>]*class="[^"]*slider-section[^"]*"[^>]*>.*?<\/section>/is', $html, $mResults);
if (empty($mResults)) {
    preg_match('/<div[^>]*class="[^"]*slider[^"]*"[^>]*>.*?<\/div>\s*<\/div>/is', $html, $mResults);
}
echo "Results slider matched: " . (!empty($mResults) ? strlen($mResults[0]) : "NO") . "\n";

// 4. Growth CTA pure markup
preg_match('/<section[^>]*id="growth-cta"[^>]*>.*?<\/section>/is', $html, $mGrowth);
echo "Growth CTA matched: " . (!empty($mGrowth) ? strlen($mGrowth[0]) : "NO") . "\n";

// 5. About section pure markup
preg_match('/<section[^>]*class="[^"]*about-section[^"]*"[^>]*>.*?<\/section>/is', $html, $mAbout);
echo "About section matched: " . (!empty($mAbout) ? strlen($mAbout[0]) : "NO") . "\n";


