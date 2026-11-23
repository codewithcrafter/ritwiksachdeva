<?php
/**
 * CLEAN AND FIX ALL NAVBAR DROPDOWNS AND MOBILE MENUS ACROSS ALL PAGES
 */

require_once __DIR__ . '/generate_all_services.php';

$desktopDropdown = render_desktop_dropdown('');
$mobileSubmenu = render_mobile_submenu('');
$footerServices = render_footer_services_list();

// Collect all relevant files
$allFiles = array_merge(
    glob(__DIR__ . '/../*.html'),
    glob(__DIR__ . '/../*.php')
);

foreach ($allFiles as $filePath) {
    $filename = basename($filePath);

    // Skip service-* files as they were already generated perfectly
    if (strpos($filename, 'service-') === 0) {
        continue;
    }
    // Skip scripts/ or admin/ or test files
    if (strpos($filePath, 'scripts') !== false || strpos($filePath, 'admin') !== false) {
        continue;
    }

    $content = file_get_contents($filePath);
    $origLen = strlen($content);

    // 1. Replace the entire desktop dropdown between `<div class="nav-dropdown-menu"` and `</li>\s*<li class="nav-item"><a href="blog`
    $dropdownPattern = '/<div class="nav-dropdown-menu"[^>]*>.*?<\/div>\s*<\/li>\s*(<li class="nav-item">\s*<a href="blog)/s';
    if (preg_match($dropdownPattern, $content)) {
        $content = preg_replace($dropdownPattern, $desktopDropdown . "\n          </li>\n          $1", $content);
    }

    // 2. Replace mobile-submenu
    $mobilePattern = '/<div class="mobile-submenu">.*?<\/div>/s';
    if (preg_match($mobilePattern, $content)) {
        $content = preg_replace($mobilePattern, $mobileSubmenu, $content);
    }

    // 3. Replace footer services block if found
    $footerPattern = '/<h4 class="footer-heading">(?:Core Practices|Services)<\/h4>\s*<ul class="footer-links">.*?<\/ul>/s';
    if (preg_match($footerPattern, $content)) {
        $content = preg_replace($footerPattern, $footerServices, $content);
    }

    if (strlen($content) !== $origLen) {
        file_put_contents($filePath, $content);
        echo "Cleaned and updated: $filename\n";
    }
}

echo "Navbar cleanup complete!\n";


