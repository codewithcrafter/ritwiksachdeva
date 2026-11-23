import re

for fname in ['blog.html', 'blog.php', 'blog-detail.php', 'blog-ai-in-business.html']:
    with open(fname, 'r', encoding='utf-8') as f:
        text = f.read()
    css_links = re.findall(r'<link rel="stylesheet"[^>]*href="([^"]+)"', text)
    js_scripts = re.findall(r'<script[^>]*src="([^"]+)"', text)
    print(f"=== {fname} ===")
    print("  CSS:", css_links)
    print("  JS:", js_scripts)
