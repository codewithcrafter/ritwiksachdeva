<?php
// scripts/inspect_service_issues.php
$files = glob('service-*.html');
$files[] = 'services.html';

foreach ($files as $file) {
    $content = file_get_contents($file);
    echo "=== $file ===\n";
    // Check for WhatsApp Direct button
    if (preg_match('/WhatsApp Direct[^\n<]*/i', $content, $m)) {
        echo "WhatsApp Direct found: " . substr($content, max(0, strpos($content, 'WhatsApp Direct') - 100), 250) . "\n---\n";
    }
    // Check 50 Cr
    if (preg_match('/.{0,40}50\s*Cr.{0,40}/i', $content, $m2)) {
        echo "50 Cr match: " . $m2[0] . "\n";
    }
    // Check em dash or missing dash around Delhi and revenue
    if (preg_match('/.{0,30}Delhi.{0,20}Ritwik.{0,30}/i', $content, $m3)) {
        echo "Delhi-Ritwik match: " . $m3[0] . "\n";
    }
    if (preg_match('/.{0,30}revenue.{0,20}not.{0,30}/i', $content, $m4)) {
        echo "Revenue-not match: " . $m4[0] . "\n";
    }
}
