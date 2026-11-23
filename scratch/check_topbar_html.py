with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    text = f.read()

pos = text.find('header-top-bar')
print("In blog-ai-in-business.html:")
print(text[pos:pos+700])
