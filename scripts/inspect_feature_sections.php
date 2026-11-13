<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');

function printSnippet($title, $startStr, $len = 1000)
{
    global $html;
    $pos = strpos($html, $startStr);
    echo "=== $title ===\n";
    if ($pos !== false) {
        echo substr($html, $pos, $len) . "\n...\n\n";
    } else {
        echo "NOT FOUND: $startStr\n\n";
    }
}

printSnippet("BRANDS SECTION", "Trusted by Leading Brands");
printSnippet("RESULTS SECTION", "🚀 Our Results");
printSnippet("ABOUT RITWIK CARDS", "About Ritwik Sachdeva");
printSnippet("SCHEDULE STRATEGY CALL", "Schedule Your Free Strategy Call");

