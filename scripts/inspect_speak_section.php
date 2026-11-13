<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$pos = strpos($html, 'Digital Marketing Results That Speak for Themselves');
echo substr($html, $pos - 100, 3000) . "\n";

