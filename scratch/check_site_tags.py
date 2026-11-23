import os
import glob
import re

files = glob.glob('*.html') + glob.glob('*.php')
print(f"Total files: {len(files)}")

for f in sorted(files):
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    h = re.search(r'<header class="site-header"[^>]*>.*?</header>', c, re.DOTALL)
    d = re.search(r'<div class="mobile-drawer"[^>]*>.*?(?=(<!--\s*(MAIN|SECTION|<main|<section|<!--\s*Ambient)|\Z))', c, re.DOTALL | re.IGNORECASE)
    ft = re.search(r'<footer class="site-footer"[^>]*>.*?</footer>', c, re.DOTALL)
    fl = re.search(r'<div class="floating-actions[^"]*"[^>]*>.*?</div>', c, re.DOTALL)
    print(f"{f:35} : H={bool(h)} D={bool(d)} FT={bool(ft)} FL={bool(fl)}")
