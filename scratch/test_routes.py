import urllib.request
import urllib.error
import http.client

BASE_URL = "http://localhost:8000"

class NoRedirectHandler(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        # Prevent automatic redirection to inspect 301/302 responses
        return None

opener = urllib.request.build_opener(NoRedirectHandler)

def get(path):
    url = f"{BASE_URL}{path}"
    req = urllib.request.Request(url)
    try:
        res = opener.open(req)
        return res.status, res.headers.get("Location")
    except urllib.error.HTTPError as e:
        return e.code, e.headers.get("Location")
    except Exception as e:
        return 0, str(e)

# 1. Test clean routes (expect 200)
clean_routes = [
    "/",
    "/about/",
    "/services/",
    "/contact/",
    "/blog/",
    "/services/ecommerce-management/",
    "/services/graphic-designer/",
    "/services/performance-marketing/",
    "/services/ppc-expert/",
    "/services/product-shoot/",
    "/services/seo-expert/",
    "/services/smo-services/",
    "/services/social-media-marketing/",
    "/services/video-editing/",
    "/services/website-designer/",
    "/blog/business-growth-strategy/",
    "/blog/ai-in-business/",
    "/blog/digital-transformation-strategies/",
    "/blog/leadership-skills/",
    "/blog/marketing-strategies/",
]

print("=== 1. Testing Clean Routes (Expect 200) ===")
clean_failures = 0
for r in clean_routes:
    status, loc = get(r)
    if status == 200:
        print(f"  [OK 200] {r}")
    else:
        print(f"  [FAIL {status}] {r} (Loc: {loc})")
        clean_failures += 1

# 2. Test 301 Redirects from physical .html and .php files
redirect_cases = [
    ("/index.html", "/"),
    ("/index.php", "/"),
    ("/about.html", "/about/"),
    ("/services.html", "/services/"),
    ("/contact.html", "/contact/"),
    ("/blog.html", "/blog/"),
    ("/blog.php", "/blog/"),
    ("/service-ecommerce-management.html", "/services/ecommerce-management/"),
    ("/service-graphic-designer.html", "/services/graphic-designer/"),
    ("/service-performance-marketing.html", "/services/performance-marketing/"),
    ("/service-ppc-expert.html", "/services/ppc-expert/"),
    ("/service-product-shoot.html", "/services/product-shoot/"),
    ("/service-seo-expert.html", "/services/seo-expert/"),
    ("/service-smo-services.html", "/services/smo-services/"),
    ("/service-social-media-marketing.html", "/services/social-media-marketing/"),
    ("/service-video-editing.html", "/services/video-editing/"),
    ("/service-website-designer.html", "/services/website-designer/"),
    ("/service-best-marketing-consultant.html", "/services/"),
    ("/services/marketing-consultant/", "/services/"),
    ("/blog-business-growth-strategy.html", "/blog/business-growth-strategy/"),
    ("/blog-ai-in-business.html", "/blog/ai-in-business/"),
    ("/blog-digital-transformation-strategies.html", "/blog/digital-transformation-strategies/"),
    ("/blog-leadership-skills.html", "/blog/leadership-skills/"),
    ("/blog-marketing-strategies.html", "/blog/marketing-strategies/"),
]

print("\n=== 2. Testing 301 Redirects (Expect 301 & Target Location) ===")
redirect_failures = 0
for src, expected_dst in redirect_cases:
    status, loc = get(src)
    if status == 301 and loc == expected_dst:
        print(f"  [OK 301] {src} -> {loc}")
    else:
        print(f"  [FAIL] {src} -> Expected {expected_dst}, got {status} (Loc: {loc})")
        redirect_failures += 1

# 3. Test trailing slash enforcement
slash_cases = [
    ("/about", "/about/"),
    ("/services", "/services/"),
    ("/contact", "/contact/"),
    ("/blog", "/blog/"),
    ("/services/ecommerce-management", "/services/ecommerce-management/"),
    ("/blog/ai-in-business", "/blog/ai-in-business/"),
]

print("\n=== 3. Testing Trailing Slash Enforcement (Expect 301) ===")
slash_failures = 0
for src, expected_dst in slash_cases:
    status, loc = get(src)
    if status == 301 and loc == expected_dst:
        print(f"  [OK 301] {src} -> {loc}")
    else:
        print(f"  [FAIL] {src} -> Expected {expected_dst}, got {status} (Loc: {loc})")
        slash_failures += 1

# 4. Test query string preservation
query_cases = [
    ("/index.html?ref=banner", "/?ref=banner"),
    ("/about.html?src=test", "/about/?src=test"),
    ("/about?src=test", "/about/?src=test"),
]

print("\n=== 4. Testing Query String Preservation ===")
query_failures = 0
for src, expected_dst in query_cases:
    status, loc = get(src)
    if status == 301 and loc == expected_dst:
        print(f"  [OK 301] {src} -> {loc}")
    else:
        print(f"  [FAIL] {src} -> Expected {expected_dst}, got {status} (Loc: {loc})")
        query_failures += 1

# 5. Test static assets passthrough
asset_cases = [
    "/css/style.css",
    "/js/main.js",
]

print("\n=== 5. Testing Static Assets Passthrough (Expect 200) ===")
asset_failures = 0
for a in asset_cases:
    status, loc = get(a)
    if status == 200:
        print(f"  [OK 200] {a}")
    else:
        print(f"  [FAIL] {a} -> Status {status}")
        asset_failures += 1

total_failures = clean_failures + redirect_failures + slash_failures + query_failures + asset_failures
print(f"\n==========================================")
print(f"TOTAL FAILURES: {total_failures}")
print(f"==========================================")
if total_failures == 0:
    print("ALL TESTS PASSED SUCCESSFULLY!")
