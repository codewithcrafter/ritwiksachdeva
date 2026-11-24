<?php
// scripts/check_all_inputs_placeholders.php
$files = array_merge(glob('*.html'), glob('*.php'));
foreach ($files as $file) {
    if (strpos($file, 'admin') !== false) continue;
    $c = file_get_contents($file);
    preg_match_all('/<(?:input|textarea)[^>]*>/i', $c, $matches);
    foreach ($matches[0] as $tag) {
        if (stripos($tag, 'type="hidden"') !== false || stripos($tag, 'type="submit"') !== false || stripos($tag, 'type="checkbox"') !== false || stripos($tag, 'type="radio"') !== false) {
            continue;
        }
        if (stripos($tag, 'class="consult-honeypot"') !== false || stripos($tag, 'name="website_url"') !== false) {
            continue;
        }
        if (stripos($tag, 'placeholder') === false || preg_match('/placeholder=["\']\s*["\']/', $tag)) {
            echo "MISSING PLACEHOLDER in $file: $tag\n";
        }
    }
}
