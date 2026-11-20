import glob
import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

html_files = glob.glob("*.html") + glob.glob("*.php")
missing_interactions = []

for f in sorted(html_files):
    if f.startswith('admin') or f.startswith('test'):
        continue
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    if 'js/interactions.js' not in c and 'interactions.js' not in c:
        missing_interactions.append(f)

print(f"Files without interactions.js ({len(missing_interactions)}):")
for mf in missing_interactions:
    print(" -", mf)
