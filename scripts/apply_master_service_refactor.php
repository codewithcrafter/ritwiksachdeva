<?php
// apply_master_service_refactor.php

$canonicalPopupHtml = file_get_contents(__DIR__ . '/../consult-popup.html');

$servicesConfig = [
    'service-graphic-designer.html' => [
        'slug' => 'graphic-designer',
        'badge' => 'CREATIVE DIRECTION & BRANDING',
        'cat1' => 'Brand Identity Systems',
        'cat2' => 'Marketing & Production Collateral',
        'tools' => ['Adobe Illustrator', 'Figma', 'Adobe Photoshop', 'InDesign', 'Print CMYK Pre-Flight', 'Vector Architecture']
    ],
    'service-performance-marketing.html' => [
        'slug' => 'performance-marketing',
        'badge' => 'PAID MEDIA & ATTRIBUTION ARCHITECTURE',
        'cat1' => 'Demand Generation & Acquisition',
        'cat2' => 'Attribution, CAPI & Unit Economics',
        'tools' => ['Meta Ads Manager', 'Google Ads (Search/PMax)', 'LinkedIn Ads', 'GA4 Server-Side', 'Meta CAPI', 'Looker Studio']
    ],
    'service-seo-expert.html' => [
        'slug' => 'seo-expert',
        'badge' => 'TECHNICAL SEARCH ENGINE OPTIMIZATION',
        'cat1' => 'Technical Auditing & Core Web Vitals',
        'cat2' => 'Keyword Authority & Programmatic Search',
        'tools' => ['Google Search Console', 'Ahrefs', 'SEMrush', 'Screaming Frog', 'Schema.org JSON-LD', 'PageSpeed Insights']
    ],
    'service-ecommerce-management.html' => [
        'slug' => 'ecommerce-management',
        'badge' => 'MARKETPLACE & D2C STORE OPERATIONS',
        'cat1' => 'Marketplaces (Amazon & Flipkart)',
        'cat2' => 'Shopify Architecture & Quick-Commerce',
        'tools' => ['Amazon Seller Central', 'Flipkart Seller Hub', 'Shopify Plus', 'Helium 10', 'Blinkit / Zepto Ops', 'Shiprocket Fulfillment']
    ],
    'service-ppc-expert.html' => [
        'slug' => 'ppc-expert',
        'badge' => 'GOOGLE ADS & HIGH INTENT SEARCH',
        'cat1' => 'High-Intent Search & Shopping',
        'cat2' => 'Performance Max & YouTube Campaigns',
        'tools' => ['Google Ads Editor', 'Keyword Planner', 'Smart Bidding Algorithms', 'Google Tag Manager', 'Looker Studio Reporting', 'Negative KW Architecture']
    ],
    'service-product-shoot.html' => [
        'slug' => 'product-shoot',
        'badge' => 'COMMERCIAL PRODUCT PHOTOGRAPHY',
        'cat1' => 'Marketplace White-Background Shoots',
        'cat2' => 'Creative Lifestyle & 360 Spin Captures',
        'tools' => ['Sony FX Cinema Gear', 'Studio Strobes (Profoto)', 'Capture One Pro', 'ColorChecker Passport', 'Photoshop Retouching', 'Amazon Compliance Specs']
    ],
    'service-smo-services.html' => [
        'slug' => 'smo-services',
        'badge' => 'SOCIAL MEDIA OPTIMIZATION & ORGANIC REACH',
        'cat1' => 'Algorithmic Profile Engineering',
        'cat2' => 'Hashtag Clusters & Retention Funnels',
        'tools' => ['Instagram Algorithm Frameworks', 'LinkedIn Creator Tools', 'YouTube Studio SEO', 'Bio Funnel Architecture', 'Buffer / Sprout', 'Engagement Hook Engines']
    ],
    'service-social-media-marketing.html' => [
        'slug' => 'social-media-marketing',
        'badge' => 'FULL-FUNNEL SOCIAL BRANDING & ADS',
        'cat1' => 'Organic Narrative Architecture',
        'cat2' => 'Paid Social Amplification & Retargeting',
        'tools' => ['Meta Advantage+ Campaigns', 'TikTok / Reels Formats', 'Creator Seeding', 'Dynamic Creative Testing', 'ManyChat Automation', 'UGC Director Frameworks']
    ],
    'service-video-editing.html' => [
        'slug' => 'video-editing',
        'badge' => 'HIGH-RETENTION VIDEO PRODUCTION',
        'cat1' => 'Short-Form Reels, TikToks & Shorts',
        'cat2' => 'Long-Form YouTube & Commercial Ads',
        'tools' => ['Adobe Premiere Pro', 'After Effects', 'DaVinci Resolve Studio', 'Dynamic Subtitling / Captions', 'Sound Design (48kHz)', 'Kinetic Hook Sequencing']
    ],
    'service-website-designer.html' => [
        'slug' => 'website-designer',
        'badge' => 'HIGH-CONVERSION WEB ARCHITECTURE',
        'cat1' => 'Custom Hand-Coded Architecture',
        'cat2' => 'Mobile UX & Speed Engineering',
        'tools' => ['Semantic HTML5 / Clean CSS3', 'Vanilla JavaScript (Zero Bloat)', 'PHP 8.3 Backend', 'Core Web Vitals Optimization', 'SVG Vector Assets', 'Figma to Code']
    ],
];

$waSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';

foreach ($servicesConfig as $filename => $config) {
    exec("git show HEAD:$filename", $out);
    $html = implode("\n", $out);
    $out = [];

    // Parse with DOMDocument
    $dom = new DOMDocument();
    @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);

    $slug = $config['slug'];
    $badge = $config['badge'];
    $cat1 = $config['cat1'];
    $cat2 = $config['cat2'];
    $tools = $config['tools'];

    // 1. Title & Meta
    $titleNode = $xpath->query('//title')->item(0);
    $titleText = $titleNode ? trim($titleNode->textContent) : "Ritwik Sachdeva";
    $titleText = str_replace([',50 Cr+', 'Delhi  Ritwik', 'WhatTs the Difference', 'What—Ts the Difference', "\xEF\xBF\xBD"], ['₹50 Cr+', 'Delhi — Ritwik', "What's the Difference", "What's the Difference", '—'], $titleText);

    $metaDescNode = $xpath->query('//meta[@name="description"]/@content')->item(0);
    $metaDesc = $metaDescNode ? trim($metaDescNode->nodeValue) : "";

    // 2. Canonical URL
    $canonicalUrl = "https://www.ritwiksachdeva.in/services/{$slug}";

    // 3. Schema JSON-LD
    $schemaNodes = $xpath->query('//script[@type="application/ld+json"]');
    $schemaHtml = '';
    foreach ($schemaNodes as $sn) {
        $schemaText = trim($sn->textContent);
        $schemaText = str_replace([
            "https://www.ritwiksachdeva.in/services/{$slug}/",
            "https://www.ritwiksachdeva.in/services{$slug}",
            ",50 Cr+",
            "\xEF\xBF\xBD"
        ], [
            "https://www.ritwiksachdeva.in/services/{$slug}",
            "https://www.ritwiksachdeva.in/services/{$slug}",
            "₹50 Cr+",
            "—"
        ], $schemaText);
        $schemaHtml .= "  <script type=\"application/ld+json\">\n" . $schemaText . "\n  </script>\n";
    }

    // 4. Hero Content: H1, Lead, Stats
    $h1Node = $xpath->query('//h1')->item(0);
    $h1Text = $h1Node ? trim($h1Node->textContent) : "";
    $h1Text = str_replace([',50 Cr+', 'Delhi  Ritwik', 'WhatTs the Difference', 'What—Ts the Difference', "\xEF\xBF\xBD"], ['₹50 Cr+', 'Delhi — Ritwik', "What's the Difference", "What's the Difference", '—'], $h1Text);

    $leadNode = $xpath->query('//*[contains(@class, "service-detail-lead")]')->item(0);
    $leadText = $leadNode ? trim($leadNode->textContent) : "";
    $leadText = str_replace([',50 Cr+', 'revenue  not', "\xEF\xBF\xBD"], ['₹50 Cr+', 'revenue — not', '—'], $leadText);

    // Stats
    $statBlocks = $xpath->query('//*[contains(@class, "stat-item-block")]');
    $statsHtml = '';
    foreach ($statBlocks as $sb) {
        $v = $xpath->query('.//*[contains(@class, "stat-item-val")]', $sb)->item(0);
        $l = $xpath->query('.//*[contains(@class, "stat-item-lbl")]', $sb)->item(0);
        $val = $v ? trim($v->textContent) : '';
        $lbl = $l ? trim($l->textContent) : '';
        if ($val === ',50 Cr+') $val = '₹50 Cr+';
        if ($val === ',15 Cr+') $val = '₹15 Cr+';
        if ($val === ',1.94') $val = '₹1.94';
        if ($val && $lbl) {
            $statsHtml .= "            <div class=\"sd-kpi-card\">\n              <div class=\"sd-kpi-val\">{$val}</div>\n              <div class=\"sd-kpi-lbl\">{$lbl}</div>\n            </div>\n";
        }
    }

    // 5. Practice Comparison Section
    $compCards = $xpath->query('//*[contains(@class, "comparison-card") or contains(@class, "comparison-box")]');
    $comparisonHtml = '';
    if ($compCards->length >= 2) {
        $c0 = $compCards->item(0);
        $c1 = $compCards->item(1);

        $c0Tag = $xpath->query('.//*[contains(@class, "comparison-tag")]', $c0)->item(0);
        $c0Title = $xpath->query('.//*[contains(@class, "comparison-title")]', $c0)->item(0);
        $c0Desc = $xpath->query('.//*[contains(@class, "comparison-desc")]', $c0)->item(0);

        $c1Tag = $xpath->query('.//*[contains(@class, "comparison-tag")]', $c1)->item(0);
        $c1Title = $xpath->query('.//*[contains(@class, "comparison-title")]', $c1)->item(0);
        $c1Desc = $xpath->query('.//*[contains(@class, "comparison-desc")]', $c1)->item(0);

        $t0 = $c0Title ? trim($c0Title->textContent) : 'Standard Execution';
        $d0 = $c0Desc ? trim($c0Desc->textContent) : '';
        $tag0 = $c0Tag ? trim($c0Tag->textContent) : 'Tactical Model';

        $t1 = $c1Title ? trim($c1Title->textContent) : 'Strategic Architecture';
        $d1 = $c1Desc ? trim($c1Desc->textContent) : '';
        $tag1 = $c1Tag ? trim($c1Tag->textContent) : 'Consultant Model';

        $b0Html = '';
        foreach ($xpath->query('.//li', $c0) as $li) {
            $b0Html .= "<li class=\"sd-comp-item\"><span class=\"sd-comp-item-icon\">•</span>" . trim($li->textContent) . "</li>";
        }
        $b1Html = '';
        foreach ($xpath->query('.//li', $c1) as $li) {
            $b1Html .= "<li class=\"sd-comp-item\"><span class=\"sd-comp-item-icon\">✓</span>" . trim($li->textContent) . "</li>";
        }

        $comparisonHtml = <<<HTML
  <!-- PRACTICE COMPARISON SECTION (2-COLUMN SIDE-BY-SIDE + COMPACT DARK CALLOUT) -->
  <section class="sd-section rs-fluid-4cm">
    <div class="sd-section-header">
      <h2 class="sd-section-title">Execution vs. Strategic Architecture</h2>
      <p class="sd-section-sub">Why business founders partner with Ritwik Sachdeva instead of delegating to traditional generalist agencies.</p>
    </div>

    <div class="sd-comparison-grid">
      <!-- Standard Card -->
      <div class="sd-comp-card">
        <span class="sd-comp-badge">{$tag0}</span>
        <h3 class="sd-comp-title">{$t0}</h3>
        <p class="sd-comp-desc">{$d0}</p>
        <ul class="sd-comp-list">{$b0Html}</ul>
      </div>

      <!-- Strategic Card -->
      <div class="sd-comp-card strategic">
        <span class="sd-comp-badge">{$tag1}</span>
        <h3 class="sd-comp-title">{$t1}</h3>
        <p class="sd-comp-desc">{$d1}</p>
        <ul class="sd-comp-list">{$b1Html}</ul>
      </div>
    </div>

    <!-- Dark Callout Bar -->
    <div class="sd-dark-callout">
      <p class="sd-dark-callout-text">💡 <strong>Architectural Approach:</strong> Every sprint is engineered for measurable commercial impact, positive unit economics, and senior-level direct accountability.</p>
      <a href="/contact" class="sd-dark-callout-cta">Inquire About Scope →</a>
    </div>
  </section>
HTML;
    }

    // 6. Deliverables Section (Interactive Tabs + 4-Column Compact Grid)
    $delivCards = $xpath->query('//*[contains(@class, "deliverable-card")]');
    $delivCardsHtml = '';
    $dCount = 1;
    $totalDelivs = $delivCards->length;
    $half = ceil($totalDelivs / 2);

    foreach ($delivCards as $idx => $dc) {
        $dtNode = $xpath->query('.//*[contains(@class, "deliverable-title")]', $dc)->item(0);
        $ddNode = $xpath->query('.//*[contains(@class, "deliverable-desc")]', $dc)->item(0);

        $dt = $dtNode ? trim($dtNode->textContent) : '';
        $dd = $ddNode ? trim($ddNode->textContent) : '';
        if (!$dt) continue;

        if (stripos($dt, 'in Delhi') !== false && ($idx >= $totalDelivs - 3)) {
            continue;
        }

        $num = sprintf("%02d", $dCount++);
        $category = ($idx < $half) ? 'cat1' : 'cat2';

        $bulletsHtml = '';
        foreach ($xpath->query('.//li', $dc) as $li) {
            $bulletsHtml .= "<span class=\"sd-deliv-pill\">" . trim($li->textContent) . "</span>";
        }

        $delivCardsHtml .= <<<HTML
      <div class="sd-deliv-card" data-category="{$category}">
        <span class="sd-deliv-num">{$num}</span>
        <h3 class="sd-deliv-title">{$dt}</h3>
        <p class="sd-deliv-desc">{$dd}</p>
        <div class="sd-deliv-tags">
          {$bulletsHtml}
        </div>
      </div>
HTML;
    }

    $deliverablesSectionHtml = <<<HTML
  <!-- DELIVERABLES / SCOPE (INTERACTIVE TABS + 4-COLUMN COMPACT GRID) -->
  <section class="sd-section rs-fluid-4cm" id="deliverables">
    <div class="sd-section-header">
      <h2 class="sd-section-title">Deliverables & Strategic Scope</h2>
      <p class="sd-section-sub">Comprehensive capabilities structured into modular execution sprints and ongoing performance retainers.</p>
    </div>

    <div class="sd-tab-bar">
      <button type="button" class="sd-tab-btn active" data-filter="all">All Deliverables ({$dCount})</button>
      <button type="button" class="sd-tab-btn" data-filter="cat1">{$cat1}</button>
      <button type="button" class="sd-tab-btn" data-filter="cat2">{$cat2}</button>
    </div>

    <div class="sd-deliverables-grid">
{$delivCardsHtml}
    </div>
  </section>
