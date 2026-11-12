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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title><?= e($pageTitle) ?></title>
  <meta name="title" content="<?= e($pageTitle) ?>">
  <meta name="description" content="<?= e($pageDesc) ?>">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="<?= SITE_URL ?>/blog.php<?= $currentCategory ? '?category=' . urlencode($currentCategory) : '' ?>">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= SITE_URL ?>/blog.php">
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
                <span class="dropdown-header-title">Consulting Practices</span>
                <span class="dropdown-header-tag">7 Practices</span>
              </div>
              <div class="nav-dropdown-list">
                <a href="service-fractional-cmo.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">01</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Fractional CMO Advisory</div>
                    <div class="dropdown-item-desc">Strategic Leadership &amp; Commercial Roadmaps</div>
                  </div>
                </a>
                <a href="service-brand-strategy.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">02</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Brand Strategy &amp; Positioning</div>
                    <div class="dropdown-item-desc">Category Leadership &amp; Value Narrative</div>
                  </div>
                </a>
                <a href="service-performance-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">03</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Performance Marketing</div>
                    <div class="dropdown-item-desc">Paid Acquisition (Google, Meta &amp; LinkedIn)</div>
                  </div>
                </a>
                <a href="service-seo-consulting.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">04</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">SEO &amp; Organic Authority</div>
                    <div class="dropdown-item-desc">Technical Architecture &amp; Compounding Moat</div>
                  </div>
                </a>
                <a href="service-b2b-lead-generation.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">05</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">B2B Lead Generation &amp; CRO</div>
                    <div class="dropdown-item-desc">Funnel Architecture &amp; Conversion Optimization</div>
                  </div>
                </a>
                <a href="service-content-marketing.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">06</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Editorial Content Marketing</div>
                    <div class="dropdown-item-desc">Thought Leadership &amp; Owned Audience Assets</div>
                  </div>
                </a>
                <a href="service-marketing-analytics.html" class="nav-dropdown-item" role="menuitem">
                  <span class="dropdown-item-num">07</span>
                  <div class="dropdown-item-body">
                    <div class="dropdown-item-title">Analytics &amp; Attribution</div>
                    <div class="dropdown-item-desc">GA4, Looker Studio &amp; Multi-Touch Modeling</div>
                  </div>
                </a>
              </div>
              <div class="nav-dropdown-footer">
                <a href="services.html" class="dropdown-view-all">
                  <span>View All Services &amp; Engagement Models</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
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
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
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
          <a href="service-fractional-cmo.html" class="mobile-sublink">01. Fractional CMO Advisory</a>
          <a href="service-brand-strategy.html" class="mobile-sublink">02. Brand Strategy &amp; Positioning</a>
          <a href="service-performance-marketing.html" class="mobile-sublink">03. Performance Marketing</a>
          <a href="service-seo-consulting.html" class="mobile-sublink">04. SEO &amp; Organic Authority</a>
          <a href="service-b2b-lead-generation.html" class="mobile-sublink">05. B2B Lead Generation &amp; CRO</a>
          <a href="service-content-marketing.html" class="mobile-sublink">06. Editorial Content Marketing</a>
          <a href="service-marketing-analytics.html" class="mobile-sublink">07. Analytics &amp; Attribution</a>
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
            <a href="blog.php" class="category-pill <?= empty($currentCategory) ? 'active' : '' ?>">
              All Topics
            </a>
            <?php foreach ($categories as $cat): ?>
              <a href="blog.php?category=<?= urlencode($cat['slug']) ?>" 
                 class="category-pill <?= ($currentCategory === $cat['slug']) ? 'active' : '' ?>">
                <?= e($cat['name']) ?>
                <span class="category-pill-count"><?= (int)$cat['blog_count'] ?></span>
              </a>
            <?php endforeach; ?>
          </div>

          <form action="blog.php" method="GET" class="blog-search-box">
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
            <a href="blog-detail.php?slug=<?= urlencode($featuredBlog['slug']) ?>" tabindex="-1" aria-hidden="true">
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
              <a href="blog-detail.php?slug=<?= urlencode($featuredBlog['slug']) ?>">
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
              <a href="blog-detail.php?slug=<?= urlencode($featuredBlog['slug']) ?>" class="read-more-link">
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
          <a href="blog.php" style="color: var(--accent-primary); font-weight: 600; text-decoration: none;">Clear Filter &times;</a>
        </div>
      <?php endif; ?>

      <!-- BLOG GRID -->
      <?php if (!empty($blogs)): ?>
        <div class="blog-grid">
          <?php foreach ($blogs as $blog): ?>
            <article class="blog-card">
              <div class="blog-card-media">
                <a href="blog-detail.php?slug=<?= urlencode($blog['slug']) ?>" tabindex="-1">
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
                  <a href="blog-detail.php?slug=<?= urlencode($blog['slug']) ?>">
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
                  <a href="blog-detail.php?slug=<?= urlencode($blog['slug']) ?>" class="read-more-link" aria-label="Read <?= e($blog['title']) ?>">
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
          <a href="blog.php" class="btn btn-secondary btn-sm">Reset All Filters</a>
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
        <a href="contact.html" class="btn btn-primary btn-lg btn-magnetic">
          Book Advisory Session
          <span class="btn-icon-right">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </span>
        </a>
      </section>

    </div>
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
          <h4 class="footer-heading">Core Practices</h4>
          <ul class="footer-links">
            <li><a href="service-fractional-cmo.html" class="footer-link">Fractional CMO Advisory</a></li>
            <li><a href="service-brand-strategy.html" class="footer-link">Brand Strategy &amp; Positioning</a></li>
            <li><a href="service-performance-marketing.html" class="footer-link">Performance Marketing</a></li>
            <li><a href="service-seo-consulting.html" class="footer-link">SEO Architecture</a></li>
            <li><a href="service-b2b-lead-generation.html" class="footer-link">B2B Lead Generation &amp; CRO</a></li>
            <li><a href="service-content-marketing.html" class="footer-link">Editorial Content Marketing</a></li>
            <li><a href="service-marketing-analytics.html" class="footer-link">Analytics &amp; Attribution</a></li>
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
</body>
</html>

