import re

with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Find header
header_match = re.search(r'(<header class="site-header".*?</header>)', text, re.DOTALL)
if header_match:
    print("Found header in index.html, len:", len(header_match.group(1)))

# Find mobile drawer
drawer_match = re.search(r'(<div class="mobile-drawer".*?</div>\s*</div>)', text, re.DOTALL)
if drawer_match:
    print("Found mobile drawer in index.html, len:", len(drawer_match.group(1)))

# Find footer
footer_match = re.search(r'(<footer class="site-footer".*?</footer>)', text, re.DOTALL)
if footer_match:
    print("Found footer in index.html, len:", len(footer_match.group(1)))

# Find popup
popup_match = re.search(r'(<div class="consultation-popup-overlay".*?</div>\s*</div>)', text, re.DOTALL)
if popup_match:
    print("Found popup in index.html, len:", len(popup_match.group(1)))

# Find floating actions
float_match = re.search(r'(<div class="floating-actions-container".*?</div>)', text, re.DOTALL)
if float_match:
    print("Found floating actions in index.html, len:", len(float_match.group(1)))
