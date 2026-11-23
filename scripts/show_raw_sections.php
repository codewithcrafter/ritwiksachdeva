<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

function print_context($html, $searchStr, $chars = 3000)
{
    $pos = strpos($html, $searchStr);
    if ($pos !== false) {
        echo "=== FOUND '$searchStr' AT POS $pos ===\n";
        $start = max(0, $pos - 200);
        $chunk = substr($html, $start, $chars);
        // Strip tags partially or show clean html
        echo htmlspecialchars_decode(strip_tags($chunk, '<p><h3><h4><div><span><a><li><ul><details><summary>')) . "\n";
    } else {
        echo "=== '$searchStr' NOT FOUND ===\n";
    }
}

print_context($html, 'Who This Is For', 2500);
print_context($html, 'Frequently Asked Questions', 4000);
print_context($html, 'Digital Marketing Services in Delhi', 3500);

