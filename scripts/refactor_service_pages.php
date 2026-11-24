<?php
// refactor_service_pages.php

$services = [
    'service-graphic-designer.html' => [
        'slug' => 'graphic-designer',
        'badge' => 'CREATIVE DIRECTION & BRANDING',
        'cat1' => 'Brand Identity',
        'cat2' => 'Marketing Collateral'
    ],
    'service-performance-marketing.html' => [
        'slug' => 'performance-marketing',
        'badge' => 'PAID MEDIA & UNIT ECONOMICS',
        'cat1' => 'Paid Channels',
        'cat2' => 'Attribution & Metrics'
    ],
    'service-seo-expert.html' => [
        'slug' => 'seo-expert',
        'badge' => 'SEARCH ENGINE OPTIMIZATION',
        'cat1' => 'Technical SEO',
        'cat2' => 'Organic Pipeline'
    ],
    'service-ecommerce-management.html' => [
        'slug' => 'ecommerce-management',
        'badge' => 'MARKETPLACE & STORE GROWTH',
        'cat1' => 'Marketplaces (Amazon/Flipkart)',
        'cat2' => 'D2C Shopify & Logistics'
    ],
    'service-ppc-expert.html' => [
        'slug' => 'ppc-expert',
        'badge' => 'GOOGLE ADS & HIGH INTENT SEARCH',
        'cat1' => 'Search & PMax',
        'cat2' => 'Commercial Setup'
    ],
    'service-product-shoot.html' => [
        'slug' => 'product-shoot',
        'badge' => 'COMMERCIAL PRODUCT PHOTOGRAPHY',
        'cat1' => 'Catalog & E-Com Shoots',
        'cat2' => 'Creative Lifestyle & 360'
    ],
    'service-smo-services.html' => [
        'slug' => 'smo-services',
        'badge' => 'SOCIAL MEDIA OPTIMIZATION',
        'cat1' => 'Platform Optimization',
        'cat2' => 'Organic Retention'
    ],
    'service-social-media-marketing.html' => [
        'slug' => 'social-media-marketing',
        'badge' => 'FULL-FUNNEL SOCIAL MARKETING',
        'cat1' => 'Organic Community',
        'cat2' => 'Paid Amplification'
    ],
    'service-video-editing.html' => [
        'slug' => 'video-editing',
        'badge' => 'HIGH RETENTION VIDEO PRODUCTION',
        'cat1' => 'Short-Form Reels/Shorts',
        'cat2' => 'Long-Form & Commercials'
    ],
    'service-website-designer.html' => [
        'slug' => 'website-designer',
        'badge' => 'HIGH CONVERSION WEB ARCHITECTURE',
        'cat1' => 'Custom Development',
        'cat2' => 'Performance & Speed'
    ],
];

$waSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';

