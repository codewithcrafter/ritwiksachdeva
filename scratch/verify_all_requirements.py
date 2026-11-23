import glob
import re
import os

files = sorted(glob.glob('*.html') + glob.glob('*.php'))
print(f"=== COMPREHENSIVE VERIFICATION ACROSS {len(files)} FILES ===")

errors = []

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    # 1. Raw SVG text checks
    raw_patterns = [
        (r'svgInfo', 'Raw SVG text: svgInfo'),
        (r'Servicessvg', 'Raw SVG text: Servicessvg'),
        (r'Let\'s Talksvg', 'Raw SVG text: Let\'s Talksvg'),
        (r'svg\+91', 'Raw SVG text: svg+91'),
        (r'svg[A-Z0-9]', 'Potential unescaped svg prefix')
    ]
    for pat, desc in raw_patterns:
        m = re.search(pat, c)
        if m:
            errors.append(f"{f}: {desc} (match: '{m.group(0)}')")

    # 2. Check for old contact info
    if 'consult@ritwiksachdeva.com' in c:
        errors.append(f"{f}: Found stale email consult@ritwiksachdeva.com")
    if '9876543210' in c or '98765 43210' in c:
        errors.append(f"{f}: Found stale phone number 9876543210")

    # 3. Check for canonical contact info in top bar
    if not re.search(r'Available for Q1 Consulting &amp; Growth Audits', c):
        errors.append(f"{f}: Missing top bar status text 'Available for Q1 Consulting & Growth Audits'")
    if not re.search(r'href="mailto:Info@ritwiksachdeva.in"', c):
        errors.append(f"{f}: Missing canonical mailto:Info@ritwiksachdeva.in")
    if not re.search(r'href="tel:\+919289626986"', c):
        errors.append(f"{f}: Missing canonical tel:+919289626986")

    # 4. Check for floating actions container with id="rs-floating-actions"
    if not re.search(r'id="rs-floating-actions"', c):
        errors.append(f"{f}: Missing id='rs-floating-actions' in floating actions container")

    # 5. Check for WhatsApp link
    if not re.search(r'https://wa.me/919289626986', c):
        errors.append(f"{f}: Missing canonical WhatsApp link https://wa.me/919289626986")

    # 6. Check for separated brand-name and brand-title spans
    if not re.search(r'<span class="brand-name">Ritwik Sachdeva</span>\s*<span class="brand-title">Marketing Consultant</span>', c):
        errors.append(f"{f}: Missing properly separated brand name and title spans")

    # 7. Check for Services dropdown toggle with span
    if not re.search(r'<span>Services</span>\s*<svg class="dropdown-arrow"', c):
        errors.append(f"{f}: Missing <span>Services</span> with dropdown arrow SVG")

# Specific checks for about.html
with open('about.html', 'r', encoding='utf-8') as f:
    about_c = f.read()

if 'legacy-about-content' in about_c:
    errors.append("about.html: Still contains legacy-about-content")

if 'Untitled-design-3.webp' not in about_c:
    errors.append("about.html: Missing portrait image Untitled-design-3.webp")

# Process steps 01-04
for step in ['01', '02', '03', '04']:
    if f'<span>{step}</span>' not in about_c:
        errors.append(f"about.html: Missing process step {step}")

# 5 Brand logos
for logo in ['logo-1.png', 'download-1.png', 'delhi-6-final-png.png', 'printex-90x90-1.webp', 'download.jpg']:
    if logo not in about_c:
        errors.append(f"about.html: Missing brand logo {logo}")

# 2 Videos
for video in ['0109.mp4', 'SANJEEV-FEEDBACK-.mp4']:
    if video not in about_c:
        errors.append(f"about.html: Missing video {video}")

# Check CSS
with open('css/style.css', 'r', encoding='utf-8') as f:
    css_c = f.read()

if 'padding-inline: 4cm' in css_c:
    errors.append("css/style.css: Still contains padding-inline: 4cm on .about-page .container")

if '.about-brand-card img' in css_c:
    # Check if brand card initial opacity is strictly 0 (invisible)
    m = re.search(r'\.about-brand-card img\s*\{[^}]*opacity:\s*0\s*(!important)?\s*;', css_c)
    if m:
        errors.append("css/style.css: .about-brand-card img has opacity: 0 (completely invisible) on initial state")

if errors:
    print(f"\nFound {len(errors)} error(s):")
    for e in errors:
        print(f"  - {e}")
else:
    print("\nALL VERIFICATION CHECKS PASSED PERFECTLY! (0 errors across 23 files)")
