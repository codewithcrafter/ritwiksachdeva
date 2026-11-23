with open('css/blog.css', 'r', encoding='utf-8') as f:
    text = f.read()

print(f"css/blog.css total lines: {len(text.splitlines())}")
print(f"css/blog.css total bytes: {len(text)}")

# Let's see some key rules in css/blog.css
import re
selectors = re.findall(r'^([.#a-zA-Z0-9_\-\s,:]+)\s*\{', text, re.MULTILINE)
print(f"Total selectors: {len(selectors)}")
print("Sample selectors:")
for s in selectors[:30]:
    s_clean = s.strip().replace('\n', ' ')
    if s_clean and not s_clean.startswith('@'):
        print(" -", s_clean[:60])
