import glob
import re

service_files = [
    'service-ecommerce-management.html',
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-seo-expert.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-website-designer.html'
]

errors = []
for sf in service_files:
    with open(sf, 'r', encoding='utf-8') as f:
        html = f.read()
    
    # Check H1
    h1 = re.findall(r'<h1[^>]*>(.*?)</h1>', html, re.DOTALL)
    if not h1:
        errors.append(f"{sf}: Missing H1")
    
    # Check Breadcrumbs
    if 'class="service-breadcrumbs"' not in html:
        errors.append(f"{sf}: Missing breadcrumbs")
        
    # Check Consultation CTA triggers
    if 'data-open-popup="consultation"' not in html:
        errors.append(f"{sf}: Missing consultation trigger")
        
    # Check FAQs
    faqs = re.findall(r'<button class="faq-question"[^>]*>.*?<span>(.*?)</span>', html, re.DOTALL)
    if len(faqs) < 6:
        errors.append(f"{sf}: Too few FAQs ({len(faqs)})")
        
    # Check WhatsApp & Call
    if 'floating-btn-whatsapp' not in html or 'floating-btn-call' not in html:
        errors.append(f"{sf}: Missing floating actions")
        
    # Check Top bar
    if 'consult@ritwiksachdeva.com' not in html:
        errors.append(f"{sf}: Missing top bar contact email")
        
    # Check dropdown items count
    dropdown_items = re.findall(r'class="nav-dropdown-item', html)
    if len(dropdown_items) != 10:
        errors.append(f"{sf}: Dropdown items count is {len(dropdown_items)}, expected 10")
        
    # Check mobile sublinks count
    sublinks = re.findall(r'class="mobile-sublink', html)
    if len(sublinks) != 10:
        errors.append(f"{sf}: Mobile sublinks count is {len(sublinks)}, expected 10")

print(f"Deep QA Check completed. Total errors found: {len(errors)}")
for e in errors:
    print("  ERROR:", e)

if not errors:
    print("ALL 10 SERVICE PAGES PASSED 100% OF QA CHECKS PERFECTLY!")
