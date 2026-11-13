<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

$posStart = strpos($html, '<section id="hero"');
if ($posStart === false) {
    $posStart = strpos($html, 'id="hero"');
    $posStart = strrpos(substr($html, 0, $posStart), '<');
}

$posEnd = strpos($html, 'id="site-footer-custom"');
if ($posEnd !== false) {
    $posEnd = strrpos(substr($html, 0, $posEnd), '<footer');
    if ($posEnd === false) {
        $posEnd = strrpos(substr($html, 0, $posEnd), '<div');
    }
}

echo "Start pos: $posStart, End pos: $posEnd\n";
if ($posStart !== false && $posEnd !== false) {
    $slice = substr($html, $posStart, $posEnd - $posStart);
    file_put_contents(__DIR__ . '/raw_home_body.html', $slice);
    echo "Saved raw_home_body.html (" . strlen($slice) . " bytes)\n";
} else {
    echo "Could not find slice boundaries\n";
}

