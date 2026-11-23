with open('index.html', 'r', encoding='utf-8') as f:
    c = f.read()
pos = c.find('</footer>')
print(c[pos:pos+1500])
