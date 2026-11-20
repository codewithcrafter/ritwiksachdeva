import re

with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

classes = sorted(list(set(re.findall(r'class=["\']([^"\']+)["\']', text))))
all_cls = set()
for c in classes:
    for item in c.split():
        all_cls.add(item)

print(f"Total unique classes in services.html: {len(all_cls)}")
key_classes = [c for c in all_cls if any(k in c for k in ['subnav', 'service-', 'entry', 'deliverable', 'catalog', 'pricing', 'process'])]
print("Key service classes:")
for kc in sorted(key_classes):
    print(" -", kc)
