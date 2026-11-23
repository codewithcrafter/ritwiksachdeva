import os
import sys
import re

sys.path.insert(0, os.path.abspath('.'))
from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

# 1. Replace header
header_html = render_header('services.html')
text = re.sub(r'<header class="site-header"[^>]*>.*?</header>', header_html.strip(), text, flags=re.DOTALL)

# 2. Replace mobile drawer
drawer_html = render_mobile_drawer('services.html')
text = re.sub(r'<div class="mobile-drawer"[^>]*>.*?</div>\s*</div>\s*(?=<!--|<main)', drawer_html.strip() + '\n', text, flags=re.DOTALL)

# 3. Replace footer
footer_html = render_footer()
text = re.sub(r'<footer class="site-footer"[^>]*>.*?</footer>', footer_html.strip(), text, flags=re.DOTALL)

# 4. Remove the article block for best-marketing-consultant
pattern = r'<article class="service-premium-card reveal-on-scroll" id="best-marketing-consultant".*?</article>\s*'
text = re.sub(pattern, '', text, flags=re.DOTALL)

with open('services.html', 'w', encoding='utf-8') as f:
    f.write(text)

print("services.html cleaned completely!")
