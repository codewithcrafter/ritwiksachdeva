with open('services.html', 'r', encoding='utf-8') as f:
    lines = f.readlines()

for idx, line in enumerate(lines):
    if 'service-best-marketing-consultant.html' in line or 'best-marketing-consultant' in line:
        print(f"Line {idx+1}: {line.strip()[:100]}")
