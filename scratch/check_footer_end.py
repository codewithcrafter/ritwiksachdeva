import re

for filename in ['index.html', 'services.html', 'contact.html', 'blog.html']:
    with open(filename, 'r', encoding='utf-8') as f:
        c = f.read()
    footer_pos = c.find('<footer class="site-footer"')
    if footer_pos != -1:
        print(f"=== {filename} FOOTER TO END (first 500 chars) ===")
        print(c[footer_pos:footer_pos+500])
