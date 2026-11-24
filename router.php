<?php
// PHP built-in server router for clean URLs without trailing slashes across the entire site.

$rawUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($rawUri, PHP_URL_PATH) ?: '/';
$queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

// 1. 301 Redirects for incoming trailing slash requests (except root '/')
if ($requestPath !== '/' && str_ends_with($requestPath, '/')) {
    $cleanPath = rtrim($requestPath, '/');
    header('Location: ' . $cleanPath . $queryString, true, 301);
    exit;
}

// 2. 301 Redirects for legacy physical .html and public .php files
$redirectMap = [
    '/index.html' => '/',
    '/index.php' => '/',
    '/about.html' => '/about',
    '/services.html' => '/services',
    '/contact.html' => '/contact',
    '/blog.html' => '/blog',
    '/blog.php' => '/blog',
    '/service-ecommerce-management.html' => '/services/ecommerce-management',
    '/service-graphic-designer.html' => '/services/graphic-designer',
    '/service-performance-marketing.html' => '/services/performance-marketing',
    '/service-ppc-expert.html' => '/services/ppc-expert',
    '/service-product-shoot.html' => '/services/product-shoot',
    '/service-seo-expert.html' => '/services/seo-expert',
    '/service-smo-services.html' => '/services/smo-services',
    '/service-social-media-marketing.html' => '/services/social-media-marketing',
    '/service-video-editing.html' => '/services/video-editing',
    '/service-website-designer.html' => '/services/website-designer',
    '/service-best-marketing-consultant.html' => '/services',
    '/services/marketing-consultant' => '/services',
    '/service-fractional-cmo.html' => '/services',
    '/service-brand-strategy.html' => '/services/graphic-designer',
    '/service-seo-consulting.html' => '/services/seo-expert',
    '/service-b2b-lead-generation.html' => '/services/performance-marketing',
    '/service-content-marketing.html' => '/services/smo-services',
    '/service-marketing-analytics.html' => '/services/performance-marketing',
    '/blog-business-growth-strategy.html' => '/blog/business-growth-strategy',
    '/blog-ai-in-business.html' => '/blog/ai-in-business',
    '/blog-digital-transformation-strategies.html' => '/blog/digital-transformation-strategies',
    '/blog-leadership-skills.html' => '/blog/leadership-skills',
    '/blog-marketing-strategies.html' => '/blog/marketing-strategies',
    '/privacy-policy.html' => '/privacy-policy',
    '/terms.html' => '/terms',
];

if (isset($redirectMap[$requestPath])) {
    header('Location: ' . $redirectMap[$requestPath] . $queryString, true, 301);
    exit;
}

// 3. Allow existing static files and backend API scripts to be served directly
$filePath = __DIR__ . $requestPath;
if ($requestPath !== '/' && $requestPath !== '' && is_file($filePath)) {
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if ($extension === 'php' && (str_starts_with($requestPath, '/api/') || str_starts_with($requestPath, '/admin/') || $requestPath === '/consult-submit.php')) {
        return false;
    }
    if ($extension !== 'php') {
        return false;
    }
}

// 4. Clean Route Definitions (Extensionless, No Trailing Slash except '/')
$cleanRoutes = [
    '/' => 'index.html',
    '/about' => 'about.html',
    '/services' => 'services.html',
    '/contact' => 'contact.html',
    '/blog' => 'blog.html',
    '/services/ecommerce-management' => 'service-ecommerce-management.html',
    '/services/graphic-designer' => 'service-graphic-designer.html',
    '/services/performance-marketing' => 'service-performance-marketing.html',
    '/services/ppc-expert' => 'service-ppc-expert.html',
    '/services/product-shoot' => 'service-product-shoot.html',
    '/services/seo-expert' => 'service-seo-expert.html',
    '/services/smo-services' => 'service-smo-services.html',
    '/services/social-media-marketing' => 'service-social-media-marketing.html',
    '/services/video-editing' => 'service-video-editing.html',
    '/services/website-designer' => 'service-website-designer.html',
    '/privacy-policy' => 'privacy-policy.html',
    '/terms' => 'terms.html',
    '/admin' => 'admin/index.php',
];

// 5. Match clean route and serve physical file internally
if (isset($cleanRoutes[$requestPath])) {
    require __DIR__ . '/' . $cleanRoutes[$requestPath];
    return true;
}

// 6. Dynamic blog articles (/blog/:slug)
if (preg_match('#^/blog/([a-z0-9_-]+)$#i', $requestPath, $match)) {
    $_GET['slug'] = $match[1];
    require __DIR__ . '/blog-detail.php';
    return true;
}

// 7. Not Found
http_response_code(404);
echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>404 Page Not Found</title></head><body><h1>404 - Page Not Found</h1><p>The requested URL was not found on this server.</p><p><a href="/">Return to Homepage</a></p></body></html>';
