<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');

function printSec($name, $start, $len = 1000) {
    global $html;
    $p = strpos($html, $start);
    echo "=== $name ===\n";
    if ($p !== false) {
        echo substr($html, $p, $len) . "\n\n";
    } else {
        echo "NOT FOUND\n\n";
    }
}

printSec('PROVEN DIGITAL IMPACT', 'Proven Digital Impact');
printSec('SPEAK FOR THEMSELVES', 'Digital Marketing Results That Speak for Themselves');
printSec('SCHEDULE STRATEGY', 'Schedule Your Free Strategy Call Today');
printSec('FOOTER', '<footer');

