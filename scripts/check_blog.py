import urllib.request, re

for page in ['blog.html', 'blog.php']:
    res = urllib.request.urlopen(f'http://localhost:8000/{page}').read().decode('utf-8')
    articles = re.findall(r'href="([^"]*(?:blog-|\?slug=)[^"]*)"', res)
    print(f"Articles on {page}:", set(articles))
