import glob
import re

files = sorted(glob.glob('*.html') + glob.glob('*.php') + glob.glob('js/*.js'))
print(f"Scanning {len(files)} files for .html and .php links...")

html_links = {}

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    # Find all href="..."
    hrefs = re.findall(r'href=["\']([^"\']*\.(?:html|php)[^"\']*)["\']', c)
    # Find all action="..."
    actions = re.findall(r'action=["\']([^"\']*\.(?:html|php)[^"\']*)["\']', c)
    # Find all window.location or similar in JS
    js_locs = re.findall(r'["\']([a-zA-Z0-9_/-]+\.(?:html|php))["\']', c)
    
    total = hrefs + actions
    if total:
        html_links[f] = set(total)

for f, links in html_links.items():
    print(f"\n{f} ({len(links)} unique links):")
    for l in sorted(links):
        print(f"  - {l}")
