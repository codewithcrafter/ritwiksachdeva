import os
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

print("=== CHECKING FOR OVERFLOW RISKS & ELEMENT SIZING ===")

issues = []

for f in FILES:
    with open(f, 'r', encoding='utf-8') as fp:
        html = fp.read()
    
    # Check for hardcoded fixed width > 400px in inline styles
    fixed_widths = re.findall(r'style="[^"]*width:\s*(\d{3,4})px[^"]*"', html)
    large_widths = [int(w) for w in fixed_widths if int(w) > 400]
    if large_widths:
        issues.append(f"{f}: Hardcoded fixed width in style: {large_widths}")

    # Check for images without responsive sizing
    img_tags = re.findall(r'<img\s+[^>]*>', html)
    for img in img_tags:
        if 'width=' in img and 'px' in img:
            issues.append(f"{f}: Hardcoded img width: {img}")

    # Check pre/code blocks
    if '<pre>' in html or '<pre ' in html:
        # Check if pre is inside article-prose
        pass

    # Check header structure
    if 'header-top-bar' not in html:
        issues.append(f"{f}: Missing header-top-bar")
    
    if '10 Services' not in html:
        issues.append(f"{f}: Missing 10 Services dropdown")
        
    if 'consultation-popup' not in html:
        issues.append(f"{f}: Missing consultation-popup")

if not issues:
    print("[PASS] No fixed width or unconstrained overflow issues found in any blog page!")
else:
    for issue in issues:
        print(f"[WARN] {issue}")

print("\n=== CHECKING CSS RULES IN css/blog.css ===")
with open('css/blog.css', 'r', encoding='utf-8') as f:
    blog_css = f.read()

css_checks = [
    ('Fluid Gutter clamp(24px, 4cm, 64px)', 'clamp(24px, 4cm, 64px)' in blog_css),
    ('Mobile Gutter 20px in media query', '--blog-gutter: 20px' in blog_css),
    ('Article Header Container padding', '.article-header > .container' in blog_css),
    ('Author Bar Display Flex', '.article-author-bar {\n  display: flex;' in blog_css),
    ('Author Avatar dimensions', '.article-author-avatar' in blog_css),
    ('Share Buttons styling', '.share-btn' in blog_css),
    ('Featured Media controlled aspect ratio', 'aspect-ratio: 16 / 9' in blog_css),
    ('Featured Media max height', 'max-height: 480px' in blog_css),
    ('Featured Media mobile natural height', 'max-height: none' in blog_css and 'aspect-ratio: auto' in blog_css),
    ('Blog Card flex column', 'display: flex;\n  flex-direction: column;\n  height: 100%' in blog_css),
    ('Blog Card Media aspect ratio 16/10', 'aspect-ratio: 16 / 10' in blog_css),
    ('Blog Card Title 2-line clamp', '-webkit-line-clamp: 2' in blog_css),
    ('Blog Card Excerpt 3-line clamp', '-webkit-line-clamp: 3' in blog_css),
    ('Blog Card Footer margin-top auto', 'margin-top: auto' in blog_css),
    ('No 3D tilt in CSS', 'transform-style: preserve-3d' not in blog_css and 'perspective' not in blog_css),
    ('Sticky TOC top calc with header height', 'calc(var(--header-height, 106px) + 24px)' in blog_css),
    ('Scroll margin top on headings', 'scroll-margin-top: calc(var(--header-height, 106px) + 28px)' in blog_css),
]

all_css_ok = True
for name, passed in css_checks:
    status = "[PASS]" if passed else "[FAIL]"
    if not passed:
        all_css_ok = False
    print(f"{status} {name}")

print(f"\nOverall CSS Status: {'ALL PASSED' if all_css_ok else 'SOME FAILED'}")
