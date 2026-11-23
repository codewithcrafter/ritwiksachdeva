with open('blog.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
cards = re.findall(r'(<article class="blog-card.*?</article>)', text, re.DOTALL)
if cards:
    print(cards[0])
