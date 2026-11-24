<?php
/**
 * RITWIK SACHDEVA - BLOG CMS & EDITORIAL SUITE
 * Enterprise-grade 2-column editorial console matching the reference specification.
 * Full CRUD, Rich Toolbar, FAQ Builder with Schema.org FAQPage generation,
 * Live Google Search Snippet Preview, SEO character counters, and Bidirectional Markdown Sync.
 */

$pageTitle = 'Blog CMS & Editorial Suite';
require_once __DIR__ . '/includes/header.php';
if (file_exists(__DIR__ . '/../includes/markdown.php')) {
    require_once __DIR__ . '/../includes/markdown.php';
}
if (file_exists(__DIR__ . '/../includes/seo.php')) {
    require_once __DIR__ . '/../includes/seo.php';
}

$id = (int)($_GET['id'] ?? 0);
$isEditing = $id > 0;

$blog = [
    'id' => 0,
    'title' => '',
    'slug' => '',
    'excerpt' => '',
    'content' => '',
    'featured_image' => '',
    'featured_image_alt' => '',
    'category_id' => null,
    'author_id' => 1,
    'author_name' => 'Ritwik Sachdeva',
    'status' => 'draft',
    'is_featured' => 0,
    'reading_time' => 5,
    'faqs_json' => '',
    'published_at' => null,
    'scheduled_for' => null
];

$existingTagsStr = '';
$seo = [
    'meta_title' => '',
    'meta_description' => '',
    'canonical_url' => '',
    'target_keywords' => '',
    'og_title' => '',
    'og_description' => '',
    'og_image' => '',
    'robots' => 'index, follow'
];

if ($isEditing) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $found = $stmt->fetch();
    if (!$found) {
        $_SESSION['flash_error'] = "Article not found.";
        header('Location: blogs.php');
        exit;
    }
    $blog = array_merge($blog, $found);

    // Load Tags
    try {
        $tagStmt = $pdo->prepare("
            SELECT t.name FROM blog_tags t
            JOIN blog_tag_relations btr ON btr.tag_id = t.id
            WHERE btr.blog_id = :id
        ");
        $tagStmt->execute([':id' => $id]);
        $tagNames = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
        $existingTagsStr = implode(', ', $tagNames);
    } catch (Exception $e) {}

    // Load SEO
    try {
        $seoStmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE entity_type = 'blog' AND entity_id = :id");
        $seoStmt->execute([':id' => $id]);
        $foundSeo = $seoStmt->fetch();
        if ($foundSeo) {
            $seo = array_merge($seo, $foundSeo);
        }
    } catch (Exception $e) {}
}

// Decode existing FAQs
$existingFaqs = [];
if (!empty($blog['faqs_json'])) {
    $decodedFaqs = json_decode($blog['faqs_json'], true);
    if (is_array($decodedFaqs)) {
        $existingFaqs = $decodedFaqs;
    }
}

