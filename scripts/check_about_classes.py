import re

with open('about.html', 'r', encoding='utf-8') as f:
    text = f.read()

classes = sorted(list(set(re.findall(r'class=["\']([^"\']+)["\']', text))))
all_cls = set()
for c in classes:
    for item in c.split():
        all_cls.add(item)

print(f"Total unique classes in about.html: {len(all_cls)}")
for c in sorted(all_cls):
    print(" -", c)