HTML;

    // 7. Bento Grid: Methodology, Tools & Commercials (3-Column Grid)
    $toolsPillsHtml = '';
    foreach ($tools as $t) {
        $toolsPillsHtml .= "<span class=\"sd-tech-pill\">{$t}</span>\n";
    }

    $bentoSectionHtml = <<<HTML
  <!-- METHODOLOGY, TOOLS & COMMERCIALS (3-COLUMN BENTO GRID) -->
  <section class="sd-section sd-section-alt rs-fluid-4cm">
    <div class="sd-section-header">
      <h2 class="sd-section-title">Methodology, Technology & Engagement Models</h2>
      <p class="sd-section-sub">How projects are initiated, executed, and held accountable to rigorous commercial benchmarks.</p>
    </div>

    <div class="sd-bento-grid">
      <!-- Bento 1: Strategic Methodology -->
      <div class="sd-bento-card">
        <span class="sd-bento-eyebrow">Strategic Architecture</span>
        <h3 class="sd-bento-title">Methodology & Execution</h3>
        <p class="sd-bento-body">Every engagement begins with an exhaustive discovery audit—mapping unit economics, eliminating budget waste, and establishing high-converting positioning assets before capital deployment.</p>
        <div class="sd-pill-wrap">
          <span class="sd-tech-pill">Diagnostic Audit</span>
          <span class="sd-tech-pill">Funnel Mapping</span>
          <span class="sd-tech-pill">Rapid Testing Sprints</span>
        </div>
      </div>

      <!-- Bento 2: Technology & Tools -->
      <div class="sd-bento-card">
        <span class="sd-bento-eyebrow">Technical Craft</span>
        <h3 class="sd-bento-title">Tooling & Infrastructure</h3>
        <p class="sd-bento-body">Deploying modern, industry-standard toolstacks ensuring zero operational bottlenecks, clean tracking telemetry, and broadcast-grade production assets.</p>
        <div class="sd-pill-wrap">
          {$toolsPillsHtml}
        </div>
      </div>

      <!-- Bento 3: Commercials & Engagement Scope -->
      <div class="sd-bento-card">
        <span class="sd-bento-eyebrow">Engagement Models</span>
        <h3 class="sd-bento-title">Retainers & Advisory Sprints</h3>
        <p class="sd-bento-body">Transparent commercial terms structured as strategic monthly retainers, project-based design sprints, or fractional executive advisory—tailored to account maturity.</p>
        <div class="sd-pill-wrap">
          <span class="sd-tech-pill">Monthly Retainer</span>
          <span class="sd-tech-pill">Advisory Sprint</span>
          <span class="sd-tech-pill">Zero Long-Term Lock-In</span>
        </div>
      </div>
    </div>
  </section>
