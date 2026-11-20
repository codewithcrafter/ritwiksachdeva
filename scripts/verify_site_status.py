import glob
import os
import re
import urllib.request

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

pages = [
    'index.html',
    'about.html',
    'services.html',
    'contact.html',
    'blog.php',
    'service-ecommerce-management.html'
]

print("--- CSS / JS Links in Key Pages ---")
for p in pages:
    if not os.path.exists(p):
        print(f"MISSING: {p}")
        continue
    with open(p, 'r', encoding='utf-8') as f:
        html = f.read()
    css_files = re.findall(r'href=["\']([^"\']+\.css[^"\']*)["\']', html)
    js_files = re.findall(r'src=["\']([^"\']+\.js[^"\']*)["\']', html)
    print(f"\n[{p}]")
    print(f"  CSS: {css_files}")
    print(f"  JS: {js_files}")

# Check HTTP status of dev server
endpoints = [
    'http://localhost:8000/',
    'http://localhost:8000/index.html',
    'http://localhost:8000/about.html',
    'http://localhost:8000/services.html',
    'http://localhost:8000/contact.html',
    'http://localhost:8000/service-ecommerce-management.html',
    'http://localhost:8000/blog.php'
]

print("\n--- HTTP Server Response Checks ---")
for url in endpoints:
    try:
        req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, timeout=5) as resp:
            print(f"  {url} => HTTP {resp.status}")
    except Exception as e:
        print(f"  {url} => ERROR: {e}")
