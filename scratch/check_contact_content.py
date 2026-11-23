with open('contact.html', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, line in enumerate(lines, 1):
    if 'consult@ritwiksachdeva.com' in line or '98765' in line:
        print(f"Line {i}: {line.strip()}")