HTML;

    // 8. FAQ Section: 2-Column Compact Accordion Grid
    $faqItems = $xpath->query('//*[contains(@class, "faq-item")]');
    $faqCol1Html = '';
    $faqCol2Html = '';
    $fIdx = 0;
    $totalFaqs = $faqItems->length;
    $halfFaqs = ceil($totalFaqs / 2);

    foreach ($faqItems as $fi) {
        $qNode = $xpath->query('.//*[contains(@class, "faq-question") or contains(@class, "question")]', $fi)->item(0);
        $aNode = $xpath->query('.//*[contains(@class, "faq-answer") or contains(@class, "answer")]', $fi)->item(0);

        $q = $qNode ? trim($qNode->textContent) : '';
        $a = $aNode ? trim($aNode->textContent) : '';

        $q = str_replace([',50 Cr+', 'Delhi  Ritwik', "\xEF\xBF\xBD"], ['₹50 Cr+', 'Delhi — Ritwik', '—'], $q);
        $a = str_replace([',50 Cr+', ',50,000 to ,1,50,000+', ',1,50,000', ',50,000', "\xEF\xBF\xBD"], ['₹50 Cr+', '₹50,000 to ₹1,50,000+', '₹1,50,000', '₹50,000', '—'], $a);

        if (!$q || !$a) continue;

        $faqItemHtml = <<<HTML
        <div class="sd-faq-item">
          <button type="button" class="sd-faq-trigger">
            <span>{$q}</span>
            <span class="sd-faq-icon">+</span>
          </button>
          <div class="sd-faq-content">
            <p>{$a}</p>
          </div>
        </div>
HTML;

        if ($fIdx < $halfFaqs) {
            $faqCol1Html .= $faqItemHtml . "\n";
        } else {
            $faqCol2Html .= $faqItemHtml . "\n";
        }
        $fIdx++;
    }

    $faqsSectionHtml = <<<HTML
  <!-- FREQUENTLY ASKED QUESTIONS (2-COLUMN COMPACT ACCORDION GRID) -->
  <section class="sd-section rs-fluid-4cm" id="faqs">
    <div class="sd-section-header">
      <h2 class="sd-section-title">Frequently Asked Questions</h2>
      <p class="sd-section-sub">Direct, transparent answers regarding deliverables, turnaround times, and consulting engagement models.</p>
    </div>

    <div class="sd-faq-grid">
      <div class="sd-faq-column">
{$faqCol1Html}      </div>
      <div class="sd-faq-column">
{$faqCol2Html}      </div>
    </div>
  </section>
