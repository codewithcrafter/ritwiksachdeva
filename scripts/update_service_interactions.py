import glob
import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

service_files = [
    'services.html',
    'service-best-marketing-consultant.html',
    'service-ecommerce-management.html',
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-seo-expert.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-website-designer.html'
]

for sf in service_files:
    if not os.path.exists(sf):
        continue
    with open(sf, 'r', encoding='utf-8') as f:
        content = f.read()

    modified = False
    # Ensure animations.css is present
    if 'css/animations.css' not in content:
        content = content.replace('css/services.css">', 'css/services.css">\n  <link rel="stylesheet" href="css/animations.css">')
        modified = True

    # Ensure js/interactions.js is present
    if 'js/interactions.js' not in content:
        if '<script src="js/animations.js"></script>' in content:
            content = content.replace('<script src="js/animations.js"></script>', '<script src="js/animations.js"></script>\n  <script src="js/interactions.js" defer></script>')
            modified = True
        elif '<script src="js/animations.js" defer></script>' in content:
            content = content.replace('<script src="js/animations.js" defer></script>', '<script src="js/animations.js" defer></script>\n  <script src="js/interactions.js" defer></script>')
            modified = True
        elif '</body>' in content:
            content = content.replace('</body>', '  <script src="js/interactions.js" defer></script>\n</body>')
            modified = True

    if modified:
        with open(sf, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Updated {sf}")
    else:
        print(f"No change needed for {sf}")
