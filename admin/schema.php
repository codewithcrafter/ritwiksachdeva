<?php
/**
 * Admin Schema Validator & JSON-LD Inspector
 */

$pageTitle = 'Schema Validator';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../includes/seo.php';

// Fetch sample blog for schema demonstration
$sampleBlog = $pdo->query("
    SELECT b.*, c.name AS category_name, a.name AS author_name, a.avatar AS author_avatar
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    WHERE b.status = 'published'
    LIMIT 1
")->fetch();

$sampleSchema = $sampleBlog ? SeoManager::getBlogSchema($sampleBlog, [['name' => 'Strategy', 'slug' => 'strategy']]) : '{}';
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Structured Data &amp; Schema Validator</h1>
    <p class="admin-page-subtitle">Inspect JSON-LD entities configured across consulting pages and published articles.</p>
  </div>
  <div class="admin-page-actions">
    <a href="https://search.google.com/test/rich-results" target="_blank" rel="noopener noreferrer" class="btn-admin btn-admin-secondary">
      Google Rich Results Test &nearr;
    </a>
  </div>
</div>

<!-- BlogPosting Schema Preview -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Live <code>BlogPosting</code> &amp; <code>BreadcrumbList</code> Schema (Sample Article)</h3>
    <?php if ($sampleBlog): ?>
      <span style="font-size: 12px; color: var(--admin-text-muted);">
        Sample: <em><?= e($sampleBlog['title']) ?></em>
      </span>
    <?php endif; ?>
  </div>
  <div class="admin-card-body">
    <p style="font-size: 13px; color: var(--admin-text-secondary); margin-bottom: 12px;">
      This schema is automatically injected into the <code>&lt;head&gt;</code> of every article page (<code>blog-detail.php</code>):
    </p>
    <pre style="background: #252525; color: #F8F7F4; padding: 18px; border-radius: var(--admin-radius); font-size: 12.5px; font-family: monospace; overflow-x: auto; max-height: 400px; line-height: 1.5;"><?= e(json_encode(json_decode($sampleSchema), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?></pre>
  </div>
</div>

<!-- Professional Service Schema Preview -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Sitewide <code>ProfessionalService</code> &amp; <code>Person</code> Schema</h3>
  </div>
  <div class="admin-card-body">
    <pre style="background: #252525; color: #F8F7F4; padding: 18px; border-radius: var(--admin-radius); font-size: 12.5px; font-family: monospace; overflow-x: auto; line-height: 1.5;">{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Person",
      "@id": "<?= SITE_URL ?>/#person",
      "name": "Ritwik Sachdeva",
      "jobTitle": "Digital Marketing Consultant",
      "description": "Senior growth strategist helping businesses design high-performing digital marketing strategies, SEO architectures, and lead generation funnels.",
      "url": "<?= SITE_URL ?>/",
      "sameAs": [
        "https://linkedin.com",
        "https://twitter.com"
      ]
    },
    {
      "@type": "ProfessionalService",
      "@id": "<?= SITE_URL ?>/#service",
      "name": "Ritwik Sachdeva - Digital Marketing Consultant",
      "url": "<?= SITE_URL ?>/",
      "description": "Professional digital marketing consulting, SEO strategy, paid media management, and customer acquisition services.",
      "founder": {
        "@id": "<?= SITE_URL ?>/#person"
      },
      "areaServed": "Worldwide",
      "priceRange": "$$"
    }
  ]
}</pre>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

