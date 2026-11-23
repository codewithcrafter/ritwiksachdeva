<?php
/**
 * UPDATE NAVBAR DROPDOWN, MOBILE SUBMENU, AND FOOTER LINKS IN ALL PAGES
 */

$files = [
    'index.html',
    'about.html',
    'blog.html',
    'contact.html',
    'blog.php',
    'blog-detail.php'
];

$desktopDropdown = <<<HTML
<div class="nav-dropdown-menu" role="menu">
              <div class="nav-dropdown-header">
                <span class="dropdown-header-title">All Services &amp; Practices</span>
                <span class="dropdown-header-tag">11 Services</span>
              </div>
              <div class="nav-dropdown-list">
                <a href="service-ecommerce-management.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">01</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">E-Commerce Management</div>
                    <div class="dropdown-item-desc">Amazon, Flipkart &amp; Shopify Growth</div>
                  </div>
                </a>
                <a href="service-graphic-designer.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">02</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Graphic Designer</div>
                    <div class="dropdown-item-desc">Brand Identity, Logos &amp; Visual Assets</div>
                  </div>
                </a>
                <a href="service-performance-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">03</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Performance Marketing Consultant in Delhi</div>
                    <div class="dropdown-item-desc">Meta &amp; Google Paid Media Scaling</div>
                  </div>
                </a>
                <a href="service-ppc-expert.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">04</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">PPC Expert in Delhi</div>
                    <div class="dropdown-item-desc">Google Ads, PMax &amp; Shopping Campaigns</div>
                  </div>
                </a>
                <a href="service-product-shoot.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">05</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Product Shoot Services in Delhi</div>
                    <div class="dropdown-item-desc">E-Commerce &amp; High-Conversion Photography</div>
                  </div>
                </a>
                <a href="service-seo-expert.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">06</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">SEO Expert in Delhi</div>
                    <div class="dropdown-item-desc">Technical, Local &amp; Organic Search Growth</div>
                  </div>
                </a>
                <a href="service-smo-services.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">07</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">SMO Services in Delhi</div>
                    <div class="dropdown-item-desc">Social Media Optimization &amp; Reach</div>
                  </div>
                </a>
                <a href="service-social-media-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">08</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Social Media Marketing Agency in Delhi</div>
                    <div class="dropdown-item-desc">Organic Engagement &amp; Viral Campaigns</div>
                  </div>
                </a>
                <a href="service-video-editing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">09</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Video Editing Services in Delhi</div>
                    <div class="dropdown-item-desc">Reels, Shorts, Video Ads &amp; Longform</div>
                  </div>
                </a>
                <a href="service-best-marketing-consultant.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">10</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">best marketing consultant</div>
                    <div class="dropdown-item-desc">Strategic Full-Funnel Business Consulting</div>
                  </div>
                </a>
                <a href="service-website-designer.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">11</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Website Designer in Delhi</div>
                    <div class="dropdown-item-desc">Custom Web Development &amp; Shopify Stores</div>
                  </div>
                </a>
              </div>
              <div class="nav-dropdown-footer">
                <a href="services.html" class="dropdown-view-all">
                  <span>View Comprehensive Services Catalog</span>
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
              </div>
            </div>
HTML;

$mobileSubmenu = <<<HTML
<div class="mobile-submenu">
          <a href="service-ecommerce-management.html" class="mobile-sublink">01. E-Commerce Management</a>
          <a href="service-graphic-designer.html" class="mobile-sublink">02. Graphic Designer</a>
          <a href="service-performance-marketing.html" class="mobile-sublink">03. Performance Marketing Consultant in Delhi</a>
          <a href="service-ppc-expert.html" class="mobile-sublink">04. PPC Expert in Delhi</a>
          <a href="service-product-shoot.html" class="mobile-sublink">05. Product Shoot Services in Delhi</a>
          <a href="service-seo-expert.html" class="mobile-sublink">06. SEO Expert in Delhi</a>
          <a href="service-smo-services.html" class="mobile-sublink">07. SMO Services in Delhi</a>
          <a href="service-social-media-marketing.html" class="mobile-sublink">08. Social Media Marketing Agency in Delhi</a>
          <a href="service-video-editing.html" class="mobile-sublink">09. Video Editing Services in Delhi</a>
          <a href="service-best-marketing-consultant.html" class="mobile-sublink">10. best marketing consultant</a>
          <a href="service-website-designer.html" class="mobile-sublink">11. Website Designer in Delhi</a>
        </div>
HTML;

$footerServices = <<<HTML
<h4 class="footer-heading">Services</h4>
          <ul class="footer-links">
            <li><a href="service-ecommerce-management.html">E-Commerce Management</a></li>
            <li><a href="service-graphic-designer.html">Graphic Designer</a></li>
            <li><a href="service-performance-marketing.html">Performance Marketing Consultant in Delhi</a></li>
            <li><a href="service-ppc-expert.html">PPC Expert in Delhi</a></li>
            <li><a href="service-product-shoot.html">Product Shoot Services in Delhi</a></li>
            <li><a href="service-seo-expert.html">SEO Expert in Delhi</a></li>
            <li><a href="service-smo-services.html">SMO Services in Delhi</a></li>
            <li><a href="service-social-media-marketing.html">Social Media Marketing Agency in Delhi</a></li>
            <li><a href="service-video-editing.html">Video Editing Services in Delhi</a></li>
            <li><a href="service-best-marketing-consultant.html">best marketing consultant</a></li>
            <li><a href="service-website-designer.html">Website Designer in Delhi</a></li>
          </ul>
HTML;

foreach ($files as $f) {
    $path = __DIR__ . '/../' . $f;
    if (!file_exists($path)) {
        echo "Skipping $f (not found)\n";
        continue;
    }

    $content = file_get_contents($path);

    // 1. Replace nav-dropdown-menu
    $content = preg_replace(
        '/<div class="nav-dropdown-menu" role="menu">.*?<\/div>\s*<\/div>/s',
        $desktopDropdown,
        $content
    );

    // 2. Replace mobile-submenu
    $content = preg_replace(
        '/<div class="mobile-submenu">.*?<\/div>/s',
        $mobileSubmenu,
        $content
    );

    // 3. Replace footer services block if found
    $content = preg_replace(
        '/<h4 class="footer-heading">(?:Core Practices|Services)<\/h4>\s*<ul class="footer-links">.*?<\/ul>/s',
        $footerServices,
        $content
    );

    file_put_contents($path, $content);
    echo "Updated navbar & footer in: $f\n";
}

echo "All navigation and footers updated successfully!\n";


