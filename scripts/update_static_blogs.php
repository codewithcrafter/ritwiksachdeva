<?php
require_once __DIR__ . '/generate_all_services.php';

$desktopDropdown = render_desktop_dropdown('');
$mobileSubmenu = render_mobile_submenu('');
$footerServices = render_footer_services_list();

$blogFiles = glob(__DIR__ . '/../blog-*.html');
foreach ($blogFiles as $bf) {
    $c = file_get_contents($bf);
    
    // Replace dropdown
    $c = preg_replace(
        '/<div class="nav-dropdown-menu"[^>]*>.*?<\/div>\s*<\/div>/s',
        $desktopDropdown,
        $c
    );
    // Replace mobile submenu
    $c = preg_replace(
        '/<div class="mobile-submenu">.*?<\/div>/s',
        $mobileSubmenu,
        $c
    );
    // Replace footer
    $c = preg_replace(
        '/<h4 class="footer-heading">(?:Core Practices|Services)<\/h4>\s*<ul class="footer-links">.*?<\/ul>/s',
        $footerServices,
        $c
    );

    file_put_contents($bf, $c);
    echo "Updated static blog: " . basename($bf) . "\n";
}

