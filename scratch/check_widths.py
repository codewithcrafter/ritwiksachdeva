import re

for f in ['blog.html', 'blog.php']:
    with open(f, 'r', encoding='utf-8') as fp:
        lines = fp.readlines()
    print(f'=== {f} ===')
    for i, line in enumerate(lines, 1):
        if '860' in line or '720' in line or '620' in line or '480' in line:
            print(f'  L{i}: {line.strip()[:100]}')
