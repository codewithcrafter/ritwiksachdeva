import re

with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

items = re.findall(r'<a href="(service-[^"]+)" class="nav-dropdown-item"[^>]*>(.*?)</a>', text, re.DOTALL)
print(f"Total nav dropdown items in index.html: {len(items)}")
for url, body in items:
    title_m = re.search(r'class="dropdown-item-title">([^<]+)<', body)
    title = title_m.group(1) if title_m else 'No title'
    print(f"  - {url}: {title}")
