<?php
// scripts/search_form_text.php
$files = array_merge(glob('*.html'), glob('*.php'), glob('*.js'), glob('includes/*.php'), glob('admin/*.php'));
foreach ($files as $file) {
    if (!is_file($file)) continue;
    $c = file_get_contents($file);
    if (stripos($c, 'FREE GROWTH CONSULTATION') !== false) {
        echo "Found 'FREE GROWTH CONSULTATION' in $file\n";
    }
    if (stripos($c, 'Start a Consultation') !== false) {
        echo "Found 'Start a Consultation' in $file\n";
    }
    if (stripos($c, '92896') !== false) {
        preg_match_all('/.{0,40}92896.{0,40}/', $c, $m);
        foreach ($m[0] as $match) {
            if (stripos($match, 'input') !== false || stripos($match, 'placeholder') !== false || stripos($match, 'form') !== false || stripos($match, 'value') !== false) {
                echo "Found 92896 in form context in $file: " . trim($match) . "\n";
            }
        }
    }
}
