<?php
$data = json_decode(file_get_contents('scripts/scraped_services.json'), true);
foreach ($data as $k => $v) {
    file_put_contents("scripts/{$k}_detail.txt", 
        "TITLE: " . $v['title'] . "\n" .
        "DESC: " . $v['desc'] . "\n\n" .
        "HEADINGS:\n" . implode("\n", $v['headings']) . "\n\n" .
        "PARAGRAPHS:\n" . implode("\n\n", $v['paragraphs']) . "\n"
    );
}
echo "Exported detail files for all 11 services.\n";


