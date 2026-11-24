<?php
// polish_markdown.php

$files = array_merge(
    glob(__DIR__ . '/../*.md'),
    glob(__DIR__ . '/../services/*.md'),
    glob(__DIR__ . '/../blog/*.md')
);

foreach ($files as $file) {
    if (is_dir($file)) continue;
    $content = file_get_contents($file);
    $orig = $content;

    $content = str_replace(',1₹50,000+', '₹1,50,000+', $content);
    $content = str_replace(',1,50,000', '₹1,50,000', $content);
    $content = str_replace(',50,000', '₹50,000', $content);
    $content = str_replace(',50 Cr+', '₹50 Cr+', $content);
    $content = str_replace('Meta—Ts', "Meta's", $content);
    $content = str_replace('What—Ts', "What's", $content);
    $content = str_replace('WhatTs', "What's", $content);
    $content = str_replace('—Ts', "'s", $content);
    $content = str_replace('—t', "'t", $content);

    // Remove any accidental double slashes in canonical URLs (e.g. services// or https://www.ritwiksachdeva.in//)
    $content = preg_replace('#(?<!:)//+#', '/', $content);

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Polished: " . basename($file) . "\n";
    }
}

echo "Finished polishing markdown files.\n";
