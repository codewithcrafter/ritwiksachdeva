with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, l in enumerate(lines[80:150]):
    print(f"{i+80}: {l.strip()}")
