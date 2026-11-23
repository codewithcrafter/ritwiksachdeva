import os
import glob
import re
import sys

sys.path.insert(0, os.path.abspath('.'))
from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

files = sorted(glob.glob('*.html') + glob.glob('*.php'))
print(f"Batch migrating {len(files)} files to clean URLs...")

MAPPING = [
    # Full URLs in metadata / schema
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/index\.(?:html|php)', r'/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/about\.html', r'/about/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/services\.html', r'/services/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/contact\.html', r'/contact/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog\.(?:html|php)', r'/blog/'),
    
    # Full Service URLs
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-ecommerce-management\.html', r'/services/ecommerce-management/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-graphic-designer\.html', r'/services/graphic-designer/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-performance-marketing\.html', r'/services/performance-marketing/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-ppc-expert\.html', r'/services/ppc-expert/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-product-shoot\.html', r'/services/product-shoot/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-seo-expert\.html', r'/services/seo-expert/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-smo-services\.html', r'/services/smo-services/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-social-media-marketing\.html', r'/services/social-media-marketing/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-video-editing\.html', r'/services/video-editing/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-website-designer\.html', r'/services/website-designer/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/service-best-marketing-consultant\.html', r'/services/'),
    
    # Full Blog URLs
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog-ai-in-business\.html', r'/blog/ai-in-business/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog-business-growth-strategy\.html', r'/blog/business-growth-strategy/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog-digital-transformation-strategies\.html', r'/blog/digital-transformation-strategies/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog-leadership-skills\.html', r'/blog/leadership-skills/'),
    (r'https?://(?:ritwiksachdeva\.(?:com|in)|localhost:8000)/blog-marketing-strategies\.html', r'/blog/marketing-strategies/'),

    # Encoded share URLs
    (r'%2Fblog-detail\.php%3Fslug%3Dai-in-business', r'%2Fblog%2Fai-in-business%2F'),
    (r'%2Fblog-detail\.php%3Fslug%3Dbusiness-growth-strategy', r'%2Fblog%2Fbusiness-growth-strategy%2F'),
    (r'%2Fblog-detail\.php%3Fslug%3Ddigital-transformation-strategies', r'%2Fblog%2Fdigital-transformation-strategies%2F'),
    (r'%2Fblog-detail\.php%3Fslug%3Dleadership-skills', r'%2Fblog%2Fleadership-skills%2F'),
    (r'%2Fblog-detail\.php%3Fslug%3Dmarketing-strategies', r'%2Fblog%2Fmarketing-strategies%2F'),
    (r'%2Fblog-ai-in-business\.html', r'%2Fblog%2Fai-in-business%2F'),
    (r'%2Fblog-business-growth-strategy\.html', r'%2Fblog%2Fbusiness-growth-strategy%2F'),
    (r'%2Fblog-digital-transformation-strategies\.html', r'%2Fblog%2Fdigital-transformation-strategies%2F'),
    (r'%2Fblog-leadership-skills\.html', r'%2Fblog%2Fleadership-skills%2F'),
    (r'%2Fblog-marketing-strategies\.html', r'%2Fblog%2Fmarketing-strategies%2F'),

    # Relative Service page links
    (r'href=["\'](?:./)?service-ecommerce-management\.html["\']', r'href="/services/ecommerce-management/"'),
    (r'href=["\'](?:./)?service-graphic-designer\.html["\']', r'href="/services/graphic-designer/"'),
    (r'href=["\'](?:./)?service-performance-marketing\.html["\']', r'href="/services/performance-marketing/"'),
    (r'href=["\'](?:./)?service-ppc-expert\.html["\']', r'href="/services/ppc-expert/"'),
    (r'href=["\'](?:./)?service-product-shoot\.html["\']', r'href="/services/product-shoot/"'),
    (r'href=["\'](?:./)?service-seo-expert\.html["\']', r'href="/services/seo-expert/"'),
    (r'href=["\'](?:./)?service-smo-services\.html["\']', r'href="/services/smo-services/"'),
    (r'href=["\'](?:./)?service-social-media-marketing\.html["\']', r'href="/services/social-media-marketing/"'),
    (r'href=["\'](?:./)?service-video-editing\.html["\']', r'href="/services/video-editing/"'),
    (r'href=["\'](?:./)?service-website-designer\.html["\']', r'href="/services/website-designer/"'),
    (r'href=["\'](?:./)?service-best-marketing-consultant\.html["\']', r'href="/services/"'),

    # Relative Blog page links
    (r'href=["\'](?:./)?blog-ai-in-business\.html["\']', r'href="/blog/ai-in-business/"'),
    (r'href=["\'](?:./)?blog-business-growth-strategy\.html["\']', r'href="/blog/business-growth-strategy/"'),
    (r'href=["\'](?:./)?blog-digital-transformation-strategies\.html["\']', r'href="/blog/digital-transformation-strategies/"'),
    (r'href=["\'](?:./)?blog-leadership-skills\.html["\']', r'href="/blog/leadership-skills/"'),
    (r'href=["\'](?:./)?blog-marketing-strategies\.html["\']', r'href="/blog/marketing-strategies/"'),

    # Blog category & tag query strings
    (r'href=["\'](?:./)?blog\.(?:html|php)\?category=([^"\']+)["\']', r'href="/blog/?category=\1"'),
    (r'href=["\'](?:./)?blog\.(?:html|php)\?tag=([^"\']+)["\']', r'href="/blog/?tag=\1"'),

    # Main core pages in hrefs
    (r'href=["\'](?:./)?index\.(?:html|php)["\']', r'href="/"'),
    (r'href=["\'](?:./)?about\.html["\']', r'href="/about/"'),
    (r'href=["\'](?:./)?services\.html["\']', r'href="/services/"'),
    (r'href=["\'](?:./)?contact\.html["\']', r'href="/contact/"'),
    (r'href=["\'](?:./)?blog\.(?:html|php)["\']', r'href="/blog/"'),
]