// Handle Form Submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!auth_verify_csrf($csrf)) {
        $errors[] = 'Security token expired. Please refresh and try again.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        if (empty($slug)) {
            $slug = generate_slug($title);
        } else {
            $slug = generate_slug($slug);
        }

        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $authorName = trim($_POST['author_name'] ?? 'Ritwik Sachdeva');
        $statusAction = $_POST['status_action'] ?? $_POST['status'] ?? 'draft';
        if (isset($_POST['action_publish'])) {
            $status = 'published';
        } elseif (isset($_POST['action_draft'])) {
            $status = 'draft';
        } else {
            $status = in_array($statusAction, ['published', 'draft', 'scheduled']) ? $statusAction : 'draft';
        }

        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $readingTime = max(1, (int)($_POST['reading_time'] ?? calculate_reading_time($content)));
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $featuredImageAlt = trim($_POST['featured_image_alt'] ?? '');
        $tagsRaw = trim($_POST['tags'] ?? '');

        // Keep the editable author field and the normalized author relation in
        // sync.  This also prevents every new article from being hard-coded to
        // author ID 1.
        $authorSlug = generate_slug($authorName) ?: 'ritwik-sachdeva';
        $authorStmt = $pdo->prepare("SELECT id FROM blog_authors WHERE slug = :slug LIMIT 1");
        $authorStmt->execute([':slug' => $authorSlug]);
        $authorId = (int)$authorStmt->fetchColumn();
        if (!$authorId) {
            $authorInsert = $pdo->prepare("INSERT INTO blog_authors (name, slug) VALUES (:name, :slug)");
            $authorInsert->execute([':name' => $authorName ?: 'Ritwik Sachdeva', ':slug' => $authorSlug]);
            $authorId = (int)$pdo->lastInsertId();
        }

        // FAQs extraction
        $faqs = [];
        if (!empty($_POST['faq_q']) && is_array($_POST['faq_q'])) {
            for ($i = 0; $i < count($_POST['faq_q']); $i++) {
                $q = trim($_POST['faq_q'][$i] ?? '');
                $a = trim($_POST['faq_a'][$i] ?? '');
                if ($q !== '' && $a !== '') {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }
        $faqsJson = !empty($faqs) ? json_encode($faqs, JSON_UNESCAPED_UNICODE) : null;

        // SEO Fields
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDescription = trim($_POST['meta_description'] ?? '');
        $targetKeywords = trim($_POST['target_keywords'] ?? '');
        $canonicalUrl = trim($_POST['canonical_url'] ?? '');
        $ogTitle = trim($_POST['og_title'] ?? '');
        $ogDescription = trim($_POST['og_description'] ?? '');
        $ogImage = trim($_POST['og_image'] ?? '');
        $robots = trim($_POST['robots'] ?? 'index, follow');

        // File upload handling for featured image
        if (!empty($_FILES['featured_image_file']['name']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/blog';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileExt = strtolower(pathinfo($_FILES['featured_image_file']['name'], PATHINFO_EXTENSION));
            if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
                $newFilename = 'article-' . $slug . '-' . time() . '.' . $fileExt;
                $destPath = $uploadDir . '/' . $newFilename;
                if (move_uploaded_file($_FILES['featured_image_file']['tmp_name'], $destPath)) {
                    $featuredImage = 'uploads/blog/' . $newFilename;
                }
            } else {
                $errors[] = 'Invalid image file type. Please upload a WebP, PNG, JPG, or SVG image.';
            }
        }

        if (empty($title)) {
            $errors[] = 'Article title is required.';
        }
        if (empty($slug)) {
            $errors[] = 'Article slug is required.';
        }
        if (empty($excerpt)) {
            $errors[] = 'Article excerpt is required.';
        }
        if (empty($content)) {
            $errors[] = 'Article body content cannot be empty.';
        }

        // Check slug uniqueness
        $slugCheckQuery = "SELECT id FROM blogs WHERE slug = :slug";
        $slugParams = [':slug' => $slug];
        if ($isEditing) {
            $slugCheckQuery .= " AND id != :id";
            $slugParams[':id'] = $id;
        }
        $slugCheck = $pdo->prepare($slugCheckQuery);
        $slugCheck->execute($slugParams);
        if ($slugCheck->fetch()) {
            $errors[] = "The slug '{$slug}' is already in use by another article. Please customize it.";
        }

        if (empty($errors)) {
            $pubDateInput = trim($_POST['published_at'] ?? '');
            if (!empty($pubDateInput)) {
                $publishedAt = date('Y-m-d H:i:s', strtotime($pubDateInput));
            } elseif ($status === 'published') {
                $publishedAt = $blog['published_at'] ?: date('Y-m-d H:i:s');
            } else {
                $publishedAt = null;
            }

            if ($isEditing) {
                // Save revision before updating
                try {
                    $revStmt = $pdo->prepare("
                        INSERT INTO blog_revisions (blog_id, admin_id, title, content, excerpt, revision_summary)
                        VALUES (:bid, :aid, :title, :content, :excerpt, 'Saved from Editorial Suite')
                    ");
                    $revStmt->execute([
                        ':bid'     => $id,
                        ':aid'     => $currentUser['id'] ?? 1,
                        ':title'   => $blog['title'],
                        ':content' => $blog['content'],
                        ':excerpt' => $blog['excerpt']
                    ]);
                } catch (Exception $e) {}

                // Update Blog
                $updateStmt = $pdo->prepare("
                    UPDATE blogs SET
                        title = :title,
                        slug = :slug,
                        excerpt = :excerpt,
                        content = :content,
                        featured_image = :featured_image,
                        featured_image_alt = :featured_image_alt,
                        category_id = :category_id,
                        author_id = :author_id,
                        status = :status,
                        is_featured = :is_featured,
                        reading_time = :reading_time,
                        faqs_json = :faqs_json,
                        published_at = :published_at,
                        updated_at = datetime('now')
                    WHERE id = :id
                ");
                $updateStmt->execute([
                    ':title'              => $title,
                    ':slug'               => $slug,
                    ':excerpt'            => $excerpt,
                    ':content'            => $content,
                    ':featured_image'     => $featuredImage ?: null,
                    ':featured_image_alt' => $featuredImageAlt ?: null,
                    ':category_id'        => $categoryId,
                    ':author_id'          => $authorId,
                    ':status'             => $status,
                    ':is_featured'        => $isFeatured,
                    ':reading_time'       => $readingTime,
                    ':faqs_json'          => $faqsJson,
                    ':published_at'       => $publishedAt,
                    ':id'                 => $id
                ]);
                $savedId = $id;
            } else {
                // Insert New Blog
                $insertStmt = $pdo->prepare("
                    INSERT INTO blogs (
                        title, slug, excerpt, content, featured_image, featured_image_alt,
                        category_id, author_id, status, is_featured, reading_time, faqs_json, published_at
                    ) VALUES (
                        :title, :slug, :excerpt, :content, :featured_image, :featured_image_alt,
                        :category_id, :author_id, :status, :is_featured, :reading_time, :faqs_json, :published_at
                    )
                ");
                $insertStmt->execute([
                    ':title'              => $title,
                    ':slug'               => $slug,
                    ':excerpt'            => $excerpt,
                    ':content'            => $content,
                    ':featured_image'     => $featuredImage ?: null,
                    ':featured_image_alt' => $featuredImageAlt ?: null,
                    ':category_id'        => $categoryId,
                    ':author_id'          => $authorId,
                    ':status'             => $status,
                    ':is_featured'        => $isFeatured,
                    ':reading_time'       => $readingTime,
                    ':faqs_json'          => $faqsJson,
                    ':published_at'       => $publishedAt
                ]);
                $savedId = (int)$pdo->lastInsertId();
            }

            // Sync Tags
            try {
                $pdo->prepare("DELETE FROM blog_tag_relations WHERE blog_id = :id")->execute([':id' => $savedId]);
                if (!empty($tagsRaw)) {
                    $tagsArr = array_filter(array_map('trim', explode(',', $tagsRaw)));
                    foreach ($tagsArr as $tagName) {
                        $tagSlug = generate_slug($tagName);
                        $tCheck = $pdo->prepare("SELECT id FROM blog_tags WHERE slug = :slug");
                        $tCheck->execute([':slug' => $tagSlug]);
                        $tagId = $tCheck->fetchColumn();

                        if (!$tagId) {
                            $tIns = $pdo->prepare("INSERT INTO blog_tags (name, slug) VALUES (:name, :slug)");
                            $tIns->execute([':name' => $tagName, ':slug' => $tagSlug]);
                            $tagId = (int)$pdo->lastInsertId();
                        }

                        $relIns = $pdo->prepare("INSERT OR IGNORE INTO blog_tag_relations (blog_id, tag_id) VALUES (:bid, :tid)");
                        $relIns->execute([':bid' => $savedId, ':tid' => $tagId]);
                    }
                }
            } catch (Exception $e) {}

            // Upsert SEO Metadata
            try {
                $seoCheck = $pdo->prepare("SELECT id FROM seo_metadata WHERE entity_type = 'blog' AND entity_id = :id");
                $seoCheck->execute([':id' => $savedId]);
                $seoId = $seoCheck->fetchColumn();

                if ($seoId) {
                    $seoUp = $pdo->prepare("
                        UPDATE seo_metadata SET
                            meta_title = :title,
                            meta_description = :desc,
                            target_keywords = :keywords,
                            canonical_url = :canon,
                            og_title = :og_title,
                            og_description = :og_desc,
                            og_image = :og_img,
                            robots = :robots,
                            updated_at = datetime('now')
                        WHERE id = :id
                    ");
                    $seoUp->execute([
                        ':title'     => $metaTitle ?: null,
                        ':desc'      => $metaDescription ?: null,
                        ':keywords'  => $targetKeywords ?: null,
                        ':canon'     => $canonicalUrl ?: null,
                        ':og_title'  => $ogTitle ?: null,
                        ':og_desc'   => $ogDescription ?: null,
                        ':og_img'    => $ogImage ?: null,
                        ':robots'    => $robots,
                        ':id'        => $seoId
                    ]);
                } else {
                    $seoIns = $pdo->prepare("
                        INSERT INTO seo_metadata (entity_type, entity_id, meta_title, meta_description, target_keywords, canonical_url, og_title, og_description, og_image, robots)
                        VALUES ('blog', :id, :title, :desc, :keywords, :canon, :og_title, :og_desc, :og_img, :robots)
                    ");
                    $seoIns->execute([
                        ':id'        => $savedId,
                        ':title'     => $metaTitle ?: null,
                        ':desc'      => $metaDescription ?: null,
                        ':keywords'  => $targetKeywords ?: null,
                        ':canon'     => $canonicalUrl ?: null,
                        ':og_title'  => $ogTitle ?: null,
                        ':og_desc'   => $ogDescription ?: null,
                        ':og_img'    => $ogImage ?: null,
                        ':robots'    => $robots
                    ]);
                }
            } catch (Exception $e) {}

            // Sync physical Markdown file
            try {
                MarkdownManager::syncBlog($savedId);
            } catch (Exception $e) {}

            // Re-generate Sitemap if published
            if ($status === 'published') {
                try {
                    SeoManager::generateSitemap();
                    SeoManager::generateLlmsIndex();
                } catch (Exception $e) {}
            }

            $_SESSION['flash_success'] = "Article saved and published status updated successfully!";
            header("Location: blog-edit.php?id={$savedId}");
            exit;
        }
    }
}

// Fetch categories for select menu
$categories = [];
try {
    $categories = $pdo->query("SELECT id, name FROM blog_categories ORDER BY name ASC")->fetchAll();
} catch (Exception $e) {}
?>

<style>
/* Blog CMS Dark Card Editorial Theme Overrides */
.cms-console-header {
  margin-bottom: 24px;
}
.cms-top-breadcrumb {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  color: var(--admin-text-muted);
  margin-bottom: 8px;
}
.cms-user-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(15, 23, 42, 0.05);
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 11.5px;
  font-weight: 600;
}
.cms-user-badge {
  background: #F59E0B;
  color: #0F172A;
  padding: 1px 6px;
  border-radius: 4px;
  font-size: 10px;
  font-weight: 800;
  letter-spacing: 0.05em;
}
.cms-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}
.cms-page-title {
  font-family: var(--admin-font-heading);
  font-size: 26px;
  font-weight: 800;
  color: var(--admin-text-main);
  letter-spacing: -0.02em;
  margin: 0 0 4px;
}
.cms-page-desc {
  font-size: 13.5px;
  color: var(--admin-text-muted);
  margin: 0;
}

/* Card Styling */
.cms-card {
  background: var(--admin-card);
  border: 1px solid var(--admin-border);
  border-radius: var(--admin-radius);
  box-shadow: var(--admin-shadow);
  margin-bottom: 22px;
  overflow: hidden;
}
.cms-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--admin-border-light);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #FAFAF9;
}
.cms-card-title {
  font-size: 14.5px;
  font-weight: 700;
  color: var(--admin-text-main);
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
}
.cms-card-body {
  padding: 20px;
}

/* Status Badges */
.cms-badge-draft {
  background: #FEF3C7;
  color: #92400E;
  border: 1px solid #FDE68A;
  padding: 2px 8px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
.cms-badge-pub {
  background: #DCFCE7;
  color: #166534;
  border: 1px solid #BBF7D0;
  padding: 2px 8px;
  border-radius: 999px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Slug Input Group */
.cms-slug-group {
  display: flex;
  align-items: center;
  border: 1px solid var(--admin-border);
  border-radius: var(--admin-radius);
  background: #F8FAFC;
  overflow: hidden;
}
.cms-slug-prefix {
  padding: 9px 12px;
  font-size: 13px;
  color: #64748B;
  font-weight: 600;
  background: #F1F5F9;
  border-right: 1px solid var(--admin-border);
  user-select: none;
}
.cms-slug-input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 9px 12px;
  font-size: 13.5px;
  font-family: monospace;
  font-weight: 600;
  color: var(--admin-text-main);
}
.cms-slug-input:focus {
  outline: none;
  background: #FFFFFF;
}

/* Counter Tags */
.cms-counter {
  font-size: 11.5px;
  color: var(--admin-text-muted);
  font-weight: 600;
}

/* Rich Toolbar */
.cms-toolbar {
  display: flex;
  align-items: center;
  gap: 4px;
  flex-wrap: wrap;
  padding: 8px 12px;
  background: #F8FAFC;
  border: 1px solid var(--admin-border);
  border-bottom: none;
  border-radius: var(--admin-radius) var(--admin-radius) 0 0;
}
.cms-tool-btn {
  background: #FFFFFF;
  border: 1px solid #CBD5E1;
  border-radius: 4px;
  padding: 4px 8px;
  font-size: 12px;
  font-weight: 600;
  color: #334155;
  cursor: pointer;
  transition: all 0.15s ease;
}
.cms-tool-btn:hover {
  background: #E2E8F0;
  color: #0F172A;
}
.cms-content-textarea {
  border-radius: 0 0 var(--admin-radius) var(--admin-radius) !important;
  font-family: inherit;
  font-size: 14.5px;
  line-height: 1.7;
}

/* Google Search Snippet Preview Box */
.cms-google-preview {
  background: #0F172A;
  border: 1px solid #334155;
  border-radius: var(--admin-radius);
  padding: 16px 20px;
  margin-bottom: 20px;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
}
.cms-google-preview-label {
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.08em;
  color: #94A3B8;
  margin-bottom: 8px;
  text-transform: uppercase;
}
.cms-preview-url {
  font-size: 12px;
  color: #38BDF8;
  margin-bottom: 3px;
  font-family: monospace;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.cms-preview-title {
  font-size: 17px;
  font-weight: 600;
  color: #60A5FA;
  margin: 0 0 4px;
  line-height: 1.3;
}
.cms-preview-snippet {
  font-size: 13px;
  color: #CBD5E1;
  line-height: 1.5;
  margin: 0;
}

/* FAQ Builder Accordion Cards */
.faq-builder-item {
  background: #F8FAFC;
  border: 1px solid var(--admin-border);
  border-radius: var(--admin-radius);
  padding: 14px 16px;
  margin-bottom: 12px;
  position: relative;
}
.faq-item-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.faq-num-title {
  font-size: 12px;
  font-weight: 700;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Action Buttons */
.btn-publish-gold {
  background: #F59E0B;
  color: #0F172A;
  font-weight: 800;
  border: 1px solid #D97706;
  border-radius: var(--admin-radius);
  padding: 12px 20px;
  font-size: 14px;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
  transition: all 0.2s ease;
}
.btn-publish-gold:hover {
  background: #D97706;
  color: #FFFFFF;
}
.btn-save-draft {
  background: #1E293B;
  color: #FFFFFF;
  font-weight: 700;
  border: 1px solid #0F172A;
  border-radius: var(--admin-radius);
  padding: 10px 20px;
  font-size: 13.5px;
  cursor: pointer;
  transition: all 0.2s ease;
}
.btn-save-draft:hover {
  background: #0F172A;
}

/* Image preview frame */
.cms-image-preview-frame {
  width: 100%;
  aspect-ratio: 16/9;
  background: #F1F5F9;
  border: 2px dashed #CBD5E1;
  border-radius: var(--admin-radius);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  margin-bottom: 12px;
}
.cms-image-preview-frame img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<div class="cms-console-header">
  <div class="cms-top-breadcrumb">
    <div>Admin / Blog CMS &amp; Article Editor</div>
    <div class="cms-user-pill">
      Signed in as <?= e($currentUser['email'] ?? 'admin@ritwiksachdeva.in') ?>
      <span class="cms-user-badge">SUPER ADMIN</span>
    </div>
  </div>
  <div class="cms-title-row">
    <div>
      <h1 class="cms-page-title">Blog CMS &amp; Editorial Suite</h1>
      <p class="cms-page-desc">Publish high-ranking technical guides, buyer guides, and case studies with schema, rich typography &amp; FAQs.</p>
    </div>
    <div>
      <a href="blogs.php" class="btn-admin btn-admin-secondary">&larr; Back to Articles</a>
      <?php if ($isEditing && !empty($blog['slug'])): ?>
        <a href="../blog-detail.php?slug=<?= urlencode($blog['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="margin-left: 6px;">
          Live Preview &nearr;
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="admin-alert admin-alert-danger" style="margin-bottom: 20px;">
    <ul style="margin: 0; padding-left: 18px;">
      <?php foreach ($errors as $err): ?>
        <li><?= e($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="POST" action="blog-edit.php<?= $isEditing ? '?id=' . $id : '' ?>" enctype="multipart/form-data" id="article-form">
  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">

  <!-- 2-COLUMN LAYOUT -->
  <div style="display: grid; grid-template-columns: minmax(0, 1.9fr) minmax(310px, 1fr); gap: 24px; align-items: flex-start;">

    <!-- =====================================================================
         LEFT COLUMN: Article Details, Body, FAQ Builder, and SEO
         ===================================================================== -->
    <div>

      <!-- 1. ARTICLE INFORMATION & ESSENTIALS -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">
            <span>📄</span> Article Information &amp; Essentials
          </h2>
          <div>
            <?php if ($blog['status'] === 'published'): ?>
              <span class="cms-badge-pub">Live / Published</span>
            <?php else: ?>
              <span class="cms-badge-draft">Draft</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="cms-card-body">
          
          <!-- Article Title -->
          <div class="form-group-admin">
            <label for="title" class="form-label-admin">Article Title *</label>
            <input type="text" id="title" name="title" class="form-control-admin" 
                   value="<?= e($blog['title']) ?>" 
                   placeholder="e.g. Complete Guide to DTF Printing: Fabrics, Heat Press Settings & Lon" 
                   required autocomplete="off">
          </div>

          <!-- SEO Friendly Slug -->
          <div class="form-group-admin">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
              <label for="slug" class="form-label-admin" style="margin: 0;">SEO Friendly Slug (Canonical URL Path) *</label>
              <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" id="btn-toggle-slug" style="padding: 2px 8px; font-size: 11px;">
                Edit Slug
              </button>
            </div>
            <div class="cms-slug-group">
              <span class="cms-slug-prefix">/blog/</span>
              <input type="text" id="slug" name="slug" class="cms-slug-input" 
                     value="<?= e($blog['slug']) ?>" 
                     placeholder="complete-guide-to-dtf-printing" 
                     readonly required>
              <span class="cms-slug-prefix">/</span>
            </div>
            <div style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">
              Automatically generated from title. Click 'Edit Slug' to customize manually.
            </div>
          </div>

          <!-- Category & Tags 2-Column Row -->
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group-admin">
              <label for="category_id" class="form-label-admin">Category *</label>
              <select id="category_id" name="category_id" class="form-control-admin" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= ($blog['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                    <?= e($cat['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group-admin">
              <label for="tags" class="form-label-admin">Tags (comma-separated)</label>
              <input type="text" id="tags" name="tags" class="form-control-admin" 
                     value="<?= e($existingTagsStr) ?>" 
                     placeholder="e.g. DTF Printing, Apparel, Heat Press, D">
            </div>
          </div>

          <!-- Short Excerpt / Lead Summary -->
          <div class="form-group-admin" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
              <label for="excerpt" class="form-label-admin" style="margin: 0;">Short Excerpt / Lead Summary *</label>
              <span class="cms-counter" id="excerpt-counter">0 / 180</span>
            </div>
            <textarea id="excerpt" name="excerpt" rows="3" class="form-control-admin" 
                      placeholder="A concise, high-impact 2-3 sentence teaser shown on archive cards and search snippets..." 
                      maxlength="300" required><?= e($blog['excerpt']) ?></textarea>
            <div style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">
              Shown on blog cards, search snippet and article header lead text.
            </div>
          </div>

        </div>
      </div>

      <!-- 2. ARTICLE CONTENT BODY -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">
            <span>✍️</span> Article Content Body
          </h2>
          <div class="cms-counter" id="body-counter">
            Words: 0 | Chars: 0
          </div>
        </div>
        <div class="cms-card-body" style="padding-top: 14px;">

          <!-- Rich Formatting Toolbar -->
          <div class="cms-toolbar">
            <select class="cms-tool-btn" id="tool-heading" onchange="insertHeading(this.value)">
              <option value="">Paragraph</option>
              <option value="## ">Heading 2</option>
              <option value="### ">Heading 3</option>
              <option value="#### ">Heading 4</option>
            </select>
            <button type="button" class="cms-tool-btn" onclick="wrapText('**', '**')" title="Bold"><strong>B</strong></button>
            <button type="button" class="cms-tool-btn" onclick="wrapText('*', '*')" title="Italic"><em>I</em></button>
            <button type="button" class="cms-tool-btn" onclick="wrapText('<u>', '</u>')" title="Underline"><u>U</u></button>
            <button type="button" class="cms-tool-btn" onclick="wrapText('~~', '~~')" title="Strikethrough"><s>S</s></button>
            <span style="color:#CBD5E1;">|</span>
            <button type="button" class="cms-tool-btn" onclick="insertLinePrefix('- ')" title="Bullet List">&bull; List</button>
            <button type="button" class="cms-tool-btn" onclick="insertLinePrefix('1. ')" title="Numbered List">1. List</button>
            <button type="button" class="cms-tool-btn" onclick="insertLink()" title="Insert Link">&#128279; Link</button>
            <button type="button" class="cms-tool-btn" onclick="insertTable()" title="Insert Table">&#128202; Table</button>
            <button type="button" class="cms-tool-btn" onclick="insertText('\n---\n')" title="Horizontal Rule">&mdash; HR</button>
            <button type="button" class="cms-tool-btn" onclick="wrapText('`', '`')" title="Inline Code">&lt;/&gt; Code</button>
            <button type="button" class="cms-tool-btn" onclick="insertLinePrefix('> ')" title="Blockquote">&ldquo; Quote</button>
          </div>

          <!-- Body Textarea -->
          <textarea id="content" name="content" rows="18" class="form-control-admin cms-content-textarea" 
                    placeholder="Write your article introduction here..." required><?= e($blog['content']) ?></textarea>

        </div>
      </div>

      <!-- 3. FREQUENTLY ASKED QUESTIONS (FAQ BUILDER) -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">
            <span>❓</span> Frequently Asked Questions (FAQ Builder)
          </h2>
          <div>
            <button type="button" class="btn-admin btn-admin-primary btn-admin-sm" id="btn-add-faq" style="background:#F59E0B; color:#0F172A; border-color:#D97706; font-weight:700;">
              + Add Question
            </button>
          </div>
        </div>
        <div class="cms-card-body">
          <p style="font-size: 12.5px; color: var(--admin-text-muted); margin-bottom: 16px; line-height: 1.5;">
            Questions added here will render as interactive accordion cards below your article and will automatically generate a dedicated <strong>Schema.org FAQPage JSON-LD</strong> block for Google Rich Search Results.
          </p>

          <div id="faq-list-container">
            <?php if (empty($existingFaqs)): ?>
              <div id="faq-empty-state" style="padding: 24px; text-align: center; border: 1.5px dashed var(--admin-border); border-radius: var(--admin-radius); color: var(--admin-text-muted); font-size: 13px;">
                No FAQs added yet. Click <strong>"+ Add Question"</strong> to create structured FAQs for this article.
              </div>
            <?php endif; ?>

            <?php foreach ($existingFaqs as $idx => $faqItem): ?>
              <div class="faq-builder-item">
                <div class="faq-item-header">
                  <span class="faq-num-title">Question #<?= ($idx + 1) ?></span>
                  <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" style="padding: 2px 6px; font-size: 11px;" onclick="this.closest('.faq-builder-item').remove(); checkFaqEmpty();">
                    &times; Remove
                  </button>
                </div>
                <div class="form-group-admin" style="margin-bottom: 8px;">
                  <input type="text" name="faq_q[]" class="form-control-admin" placeholder="e.g. How does performance marketing attribution work with privacy updates?" value="<?= e($faqItem['question'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin" style="margin-bottom: 0;">
                  <textarea name="faq_a[]" rows="2" class="form-control-admin" placeholder="Answer explanation that will appear in the accordion and FAQPage schema..." required><?= e($faqItem['answer'] ?? '') ?></textarea>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>

      <!-- 4. SEO & SOCIAL GRAPH -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">🔍 Search Engine Optimization (SEO) &amp; Social Graph</h2>
        </div>
        <div class="cms-card-body">
          <div class="cms-google-preview">
            <div class="cms-google-preview-label">Google Search Result Snippet Preview</div>
            <div id="preview-url" class="cms-preview-url">https://www.ritwiksachdeva.in/blog/article-slug/</div>
            <h3 id="preview-title" class="cms-preview-title">Article Title | Ritwik Sachdeva</h3>
            <p id="preview-snippet" class="cms-preview-snippet">Search snippet description will appear here as you type.</p>
          </div>

          <div class="form-group-admin">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;"><label for="meta_title" class="form-label-admin" style="margin:0;">SEO Meta Title</label><span id="meta-title-counter" class="cms-counter">0 / 60</span></div>
            <input type="text" id="meta_title" name="meta_title" class="form-control-admin" maxlength="70" value="<?= e($seo['meta_title']) ?>" placeholder="Leave empty to use article title + Ritwik Sachdeva">
            <div style="font-size:11px;color:var(--admin-text-muted);margin-top:4px;">Recommended: 50–60 characters.</div>
          </div>
          <div class="form-group-admin">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;"><label for="meta_description" class="form-label-admin" style="margin:0;">SEO Meta Description</label><span id="meta-desc-counter" class="cms-counter">0 / 160</span></div>
            <textarea id="meta_description" name="meta_description" rows="3" class="form-control-admin" maxlength="170" placeholder="Concise summary answering the search query with high-intent keywords..."><?= e($seo['meta_description']) ?></textarea>
            <div style="font-size:11px;color:var(--admin-text-muted);margin-top:4px;">Recommended: 150–160 characters.</div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group-admin"><label for="target_keywords" class="form-label-admin">Target Keywords</label><input id="target_keywords" name="target_keywords" class="form-control-admin" value="<?= e($seo['target_keywords']) ?>" placeholder="growth strategy, business consulting"></div>
            <div class="form-group-admin"><label for="canonical_url" class="form-label-admin">Canonical URL Override</label><input type="url" id="canonical_url" name="canonical_url" class="form-control-admin" value="<?= e($seo['canonical_url']) ?>" placeholder="https://www.ritwiksachdeva.in/blog/custom-slug/"></div>
          </div>
          <div style="padding-top:4px;border-top:1px solid var(--admin-border-light);">
            <p style="font-size:12px;font-weight:700;margin:14px 0 10px;">Social Sharing (Open Graph Meta)</p>
            <div class="form-group-admin"><label for="og_title" class="form-label-admin">OG Title</label><input id="og_title" name="og_title" class="form-control-admin" value="<?= e($seo['og_title']) ?>" placeholder="Defaults to SEO title"></div>
            <div class="form-group-admin"><label for="og_image" class="form-label-admin">OG Image URL</label><input id="og_image" name="og_image" class="form-control-admin" value="<?= e($seo['og_image']) ?>" placeholder="Defaults to featured image"></div>
            <div class="form-group-admin" style="margin-bottom:0;"><label for="og_description" class="form-label-admin">OG Description</label><textarea id="og_description" name="og_description" rows="2" class="form-control-admin" placeholder="Defaults to meta description"><?= e($seo['og_description']) ?></textarea></div>
          </div>
        </div>
      </div>

    </div>

    <!-- =====================================================================
         RIGHT COLUMN: Publishing Status, Author, Media & Actions
         ===================================================================== -->
    <div>

      <!-- 1. PUBLISHING STATUS -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">
            <span>🚀</span> Publishing Status
          </h2>
        </div>
        <div class="cms-card-body">

          <!-- Status Dropdown -->
          <div class="form-group-admin">
            <label for="status" class="form-label-admin">Status</label>
            <select id="status" name="status" class="form-control-admin" style="font-weight: 700;">
              <option value="published" <?= ($blog['status'] === 'published') ? 'selected' : '' ?>>
                Published (Live Storefront)
              </option>
              <option value="draft" <?= ($blog['status'] === 'draft') ? 'selected' : '' ?>>
                Draft
              </option>
              <option value="scheduled" <?= ($blog['status'] === 'scheduled') ? 'selected' : '' ?>>
                Scheduled
              </option>
            </select>
          </div>

          <!-- Publish Date & Time -->
          <div class="form-group-admin">
            <label for="published_at" class="form-label-admin">Publish Date &amp; Time</label>
            <input type="datetime-local" id="published_at" name="published_at" class="form-control-admin"
                   value="<?= !empty($blog['published_at']) ? date('Y-m-d\TH:i', strtotime($blog['published_at'])) : date('Y-m-d\TH:i') ?>">
          </div>

          <!-- Author Name -->
          <div class="form-group-admin">
            <label for="author_name" class="form-label-admin">Author Name</label>
            <input type="text" id="author_name" name="author_name" class="form-control-admin" 
                   value="<?= e($blog['author_name'] ?? 'Ritwik Sachdeva') ?>" required>
          </div>

          <!-- Estimated Read Time with Recalc button -->
          <div class="form-group-admin">
            <label for="reading_time" class="form-label-admin">Estimated Read Time</label>
            <div style="display: flex; gap: 8px;">
              <input type="number" id="reading_time" name="reading_time" class="form-control-admin" 
                     value="<?= (int)$blog['reading_time'] ?>" min="1" max="60" style="max-width: 120px;">
              <button type="button" class="btn-admin btn-admin-secondary" id="btn-recalc-time" style="font-size: 12px; font-weight: 600;">
                Recalc
              </button>
            </div>
            <div style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">
              Calculated automatically based on 200 words/min.
            </div>
          </div>

          <!-- Featured Checkbox -->
          <div class="form-group-admin" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; background: #F8FAFC; padding: 10px 12px; border-radius: var(--admin-radius); border: 1px solid var(--admin-border);">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" <?= $blog['is_featured'] ? 'checked' : '' ?> style="width: 16px; height: 16px; accent-color: #F59E0B;">
            <label for="is_featured" style="font-size: 13px; font-weight: 600; cursor: pointer; margin: 0; color: #0F172A;">
              Mark as Featured / Highlighted Article
            </label>
          </div>

          <!-- Action Buttons -->
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <button type="submit" name="action_publish" value="publish" class="btn-publish-gold" style="width: 100%;">
              Publish Article Now
            </button>
            <button type="submit" name="action_draft" value="draft" class="btn-save-draft" style="width: 100%;">
              Save as Draft
            </button>
          </div>

        </div>
      </div>

      <!-- 2. FEATURED MEDIA & ALT -->
      <div class="cms-card">
        <div class="cms-card-header">
          <h2 class="cms-card-title">
            <span>🖼️</span> Featured Media &amp; Alt
          </h2>
        </div>
        <div class="cms-card-body">

          <!-- Image Preview Frame -->
          <div class="cms-image-preview-frame" id="image-preview-frame">
            <?php if (!empty($blog['featured_image'])): ?>
              <img src="../<?= e($blog['featured_image']) ?>" alt="<?= e($blog['featured_image_alt']) ?>" id="preview-img">
            <?php else: ?>
              <span id="no-img-text" style="color: #94A3B8; font-size: 13px; font-weight: 600;">No Image Selected</span>
              <img src="" alt="" id="preview-img" style="display: none;">
            <?php endif; ?>
          </div>

          <!-- Upload New Image File -->
          <div class="form-group-admin">
            <label for="featured_image_file" class="form-label-admin">Upload New Image</label>
            <input type="file" id="featured_image_file" name="featured_image_file" class="form-control-admin" accept="image/*" onchange="previewSelectedImage(this)">
            <div style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">
              Recommended: 1200x675px landscape image.
            </div>
          </div>

          <!-- Or Image URL / Path -->
          <div class="form-group-admin">
            <label for="featured_image" class="form-label-admin">Or Existing Image Path</label>
            <input type="text" id="featured_image" name="featured_image" class="form-control-admin" 
                   value="<?= e($blog['featured_image']) ?>" 
                   placeholder="assets/images/about-consultant.svg">
          </div>

          <!-- Featured Image Alt Text -->
          <div class="form-group-admin" style="margin-bottom: 0;">
            <label for="featured_image_alt" class="form-label-admin">Featured Image Alt Text *</label>
            <input type="text" id="featured_image_alt" name="featured_image_alt" class="form-control-admin" 
                   value="<?= e($blog['featured_image_alt']) ?>" 
                   placeholder="Descriptive text for SEO & screen reader" required>
            <div style="font-size: 11px; color: var(--admin-text-muted); margin-top: 4px;">
              Important for technical SEO image indexing and accessibility.
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</form>

<script>
  // DOM Elements
  const titleInput = document.getElementById('title');
  const slugInput = document.getElementById('slug');
  const btnToggleSlug = document.getElementById('btn-toggle-slug');
  const excerptInput = document.getElementById('excerpt');
  const excerptCounter = document.getElementById('excerpt-counter');
  const contentInput = document.getElementById('content');
  const bodyCounter = document.getElementById('body-counter');
  const metaTitleInput = document.getElementById('meta_title');
  const metaTitleCounter = document.getElementById('meta-title-counter');
  const metaDescInput = document.getElementById('meta_description');
  const metaDescCounter = document.getElementById('meta-desc-counter');
  const previewUrl = document.getElementById('preview-url');
  const previewTitle = document.getElementById('preview-title');
  const previewSnippet = document.getElementById('preview-snippet');
  const readingTimeInput = document.getElementById('reading_time');
  const btnRecalcTime = document.getElementById('btn-recalc-time');

  let isManualSlug = <?= $isEditing ? 'true' : 'false' ?>;

  // Slug generator helper
  function stringToSlug(str) {
    return str.toLowerCase()
      .replace(/[^\w\s-]/g, '')
      .trim()
      .replace(/[\s_-]+/g, '-')
      .replace(/^-+|-+$/g, '');
  }

  // Toggle slug manual editing
  btnToggleSlug.addEventListener('click', function () {
    if (slugInput.hasAttribute('readonly')) {
      slugInput.removeAttribute('readonly');
      slugInput.focus();
      btnToggleSlug.textContent = 'Auto Slug';
      isManualSlug = true;
    } else {
      slugInput.setAttribute('readonly', 'readonly');
      btnToggleSlug.textContent = 'Edit Slug';
      slugInput.value = stringToSlug(titleInput.value);
      isManualSlug = false;
      updatePreview();
    }
  });

  // Title input change
  titleInput.addEventListener('input', function () {
    if (!isManualSlug) {
      slugInput.value = stringToSlug(titleInput.value);
    }
    updatePreview();
  });

  slugInput.addEventListener('input', updatePreview);

  // Excerpt character counter
  excerptInput.addEventListener('input', function () {
    const len = excerptInput.value.length;
    excerptCounter.textContent = len + ' / 180';
    if (len > 180) {
      excerptCounter.style.color = '#DC2626';
    } else {
      excerptCounter.style.color = 'var(--admin-text-muted)';
    }
    updatePreview();
  });

  // Body word and char counter
  function updateBodyStats() {
    const text = contentInput.value.trim();
    const chars = text.length;
    const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
    bodyCounter.textContent = 'Words: ' + words + ' | Chars: ' + chars;

    // Auto-update reading time
    const calcMin = Math.max(1, Math.round(words / 200));
    if (readingTimeInput) {
      readingTimeInput.value = calcMin;
    }
  }
  contentInput.addEventListener('input', updateBodyStats);

  // SEO counters and snippet preview
  if (metaTitleInput) metaTitleInput.addEventListener('input', function () {
    const len = metaTitleInput.value.length;
    metaTitleCounter.textContent = len + ' / 60';
    if (len > 60) metaTitleCounter.style.color = '#DC2626';
    else metaTitleCounter.style.color = 'var(--admin-text-muted)';
    updatePreview();
  });

  if (metaDescInput) metaDescInput.addEventListener('input', function () {
    const len = metaDescInput.value.length;
    metaDescCounter.textContent = len + ' / 160';
    if (len > 160) metaDescCounter.style.color = '#DC2626';
    else metaDescCounter.style.color = 'var(--admin-text-muted)';
    updatePreview();
  });

  function updatePreview() {
    const curSlug = slugInput.value.trim() || 'article-slug';
    if (previewUrl) previewUrl.textContent = 'https://www.ritwiksachdeva.in/blog/' + curSlug + '/';

    const curTitle = (metaTitleInput ? metaTitleInput.value.trim() : '') || titleInput.value.trim() || 'Article Title';
    if (previewTitle) previewTitle.textContent = curTitle + ' | Ritwik Sachdeva Blog';

    const curSnippet = (metaDescInput ? metaDescInput.value.trim() : '') || excerptInput.value.trim() || 'Search snippet description will appear here as you type in the excerpt or SEO description field.';
    if (previewSnippet) previewSnippet.textContent = curSnippet;
  }

  // Recalculate button
  btnRecalcTime.addEventListener('click', updateBodyStats);

  // Initial update
  updateBodyStats();
  excerptCounter.textContent = excerptInput.value.length + ' / 180';
  if (metaTitleCounter && metaTitleInput) metaTitleCounter.textContent = metaTitleInput.value.length + ' / 60';
  if (metaDescCounter && metaDescInput) metaDescCounter.textContent = metaDescInput.value.length + ' / 160';
  updatePreview();

  // FAQ Builder Repeater
  const btnAddFaq = document.getElementById('btn-add-faq');
  const faqListContainer = document.getElementById('faq-list-container');

  function checkFaqEmpty() {
    const items = faqListContainer.querySelectorAll('.faq-builder-item');
    let emptyState = document.getElementById('faq-empty-state');
    if (items.length === 0) {
      if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'faq-empty-state';
        emptyState.style.cssText = 'padding: 24px; text-align: center; border: 1.5px dashed var(--admin-border); border-radius: var(--admin-radius); color: var(--admin-text-muted); font-size: 13px;';
        emptyState.innerHTML = 'No FAQs added yet. Click <strong>"+ Add Question"</strong> to create structured FAQs for this article.';
        faqListContainer.appendChild(emptyState);
      }
    } else {
      if (emptyState) emptyState.remove();
    }
  }

  btnAddFaq.addEventListener('click', function () {
    const currentCount = faqListContainer.querySelectorAll('.faq-builder-item').length + 1;
    const emptyState = document.getElementById('faq-empty-state');
    if (emptyState) emptyState.remove();

    const faqDiv = document.createElement('div');
    faqDiv.className = 'faq-builder-item';
    faqDiv.innerHTML = `
      <div class="faq-item-header">
        <span class="faq-num-title">Question #${currentCount}</span>
        <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" style="padding: 2px 6px; font-size: 11px;" onclick="this.closest('.faq-builder-item').remove(); checkFaqEmpty();">
          &times; Remove
        </button>
      </div>
      <div class="form-group-admin" style="margin-bottom: 8px;">
        <input type="text" name="faq_q[]" class="form-control-admin" placeholder="e.g. How does performance marketing attribution work with privacy updates?" required>
      </div>
      <div class="form-group-admin" style="margin-bottom: 0;">
        <textarea name="faq_a[]" rows="2" class="form-control-admin" placeholder="Answer explanation that will appear in the accordion and FAQPage schema..." required></textarea>
      </div>
    `;
    faqListContainer.appendChild(faqDiv);
    faqDiv.querySelector('input').focus();
  });

  // Image Preview Function
  function previewSelectedImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const previewImg = document.getElementById('preview-img');
        const noImgText = document.getElementById('no-img-text');
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
        if (noImgText) noImgText.style.display = 'none';
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Formatting Toolbar Helper Functions
  function wrapText(prefix, suffix) {
    const start = contentInput.selectionStart;
    const end = contentInput.selectionEnd;
    const selected = contentInput.value.substring(start, end);
    const replacement = prefix + (selected || 'text') + suffix;
    contentInput.value = contentInput.value.substring(0, start) + replacement + contentInput.value.substring(end);
    contentInput.selectionStart = start + prefix.length;
    contentInput.selectionEnd = end + prefix.length;
    contentInput.focus();
    updateBodyStats();
  }

  function insertText(text) {
    const start = contentInput.selectionStart;
    contentInput.value = contentInput.value.substring(0, start) + text + contentInput.value.substring(start);
    contentInput.selectionStart = contentInput.selectionEnd = start + text.length;
    contentInput.focus();
    updateBodyStats();
  }

  function insertLinePrefix(prefix) {
    const start = contentInput.selectionStart;
    const end = contentInput.selectionEnd;
    const lineStart = contentInput.value.lastIndexOf('\n', start - 1) + 1;
    contentInput.value = contentInput.value.substring(0, lineStart) + prefix + contentInput.value.substring(lineStart);
    contentInput.selectionStart = contentInput.selectionEnd = end + prefix.length;
    contentInput.focus();
    updateBodyStats();
  }

  // Keep formatting shortcuts usable without reaching for the toolbar.
  contentInput.addEventListener('keydown', function (event) {
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'b') { event.preventDefault(); wrapText('**', '**'); }
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'i') { event.preventDefault(); wrapText('*', '*'); }
  });

  function insertHeading(prefix) {
    if (!prefix) return;
    insertLinePrefix(prefix);
    document.getElementById('tool-heading').value = '';
  }

  function insertLink() {
    const url = prompt('Enter link URL:', 'https://');
    if (!url) return;
    const start = contentInput.selectionStart;
    const end = contentInput.selectionEnd;
    const selected = contentInput.value.substring(start, end) || 'link text';
    const mdLink = '[' + selected + '](' + url + ')';
    contentInput.value = contentInput.value.substring(0, start) + mdLink + contentInput.value.substring(end);
    contentInput.selectionStart = contentInput.selectionEnd = start + mdLink.length;
    contentInput.focus();
    updateBodyStats();
  }

  function insertTable() {
    const tableMd = "\n| Feature / Metric | Strategy A | Strategy B |\n| --- | --- | --- |\n| Conversion Rate | 2.4% | 4.8% |\n| Blended ROAS | 3.2x | 5.1x |\n\n";
    insertText(tableMd);
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
