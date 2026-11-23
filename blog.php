<?php
/**
 * Blog Listing Page - Ritwik Sachdeva
 * Editorial Business & Digital Marketing Insights
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/seo.php';

$pdo = get_db();

// Filter parameters
$currentCategory = trim($_GET['category'] ?? '');
$currentTag = trim($_GET['tag'] ?? '');
$searchQuery = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Fetch active categories with blog counts
$catStmt = $pdo->query("
    SELECT c.id, c.name, c.slug, COUNT(b.id) AS blog_count
    FROM blog_categories c
    LEFT JOIN blogs b ON b.category_id = c.id AND b.status = 'published'
    GROUP BY c.id
    HAVING blog_count > 0
    ORDER BY c.name ASC
");
$categories = $catStmt->fetchAll();

// Base query for published blogs
$where = ["b.status = 'published'", "(b.published_at IS NULL OR b.published_at <= NOW())"];
$params = [];

if ($currentCategory !== '') {
    $where[] = "c.slug = :cat_slug";
    $params[':cat_slug'] = $currentCategory;
}

if ($currentTag !== '') {
    $where[] = "EXISTS (
        SELECT 1 FROM blog_tag_relations btr 
        JOIN blog_tags t ON btr.tag_id = t.id 
        WHERE btr.blog_id = b.id AND t.slug = :tag_slug
    )";
    $params[':tag_slug'] = $currentTag;
}

if ($searchQuery !== '') {
    $where[] = "(b.title LIKE :search OR b.excerpt LIKE :search OR b.content LIKE :search)";
    $params[':search'] = '%' . $searchQuery . '%';
}

$whereClause = implode(' AND ', $where);

// Count total matching blogs
$countStmt = $pdo->prepare("
    SELECT COUNT(b.id) 
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    WHERE {$whereClause}
");
$countStmt->execute($params);
$totalBlogs = (int)$countStmt->fetchColumn();
$totalPages = ceil($totalBlogs / $perPage);

// Featured blog (only on page 1 with no search filter)
$featuredBlog = null;
if ($page === 1 && empty($searchQuery) && empty($currentCategory) && empty($currentTag)) {
    $featStmt = $pdo->query("
        SELECT b.*, c.name AS category_name, c.slug AS category_slug, 
               a.name AS author_name, a.avatar AS author_avatar
        FROM blogs b
        LEFT JOIN blog_categories c ON b.category_id = c.id
        LEFT JOIN authors a ON b.author_id = a.id
        WHERE b.status = 'published' AND b.is_featured = 1
        ORDER BY b.published_at DESC
        LIMIT 1
    ");
    $featuredBlog = $featStmt->fetch();
}

// Fetch blogs for current page
$listQuery = "
    SELECT b.*, c.name AS category_name, c.slug AS category_slug,
           a.name AS author_name, a.avatar AS author_avatar
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    WHERE {$whereClause}
";

// If featured blog is present on front page, we can exclude it or keep in list
$listQuery .= " ORDER BY b.published_at DESC LIMIT :limit OFFSET :offset";

$listStmt = $pdo->prepare($listQuery);
foreach ($params as $key => $val) {
    $listStmt->bindValue($key, $val);
}
$listStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$listStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$listStmt->execute();
$blogs = $listStmt->fetchAll();

// Dynamic Meta tags
$pageTitle = "Marketing & Strategy Blog | Ritwik Sachdeva - Growth Perspectives";
$pageDesc = "In-depth insights, frameworks, and tactical blueprints for digital transformation, B2B lead generation, performance marketing, and executive leadership.";
if ($currentCategory !== '') {
    $catName = '';
    foreach ($categories as $cat) {
        if ($cat['slug'] === $currentCategory) { $catName = $cat['name']; break; }
    }
    if ($catName) {
        $pageTitle = "{$catName} Insights | Ritwik Sachdeva Marketing Blog";
        $pageDesc = "Read expert articles and strategic guidance on {$catName} by Ritwik Sachdeva.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <base href="/">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?= e($pageTitle) ?></title>
  <meta name="title" content="<?= e($pageTitle) ?>">
  <meta name="description" content="<?= e($pageDesc) ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= SITE_URL ?>/blog/<?= $currentCategory ? '?category=' . urlencode($currentCategory) : '' ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= SITE_URL ?>/blog/">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDesc) ?>">
  <meta property="og:image" content="<?= SITE_URL ?>/assets/images/hero-consultant.svg">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/blog.css">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23C47B45'/><text x='16' y='22' fill='%23fff' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">
</head>
<body>

  <!-- Reading Progress -->
  <div id="scroll-progress" role="progressbar" aria-label="Page reading progress"></div>

  <!-- Ambient Background Overlay -->
  <div class="bg-ambient-layer" aria-hidden="true">
    <div class="ambient-glow-circle ambient-glow-1"></div>
    <div class="ambient-glow-circle ambient-glow-2"></div>
    <div class="grid-pattern-overlay"></div>
  </div>

  <!-- SITE HEADER / NAVBAR -->
  <!-- SITE HEADER / NAVBAR -->
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
      <a href="/blog/" class="mobile-link">Blog</a>
      <a href="/contact/" class="mobile-link">Contact</a>
    </div>
    <div class="mobile-actions">
      <a href="/contact/" class="btn btn-primary btn-block">Let's Talk</a>
    </div>
  </div>
<main>
    <!-- HERO SECTION -->
    <section class="blog-hero">
      <div class="container text-center">
        <div class="section-tag hero-stagger-1" style="justify-content: center;">Strategic Perspectives &amp; Research</div>
        <h1 class="hero-stagger-2" style="max-width: 860px; margin: 0 auto 16px auto;">
          Ideas, Frameworks &amp; <span class="text-gradient">Growth Blueprints.</span>
        </h1>
        <p class="hero-stagger-3" style="font-size: 1.15rem; max-width: 720px; margin: 0 auto; color: var(--text-secondary); line-height: 1.68;">
          Tested methodologies, executive notes, and analytical strategies spanning digital transformation, high-converting customer acquisition, and enterprise leadership.
        </p>

        <!-- Category Filter & Search Bar -->
        <div class="blog-filter-bar">
          <div class="blog-category-pills">
            <a href="/blog/" class="category-pill <?= empty($currentCategory) ? 'active' : '' ?>">
              All Topics
            </a>
            <?php foreach ($categories as $cat): ?>
              <a href="/blog/?category=<?= urlencode($cat['slug']) ?>" 
                 class="category-pill <?= ($currentCategory === $cat['slug']) ? 'active' : '' ?>">
                <?= e($cat['name']) ?>
                <span class="category-pill-count"><?= (int)$cat['blog_count'] ?></span>
              </a>
            <?php endforeach; ?>
          </div>

          <form action="/blog/" method="GET" class="blog-search-box">
            <?php if ($currentCategory): ?>
              <input type="hidden" name="category" value="<?= e($currentCategory) ?>">
            <?php endif; ?>
            <span class="blog-search-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </span>
            <input type="search" name="q" class="blog-search-input" placeholder="Search strategy articles..." value="<?= e($searchQuery) ?>" aria-label="Search articles">
          </form>
        </div>
      </div>
    </section>

    <div class="container" style="padding-top: 24px; padding-bottom: 80px;">

      <!-- FEATURED BLOG SHOWCASE (When Available) -->
      <?php if ($featuredBlog): ?>
        <article class="featured-blog-card">
          <div class="featured-blog-img-wrap">
            <a href="/blog/<?= urlencode($featuredBlog['slug']) ?>/" tabindex="-1" aria-hidden="true">
              <img src="<?= e($featuredBlog['featured_image'] ?: 'assets/images/hero-consultant.svg') ?>" 
                   alt="<?= e($featuredBlog['featured_image_alt'] ?: $featuredBlog['title']) ?>" 
                   loading="eager">
            </a>
          </div>
          <div class="featured-blog-content">
            <div style="display: flex; gap: 8px; align-items: center;">
              <span class="blog-badge featured-badge">★ Featured Analysis</span>
              <?php if (!empty($featuredBlog['category_name'])): ?>
                <span class="blog-badge"><?= e($featuredBlog['category_name']) ?></span>
              <?php endif; ?>
            </div>

            <div class="blog-meta-row">
              <span><?= date('M d, Y', strtotime($featuredBlog['published_at'] ?: $featuredBlog['created_at'])) ?></span>
              <span class="blog-meta-dot"></span>
              <span><?= (int)$featuredBlog['reading_time'] ?> min read</span>
            </div>

            <h2 class="featured-blog-title">
              <a href="/blog/<?= urlencode($featuredBlog['slug']) ?>/">
                <?= e($featuredBlog['title']) ?>
              </a>
            </h2>

            <p class="featured-blog-excerpt">
              <?= e($featuredBlog['excerpt']) ?>
            </p>

            <div class="blog-card-footer" style="padding-top: 0; border-top: none;">
              <div class="author-chip">
                <img src="<?= e($featuredBlog['author_avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                     alt="<?= e($featuredBlog['author_name']) ?>" 
                     class="author-avatar">
                <div>
                  <span class="author-meta-name"><?= e($featuredBlog['author_name']) ?></span>
                  <span class="author-meta-date">Consultant &amp; Strategist</span>
                </div>
              </div>
              <a href="/blog/<?= urlencode($featuredBlog['slug']) ?>/" class="read-more-link">
                Read Article &rarr;
              </a>
            </div>
          </div>
        </article>
      <?php endif; ?>

      <!-- ACTIVE SEARCH OR FILTER NOTICE -->
      <?php if ($searchQuery !== '' || $currentCategory !== '' || $currentTag !== ''): ?>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding: 12px 18px; background: var(--bg-beige); border-radius: var(--radius-md); font-size: 0.92rem;">
          <div>
            Showing <strong><?= $totalBlogs ?></strong> articles 
            <?= $currentCategory ? 'in <em>' . e($currentCategory) . '</em>' : '' ?>
            <?= $searchQuery ? 'matching "<em>' . e($searchQuery) . '</em>"' : '' ?>
            <?= $currentTag ? 'tagged with #' . e($currentTag) : '' ?>
          </div>
          <a href="/blog/" style="color: var(--accent-primary); font-weight: 600; text-decoration: none;">Clear Filter &times;</a>
        </div>
      <?php endif; ?>

      <!-- BLOG GRID -->
      <?php if (!empty($blogs)): ?>
        <div class="blog-grid">
          <?php foreach ($blogs as $blog): ?>
            <article class="blog-card">
              <div class="blog-card-media">
                <a href="/blog/<?= urlencode($blog['slug']) ?>/" tabindex="-1">
                  <img src="<?= e($blog['featured_image'] ?: 'assets/images/hero-consultant.svg') ?>" 
                       alt="<?= e($blog['featured_image_alt'] ?: $blog['title']) ?>"
                       loading="lazy">
                </a>
              </div>
              <div class="blog-card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                  <?php if (!empty($blog['category_name'])): ?>
                    <span class="blog-badge" style="margin-bottom: 0;"><?= e($blog['category_name']) ?></span>
                  <?php endif; ?>
                  <span style="font-size: 0.78rem; color: var(--text-muted);"><?= (int)$blog['reading_time'] ?> min</span>
                </div>

                <h3 class="blog-card-title">
                  <a href="/blog/<?= urlencode($blog['slug']) ?>/">
                    <?= e($blog['title']) ?>
                  </a>
                </h3>

                <p class="blog-card-excerpt">
                  <?= e($blog['excerpt']) ?>
                </p>

                <div class="blog-card-footer">
                  <div class="author-chip">
                    <img src="<?= e($blog['author_avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                         alt="<?= e($blog['author_name']) ?>" 
                         class="author-avatar">
                    <div>
                      <span class="author-meta-name"><?= e($blog['author_name']) ?></span>
                      <span class="author-meta-date"><?= date('M d, Y', strtotime($blog['published_at'] ?: $blog['created_at'])) ?></span>
                    </div>
                  </div>
                  <a href="/blog/<?= urlencode($blog['slug']) ?>/" class="read-more-link" aria-label="Read <?= e($blog['title']) ?>">
                    Read &rarr;
                  </a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
          <nav class="blog-pagination" aria-label="Blog pagination">
            <?php if ($page > 1): ?>
              <a href="?page=<?= $page - 1 ?><?= $currentCategory ? '&category=' . urlencode($currentCategory) : '' ?><?= $searchQuery ? '&q=' . urlencode($searchQuery) : '' ?>" 
                 class="pagination-item" aria-label="Previous page">&larr; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a href="?page=<?= $i ?><?= $currentCategory ? '&category=' . urlencode($currentCategory) : '' ?><?= $searchQuery ? '&q=' . urlencode($searchQuery) : '' ?>" 
                 class="pagination-item <?= ($page === $i) ? 'active' : '' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <a href="?page=<?= $page + 1 ?><?= $currentCategory ? '&category=' . urlencode($currentCategory) : '' ?><?= $searchQuery ? '&q=' . urlencode($searchQuery) : '' ?>" 
                 class="pagination-item" aria-label="Next page">Next &rarr;</a>
            <?php endif; ?>
          </nav>
        <?php endif; ?>

      <?php else: ?>
        <div style="text-align: center; padding: 64px 20px; background: var(--bg-secondary); border-radius: var(--radius-lg); border: 1px dashed var(--border-color); margin-top: 24px;">
          <h3 style="font-size: 1.4rem; margin-bottom: 8px;">No Insights Found</h3>
          <p style="color: var(--text-secondary); max-width: 480px; margin: 0 auto 20px auto;">
            We couldn't find any articles matching your search query. Try adjusting your search term or exploring all categories.
          </p>
          <a href="/blog/" class="btn btn-secondary btn-sm">Reset All Filters</a>
        </div>
      <?php endif; ?>

      <!-- ADVISORY NEWSLETTER / CTA BANNER -->
      <section style="margin-top: 80px; padding: 48px; background: var(--bg-beige); border-radius: var(--radius-lg); border: 1px solid var(--border-color); text-align: center;">
        <div class="section-tag" style="justify-content: center; margin-bottom: 12px;">Executive Growth Advisory</div>
        <h2 style="font-size: clamp(1.6rem, 2.8vw, 2.2rem); margin-bottom: 12px; color: var(--text-primary);">
          Need Strategic Clarity for Your Next Quarter?
        </h2>
        <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto 24px auto; font-size: 1rem; line-height: 1.65;">
          Schedule an exploratory strategy consultation to audit your current customer acquisition funnels, digital presence, and conversion bottlenecks.
        </p>
        <a href="/contact/" class="btn btn-primary btn-lg btn-magnetic">
          Book Advisory Session
          <span class="btn-icon-right">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </span>
        </a>
      </section>

    </div>
  </main>

  <!-- FOOTER -->
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
</body>
</html>

