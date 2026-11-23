with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# find all id="..."
ids = re.findall(r'<div[^>]*class="service-premium-card"[^>]*id="([^"]+)"', text)
print("service-premium-card IDs in services.html:", ids)

if not ids:
    # let's find any cards
    cards = re.findall(r'id="([^"]+)"[^>]*class="[^"]*service', text)
    print("service elements with IDs:", cards)
    
# Let's search for "ecommerce" in services.html
pos = text.find('ecommerce')
while pos != -1:
    print("Found 'ecommerce' at pos:", pos)
    print(text[max(0, pos-40):pos+120])
    pos = text.find('ecommerce', pos+120)
