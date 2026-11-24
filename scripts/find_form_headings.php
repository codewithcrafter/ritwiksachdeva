<?php
$files = glob('*.html');
foreach ($files as $file) {
    $c = file_get_contents($file);
    preg_match_all('/<h[1-4][^>]*>(.*?)<\/h[1-4]>/is', $c, $headings);
    foreach ($headings[1] as $h) {
        $cleanH = trim(strip_tags($h));
        if (stripos($cleanH, 'Consult') !== false || stripos($cleanH, 'Form') !== false || stripos($cleanH, 'Inquiry') !== false || stripos($cleanH, 'Audit') !== false) {
            echo "$file: $cleanH\n";
        }
    }
}
