<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
$body = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');

$keyClasses = [
    'marketing-hero-wrap',
    'marketing-section',
    'marketing-eyebrow',
    'marketing-headline',
    'marketing-content',
    'marketing-image-col',
    'image-motion-wrapper',
    'overlay-text',
    'impact-section',
    'impact-card',
    'impact-number',
    'services-grid',
    'service-box',
    'service-icon',
    'client-slider',
    'client-track',
    'client-logo',
    'slider',
    'slide-track',
    'elementor-counter',
    'growth-cta-btn',
    'about-section',
    'about-slider',
    'about-card',
    'strategy-section',
    'strategy-left',
    'strategy-right',
    'wpforms-form'
];

foreach ($keyClasses as $c) {
    $inCss = strpos($css, $c) !== false ? 'YES' : 'NO';
    $inBody = strpos($body, $c) !== false ? 'YES' : 'NO';
    echo sprintf("%-25s | In CSS: %-4s | In Body: %-4s\n", $c, $inCss, $inBody);
}

