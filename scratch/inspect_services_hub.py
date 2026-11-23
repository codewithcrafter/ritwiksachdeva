import re

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

links = re.findall(r'href=["\'](service-[^"\']+)["\']', text)
print('Total links in services.html:', len(links))
print('Unique links:')
for l in sorted(list(set(links))):
    print(' -', l)
