import glob
import os
import re

html_files = glob.glob('*.html') + glob.glob('*.php')
print(f"Total HTML/PHP files to verify: {len(html_files)}")

consultant_refs = []
for f in html_files:
    if f == 'service-best-marketing-consultant.html':
        continue
    with open(f, 'r', encoding='utf-8') as fl:
        content = fl.read()
    if 'service-best-marketing-consultant.html' in content:
        consultant_refs.append(f)

print(f"Files referencing service-best-marketing-consultant.html: {consultant_refs}")

# Check 10 service files
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

print("\nVerifying 10 Service Pages:")
for sf in service_files:
    if not os.path.exists(sf):
        print(f"ERROR: Missing file {sf}")
        continue
    with open(sf, 'r', encoding='utf-8') as f:
        text = f.read()
    has_header = '<header class="site-header"' in text
    has_topbar = 'header-top-bar' in text
    has_footer = '<footer class="site-footer"' in text
    has_popup = 'consultation-popup-overlay' in text
    has_wa = 'floating-btn-whatsapp' in text
    has_call = 'floating-btn-call' in text
    has_btt = 'back-to-top' in text
    faqs_count = text.count('class="faq-item')
    size_kb = len(text) / 1024
    print(f"  ✓ {sf} ({size_kb:.1f} KB): FAQs={faqs_count}, Header={has_header}, TopBar={has_topbar}, Footer={has_footer}, Popup={has_popup}, WA={has_wa}, Call={has_call}, BTT={has_btt}")
