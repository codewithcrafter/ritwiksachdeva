import re

with open('service-ecommerce-management.html', 'r', encoding='utf-8') as f:
    c = f.read()

# Replace <section style="width:100%; padding:50px 24px; background:#ffffff; ..."> with clean <section class="rs-ecom-section">
# and <div style="max-width:1200px; margin:0 auto; ..."> with <div class="rs-ecom-container">
pattern_section = re.compile(r'<section\s+style="[^"]*width:\s*100%[^"]*"', re.IGNORECASE)
matches = pattern_section.findall(c)
print(f"Found {len(matches)} full-width inline styled sections")

# We can replace the inline style on these sections to use background:transparent; padding:48px 0; border-bottom:1px solid var(--border-color);
clean_c = re.sub(
    r'<section\s+style="\s*width:\s*100%;\s*padding:\s*50px\s+24px;\s*background:\s*#ffffff;[^"]*"',
    r'<section class="rs-ecom-section" style="padding:48px 0; background:transparent; border-bottom:1px solid var(--border-color);"',
    c
)

# And inside the sections, remove inline max-width:1200px since the parent .ecom-page-wrapper is already max-width:1200px
clean_c = re.sub(
    r'<div\s+style="\s*max-width:\s*1200px;\s*margin:\s*0\s+auto;\s*box-sizing:\s*border-box;\s*"',
    r'<div class="rs-ecom-container"',
    clean_c
)

if clean_c != c:
    with open('service-ecommerce-management.html', 'w', encoding='utf-8') as f:
        f.write(clean_c)
    print("SUCCESS: cleaned full-width inline styles in service-ecommerce-management.html")
else:
    print("No changes made")
