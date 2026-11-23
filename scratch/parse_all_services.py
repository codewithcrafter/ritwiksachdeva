import json, re

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    raw_services = json.load(f)

print(f"Total raw services: {len(raw_services)}")

slug_mapping = {
    'e-commerce-management-services-in-delhi': 'service-ecommerce-management.html',
    'freelance-graphic-designer-in-delhi': 'service-graphic-designer.html',
    'performance-marketing-consultant-in-delhi': 'service-performance-marketing.html',
    'ppc-expert-in-delhi': 'service-ppc-expert.html',
    'product-shoot-services-in-delhi': 'service-product-shoot.html',
    'seo-expert-in-delhi': 'service-seo-expert.html',
    'smo-services-in-delhi': 'service-smo-services.html',
    'social-media-marketing-consultant-in-delhi': 'service-social-media-marketing.html',
    'video-editing-services-in-delhi': 'service-video-editing.html',
    'website-designer-in-delhi': 'service-website-designer.html'
}

for slug, filename in slug_mapping.items():
    text = raw_services[slug]
    lines = [l.strip() for l in text.split('\n') if l.strip()]
    print(f"\n==================== {slug} -> {filename} ====================")
    print(f"Lines count: {len(lines)}")
    # Print the first few lines
    for i, l in enumerate(lines[:12]):
        print(f"  {i}: {l[:85]}")
