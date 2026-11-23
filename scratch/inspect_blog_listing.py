with open('blog.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
featured_m = re.search(r'(<div class="featured-blog-card".*?</div>\s*</div>\s*</div>)', text, re.DOTALL)
if featured_m:
    print("=== FEATURED BLOG CARD ===")
    print(featured_m.group(1)[:800])

cards = re.findall(r'<article class="blog-card.*?>(.*?)</article>', text, re.DOTALL)
print(f"\nTotal blog cards in blog.html: {len(cards)}")
for i, c in enumerate(cards[:3]):
    print(f"--- Card {i+1} ---")
    print(c[:400])
