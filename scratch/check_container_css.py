with open('css/style.css', 'r', encoding='utf-8') as f:
    text = f.read()

import re
matches = [m.start() for m in re.finditer(r'\.container\b', text)]
print("Container occurrences in css/style.css:", len(matches))
for m in matches[:6]:
    print("------------------")
    print(text[m:m+250])
