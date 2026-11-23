import re

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

dropdown_count = len(re.findall(r'class="nav-dropdown-item', text))
mobile_count = len(re.findall(r'class="mobile-sublink', text))
cards_count = len(re.findall(r'class="service-premium-card', text))
best_count = text.count('best-marketing-consultant')

print(f"services.html verification:")
print(f"  Dropdown items: {dropdown_count} (expected 10)")
print(f"  Mobile sublinks: {mobile_count} (expected 10)")
print(f"  Catalog cards: {cards_count} (expected 10)")
print(f"  best-marketing-consultant references: {best_count} (expected 0)")
