import glob

files = sorted(glob.glob('*.html') + glob.glob('*.php'))
missing = []
for f in files:
    if f == 'router.php': continue
    c = open(f, encoding='utf-8').read()
    if '<base href="/"' not in c and "<base href='/'" not in c:
        missing.append(f)
print("Missing <base href=\"/\"> in:", missing)
