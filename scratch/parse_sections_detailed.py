import json, re

with open('scratch/services_raw.json', 'r', encoding='utf-8') as f:
    raw_services = json.load(f)

for slug, text in raw_services.items():
    print(f"\n==========================================")
    print(f"SLUG: {slug}")
    
    # Split by major headings or double newlines
    blocks = [b.strip() for b in text.split('\n\n') if b.strip()]
    print(f"Total blocks: {len(blocks)}")
    
    # Show first 5 blocks
    for i, b in enumerate(blocks[:6]):
        lines = b.split('\n')
        print(f"  Block {i}: ({len(lines)} lines) {lines[0][:80]}")
