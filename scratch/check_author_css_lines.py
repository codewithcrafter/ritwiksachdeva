with open('css/blog.css', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, l in enumerate(lines):
    if any(k in l for k in ['author-bar', 'author-info', 'share-buttons', 'share-btn', 'author-avatar']):
        print(f"Line {i+1}: {l.strip()}")
