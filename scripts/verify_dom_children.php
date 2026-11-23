<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

$sections = $xpath->query('//main[@id="main-content"]/*');
echo "Direct children of <main id=\"main-content\">: " . $sections->length . "\n";
foreach ($sections as $i => $sec) {
    $class = $sec->getAttribute('class');
    $id = $sec->getAttribute('id');
    $h = $xpath->query('.//h1 | .//h2', $sec);
    $hText = $h->length > 0 ? trim($h->item(0)->textContent) : 'No heading';
    echo ($i+1) . ". <" . $sec->nodeName . "> id=\"$id\" class=\"$class\" => Heading: $hText\n";
}


