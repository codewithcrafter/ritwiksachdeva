<?php
$data = json_decode(file_get_contents('scripts/scraped_services.json'), true);
foreach ($data as $k => $v) {
    echo "=== " . strtoupper($k) . " ===\n";
    echo "Title: " . $v['title'] . "\n";
    echo "Desc: " . $v['desc'] . "\n";
    echo "Headings:\n";
    foreach (array_slice($v['headings'], 0, 6) as $h) {
        echo "  $h\n";
    }
    echo "Sample text:\n";
    foreach (array_slice($v['paragraphs'], 0, 2) as $p) {
        echo "  > " . substr($p, 0, 140) . "...\n";
    }
    echo "\n";
}


