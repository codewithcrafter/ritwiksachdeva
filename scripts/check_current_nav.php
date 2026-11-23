<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$posNav = strpos($html, '<header');
$posNavEnd = strpos($html, '</header>');
echo substr($html, $posNav, $posNavEnd - $posNav + 9) . "\n";


