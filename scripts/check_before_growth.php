<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
echo substr($html, 227000, 1100) . "\n";

