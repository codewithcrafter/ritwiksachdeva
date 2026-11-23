import glob
import re

blog_pages = glob.glob('blog*.html') + ['blog.php', 'blog-detail.php']
print(f"Total blog pages: {len(blog_pages)}")

for bp in sorted(blog_pages):
    with open(bp, 'r', encoding='utf-8') as f:
        text = f.read()
    has_topbar = 'header-top-bar' in text
    has_author_bar = 'article-author-bar' in text
    has_media = 'article-featured-media' in text
    has_grid = 'article-layout-grid' in text or 'blog-grid' in text
    has_share = 'article-share-buttons' in text
    has_10_services = '10 Services' in text
    print(f"=== {bp} ===")
    print(f"  TopBar: {has_topbar}, AuthorBar: {has_author_bar}, Share: {has_share}, Media: {has_media}, Grid: {has_grid}, 10Services: {has_10_services}")
