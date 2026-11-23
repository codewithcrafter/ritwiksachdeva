with open('css/style.css', 'r', encoding='utf-8') as f:
    text = f.read()

pos = text.find('.header-top-bar')
if pos != -1:
    print(text[pos:pos+1500])
else:
    print("Not found .header-top-bar in css/style.css")
