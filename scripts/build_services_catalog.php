<?php
/**
 * REBUILD SERVICES.HTML WITH ALL 11 VERIFIED SERVICES
 * Aligned with www.ritwiksachdeva.in offerings and luxury editorial design
 */

require_once __DIR__ . '/generate_all_services.php';

// Generate desktop dropdown with active class on services
$desktopDropdown = render_desktop_dropdown('services.html');
$mobileSubmenu = render_mobile_submenu('services.html');
$footerServices = render_footer_services_list();

// Quick-jump dropdown options
$quickJumpDeepDives = '';
$quickJumpAnchorLinks = '';
$subnavPills = '';

// Detailed 11 service cards data for services.html
$catalogData = [
    [
        'id' => 'ecommerce',
        'file' => 'service-ecommerce-management.html',
        'num' => '01',
        'tag' => 'MARKETPLACE OPERATIONS',
        'title' => 'E-Commerce Management Services',
        'subtitle' => 'Amazon, Flipkart, Shopify & Quick Commerce Scaling',
        'badge' => 'Operational Retainer',
        'desc' => 'End-to-end seller account management, inventory forecasting, Buy Box defense, and sponsored advertising across Amazon India, Flipkart, and Shopify.',
        'problem' => 'Account health flags, Buy Box loss to unauthorized resellers, uncoordinated stock leading to stockouts, and margin erosion from high Return-to-Origin (RTO).',
        'deliverables' => [
            'Amazon & Flipkart Full Account Stewardship',
            'PPC & Sponsored Products ROAS Optimization',
            'Buy Box / Featured Offer Algorithmic Defense',
            'A+ Content, Brand Registry & SKU Mapping',
            'FBA / Smart-FA Shipment & Inventory Planning',
            'RTO/DTO Reduction & Cash-on-Delivery Safeguards'
        ],
        'impact' => [
            'val' => '4.2x',
            'title' => 'Average Catalog ROAS',
            'desc' => 'Increased sales velocity while defending Buy Box share above 99% and cutting transit return rates by up to 35%.'
        ],
        'tools' => ['Amazon Seller Central', 'Flipkart Seller Hub', 'Shopify', 'Helium 10', 'Blinkit / Zepto']
    ],
    [
        'id' => 'graphic-design',
        'file' => 'service-graphic-designer.html',
        'num' => '02',
        'tag' => 'CREATIVE DIRECTION',
        'title' => 'Freelance Graphic Designer & Branding Consultant',
        'subtitle' => 'Logos, Brand Books, Packaging & Performance Ad Creatives',
        'badge' => 'Creative Sprint / Retainer',
        'desc' => 'Strategic visual identity design that turns abstract business concepts into unmistakable, prestigious brand assets that command attention and drive conversions.',
        'problem' => 'Inconsistent visual branding, amateur Canva templates that blend into noise, and ad creatives designed without buyer psychology that fail to stop social scrolling.',
        'deliverables' => [
            'Distinctive Logo & Vector Visual Identity System',
            'Comprehensive Corporate Brand Book & Style Guide',
            'High-Converting Meta & Google Ad Creative Suites',
            'Product Packaging, Box Die-lines & Label Architecture',
            'Investor Pitch Decks & Corporate Sales Collateral',
            'Figma / Illustrator Team Template Kits'
        ],
        'impact' => [
            'val' => '300+',
            'title' => 'Identities Created',
            'desc' => 'Production-ready vector assets that eliminate brand confusion and lift advertising click-through rates by over 40%.'
        ],
        'tools' => ['Adobe Illustrator', 'Figma', 'Adobe Photoshop', 'InDesign', 'Print CMYK Pre-flight']
    ],
    [
        'id' => 'performance-marketing',
        'file' => 'service-performance-marketing.html',
        'num' => '03',
        'tag' => 'PAID ACQUISITION',
        'title' => 'Performance Marketing Consultant in Delhi',
        'subtitle' => 'Data-Driven Meta, Google & LinkedIn Media Buying',
        'badge' => 'Growth Retainer',
        'desc' => 'Disciplined media buying anchored in contribution margins, server-side CAPI tracking, and weekly creative testing sprints that scale acquisition profitably.',
        'problem' => 'Vanity platform ROAS that evaporates when matching bank revenue, signal loss from iOS privacy updates, and ad fatigue that causes customer acquisition costs to spike.',
        'deliverables' => [
            'Meta Ads (Facebook & Instagram) Direct Response Scaling',
            'Google Ads (Search, Performance Max & YouTube)',
            'LinkedIn Campaign Manager for High-Ticket B2B',
            'Server-Side CAPI & First-Party sGTM Tracking Containers',
            'Weekly Creative Testing Sprints & Angle Diversification',
            'Contribution Margin & Blended MER Financial Reporting'
        ],
        'impact' => [
            'val' => '5.8x',
            'title' => 'Peak Blended ROAS',
            'desc' => ',12 Cr+ in profitably managed ad spend with verified attribution and 38% lower customer acquisition cost.'
        ],
        'tools' => ['Meta Ads Manager', 'Google Ads', 'LinkedIn Ads', 'sGTM / CAPI', 'Triple Whale / GA4']
    ],
    [
        'id' => 'ppc-expert',
        'file' => 'service-ppc-expert.html',
        'num' => '04',
        'tag' => 'GOOGLE ADS SPECIALIST',
        'title' => 'PPC Expert in Delhi | Google Ads Consultant',
        'subtitle' => 'High-Intent Search, Shopping Feeds & Zero Budget Waste',
        'badge' => 'Consulting Retainer',
        'desc' => 'Precision Google Ads management focused on exact high-intent keyword capture, Merchant Center feed optimization, and aggressive negative keyword hygiene.',
        'problem' => 'Agencies enabling loose broad-match keywords that burn 40% of ad spend on junk queries, while PMax bids against your own organic brand name.',
        'deliverables' => [
            'Single-Theme Ad Group (STAG) Search Campaigns',
            'Google Performance Max (PMax) Asset Optimization',
            'Google Shopping & Merchant Center Feed Management',
            'Aggressive Weekly Negative Keyword Pruning',
            'Offline Conversion Tracking (OCT) with CRM Integration',
            'Quality Score Engineering & Landing Page Alignment'
        ],
        'impact' => [
            'val' => '9.4/10',
            'title' => 'Average Quality Score',
            'desc' => 'Cutting cost-per-click by 42% while directing 100% of budget toward high-intent buyers with verified purchase intent.'
        ],
        'tools' => ['Google Ads', 'Google Merchant Center', 'HubSpot / Zoho CRM', 'Google Tag Manager']
    ],
    [
        'id' => 'product-shoot',
        'file' => 'service-product-shoot.html',
        'num' => '05',
        'tag' => 'COMMERCIAL PHOTOGRAPHY',
        'title' => 'Product Photography & Shoot Services in Delhi',
        'subtitle' => 'White Background, Ghost Mannequin, Flat Lays & Model Shoots',
        'badge' => 'Studio Production',
        'desc' => 'Studio-grade commercial product photography tailored to marketplace algorithms, Amazon/Flipkart compliance, and high-conversion visual storytelling.',
        'problem' => 'Listing rejections due to non-compliant photo specs, amateur lighting that looks cheap, and color mismatches that cause high customer return rates.',
        'deliverables' => [
            'RGB (255, 255, 255) Pure White E-Commerce Main Images',
            'Ghost Mannequin / Invisible Neck-Joint Apparel Photography',
            'Flat Lay & Tabletop Styled Commercial Compositions',
            'On-Location & Studio Fashion Model Shoots',
            'Feature Callout Infographics & A+ Content Layouts',
            'High-End Retouching, Shadow Creation & Color Grading'
        ],
        'impact' => [
            'val' => '+45%',
            'title' => 'Click-Through Uplift',
            'desc' => 'Over 10,000 marketplace-compliant products shot with 72-hour delivery turnaround in Delhi NCR.'
        ],
        'tools' => ['Profoto Strobes', 'Sony Alpha 4K / Medium Format', 'Capture One Pro', 'Adobe Photoshop']
    ],
    [
        'id' => 'seo-expert',
        'file' => 'service-seo-expert.html',
        'num' => '06',
        'tag' => 'ORGANIC AUTHORITY',
        'title' => 'SEO Expert in Delhi — Technical, On-Page & Local',
        'subtitle' => 'Topical Clusters, Core Web Vitals & Google Map Pack Domination',
        'badge' => 'Compounding Retainer',
        'desc' => 'Technical search architecture, semantic content modeling, and Google Business Profile optimization designed to build an unbeatable organic pipeline.',
        'problem' => 'Slow site speed failing Core Web Vitals, thin automated content getting hit by Google updates, and lack of local map pack visibility across Delhi NCR.',
        'deliverables' => [
            'Technical SEO, Crawl Budget & Indexability Repairs',
            'Core Web Vitals Speed & Page Experience Optimization',
            'Topical Authority Pillar-and-Spoke Content Clusters',
            'Local SEO & Google Business Profile (GMB) Domination',
            'JSON-LD Schema Markup (Service, FAQ, LocalBusiness)',
            'White-Hat Editorial Link Acquisition & Digital PR'
        ],
        'impact' => [
            'val' => '3.8x',
            'title' => 'Organic Traffic Growth',
            'desc' => '#1 rankings for high-intent commercial terms with 98+ Core Web Vitals health scores.'
        ],
        'tools' => ['Ahrefs', 'Screaming Frog SEO Spider', 'Google Search Console', 'Semrush', 'Schema Pro']
    ],
    [
        'id' => 'smo-services',
        'file' => 'service-smo-services.html',
        'num' => '07',
        'tag' => 'SOCIAL DISCOVERY',
        'title' => 'SMO Services in Delhi — Social Media Optimization',
        'subtitle' => 'Bio SEO, Highlights Architecture & Search Engine Discovery',
        'badge' => 'Profile Optimization',
        'desc' => 'Transforming static social profiles into active lead-generating assets through in-app search engine optimization, bio copywriting, and conversion funnels.',
        'problem' => 'Profiles that receive clicks but leak visitors because bios lack searchable keywords, link trees are broken, and highlights fail to explain what the business does.',
        'deliverables' => [
            'Instagram Profile, Name-Field & Bio SEO Calibration',
            'LinkedIn Executive & Company Page Optimization',
            'Branded Story Highlights Funnels (Story, Proof, Offer)',
            'YouTube Channel Art, Tags & Playlist Architecture',
            'Cross-Platform Social Search Keyword Indexing',
            'Fast-Loading Branded Link-in-Bio Destinations with UTMs'
        ],
        'impact' => [
            'val' => '4.5x',
            'title' => 'Profile Visits Growth',
            'desc' => '60%+ boost in bio clicks to website leads and unified multi-network brand consistency.'
        ],
        'tools' => ['Instagram Search SEO', 'LinkedIn Creator Studio', 'YouTube Studio', 'Bitly / UTM Builders']
    ],
    [
        'id' => 'social-media-marketing',
        'file' => 'service-social-media-marketing.html',
        'num' => '08',
        'tag' => 'SMM AGENCY',
        'title' => 'Social Media Marketing Agency in Delhi',
        'subtitle' => 'Reels, Paid Social Campaigns, Community & Viral Reach',
        'badge' => 'Full-Funnel Social',
        'desc' => 'Combining high-velocity organic short-form video production with aggressive direct-response paid advertising to build engaged, paying audiences.',
        'problem' => 'Declining organic reach from posting boring quote cards, zero video content strategy, and failure to convert social followers into qualified sales pipeline.',
        'deliverables' => [
            'Strategic Editorial Content Calendars & Creative Direction',
            'Turnkey Short-Form Video Production (Reels & Shorts)',
            'Full-Funnel Paid Social Campaigns (Meta, TikTok, LinkedIn)',
            'Active Community Engagement & Direct Message Lead Funnels',
            'Influencer Identification & Whitelisted Creator Ads',
            'Monthly Social Attribution & Revenue Tracking Dashboards'
        ],
        'impact' => [
            'val' => '15M+',
            'title' => 'Video Views Delivered',
            'desc' => '4.6x return on ad spend with an average 85% uplift in meaningful audience engagement.'
        ],
        'tools' => ['Meta Business Suite', 'CapCut Pro', 'Metricool', 'Sprout Social', 'Creator Studio']
    ],
    [
        'id' => 'video-editing',
        'file' => 'service-video-editing.html',
        'num' => '09',
        'tag' => 'POST-PRODUCTION',
        'title' => 'Video Editing Services in Delhi | Reels & Ads',
        'subtitle' => 'High-Retention Cuts, Kinetic Typography & Sound Design',
        'badge' => 'Creative Retainer',
        'desc' => 'Retention-focused video editing calibrated for the first 3 seconds — using zoom punches, kinetic typography, pacing psychology, and sound effects to stop scrolls.',
        'problem' => 'Monotonous footage pacing that loses 80% of viewers within 5 seconds, weak audio, and missing captions on platforms where 70% of users watch on mute.',
        'deliverables' => [
            'Instagram Reels, YouTube Shorts & TikTok Dynamic Cuts',
            'Direct-Response Paid Video Ad Creatives (UGC & Mashups)',
            'Multi-Cam Podcast Video Editing & Viral Clip Extraction',
            'Cinematic Corporate Documentaries & Founder Brand Films',
            '2D/3D Motion Graphics, Animated Callouts & Visual Effects',
            'Sound Design (SFX), Audio Equalization & 4K Color Grading'
        ],
        'impact' => [
            'val' => '78%',
            'title' => 'Hook Retention Rate',
            'desc' => 'Over 2,500 commercial videos edited with rapid 24 to 48-hour delivery cycles.'
        ],
        'tools' => ['Adobe Premiere Pro', 'After Effects', 'DaVinci Resolve Studio', 'Frame.io']
    ],
    [
        'id' => 'best-marketing-consultant',
        'file' => 'service-best-marketing-consultant.html',
        'num' => '10',
        'tag' => 'STRATEGIC ADVISORY',
        'title' => 'Delhi—Ts Best Digital Marketing Consultant',
        'subtitle' => 'Full-Funnel Commercial Roadmaps & Fractional CMO Advisory',
        'badge' => 'Executive Advisory',
        'desc' => 'Senior marketing consulting for ambitious founders and SMEs needing high-level commercial roadmaps, budget allocation, and unified omnichannel growth.',
        'problem' => 'Working with generic agencies where junior interns manage your account, SEO doesn—Tt talk to paid media, and nobody takes accountability for profit.',
        'deliverables' => [
            'Full-Funnel Omnichannel Commercial Marketing Roadmaps',
            'Cross-Channel Performance Marketing & Capital Allocation',
            'Conversion Rate Optimization (CRO) & Funnel Engineering',
            'Defensible Brand Positioning & Category Storytelling',
            'MarTech Stack Architecture (CRM, GA4, Server Tracking)',
            'Fractional CMO Leadership & In-House Team Mentorship'
        ],
        'impact' => [
            'val' => ',50 Cr+',
            'title' => 'Revenue & Pipeline Driven',
            'desc' => '8+ years of battle-tested marketing consulting with a 94% client retention rate.'
        ],
        'tools' => ['Strategic Planning', 'Financial Unit Economics', 'GA4 / BigQuery', 'Executive Reviews']
    ],
    [
        'id' => 'website-designer',
        'file' => 'service-website-designer.html',
        'num' => '11',
        'tag' => 'WEB DEVELOPMENT',
        'title' => 'Website Designer in Delhi | Custom Web Development',
        'subtitle' => 'Fast, Modern, SEO-Friendly HTML/CSS & WordPress Stores',
        'badge' => 'Custom Development',
        'desc' => 'Bespoke web development engineered for 95+ Google PageSpeed scores, mobile-first responsiveness, built-in SEO schema, and maximum conversion rates.',
        'problem' => 'Slow page builders (Elementor/Divi) loading in 5+ seconds, ugly templates that fail to inspire trust, and missing technical SEO that keeps you off Google.',
        'deliverables' => [
            'Custom Frontend Web Development (HTML5, Modern CSS, Vanilla JS)',
            'High-Performance WordPress Development & Custom Themes',
            'E-Commerce Store Development (Shopify & WooCommerce)',
            'Conversion-Focused UI/UX & Landing Page Funnel Design',
            'Built-In Technical On-Page SEO, Open Graph & Schema Markup',
            'Hosting Setup, SSL Hardening, Speed Optimization & Maintenance'
        ],
        'impact' => [
            'val' => '98+',
            'title' => 'Google PageSpeed Score',
            'desc' => 'Under 1.2-second load times that convert up to 3x more visitors into paying customers.'
        ],
        'tools' => ['HTML5 / CSS3 / Vanilla JS', 'WordPress Custom Blocks', 'Shopify Liquid', 'PHP / MySQL']
    ]
];

