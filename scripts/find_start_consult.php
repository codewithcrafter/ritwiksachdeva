<?php
$files = glob('*.html');
foreach ($files as $file) {
    $c = file_get_contents($file);
    if (stripos($c, 'Start a Consultation') !== false) {
        echo "Found in $file\n";
        preg_match_all('/.{0,100}Start a Consultation.{0,200}/is', $c, $m);
        foreach ($m[0] as $match) {
            echo "   " . trim($match) . "\n";
        }
    }
}
