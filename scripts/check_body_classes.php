<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
preg_match_all('/class="([^"]+)"/i', $html, $m);
$classes = [];
foreach ($m[1] as $cList) {
    foreach (preg_split('/\s+/', $cList) as $c) {
        if ($c) $classes[$c] = ($classes[$c] ?? 0) + 1;
    }
}
arsort($classes);
echo "Top classes in raw body:\n";
print_r(array_slice($classes, 0, 30));

