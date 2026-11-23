<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
preg_match('/<h1[^>]*>.*?<\/h1>/is', $html, $m);
echo "H1 found: " . trim(preg_replace('/\s+/', ' ', strip_tags($m[0] ?? ''))) . "\n";
echo "Raw H1:\n" . ($m[0] ?? '') . "\n";


