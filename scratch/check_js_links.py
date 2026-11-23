import glob
import re

files = glob.glob('js/*.js')
for f in files:
    c = open(f, encoding='utf-8').read()
    matches = re.findall(r'["\']([^"\']*\.(?:html|php)[^"\']*)["\']', c)
    if matches:
        print(f"{f}: {matches}")
