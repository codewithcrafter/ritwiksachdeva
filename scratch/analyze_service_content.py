import json, re

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    raw = json.load(f)

for slug, content in raw.items():
    print(f"\n=======================================================")
    print(f"ANALYZE: {slug}")
    print(f"=======================================================")
    lines = [l.strip() for l in content.split('\n') if l.strip()]
    
    # Let's inspect headings and structure
    for i, l in enumerate(lines):
        # detect sections
        if l.startswith('[') and l.endswith(')'):
            continue
        if len(l) < 70 and not l.endswith('.') and not l.startswith('©'):
            # might be a heading
            print(f"  Line {i}: {l}")
