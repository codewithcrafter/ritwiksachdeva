<?php
$html = file_get_contents(__DIR__ . '/live_best_consultant.html');

preg_match_all('#<style[^>]*>(.*?)</style>#is', $html, $matches);
echo "Total style tags: " . count($matches[1]) . "\n";

$savedCss = '';
foreach ($matches[1] as $idx => $css) {
    if (strpos($css, 'WHO WE ARE') !== false || 
        strpos($css, 'Proven Digital Impact') !== false || 
        strpos($css, 'Our Digital Marketing Services') !== false ||
        strpos($css, 'elementor-') !== false ||
        strpos($css, 'impact') !== false) {
        $savedCss .= "\n/* --- Style block $idx --- */\n" . $css;
    }
}

file_put_contents(__DIR__ . '/../css/best-consultant-live.css', $savedCss);
echo "Saved best-consultant-live.css (" . strlen($savedCss) . " bytes)\n";


