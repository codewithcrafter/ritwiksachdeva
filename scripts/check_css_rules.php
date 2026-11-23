<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
$checkClasses = [
    'service-box',
    'about-card',
    'client-logo',
    'impact-number',
    'elementor-counter',
    'who-we-are',
    'consultant'
];
foreach ($checkClasses as $cls) {
    echo "Class '$cls': " . (strpos($css, $cls) !== false ? 'FOUND' : 'MISSING') . "\n";
}
echo "Total CSS size: " . strlen($css) . " bytes\n";


