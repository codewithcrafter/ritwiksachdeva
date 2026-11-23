<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$posDrawer = strpos($html, '<div class="mobile-drawer"');
$posDrawerEnd = strpos($html, '</div>', $posDrawer + 2000);
echo substr($html, $posDrawer, 1200) . "\n";


