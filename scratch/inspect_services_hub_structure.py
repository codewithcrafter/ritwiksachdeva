import re

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Let's find occurrences of best-marketing-consultant
print("Occurrences of 'best-marketing-consultant':", text.count('best-marketing-consultant'))

# Let's find the card block for best-marketing-consultant
m = re.search(r'(<div class="service-premium-card reveal-on-scroll" id="best-marketing-consultant".*?</div>\s*</div>\s*</div>\s*</div>)', text, re.DOTALL)
if m:
    print("Found card block, len:", len(m.group(1)))
    print(m.group(1)[:200])
