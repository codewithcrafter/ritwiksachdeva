import glob

files = sorted(glob.glob('*.html') + glob.glob('*.php'))

for f in files:
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    
    orig = c
    c = c.replace('consult@ritwiksachdeva.com', 'Info@ritwiksachdeva.in')
    c = c.replace('https://wa.me/919876543210', 'https://wa.me/919289626986')
    c = c.replace('tel:+919876543210', 'tel:+919289626986')
    c = c.replace('+91 98765 43210', '+91 92896 26986')
    c = c.replace('+919876543210', '+919289626986')
    
    if c != orig:
        with open(f, 'w', encoding='utf-8') as fp:
            fp.write(c)
        print(f"Updated remaining stale links in {f}")

print("Done fixing remaining stale links.")
