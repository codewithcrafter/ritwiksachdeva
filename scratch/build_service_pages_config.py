"""
Build script to generate all 10 high-converting, neo-brutalist service pages for Ritwik Sachdeva.
Preserves 100% of the content provided by the user while applying the strict neo-brutalist design direction.
"""

import json
import re
import os

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    services_raw = json.load(f)

# The 10 services specification
SERVICES_CONFIG = {
    'e-commerce-management-services-in-delhi': {
        'filename': 'service-ecommerce-management.html',
        'num': '01',
        'short_title': 'E-Commerce Management',
        'meta_title': 'E-Commerce Management Services in Delhi — Amazon, Flipkart & Shopify | Ritwik Sachdeva',
        'meta_desc': 'End-to-end e-commerce management in Delhi across Amazon, Flipkart, and Shopify. Cataloging, Buy Box optimization, PPC, and RTO reduction. Book a consultation.',
        'eyebrow': 'Marketplace Operations & Growth',
        'metrics': [
            {'val': '4.2x', 'lbl': 'Avg Marketplace ROAS'},
            {'val': '-38%', 'lbl': 'RTO / DTO Reduction'},
            {'val': '98.4%', 'lbl': 'Buy Box Retention'},
            {'val': '300+', 'lbl': 'Brand SKUs Scaled'}
        ],
        'related': ['service-performance-marketing.html', 'service-ppc-expert.html', 'service-product-shoot.html']
    },
    'freelance-graphic-designer-in-delhi': {
        'filename': 'service-graphic-designer.html',
        'num': '02',
        'short_title': 'Graphic Designer & Branding',
        'meta_title': 'Freelance Graphic Designer & Branding Design Consultant in Delhi — Ritwik Sachdeva',
        'meta_desc': 'Freelance graphic designer and branding design consultant in Delhi. Custom logo design, brand style guides, marketing collateral, and ad creatives. Book a consultation.',
        'eyebrow': 'Visual Identity & Creative Strategy',
        'metrics': [
            {'val': '300+', 'lbl': 'Brand Identities Designed'},
            {'val': '100%', 'lbl': 'Vector & Production Ready'},
            {'val': '48h', 'lbl': 'Rapid Concept Turnaround'},
            {'val': '4.9/5', 'lbl': 'Client Review Rating'}
        ],
        'related': ['service-website-designer.html', 'service-social-media-marketing.html', 'service-video-editing.html']
    },
    'performance-marketing-consultant-in-delhi': {
        'filename': 'service-performance-marketing.html',
        'num': '03',
        'short_title': 'Performance Marketing Consultant',
        'meta_title': 'Performance Marketing Consultant & Agency in Delhi — Ritwik Sachdeva',
        'meta_desc': 'Performance marketing consultant in Delhi for D2C brands & B2B. ROI-driven Meta ads, Google Ads, GA4 attribution, and CAC reduction. Book a consultation.',
        'eyebrow': 'Paid Media Scaling & CAC Reduction',
        'metrics': [
            {'val': '₹50 Cr+', 'lbl': 'Pipeline Generated'},
            {'val': '4.6x', 'lbl': 'Avg Blended ROAS'},
            {'val': '-32%', 'lbl': 'Customer Acquisition Cost'},
            {'val': '94%', 'lbl': 'Client Retention'}
        ],
        'related': ['service-ppc-expert.html', 'service-social-media-marketing.html', 'service-ecommerce-management.html']
    },
    'ppc-expert-in-delhi': {
        'filename': 'service-ppc-expert.html',
        'num': '04',
        'short_title': 'PPC Expert in Delhi',
        'meta_title': 'PPC Expert in Delhi | Google Ads Consultant Delhi — Ritwik Sachdeva',
        'meta_desc': 'PPC expert and Google Ads consultant in Delhi. Search, Shopping, PMax, and YouTube ads optimized for high ROAS and lower CPA. Book a consultation.',
        'eyebrow': 'Google Ads & High-Intent Search',
        'metrics': [
            {'val': '5.2x', 'lbl': 'Target ROAS Achieved'},
            {'val': '0%', 'lbl': 'Broad Match Budget Bleed'},
            {'val': '10/10', 'lbl': 'Quality Score Optimization'},
            {'val': '₹15 Cr+', 'lbl': 'Ad Spend Managed'}
        ],
        'related': ['service-performance-marketing.html', 'service-seo-expert.html', 'service-website-designer.html']
    },
    'product-shoot-services-in-delhi': {
        'filename': 'service-product-shoot.html',
        'num': '05',
        'short_title': 'Product Shoot Services',
        'meta_title': 'Product Photography & Product Shoot Services in Delhi — Ritwik Sachdeva',
        'meta_desc': 'Professional product photography in Delhi for e-commerce, Amazon, Flipkart, and Shopify. White background, ghost mannequin, and lifestyle shoots. Book a consultation.',
        'eyebrow': 'E-Commerce & High-Conversion Photography',
        'metrics': [
            {'val': '2,500+', 'lbl': 'Products Photographed'},
            {'val': '100%', 'lbl': 'Marketplace Compliant'},
            {'val': '+45%', 'lbl': 'Listing Conversion Uplift'},
            {'val': '3-5 Days', 'lbl': 'Edited Delivery Window'}
        ],
        'related': ['service-ecommerce-management.html', 'service-graphic-designer.html', 'service-video-editing.html']
    },
    'seo-expert-in-delhi': {
        'filename': 'service-seo-expert.html',
        'num': '06',
        'short_title': 'SEO Expert in Delhi',
        'meta_title': 'SEO Expert in Delhi — Ritwik Sachdeva',
        'meta_desc': 'SEO expert in Delhi providing technical audits, programmatic SEO, keyword strategy, and local SEO for sustainable organic rankings. Book a consultation.',
        'eyebrow': 'Organic Traffic & Technical Search Moats',
        'metrics': [
            {'val': '+280%', 'lbl': 'Avg Organic Traffic Surge'},
            {'val': 'Top 3', 'lbl': 'High-Intent Google Rankings'},
            {'val': '100%', 'lbl': 'White-Hat Technical SEO'},
            {'val': 'Zero', 'lbl': 'Google Penalty Risk'}
        ],
        'related': ['service-ppc-expert.html', 'service-website-designer.html', 'service-performance-marketing.html']
    },
    'smo-services-in-delhi': {
        'filename': 'service-smo-services.html',
        'num': '07',
        'short_title': 'SMO Services in Delhi',
        'meta_title': 'SMO Services in Delhi — Social Media Optimization Consultant | Ritwik Sachdeva',
        'meta_desc': 'Social media optimization (SMO) services in Delhi. Profile optimization, engagement architecture, organic social reach, and SEO synergy. Book a consultation.',
        'eyebrow': 'Social Media Optimization & Authority',
        'metrics': [
            {'val': '10x', 'lbl': 'Organic Profile Visibility'},
            {'val': '100%', 'lbl': 'Consistent Brand Voice'},
            {'val': '+65%', 'lbl': 'Social Referral Traffic'},
            {'val': '5+', 'lbl': 'Platforms Synced'}
        ],
        'related': ['service-social-media-marketing.html', 'service-seo-expert.html', 'service-graphic-designer.html']
    },
    'social-media-marketing-consultant-in-delhi': {
        'filename': 'service-social-media-marketing.html',
        'num': '08',
        'short_title': 'Social Media Marketing Consultant',
        'meta_title': 'Social Media Marketing (SMM) Consultant in Delhi — Ritwik Sachdeva',
        'meta_desc': 'Social media marketing consultant in Delhi. Full-funnel Meta Ads, content calendar execution, B2B LinkedIn growth, and lead gen. Book a consultation.',
        'eyebrow': 'Full-Funnel Social Growth & Meta Ads',
        'metrics': [
            {'val': '88K+', 'lbl': 'Organic Campaign Reach'},
            {'val': '₹1.94', 'lbl': 'Cost Per Engagement Result'},
            {'val': '3.8x', 'lbl': 'Social ROAS Achieved'},
            {'val': 'Daily', 'lbl': 'Active Community Management'}
        ],
        'related': ['service-smo-services.html', 'service-performance-marketing.html', 'service-video-editing.html']
    },
    'video-editing-services-in-delhi': {
        'filename': 'service-video-editing.html',
        'num': '09',
        'short_title': 'Video Editing Services in Delhi',
        'meta_title': 'Video Editing Services in Delhi | Freelance Video Editor & Reels Editor — Ritwik Sachdeva',
        'meta_desc': 'Freelance video editing in Delhi for Instagram Reels, YouTube Shorts, corporate films, and high-converting video ads. Book a consultation.',
        'eyebrow': 'High-Retention Video & Reels Production',
        'metrics': [
            {'val': '1,200+', 'lbl': 'Reels & Shorts Produced'},
            {'val': '78%', 'lbl': 'Avg 3-Second Hook Retention'},
            {'val': '4K 60', 'lbl': 'Broadcast Quality Standards'},
            {'val': '48h', 'lbl': 'Turnaround Per Reel Sprint'}
        ],
        'related': ['service-social-media-marketing.html', 'service-graphic-designer.html', 'service-product-shoot.html']
    },
    'website-designer-in-delhi': {
        'filename': 'service-website-designer.html',
        'num': '10',
        'short_title': 'Website Designer in Delhi',
        'meta_title': 'Website Designer in Delhi | Web Development Services — Ritwik Sachdeva',
        'meta_desc': 'Custom website designer and web developer in Delhi. High-speed custom web development, WordPress themes, Shopify e-commerce, and CRO. Book a consultation.',
        'eyebrow': 'Conversion-Engineered Web Development',
        'metrics': [
            {'val': '99/100', 'lbl': 'Google PageSpeed Score'},
            {'val': '<1.2s', 'lbl': 'Largest Contentful Paint'},
            {'val': '100%', 'lbl': 'Mobile & SEO Responsive'},
            {'val': '+52%', 'lbl': 'Conversion Rate Uplift'}
        ],
        'related': ['service-seo-expert.html', 'service-ppc-expert.html', 'service-graphic-designer.html']
    }
}

print("Configuration ready for all 10 services.")
