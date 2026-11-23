with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re

# Find the main tag or wrapper
pos_header = text.find('<header class="article-header">')
pos_end_header = text.find('</header>', pos_header)
print("=== ARTICLE HEADER HTML ===")
print(text[pos_header:pos_end_header+9])

pos_body = text.find('<!-- ARTICLE BODY -->')
pos_end_body = text.find('<!-- RELATED ARTICLES -->')
if pos_end_body == -1:
    pos_end_body = text.find('<!-- FOOTER -->')
print("\n=== ARTICLE BODY HTML (FIRST 1200 CHARS) ===")
print(text[pos_body:pos_body+1200])