for filename in files:
    if filename == 'router.php':
        continue
    with open(filename, 'r', encoding='utf-8') as f:
        text = f.read()

    # 1. Synchronize Header
    header_html = render_header(filename).strip()
    text = re.sub(r'<header class="site-header"[^>]*>.*?</header>', header_html, text, count=1, flags=re.DOTALL)

    # 2. Synchronize Mobile Drawer
    drawer_html = render_mobile_drawer(filename).strip()
    text = re.sub(
        r'(<!-- Mobile Drawer Navigation -->\s*)?<div class="mobile-drawer"[^>]*>.*?</div>\s*</div>',
        drawer_html,
        text,
        count=1,
        flags=re.DOTALL
    )

    # 3. Synchronize Footer + Back to Top + Floating Actions
    footer_block = render_footer().strip() + '\n\n  '
    text = re.sub(
        r'(<!-- FOOTER -->\s*)?<footer class="site-footer"[^>]*>.*?(?=(<!-- Timed Consultation Popup|<div class="consultation-popup-overlay"|<script\s+src="js/main.js"))',
        footer_block,
        text,
        count=1,
        flags=re.DOTALL
    )

    # 4. Apply all link pattern replacements
    for pattern, repl in MAPPING:
        text = re.sub(pattern, repl, text)

    # 5. Fix remaining JSON-LD breadcrumb items and canonical tags
    # Keep domain prefix if present
    text = re.sub(r'(["\']item["\']:\s*["\']https?://[^"\']+)index\.(?:html|php)(["\'])', r'\1/\2', text)
    text = re.sub(r'(["\']item["\']:\s*["\']https?://[^"\']+)about\.html(["\'])', r'\1about/\2', text)
    text = re.sub(r'(["\']item["\']:\s*["\']https?://[^"\']+)services\.html(["\'])', r'\1services/\2', text)
    text = re.sub(r'(["\']item["\']:\s*["\']https?://[^"\']+)contact\.html(["\'])', r'\1contact/\2', text)
    text = re.sub(r'(["\']item["\']:\s*["\']https?://[^"\']+)blog\.(?:html|php)(["\'])', r'\1blog/\2', text)

    with open(filename, 'w', encoding='utf-8') as f:
        f.write(text)

    print(f"Migrated links in {filename}")

print("Batch migration complete.")
