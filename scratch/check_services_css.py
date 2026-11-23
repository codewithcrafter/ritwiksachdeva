with open('css/services.css', 'r', encoding='utf-8') as f:
    text = f.read()

print("services.css lines:", len(text.split('\n')))
print("services.css bytes:", len(text))
