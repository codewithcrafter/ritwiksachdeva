import glob
import re

files = glob.glob('*.html') + glob.glob('*.php')

for f in sorted(files):
    with open(f, 'r', encoding='utf-8') as fp:
        c = fp.read()
    # Find footer
    ft_pos = c.find('<footer class="site-footer"')
    if ft_pos == -1:
        print(f"{f}: NO FOOTER!")
        continue
    # Find popup or scripts
    tail = c[ft_pos:]
    popup_pos = re.search(r'(<div class="consultation-popup-overlay"|<script)', tail)
    if popup_pos:
        match_str = popup_pos.group(1)
        print(f"{f:35}: footer followed by {match_str} at offset {popup_pos.start()}")
    else:
        print(f"{f:35}: footer has NO popup or script following!")
