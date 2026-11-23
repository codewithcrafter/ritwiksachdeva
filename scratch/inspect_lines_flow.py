import json

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    raw_services = json.load(f)

for slug in ['freelance-graphic-designer-in-delhi', 'ppc-expert-in-delhi', 'seo-expert-in-delhi', 'website-designer-in-delhi']:
    print(f"\n==========================================")
    print(f"SLUG: {slug}")
    lines = [l.strip() for l in raw_services[slug].split('\n') if l.strip()]
    for i, l in enumerate(lines[:35]):
        print(f"{i:2d}: {l}")
