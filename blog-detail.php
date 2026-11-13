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
    header('Location: blog.php');
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
    echo '<!DOCTYPE html><html><head><title>Article Not Found</title><link rel="stylesheet" href="css/style.css"></head><body style="display:flex;align-items:center;justify-content:center;height:100vh;text-align:center;"><div class="container"><h1>404 - Article Not Found</h1><p>The requested strategy analysis could not be located.</p><p><a href="blog.php" class="btn btn-primary">Return to Blog</a></p></div></body></html>';
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
$canonical = $blog['canonical_url'] ?: (SITE_URL . '/blog-detail.php?slug=' . urlencode($blog['slug']));
$ogImage = $blog['og_image'] ?: ($blog['featured_image'] ?: (SITE_URL . '/assets/images/hero-consultant.svg'));
$publishedIso = date('c', strtotime($blog['published_at'] ?: $blog['created_at']));
$updatedIso = date('c', strtotime($blog['updated_at']));

// Generate Schema
$schemaJson = SeoManager::getBlogSchema($blog, $tags);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
  <header class="site-header" id="navbar">
    <div class="container nav-container">
      <a href="index.html" class="brand-logo" aria-label="Ritwik Sachdeva - Digital Marketing Consultant">
        <div class="brand-monogram">RS</div>
        <div class="brand-info">
          <span class="brand-name">Ritwik Sachdeva</span>
          <span class="brand-title">Marketing Consultant</span>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="desktop-nav" aria-label="Primary Navigation">
        <ul class="nav-links">
          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
          <li class="nav-item nav-item-has-dropdown">
            <a href="services.html" class="nav-link dropdown-toggle" aria-expanded="false" aria-haspopup="true">
              Services
              <svg class="dropdown-arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </a>
            <div class="nav-dropdown-menu" role="menu">
              <div class="nav-dropdown-header">
                <span class="dropdown-header-title">All Services &amp; Practices</span>
                <span class="dropdown-header-tag">11 Services</span>
              </div>
              <div class="nav-dropdown-list">
                <a href="service-ecommerce-management.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">01</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">E-Commerce Management</div>
                    <div class="dropdown-item-desc">Amazon, Flipkart &amp; Shopify Growth</div>
                  </div>
                </a>
                <a href="service-graphic-designer.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">02</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Graphic Designer</div>
                    <div class="dropdown-item-desc">Brand Identity, Logos &amp; Visual Assets</div>
                  </div>
                </a>
                <a href="service-performance-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">03</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Performance Marketing Consultant in Delhi</div>
                    <div class="dropdown-item-desc">Meta &amp; Google Paid Media Scaling</div>
                  </div>
                </a>
                <a href="service-ppc-expert.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">04</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">PPC Expert in Delhi</div>
                    <div class="dropdown-item-desc">Google Ads, PMax &amp; Shopping Campaigns</div>
                  </div>
                </a>
                <a href="service-product-shoot.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">05</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Product Shoot Services in Delhi</div>
                    <div class="dropdown-item-desc">E-Commerce &amp; High-Conversion Photography</div>
                  </div>
                </a>
                <a href="service-seo-expert.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">06</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">SEO Expert in Delhi</div>
                    <div class="dropdown-item-desc">Technical, Local &amp; Organic Search Growth</div>
                  </div>
                </a>
                <a href="service-smo-services.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">07</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">SMO Services in Delhi</div>
                    <div class="dropdown-item-desc">Social Media Optimization &amp; Reach</div>
                  </div>
                </a>
                <a href="service-social-media-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">08</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Social Media Marketing Agency in Delhi</div>
                    <div class="dropdown-item-desc">Organic Engagement &amp; Viral Campaigns</div>
                  </div>
                </a>
                <a href="service-video-editing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">09</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Video Editing Services in Delhi</div>
                    <div class="dropdown-item-desc">Reels, Shorts, Video Ads &amp; Longform</div>
                  </div>
                </a>
                <a href="service-best-marketing-consultant.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">10</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">best marketing consultant</div>
                    <div class="dropdown-item-desc">Strategic Full-Funnel Business Consulting</div>
                  </div>
                </a>
                <a href="service-website-designer.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">11</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Website Designer in Delhi</div>
                    <div class="dropdown-item-desc">Custom Web Development &amp; Shopify Stores</div>
                  </div>
                </a>
              </div>
              <div class="nav-dropdown-footer">
                <a href="services.html" class="dropdown-view-all">
                  <span>View Comprehensive Services Catalog</span>
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item"><a href="blog.php" class="nav-link active">Blog</a></li>
          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
        </ul>
        <div class="nav-actions">
          <a href="contact.html" class="btn btn-primary btn-sm btn-magnetic">
            Let's Talk
            <span class="btn-icon-right">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
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
  <div class="mobile-drawer" id="mobile-drawer" aria-label="Mobile Navigation">
    <div class="mobile-links">
      <a href="index.html" class="mobile-link">Home</a>
      <a href="about.html" class="mobile-link">About</a>
      <div class="mobile-nav-item-dropdown">
        <div class="mobile-dropdown-header-row">
          <a href="services.html" class="mobile-link">Services</a>
          <button class="mobile-submenu-btn" aria-label="Toggle Services submenu" aria-expanded="false">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </button>
        </div>
        <div class="mobile-submenu">
          <a href="service-ecommerce-management.html" class="mobile-sublink">01. E-Commerce Management</a>
          <a href="service-graphic-designer.html" class="mobile-sublink">02. Graphic Designer</a>
          <a href="service-performance-marketing.html" class="mobile-sublink">03. Performance Marketing Consultant in Delhi</a>
          <a href="service-ppc-expert.html" class="mobile-sublink">04. PPC Expert in Delhi</a>
          <a href="service-product-shoot.html" class="mobile-sublink">05. Product Shoot Services in Delhi</a>
          <a href="service-seo-expert.html" class="mobile-sublink">06. SEO Expert in Delhi</a>
          <a href="service-smo-services.html" class="mobile-sublink">07. SMO Services in Delhi</a>
          <a href="service-social-media-marketing.html" class="mobile-sublink">08. Social Media Marketing Agency in Delhi</a>
          <a href="service-video-editing.html" class="mobile-sublink">09. Video Editing Services in Delhi</a>
          <a href="service-best-marketing-consultant.html" class="mobile-sublink">10. best marketing consultant</a>
          <a href="service-website-designer.html" class="mobile-sublink">11. Website Designer in Delhi</a>
        </div>
      </div>
      <a href="blog.php" class="mobile-link active">Blog</a>
      <a href="contact.html" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-drawer-footer">
      <a href="contact.html" class="btn btn-primary btn-lg" style="width: 100%;">
        Request Strategy Consultation
        <span class="btn-icon-right">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </span>
      </a>
      <p style="font-size: 0.85rem; color: var(--text-secondary); text-align: center; margin-top: 10px;">Direct: consult@ritwiksachdeva.com</p>
    </div>
  </div>

  <main>
    <!-- ARTICLE HEADER -->
    <article>
      <header class="article-header">
        <div class="container" style="max-width: 980px;">
          <!-- Breadcrumb Navigation -->
          <nav class="article-breadcrumbs" aria-label="Breadcrumbs">
            <a href="index.html">Home</a>
            <span class="breadcrumb-sep">/</span>
            <a href="blog.php">Blog</a>
            <?php if (!empty($blog['category_name'])): ?>
              <span class="breadcrumb-sep">/</span>
              <a href="blog.php?category=<?= urlencode($blog['category_slug']) ?>"><?= e($blog['category_name']) ?></a>
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
                $shareUrl = urlencode(SITE_URL . '/blog-detail.php?slug=' . $blog['slug']);
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
      <div class="container" style="max-width: 1140px; padding-bottom: 80px;">

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
                  <a href="blog.php?tag=<?= urlencode($tag['slug']) ?>" class="article-tag-item">
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
                <a href="contact.html" class="read-more-link">
                  Consult with <?= e($blog['author_name']) ?> &rarr;
                </a>
              </div>
            </div>

            <!-- Previous / Next Navigation -->
            <div class="article-nav-grid">
              <?php if ($prevArticle): ?>
                <a href="blog-detail.php?slug=<?= urlencode($prevArticle['slug']) ?>" class="article-nav-card">
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
                <a href="blog-detail.php?slug=<?= urlencode($nextArticle['slug']) ?>" class="article-nav-card" style="text-align: right;">
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
              <a href="contact.html" class="btn btn-primary btn-sm" style="width: 100%;">
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
                    <a href="blog-detail.php?slug=<?= urlencode($rel['slug']) ?>" tabindex="-1">
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
                      <a href="blog-detail.php?slug=<?= urlencode($rel['slug']) ?>">
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
                      <a href="blog-detail.php?slug=<?= urlencode($rel['slug']) ?>" class="read-more-link" style="font-size: 0.82rem;">
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
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <a href="index.html" class="brand-logo" style="margin-bottom: 8px;">
            <div class="brand-monogram">RS</div>
            <div class="brand-info">
              <span class="brand-name">Ritwik Sachdeva</span>
              <span class="brand-title">Marketing Consultant</span>
            </div>
          </a>
          <p class="footer-brand-statement">
            Digital marketing consulting, performance marketing strategy, and SEO architecture engineered for sustainable business growth.
          </p>
        </div>

        <div>
          <h4 class="footer-heading">Navigation</h4>
          <ul class="footer-links">
            <li><a href="index.html" class="footer-link">Home</a></li>
            <li><a href="about.html" class="footer-link">About Consultant</a></li>
            <li><a href="services.html" class="footer-link">Digital Marketing Services</a></li>
            <li><a href="blog.php" class="footer-link">Insights &amp; Blog</a></li>
            <li><a href="contact.html" class="footer-link">Contact &amp; Consultation</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-heading">Services</h4>
          <ul class="footer-links">
            <li><a href="service-ecommerce-management.html">E-Commerce Management</a></li>
            <li><a href="service-graphic-designer.html">Graphic Designer</a></li>
            <li><a href="service-performance-marketing.html">Performance Marketing Consultant in Delhi</a></li>
            <li><a href="service-ppc-expert.html">PPC Expert in Delhi</a></li>
            <li><a href="service-product-shoot.html">Product Shoot Services in Delhi</a></li>
            <li><a href="service-seo-expert.html">SEO Expert in Delhi</a></li>
            <li><a href="service-smo-services.html">SMO Services in Delhi</a></li>
            <li><a href="service-social-media-marketing.html">Social Media Marketing Agency in Delhi</a></li>
            <li><a href="service-video-editing.html">Video Editing Services in Delhi</a></li>
            <li><a href="service-best-marketing-consultant.html">best marketing consultant</a></li>
            <li><a href="service-website-designer.html">Website Designer in Delhi</a></li>
          </ul>
        </div>

        <div>
          <h4 class="footer-heading">Direct Inquiry</h4>
          <p style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 10px;">
            Inquiries answered within 24 business hours.
          </p>
          <a href="mailto:consult@ritwiksachdeva.com" style="color: var(--accent-primary); font-weight: 600; font-size: 0.92rem;">
            consult@ritwiksachdeva.com
          </a>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; <span id="current-year">2026</span> Ritwik Sachdeva. All Rights Reserved. Digital Marketing Strategy &amp; Consulting.
        </div>
        <div>
          <button id="back-to-top" class="back-to-top-btn" aria-label="Back to top">
            Back To Top &uarr;
          </button>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="js/main.js"></script>
  <script src="js/animations.js"></script>
  <script src="js/interactions.js"></script>
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

