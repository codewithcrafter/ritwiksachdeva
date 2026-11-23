import glob
import re

css_files = glob.glob('css/*.css')

for cf in css_files:
    with open(cf, 'r', encoding='utf-8') as f:
        content = f.read()
    matches = re.findall(r'(\.[a-zA-Z0-9_\-]*author[a-zA-Z0-9_\-]*|\.[a-zA-Z0-9_\-]*share[a-zA-Z0-9_\-]*)', content)
    if matches:
        print(f"=== {cf} ===")
        print("  Classes:", set(matches))
