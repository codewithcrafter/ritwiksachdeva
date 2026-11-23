with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
# Print sections and classes
header_m = re.search(r'(<header class="article-header".*?</header>)', text, re.DOTALL)
if header_m:
    print("=== ARTICLE HEADER ===")
    print(header_m.group(1)[:1500])

media_m = re.search(r'(<div class="article-featured-media".*?</div>)', text, re.DOTALL)
if media_m:
    print("=== FEATURED MEDIA ===")
    print(media_m.group(1))

grid_m = re.search(r'(<div class="article-layout-grid".*?)(?=<footer)', text, re.DOTALL)
if grid_m:
    print("=== LAYOUT GRID (start) ===")
    print(grid_m.group(1)[:1500])
