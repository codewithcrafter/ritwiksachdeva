<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$pos = strpos($html, '<footer');
echo substr($html, $pos, 800) . "\n";

