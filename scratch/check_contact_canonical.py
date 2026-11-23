with open('contact.html', 'r', encoding='utf-8') as f:
    for i, line in enumerate(f, 1):
        if '92896' in line or 'Info@' in line:
            print(f"Line {i}: {line.strip()}")
