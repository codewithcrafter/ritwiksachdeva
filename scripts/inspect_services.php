<?php
$data = json_decode(file_get_contents('scripts/scraped_services.json'), true);
foreach ($data as $k => $v) {
    echo "=========================================================\n";
    echo "KEY: $k\n";
    echo "TITLE: " . $v['title'] . "\n";
    echo "DESC: " . $v['desc'] . "\n";
    echo "HEADINGS COUNT: " . count($v['headings']) . "\n";
    echo "PARAGRAPHS COUNT: " . count($v['paragraphs']) . "\n";
    echo "FIRST 4 HEADINGS:\n";
    foreach (array_slice($v['headings'], 0, 4) as $h) {
        echo "  - $h\n";
    }
}

