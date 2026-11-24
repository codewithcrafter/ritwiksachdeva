<?php
// scripts/inspect_service_forms.php
$files = glob('service-*.html');
foreach ($files as $file) {
    $content = file_get_contents($file);
    preg_match_all('/<form[^>]*>.*?<\/form>/is', $content, $forms);
    if (!empty($forms[0])) {
        echo "=== $file (Forms: " . count($forms[0]) . ") ===\n";
        foreach ($forms[0] as $idx => $form) {
            echo "--- Form #$idx ---\n";
            preg_match_all('/<(?:input|textarea)[^>]*>/is', $form, $inputs);
            foreach ($inputs[0] as $inp) {
                echo "  $inp\n";
            }
        }
    }
}