// Build cards HTML
$cardsHtml = '';
foreach ($catalogData as $c) {
    $delivListHtml = '';
    foreach ($c['deliverables'] as $d) {
        $delivListHtml .= '
        <li class="breakdown-list-item">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span>' . htmlspecialchars($d) . '</span>
        </li>';
    }

    $toolsHtml = '';
    foreach ($c['tools'] as $t) {
        $toolsHtml .= '<span class="tool-tag">' . htmlspecialchars($t) . '</span>';
    }

    $cardsHtml .= <<<HTML

        <!-- SERVICE CARD {$c['num']}: {$c['title']} -->
        <article class="service-premium-card reveal-on-scroll" id="{$c['id']}">
          <div class="service-card-top">
            <div>
              <span class="service-number-tag">SERVICE {$c['num']} / {$c['tag']}</span>
              <h3 class="service-heading">{$c['title']}</h3>
              <p style="font-size: 0.95rem; color: var(--accent-primary); font-weight: 600; margin-top: 4px;">{$c['subtitle']}</p>
            </div>
            <span class="badge-status">{$c['badge']}</span>
          </div>

          <p class="service-lead-desc">{$c['desc']}</p>

          <div class="service-breakdown-grid">
            <div>
              <div class="breakdown-col-header problem">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="8" x2="12" y2="12"></line>
                  <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Core Bottleneck Solved
              </div>
              <p class="breakdown-text">{$c['problem']}</p>
            </div>

            <div>
              <div class="breakdown-col-header deliverables">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Signature Deliverables
              </div>
              <ul class="breakdown-list">
                {$delivListHtml}
              </ul>
            </div>

            <div>
              <div class="breakdown-col-header roi">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="12" y1="1" x2="12" y2="23"></line>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                Commercial Impact
              </div>
              <div class="roi-metric-highlight">
                <span class="roi-number">{$c['impact']['val']}</span>
                <span class="roi-label">{$c['impact']['title']}</span>
              </div>
              <p class="breakdown-text">{$c['impact']['desc']}</p>
            </div>
          </div>

          <div class="service-card-bottom">
            <div class="service-tools-row">
              <span style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); margin-right: 4px;">Platform Stack:</span>
              {$toolsHtml}
            </div>
            <div style="display: flex; gap: 12px; align-items: center;">
              <a href="{$c['file']}" class="btn btn-primary btn-sm btn-magnetic">
                Explore Service Details &rarr;
              </a>
              <a href="contact.html" class="btn btn-secondary btn-sm">
                Inquire Now
              </a>
            </div>
          </div>
        </article>
