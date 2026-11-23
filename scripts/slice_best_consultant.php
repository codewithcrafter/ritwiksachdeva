<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');

// Let's find sections or elementor containers
$posStart = strpos($html, 'THE BEST MARKETING CONSULTANT IN DELHI');
$posStart = strrpos(substr($html, 0, $posStart), '<section');
if ($posStart === false) {
    $posStart = strrpos(substr($html, 0, strpos($html, 'WHO WE ARE')), '<div');
}

$posEnd = strpos($html, 'id="site-footer-custom"');
if ($posEnd === false) {
    $posEnd = strpos($html, '<footer');
}

echo "Start pos: $posStart, End pos: $posEnd\n";
if ($posStart !== false && $posEnd !== false) {
    $slice = substr($html, $posStart, $posEnd - $posStart);
    file_put_contents(__DIR__ . '/raw_best_consultant_body.html', $slice);
    echo "Saved raw_best_consultant_body.html (" . strlen($slice) . " bytes)\n";
} else {
    echo "Could not find slice boundaries\n";
}


