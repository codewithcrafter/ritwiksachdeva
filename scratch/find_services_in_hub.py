with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
matches = [m.start() for m in re.finditer(r'service-', text)]
print("Total occurrences of 'service-' in services.html:", len(matches))
for m in matches[:10]:
    print("----------------")
    print(text[m-20:m+120])
