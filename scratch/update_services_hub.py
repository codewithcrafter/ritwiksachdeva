import os
import sys
import re

sys.path.insert(0, os.path.abspath('.'))

from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

# 1. Update header dropdown & mobile drawer & footer
header_html = render_header('services.html')
drawer_html = render_mobile_drawer('services.html')
footer_html = render_footer()

# Replace header
text = re.sub(r'<!-- SITE HEADER / NAVBAR -->\s*<header class="site-header".*?</header>', header_html, text, flags=re.DOTALL)

# Replace mobile drawer
text = re.sub(r'<!-- Mobile Drawer Navigation -->\s*<div class="mobile-drawer".*?</div>\s*</div>\s*</div>', drawer_html, text, flags=re.DOTALL)

# Replace footer
text = re.sub(r'<!-- FOOTER -->\s*<footer class="site-footer".*?</footer>', footer_html, text, flags=re.DOTALL)

# 2. Update Hero metrics: 11 -> 10
text = text.replace('Explore 11 specialized services', 'Explore 10 specialized services')
text = text.replace('<div class="metric-strip-val">11</div>', '<div class="metric-strip-val">10</div>')

# 3. Update sticky track: remove #best-marketing-consultant pill
text = re.sub(r'<a href="#best-marketing-consultant" class="subnav-pill">.*?</a>\s*', '', text)

# 4. Update jump selects:
# Remove option 10. Delhi’s Best Digital Marketing Consultant
text = re.sub(r'<option value="service-best-marketing-consultant.html">.*?</option>\s*', '', text)
text = re.sub(r'<option value="#best-marketing-consultant">.*?</option>\s*', '', text)

# Renumber 11 -> 10 for website designer
text = text.replace('11. Website Designer in Delhi &rarr;', '10. Website Designer in Delhi &rarr;')
text = text.replace('Overview 11: Website Designer in Delhi', 'Overview 10: Website Designer in Delhi')
text = text.replace('SERVICE 11 / WEB ENGINEERING', 'SERVICE 10 / WEB ENGINEERING')

# 5. Remove the catalog card for best-marketing-consultant
# Find the start of id="best-marketing-consultant" and the start of next card id="website-designer"
pos_start = text.find('id="best-marketing-consultant"')
if pos_start != -1:
    card_start = text.rfind('<div class="service-premium-card', 0, pos_start)
    pos_next = text.find('id="website-designer"')
    card_next = text.rfind('<div class="service-premium-card', 0, pos_next)
    if card_start != -1 and card_next != -1:
        text = text[:card_start] + text[card_next:]
        print("Removed best-marketing-consultant card from catalog successfully!")

with open('services.html', 'w', encoding='utf-8') as f:
    f.write(text)

print("Updated services.html successfully!")
