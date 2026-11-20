import glob, re

pages = sorted(glob.glob('*.html') + ['blog.php', 'blog-detail.php'])
for p in pages:
    with open(p, 'r', encoding='utf-8') as f:
        c = f.read()
    has_style = 'css/style.css' in c
    has_footer = 'site-footer' in c
    has_grid = 'footer-grid' in c
    has_header = 'site-header' in c
    has_active_nav = 'nav-link' in c
    print(f"{p:45} | style:{str(has_style):5} | footer:{str(has_footer):5} | grid:{str(has_grid):5} | header:{str(has_header):5}")