HTML;

    // Subnav pills
    $subnavPills .= '<a href="#' . $c['id'] . '" class="subnav-pill">' . htmlspecialchars($c['title']) . '</a>' . "\n";

    // Quick-jump dropdown options
    $quickJumpDeepDives .= '<option value="' . $c['file'] . '">' . $c['num'] . '. ' . htmlspecialchars($c['title']) . ' &rarr;</option>' . "\n";
    $quickJumpAnchorLinks .= '<option value="#' . $c['id'] . '">Overview ' . $c['num'] . ': ' . htmlspecialchars($c['title']) . '</option>' . "\n";
}

$servicesFullHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Marketing Consulting &amp; Growth Services | Ritwik Sachdeva</title>
  <meta name="title" content="Marketing Consulting &amp; Growth Services | Ritwik Sachdeva">
  <meta name="description"
    content="Explore all 11 core consulting and execution services by Ritwik Sachdeva: E-Commerce Management, Graphic Design, Performance Marketing, PPC, Product Shoots, SEO, SMO, SMM, Video Editing, Consulting &amp; Web Design.">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="http://localhost:8000/services.html">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://localhost:8000/services.html">
  <meta property="og:title" content="Marketing Consulting &amp; Growth Services | Ritwik Sachdeva">
  <meta property="og:description"
    content="11 specialized services built to engineer predictable revenue, technical SEO moats, and high-converting creative assets.">
  <meta property="og:image" content="http://localhost:8000/assets/images/blog-marketing-strategy.jpg">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/services.css">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23C47B45'/><text x='16' y='22' fill='%23fff' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Person",
        "name": "Ritwik Sachdeva",
        "jobTitle": "Strategic Digital Marketing Consultant & Fractional CMO",
        "url": "http://localhost:8000/about.html"
      },
      {
        "@type": "Service",
        "name": "Digital Marketing Consulting & Full-Stack Growth Services",
        "provider": {
          "@type": "Person",
          "name": "Ritwik Sachdeva"
        },
        "description": "11 full-funnel digital marketing services: E-Commerce Management, Graphic Design, Performance Marketing, PPC, Product Shoots, SEO, SMO, SMM, Video Editing, Strategy & Web Design.",
        "areaServed": "Delhi NCR & Global"
      }
    ]
  }
  </script>