HTML;

    // 9. Explore Other Services Section
    $exploreServices = [
        ['title' => 'Performance Marketing Consultant', 'desc' => 'ROI-driven Meta & Google Ads scaling', 'url' => '/services/performance-marketing'],
        ['title' => 'SEO Expert & Technical Optimization', 'desc' => 'High-intent organic search authority', 'url' => '/services/seo-expert'],
        ['title' => 'E-Commerce Management', 'desc' => 'Amazon, Flipkart & Shopify store growth', 'url' => '/services/ecommerce-management'],
        ['title' => 'Freelance Graphic Designer', 'desc' => 'Logos, brand books & visual identity', 'url' => '/services/graphic-designer'],
        ['title' => 'Video Editing Services', 'desc' => 'High-retention Reels, Shorts & Ad creatives', 'url' => '/services/video-editing'],
        ['title' => 'Website Designer & Architect', 'desc' => 'Ultra-fast custom websites built for conversions', 'url' => '/services/website-designer'],
    ];

    $filteredExplore = [];
    foreach ($exploreServices as $es) {
        if ($es['url'] !== "/services/{$slug}") {
            $filteredExplore[] = $es;
            if (count($filteredExplore) === 3) break;
        }
    }

    $exploreCardsHtml = '';
    foreach ($filteredExplore as $fe) {
        $exploreCardsHtml .= <<<HTML
      <a href="{$fe['url']}" class="sd-related-card">
        <h3 class="sd-related-title">{$fe['title']}</h3>
        <p class="sd-related-desc">{$fe['desc']}</p>
        <span class="sd-related-arrow">Explore Service →</span>
      </a>
HTML;
    }

    $exploreSectionHtml = <<<HTML
  <!-- EXPLORE OTHER SERVICES -->
  <section class="sd-section sd-section-alt rs-fluid-4cm">
    <div class="sd-section-header">
      <h2 class="sd-section-title">Explore Complementary Growth Services</h2>
      <p class="sd-section-sub">Integrate multi-channel capabilities across creative production, paid media, and technical infrastructure.</p>
    </div>

    <div class="sd-related-grid">
{$exploreCardsHtml}
    </div>
  </section>