foreach ($services as $filename => $meta) {
    $filePath = __DIR__ . '/../' . $filename;
    if (!file_exists($filePath)) continue;

    $content = file_get_contents($filePath);

    // 1. Ensure clean UTF-8 strings
    $content = str_replace([
        ',50 Cr+',
        '&#8377;50 Cr+',
        'Delhi  Ritwik Sachdeva',
        'revenue  not impressions',
        'WhatTs the Difference',
        'What—Ts the Difference',
        'What—Ts Included',
        'WhatTs Included',
        'It—Ts Different',
        'Platform  Platform',
        "\xEF\xBF\xBD"
    ], [
        '₹50 Cr+',
        '₹50 Cr+',
        'Delhi — Ritwik Sachdeva',
        'revenue — not impressions',
        'What’s the Difference',
        'What’s the Difference',
        'What’s Included',
        'What’s Included',
        'It’s Different',
        'Platform — Platform',
        '—'
    ], $content);

    // 2. Link css/service-detail.css in <head> if not present
    if (strpos($content, 'css/service-detail.css') === false) {
        $content = str_replace('</head>', "  <link rel=\"stylesheet\" href=\"css/service-detail.css\">\n</head>", $content);
    }

    // 3. Add js/service-detail.js before </body> if not present
    if (strpos($content, 'js/service-detail.js') === false) {
        $content = str_replace('</body>', "  <script src=\"js/service-detail.js\"></script>\n</body>", $content);
    }

    // 4. Extract Hero Elements (H1, Lead, Stats)
    $h1Match = '';
    if (preg_match('/<h1[^>]*>([\s\S]*?)<\/h1>/i', $content, $m)) {
        $h1Match = trim($m[1]);
    }

    $leadMatch = '';
    if (preg_match('/<p class="service-detail-lead">([\s\S]*?)<\/p>/i', $content, $m)) {
        $leadMatch = trim($m[1]);
    }

    $statsHtml = '';
    if (preg_match('/<div class="service-key-stats-row">([\s\S]*?)<\/div>/i', $content, $m)) {
        // Parse individual stat items
        if (preg_match_all('/<div class="stat-item-block">([\s\S]*?)<\/div>/i', $m[1], $statBlocks)) {
            foreach ($statBlocks[0] as $sb) {
                preg_match('/<div class="stat-item-val">([\s\S]*?)<\/div>/i', $sb, $vm);
                preg_match('/<div class="stat-item-lbl">([\s\S]*?)<\/div>/i', $sb, $lm);
                $val = trim($vm[1] ?? '');
                $lbl = trim($lm[1] ?? '');
                if ($val && $lbl) {
                    $statsHtml .= "            <div class=\"sd-kpi-card\">\n              <div class=\"sd-kpi-val\">{$val}</div>\n              <div class=\"sd-kpi-lbl\">{$lbl}</div>\n            </div>\n";
                }
            }
        }
    }

    // 5. Construct New 2-Column Split Hero with Right Consultation Form Card Above-The-Fold
    $slug = $meta['slug'];
    $badge = $meta['badge'];

    $newHero = <<<HTML
  <!-- SERVICE HERO (2-COLUMN SPLIT 7fr 5fr WITH INLINE FORM ABOVE-THE-FOLD) -->
  <section class="sd-hero rs-fluid-4cm">
    <div class="sd-hero-grid">
      <!-- Left Column (7fr): Eyebrow, H1, Lead, CTAs, 4-Column KPI Strip -->
      <div class="sd-hero-left">
        <div class="sd-eyebrow">
          <span class="sd-eyebrow-dot"></span>
          <span>{$badge}</span>
        </div>
        <h1 class="sd-hero-title">{$h1Match}</h1>
        <p class="sd-hero-lead">{$leadMatch}</p>
        
        <div class="sd-hero-ctas">
          <button type="button" class="sd-btn-primary" onclick="if(window.consultPopup){window.consultPopup.open('Hero Consultation Button');}">
            Book a Consultation
            <span class="btn-icon-right">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </button>
          <a href="https://wa.me/919289626986" class="sd-btn-secondary" target="_blank" rel="noopener noreferrer">
            WhatsApp Direct
            <span class="btn-icon-right">
              {$waSvg}
            </span>
          </a>
        </div>

        <div class="sd-kpi-grid">
{$statsHtml}        </div>
      </div>

      <!-- Right Column (5fr): Compact Above-The-Fold Consultation Form Card -->
      <div class="sd-hero-right">
        <div class="sd-hero-form-card">
          <span class="sd-form-badge">Priority Access</span>
          <h3 class="sd-form-title">Start a Conversation</h3>
          <p class="sd-form-sub">Direct response from Ritwik within 24 hours.</p>
          <form class="sd-hero-inline-form" action="/consult-submit.php" method="POST">
            <input type="hidden" name="source_page" value="/services/{$slug}">
            <input type="hidden" name="source_trigger" value="Hero Inline Form">
            <input type="hidden" name="form_type" value="inline_hero">
            <div class="sd-form-body">
              <div class="sd-field-group">
                <label class="sd-field-label">Your Name</label>
                <input type="text" name="name" required placeholder="e.g. Rohan Sharma" class="sd-input">
              </div>
              <div class="sd-field-group">
                <label class="sd-field-label">Email Address</label>
                <input type="email" name="email" required placeholder="alex@company.com" class="sd-input">
              </div>
              <div class="sd-field-group">
                <label class="sd-field-label">Phone Number</label>
                <input type="tel" name="phone" required placeholder="+91 00000-00000" class="sd-input">
              </div>
              <div class="sd-field-group">
                <label class="sd-field-label">Project Goals or Challenges</label>
                <textarea name="message" rows="2" placeholder="Tell us about your project, goals, or challenges..." class="sd-textarea"></textarea>
              </div>
              <button type="submit" class="sd-submit-btn">
                Request Consultation <span style="font-weight:900;">→</span>
              </button>
              <div class="sd-form-feedback"></div>
              <div class="sd-form-footer-note">
                🔒 100% Confidential • Direct Advisory
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
HTML;

    // Replace original <section class="service-detail-hero">...</section>
    $content = preg_replace('/<section class="service-detail-hero">[\s\S]*?<\/section>/i', $newHero, $content, 1);

    // 6. Apply .rs-fluid-4cm and layout classes across all content sections
    $content = preg_replace('/<section class="service-content-section"([^>]*)>/i', '<section class="sd-section rs-fluid-4cm"$1>', $content);
    $content = preg_replace('/<section class="service-content-section">/i', '<section class="sd-section rs-fluid-4cm">', $content);

    // Replace container wrappers inside sections to full stretch
    $content = str_replace('<div class="service-detail-header-wrap">', '<div class="sd-section-header">', $content);
    $content = str_replace('<div class="service-page-main service-faq-container">', '<div class="sd-faq-wrap">', $content);
    $content = str_replace('class="service-page-main"', 'class="sd-content-wrap"', $content);

    // Comparison cards 2-column styling
    $content = str_replace('class="comparison-grid-2col"', 'class="sd-comparison-grid comparison-grid-2col"', $content);
    $content = str_replace('class="comparison-box"', 'class="sd-comp-card comparison-box"', $content);
    $content = str_replace('class="comparison-box highlight"', 'class="sd-comp-card strategic comparison-box highlight"', $content);
    $content = str_replace('class="comparison-title"', 'class="sd-comp-title comparison-title"', $content);
    $content = str_replace('class="comparison-desc"', 'class="sd-comp-desc comparison-desc"', $content);

    // Deliverables grid 4-column compact styling
    $content = str_replace('class="deliverables-grid"', 'class="sd-deliverables-grid deliverables-grid"', $content);
    $content = str_replace('class="deliverable-card"', 'class="sd-deliv-card deliverable-card"', $content);
    $content = str_replace('class="deliverable-num"', 'class="sd-deliv-num deliverable-num"', $content);
    $content = str_replace('class="deliverable-title"', 'class="sd-deliv-title deliverable-title"', $content);
    $content = str_replace('class="deliverable-desc"', 'class="sd-deliv-desc deliverable-desc"', $content);

    // FAQ 2-column compact accordion styling
    $content = str_replace('class="faq-accordion-list"', 'class="sd-faq-grid faq-accordion-list"', $content);
    $content = str_replace('class="faq-item', 'class="sd-faq-item faq-item', $content);
    $content = str_replace('class="faq-question', 'class="sd-faq-trigger faq-question', $content);
    $content = str_replace('class="faq-answer', 'class="sd-faq-content faq-answer', $content);

    // Add interactive tab bar to the first deliverables section if not already present
    if (strpos($content, 'sd-tab-bar') === false && strpos($content, 'id="deliverables"') !== false) {
        $cat1 = $meta['cat1'];
        $cat2 = $meta['cat2'];
        $tabBarHtml = <<<HTML
      <div class="sd-tab-bar">
        <button type="button" class="sd-tab-btn active" data-filter="all">All Deliverables & Scope</button>
        <button type="button" class="sd-tab-btn" data-filter="cat1">{$cat1}</button>
        <button type="button" class="sd-tab-btn" data-filter="cat2">{$cat2}</button>
      </div>
HTML;
        // Inject right before the first deliverables-grid
        $content = preg_replace('/(<div class="[^"]*deliverables-grid[^"]*">)/i', $tabBarHtml . "\n$1", $content, 1);
    }

    // Add dark callout banner under the first comparison grid if not present
    if (strpos($content, 'sd-dark-callout') === false && strpos($content, 'comparison-grid-2col') !== false) {
        $darkCalloutHtml = <<<HTML
        <div class="sd-dark-callout">
          <p class="sd-dark-callout-text">💡 <strong>Architectural Approach:</strong> Every sprint is engineered for measurable commercial impact, positive unit economics, and senior-level direct accountability.</p>
          <a href="/contact" class="sd-dark-callout-cta">Inquire About Scope →</a>
        </div>
HTML;
        $content = preg_replace('/(<\/div>\s*<!-- End Comparison Grid -->|<\/div>[\s\n]*<\/section>)/i', "$darkCalloutHtml\n$1", $content, 1);
    }

    file_put_contents($filePath, $content);
    echo "Refactored: " . $filename . "\n";
}

// Also update service-best-marketing-consultant.html
$bmcPath = __DIR__ . '/../service-best-marketing-consultant.html';
if (file_exists($bmcPath)) {
    $bmcC = file_get_contents($bmcPath);
    // Link service-detail.css
    if (strpos($bmcC, 'css/service-detail.css') === false) {
        $bmcC = str_replace('</head>', "  <link rel=\"stylesheet\" href=\"css/service-detail.css\">\n</head>", $bmcC);
    }
    // Add rs-fluid-4cm to sections
    $bmcC = preg_replace('/<section class="([^"]*)"/i', '<section class="$1 rs-fluid-4cm"', $bmcC);
    file_put_contents($bmcPath, $bmcC);
    echo "Refactored: service-best-marketing-consultant.html\n";
}

echo "All service pages refactored successfully.\n";
