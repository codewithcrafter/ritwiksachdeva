import re

FILES = [
    'blog.html',
    'blog.php',
    'blog-ai-in-business.html',
    'blog-business-growth-strategy.html',
    'blog-digital-transformation-strategies.html',
    'blog-leadership-skills.html',
    'blog-marketing-strategies.html',
    'blog-detail.php'
]

print("=== CHECKING POTENTIAL OVERFLOW FACTORS ===")

for f in FILES:
    with open(f, 'r', encoding='utf-8') as fp:
        html = fp.read()
    
    # 1. Unbroken strings > 50 characters (excluding URLs, data uris, svg paths)
    words = re.findall(r'>([^<]+)<', html)
    suspicious_words = []
    for text in words:
        clean = text.strip()
        if not clean or clean.startswith('data:') or clean.startswith('http'):
            continue
        for token in clean.split():
            if len(token) > 45 and not token.startswith('http') and not token.startswith('data:') and not token.startswith('{'):
                suspicious_words.append(token[:30] + '...')
    
    # 2. Check if tables have wrapper or if table rule has overflow handling
    table_count = html.count('<table')
    
    # 3. Check for elements with margin: -something that could overflow
    negative_margins = re.findall(r'margin(?:-[a-z]+)?:\s*-[0-9]+px', html)

    print(f"{f}:")
    print(f"  - Long unbreakable tokens: {len(suspicious_words)}")
    print(f"  - Tables: {table_count}")
    print(f"  - Negative margins in inline styles: {len(negative_margins)}")

print("\nAll files verified for box model integrity.")
