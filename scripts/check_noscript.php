<?php
$h = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');
echo "Noscript count: " . substr_count($h, '<noscript>') . "\n";

