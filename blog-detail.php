<?php
/**
 * Single Blog Article Detail View - Ritwik Sachdeva
 * Dynamic Article with Markdown parsing, Table of Contents, Schema & Sharing
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/markdown.php';
require_once __DIR__ . '/includes/seo.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = get_db();
$slug = trim($_GET['slug'] ?? '');

if (empty($slug)) {
    header('Location: /blog/', true, 301);
    exit;
}

// Check if user is logged in admin (can preview drafts)
$isAdmin = auth_check();

// Query blog
$query = "
    SELECT b.*, 
           c.name AS category_name, c.slug AS category_slug,
           a.name AS author_name, a.title AS author_title, a.bio AS author_bio, 
           a.avatar AS author_avatar, a.email AS author_email,
           sm.page_title AS meta_title, sm.meta_description, sm.canonical_url, sm.og_image, sm.robots_directive AS robots
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    LEFT JOIN seo_metadata sm ON sm.page_route = CONCAT('/blog/', b.slug, '/')
    WHERE b.slug = :slug
";

if (!$isAdmin) {
    $query .= " AND b.status = 'published' AND (b.published_at IS NULL OR b.published_at <= NOW())";
}

$stmt = $pdo->prepare($query);
$stmt->execute([':slug' => $slug]);
$blog = $stmt->fetch();

if (!$blog) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><head><title>Article Not Found</title><link rel="stylesheet" href="css/style.css"></head><body style="display:flex;align-items:center;justify-content:center;height:100vh;text-align:center;"><div class="container"><h1>404 - Article Not Found</h1><p>The requested strategy analysis could not be located.</p><p><a href="/blog/" class="btn btn-primary">Return to Blog</a></p></div></body></html>';
    exit;
}

// Fetch article tags
$tagsStmt = $pdo->prepare("
    SELECT t.name, t.slug 
    FROM blog_tags t
    JOIN blog_tag_relations btr ON btr.tag_id = t.id
    WHERE btr.blog_id = :id
    ORDER BY t.name ASC
");
$tagsStmt->execute([':id' => $blog['id']]);
$tags = $tagsStmt->fetchAll();

// Convert Markdown/Raw content into HTML
$rawHtml = MarkdownManager::toHtml($blog['content']);

// Parse headings to generate Table of Contents & inject IDs into <h2> and <h3>
$toc = [];
$htmlWithIds = preg_replace_callback('/<h([23])>(.*?)<\/h\1>/i', function($matches) use (&$toc) {
    $level = (int)$matches[1];
    $title = strip_tags($matches[2]);
    $id = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($title)));
    $id = trim($id, '-');
    $toc[] = [
        'level' => $level,
        'title' => $title,
        'id'    => $id
    ];
    return "<h{$level} id=\"{$id}\">{$matches[2]}</h{$level}>";
}, $rawHtml);

// Fetch Previous & Next articles
$prevStmt = $pdo->prepare("
    SELECT slug, title FROM blogs 
    WHERE status = 'published' AND published_at < :published_at 
    ORDER BY published_at DESC LIMIT 1
");
$prevStmt->execute([':published_at' => $blog['published_at'] ?: $blog['created_at']]);
$prevArticle = $prevStmt->fetch();

$nextStmt = $pdo->prepare("
    SELECT slug, title FROM blogs 
    WHERE status = 'published' AND published_at > :published_at 
    ORDER BY published_at ASC LIMIT 1
");
$nextStmt->execute([':published_at' => $blog['published_at'] ?: $blog['created_at']]);
$nextArticle = $nextStmt->fetch();

// Fetch Related Articles (same category, excluding self)
$relStmt = $pdo->prepare("
    SELECT b.*, c.name AS category_name, a.name AS author_name, a.avatar AS author_avatar
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    WHERE b.status = 'published' AND b.id != :id AND b.category_id = :cat_id
    ORDER BY b.published_at DESC LIMIT 3
");
$relStmt->execute([':id' => $blog['id'], ':cat_id' => $blog['category_id']]);
$relatedBlogs = $relStmt->fetchAll();

// If less than 3 related by category, backfill with newest articles
if (count($relatedBlogs) < 3) {
    $existingIds = array_merge([$blog['id']], array_column($relatedBlogs, 'id'));
    $inClause = implode(',', array_map('intval', $existingIds));
    $backfillLimit = 3 - count($relatedBlogs);
    $bfStmt = $pdo->query("
        SELECT b.*, c.name AS category_name, a.name AS author_name, a.avatar AS author_avatar
        FROM blogs b
        LEFT JOIN blog_categories c ON b.category_id = c.id
        LEFT JOIN authors a ON b.author_id = a.id
        WHERE b.status = 'published' AND b.id NOT IN ({$inClause})
        ORDER BY b.published_at DESC LIMIT {$backfillLimit}
    ");
    $backfills = $bfStmt->fetchAll();
    $relatedBlogs = array_merge($relatedBlogs, $backfills);
}

// Metadata calculation
$metaTitle = $blog['meta_title'] ?: ($blog['title'] . ' | Ritwik Sachdeva');
$metaDesc = $blog['meta_description'] ?: $blog['excerpt'];
$canonical = $blog['canonical_url'] ?: (SITE_URL . '/blog/' . urlencode($blog['slug']) . '/');
$ogImage = $blog['og_image'] ?: ($blog['featured_image'] ?: (SITE_URL . '/assets/images/hero-consultant.svg'));
$publishedIso = date('c', strtotime($blog['published_at'] ?: $blog['created_at']));
$updatedIso = date('c', strtotime($blog['updated_at']));

// Generate Schema
$schemaJson = SeoManager::getBlogSchema($blog, $tags);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?= e($metaTitle) ?></title>
  <meta name="title" content="<?= e($metaTitle) ?>">
  <meta name="description" content="<?= e($metaDesc) ?>">
  <meta name="author" content="<?= e($blog['author_name']) ?>">
  <meta name="robots" content="<?= e($blog['robots'] ?: 'index, follow') ?>">
  <link rel="canonical" href="<?= e($canonical) ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="article">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:title" content="<?= e($metaTitle) ?>">
  <meta property="og:description" content="<?= e($metaDesc) ?>">
  <meta property="og:image" content="<?= e($ogImage) ?>">
  <meta property="article:published_time" content="<?= $publishedIso ?>">
  <meta property="article:modified_time" content="<?= $updatedIso ?>">
  <meta property="article:author" content="<?= e($blog['author_name']) ?>">
  <?php if (!empty($blog['category_name'])): ?>
    <meta property="article:section" content="<?= e($blog['category_name']) ?>">
  <?php endif; ?>

  <!-- Twitter Card -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:title" content="<?= e($metaTitle) ?>">
  <meta property="twitter:description" content="<?= e($metaDesc) ?>">
  <meta property="twitter:image" content="<?= e($ogImage) ?>">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/blog.css">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23C47B45'/><text x='16' y='22' fill='%23fff' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">

  <!-- JSON-LD Article Schema -->
  <script type="application/ld+json">
  <?= $schemaJson ?>
  </script>
</head>
<body>

  <!-- Reading Progress Bar -->
  <div id="scroll-progress" role="progressbar" aria-label="Article reading progress"></div>

  <!-- Ambient Background Layer -->
  <div class="bg-ambient-layer" aria-hidden="true">
    <div class="ambient-glow-circle ambient-glow-1"></div>
    <div class="ambient-glow-circle ambient-glow-2"></div>
    <div class="grid-pattern-overlay"></div>
  </div>

  <!-- HEADER / NAVBAR -->
  <!-- SITE HEADER / NAVBAR -->
  <!-- SITE HEADER / NAVBAR -->
  <header class="site-header" id="navbar">
    <!-- Top Contact Links Bar -->
    <div class="header-top-bar">
      <div class="container header-top-inner">
        <div class="header-top-left">
          <span class="top-status-indicator"></span>
          <span class="top-status-text">Available for Q1 Consulting &amp; Growth Audits</span>
        </div>
        <div class="header-top-right">
          <a href="mailto:Info@ritwiksachdeva.in" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <span>Info@ritwiksachdeva.in</span>
          </a>
          <span class="top-bar-divider" aria-hidden="true">&bull;</span>
          <a href="tel:+919289626986" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>+91 92896 26986</span>
          </a>
        </div>
      </div>
    </div>

    <div class="container nav-container">
      <a href="/" class="brand-logo" aria-label="Ritwik Sachdeva - Digital Marketing Consultant">
        <div class="brand-monogram">RS</div>
        <div class="brand-info">
          <span class="brand-name">Ritwik Sachdeva</span>
          <span class="brand-title">Marketing Consultant</span>
        </div>
      </a>

      <!-- Desktop Navigation with Dropdown -->
      <nav class="desktop-nav" aria-label="Primary Navigation">
        <ul class="nav-links">
          <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="/about/" class="nav-link">About</a></li>
          <li class="nav-item nav-item-has-dropdown">
            <a href="/services/" class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true">
              <span>Services</span>
              <svg class="dropdown-arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" aria-hidden="true" focusable="false">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </a>
            <div class="nav-dropdown-menu" role="menu">
  <div class="nav-dropdown-header">
    <span class="dropdown-header-title">All Services &amp; Practices</span>
    <span class="dropdown-header-tag">10 Services</span>
  </div>
  <div class="nav-dropdown-list">
    <a href="/services/ecommerce-management/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">01</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">E-Commerce Management</div>
        <div class="dropdown-item-desc">Amazon, Flipkart &amp; Shopify Growth</div>
      </div>
    </a>
    <a href="/services/graphic-designer/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">02</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Graphic Designer</div>
        <div class="dropdown-item-desc">Brand Identity, Logos &amp; Visual Assets</div>
      </div>
    </a>
    <a href="/services/performance-marketing/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">03</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Performance Marketing Consultant in Delhi</div>
        <div class="dropdown-item-desc">Meta &amp; Google Paid Media Scaling</div>
      </div>
    </a>
    <a href="/services/ppc-expert/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">04</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">PPC Expert in Delhi</div>
        <div class="dropdown-item-desc">Google Ads, PMax &amp; Shopping Campaigns</div>
      </div>
    </a>
    <a href="/services/product-shoot/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">05</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Product Shoot Services in Delhi</div>
        <div class="dropdown-item-desc">E-Commerce &amp; High-Conversion Photography</div>
      </div>
    </a>
    <a href="/services/seo-expert/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">06</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">SEO Expert in Delhi</div>
        <div class="dropdown-item-desc">Technical, Local &amp; Organic Search Growth</div>
      </div>
    </a>
    <a href="/services/smo-services/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">07</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">SMO Services in Delhi</div>
        <div class="dropdown-item-desc">Social Media Optimization &amp; Reach</div>
      </div>
    </a>
    <a href="/services/social-media-marketing/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">08</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Social Media Marketing Agency in Delhi</div>
        <div class="dropdown-item-desc">Organic Engagement &amp; Viral Campaigns</div>
      </div>
    </a>
    <a href="/services/video-editing/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">09</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Video Editing Services in Delhi</div>
        <div class="dropdown-item-desc">Reels, Shorts, Video Ads &amp; Longform</div>
      </div>
    </a>
    <a href="/services/website-designer/" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">10</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Website Designer in Delhi</div>
        <div class="dropdown-item-desc">Custom Web Development &amp; Shopify Stores</div>
      </div>
    </a>
  </div>
  <div class="nav-dropdown-footer">
    <a href="/services/" class="dropdown-view-all">
      <span>View Comprehensive Services Catalog</span>
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </a>
  </div>
</div>
          </li>
          <li class="nav-item"><a href="/blog/" class="nav-link active">Blog</a></li>
          <li class="nav-item"><a href="/contact/" class="nav-link">Contact</a></li>
        </ul>
        <div class="nav-actions">
          <a href="/contact/" class="btn btn-primary btn-sm btn-magnetic">
            <span>Let's Talk</span>
            <span class="btn-icon-right" aria-hidden="true">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </span>
          </a>
        </div>
      </nav>

      <!-- Mobile Hamburger Toggle -->
      <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>
    </div>
  </header>

  <!-- Mobile Drawer -->
  <!-- Mobile Drawer Navigation -->
  <div class="mobile-drawer" id="mobile-drawer" aria-label="Mobile Navigation">
    <div class="mobile-links">
      <a href="/" class="mobile-link">Home</a>
      <a href="/about/" class="mobile-link">About</a>
      <div class="mobile-nav-item-dropdown">
        <div class="mobile-dropdown-header-row">
          <a href="/services/" class="mobile-link">Services</a>
          <button class="mobile-submenu-btn" aria-label="Toggle Services submenu" aria-expanded="false">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>
        </div>
        <div class="mobile-submenu">
  <a href="/services/ecommerce-management/" class="mobile-sublink">01. E-Commerce Management</a>
  <a href="/services/graphic-designer/" class="mobile-sublink">02. Graphic Designer</a>
  <a href="/services/performance-marketing/" class="mobile-sublink">03. Performance Marketing Consultant in Delhi</a>
  <a href="/services/ppc-expert/" class="mobile-sublink">04. PPC Expert in Delhi</a>
  <a href="/services/product-shoot/" class="mobile-sublink">05. Product Shoot Services in Delhi</a>
  <a href="/services/seo-expert/" class="mobile-sublink">06. SEO Expert in Delhi</a>
  <a href="/services/smo-services/" class="mobile-sublink">07. SMO Services in Delhi</a>
  <a href="/services/social-media-marketing/" class="mobile-sublink">08. Social Media Marketing Agency in Delhi</a>
  <a href="/services/video-editing/" class="mobile-sublink">09. Video Editing Services in Delhi</a>
  <a href="/services/website-designer/" class="mobile-sublink">10. Website Designer in Delhi</a>
</div>
      </div>
      <a href="/blog/" class="mobile-link active">Blog</a>
      <a href="/contact/" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-actions">
      <a href="/contact/" class="btn btn-primary btn-block"><span>Let's Talk</span></a>
    </div>
  </div>
      <a href="/blog/" class="mobile-link active">Blog</a>
      <a href="/contact/" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-actions">
      <a href="/contact/" class="btn btn-primary btn-block"><span>Let's Talk</span></a>
    </div>
  </div>
      <a href="/blog/" class="mobile-link active">Blog</a>
      <a href="/contact/" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-drawer-footer">
      <a href="/contact/" class="btn btn-primary btn-lg" style="width: 100%;">
        Request Strategy Consultation
        <span class="btn-icon-right">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </span>
      </a>
      <p style="font-size: 0.85rem; color: var(--text-secondary); text-align: center; margin-top: 10px;">Direct: Info@ritwiksachdeva.in</p>
    </div>
  </div>

  <main>
    <!-- ARTICLE HEADER -->
    <article>
      <header class="article-header">
        <div class="container article-container">
          <!-- Breadcrumb Navigation -->
          <nav class="article-breadcrumbs" aria-label="Breadcrumbs">
            <a href="/">Home</a>
            <span class="breadcrumb-sep">/</span>
            <a href="/blog/">Blog</a>
            <?php if (!empty($blog['category_name'])): ?>
              <span class="breadcrumb-sep">/</span>
              <a href="/blog/?category=<?= urlencode($blog['category_slug']) ?>"><?= e($blog['category_name']) ?></a>
            <?php endif; ?>
            <span class="breadcrumb-sep">/</span>
            <span style="color: var(--text-primary); font-weight: 500;"><?= e(mb_substr($blog['title'], 0, 36)) ?>...</span>
          </nav>

          <!-- Badges & Meta -->
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <?php if (!empty($blog['category_name'])): ?>
              <span class="blog-badge" style="margin-bottom: 0;"><?= e($blog['category_name']) ?></span>
            <?php endif; ?>
            <span style="font-size: 0.85rem; color: var(--text-secondary);">
              Published <?= date('F d, Y', strtotime($blog['published_at'] ?: $blog['created_at'])) ?>
            </span>
            <span class="blog-meta-dot"></span>
            <span style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 500;">
              <?= (int)$blog['reading_time'] ?> min read
            </span>
            <?php if ($blog['status'] !== 'published'): ?>
              <span style="background: #FEF3C7; color: #92400E; font-size: 0.75rem; padding: 2px 8px; border-radius: var(--radius-pill); font-weight: 700;">
                ADMIN PREVIEW (<?= strtoupper($blog['status']) ?>)
              </span>
            <?php endif; ?>
          </div>

          <h1 class="article-title"><?= e($blog['title']) ?></h1>
          <p class="article-lead"><?= e($blog['excerpt']) ?></p>

          <!-- Author bar & Social Sharing -->
          <div class="article-author-bar">
            <div class="article-author-info">
              <img src="<?= e($blog['author_avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                   alt="<?= e($blog['author_name']) ?>" 
                   class="article-author-avatar">
              <div>
                <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem;"><?= e($blog['author_name']) ?></div>
                <div style="font-size: 0.82rem; color: var(--text-secondary);"><?= e($blog['author_title'] ?: 'Marketing Strategy Consultant') ?></div>
              </div>
            </div>

            <!-- Social Share Bar -->
            <div class="article-share-buttons">
              <span style="font-size: 0.82rem; color: var(--text-secondary); font-weight: 600; margin-right: 4px;">Share:</span>
              <?php
                $shareUrl = urlencode(SITE_URL . '/blog/' . $blog['slug'] . '/');
                $shareTitle = urlencode($blog['title']);
              ?>
              <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareUrl ?>" 
                 target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Share on LinkedIn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                LinkedIn
              </a>
              <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= $shareUrl ?>" 
                 target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Share on X">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                X
              </a>
              <button type="button" class="share-btn" id="copy-link-btn" onclick="navigator.clipboard.writeText(window.location.href); alert('Article link copied to clipboard!');" aria-label="Copy article link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                Copy Link
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- ARTICLE BODY -->
      <div class="container article-container" style="padding-bottom: 80px;">

        <!-- Featured Banner Image -->
        <?php if (!empty($blog['featured_image'])): ?>
          <div class="article-featured-media">
            <img src="<?= e($blog['featured_image']) ?>" 
                 alt="<?= e($blog['featured_image_alt'] ?: $blog['title']) ?>">
          </div>
        <?php endif; ?>

        <!-- 2-Column Content + TOC Grid -->
        <div class="article-layout-grid">
          
          <!-- Main Content Column -->
          <div class="article-prose-column">
            <div class="article-prose">
              <?= $htmlWithIds ?>
            </div>

            <!-- Tags Section -->
            <?php if (!empty($tags)): ?>
              <div class="article-tags-wrap">
                <span style="font-size: 0.84rem; font-weight: 600; color: var(--text-primary); margin-right: 6px;">Topics:</span>
                <?php foreach ($tags as $tag): ?>
                  <a href="/blog/?tag=<?= urlencode($tag['slug']) ?>" class="article-tag-item">
                    #<?= e($tag['name']) ?>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <!-- Author Card -->
            <div class="article-author-card">
              <img src="<?= e($blog['author_avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                   alt="<?= e($blog['author_name']) ?>" 
                   class="article-author-card-avatar">
              <div>
                <h4 style="font-size: 1.15rem; margin-bottom: 6px; color: var(--text-primary);">
                  Written by <?= e($blog['author_name']) ?>
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.92rem; line-height: 1.6; margin-bottom: 12px;">
                  <?= e($blog['author_bio'] ?: 'Senior Digital Marketing Consultant & Strategy Advisor helping modern enterprises scale customer acquisition.') ?>
                </p>
                <a href="/contact/" class="read-more-link">
                  Consult with <?= e($blog['author_name']) ?> &rarr;
                </a>
              </div>
            </div>

            <!-- Previous / Next Navigation -->
            <div class="article-nav-grid">
              <?php if ($prevArticle): ?>
                <a href="/blog/<?= urlencode($prevArticle['slug']) ?>/" class="article-nav-card">
                  <div class="article-nav-label">&larr; Previous Analysis</div>
                  <div class="article-nav-title"><?= e($prevArticle['title']) ?></div>
                </a>
              <?php else: ?>
                <div class="article-nav-card" style="opacity: 0.5;">
                  <div class="article-nav-label">Previous</div>
                  <div class="article-nav-title">First in publication archive</div>
                </div>
              <?php endif; ?>

              <?php if ($nextArticle): ?>
                <a href="/blog/<?= urlencode($nextArticle['slug']) ?>/" class="article-nav-card" style="text-align: right;">
                  <div class="article-nav-label">Next Analysis &rarr;</div>
                  <div class="article-nav-title"><?= e($nextArticle['title']) ?></div>
                </a>
              <?php else: ?>
                <div class="article-nav-card" style="opacity: 0.5; text-align: right;">
                  <div class="article-nav-label">Next</div>
                  <div class="article-nav-title">Latest released analysis</div>
                </div>
              <?php endif; ?>
            </div>

          </div>

          <!-- Sticky Sidebar: Table of Contents -->
          <aside class="toc-sidebar" aria-label="Table of Contents">
            <div class="toc-title">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
              Table of Contents
            </div>

            <?php if (!empty($toc)): ?>
              <ul class="toc-list" id="toc-list">
                <?php foreach ($toc as $item): ?>
                  <li>
                    <a href="#<?= e($item['id']) ?>" 
                       class="toc-link <?= ($item['level'] === 3) ? 'subheading' : '' ?>">
                      <?= e($item['title']) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Comprehensive overview</p>
            <?php endif; ?>

            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
              <h5 style="font-size: 0.88rem; font-weight: 700; margin-bottom: 8px;">Need Custom Implementation?</h5>
              <p style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.5; margin-bottom: 12px;">
                I work directly with founders and leadership teams to execute these frameworks.
              </p>
              <a href="/contact/" class="btn btn-primary btn-sm" style="width: 100%;">
                Request Consultation
              </a>
            </div>
          </aside>

        </div>

        <!-- RELATED ARTICLES SECTION -->
        <?php if (!empty($relatedBlogs)): ?>
          <section style="margin-top: 80px; padding-top: 48px; border-top: 1px solid var(--border-color);">
            <div class="section-tag">Recommended Reading</div>
            <h3 style="font-size: 1.8rem; margin-bottom: 24px; color: var(--text-primary);">
              Related Strategic Analyses
            </h3>

            <div class="blog-grid">
              <?php foreach ($relatedBlogs as $rel): ?>
                <article class="blog-card">
                  <div class="blog-card-media">
                    <a href="/blog/<?= urlencode($rel['slug']) ?>/" tabindex="-1">
                      <img src="<?= e($rel['featured_image'] ?: 'assets/images/hero-consultant.svg') ?>" 
                           alt="<?= e($rel['featured_image_alt'] ?: $rel['title']) ?>"
                           loading="lazy">
                    </a>
                  </div>
                  <div class="blog-card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                      <?php if (!empty($rel['category_name'])): ?>
                        <span class="blog-badge" style="margin-bottom: 0;"><?= e($rel['category_name']) ?></span>
                      <?php endif; ?>
                      <span style="font-size: 0.78rem; color: var(--text-muted);"><?= (int)$rel['reading_time'] ?> min</span>
                    </div>

                    <h4 class="blog-card-title" style="font-size: 1.15rem;">
                      <a href="/blog/<?= urlencode($rel['slug']) ?>/">
                        <?= e($rel['title']) ?>
                      </a>
                    </h4>

                    <p class="blog-card-excerpt" style="font-size: 0.88rem;">
                      <?= e(mb_substr($rel['excerpt'], 0, 110)) ?>...
                    </p>

                    <div class="blog-card-footer">
                      <div class="author-chip">
                        <img src="<?= e($rel['author_avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                             alt="<?= e($rel['author_name']) ?>" 
                             class="author-avatar" style="width: 28px; height: 28px;">
                        <span class="author-meta-name" style="font-size: 0.8rem;"><?= e($rel['author_name']) ?></span>
                      </div>
                      <a href="/blog/<?= urlencode($rel['slug']) ?>/" class="read-more-link" style="font-size: 0.82rem;">
                        Read &rarr;
                      </a>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>

      </div>
    </article>
  </main>

    <!-- FOOTER -->
  <footer class="site-footer" id="footer">
    <div class="container footer-container">
      <div class="footer-grid">
        <!-- Col 1: Brand Info -->
        <div class="footer-col footer-col-brand">
          <a href="/" class="footer-logo">
            <div class="brand-monogram">RS</div>
            <div class="brand-info">
              <span class="brand-name">Ritwik Sachdeva</span>
              <span class="brand-title">Marketing Consultant</span>
            </div>
          </a>
          <p class="footer-tagline">
            Strategic digital marketing consultant helping businesses scale through data-driven campaigns, technical search moats, and high-converting creative systems.
          </p>
          <div class="footer-social-links">
            <a href="https://linkedin.com" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
            </a>
            <a href="https://twitter.com" class="social-link" aria-label="Twitter / X" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="https://instagram.com" class="social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Navigation -->
        <div class="footer-col">
          <h4 class="footer-col-title">Navigation</h4>
          <ul class="footer-links">
            <li><a href="/">Home</a></li>
            <li><a href="/about/">About Ritwik</a></li>
            <li><a href="/services/">Services Catalog</a></li>
            <li><a href="/blog/">Growth Articles</a></li>
            <li><a href="/contact/">Contact &amp; Bookings</a></li>
          </ul>
        </div>

        <!-- Col 3: Services (10 Services) -->
        <div class="footer-col">
          <h4 class="footer-col-title">Services</h4>
          <ul class="footer-links">
            <li><a href="/services/ecommerce-management/">E-Commerce Management</a></li>
            <li><a href="/services/graphic-designer/">Graphic Designer &amp; Branding</a></li>
            <li><a href="/services/performance-marketing/">Performance Marketing</a></li>
            <li><a href="/services/ppc-expert/">PPC Expert (Google Ads)</a></li>
            <li><a href="/services/product-shoot/">Product Shoot Services</a></li>
            <li><a href="/services/seo-expert/">SEO Expert in Delhi</a></li>
            <li><a href="/services/smo-services/">SMO Services</a></li>
            <li><a href="/services/social-media-marketing/">Social Media Marketing</a></li>
            <li><a href="/services/video-editing/">Video Editing Services</a></li>
            <li><a href="/services/website-designer/">Website Designer &amp; Dev</a></li>
          </ul>
        </div>

        <!-- Col 4: Direct Inquiry -->
        <div class="footer-col">
          <h4 class="footer-col-title">Direct Inquiry</h4>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <a href="mailto:Info@ritwiksachdeva.in"><span>Info@ritwiksachdeva.in</span></a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <a href="tel:+919289626986"><span>+91 92896 26986</span></a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Delhi NCR, India (Global Remote)</span>
          </p>
          <div class="footer-cta-box">
            <span class="cta-box-text">Ready to scale your business?</span>
            <a href="/contact/" class="btn btn-primary btn-sm btn-magnetic"><span>Book Consultation</span></a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p class="copyright-text">&copy; 2026 Ritwik Sachdeva. All rights reserved. Strategic Digital Marketing &amp; Scaling Consultant.</p>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Engagement</a>
          <a href="/sitemap.xml">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button with SVG Circular Progress -->
  <button id="back-to-top" class="back-to-top-progress" aria-label="Back to top" title="Scroll back to top">
    <svg class="progress-ring" width="46" height="46" viewBox="0 0 46 46" aria-hidden="true" focusable="false">
      <circle class="progress-ring-bg" cx="23" cy="23" r="20" fill="none" stroke="#CBD5E1" stroke-width="2.5" />
      <circle class="progress-ring-indicator" cx="23" cy="23" r="20" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-dasharray="125.6" stroke-dashoffset="125.6" />
    </svg>
    <span class="back-to-top-arrow" aria-hidden="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
        <polyline points="18 15 12 9 6 15"></polyline>
      </svg>
    </span>
  </button>

  <!-- Floating WhatsApp and Call Action Buttons -->
  <div class="floating-actions-container" id="rs-floating-actions" aria-label="Direct contact options">
    <a href="https://wa.me/919289626986" class="floating-btn floating-btn-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp with Ritwik Sachdeva">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.12.553 4.11 1.523 5.836l-1.616 5.908 6.06-1.59c1.664.908 3.568 1.42 5.597 1.42 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/>
      </svg>
    </a>
    <a href="tel:+919289626986" class="floating-btn floating-btn-call" aria-label="Direct Phone Call" title="Call Ritwik Sachdeva directly">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>
  </div>

  <!-- Timed Consultation Popup Modal -->
  <div class="consultation-popup-overlay" id="consultation-popup" role="dialog" aria-modal="true" aria-labelledby="popup-title" aria-hidden="true">
    <div class="consultation-popup-dialog">
      <button class="popup-close-btn" id="popup-close-btn" aria-label="Close consultation modal">&times;</button>
      <div class="popup-header">
        <span class="popup-badge">Free Growth Audit</span>
        <h3 class="popup-title" id="popup-title">Book a 1-on-1 Growth Consultation</h3>
        <p class="popup-subtitle">Discuss your marketing, SEO, paid media, or design requirements directly with Ritwik Sachdeva.</p>
      </div>
      <form class="popup-form" id="consultation-popup-form" action="api/contact.php" method="POST" novalidate>
        <div class="form-group">
          <label for="popup-name" class="form-label">Full Name <span class="required-mark">*</span></label>
          <input type="text" id="popup-name" name="name" class="form-input" placeholder="e.g. Rahul Sharma" required autocomplete="name">
          <div class="form-error-msg" id="popup-name-error">Please enter your full name.</div>
        </div>
        <div class="form-group">
          <label for="popup-email" class="form-label">Email Address <span class="required-mark">*</span></label>
          <input type="email" id="popup-email" name="email" class="form-input" placeholder="e.g. rahul@company.com" required autocomplete="email">
          <div class="form-error-msg" id="popup-email-error">Please enter a valid business email address.</div>
        </div>
        <div class="form-group">
          <label for="popup-number" class="form-label">Phone Number <span class="required-mark">*</span></label>
          <input type="tel" id="popup-number" name="phone" class="form-input" placeholder="e.g. +91 92896 26986" required autocomplete="tel">
          <div class="form-error-msg" id="popup-phone-error">Please enter a valid phone number.</div>
        </div>
        <div class="form-group">
          <label for="popup-message" class="form-label">Message <span class="optional-mark">(optional)</span></label>
          <textarea id="popup-message" name="message" class="form-textarea" rows="3" placeholder="Give us a bit about your idea..."></textarea>
        </div>
        <div class="popup-form-status" id="popup-form-status" role="status" aria-live="polite"></div>
        <button type="submit" class="btn btn-primary btn-block popup-submit-btn" id="popup-submit-btn">
          <span>Submit Request</span>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
      </form>
    </div>
  </div>

<!-- Scripts -->
  <script src="js/main.js"></script>
  <script src="js/animations.js"></script>
  <script src="js/interactions.js"></script>
  <script src="js/blog-enhancements.js"></script>
  <script>
    // Smooth scroll and active highlight for Table of Contents
    document.addEventListener('DOMContentLoaded', () => {
      const tocLinks = document.querySelectorAll('.toc-link');
      const headings = Array.from(tocLinks).map(link => {
        const id = link.getAttribute('href').slice(1);
        return document.getElementById(id);
      }).filter(Boolean);

      window.addEventListener('scroll', () => {
        const scrollPos = window.scrollY + 120;
        let currentActive = null;
        headings.forEach(heading => {
          if (heading.offsetTop <= scrollPos) {
            currentActive = heading.id;
          }
        });

        tocLinks.forEach(link => {
          if (link.getAttribute('href') === '#' + currentActive) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }, { passive: true });
    });
  </script>
</body>
</html>

