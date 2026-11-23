with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
sections = re.findall(r'<section[^>]*id=["\']([^"\']+)["\']', text)
print("Sections with IDs in services.html:", sections)

h2s = re.findall(r'<h2[^>]*>(.*?)</h2>', text, re.DOTALL)
print("H2s count:", len(h2s))
for i, h in enumerate(h2s):
    print(f"  {i}: {re.sub('<[^<]+?>', '', h).strip()}")
