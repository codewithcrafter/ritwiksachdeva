<?php
$html = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

$nodes = $xpath->query('/html/body/div/*');
echo "Top level elements: " . $nodes->length . "\n";
foreach ($nodes as $i => $n) {
    echo "Element $i: <" . $n->nodeName . "> class=\"" . $n->getAttribute('class') . "\" id=\"" . $n->getAttribute('id') . "\"\n";
}

