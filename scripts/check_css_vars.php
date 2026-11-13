<?php
$css = file_get_contents(__DIR__ . '/../css/best-consultant-live.css');
preg_match_all('/var\(--([a-zA-Z0-9_-]+)/', $css, $vars);
$uniqueVars = array_unique($vars[1]);
echo "CSS variables referenced: " . count($uniqueVars) . "\n";
foreach (array_slice($uniqueVars, 0, 20) as $v) {
    $defined = strpos($css, "--$v:") !== false ? 'DEFINED' : 'UNDEFINED';
    echo "--$v: $defined\n";
}

