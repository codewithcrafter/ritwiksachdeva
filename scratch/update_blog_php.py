with open('blog.php', 'r', encoding='utf-8') as f:
    c = f.read()

c = c.replace("href=\"<?= SITE_URL ?>/blog.php<?= $currentCategory ? '?category=' . urlencode($currentCategory) : '' ?>\"", "href=\"<?= SITE_URL ?>/blog/<?= $currentCategory ? '?category=' . urlencode($currentCategory) : '' ?>\"")
c = c.replace('content="<?= SITE_URL ?>/blog.php"', 'content="<?= SITE_URL ?>/blog/"')
c = c.replace('href="blog.php"', 'href="/blog/"')
c = c.replace('href="blog.php?category=', 'href="/blog/?category=')
c = c.replace('action="blog.php"', 'action="/blog/"')
c = c.replace('blog-detail.php?slug=<?= urlencode($featuredBlog[\'slug\']) ?>', '/blog/<?= urlencode($featuredBlog[\'slug\']) ?>/')
c = c.replace('blog-detail.php?slug=<?= urlencode($blog[\'slug\']) ?>', '/blog/<?= urlencode($blog[\'slug\']) ?>/')

with open('blog.php', 'w', encoding='utf-8') as f:
    f.write(c)

print("blog.php updated.")
