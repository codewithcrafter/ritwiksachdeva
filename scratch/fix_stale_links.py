import glob, re

# Check form actions
print("=== Form actions check ===")
for p in sorted(glob.glob('*.html') + glob.glob('*.php')):
    if p in ['router.php']:
        continue
    with open(p, 'r', encoding='utf-8') as f:
        c = f.read()
    actions = re.findall(r'<form[^>]*action=["\']([^"\']+)["\']', c, re.IGNORECASE)
    for a in actions:
        if 'contact' in a or 'blog' in a:
            print(f"{p}: form action = {a}")

# 1. In blog.html, replace action="blog.php" with action="/blog/"
with open('blog.html', 'r', encoding='utf-8') as f:
    content = f.read()
if 'action="blog.php"' in content:
    content = content.replace('action="blog.php"', 'action="/blog/"')
    with open('blog.html', 'w', encoding='utf-8') as f:
        f.write(content)
    print("Fixed blog.html: action='blog.php' -> action='/blog/'")

# 2. In service-best-marketing-consultant.html, check the form action
with open('service-best-marketing-consultant.html', 'r', encoding='utf-8') as f:
    content = f.read()
if 'action="contact.html"' in content:
    # check if other forms use api/contact.php or /contact/
    # Usually strategy-booking-form submits to api/contact.php
    print("Found action='contact.html' in service-best-marketing-consultant.html")
