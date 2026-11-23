import re

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Find service cards in services.html
cards = re.findall(r'<div class="service-premium-card".*?</div>\s*</div>\s*</div>', text, re.DOTALL)
print("Total service cards in services.html:", len(cards))

headers = re.findall(r'<h2 class="service-heading">(.*?)</h2>', text)
print("Headers in services.html:", len(headers))
for i, h in enumerate(headers):
    print(f" {i+1}: {h.strip()}")
