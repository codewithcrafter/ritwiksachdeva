<?php
$html = file_get_contents(__DIR__ . '/../index.html');

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

echo "=== CHECKING INDEX.HTML ===\n";
echo "Header exists: " . ($xpath->query('//header[@id="navbar"]')->length ? 'YES' : 'NO') . "\n";
echo "Footer exists: " . ($xpath->query('//footer')->length ? 'YES' : 'NO') . "\n";
echo "Dropdown items in header: " . $xpath->query('//div[contains(@class, "nav-dropdown-item")]')->length . "\n";
echo "Mobile sublinks: " . $xpath->query('//a[contains(@class, "mobile-sublink")]')->length . "\n";

$sections = [
    'hero',
    'what-consultant-does',
    'services',
    'who-for',
    'choosing-consultant',
    'results-focused-marketing',
    'trusted-businesses-searching',
    'dm-faq',
    'cta-consultant-delhi'
];

echo "\n=== HOMEPAGE SECTIONS ===\n";
foreach ($sections as $sId) {
    $sec = $xpath->query('//*[@id="' . $sId . '"]');
    if ($sec->length > 0) {
        $h = $xpath->query('.//h1 | .//h2', $sec->item(0));
        $headingText = ($h->length > 0) ? trim($h->item(0)->textContent) : '(no h1/h2)';
        echo " [OK] #$sId: $headingText\n";
    } else {
        echo " [FAIL] #$sId NOT FOUND!\n";
    }
}

