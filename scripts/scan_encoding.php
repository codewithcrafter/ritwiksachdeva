<?php
// scripts/scan_encoding.php
$files = array_merge(
    glob('*.html'),
    glob('*.php'),
    glob('*.md'),
    glob('services/*.md'),
    glob('blog/*.md'),
    glob('css/*.css'),
    glob('js/*.js')
);

$badUtf8 = "\xEF\xBF\xBD";

echo "=== SCANNING FOR ENCODING ISSUES ===\n";
foreach ($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    $issues = [];
    
    // Check for U+FFFD replacement char
    $replacementCount = substr_count($content, $badUtf8);
    if ($replacementCount > 0) {
        $issues[] = "$replacementCount replacement character(s)";
    }
    
    // Check for ",50 Cr" instead of "₹50 Cr"
    if (strpos($content, ',50 Cr') !== false) {
        $issues[] = 'Found ",50 Cr"';
    }
    
    // Check for "Delhi  Ritwik"
    if (preg_match('/Delhi\s{2,}Ritwik/i', $content)) {
        $issues[] = 'Found "Delhi  Ritwik"';
    }

    // Check for "revenue  not"
    if (preg_match('/revenue\s{2,}not/i', $content)) {
        $issues[] = 'Found "revenue  not"';
    }

    if (!empty($issues)) {
        echo "$file:\n  - " . implode("\n  - ", $issues) . "\n";
    }
}
