<?php
// scripts/find_all_forms_full.php
$files = array_merge(glob('*.html'), glob('*.php'));
foreach ($files as $file) {
    if (strpos($file, 'admin') !== false) continue;
    $c = file_get_contents($file);
    preg_match_all('/<form[^>]*>(.*?)<\/form>/is', $c, $forms);
    if (!empty($forms[0])) {
        foreach ($forms[0] as $i => $form) {
            // Find preceding heading
            $pos = strpos($c, $form);
            $before = substr($c, max(0, $pos - 400), 400);
            preg_match_all('/<h[1-4][^>]*>(.*?)<\/h[1-4]>/is', $before, $h);
            $lastH = !empty($h[1]) ? end($h[1]) : 'No heading';

            echo "$file (Heading: " . strip_tags($lastH) . "):\n";
            preg_match_all('/<(?:input|textarea)[^>]*>/is', $form, $inputs);
            foreach ($inputs[0] as $inp) {
                echo "   $inp\n";
            }
            echo "\n";
        }
    }
}
