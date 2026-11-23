<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');

$sections = [
    'results-stats-section',
    'growth-cta',
    'about-section',
    'strategy-call-section'
];

foreach ($sections as $sec) {
    preg_match_all('/\.'.preg_quote($sec, '/').'[^{]*\{[^}]*\}/s', $css, $m);
    echo "=== CSS for .$sec (" . count($m[0]) . " rules) ===\n";
    foreach ($m[0] as $rule) {
        echo trim($rule) . "\n---\n";
    }
    echo "\n";
}

