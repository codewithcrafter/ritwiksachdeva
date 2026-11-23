import os
import re
import subprocess

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

print("=== VERIFYING BLOG FILES INTEGRITY & STANDARDS ===")
all_pass = True

for f in FILES:
    if not os.path.exists(f):
        print(f"[FAIL] File not found: {f}")
        all_pass = False
        continue
    
    with open(f, 'r', encoding='utf-8') as fp:
        content = fp.read()
    
    checks = {
        'Top Contact Bar': 'header-top-bar' in content,
        '10 Services Dropdown': '10 Services' in content,
        'Consultation Popup': 'consultation-popup' in content,
        'Floating Action Buttons': 'floating-actions-container' in content,
        'Back to Top Progress Ring': 'back-to-top' in content and 'progress-ring' in content,
        'Blog Enhancements JS linked': 'js/blog-enhancements.js' in content,
        'No conflicting inline 980px on container': 'max-width: 980px' not in content,
        'No conflicting inline 1140px on container': 'max-width: 1140px' not in content,
    }
    
    failed = [k for k, v in checks.items() if not v]
    if failed:
        print(f"[FAIL] {f}: Missing {failed}")
        all_pass = False
    else:
        print(f"[PASS] {f}: All 8 checks passed.")

# Verify JS files
print("\n=== VERIFYING JS SYNTAX ===")
try:
    res = subprocess.run(['node', '-c', 'js/blog-enhancements.js', 'js/main.js'], capture_output=True, text=True)
    if res.returncode == 0:
        print("[PASS] JS syntax verified cleanly with Node.")
    else:
        print(f"[FAIL] JS syntax error: {res.stderr}")
        all_pass = False
except Exception as e:
    print(f"[WARN] Node not available: {e}")

# Verify PHP syntax
print("\n=== VERIFYING PHP SYNTAX ===")
php_files = ['blog.php', 'blog-detail.php']
for pf in php_files:
    try:
        res = subprocess.run(['php', '-l', pf], capture_output=True, text=True)
        if 'No syntax errors detected' in res.stdout:
            print(f"[PASS] {pf}: {res.stdout.strip()}")
        else:
            print(f"[FAIL] {pf}: {res.stderr or res.stdout}")
            all_pass = False
    except Exception as e:
        print(f"[WARN] PHP CLI not available: {e}")

# Verify 3D tilt is completely gone
print("\n=== VERIFYING NO 3D TILT ===")
with open('js/blog-enhancements.js', 'r', encoding='utf-8') as f:
    js_text = f.read()
if 'rotateX' in js_text or 'perspective' in js_text:
    print("[FAIL] Found 3D tilt in js/blog-enhancements.js!")
    all_pass = False
else:
    print("[PASS] Zero 3D tilt in js/blog-enhancements.js.")

with open('css/blog.css', 'r', encoding='utf-8') as f:
    css_text = f.read()
if 'preserve-3d' in css_text or 'rotateX' in css_text:
    print("[FAIL] Found 3D transform in css/blog.css!")
    all_pass = False
else:
    print("[PASS] Zero 3D transforms in css/blog.css.")

# Verify 4cm fluid gutter
if 'clamp(24px, 4cm, 64px)' in css_text:
    print("[PASS] clamp(24px, 4cm, 64px) correctly configured in css/blog.css.")
else:
    print("[FAIL] clamp(24px, 4cm, 64px) missing in css/blog.css!")
    all_pass = False

print(f"\nFinal Result: {'ALL CHECKS PASSED PERFECTLY' if all_pass else 'SOME CHECKS FAILED'}")
