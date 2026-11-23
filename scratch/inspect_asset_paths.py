import glob
import re

files = sorted(glob.glob('*.html') + glob.glob('*.php'))

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    css_links = re.findall(r'<link[^>]+href=["\']([^"\']+\.css[^"\']*)["\']', c)
    js_scripts = re.findall(r'<script[^>]+src=["\']([^"\']+\.js[^"\']*)["\']', c)
    has_base = '<base ' in c
    
    print(f"{f:35} (base={has_base}):")
    print(f"  CSS: {css_links[:3]}")
    print(f"  JS : {js_scripts[:3]}")
