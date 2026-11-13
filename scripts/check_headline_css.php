<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
preg_match('/\.marketing-headline[^\{]*\{[^\}]*\}/', $css, $m1);
preg_match('/\.marketing-headline\s+span[^\{]*\{[^\}]*\}/', $css, $m2);
echo $m1[0] . "\n" . ($m2[0] ?? '') . "\n";

