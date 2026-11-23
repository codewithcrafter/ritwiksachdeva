with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Replace any service-best-marketing-consultant.html in index.html with appropriate service pages
text = text.replace('href="service-best-marketing-consultant.html"', 'href="service-performance-marketing.html"')

with open('index.html', 'w', encoding='utf-8') as f:
    f.write(text)

print("Updated remaining references in index.html successfully.")
