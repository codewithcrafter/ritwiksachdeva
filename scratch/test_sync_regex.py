import glob
import re
import os
import sys

sys.path.insert(0, os.path.abspath('.'))
from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

files = sorted(glob.glob('*.html') + glob.glob('*.php'))

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    # 1. Header match
    h_match = re.search(r'<header class="site-header"[^>]*>.*?</header>', c, re.DOTALL)
    
    # 2. Drawer match
    d_match = re.search(r'<!-- Mobile Drawer Navigation -->\s*<div class="mobile-drawer"[^>]*>.*?</div>\s*</div>', c, re.DOTALL)
    if not d_match:
        d_match = re.search(r'<div class="mobile-drawer"[^>]*>.*?</div>\s*</div>', c, re.DOTALL)
        
    # 3. Footer up to popup or script
    ft_match = re.search(r'(<!-- FOOTER -->\s*)?<footer class="site-footer"[^>]*>.*?(?=(<!-- Timed Consultation Popup|<div class="consultation-popup-overlay"|<script\s+src="js/main.js"))', c, re.DOTALL)
    
    print(f"{f:35}: H={bool(h_match)} D={bool(d_match)} FT={bool(ft_match)}")
