import re

with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

cards = re.findall(r'<a href="([^"]+)" class="arch-ledger-card".*?<h3[^>]*>(.*?)</h3>', text, re.DOTALL)
print("Ledger cards in index.html:", len(cards))
for href, title in cards:
    print(f"  - {href}: {title.strip()}")
