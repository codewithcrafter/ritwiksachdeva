with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
matches = [m.start() for m in re.finditer(r'author', text, re.I)]
print("Author occurrences:", len(matches))
for m in matches[:5]:
    print("---------------------------------")
    print(text[max(0, m-50):m+300])
