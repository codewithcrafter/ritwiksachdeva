<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
$pos = strpos($css, 'header{margin-bottom:40px}');
echo "Position of header{margin-bottom:40px}: " . ($pos !== false ? $pos : 'NOT FOUND') . "\n";
if ($pos !== false) {
    echo substr($css, max(0, $pos - 100), 200) . "\n";
}

