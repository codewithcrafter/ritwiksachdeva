<?php
/**
 * GENERATE ALL 11 INDIVIDUAL SERVICE PAGES
 * Aligned with real content, headings and meta from www.ritwiksachdeva.in
 * Luxury Light Editorial Design System for Ritwik Sachdeva
 */

$scraped = json_decode(file_get_contents(__DIR__ . '/scraped_services.json'), true);

// Exact 11 services configuration in the user's requested order
$services = [
    'ecommerce' => [
        'file' => 'service-ecommerce-management.html',
        'menu_num' => '01',
        'menu_title' => 'E-Commerce Management',
        'menu_desc' => 'Amazon, Flipkart & Shopify Growth',
        'badge' => 'Marketplace Operations & Scaling',
        'h1' => 'E-Commerce Management Services in Delhi — Amazon, Flipkart & Shopify',
        'meta_title' => 'E-Commerce Management Services in Delhi | Amazon & Flipkart Expert — Ritwik Sachdeva',
        'meta_desc' => 'E-commerce management services in Delhi for Amazon, Flipkart & Shopify sellers. Ritwik Sachdeva scales sales, optimizes Buy Box, and cuts RTO/DTO. Book a free consultation!',
        'subtitle' => 'End-to-end marketplace management, sponsored ads, Buy Box optimization, and catalog operations engineered to scale revenue without operational chaos.',
        'stats' => [
            ['val' => '4.2x', 'label' => 'Avg. Catalog ROAS'],
            ['val' => '99.4%', 'label' => 'Buy Box Win Rate'],
            ['val' => '35%', 'label' => 'Lower RTO / DTO Rates'],
            ['val' => '100+', 'label' => 'Brand Catalogs Managed']
        ],
        'problem_title' => 'Why Most E-Commerce Brands Struggle to Scale on Marketplaces',
        'problem_lead' => 'Selling on Amazon, Flipkart, and Shopify seems straightforward until inventory mismatches, creeping ad costs, falling Buy Box shares, and high return rates eat your margins.',
        'problem_points' => [
            'Ad campaigns burn cash driving clicks to poorly cataloged or low-converting listings.',
            'Buy Box losses to unauthorized resellers or delayed fulfillment crush daily sales volume.',
            'Uncoordinated inventory across Amazon FBA, Flipkart Smart, and Quick Commerce leads to stockouts or costly dead-stock penalties.',
            'High Return-to-Origin (RTO) and damaged transit orders silently drain contribution margins.'
        ],
        'solution_lead' => 'Ritwik Sachdeva treats marketplace management as a unified commercial engine — connecting cataloging, sponsored ads, inventory forecasting, and dispute resolution for sustainable profit.',
        'deliverables' => [
            [
                'title' => 'Amazon & Flipkart Account Management',
                'desc' => 'Full-lifecycle account stewardship covering listing hygiene, category approvals, brand registry, FBA shipment planning, and day-to-day seller support handling.'
            ],
            [
                'title' => 'PPC & Sponsored Products Mastery',
                'desc' => 'High-ROAS sponsored products, sponsored brands, and display campaigns with negative keyword pruning and dayparting to prevent ad spend waste.'
            ],
            [
                'title' => 'Buy Box & Featured Offer Optimization',
                'desc' => 'Algorithmic pricing and fulfillment calibration to win and defend the Buy Box against competing sellers while safeguarding profit margins.'
            ],
            [
                'title' => 'A+ Content & Enhanced Brand Content (EBC)',
                'desc' => 'Visually engaging rich media modules, comparison charts, and persuasive brand storytelling that lift listing conversion rates by up to 25%.'
            ],
            [
                'title' => 'Cataloging, SKU Mapping & Parent-Child Variations',
                'desc' => 'Flawless flat-file uploads, attribute optimization, search term backend indexing, and structured variation architecture that captures multi-size and multi-color shoppers.'
            ],
            [
                'title' => 'Account Reinstatement & Policy Compliance (POA)',
                'desc' => 'Urgent dispute resolution, root-cause Plan of Action (POA) drafting for suspended listings, and ongoing health audit compliance.'
            ],
            [
                'title' => 'Quick Commerce & Multi-Channel Sync',
                'desc' => 'Unified catalog and inventory management across Amazon, Flipkart, Blinkit, Zepto, and Shopify to prevent stockouts and price arbitrage.'
            ],
            [
                'title' => 'RTO / DTO Reduction & Margin Protection',
                'desc' => 'Rigorous address verification, customer communication triggers, and courier performance tracking to bring down cash-on-delivery returns.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'What platforms do your e-commerce management services cover?',
                'a' => 'We manage Amazon India & Global (Seller Central & Vendor Central), Flipkart (Seller Hub & Smart-FA), Shopify D2C stores, Meesho, Myntra, and Quick Commerce integrations like Blinkit and Zepto.'
            ],
            [
                'q' => 'How do you help win the Amazon Buy Box?',
                'a' => 'We systematically address the key algorithmic drivers: pricing competitiveness, fulfillment method (prioritizing FBA / Prime), shipping times, defect rates, and stock availability to ensure you win and maintain the Buy Box.'
            ],
            [
                'q' => 'Can you help reinstate a suspended Amazon or Flipkart listing?',
                'a' => 'Yes. We conduct forensic root-cause analysis, identify the exact policy breach or flagged metric, and draft a structured, evidence-backed Plan of Action (POA) that addresses seller performance criteria directly.'
            ],
            [
                'q' => 'How does e-commerce management reduce RTO (Return to Origin)?',
                'a' => 'We implement automated COD verification flows, analyze return trends by PIN code and SKU, improve packaging guidelines, and partner with reliable logistics partners to cut non-delivery rates significantly.'
            ]
        ]
    ],

    'graphic_design' => [
        'file' => 'service-graphic-designer.html',
        'menu_num' => '02',
        'menu_title' => 'Graphic Designer',
        'menu_desc' => 'Brand Identity, Logos & Visual Assets',
        'badge' => 'Creative Direction & Brand Identity',
        'h1' => 'Freelance Graphic Designer & Branding Design Consultant in Delhi',
        'meta_title' => 'Freelance Graphic Designer in Delhi | Brand Identity & Ad Creatives — Ritwik Sachdeva',
        'meta_desc' => 'Hire a freelance graphic designer in Delhi for logo design, brand identity & social media creatives. Ritwik Sachdeva creates visuals that elevate brands. Book a consultation!',
        'subtitle' => 'Strategic visual identity, performance ad creatives, packaging design, and brand systems that command attention and drive conversions.',
        'stats' => [
            ['val' => '300+', 'label' => 'Brand Identities Designed'],
            ['val' => '100%', 'label' => 'Vector & Print-Ready Files'],
            ['val' => '48h', 'label' => 'Rapid Concept Turnaround'],
            ['val' => '4.9/5', 'label' => 'Client Review Rating']
        ],
        'problem_title' => 'Graphic Designer vs. Branding Design Consultant: What is the Difference?',
        'problem_lead' => 'A basic graphic designer executes individual tasks. A branding design consultant engineers a coherent visual language that communicates authority, builds trust, and makes your company unforgettable.',
        'problem_points' => [
            'Inconsistent visual branding confuses customers and erodes brand trust across touchpoints.',
            'Generic templates and stock graphics blend into competitor noise without telling a distinct story.',
            'Ad creatives designed without marketing psychology fail to stop scrolling feeds or convert clicks.',
            'Poorly structured print and packaging files cause expensive manufacturing defects and delays.'
        ],
        'solution_lead' => 'Ritwik Sachdeva bridges the gap between high aesthetics and commercial performance — creating visual assets that not only look prestigious but directly support business growth.',
        'deliverables' => [
            [
                'title' => 'Logo Design & Visual Identity Systems',
                'desc' => 'Distinctive, memorable brand marks with full color variants, clear-space guidelines, typography hierarchy, and adaptive responsive formats.'
            ],
            [
                'title' => 'Comprehensive Brand Style Guide & Brand Book',
                'desc' => 'A definitive master brand manual covering color systems, typography pairings, imagery rules, graphic motifs, and application do\'s and don\'ts.'
            ],
            [
                'title' => 'High-Conversion Performance Ad Creatives',
                'desc' => 'Direct-response static, carousel, and motion graphic ads built with tested visual hooks and persuasive typography for Meta and Google Ads.'
            ],
            [
                'title' => 'Packaging & Label Architecture',
                'desc' => 'Market-ready packaging designs, die-lines, ingredient layout compliance, and premium print finishes (foil stamping, embossing, spot UV).'
            ],
            [
                'title' => 'Investor Pitch Decks & Corporate Collateral',
                'desc' => 'Polished pitch decks, annual reports, business cards, letterheads, and presentation templates that impress investors and enterprise prospects.'
            ],
            [
                'title' => 'Social Media Brand Kits & Post Templates',
                'desc' => 'Figma and Illustrator template suites for Instagram, LinkedIn, and YouTube that empower internal teams to produce on-brand content quickly.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'What is the typical turnaround time for a complete brand identity project?',
                'a' => 'A complete brand identity (logo, color system, typography, and brand guide) typically takes 2 to 3 weeks, including moodboarding, concept exploration, and revision rounds.'
            ],
            [
                'q' => 'Do you provide editable source files upon project completion?',
                'a' => 'Yes, absolutely. You receive complete ownership of all production-ready vector assets (AI, EPS, SVG, PDF) alongside high-resolution web formats (PNG, JPG, WebP) and font documentation.'
            ],
            [
                'q' => 'Can you design ad creatives tailored for specific ROAS goals on Meta and Google?',
                'a' => 'Yes. Creative strategy is directly paired with performance marketing data, applying proven hook architecture, contrast ratios, and clear calls to action that lower customer acquisition costs.'
            ],
            [
                'q' => 'Do you handle packaging die-lines and print coordination?',
                'a' => 'Yes. We prepare precise technical die-lines, CMYK color profiles, bleed margins, and spot-varnish layers, and coordinate directly with your printing vendors to ensure perfect output.'
            ]
        ]
    ],

    'performance_marketing' => [
        'file' => 'service-performance-marketing.html',
        'menu_num' => '03',
        'menu_title' => 'Performance Marketing Consultant in Delhi',
        'menu_desc' => 'Meta & Google Paid Media Scaling',
        'badge' => 'Paid Acquisition & Growth Consulting',
        'h1' => 'Performance Marketing Consultant & Agency in Delhi — Ritwik Sachdeva',
        'meta_title' => 'Performance Marketing Consultant in Delhi | Paid Ads & Media Buying — Ritwik Sachdeva',
        'meta_desc' => 'Hire a performance marketing consultant in Delhi for ROI-focused Google Ads & Meta Ads campaigns. Ritwik Sachdeva drives predictable, profitable acquisition. Book a call!',
        'subtitle' => 'Data-driven paid media execution across Meta, Google, and LinkedIn engineered around unit economics, contribution margins, and real revenue.',
        'stats' => [
            ['val' => '5.8x', 'label' => 'Peak Blended ROAS'],
            ['val' => '₹12 Cr+', 'label' => 'Ad Spend Managed'],
            ['val' => '100%', 'label' => 'Server-Side CAPI Setup'],
            ['val' => '-38%', 'label' => 'Customer Acquisition Cost']
        ],
        'problem_title' => 'What Performance Marketing Actually Means (And Why Most Campaigns Fail)',
        'problem_lead' => 'Too many agencies optimize for vanity metrics — impressions, clicks, and platform-reported ROAS that evaporates when matching bank deposits. True performance marketing is anchored in cash flow and unit economics.',
        'problem_points' => [
            'Relying on out-of-the-box browser pixels that miss 25-35% of iOS and Safari conversions.',
            'Ad fatigue sets in quickly because teams test button colors instead of fundamentally different creative angles.',
            'Scaling budgets causes CPA to double because account structure lacks algorithmic bidding headroom.',
            'Lack of post-click landing page optimization means expensive paid traffic drops off before buying.'
        ],
        'solution_lead' => 'Ritwik Sachdeva installs a resilient growth engine: server-side tracking, systematic creative testing, disciplined bidding architectures, and high-converting funnel design.',
        'deliverables' => [
            [
                'title' => 'Meta Ads Manager (Facebook & Instagram)',
                'desc' => 'Broad-audience scaling, Advantage+ shopping campaigns, dynamic catalog ads, and precision retargeting that maximize contribution margins.'
            ],
            [
                'title' => 'Google Ads (Search, Performance Max & YouTube)',
                'desc' => 'High-intent search capture, optimized PMax asset groups, YouTube action campaigns, and strict negative keyword hygiene.'
            ],
            [
                'title' => 'LinkedIn Campaign Manager for B2B',
                'desc' => 'Account-based marketing (ABM), matched audiences, lead generation forms, and thought-leadership ads targeting verified decision-makers.'
            ],
            [
                'title' => 'Server-Side CAPI & First-Party Tracking',
                'desc' => 'Robust Meta Conversions API, Google Enhanced Conversions, and server-side GTM containers ensuring 95%+ event match quality.'
            ],
            [
                'title' => 'Rapid Creative Testing Frameworks',
                'desc' => 'Weekly iterative creative cycles testing distinct psychological angles, visual hooks, formats, and UGC frameworks to conquer ad fatigue.'
            ],
            [
                'title' => 'Contribution Margin & Blended MER Dashboards',
                'desc' => 'Transparent business intelligence reporting that measures Marketing Efficiency Ratio (MER), LTV/CAC, and cash-in-bank ROI.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'What ad budget is required to begin performance marketing consulting?',
                'a' => 'We typically work with brands deploying at least ₹75,000 to ₹10,00,000+ per month in ad spend, ensuring sufficient data density for statistical testing and algorithmic bidding.'
            ],
            [
                'q' => 'How do you combat signal loss from iOS 14+ and privacy updates?',
                'a' => 'We deploy custom server-side Google Tag Manager (sGTM) containers paired with Meta CAPI and Google Enhanced Conversions, restoring conversion signals and lifting attribution fidelity.'
            ],
            [
                'q' => 'What is the difference between platform ROAS and Blended MER?',
                'a' => 'Platform ROAS relies on modeled attribution inside Facebook or Google. Marketing Efficiency Ratio (MER) measures total company revenue divided by total ad spend, giving you the real financial truth.'
            ],
            [
                'q' => 'How frequently are new creative angles tested?',
                'a' => 'We deploy a weekly creative testing sprint, generating and testing 4 to 8 new creative variations across hooks, formats, and messaging pillars every week.'
            ]
        ]
    ],

    'ppc_expert' => [
        'file' => 'service-ppc-expert.html',
        'menu_num' => '04',
        'menu_title' => 'PPC Expert in Delhi',
        'menu_desc' => 'Google Ads, PMax & Shopping Campaigns',
        'badge' => 'Google Ads Specialist & ROAS Scaling',
        'h1' => 'PPC Expert in Delhi | Google Ads Consultant Delhi — Ritwik Sachdeva',
        'meta_title' => 'PPC Expert in Delhi | Google Ads Consultant — Ritwik Sachdeva',
        'meta_desc' => 'Hire a PPC expert in Delhi for Google Ads & Shopping campaigns focused on ROAS and scalable lead generation. Ritwik Sachdeva stops budget waste. Get a free consultation!',
        'subtitle' => 'High-intent search capture, Google Performance Max architecture, and aggressive negative keyword management designed to maximize pipeline value.',
        'stats' => [
            ['val' => '9.4/10', 'label' => 'Avg. Quality Score'],
            ['val' => '42%', 'label' => 'Lower Cost Per Click'],
            ['val' => 'Zero', 'label' => 'Wasted Search Spend'],
            ['val' => '₹25 Cr+', 'label' => 'Client Revenue Driven']
        ],
        'problem_title' => 'What a PPC / Google Ads Consultant Actually Does (vs. An Agency)',
        'problem_lead' => 'Most generic agencies turn on smart campaigns, add broad-match keywords, and let Google spend your budget on irrelevant search queries. A dedicated PPC consultant audits search term reports daily, eliminates waste, and optimizes for sales.',
        'problem_points' => [
            'Broad match keywords wasting up to 40% of ad spend on junk searches and informational queries.',
            'Performance Max campaigns bidding against your own branded search keywords, inflating perceived ROAS.',
            'Poor Quality Scores (under 6/10) that force you to pay double what competitors pay for the same ad slot.',
            'Disjointed conversion tracking that counts page visits instead of verified phone calls and purchases.'
        ],
        'solution_lead' => 'Ritwik Sachdeva implements high-precision Google Ads campaigns with exact keyword mapping, structured asset groups, and deep conversion value tracking.',
        'deliverables' => [
            [
                'title' => 'Google Search Campaign Precision',
                'desc' => 'Granular single-theme ad groups (STAGs), high-intent phrase and exact match bidding, and responsive search ads crafted for 15%+ click-through rates.'
            ],
            [
                'title' => 'Google Performance Max (PMax) Optimization',
                'desc' => 'Custom asset group segmentation, audience signals, first-party customer list ingestion, and brand exclusion scripts to prevent branded cannibalization.'
            ],
            [
                'title' => 'Google Shopping & Merchant Center Management',
                'desc' => 'Supplemental feed optimization, title tag keyword enrichment, custom labels for margin-based bidding, and error-free feed approvals.'
            ],
            [
                'title' => 'Aggressive Negative Keyword Management',
                'desc' => 'Weekly forensic search term audits and thousands of pre-built negative keyword exclusions preventing irrelevant and competitor traffic drain.'
            ],
            [
                'title' => 'Offline Conversion Tracking (OCT) & CRM Integration',
                'desc' => 'Passing Google Click IDs (GCLID / WBID) into HubSpot, Zoho, or Salesforce so bidding algorithms optimize for closed deals rather than spam forms.'
            ],
            [
                'title' => 'Landing Page Experience & Quality Score Engineering',
                'desc' => 'Aligning ad copy headline psychology with landing page messaging to achieve 9+ Quality Scores and drop cost-per-click significantly.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'How quickly can I expect results from a Google Ads campaign?',
                'a' => 'Search ads generate immediate targeted traffic from day one. Full algorithmic optimization, Quality Score improvements, and CPA stabilization typically occur within 2 to 4 weeks of continuous tuning.'
            ],
            [
                'q' => 'Why are my current Google Ads generating clicks but no leads or sales?',
                'a' => 'Common culprits include loose broad match keywords triggering irrelevant queries, lack of negative keyword lists, slow mobile page speed, or weak post-click value proposition.'
            ],
            [
                'q' => 'Do you take a percentage of ad spend or a flat consulting fee?',
                'a' => 'We offer transparent flat monthly consulting retainers or a hybrid base plus performance fee. This ensures our incentives align with lowering your ad spend and increasing your profit.'
            ],
            [
                'q' => 'Can you audit my existing Google Ads account before I commit?',
                'a' => 'Yes. We provide a comprehensive 40-point Google Ads audit reviewing account structure, search terms, Quality Scores, conversion accuracy, and wasted ad spend.'
            ]
        ]
    ],

    'product_shoot' => [
        'file' => 'service-product-shoot.html',
        'menu_num' => '05',
        'menu_title' => 'Product Shoot Services in Delhi',
        'menu_desc' => 'E-Commerce & High-Conversion Photography',
        'badge' => 'Commercial Photography & Studio Production',
        'h1' => 'Product Photography & Product Shoot Services in Delhi — Ritwik Sachdeva',
        'meta_title' => 'Product Shoot Services in Delhi | E-Commerce Photography — Ritwik Sachdeva',
        'meta_desc' => 'Product shoot services in Delhi for Amazon, Flipkart & Shopify sellers. Ritwik Sachdeva delivers marketplace-ready photos that boost conversion rates. Book a session!',
        'subtitle' => 'Marketplace-compliant white background photography, invisible ghost mannequin apparel shoots, flat lays, and lifestyle editorial visuals that sell.',
        'stats' => [
            ['val' => '10,000+', 'label' => 'Products Shot & Retouched'],
            ['val' => '100%', 'label' => 'Marketplace Compliant'],
            ['val' => '72h', 'label' => 'Turnaround Delivery'],
            ['val' => '+45%', 'label' => 'Avg. Click-Through Uplift']
        ],
        'problem_title' => 'Why Professional Product Shoots Are Your Highest-ROI Investment',
        'problem_lead' => 'Online shoppers cannot touch, feel, or try your product. Your photos are the sole proxy for product quality. Substandard lighting, color inaccuracies, and phone photos instantly kill buyer trust and trigger high return rates.',
        'problem_points' => [
            'Dark, blurry, or discolored images that look amateurish compared to marketplace market leaders.',
            'Listing rejections on Amazon and Flipkart due to non-compliant backgrounds, borders, or text watermarks.',
            'High return rates caused by color mismatch between the online photo and the physical delivered product.',
            'Lack of lifestyle and context imagery leaving shoppers uncertain about product scale, fit, and use.'
        ],
        'solution_lead' => 'Ritwik Sachdeva delivers studio-grade commercial photography calibrated specifically for e-commerce algorithms, visual clarity, and maximum conversion rates.',
        'deliverables' => [
            [
                'title' => 'Pure White Background E-Commerce Shots',
                'desc' => '100% RGB (255, 255, 255) pure white background images with natural or drop shadows, perfectly complying with Amazon and Flipkart main image guidelines.'
            ],
            [
                'title' => 'Ghost Mannequin / Invisible Neck-Joint Shoots',
                'desc' => '3D volumetric apparel photography for shirts, dresses, suits, and jackets that reveals internal linings and tailored garment structure.'
            ],
            [
                'title' => 'Flat Lay & Tabletop Styled Commercial Shoots',
                'desc' => 'Meticulously arranged overhead compositions with complementary props, textures, and color palettes ideal for skincare, jewelry, and accessories.'
            ],
            [
                'title' => 'Editorial & Lifestyle Model Shoots',
                'desc' => 'Professional on-location or studio model shoots that contextualize your product, demonstrate real-world fit, and evoke aspirational emotions.'
            ],
            [
                'title' => 'Infographic & Feature Callout Imagery',
                'desc' => 'Composite images highlighting dimensions, technical materials, waterproof ratings, and key product USPs for secondary listing slots and A+ content.'
            ],
            [
                'title' => 'High-End Retouching & Color Calibration',
                'desc' => 'Dust removal, scratch elimination, fabric wrinkle smoothing, accurate color grading, and high-resolution clipping paths.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'Where does the product shoot take place in Delhi NCR?',
                'a' => 'We operate fully equipped commercial photography studios in Delhi NCR with dedicated cycloramas, strobe lighting rigs, styling bays, and props. Products can be couriered directly to our facility.'
            ],
            [
                'q' => 'Are your images compliant with Amazon and Flipkart technical standards?',
                'a' => 'Yes, 100%. All images are formatted to marketplace specs: pure white (RGB 255), minimum 2000px on the longest side for smooth zoom functionality, sRGB color profile, and zero compression artifacts.'
            ],
            [
                'q' => 'Can you provide models, makeup artists, and stylists for apparel shoots?',
                'a' => 'Yes. We manage complete end-to-end production including model casting, professional hair and makeup (HMU), fashion styling, prop sourcing, and studio logistics.'
            ],
            [
                'q' => 'How long does post-production retouching take?',
                'a' => 'Standard edited and retouched photo batches are delivered within 48 to 72 hours following the shoot date via secure cloud download.'
            ]
        ]
    ],

    'seo_expert' => [
        'file' => 'service-seo-expert.html',
        'menu_num' => '06',
        'menu_title' => 'SEO Expert in Delhi',
        'menu_desc' => 'Technical, Local & Organic Search Growth',
        'badge' => 'Technical SEO & Organic Search Authority',
        'h1' => 'SEO Expert in Delhi — Technical, On-Page & Local SEO | Ritwik Sachdeva',
        'meta_title' => 'SEO Expert in Delhi | Technical SEO & Organic Growth — Ritwik Sachdeva',
        'meta_desc' => 'Hire an SEO expert in Delhi for technical SEO, local SEO & organic growth strategies. Ritwik Sachdeva delivers top rankings and sustainable traffic. Book a free consultation!',
        'subtitle' => 'Technical crawl architecture, topical authority topic clusters, and white-hat link acquisition built to generate compounding organic pipeline.',
        'stats' => [
            ['val' => '#1', 'label' => 'Rankings for High-Intent Terms'],
            ['val' => '3.8x', 'label' => 'Avg. Organic Traffic Surge'],
            ['val' => '98+', 'label' => 'Core Web Vitals Health Score'],
            ['val' => '100%', 'label' => 'White-Hat Google Compliance']
        ],
        'problem_title' => 'Why Most SEO Agency Retainers Fail to Generate Real Revenue',
        'problem_lead' => 'Generic agencies deliver monthly PDF reports full of vanity ranking keywords that have zero search intent and zero commercial value. Real modern SEO is an engineering and editorial discipline focused on pipeline.',
        'problem_points' => [
            'Bloated JavaScript, slow server responses, and poor Core Web Vitals that prevent Google from crawling and indexing key pages.',
            'Publishing thin, repetitive blog posts that trigger algorithmic helpful content penalties.',
            'Fragmented internal linking and keyword cannibalization that dilutes page authority.',
            'Spammy automated backlink schemes that risk manual Google penalties and domain blacklisting.'
        ],
        'solution_lead' => 'Ritwik Sachdeva implements an enterprise-grade SEO framework: technical infrastructure repair, topical cluster modeling, search intent mapping, and high-tier digital PR.',
        'deliverables' => [
            [
                'title' => 'Technical SEO & Deep Crawl Diagnostics',
                'desc' => 'Server log analysis, XML sitemap architecture, crawl budget optimization, canonical tag audits, and resolving rendering errors.'
            ],
            [
                'title' => 'Core Web Vitals & Speed Optimization',
                'desc' => 'Eliminating render-blocking resources, optimizing Largest Contentful Paint (LCP), Cumulative Layout Shift (CLS), and Interaction to Next Paint (INP).'
            ],
            [
                'title' => 'Topical Authority & Semantic Topic Clusters',
                'desc' => 'Building comprehensive content hubs with pillar-and-spoke internal link hierarchies that signal unquestionable niche expertise to Google.'
            ],
            [
                'title' => 'Local SEO & Google Business Profile (GMB) Domination',
                'desc' => 'Local citation building, review acquisition funnels, geo-targeted landing pages, and local map pack rank tracking across Delhi NCR.'
            ],
            [
                'title' => 'Structured Data & Schema.org Implementation',
                'desc' => 'JSON-LD schema for Services, FAQs, LocalBusiness, Breadcrumbs, and Articles to win rich snippets and AI overview citations.'
            ],
            [
                'title' => 'Editorial White-Hat Link Building & Digital PR',
                'desc' => 'High-authority editorial backlink acquisition from legitimate industry publications, founders, and media outlets through original research and expert commentary.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'How long does it take to see tangible ranking and revenue growth from SEO?',
                'a' => 'Technical fixes and local Google Business Profile improvements often show initial gains within 30 to 45 days. Substantial organic traffic surges and competitive keyword domination typically mature over 3 to 6 months.'
            ],
            [
                'q' => 'Do you guarantee #1 rankings on Google?',
                'a' => 'No reputable SEO professional guarantees a specific #1 rank because Google\'s algorithm updates continuously. However, we guarantee strict adherence to Google Search Essentials and a proven track record of dominating competitive SERPs.'
            ],
            [
                'q' => 'What is the role of Local SEO for Delhi-based businesses?',
                'a' => 'Local SEO ensures high-intent customers searching for services in Delhi NCR find your business in Google\'s 3-Pack Map results, generating phone calls, direct inquiries, and walk-in foot traffic.'
            ],
            [
                'q' => 'How do you handle Google\'s recent Helpful Content and AI Overview updates?',
                'a' => 'We focus exclusively on first-party insights, original expert data, author EEAT credentials, and deeply helpful answers that AI search summaries naturally cite as trusted primary sources.'
            ]
        ]
    ],

    'smo_services' => [
        'file' => 'service-smo-services.html',
        'menu_num' => '07',
        'menu_title' => 'SMO Services in Delhi',
        'menu_desc' => 'Social Media Optimization & Reach',
        'badge' => 'Profile Optimization & Organic Social Reach',
        'h1' => 'SMO Services in Delhi — Social Media Optimization Consultant | Ritwik Sachdeva',
        'meta_title' => 'SMO Services in Delhi | Social Media Optimization — Ritwik Sachdeva',
        'meta_desc' => 'SMO Services in Delhi — Ritwik Sachdeva optimizes your social profiles for better visibility, engagement & organic reach. Get a free consultation today!',
        'subtitle' => 'Turn your social media profiles into high-converting organic discovery engines with bio SEO, highlights architecture, and algorithmic search indexing.',
        'stats' => [
            ['val' => '4.5x', 'label' => 'Growth in Profile Visits'],
            ['val' => '60%+', 'label' => 'Bio-to-Website Conversion Boost'],
            ['val' => '100%', 'label' => 'Multi-Platform Brand Consistency'],
            ['val' => '120k+', 'label' => 'Organic Monthly Reach Generated']
        ],
        'problem_title' => 'What SMO Actually Means (And How It Differs From SMM)',
        'problem_lead' => 'Social Media Optimization (SMO) is the technical and structural foundation of your organic presence — making sure your profiles are indexed by search engines, appear in platform search results, and convert visitors into followers and leads.',
        'problem_points' => [
            'Unoptimized Instagram and LinkedIn bios that lack searchable keywords and clear value propositions.',
            'Profiles that get traffic but have dead-end links or confusing link-in-bio trees with zero tracking.',
            'Fragmented branding across platforms, where handles, colors, and messaging contradict each other.',
            'Ignoring in-app social search algorithms (Instagram SEO, TikTok search, LinkedIn search) where modern consumers look for solutions.'
        ],
        'solution_lead' => 'Ritwik Sachdeva optimizes every inch of your social real estate: search keywords, high-converting bio architecture, categorized highlight funnels, and search-indexed profile assets.',
        'deliverables' => [
            [
                'title' => 'Instagram Search & Profile Optimization',
                'desc' => 'Keyword-optimized display names, search-friendly bio copy, custom action buttons, and verified meta setup for maximum in-app discovery.'
            ],
            [
                'title' => 'LinkedIn Executive & Corporate Profile Architecture',
                'desc' => 'Transforming personal profiles and company pages into lead-generating landing pages with compelling banners, featured assets, and SEO-rich summaries.'
            ],
            [
                'title' => 'Story Highlights & Conversion Funnels',
                'desc' => 'Curating branded highlight covers and logical narrative pathways (About, Client Wins, Services, FAQs) that warm up new visitors on autopilot.'
            ],
            [
                'title' => 'YouTube Channel Optimization & Video Metadata',
                'desc' => 'Channel branding, trailer architecture, keyword-dense playlist taxonomy, video tags, chapters, and clickable card end-screens.'
            ],
            [
                'title' => 'Social Search Engine Optimization (Social SEO)',
                'desc' => 'Aligning captions, spoken video keywords, on-screen text, and hashtags with emerging social search behavior to capture organic discovery.'
            ],
            [
                'title' => 'Cross-Platform Link-in-Bio Funnel Systems',
                'desc' => 'Fast-loading, branded link destinations with UTM tracking parameters and direct WhatsApp/email triggers that capture intent immediately.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'How does SMO help my website\'s Google ranking?',
                'a' => 'Optimized social profiles rank on page one of Google for your brand name, build brand authority signals, drive direct referral traffic, and provide secondary discovery pathways that reinforce overall domain trust.'
            ],
            [
                'q' => 'What is the difference between SMO and SMM?',
                'a' => 'SMO focuses on optimizing profile structure, SEO searchability, and conversion mechanics of your channels. SMM covers active publishing schedules, campaign distribution, community management, and paid advertising.'
            ],
            [
                'q' => 'Can you optimize our founder\'s personal LinkedIn profile as well as company pages?',
                'a' => 'Yes. Personal executive branding on LinkedIn frequently generates 5x to 10x higher engagement and organic reach than company pages, making founder optimization a core priority.'
            ],
            [
                'q' => 'Do you optimize existing content or only setup new profiles?',
                'a' => 'We perform a full historical audit of your existing channels, revamp profiles, reorganize video playlists and highlights, update old descriptions, and establish clear posting guidelines.'
            ]
        ]
    ],

    'social_media_agency' => [
        'file' => 'service-social-media-marketing.html',
        'menu_num' => '08',
        'menu_title' => 'Social Media Marketing Agency in Delhi',
        'menu_desc' => 'Organic Engagement & Viral Campaigns',
        'badge' => 'Full-Funnel Social Growth & Advertising',
        'h1' => 'Social Media Marketing (SMM) Consultant & Agency in Delhi — Ritwik Sachdeva',
        'meta_title' => 'Social Media Marketing Agency in Delhi | SMM Consultant — Ritwik Sachdeva',
        'meta_desc' => 'Social Media Marketing Consultant in Delhi — Ritwik Sachdeva delivers performance-driven Meta Ads & organic content strategy. Book a free consultation today!',
        'subtitle' => 'High-impact editorial content, viral short-form video strategies, direct-response paid social ads, and active community cultivation that builds genuine brand equity.',
        'stats' => [
            ['val' => '15M+', 'label' => 'Organic & Paid Video Views'],
            ['val' => '4.6x', 'label' => 'Blended Meta Ads ROAS'],
            ['val' => '85%', 'label' => 'Average Engagement Uplift'],
            ['val' => '100%', 'label' => 'Turnkey Content & Production']
        ],
        'problem_title' => 'Social Media Management vs. Social Media Advertising: You Need Both',
        'problem_lead' => 'Posting pretty graphics without a paid distribution strategy leaves you trapped at the mercy of declining organic reach. Running paid ads without social proof makes acquisition expensive. Sustainable growth requires a coordinated two-pillar strategy.',
        'problem_points' => [
            'Posting low-effort quote cards and generic stock graphics that your audience ignores.',
            'Failing to produce short-form vertical video (Reels/Shorts), leaving millions of free organic algorithmic impressions on the table.',
            'No clear direct-response funnel to convert social followers into qualified sales pipeline.',
            'Ignoring comment sections and direct messages, losing high-intent warm buyer leads.'
        ],
        'solution_lead' => 'Ritwik Sachdeva combines culturally resonant organic content creation with ruthless direct-response advertising to build brands that capture market share.',
        'deliverables' => [
            [
                'title' => 'Strategic Editorial Content Calendars',
                'desc' => 'Data-backed content pillars designed around thought leadership, customer pain points, product demonstrations, and cultural storytelling.'
            ],
            [
                'title' => 'Short-Form Video Production (Reels & Shorts)',
                'desc' => 'Concept ideation, scripting, professional filming, dynamic kinetic captioning, and sound design tailored for maximum algorithm velocity.'
            ],
            [
                'title' => 'Targeted Paid Social Ad Campaigns (Meta & LinkedIn)',
                'desc' => 'Full-funnel campaign architecture: top-of-funnel brand awareness, middle-of-funnel consideration, and bottom-of-funnel retargeting with direct-response offers.'
            ],
            [
                'title' => 'Active Community Management & DM Lead Conversion',
                'desc' => 'Rapid response times for inbound comments and DMs, relationship nurturing, and structured appointment booking flows.'
            ],
            [
                'title' => 'Influencer Marketing & Creator Partnerships',
                'desc' => 'Vetting authentic niche creators, negotiating usage rights, managing creative briefs, and turning creator content into high-converting whitelist ad units.'
            ],
            [
                'title' => 'Monthly Social Analytics & ROI Attribution',
                'desc' => 'Comprehensive reporting on follower growth velocity, audience demographic shifts, engagement rates, and direct sales revenue generated.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'Which social media platforms should my business prioritize?',
                'a' => 'It depends on your business model. For B2C and D2C brands, Instagram, Meta Ads, and YouTube Shorts drive maximum revenue. For B2B companies, LinkedIn and YouTube deliver high-ticket enterprise contracts.'
            ],
            [
                'q' => 'How many posts per week do you recommend for healthy organic growth?',
                'a' => 'We recommend 3 to 5 high-quality, substantive posts per week (prioritizing 2 to 3 Reels/Shorts), rather than posting low-value filler every day. Quality and retention vastly outperform raw volume.'
            ],
            [
                'q' => 'Do you handle the entire video production from script to final edit?',
                'a' => 'Yes. We provide complete turnkey production: creative brainstorming, scriptwriting, hook testing, on-location or studio recording guidance, professional editing, and thumbnail design.'
            ],
            [
                'q' => 'Can you collaborate with our in-house marketing team?',
                'a' => 'Absolutely. We frequently operate as an external strategic powerhouse — steering creative direction, running paid campaigns, and mentoring internal marketing staff.'
            ]
        ]
    ],

    'video_editing' => [
        'file' => 'service-video-editing.html',
        'menu_num' => '09',
        'menu_title' => 'Video Editing Services in Delhi',
        'menu_desc' => 'Reels, Shorts, Video Ads & Longform',
        'badge' => 'Video Production & Post-Production Services',
        'h1' => 'Video Editing Services in Delhi | Freelance Video Editor & Reels Editor — Ritwik Sachdeva',
        'meta_title' => 'Video Editing Services in Delhi | Reels & Video Ads — Ritwik Sachdeva',
        'meta_desc' => 'Need freelance Video Editing Services in Delhi? Ritwik Sachdeva creates scroll-stopping Reels, YouTube videos & ad creatives. Get a free consultation today!',
        'subtitle' => 'High-retention editing, kinetic typography, pacing psychology, sound design, and color grading that transform raw footage into viral, revenue-generating assets.',
        'stats' => [
            ['val' => '2,500+', 'label' => 'Videos Produced & Delivered'],
            ['val' => '78%', 'label' => 'Avg. 3-Second Hook Retention'],
            ['val' => '4K', 'label' => 'Mastered Audio & Color Grading'],
            ['val' => '24-48h', 'label' => 'Fast Turnaround Velocity']
        ],
        'problem_title' => 'Why Pacing, Hooks, and Audio Psychology Dictate Video Success',
        'problem_lead' => 'The first 3 seconds of a video determine whether a viewer stops scrolling or swipes away. Boring intros, monotone delivery, poor audio, and lazy jump-cuts cause immediate viewer abandonment. High-performing video is built on retention psychology.',
        'problem_points' => [
            'Flat opening hooks that fail to trigger curiosity, tension, or immediate value.',
            'Monotonous visual pacing that causes viewer drop-off within the first 10 seconds.',
            'Uninspired captions that blend into the background instead of guiding viewer focus.',
            'Muddy, unbalanced audio and missing sound effects (SFX) that make videos feel amateur.'
        ],
        'solution_lead' => 'Ritwik Sachdeva crafts scroll-stopping video assets engineered for maximum watch-time, algorithmic recommendation, and direct conversion.',
        'deliverables' => [
            [
                'title' => 'Instagram Reels & YouTube Shorts Editing',
                'desc' => 'Dynamic fast-cut editing, zoom punches, visual B-roll inserts, animated sound effects, and kinetic subtitles styled for peak retention.'
            ],
            [
                'title' => 'Direct-Response Paid Video Ad Creatives (UGC & Mashups)',
                'desc' => 'Performance ad edits testing multiple opening hooks, problem-agitation segments, social proof overlays, and clear call-to-action cards.'
            ],
            [
                'title' => 'Podcast Video Editing & Viral Snippet Extraction',
                'desc' => 'Multi-camera podcast editing, intelligent speaker tracking, audio mastering, and extracting 5 to 10 viral vertical micro-clips per episode.'
            ],
            [
                'title' => 'Corporate Video & Brand Storytelling Films',
                'desc' => 'Polished company documentaries, founder brand stories, case study interview videos, and product showcase films with cinematic grading.'
            ],
            [
                'title' => 'Motion Graphics & Visual Effects (VFX)',
                'desc' => 'Custom 2D/3D motion graphics, infographic animations, UI screen mockups, and dynamic visual metaphors that explain complex concepts simply.'
            ],
            [
                'title' => 'Audio Mastering, Foley & Sound Design (SFX)',
                'desc' => 'Professional noise reduction, dialogue equalization, whoosh and pop sound design, and royalty-free cinematic music synchronization.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'What video editing software and tech stack do you use?',
                'a' => 'We work primarily in Adobe Premiere Pro, After Effects, and DaVinci Resolve Studio for advanced color grading and audio mastering.'
            ],
            [
                'q' => 'How do I transfer large raw video footage files to you?',
                'a' => 'You can upload raw files via Google Drive, Dropbox, WeTransfer, or Frame.io. We provide clear folder templates for structured footage organization.'
            ],
            [
                'q' => 'How many revisions are included with each video project?',
                'a' => 'Every video project includes 2 comprehensive rounds of revision to fine-tune pacing, graphics, music selection, and typography.'
            ],
            [
                'q' => 'Can you generate animated captions and subtitles for mobile viewers?',
                'a' => 'Yes. Since over 70% of social media users browse videos without sound, we design animated, highlighted kinetic captions that ensure 100% message retention.'
            ]
        ]
    ],

    'best_marketing_consultant' => [
        'file' => 'service-best-marketing-consultant.html',
        'menu_num' => '10',
        'menu_title' => 'best marketing consultant',
        'menu_desc' => 'Strategic Full-Funnel Business Consulting',
        'badge' => 'Strategic Business & Omnichannel Consulting',
        'h1' => 'The Best Digital Marketing Consultant in Delhi — Ritwik Sachdeva',
        'meta_title' => 'Best Digital Marketing Consultant in Delhi | Full-Funnel Growth — Ritwik Sachdeva',
        'meta_desc' => 'Looking for the best digital marketing consultant in Delhi? Ritwik Sachdeva delivers data-driven SEO, PPC & social media strategies. Book a free consultation!',
        'subtitle' => 'Senior strategic marketing consulting, commercial roadmaps, and full-funnel execution trusted by ambitious founders, SMEs, and enterprise leaders.',
        'stats' => [
            ['val' => '₹50 Cr+', 'label' => 'Client Revenue & Pipeline Driven'],
            ['val' => '8+ Yrs', 'label' => 'Marketing Consulting Leadership'],
            ['val' => '94%', 'label' => 'Long-Term Client Retention Rate'],
            ['val' => '1-on-1', 'label' => 'Direct Access to Ritwik Sachdeva']
        ],
        'problem_title' => 'Why Businesses Choose a Strategic Marketing Consultant Over Big Agencies',
        'problem_lead' => 'Large agencies pitch you with their senior partners, then delegate your account to junior trainees who follow cookie-cutter checklists. A dedicated senior consultant brings battle-tested commercial acumen, direct accountability, and holistic business strategy.',
        'problem_points' => [
            'Siloed agency departments where the SEO team never talks to the paid media team or web developer.',
            'Endless meetings and vanity slide decks with zero measurable impact on bottom-line company profit.',
            'Generic playbooks that fail to consider your unique unit economics, sales cycles, or industry competitors.',
            'High overhead markups that make agency retainers expensive with minimal return on investment.'
        ],
        'solution_lead' => 'Ritwik Sachdeva functions as your trusted growth advisor — orchestrating web design, search, paid media, and brand strategy into one synchronized commercial revenue engine.',
        'deliverables' => [
            [
                'title' => 'Full-Funnel Omnichannel Marketing Roadmaps',
                'desc' => 'Diagnosing commercial leaks, identifying highest-leverage growth channels, and architecting phased 90-day and 12-month execution playbooks.'
            ],
            [
                'title' => 'Performance Marketing & Capital Allocation Strategy',
                'desc' => 'Optimizing paid acquisition budgets across Google, Meta, and LinkedIn with strict payback period modeling and contribution margin tracking.'
            ],
            [
                'title' => 'Conversion Rate Optimization (CRO) & Funnel Architecture',
                'desc' => 'Auditing post-click conversion funnels, removing friction, and running quantitative A/B split tests that lift visitor-to-customer conversion rates.'
            ],
            [
                'title' => 'Brand Positioning & Category Storytelling',
                'desc' => 'Sharpening your value proposition so you escape commoditized price battles and establish clear, defensible authority in your marketplace.'
            ],
            [
                'title' => 'MarTech Stack Architecture & Data Attribution',
                'desc' => 'Integrating CRM, analytics (GA4), email automation (Klaviyo/HubSpot), and attribution systems into a single source of commercial truth.'
            ],
            [
                'title' => 'Fractional CMO Advisory & Internal Team Mentorship',
                'desc' => 'Providing high-level leadership for your internal marketing department, hiring key talent, and steering agency partners toward your commercial goals.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'What makes Ritwik Sachdeva Delhi’s best digital marketing consultant?',
                'a' => 'Ritwik combines hands-on technical execution (SEO, PPC, Web Architecture) with executive-level commercial strategy. You work directly with an experienced growth leader, not junior agency interns.'
            ],
            [
                'q' => 'What industries do you specialize in?',
                'a' => 'We work across B2B SaaS, Professional Services, E-Commerce & D2C Brands, Healthcare, Real Estate, and High-Growth Tech Startups across Delhi NCR and globally.'
            ],
            [
                'q' => 'How does the consulting engagement work?',
                'a' => 'Engagements begin with a comprehensive 360-degree commercial audit, followed by the presentation of a tailored strategic roadmap. Ongoing advisory operates on monthly retainers with structured weekly sprint reviews.'
            ],
            [
                'q' => 'Can you help hire and train our internal marketing team?',
                'a' => 'Yes. As part of our Fractional CMO advisory, we evaluate candidates, design competency assessments, and mentor internal hires to build an autonomous in-house growth engine.'
            ]
        ]
    ],

    'website_designer' => [
        'file' => 'service-website-designer.html',
        'menu_num' => '11',
        'menu_title' => 'Website Designer in Delhi',
        'menu_desc' => 'Custom Web Development & Shopify Stores',
        'badge' => 'High-Performance Web Design & Development',
        'h1' => 'Website Designer in Delhi | Custom Web Development Services — Ritwik Sachdeva',
        'meta_title' => 'Website Designer in Delhi | Custom Web Development — Ritwik Sachdeva',
        'meta_desc' => 'Looking for a website designer in Delhi? Ritwik Sachdeva builds fast, SEO-friendly websites that turn visitors into customers. Get a free consultation today!',
        'subtitle' => 'Bespoke web development, lightning-fast Core Web Vitals, conversion-focused UI/UX, and robust e-commerce platforms engineered to generate sales.',
        'stats' => [
            ['val' => '98+', 'label' => 'Google PageSpeed Score'],
            ['val' => '< 1.2s', 'label' => 'Initial Page Load Time'],
            ['val' => '100%', 'label' => 'Mobile & Tablet Responsive'],
            ['val' => '3x', 'label' => 'Higher Conversion vs. Templates']
        ],
        'problem_title' => 'What Good Web Design Actually Does for a Business',
        'problem_lead' => 'Your website is your company\'s digital storefront and most important salesperson. A slow, outdated, or confusing website leaks qualified prospects every single hour. High-performance web development turns casual traffic into committed buyers.',
        'problem_points' => [
            'Bloated page builders (Elementor/Divi) that take 5+ seconds to load, losing 50% of mobile visitors immediately.',
            'Generic stock themes that fail to communicate your unique value proposition or build brand prestige.',
            'Zero technical on-page SEO, missing schema markup, and broken mobile viewports that cripple Google indexing.',
            'Cluttered navigation and buried call-to-action buttons that confuse users and suppress inquiries.'
        ],
        'solution_lead' => 'Ritwik Sachdeva builds bespoke, clean-coded, lightning-fast digital experiences crafted with modern UI/UX design and conversion rate optimization built directly into every page.',
        'deliverables' => [
            [
                'title' => 'Custom Frontend Web Development (HTML5 / Modern CSS / Vanilla JS)',
                'desc' => 'Lightweight, ultra-fast custom code free from bloated frameworks, scoring 95+ on Google PageSpeed and loading instantly on mobile connections.'
            ],
            [
                'title' => 'WordPress Development & Custom Themes',
                'desc' => 'Clean, secure WordPress architectures with custom Gutenberg blocks, streamlined admin interfaces, and rock-solid security protocols.'
            ],
            [
                'title' => 'E-Commerce Development (Shopify & WooCommerce)',
                'desc' => 'High-converting online store design, frictionless one-page checkout flows, payment gateway integrations, and mobile-first product pages.'
            ],
            [
                'title' => 'Conversion-Focused UI/UX & Landing Page Design',
                'desc' => 'Wireframing, visual hierarchy modeling, interactive prototypes, and persuasive sales funnels calibrated for maximum conversion rate.'
            ],
            [
                'title' => 'Technical On-Page SEO & Schema Out-of-the-Box',
                'desc' => 'Semantic HTML5 structure, Open Graph tags, canonical URLs, XML sitemaps, and Schema.org structured data embedded at launch.'
            ],
            [
                'title' => 'Ongoing Maintenance, Speed Audits & Security Hardening',
                'desc' => 'Automated cloud backups, SSL certification, malware scanning, database optimization, and continuous uptime monitoring.'
            ]
        ],
        'faqs' => [
            [
                'q' => 'How long does it take to design and launch a custom website?',
                'a' => 'A standard custom 5 to 10-page business website typically takes 2 to 4 weeks from initial wireframes to production launch. Complex e-commerce stores take 4 to 6 weeks.'
            ],
            [
                'q' => 'Will I be able to edit text and add new content myself after launch?',
                'a' => 'Yes. Whether built on WordPress or equipped with a lightweight CMS, you will have an intuitive administrative dashboard where you can easily update content, images, and publish new blogs without touching code.'
            ],
            [
                'q' => 'Is the website optimized for mobile phones and search engines?',
                'a' => 'Yes, 100%. Every website is engineered mobile-first, tested across all screen resolutions, and includes complete on-page SEO, meta tags, and schema markup built in.'
            ],
            [
                'q' => 'Do you provide website hosting, domain setup, and ongoing maintenance?',
                'a' => 'Yes. We assist with domain configuration, high-speed hosting setup (Cloudflare, Hostinger, Siteground, AWS), SSL certificates, and ongoing maintenance retainers.'
            ]
        ]
    ]
];

