with open('js/main.js', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, l in enumerate(lines, 1):
    for target in ['index.html', 'about.html', 'services.html', 'blog.html', 'blog.php', 'contact.html']:
        if target in l:
            print(f"Line {i}: {l.strip()[:100]}")
