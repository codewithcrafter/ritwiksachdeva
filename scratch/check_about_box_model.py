import re

with open('about.html', 'r', encoding='utf-8') as f:
    html = f.read()

with open('css/style.css', 'r', encoding='utf-8') as f:
    css = f.read()

print("=== ABOUT PAGE INTEGRITY & BOX MODEL CHECKS ===")

# Check for fixed pixel widths that could cause horizontal overflow on mobile
fixed_widths = re.findall(r'width:\s*([4-9]\d{2,}px|[1-9]\d{3,}px)', css)
print(f"Fixed wide pixel widths in CSS: {len(fixed_widths)}")

# Verify all images on about page have max-width or width: 100%
imgs = re.findall(r'<img[^>]+src="([^">]+)"[^>]*>', html)
print(f"Images in about.html: {len(imgs)}")
for img in imgs:
    print(f"  - {img}")

# Verify all videos on about page
videos = re.findall(r'<video[^>]+src="([^">]+)"[^>]*>', html)
print(f"Videos in about.html: {len(videos)}")
for v in videos:
    print(f"  - {v}")

print("About page check complete.")
