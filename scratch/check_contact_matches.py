with open('contact.html', 'r', encoding='utf-8') as f:
    c = f.read()

import re
matches = re.findall(r'(\+91[0-9\s-]+|Info@[a-zA-Z0-9.-]+|consult@[a-zA-Z0-9.-]+)', c)
print(set(matches))
