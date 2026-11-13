<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
$check = ['marketing-section', 'marketing-eyebrow', 'marketing-headline', 'marketing-image-col', 'overlay-text'];
foreach ($check as $c) {
    echo "$c: " . (strpos($css, $c) !== false ? 'FOUND' : 'MISSING') . "\n";
}

