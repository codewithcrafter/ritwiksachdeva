<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
preg_match_all('/@keyframes\s+([a-zA-Z0-9_-]+)/', $css, $keyframes);
echo "Keyframes found in best-consultant-live.css:\n";
print_r($keyframes[1]);

$classes = ['client-slider', 'client-track', 'slide-track', 'slider-wrapper', 'about-slider'];
foreach ($classes as $c) {
    if (preg_match('/\.'.preg_quote($c, '/').'[^\{]*\{[^\}]*\}/s', $css, $m)) {
        echo "=== CSS for .$c ===\n" . substr($m[0], 0, 300) . "\n\n";
    }
}


