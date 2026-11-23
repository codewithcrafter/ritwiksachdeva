import re

with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

pos = text.find('nav-dropdown-list')
if pos != -1:
    end = text.find('</div', pos + 1000)
    print("=== NAV DROPDOWN ITEMS ===")
    print(text[pos:pos+1500])

pos_m = text.find('mobile-submenu')
if pos_m != -1:
    print("=== MOBILE SUBMENU ITEMS ===")
    print(text[pos_m:pos_m+800])
