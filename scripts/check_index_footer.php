<?php
$indexHtml = file_get_contents(__DIR__ . '/../index.html');
preg_match('/<footer\b[^>]*>.*?<\/footer>/is', $indexHtml, $m);
echo "Index footer length: " . strlen($m[0] ?? '') . "\n";
echo substr($m[0] ?? '', 0, 500) . "\n";

