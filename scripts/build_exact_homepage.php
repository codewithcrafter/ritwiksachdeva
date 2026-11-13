<?php
/**
 * BUILD EXACT HOMEPAGE (HEADER & FOOTER PRESERVED)
 * Content & Structure 100% identical to live site https://www.ritwiksachdeva.in/
 */

$indexContent = file_get_contents(__DIR__ . '/../index.html');
$cleanMain = file_get_contents(__DIR__ . '/clean_home_main.html');

// 1. Ensure home-live.css is linked in <head>
if (strpos($indexContent, 'css/home-live.css') === false) {
    $indexContent = str_replace(
        '<link rel="stylesheet" href="css/responsive.css">',
        "<link rel=\"stylesheet\" href=\"css/home-live.css\">\n  <link rel=\"stylesheet\" href=\"css/responsive.css\">",
        $indexContent
    );
}

// 2. Prepare the clean main block
$newMain = "<main id=\"main-content\">\n" . trim($cleanMain) . "\n  </main>";

// 3. Replace <main> ... </main> or <main id="main-content"> ... </main>
$mainPattern = '/<main[^>]*>.*?<\/main>/s';
if (preg_match($mainPattern, $indexContent)) {
    $indexContent = preg_replace($mainPattern, $newMain, $indexContent);
    echo "Replaced <main> successfully.\n";
} else {
    echo "ERROR: Could not find <main> in index.html\n";
    exit(1);
}

file_put_contents(__DIR__ . '/../index.html', $indexContent);
echo "index.html updated successfully! (" . strlen($indexContent) . " bytes)\n";
