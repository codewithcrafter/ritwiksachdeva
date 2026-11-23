<?php
// PHP built-in server router for clean URLs across the entire site.

$rawUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($rawUri, PHP_URL_PATH) ?: '/';
$queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';

// 1. 301 Redirects for direct requests to legacy / physical .html and public .php files.
$redirectMap = [
    '/index.html' => '/',
    '/index.php' => '/',
    '/about.html' => '/about/',
    '/services.html' => '/services/',
    '/contact.html' => '/contact/',
    '/blog.html' => '/blog/',
    '/blog.php' => '/blog/',
    '/service-ecommerce-management.html' => '/services/ecommerce-management/',
    '/service-graphic-designer.html' => '/services/graphic-designer/',
    '/service-performance-marketing.html' => '/services/performance-marketing/',
    '/service-ppc-expert.html' => '/services/ppc-expert/',
    '/service-product-shoot.html' => '/services/product-shoot/',
    '/service-seo-expert.html' => '/services/seo-expert/',
    '/service-smo-services.html' => '/services/smo-services/',
    '/service-social-media-marketing.html' => '/services/social-media-marketing/',
    '/service-video-editing.html' => '/services/video-editing/',
    '/service-website-designer.html' => '/services/website-designer/',
    '/service-best-marketing-consultant.html' => '/services/',
    '/service-fractional-cmo.html' => '/services/',
    '/service-brand-strategy.html' => '/services/graphic-designer/',
    '/service-seo-consulting.html' => '/services/seo-expert/',
    '/service-b2b-lead-generation.html' => '/services/performance-marketing/',
    '/service-content-marketing.html' => '/services/smo-services/',
    '/service-marketing-analytics.html' => '/services/performance-marketing/',
    '/blog-business-growth-strategy.html' => '/blog/business-growth-strategy/',
    '/blog-ai-in-business.html' => '/blog/ai-in-business/',
    '/blog-digital-transformation-strategies.html' => '/blog/digital-transformation-strategies/',
    '/blog-leadership-skills.html' => '/blog/leadership-skills/',
    '/blog-marketing-strategies.html' => '/blog/marketing-strategies/',
];

if (isset($redirectMap[$requestPath])) {
    header('Location: ' . $redirectMap[$requestPath] . $queryString, true, 301);
    exit;
}

// 2. Allow existing static assets, uploads, and backend API scripts to be served directly.
$filePath = __DIR__ . $requestPath;
if ($requestPath !== '/' && $requestPath !== '' && is_file($filePath)) {
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    // Never serve legacy .html or public page .php directly as an asset
    if ($extension !== 'html') {
        if ($extension === 'php' && (str_starts_with($requestPath, '/api/') || str_starts_with($requestPath, '/admin/'))) {
            return false;
        }
        if ($extension !== 'php') {
            return false;
        }
    }
}

// 3. Normalize clean URL paths (ensure trailing slash for clean page routes)
$trimmed = trim(rawurldecode($requestPath), '/');
$normalizedPath = $trimmed === '' ? '/' : '/' . $trimmed . '/';

// 4. Clean Route Definitions
$cleanRoutes = [
    '/' => 'index.html',
    '/about/' => 'about.html',
    '/services/' => 'services.html',
    '/contact/' => 'contact.html',
    '/blog/' => 'blog.php',
    '/services/ecommerce-management/' => 'service-ecommerce-management.html',
    '/services/graphic-designer/' => 'service-graphic-designer.html',
    '/services/performance-marketing/' => 'service-performance-marketing.html',
    '/services/ppc-expert/' => 'service-ppc-expert.html',
    '/services/product-shoot/' => 'service-product-shoot.html',
    '/services/seo-expert/' => 'service-seo-expert.html',
    '/services/smo-services/' => 'service-smo-services.html',
    '/services/social-media-marketing/' => 'service-social-media-marketing.html',
    '/services/video-editing/' => 'service-video-editing.html',
    '/services/website-designer/' => 'service-website-designer.html',
    '/blog/business-growth-strategy/' => 'blog-business-growth-strategy.html',
    '/blog/ai-in-business/' => 'blog-ai-in-business.html',
    '/blog/digital-transformation-strategies/' => 'blog-digital-transformation-strategies.html',
    '/blog/leadership-skills/' => 'blog-leadership-skills.html',
    '/blog/marketing-strategies/' => 'blog-marketing-strategies.html',
    '/admin/' => 'admin/index.php',
];

// If path lacks trailing slash, redirect with 301 to the canonical clean route
if ($requestPath !== '/' && !str_ends_with($requestPath, '/')) {
    if (isset($cleanRoutes[$normalizedPath]) || preg_match('#^/blog/[a-z0-9_-]+/$#i', $normalizedPath)) {
        header('Location: ' . $normalizedPath . $queryString, true, 301);
        exit;
    }
}

// 5. Match clean route and serve physical file internally
if (isset($cleanRoutes[$normalizedPath])) {
    require __DIR__ . '/' . $cleanRoutes[$normalizedPath];
    return true;
}

// 6. Dynamic blog articles (/blog/:slug/)
if (preg_match('#^/blog/([a-z0-9_-]+)/$#i', $normalizedPath, $match)) {
    $_GET['slug'] = $match[1];
    require __DIR__ . '/blog-detail.php';
    return true;
}

// 7. Not Found
http_response_code(404);
echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><title>404 Page Not Found</title></head><body><h1>404 - Page Not Found</h1><p>The requested URL was not found on this server.</p><p><a href="/">Return to Homepage</a></p></body></html>';
