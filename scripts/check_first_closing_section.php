<?php
$html = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');
$pos = strpos($html, '</section>');
echo "First </section> at position: $pos\n";
echo substr($html, max(0, $pos - 200), 250) . "\n";