// Helper to generate the exact 11-item desktop dropdown HTML
function render_desktop_dropdown($current_file) {
    global $services;
    $html = '<div class="nav-dropdown-menu" role="menu">' . "\n";
    $html .= '  <div class="nav-dropdown-header">' . "\n";
    $html .= '    <span class="dropdown-header-title">All Services &amp; Practices</span>' . "\n";
    $html .= '    <span class="dropdown-header-tag">11 Services</span>' . "\n";
    $html .= '  </div>' . "\n";
    $html .= '  <div class="nav-dropdown-list">' . "\n";

    foreach ($services as $key => $s) {
        $isActive = ($s['file'] === $current_file) ? ' active' : '';
        $html .= '    <a href="' . $s['file'] . '" class="nav-dropdown-item' . $isActive . '" role="menuitem">' . "\n";
        $html .= '      <span class="dropdown-item-num">' . $s['menu_num'] . '</span>' . "\n";
        $html .= '      <div class="dropdown-item-body">' . "\n";
        $html .= '        <div class="dropdown-item-title">' . htmlspecialchars($s['menu_title']) . '</div>' . "\n";
        $html .= '        <div class="dropdown-item-desc">' . htmlspecialchars($s['menu_desc']) . '</div>' . "\n";
        $html .= '      </div>' . "\n";
        $html .= '    </a>' . "\n";
    }

    $html .= '  </div>' . "\n";
    $html .= '  <div class="nav-dropdown-footer">' . "\n";
    $html .= '    <a href="services.html" class="dropdown-view-all">' . "\n";
    $html .= '      <span>View Comprehensive Services Catalog</span>' . "\n";
    $html .= '      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>' . "\n";
    $html .= '    </a>' . "\n";
    $html .= '  </div>' . "\n";
    $html .= '</div>';
    return $html;
}

