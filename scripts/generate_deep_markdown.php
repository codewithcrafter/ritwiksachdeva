<?php
// generate_deep_markdown.php

require_once __DIR__ . '/../includes/markdown.php';

function clean_text($text) {
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = str_replace(["\r\n", "\r"], "\n", $text);
    $text = str_replace(',50 Cr+', '₹50 Cr+', $text);
    $text = str_replace(',50,000', '₹50,000', $text);
    $text = str_replace(',1,50,000', '₹1,50,000', $text);
    $text = str_replace('Delhi  Ritwik', 'Delhi — Ritwik', $text);
    $text = str_replace('revenue  not', 'revenue — not', $text);
    $text = str_replace('Platform  Platform', 'Platform — Platform', $text);
    $text = str_replace('WhatTs the Difference', 'What’s the Difference', $text);
    $text = preg_replace('/[ \t]+/', ' ', $text);
    return trim($text);
}

function html_to_deep_markdown($html, $canonicalUrl, $pageTitle, $pageType = 'Page') {
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    // Load with UTF-8 hint
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);

    $md = "# {$pageTitle}\n\n";
    $md .= "- **Canonical URL:** {$canonicalUrl}\n";
    $md .= "- **Page Type:** {$pageType}\n\n";

    // 1. Meta Description / Hero Subtitle
    $metaDescNode = $xpath->query('//meta[@name="description"]/@content')->item(0);
    $metaDesc = $metaDescNode ? clean_text($metaDescNode->nodeValue) : '';
    if ($metaDesc) {
        $md .= "## Executive Summary\n\n{$metaDesc}\n\n";
    }

    // 2. Metrics / Key Highlights
    $statCards = $xpath->query('//*[contains(@class, "stat-item") or contains(@class, "metric-item") or contains(@class, "hp-stat") or contains(@class, "sp-stat")]');
    if ($statCards->length > 0) {
        $md .= "## Verified Performance Metrics\n\n";
        foreach ($statCards as $sc) {
            $valNode = $xpath->query('.//*[contains(@class, "number") or contains(@class, "value") or contains(@class, "digit") or contains(@class, "count")]', $sc)->item(0);
            $lblNode = $xpath->query('.//*[contains(@class, "label") or contains(@class, "desc") or contains(@class, "text")]', $sc)->item(0);
            $val = $valNode ? clean_text($valNode->textContent) : '';
            $lbl = $lblNode ? clean_text($lblNode->textContent) : '';
            if ($val && $lbl) {
                $md .= "- **{$val}:** {$lbl}\n";
            }
        }
        $md .= "\n";
    }

    // 3. Main Content Sections
    // Find all sections or article
    $sections = $xpath->query('//section | //article | //main');
    if ($sections->length > 0) {
        $md .= "## Detailed Core Sections & Service Architecture\n\n";
        foreach ($sections as $sec) {
            $secId = $sec->getAttribute('id');
            // Skip footer, nav, popup, announcement
            $class = $sec->getAttribute('class');
            if (strpos($class, 'footer') !== false || strpos($class, 'nav') !== false || strpos($class, 'popup') !== false || strpos($class, 'modal') !== false) {
                continue;
            }

            // Headings inside section
            $headings = $xpath->query('.//h2 | .//h3 | .//h4', $sec);
            foreach ($headings as $h) {
                $tag = strtolower($h->tagName);
                $hText = clean_text($h->textContent);
                if (empty($hText)) continue;
                if (stripos($hText, 'ready to') !== false || stripos($hText, 'frequently asked questions') !== false || stripos($hText, 'faqs') !== false) {
                    continue; // FAQs handled separately
                }

                $prefix = ($tag === 'h2') ? '### ' : (($tag === 'h3') ? '#### ' : '##### ');
                $md .= "{$prefix}{$hText}\n\n";

                // Sibling or adjacent paragraphs and lists
                $sibling = $h->nextSibling;
                $gatheredP = 0;
                while ($sibling && $gatheredP < 5) {
                    if ($sibling->nodeType === XML_ELEMENT_NODE) {
                        $sTag = strtolower($sibling->tagName);
                        if (in_array($sTag, ['h2', 'h3', 'h4'])) break;
                        if ($sTag === 'p') {
                            $pText = clean_text($sibling->textContent);
                            if ($pText && strlen($pText) > 10) {
                                $md .= "{$pText}\n\n";
                                $gatheredP++;
                            }
                        } elseif ($sTag === 'ul' || $sTag === 'ol') {
                            $lis = $xpath->query('.//li', $sibling);
                            foreach ($lis as $li) {
                                $liText = clean_text($li->textContent);
                                if ($liText) {
                                    $md .= "- {$liText}\n";
                                }
                            }
                            $md .= "\n";
                        }
                    }
                    $sibling = $sibling->nextSibling;
                }
            }
        }
    }

    // 4. Deliverables / Features Cards
    $cards = $xpath->query('//*[contains(@class, "deliverable") or contains(@class, "feature-card") or contains(@class, "service-card") or contains(@class, "capability-card")]');
    if ($cards->length > 0) {
        $md .= "## Scope of Deliverables & Strategic Capabilities\n\n";
        $cIndex = 1;
        foreach ($cards as $card) {
            $cTitleNode = $xpath->query('.//h3 | .//h4 | .//*[contains(@class, "title")]', $card)->item(0);
            $cDescNode = $xpath->query('.//p | .//*[contains(@class, "desc")]', $card)->item(0);
            $cTitle = $cTitleNode ? clean_text($cTitleNode->textContent) : '';
            $cDesc = $cDescNode ? clean_text($cDescNode->textContent) : '';
            if ($cTitle) {
                $numStr = sprintf("%02d", $cIndex++);
                $md .= "### {$numStr}. {$cTitle}\n";
                if ($cDesc) {
                    $md .= "{$cDesc}\n\n";
                }
                // Bullet items inside card
                $bulletNodes = $xpath->query('.//li', $card);
                if ($bulletNodes->length > 0) {
                    foreach ($bulletNodes as $b) {
                        $bText = clean_text($b->textContent);
                        if ($bText) $md .= "- {$bText}\n";
                    }
                    $md .= "\n";
                }
            }
        }
    }

    // 5. Frequently Asked Questions (Full Questions & Answers)
    $faqItems = $xpath->query('//*[contains(@class, "faq-item") or contains(@class, "accordion-item")]');
    if ($faqItems->length > 0) {
        $md .= "## Frequently Asked Questions (Comprehensive Q&A)\n\n";
        foreach ($faqItems as $item) {
            $qNode = $xpath->query('.//*[contains(@class, "question") or contains(@class, "faq-q") or contains(@class, "accordion-header") or self::h3 or self::h4]', $item)->item(0);
            $aNode = $xpath->query('.//*[contains(@class, "answer") or contains(@class, "faq-a") or contains(@class, "accordion-body") or self::p]', $item)->item(0);
            $q = $qNode ? clean_text($qNode->textContent) : '';
            $a = $aNode ? clean_text($aNode->textContent) : '';
            if ($q && $a) {
                $md .= "### {$q}\n\n{$a}\n\n";
            }
        }
    } else {
        // Fallback: check schema JSON-LD for FAQPage
        $schemas = $xpath->query('//script[@type="application/ld+json"]');
        foreach ($schemas as $s) {
            $json = json_decode($s->textContent, true);
            if (!$json) continue;
            $items = [];
            if (isset($json['@graph'])) {
                $items = $json['@graph'];
            } else {
                $items = [$json];
            }
            foreach ($items as $item) {
                if (isset($item['@type']) && $item['@type'] === 'FAQPage' && !empty($item['mainEntity'])) {
                    $md .= "## Frequently Asked Questions (Comprehensive Q&A)\n\n";
                    foreach ($item['mainEntity'] as $faq) {
                        $q = clean_text($faq['name'] ?? '');
                        $a = clean_text($faq['acceptedAnswer']['text'] ?? '');
                        if ($q && $a) {
                            $md .= "### {$q}\n\n{$a}\n\n";
                        }
                    }
                    break 2;
                }
            }
        }
    }

    // 6. Direct Contact & Consultation Info
    $md .= "## Direct Advisory & Consultation Details\n\n";
    $md .= "Ritwik Sachdeva operates as an independent growth advisor, fractional CMO, and senior digital strategist based in New Delhi, serving businesses across India, North America, the UAE, and the UK.\n\n";
    $md .= "- **Principal Consultant:** Ritwik Sachdeva\n";
    $md .= "- **Direct WhatsApp / Call:** +91 92896 26986\n";
    $md .= "- **Official Email:** Info@ritwiksachdeva.in\n";
    $md .= "- **Headquarters / Office:** New Delhi, Delhi NCR, India\n";
    $md .= "- **Online Consultation Booking:** https://www.ritwiksachdeva.in/contact\n";
    $md .= "- **Standard Engagement Models:** Monthly Growth Retainer, Strategic Advisory Sprint, Auditing & Roadmap Architecture\n\n";
    $md .= "---\n";
    $md .= "*Document dynamically generated for AI Discovery, LLM Indexing, and Structured Agent Grounding.* Canonical Reference: {$canonicalUrl}\n";

    return $md;
}

