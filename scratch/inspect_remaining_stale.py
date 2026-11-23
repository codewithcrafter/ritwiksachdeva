import glob

files = sorted(glob.glob('*.html') + glob.glob('*.php'))

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        lines = fp.readlines()
    for i, line in enumerate(lines, 1):
        if 'consult@ritwiksachdeva.com' in line:
            print(f"{f}:{i}: email -> {line.strip()[:100]}")
        if '98765 43210' in line or '9876543210' in line:
            print(f"{f}:{i}: phone -> {line.strip()[:100]}")
