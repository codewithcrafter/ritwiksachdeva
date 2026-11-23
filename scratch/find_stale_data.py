import glob
import re

files = sorted(glob.glob('*.html') + glob.glob('*.php'))

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    stale_email = 'consult@ritwiksachdeva.com' in c
    stale_phone = '98765 43210' in c or '9876543210' in c
    raw_svg_text = bool(re.search(r'(svgInfo|Servicessvg|Let\'s Talksvg|svg\+91)', c))
    joined_brand = bool(re.search(r'Ritwik Sachdeva\s*Marketing Consultant', c))
    
    issues = []
    if stale_email: issues.append('stale_email')
    if stale_phone: issues.append('stale_phone')
    if raw_svg_text: issues.append('raw_svg_text')
    
    if issues:
        print(f"{f:35}: {issues}")
print("Check complete.")