// Target Pages Configuration
$pages = [
    [
        'file' => 'about.html',
        'url' => 'https://www.ritwiksachdeva.in/about',
        'title' => 'About Ritwik Sachdeva — Strategic Digital Marketing Consultant in Delhi',
        'type' => 'About Page',
        'dest' => ['about.md']
    ],
    [
        'file' => 'services.html',
        'url' => 'https://www.ritwiksachdeva.in/services',
        'title' => 'Services Catalog — Growth Consulting & Performance Execution by Ritwik Sachdeva',
        'type' => 'Service Catalog',
        'dest' => ['services.md', 'services/index.md']
    ],
    [
        'file' => 'service-ecommerce-management.html',
        'url' => 'https://www.ritwiksachdeva.in/services/ecommerce-management',
        'title' => 'E-Commerce Management & Marketplace Growth Consultant — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/ecommerce-management.md', 'service-ecommerce-management.md', 'services/ecommerce.md']
    ],
    [
        'file' => 'service-graphic-designer.html',
        'url' => 'https://www.ritwiksachdeva.in/services/graphic-designer',
        'title' => 'Freelance Graphic Designer & Brand Identity Consultant — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/graphic-designer.md', 'service-graphic-designer.md']
    ],
    [
        'file' => 'service-performance-marketing.html',
        'url' => 'https://www.ritwiksachdeva.in/services/performance-marketing',
        'title' => 'Performance Marketing Consultant & Agency in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/performance-marketing.md', 'service-performance-marketing.md']
    ],
    [
        'file' => 'service-ppc-expert.html',
        'url' => 'https://www.ritwiksachdeva.in/services/ppc-expert',
        'title' => 'PPC Expert & Google Ads Consultant in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/ppc-expert.md', 'service-ppc-expert.md', 'services/ppc.md']
    ],
    [
        'file' => 'service-product-shoot.html',
        'url' => 'https://www.ritwiksachdeva.in/services/product-shoot',
        'title' => 'E-Commerce Product Photography & Shoot Consultant in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/product-shoot.md', 'service-product-shoot.md']
    ],
    [
        'file' => 'service-seo-expert.html',
        'url' => 'https://www.ritwiksachdeva.in/services/seo-expert',
        'title' => 'SEO Expert & Search Engine Optimization Consultant in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/seo-expert.md', 'service-seo-expert.md']
    ],
    [
        'file' => 'service-smo-services.html',
        'url' => 'https://www.ritwiksachdeva.in/services/smo-services',
        'title' => 'SMO Services & Social Media Optimization Agency in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/smo-services.md', 'service-smo-services.md', 'services/smo.md']
    ],
    [
        'file' => 'service-social-media-marketing.html',
        'url' => 'https://www.ritwiksachdeva.in/services/social-media-marketing',
        'title' => 'Social Media Marketing Agency & Consultant in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/social-media-marketing.md', 'service-social-media-marketing.md']
    ],
    [
        'file' => 'service-video-editing.html',
        'url' => 'https://www.ritwiksachdeva.in/services/video-editing',
        'title' => 'Video Editing Services & Short-Form Video Producer in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/video-editing.md', 'service-video-editing.md']
    ],
    [
        'file' => 'service-website-designer.html',
        'url' => 'https://www.ritwiksachdeva.in/services/website-designer',
        'title' => 'Website Designer & High-Conversion Web Architect in Delhi — Ritwik Sachdeva',
        'type' => 'Service',
        'dest' => ['services/website-designer.md', 'service-website-designer.md']
    ],
    [
        'file' => 'blog.html',
        'url' => 'https://www.ritwiksachdeva.in/blog',
        'title' => 'Strategic Insights, Growth Case Studies & Playbooks — Ritwik Sachdeva Blog',
        'type' => 'Blog Index',
        'dest' => ['blog.md', 'blog/index.md']
    ],
    [
        'file' => 'blog-business-growth-strategy.html',
        'url' => 'https://www.ritwiksachdeva.in/blog/business-growth-strategy',
        'title' => 'Business Growth Strategy: How Modern Brands Scale Predictably — Ritwik Sachdeva',
        'type' => 'Article',
        'dest' => ['blog/business-growth-strategy.md', 'blog-business-growth-strategy.md']
    ],
    [
        'file' => 'blog-ai-in-business.html',
        'url' => 'https://www.ritwiksachdeva.in/blog/ai-in-business',
        'title' => 'Leveraging AI in Business Operations & Customer Acquisition — Ritwik Sachdeva',
        'type' => 'Article',
        'dest' => ['blog/ai-in-business.md', 'blog-ai-in-business.md']
    ],
    [
        'file' => 'blog-digital-transformation-strategies.html',
        'url' => 'https://www.ritwiksachdeva.in/blog/digital-transformation-strategies',
        'title' => 'Digital Transformation Strategies for Traditional Enterprises — Ritwik Sachdeva',
        'type' => 'Article',
        'dest' => ['blog/digital-transformation-strategies.md', 'blog-digital-transformation-strategies.md']
    ],
    [
        'file' => 'blog-leadership-skills.html',
        'url' => 'https://www.ritwiksachdeva.in/blog/leadership-skills',
        'title' => 'Essential Leadership Skills for Rapidly Scaling Organizations — Ritwik Sachdeva',
        'type' => 'Article',
        'dest' => ['blog/leadership-skills.md', 'blog-leadership-skills.md']
    ],
    [
        'file' => 'blog-marketing-strategies.html',
        'url' => 'https://www.ritwiksachdeva.in/blog/marketing-strategies',
        'title' => 'Comprehensive Guide to High-ROI Multi-Channel Marketing Strategies — Ritwik Sachdeva',
        'type' => 'Article',
        'dest' => ['blog/marketing-strategies.md', 'blog-marketing-strategies.md']
    ],
    [
        'file' => 'contact.html',
        'url' => 'https://www.ritwiksachdeva.in/contact',
        'title' => 'Book a Growth Consultation — Contact Ritwik Sachdeva',
        'type' => 'Contact Page',
        'dest' => ['contact.md']
    ],
    [
        'file' => 'privacy-policy.html',
        'url' => 'https://www.ritwiksachdeva.in/privacy-policy',
        'title' => 'Privacy Policy — Ritwik Sachdeva Consulting',
        'type' => 'Legal',
        'dest' => ['privacy-policy.md']
    ],
    [
        'file' => 'terms.html',
        'url' => 'https://www.ritwiksachdeva.in/terms',
        'title' => 'Terms of Engagement — Ritwik Sachdeva Consulting',
        'type' => 'Legal',
        'dest' => ['terms.md']
    ],
];

