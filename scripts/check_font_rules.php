<?php
$css = file_get_contents(__DIR__ . '/../css/home-live.css');
echo "Length: " . strlen($css) . "\n";
// Let's check font-family occurrences
preg_match_all('/font-family:[^;}]+/i', $css, $m);
print_r(array_unique($m[0]));


