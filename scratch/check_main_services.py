with open('services.html', 'r', encoding='utf-8') as f:
    text = f.read()

import re
m = re.search(r'<main[^>]*>(.*?)</main>', text, re.DOTALL)
if m:
    main_content = m.group(1)
    print("Main content length:", len(main_content))
    # print the first 2500 chars of main
    print(main_content[:2500])