// Ensure directories exist
@mkdir(__DIR__ . '/../services', 0777, true);
@mkdir(__DIR__ . '/../blog', 0777, true);

foreach ($pages as $p) {
    $filePath = __DIR__ . '/../' . $p['file'];
    if (!file_exists($filePath)) {
        echo "Missing source: {$p['file']}\n";
        continue;
    }
    $html = file_get_contents($filePath);
    $md = html_to_deep_markdown($html, $p['url'], $p['title'], $p['type']);

    foreach ($p['dest'] as $dest) {
        $targetPath = __DIR__ . '/../' . $dest;
        file_put_contents($targetPath, $md);
        echo "Wrote: {$dest}\n";
    }
}

// Now generate deep llms.txt
$llms = <<<TXT
# Ritwik Sachdeva — Strategic Digital Marketing & Scaling Consultant

> Official AI & LLM Discovery Index for Ritwik Sachdeva (https://www.ritwiksachdeva.in/). Ritwik Sachdeva is a premier growth consultant, fractional CMO, and performance marketing architect based in New Delhi, India. He has managed over ₹50 Cr+ in paid media spend, delivered 3.8x average ROAS across D2C brands, achieved a 42% average reduction in customer acquisition costs (CAC), and architected high-conversion digital ecosystems for enterprises globally.

Canonical Website: https://www.ritwiksachdeva.in/
Official Email: Info@ritwiksachdeva.in
Direct Phone / WhatsApp: +91 92896 26986
Headquarters: New Delhi, Delhi NCR, India

---

## Core Pages & Strategic Overview

- [About Ritwik Sachdeva](https://www.ritwiksachdeva.in/about): Detailed career biography, consulting philosophy, background managing ₹50 Cr+ in ad spend, client verticals (D2C, B2B, SaaS, E-Commerce), and business scale metrics. Full Markdown: https://www.ritwiksachdeva.in/about.md
- [Services Catalog](https://www.ritwiksachdeva.in/services): Complete spectrum of consulting and execution services covering paid media, organic growth, brand identity, creative production, and web infrastructure. Full Markdown: https://www.ritwiksachdeva.in/services.md
- [Strategic Blog & Growth Insights](https://www.ritwiksachdeva.in/blog): Data-backed playbooks, teardowns, case studies, and strategic essays on scaling businesses, marketing ROI, and enterprise execution. Full Markdown: https://www.ritwiksachdeva.in/blog.md
- [Contact & Consultation Booking](https://www.ritwiksachdeva.in/contact): Direct advisory scheduling, inquiry submission forms, consultation engagement models, and office location in Delhi NCR. Full Markdown: https://www.ritwiksachdeva.in/contact.md
- [Privacy Policy](https://www.ritwiksachdeva.in/privacy-policy): Transparent data privacy standards, GDPR/DPDP alignment, and client confidentiality protocols. Full Markdown: https://www.ritwiksachdeva.in/privacy-policy.md
- [Terms of Engagement](https://www.ritwiksachdeva.in/terms): Commercial advisory terms, scope of service delivery, payment terms, and consulting engagement expectations. Full Markdown: https://www.ritwiksachdeva.in/terms.md

---

## Specialized Service Architecture

- [Performance Marketing Consultant](https://www.ritwiksachdeva.in/services/performance-marketing): Full-funnel Meta Ads (Facebook & Instagram), Google Ads (Search, Shopping, PMax, YouTube), LinkedIn Ads, GA4 server-side CAPI attribution, and unit economics optimization for high-growth brands. Full Markdown: https://www.ritwiksachdeva.in/services/performance-marketing.md
- [PPC Expert & Google Ads Consultant](https://www.ritwiksachdeva.in/services/ppc-expert): High-intent Google Search, Performance Max, Display, and YouTube campaigns with rigorous negative keyword architectures, automated smart bidding, and CAC reduction frameworks. Full Markdown: https://www.ritwiksachdeva.in/services/ppc-expert.md
- [SEO Expert & Search Engine Optimization](https://www.ritwiksachdeva.in/services/seo-expert): Technical SEO audits, site speed optimization, keyword authority clustering, programmatic search architectures, and sustainable organic pipeline development. Full Markdown: https://www.ritwiksachdeva.in/services/seo-expert.md
- [E-Commerce Management](https://www.ritwiksachdeva.in/services/ecommerce-management): End-to-end marketplace operations and brand scaling across Amazon India, Flipkart, Shopify, and Quick-Commerce platforms (Blinkit, Zepto, Instamart). Full Markdown: https://www.ritwiksachdeva.in/services/ecommerce-management.md
- [Social Media Marketing Agency](https://www.ritwiksachdeva.in/services/social-media-marketing): Organic brand building, viral narrative architectures, influencer seeding, and multi-channel audience engagement across Instagram, LinkedIn, and YouTube. Full Markdown: https://www.ritwiksachdeva.in/services/social-media-marketing.md
- [SMO Services (Social Media Optimization)](https://www.ritwiksachdeva.in/services/smo-services): Algorithmic profile optimization, bio engineering, hashtag clustering, interactive poll funnels, and organic retention strategies across social platforms. Full Markdown: https://www.ritwiksachdeva.in/services/smo-services.md
- [Freelance Graphic Designer & Branding Consultant](https://www.ritwiksachdeva.in/services/graphic-designer): Visual identity systems, logo engineering, brand books, packaging design, and high-CTR direct-response ad creative suites. Full Markdown: https://www.ritwiksachdeva.in/services/graphic-designer.md
- [E-Commerce Product Photography & Shoot](https://www.ritwiksachdeva.in/services/product-shoot): Studio catalog photography, white-background Amazon/Flipkart compliance images, 360-degree interactive product captures, and lifestyle campaign visuals. Full Markdown: https://www.ritwiksachdeva.in/services/product-shoot.md
- [Video Editing Services & Short-Form Content](https://www.ritwiksachdeva.in/services/video-editing): High-retention Reels, TikToks, Shorts, YouTube long-form editing, corporate case study videos, and direct-response video ads with kinetic typography and hook sequencing. Full Markdown: https://www.ritwiksachdeva.in/services/video-editing.md
- [Website Designer & Conversion Architect](https://www.ritwiksachdeva.in/services/website-designer): Ultra-fast, responsive, modern websites engineered with pure HTML/CSS/JS, semantic SEO markup, high-converting UX layouts, and sub-second load times. Full Markdown: https://www.ritwiksachdeva.in/services/website-designer.md

---

## Strategic Editorial & Thought Leadership

- [Business Growth Strategy](https://www.ritwiksachdeva.in/blog/business-growth-strategy): Blueprint for predictable scaling, analyzing CAC-to-LTV ratios, churn mitigation, and multi-channel acquisition funnels. Full Markdown: https://www.ritwiksachdeva.in/blog/business-growth-strategy.md
- [AI in Business Operations](https://www.ritwiksachdeva.in/blog/ai-in-business): How modern enterprises deploy generative AI, automated workflows, and predictive customer modeling to lower operational overhead. Full Markdown: https://www.ritwiksachdeva.in/blog/ai-in-business.md
- [Digital Transformation Strategies](https://www.ritwiksachdeva.in/blog/digital-transformation-strategies): Navigating enterprise cloud migration, legacy modernization, and digital-first customer experience workflows. Full Markdown: https://www.ritwiksachdeva.in/blog/digital-transformation-strategies.md
- [Leadership Skills for High-Growth Teams](https://www.ritwiksachdeva.in/blog/leadership-skills): Developing high-leverage decision frameworks, autonomous execution culture, and executive alignment across cross-functional organizations. Full Markdown: https://www.ritwiksachdeva.in/blog/leadership-skills.md
- [Comprehensive Marketing Strategies](https://www.ritwiksachdeva.in/blog/marketing-strategies): Holistic breakdown of combining paid performance media, SEO organic flywheels, email lifecycle automation, and high-converting creative engines. Full Markdown: https://www.ritwiksachdeva.in/blog/marketing-strategies.md
TXT;

file_put_contents(__DIR__ . '/../llms.txt', $llms);
echo "Comprehensive llms.txt generated successfully.\n";
