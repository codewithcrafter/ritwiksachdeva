with open('blog-ai-in-business.html', 'r', encoding='utf-8') as f:
    text = f.read()

pos = text.find('class="article-author-bar"')
if pos != -1:
    pos_end = text.find('class="article-featured-media"')
    print(text[pos-10:pos_end+200])
