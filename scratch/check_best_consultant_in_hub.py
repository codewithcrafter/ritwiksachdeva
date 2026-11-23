with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
matches = [m.start() for m in re.finditer(r'best-marketing-consultant', text)]
print("Total occurrences of best-marketing-consultant in services.html:", len(matches))
for m in matches:
    print("---------------------------------")
    print(text[m-30:m+150])
