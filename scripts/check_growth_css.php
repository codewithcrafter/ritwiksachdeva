<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
preg_match_all('/\.growth-cta[^{]*\{[^}]*\}/', $css, $matches);
foreach ($matches[0] as $m) {
    echo $m . "\n";
}

