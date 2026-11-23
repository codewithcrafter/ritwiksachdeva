with open('blog-detail.php', 'r', encoding='utf-8') as f:
    c = f.read()

c = c.replace("header('Location: blog.php');", "header('Location: /blog/', true, 301);")
c = c.replace('<a href="blog.php" class="btn btn-primary">Return to Blog</a>', '<a href="/blog/" class="btn btn-primary">Return to Blog</a>')
c = c.replace("(SITE_URL . '/blog-detail.php?slug=' . urlencode($blog['slug']))", "(SITE_URL . '/blog/' . urlencode($blog['slug']) . '/')")
c = c.replace('<a href="blog.php" class="mobile-link active">Blog</a>', '<a href="/blog/" class="mobile-link active">Blog</a>')
c = c.replace('<a href="blog.php">Blog</a>', '<a href="/blog/">Blog</a>')
c = c.replace('<a href="blog.php?category=<?= urlencode($blog[\'category_slug\']) ?>"><?= e($blog[\'category_name\']) ?></a>', '<a href="/blog/?category=<?= urlencode($blog[\'category_slug\']) ?>"><?= e($blog[\'category_name\']) ?></a>')
c = c.replace("$shareUrl = urlencode(SITE_URL . '/blog-detail.php?slug=' . $blog['slug']);", "$shareUrl = urlencode(SITE_URL . '/blog/' . $blog['slug'] . '/');")
c = c.replace('<a href="blog.php?tag=<?= urlencode($tag[\'slug\']) ?>"', '<a href="/blog/?tag=<?= urlencode($tag[\'slug\']) ?>"')
c = c.replace('blog-detail.php?slug=<?= urlencode($prevArticle[\'slug\']) ?>', '/blog/<?= urlencode($prevArticle[\'slug\']) ?>/')
c = c.replace('blog-detail.php?slug=<?= urlencode($nextArticle[\'slug\']) ?>', '/blog/<?= urlencode($nextArticle[\'slug\']) ?>/')
c = c.replace('blog-detail.php?slug=<?= urlencode($rel[\'slug\']) ?>', '/blog/<?= urlencode($rel[\'slug\']) ?>/')

with open('blog-detail.php', 'w', encoding='utf-8') as f:
    f.write(c)

print("blog-detail.php updated.")
