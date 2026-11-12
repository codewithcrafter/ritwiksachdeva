<?php
/**
 * RITWIK SACHDEVA - SEO & SCHEMA AUTOMATION MODULE
 * Dynamic JSON-LD structured data, Open Graph generator, and sitemap automation.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

class SeoManager {
    /**
     * Generate dynamic sitemap.xml from published pages and blogs
     */
    public static function generateSitemap(): string {
        $db = get_db();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static Core Pages
        $staticPages = [
            ['loc' => BASE_URL . '/', 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => BASE_URL . '/about.html', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => BASE_URL . '/services.html', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => BASE_URL . '/blog/', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => BASE_URL . '/contact.html', 'changefreq' => 'monthly', 'priority' => '0.8']
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($page['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $page['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // Published Blogs Only
        $stmt = $db->query("
            SELECT slug, updated_at, published_at
            FROM blogs
            WHERE status = 'published' AND deleted_at IS NULL
            ORDER BY published_at DESC
        ");
        $blogs = $stmt->fetchAll();

        foreach ($blogs as $blog) {
            $url = BASE_URL . '/blog/' . $blog['slug'] . '/';
            $lastmod = date('Y-m-d', strtotime($blog['updated_at'] ?: $blog['published_at'] ?: 'now'));
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        // Write sitemap.xml to root directory
        $sitemapPath = ROOT_PATH . '/sitemap.xml';
        file_put_contents($sitemapPath, $xml);

        return $xml;
    }

    /**
     * Build JSON-LD Article Schema
     */
    public static function getBlogSchema(array $blog, array $author): string {
        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => $blog['schema_type'] ?: 'BlogPosting',
            'headline'         => $blog['title'],
            'description'      => $blog['excerpt'],
            'image'            => $blog['featured_image'] ? (BASE_URL . '/' . ltrim($blog['featured_image'], '/')) : (BASE_URL . '/assets/images/hero-consultant.svg'),
            'datePublished'    => date('c', strtotime($blog['published_at'] ?: 'now')),
            'dateModified'     => date('c', strtotime($blog['updated_at'] ?: $blog['published_at'] ?: 'now')),
            'author'           => [
                '@type' => 'Person',
                'name'  => $author['name'] ?: 'Ritwik Sachdeva',
                'url'   => BASE_URL . '/about.html'
            ],
            'publisher'        => [
                '@type' => 'Organization',
                'name'  => 'Ritwik Sachdeva - Business & Marketing Consulting',
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => BASE_URL . '/assets/images/about-consultant.svg'
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => BASE_URL . '/blog/' . $blog['slug'] . '/'
            ]
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Build BreadcrumbList Schema
     */
    public static function getBreadcrumbSchema(array $crumbs): string {
        $list = [];
        $pos = 1;
        foreach ($crumbs as $name => $url) {
            $list[] = [
                '@type'    => 'ListItem',
                'position' => $pos++,
                'name'     => $name,
                'item'     => $url
            ];
        }

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $list
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

