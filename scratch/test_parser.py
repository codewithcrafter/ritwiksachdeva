import json, re

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    raw_services = json.load(f)

print(f"Total raw services: {len(raw_services)}")

for slug, content in raw_services.items():
    print(f"\n=======================================================")
    print(f"SERVICE: {slug}")
    lines = [l.strip() for l in content.split('\n') if l.strip()]
    
    # 1. Title / H1
    # Find line with '— Ritwik Sachdeva' or '| Ritwik Sachdeva'
    title = ""
    for l in lines[:15]:
        if 'Ritwik Sachdeva' in l and ('—' in l or '|' in l or 'Consultant' in l) and not l.startswith('['):
            title = l
            break
    if not title:
        title = lines[6]
    print(f"Title: {title}")
    
    # 2. Hero lead
    lead = ""
    for l in lines[:15]:
        if len(l) > 100 and not l.startswith('[') and l != title:
            lead = l
            break
    print(f"Lead: {lead[:90]}...")
    
    # 3. Headings
    headings = []
    for i, l in enumerate(lines):
        if l.startswith('[') or l.startswith('©') or l.startswith('Info@') or l.startswith('http'):
            continue
        if len(l) < 80 and not l.endswith('.') and not l.endswith('?') and not l.endswith(':'):
            headings.append((i, l))
    print(f"Found {len(headings)} candidate headings")
    for idx, h in headings[:8]:
        print(f"  - ({idx}) {h}")
