import urllib.request

service_pages = [
    'service-ecommerce-management.html',
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-seo-expert.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-best-marketing-consultant.html',
    'service-website-designer.html'
]

print("Verifying all 11 individual service pages on localhost:8000...")
all_ok = True
for sp in service_pages:
    url = f"http://localhost:8000/{sp}"
    try:
        req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, timeout=5) as resp:
            if resp.status == 200:
                print(f"  [OK 200] {sp}")
            else:
                print(f"  [STATUS {resp.status}] {sp}")
                all_ok = False
    except Exception as e:
        print(f"  [ERROR] {sp}: {e}")
        all_ok = False

if all_ok:
    print("\nALL 11 SERVICE PAGES SERVED SUCCESSFULLY WITH HTTP 200 OK!")
