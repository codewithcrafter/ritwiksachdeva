<?php
$html = file_get_contents(__DIR__ . '/raw_home_body.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

$sections = $xpath->query('//section | //div[@id]');
echo "Found " . $sections->length . " sections/containers with IDs:\n";
foreach ($sections as $s) {
    $id = $s->getAttribute('id');
    if ($id) {
        echo " - #" . $id . " (" . $s->nodeName . ")\n";
    }
}

