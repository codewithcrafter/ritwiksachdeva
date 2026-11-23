with open('css/style.css', 'r', encoding='utf-8') as f:
    text = f.read()

pos = text.find('.header-top-bar')
print(text[pos:pos+1000])
