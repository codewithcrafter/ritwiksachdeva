<?php
// scripts/find_phone.php
$files = array_merge(glob('*.html'), glob('*.php'), glob('*.js'), glob('*.css'));
foreach ($files as $file) {
    if (!is_file($file)) continue;
    $c = file_get_contents($file);
    if (strpos($c, '92896 26986') !== false || strpos($c, '9289626986') !== false) {
        preg_match_all('/.{0,60}92896[\s-]?26986.{0,60}/', $c, $m);
        echo "$file:\n";
        foreach ($m[0] as $match) {
            echo "   " . trim($match) . "\n";
        }
    }
}
