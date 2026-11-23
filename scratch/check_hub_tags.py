with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
print("Header search:", bool(re.search(r'<header class="site-header"', text)))
print("Footer search:", bool(re.search(r'<footer class="site-footer"', text)))
