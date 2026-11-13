<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$pos = strpos($html, "Let's Build a Winning Digital Growth Strategy");
if ($pos !== false) {
    echo substr($html, $pos, 1500) . "\n";
}

