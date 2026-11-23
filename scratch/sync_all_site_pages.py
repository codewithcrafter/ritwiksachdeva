import os
import glob
import re
import sys

sys.path.insert(0, os.path.abspath('.'))
from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

files = sorted(glob.glob('*.html') + glob.glob('*.php'))
print(f"Syncing {len(files)} files...")

for filename in files:
    with open(filename, 'r', encoding='utf-8') as f:
        text = f.read()

    orig_len = len(text)

    # 1. Header
    header_html = render_header(filename).strip()
    text = re.sub(r'<header class="site-header"[^>]*>.*?</header>', header_html, text, count=1, flags=re.DOTALL)

    # 2. Mobile drawer
    drawer_html = render_mobile_drawer(filename).strip()
    text = re.sub(
        r'(<!-- Mobile Drawer Navigation -->\s*)?<div class="mobile-drawer"[^>]*>.*?</div>\s*</div>',
        drawer_html,
        text,
        count=1,
        flags=re.DOTALL
    )

    # 3. Footer + Back to Top + Floating Actions
    footer_block = render_footer().strip() + '\n\n  '
    text = re.sub(
        r'(<!-- FOOTER -->\s*)?<footer class="site-footer"[^>]*>.*?(?=(<!-- Timed Consultation Popup|<div class="consultation-popup-overlay"|<script\s+src="js/main.js"))',
        footer_block,
        text,
        count=1,
        flags=re.DOTALL
    )

    # 4. Clean up any popup placeholder discrepancies
    text = text.replace('placeholder="e.g. +91 98765 43210"', 'placeholder="e.g. +91 92896 26986"')
    text = text.replace('placeholder="e.g. consult@ritwiksachdeva.com"', 'placeholder="e.g. Info@ritwiksachdeva.in"')

    with open(filename, 'w', encoding='utf-8') as f:
        f.write(text)

    print(f"Synced {filename:35} (length: {orig_len} -> {len(text)})")

print("All files synchronized successfully.")
