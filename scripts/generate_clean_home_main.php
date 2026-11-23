<?php
$html = file_get_contents(__DIR__ . '/raw_home_body.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
$xpath = new DOMXPath($doc);

$sections = $xpath->query('//section');
$outputHtml = '';

foreach ($sections as $s) {
    $id = $s->getAttribute('id');
    $secHtml = $doc->saveHTML($s);
    
    // Clean lazy load attributes from WordPress LiteSpeed
    $secHtml = preg_replace('/data-lazyloaded="[^"]*"/i', '', $secHtml);
    $secHtml = preg_replace('/data-lazy-src="[^"]*"/i', '', $secHtml);
    $secHtml = preg_replace('/data-src="[^"]*"/i', '', $secHtml);
    $secHtml = preg_replace('/class="([^"]*)\blitespeed-loaded\b([^"]*)"/i', 'class="$1$2"', $secHtml);
    
    // Replace live image URL with local asset
    $secHtml = str_replace(
        'https://ritwiksachdeva.in/wp-content/uploads/2026/08/Best-Digital-Marketing-Consultant-in-Delhi.webp',
        'assets/images/Best-Digital-Marketing-Consultant-in-Delhi.webp',
        $secHtml
    );
    // Replace contact url
    $secHtml = str_replace('https://ritwiksachdeva.in/contact-us/', 'contact.html', $secHtml);
    
    $outputHtml .= "\n    " . trim($secHtml) . "\n";
}

file_put_contents(__DIR__ . '/clean_home_main.html', $outputHtml);
echo "Generated clean_home_main.html (" . strlen($outputHtml) . " bytes)\n";