</head>

<body>

  <!-- Reading Progress -->
  <div id="scroll-progress" role="progressbar" aria-label="Page reading progress"></div>

  <!-- Ambient Light Background Overlay -->
  <div class="bg-ambient-layer" aria-hidden="true">
    <div class="ambient-glow-circle ambient-glow-1"></div>
    <div class="ambient-glow-circle ambient-glow-2"></div>
    <div class="grid-pattern-overlay"></div>
  </div>

  <!-- HEADER / NAVBAR -->
  <header class="site-header" id="navbar">
    <div class="container nav-container">
      <a href="index.html" class="brand-logo" aria-label="Ritwik Sachdeva - Digital Marketing Consultant">
        <div class="brand-monogram">RS</div>
        <div class="brand-info">
          <span class="brand-name">Ritwik Sachdeva</span>
          <span class="brand-title">Marketing Consultant</span>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="desktop-nav" aria-label="Primary Navigation">
        <ul class="nav-links">
          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item nav-item-has-dropdown">
            <a href="services.html" class="nav-link dropdown-toggle active" aria-expanded="false" aria-haspopup="true">
              Services
              <svg class="dropdown-arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </a>
            {$desktopDropdown}
          </li>
          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
        </ul>
        <div class="nav-actions">
          <a href="contact.html" class="btn btn-primary btn-sm btn-magnetic">
            Let's Talk
            <span class="btn-icon-right">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </span>
          </a>
        </div>
      </nav>

      <!-- Mobile Hamburger Toggle -->
      <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>
    </div>
  </header>

  <!-- Mobile Drawer -->
  <div class="mobile-drawer" id="mobile-drawer" aria-label="Mobile Navigation">
    <div class="mobile-links">
      <a href="index.html" class="mobile-link">Home</a>
      <a href="about.html" class="mobile-link">About</a>
      <div class="mobile-nav-item-dropdown">
        <div class="mobile-dropdown-header-row">
          <a href="services.html" class="mobile-link active">Services</a>
          <button class="mobile-submenu-btn" aria-label="Toggle Services submenu" aria-expanded="false">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>
        </div>
        {$mobileSubmenu}
      </div>
      <a href="blog.html" class="mobile-link">Blog</a>
      <a href="contact.html" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-drawer-footer">
      <a href="contact.html" class="btn btn-primary btn-lg" style="width: 100%;">
        Request Strategy Consultation
        <span class="btn-icon-right">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </span>
      </a>
      <p style="font-size: 0.85rem; color: var(--text-secondary); text-align: center; margin-top: 10px;">Direct:
        consult@ritwiksachdeva.com</p>
    </div>
  </div>

  <main id="main-content">

    <!-- SERVICES HERO -->
    <section class="services-hero">
      <div class="container">
        <div class="services-hero-content">
          <span class="badge badge-accent">Strategic Marketing Capabilities</span>
          <h1 class="services-title">Services Built for Scalable, Profitable Growth</h1>
          <p class="services-lead">
            Explore 11 specialized services engineered around commercial truth, unit economics, technical search moats, and high-impact visual creative direction.
          </p>
        </div>

        <!-- Metrics Strip -->
        <div class="services-metrics-strip">
          <div class="metric-strip-item">
            <div class="metric-strip-val">11</div>
            <div class="metric-strip-label">Specialized Services</div>
          </div>
          <div class="metric-strip-item">
            <div class="metric-strip-val">,50 Cr+</div>
            <div class="metric-strip-label">Pipeline Generated</div>
          </div>
          <div class="metric-strip-item">
            <div class="metric-strip-val">4.6x</div>
            <div class="metric-strip-label">Avg Blended ROAS</div>
          </div>
          <div class="metric-strip-item">
            <div class="metric-strip-val">94%</div>
            <div class="metric-strip-label">Client Retention</div>
          </div>
        </div>
      </div>
    </section>

    <!-- STICKY PRACTICE NAVIGATION BAR -->
    <nav class="services-subnav-sticky" aria-label="Practice Areas Quick Navigation">
      <div class="container">
        <div class="services-subnav-track">
          {$subnavPills}
          <a href="#growth-process" class="subnav-pill">Methodology</a>
          <a href="#engagement-models" class="subnav-pill">Engagement Models</a>
        </div>
      </div>
    </nav>

    <!-- MAIN SERVICES CATALOG -->
    <div class="container" style="padding-bottom: 80px;">

      <!-- QUICK PRACTICE SELECTOR DROPDOWN BAR -->
      <div class="services-quick-select-bar">
        <div class="quick-select-label-wrap">
          <div class="quick-select-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </div>
          <div>
            <div class="quick-select-title">Jump Directly to Any of the 11 Services</div>
            <div class="quick-select-subtitle">Select below to open dedicated service page or jump to section</div>
          </div>
        </div>

        <div class="quick-select-control-wrap">
          <select id="service-quick-dropdown" class="service-jump-select"
            onchange="if(this.value) window.location.href=this.value;" aria-label="Select Service">
            <option value="">-- Choose a Service / In-Depth Page --</option>
            <optgroup label="Dedicated Individual Service Pages (11 Deep Dives)">
              {$quickJumpDeepDives}
            </optgroup>
            <optgroup label="Jump to Card on This Catalog Page">
              {$quickJumpAnchorLinks}
              <option value="#growth-process">4-Phase Consulting Methodology</option>
              <option value="#engagement-models">Engagement Models &amp; Retainers</option>
            </optgroup>
          </select>
          <div class="quick-select-arrow">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </div>
        </div>
      </div>

      <!-- 11 SERVICES CARDS LIST -->
      <div class="services-catalog-wrap">
        {$cardsHtml}
      </div>

    </div>

    <!-- 4-PHASE CONSULTING METHODOLOGY -->
    <section class="section" id="growth-process" style="background: var(--bg-secondary); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
      <div class="container">
        <div class="section-header text-center">
          <span class="section-eyebrow">Operating Rhythm</span>
          <h2 class="section-title">The 4-Phase Growth Framework</h2>
          <p class="section-subtitle">
            Every engagement operates on a structured cadence that transitions your business from diagnosis to predictable scale.
          </p>
        </div>

        <div class="process-timeline-grid">
          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">01</span>
              <span class="process-phase">Weeks 1—2</span>
            </div>
            <h3 class="process-step-title">Forensic Audit &amp; Unit Economics</h3>
            <p class="process-step-text">
              We audit historical channel performance, pixel tracking fidelity, unit economics, competitor positioning, and customer lifetime value.
            </p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">02</span>
              <span class="process-phase">Weeks 2—3</span>
            </div>
            <h3 class="process-step-title">Architecture &amp; Quick Wins</h3>
            <p class="process-step-text">
              Fix tracking leaks (CAPI/sGTM), eliminate wasted keyword spend, deploy high-converting landing page variants, and calibrate bidding.
            </p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">03</span>
              <span class="process-phase">Weeks 4—8</span>
            </div>
            <h3 class="process-step-title">Execution &amp; Testing Sprints</h3>
            <p class="process-step-text">
              Run weekly creative testing sprints, scale winning paid campaigns, publish authoritative content hubs, and refine conversion funnels.
            </p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">04</span>
              <span class="process-phase">Month 2+</span>
            </div>
            <h3 class="process-step-title">Compounding Scale &amp; Moat</h3>
            <p class="process-step-text">
              Scale budgets while protecting contribution margins, establish organic search authority, and train internal teams for autonomy.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ENGAGEMENT MODELS SECTION -->
    <section class="section" id="engagement-models" style="background: var(--bg-primary);">
      <div class="container">
        <div class="section-header text-center">
          <span class="section-eyebrow">Partnership Structures</span>
          <h2 class="section-title">Transparent Engagement Models</h2>
          <p class="section-subtitle">
            No lock-in contracts or bloated agency overhead. Flexible structures aligned with your commercial growth objectives.
          </p>
        </div>

        <div class="matrix-card-wrap">
          <div class="matrix-card">
            <span class="badge badge-accent" style="align-self: flex-start; margin-bottom: 12px;">Strategic Advisory</span>
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; font-weight: 700; margin-bottom: 8px;">Fractional CMO / Advisory</h3>
            <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;">
              Executive guidance, 90-day commercial roadmaps, agency oversight, and bi-weekly strategic reviews.
            </p>
            <ul class="breakdown-list" style="margin-bottom: 24px;">
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Bi-weekly executive strategy reviews</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Internal team &amp; vendor accountability</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Direct WhatsApp / Slack access to Ritwik</span>
              </li>
            </ul>
            <a href="contact.html" class="btn btn-secondary btn-sm" style="margin-top: auto; text-align: center;">Inquire for Retainer</a>
          </div>

          <div class="matrix-card" style="border: 2px solid var(--accent-primary); box-shadow: 0 12px 32px rgba(196, 123, 69, 0.1);">
            <div style="position: absolute; top: -12px; right: 24px; background: var(--accent-primary); color: #fff; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; padding: 3px 10px; border-radius: var(--radius-full);">Most Popular</div>
            <span class="badge badge-accent" style="align-self: flex-start; margin-bottom: 12px;">Full Growth Engine</span>
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; font-weight: 700; margin-bottom: 8px;">End-to-End Growth Retainer</h3>
            <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;">
              Full-service execution across Paid Media, SEO, Creative Production, and Funnel CRO.
            </p>
            <ul class="breakdown-list" style="margin-bottom: 24px;">
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Complete paid media buying &amp; optimization</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Weekly creative testing (ads, video, copy)</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Full BI reporting on contribution margins</span>
              </li>
            </ul>
            <a href="contact.html" class="btn btn-primary btn-sm btn-magnetic" style="margin-top: auto; text-align: center;">Book Strategy Consultation</a>
          </div>

          <div class="matrix-card">
            <span class="badge badge-outline" style="align-self: flex-start; margin-bottom: 12px;">Project Sprint</span>
            <h3 style="font-family: var(--font-heading); font-size: 1.35rem; font-weight: 700; margin-bottom: 8px;">Fixed-Scope Project Sprint</h3>
            <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 20px;">
              Dedicated project sprints for Website Development, Brand Identity, Studio Product Shoots, or Technical SEO Audits.
            </p>
            <ul class="breakdown-list" style="margin-bottom: 24px;">
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Clear deliverable timeline (2—4 weeks)</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Production-ready vector/code assets</span>
              </li>
              <li class="breakdown-list-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Handoff training &amp; 30-day post-launch warranty</span>
              </li>
            </ul>
            <a href="contact.html" class="btn btn-secondary btn-sm" style="margin-top: auto; text-align: center;">Request Project Quote</a>
          </div>
        </div>
      </div>
    </section>

    <!-- STRATEGIC CTA -->
    <section class="cta-banner-section" style="padding: 80px 0; background: var(--bg-secondary); text-align: center;">
      <div class="container" style="max-width: 800px;">
        <div class="cta-card-luxury">
          <span class="badge badge-accent" style="margin-bottom: 16px;">Ready to Scale?</span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(2rem, 3.5vw, 2.8rem); font-weight: 800; line-height: 1.15; margin-bottom: 16px; color: var(--text-primary);">
            Let's Engineer Your Company's Growth Engine
          </h2>
          <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px; max-width: 620px; margin-left: auto; margin-right: auto;">
            Schedule a 30-minute diagnostic session to review your existing numbers, uncover bottlenecks, and map out a customized execution plan.
          </p>
          <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="contact.html" class="btn btn-primary btn-lg btn-magnetic">
              Book Free Strategy Session
              <span class="btn-icon-right">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </span>
            </a>
            <a href="about.html" class="btn btn-secondary btn-lg">
              About Ritwik Sachdeva
            </a>
          </div>
          <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 20px;">
            Direct Email: <a href="mailto:consult@ritwiksachdeva.com" style="color: var(--accent-primary); font-weight: 600;">consult@ritwiksachdeva.com</a> &bull; Delhi NCR &amp; Global
          </p>
        </div>
      </div>
    </section>

  </main>

  <!-- GLOBAL FOOTER -->
  <footer class="site-footer">
    <div class="container footer-container">
      <div class="footer-top">
        <div class="footer-brand">
          <a href="index.html" class="brand-logo" aria-label="Ritwik Sachdeva Home">
            <div class="brand-monogram">RS</div>
            <div class="brand-info">
              <span class="brand-name">Ritwik Sachdeva</span>
              <span class="brand-title">Marketing Consultant</span>
            </div>
          </a>
          <p class="footer-bio">
            Senior strategic digital marketing consultant and fractional CMO based in Delhi, helping ambitious brands scale profitably across search, paid media, and creative design.
          </p>
          <div class="footer-contact-info">
            <a href="mailto:consult@ritwiksachdeva.com" class="footer-contact-link">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              consult@ritwiksachdeva.com
            </a>
            <a href="tel:+919876543210" class="footer-contact-link">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              +91 98765 43210
            </a>
          </div>
        </div>

        <div class="footer-nav-col">
          <h4 class="footer-heading">Services</h4>
          {$footerServices}
        </div>

        <div class="footer-nav-col">
          <h4 class="footer-heading">Company</h4>
          <ul class="footer-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Ritwik</a></li>
            <li><a href="services.html">Services Catalog</a></li>
            <li><a href="blog.html">Blog &amp; Insights</a></li>
            <li><a href="contact.html">Contact &amp; Bookings</a></li>
            <li><a href="admin/login.php">Admin Portal</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <p class="footer-copyright">&copy; 2026 Ritwik Sachdeva. All rights reserved.</p>
        <div class="footer-legal-links">
          <a href="#">Privacy Policy</a>
          <span class="sep">&bull;</span>
          <a href="#">Terms of Engagement</a>
          <span class="sep">&bull;</span>
          <a href="sitemap.xml">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="js/main.js"></script>
  <script src="js/animations.js"></script>
</body>

</html>
HTML;

file_put_contents(__DIR__ . '/../services.html', $servicesFullHtml);
echo "services.html rebuilt successfully with all 11 services! (" . strlen($servicesFullHtml) . " bytes)\n";



