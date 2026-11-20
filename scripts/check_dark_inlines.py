import os
import re
import glob

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

html_files = glob.glob("*.html") + glob.glob("*.php")
print(f"Checking {len(html_files)} files for inline dark styles...")

dark_patterns = [
    r'style="[^"]*background(?:-color)?:\s*#(?:0|1[0-9a-fA-F]{5})[^"]*"',
    r'style="[^"]*background(?:-color)?:\s*(?:black|#000|#111|#05070E|#030508|#171A1D)[^"]*"',
    r'style="[^"]*color:\s*#(?:fff|ffffff|FFF|FFFFFF)[^"]*"',
]

for f in sorted(html_files):
    if f.startswith('admin') or f.startswith('test'):
        continue
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    found = []
    for pat in dark_patterns:
        matches = re.findall(pat, c, re.IGNORECASE)
        if matches:
            found.extend(matches)
    if found:
        print(f"[{f}] found {len(found)} instances:")
        for m in found[:3]:
            print(f"   {m}")
