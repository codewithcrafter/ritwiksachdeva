<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

preg_match_all('#<style[^>]*>(.*?)</style>#is', $html, $matches);
foreach ($matches[1] as $css) {
    if (strpos($css, 'dm-service-card') !== false || strpos($css, 'hp-container') !== false || strpos($css, 'dm-who-grid') !== false) {
        echo "=== FOUND INLINE STYLES FOR HOMEPAGE ===\n";
        echo substr($css, 0, 3000) . "\n...\n";
    }
}