HTML;

    // 10. Construct Clean Complete HTML with Root-Relative Assets & Canonical Popup Markup
    $outputHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>{$titleText}</title>
  <meta name="title" content="{$titleText}">
  <meta name="description" content="{$metaDesc}">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{$canonicalUrl}">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{$canonicalUrl}">
  <meta property="og:title" content="{$titleText}">
  <meta property="og:description" content="{$metaDesc}">
  <meta property="og:image" content="/assets/images/blog-marketing-strategy.jpg">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{$titleText}">
  <meta name="twitter:description" content="{$metaDesc}">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%231D4ED8'/><text x='16' y='22' fill='%23D4F542' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">

  <!-- JSON-LD Structured Data -->
{$schemaHtml}
  <!-- Root-Relative Stylesheets -->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/services.css">
  <link rel="stylesheet" href="/css/service-detail.css?v=2.2">
  <link rel="stylesheet" href="/css/animations.css">
  <link rel="stylesheet" href="/css/responsive.css">
  <link rel="stylesheet" href="/consult-popup.css?v=2.2">
</head>

<body>
  <!-- Header / Nav (Docked Top Sticky) -->
  <header class="site-header" id="header">
    <div class="header-top-bar">
      <div class="container header-top-inner">
        <div class="header-top-left">
          <span class="top-status-indicator"></span>
          <span>Available for Q1/Q2 Strategic Advisory & Retainers</span>
        </div>
        <div class="header-top-right">
          <a href="tel:+919289626986" class="top-contact-link">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>+91 92896 26986</span>
          </a>
          <a href="mailto:Info@ritwiksachdeva.in" class="top-contact-link">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
              <polyline points="22,6 12,13 2,6"></polyline>
            </svg>
            <span>Info@ritwiksachdeva.in</span>
          </a>
        </div>
      </div>
    </div>

    <nav class="navbar" id="navbar" aria-label="Main navigation">
      <div class="container nav-container">
        <a href="/" class="brand-link" aria-label="Ritwik Sachdeva - Home">
          <div class="brand-monogram">RS</div>
          <div class="brand-text">
            <span class="brand-name">Ritwik Sachdeva</span>
            <span class="brand-sub">Growth & Marketing Consultant</span>
          </div>
        </a>

        <div class="nav-menu" id="nav-menu">
          <ul class="nav-links">
            <li><a href="/" class="nav-link">Home</a></li>
            <li><a href="/about" class="nav-link">About</a></li>
            <li><a href="/services" class="nav-link active">Services</a></li>
            <li><a href="/blog" class="nav-link">Blog</a></li>
            <li><a href="/contact" class="nav-link">Contact</a></li>
          </ul>
        </div>

        <div class="nav-actions">
          <button type="button" class="btn btn-primary btn-sm" onclick="if(window.consultPopup){window.consultPopup.open('Header CTA Button');}">
            Let's Talk
          </button>
        </div>
      </div>
    </nav>
  </header>

  <!-- 1. HERO SECTION (2-COLUMN SPLIT 7fr 5fr WITH INLINE FORM ABOVE-THE-FOLD) -->
  <main>
    <section class="sd-hero rs-fluid-4cm">
      <div class="sd-hero-grid">
        <!-- Left Column (7fr) -->
        <div class="sd-hero-left">
          <div class="sd-eyebrow">
            <span class="sd-eyebrow-dot"></span>
            <span>{$badge}</span>
          </div>
          <h1 class="sd-hero-title">{$h1Text}</h1>
          <p class="sd-hero-lead">{$leadText}</p>
          
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
{$statsHtml}          </div>
        </div>

        <!-- Right Column (5fr): Compact Above-The-Fold Consultation Form Card -->
        <div class="sd-hero-right">
          <div class="sd-hero-form-card">
            <span class="sd-form-badge">Priority Consultation</span>
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

    <!-- 2. PRACTICE COMPARISON SECTION -->
{$comparisonHtml}

    <!-- 3. DELIVERABLES / SCOPE SECTION (4-COLUMN COMPACT GRID) -->
{$deliverablesSectionHtml}

    <!-- 4. METHODOLOGY, TOOLS & COMMERCIALS (3-COLUMN BENTO GRID) -->
{$bentoSectionHtml}

    <!-- 5. FREQUENTLY ASKED QUESTIONS (2-COLUMN COMPACT ACCORDION GRID) -->
{$faqsSectionHtml}

    <!-- 6. EXPLORE OTHER GROWTH SERVICES -->
{$exploreSectionHtml}
  </main>

  <!-- Global 3-Part Footer (Clean 3-Column Horizontal Row on Desktop) -->
  <footer class="site-footer">
    <div class="container footer-container">
      <div class="footer-left">
        <span class="footer-tagline">Strategic Digital Marketing &amp; Scaling Consultant.</span>
      </div>
      <div class="footer-center">
        <div class="footer-legal-links">
          <a href="/privacy-policy" class="footer-link">Privacy Policy</a>
          <span class="footer-sep">•</span>
          <a href="/terms" class="footer-link">Terms of Engagement</a>
        </div>
        <div class="footer-credit">
          Designed by <a href="https://www.buzzspiremedia.com/" target="_blank" rel="noopener noreferrer" class="credit-link">Buzzspire Media Pvt Ltd</a>
        </div>
      </div>
      <div class="footer-right">
        <span class="copyright-text">© 2026 Ritwik Sachdeva. All rights reserved.</span>
      </div>
    </div>
  </footer>

  <!-- Floating WhatsApp & Call Buttons -->
  <div class="floating-actions-container" aria-label="Quick contact options">
    <a href="https://wa.me/919289626986" class="floating-btn floating-btn-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp with Ritwik Sachdeva">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.12.553 4.11 1.523 5.836l-1.616 5.908 6.06-1.59c1.664.908 3.568 1.42 5.597 1.42 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/>
      </svg>
    </a>
    <a href="tel:+919289626986" class="floating-btn floating-btn-phone" aria-label="Call Ritwik Sachdeva" title="Call Ritwik Sachdeva directly">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>
  </div>

  <!-- Canonical Consultation Modal (Hidden by Default until Activated) -->
{$canonicalPopupHtml}

  <!-- Root-Relative Scripts -->
  <script src="/js/animations.js" defer></script>
  <script src="/js/main.js" defer></script>
  <script src="/consult-popup.js?v=2.2"></script>
  <script src="/js/service-detail.js?v=2.2"></script>
</body>

</html>
HTML;

    file_put_contents(__DIR__ . '/../' . $filename, $outputHtml);
    echo "Compiled with root-relative paths & canonical popup: $filename\n";
}

// Update service-best-marketing-consultant.html
$bmcPath = __DIR__ . '/../service-best-marketing-consultant.html';
if (file_exists($bmcPath)) {
    $bmcC = file_get_contents($bmcPath);
    // Ensure base href
    if (strpos($bmcC, '<base href="/">') === false) {
        $bmcC = str_replace('<head>', "<head>\n  <base href=\"/\">", $bmcC);
    }
    // Update asset paths to root-relative
    $bmcC = str_replace('href="css/', 'href="/css/', $bmcC);
    $bmcC = str_replace('href="consult-popup.css"', 'href="/consult-popup.css?v=2.2"', $bmcC);
    $bmcC = str_replace('src="js/', 'src="/js/', $bmcC);
    $bmcC = str_replace('src="consult-popup.js"', 'src="/consult-popup.js?v=2.2"', $bmcC);
    file_put_contents($bmcPath, $bmcC);
    echo "Updated service-best-marketing-consultant.html with root-relative paths.\n";
}

echo "All service pages updated with root-relative assets and canonical popup!\n";