// Helper to generate the exact 11-item mobile drawer submenu HTML
function render_mobile_submenu($current_file) {
    global $services;
    $html = '<div class="mobile-submenu">' . "\n";
    foreach ($services as $key => $s) {
        $isActive = ($s['file'] === $current_file) ? ' active' : '';
        $html .= '  <a href="' . $s['file'] . '" class="mobile-sublink' . $isActive . '">' . $s['menu_num'] . '. ' . htmlspecialchars($s['menu_title']) . '</a>' . "\n";
    }
    $html .= '</div>';
    return $html;
}

// Helper to generate footer links for services
function render_footer_services_list() {
    global $services;
    $html = '<ul class="footer-links">' . "\n";
    foreach ($services as $key => $s) {
        $html .= '  <li><a href="' . $s['file'] . '">' . htmlspecialchars($s['menu_title']) . '</a></li>' . "\n";
    }
    $html .= '</ul>';
    return $html;
}

// Build each service page
foreach ($services as $key => $s) {
    $curFile = $s['file'];
    $desktopDropdown = render_desktop_dropdown($curFile);
    $mobileSubmenu = render_mobile_submenu($curFile);
    $footerServices = render_footer_services_list();

    // Prepare JSON-LD schema
    $schemaJson = json_encode([
        "@context" => "https://schema.org",
        "@graph" => [
            [
                "@type" => "Service",
                "name" => $s['menu_title'],
                "serviceType" => $s['badge'],
                "provider" => [
                    "@type" => "Person",
                    "name" => "Ritwik Sachdeva",
                    "jobTitle" => "Strategic Digital Marketing Consultant",
                    "url" => "http://localhost:8000/about.html"
                ],
                "description" => $s['meta_desc'],
                "areaServed" => [
                    "@type" => "Place",
                    "name" => "Delhi NCR & Global"
                ]
            ],
            [
                "@type" => "BreadcrumbList",
                "itemListElement" => [
                    ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "http://localhost:8000/index.html"],
                    ["@type" => "ListItem", "position" => 2, "name" => "Services", "item" => "http://localhost:8000/services.html"],
                    ["@type" => "ListItem", "position" => 3, "name" => $s['menu_title'], "item" => "http://localhost:8000/{$curFile}"]
                ]
            ]
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // Build stats markup
    $statsHtml = '';
    foreach ($s['stats'] as $st) {
        $statsHtml .= '
        <div class="stat-item-block">
          <div class="stat-item-val">' . htmlspecialchars($st['val']) . '</div>
          <div class="stat-item-lbl">' . htmlspecialchars($st['label']) . '</div>
        </div>';
    }

    // Build problem points markup
    $problemHtml = '';
    foreach ($s['problem_points'] as $idx => $pt) {
        $num = sprintf("%02d", $idx + 1);
        $problemHtml .= '
        <div class="problem-card">
          <div class="problem-num">' . $num . '</div>
          <p class="problem-desc">' . htmlspecialchars($pt) . '</p>
        </div>';
    }

    // Build deliverables cards markup
    $delivHtml = '';
    foreach ($s['deliverables'] as $i => $d) {
        $num = sprintf("%02d", $i + 1);
        $delivHtml .= '
        <div class="deliverable-card">
          <div class="deliverable-header">
            <span class="deliverable-num">' . $num . '</span>
            <div class="deliverable-tag">Deliverable ' . $num . '</div>
          </div>
          <h3 class="deliverable-title">' . htmlspecialchars($d['title']) . '</h3>
          <p class="deliverable-text">' . htmlspecialchars($d['desc']) . '</p>
        </div>';
    }

    // Build FAQs markup
    $faqsHtml = '';
    foreach ($s['faqs'] as $fi => $f) {
        $isOpen = ($fi === 0) ? ' is-active' : '';
        $faqsHtml .= '
        <div class="faq-item' . $isOpen . '">
          <button class="faq-question" aria-expanded="' . ($fi === 0 ? 'true' : 'false') . '">
            <span>' . htmlspecialchars($f['q']) . '</span>
            <svg class="faq-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
          </button>
          <div class="faq-answer">
            <p>' . htmlspecialchars($f['a']) . '</p>
          </div>
        </div>';
    }

    // Other services for bottom related strip (take 3 other services)
    $otherServicesHtml = '';
    $cnt = 0;
    foreach ($services as $ok => $os) {
        if ($ok === $key) continue;
        if ($cnt >= 3) break;
        $cnt++;
        $otherServicesHtml .= '
        <a href="' . $os['file'] . '" class="related-practice-card">
          <div class="related-badge">' . htmlspecialchars($os['badge']) . '</div>
          <h3 class="related-title">' . htmlspecialchars($os['menu_title']) . '</h3>
          <p class="related-desc">' . htmlspecialchars($os['menu_desc']) . '</p>
          <span class="related-link">Explore Service &rarr;</span>
        </a>';
    }

    // Complete HTML template
    $pageHtml = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>{$s['meta_title']}</title>
  <meta name="title" content="{$s['meta_title']}">
  <meta name="description" content="{$s['meta_desc']}">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="http://localhost:8000/{$curFile}">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="http://localhost:8000/{$curFile}">
  <meta property="og:title" content="{$s['meta_title']}">
  <meta property="og:description" content="{$s['meta_desc']}">
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
{$schemaJson}
  </script>
</head>

<body>

  <!-- Reading Progress -->
  <div id="scroll-progress" role="progressbar" aria-label="Page reading progress"></div>

  <!-- Ambient Background Layer -->
  <div class="bg-ambient-layer" aria-hidden="true">
    <div class="ambient-glow-circle ambient-glow-1"></div>
    <div class="ambient-glow-circle ambient-glow-2"></div>
    <div class="grid-pattern-overlay"></div>
  </div>

  <!-- SITE HEADER / NAVBAR -->
  <header class="site-header" id="navbar">
    <div class="container nav-container">
      <a href="index.html" class="brand-logo" aria-label="Ritwik Sachdeva - Digital Marketing Consultant">
        <div class="brand-monogram">RS</div>
        <div class="brand-info">
          <span class="brand-name">Ritwik Sachdeva</span>
          <span class="brand-title">Marketing Consultant</span>
        </div>
      </a>

      <!-- Desktop Navigation with Dropdown -->
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

  <!-- Mobile Drawer Navigation -->
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

    <!-- HERO SECTION -->
    <section class="service-detail-hero">
      <div class="container">
        <!-- Breadcrumbs -->
        <nav class="service-breadcrumbs" aria-label="Breadcrumb">
          <a href="index.html">Home</a>
          <span class="sep">/</span>
          <a href="services.html">Services</a>
          <span class="sep">/</span>
          <span class="current">{$s['menu_title']}</span>
        </nav>

        <div class="service-detail-header-wrap">
          <div class="service-eyebrow-row">
            <span class="badge badge-accent">{$s['badge']}</span>
            <span class="badge badge-outline">Verified Growth Deliverables</span>
          </div>
          <h1 class="service-detail-title">{$s['h1']}</h1>
          <p class="service-detail-lead">{$s['subtitle']}</p>

          <div class="service-hero-actions">
            <a href="contact.html" class="btn btn-primary btn-lg btn-magnetic">
              Book Strategy Consultation
              <span class="btn-icon-right">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </span>
            </a>
            <a href="#deliverables" class="btn btn-secondary btn-lg">
              Explore Deliverables
              <span class="btn-icon-right">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </span>
            </a>
          </div>

          <!-- Key Metrics / Stats Highlight -->
          <div class="service-key-stats-row">
            {$statsHtml}
          </div>
        </div>
      </div>
    </section>

    <!-- PROBLEM & STRATEGIC CONTEXT SECTION -->
    <section class="problem-deep-section">
      <div class="container">
        <div class="section-header-compact">
          <span class="section-eyebrow">Strategic Diagnosis</span>
          <h2 class="section-title">{$s['problem_title']}</h2>
          <p class="section-subtitle">{$s['problem_lead']}</p>
        </div>

        <div class="problem-grid-2col">
          <div class="problem-cards-column">
            {$problemHtml}
          </div>

          <div class="solution-card-column">
            <div class="solution-highlight-box">
              <div class="solution-icon-wrap">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
              </div>
              <h3 class="solution-title">The Ritwik Sachdeva Methodology</h3>
              <p class="solution-desc">{$s['solution_lead']}</p>
              <ul class="solution-checklist">
                <li>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                  <span>100% data-backed decisions aligned with unit economics and profit margins</span>
                </li>
                <li>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                  <span>No junior agency delegate handoffs — direct senior consultant execution</span>
                </li>
                <li>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                  <span>Weekly sprint cycles with clear ROI attribution and financial dashboards</span>
                </li>
              </ul>
              <div style="margin-top: 24px;">
                <a href="contact.html" class="btn btn-primary btn-sm">Schedule Diagnostic Audit &rarr;</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CORE DELIVERABLES SECTION -->
    <section class="deliverables-deep-section" id="deliverables">
      <div class="container">
        <div class="section-header text-center">
          <span class="section-eyebrow">Comprehensive Scope</span>
          <h2 class="section-title">What the Engagement Covers</h2>
          <p class="section-subtitle">Every deliverable is crafted to remove bottlenecks, scale operational leverage, and deliver compounding business value.</p>
        </div>

        <div class="deliverables-grid-3col">
          {$delivHtml}
        </div>
      </div>
    </section>

    <!-- PROCESS & EXECUTION ROADMAP -->
    <section class="process-framework-section">
      <div class="container">
        <div class="section-header text-center">
          <span class="section-eyebrow">Execution Framework</span>
          <h2 class="section-title">From Diagnosis to Compounding Scale</h2>
          <p class="section-subtitle">A disciplined, phased methodology refined across hundreds of client deployments.</p>
        </div>

        <div class="process-timeline-grid">
          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">01</span>
              <span class="process-phase">Week 1–2</span>
            </div>
            <h3 class="process-step-title">Forensic Audit &amp; Baseline</h3>
            <p class="process-step-text">Comprehensive diagnostic of historical performance, account architecture, tracking fidelity, competitor positioning, and customer unit economics.</p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">02</span>
              <span class="process-phase">Week 2–3</span>
            </div>
            <h3 class="process-step-title">Architecture &amp; Foundation</h3>
            <p class="process-step-text">Rebuilding technical infrastructure, configuring first-party tracking, cleaning catalog feeds, eliminating ad waste, and establishing operational benchmarks.</p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">03</span>
              <span class="process-phase">Week 4–8</span>
            </div>
            <h3 class="process-step-title">Execution &amp; Sprints</h3>
            <p class="process-step-text">Aggressive deployment of new campaigns, creative testing frameworks, CRO iterations, and high-tempo optimizations to achieve initial target CPA/ROAS.</p>
          </div>

          <div class="process-step-card">
            <div class="process-step-header">
              <span class="process-num">04</span>
              <span class="process-phase">Month 2+</span>
            </div>
            <h3 class="process-step-title">Scale &amp; Moat Expansion</h3>
            <p class="process-step-text">Systematic budget scaling, cross-channel synchronization, audience expansion, and automated margin reporting for sustainable profitability.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQS SECTION -->
    <section class="faq-section">
      <div class="container" style="max-width: 860px;">
        <div class="section-header text-center">
          <span class="section-eyebrow">Frequently Answered Questions</span>
          <h2 class="section-title">Common Questions &amp; Direct Answers</h2>
          <p class="section-subtitle">Everything you need to know about partnering with Ritwik Sachdeva.</p>
        </div>

        <div class="faq-accordion-list">
          {$faqsHtml}
        </div>
      </div>
    </section>

    <!-- RELATED PRACTICES STRIP -->
    <section class="related-practices-section">
      <div class="container">
        <div class="section-header-compact">
          <span class="section-eyebrow">Complementary Practices</span>
          <h2 class="section-title">Other Specialized Services</h2>
        </div>

        <div class="related-practices-grid">
          {$otherServicesHtml}
        </div>
      </div>
    </section>

    <!-- CTA BANNER -->
    <section class="cta-banner-section" style="padding: 80px 0; background: var(--bg-primary); text-align: center;">
      <div class="container" style="max-width: 800px;">
        <div class="cta-card-luxury">
          <span class="badge badge-accent" style="margin-bottom: 16px;">Ready to Scale?</span>
          <h2 style="font-family: var(--font-heading); font-size: clamp(2rem, 3.5vw, 2.8rem); font-weight: 800; line-height: 1.15; margin-bottom: 16px; color: var(--text-primary);">
            Let's Build a Profitable Growth Engine for Your Business
          </h2>
          <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 32px; max-width: 620px; margin-left: auto; margin-right: auto;">
            Book a confidential 30-minute diagnostic session to review your existing strategy, identify leaks, and map an execution plan.
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
            <a href="services.html" class="btn btn-secondary btn-lg">
              Explore All 11 Services
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

    file_put_contents(__DIR__ . '/../' . $curFile, $pageHtml);
    echo "Generated: {$curFile} (" . strlen($pageHtml) . " bytes)\n";
}

echo "All 11 service pages generated successfully!\n";

