<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');
echo substr($html, 191650, 200) . "\n";

