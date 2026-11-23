<?php
/**
 * Admin Blog Editor
 * Full CRUD, Markdown Sync, Tag Management, Revisions & SEO Fields
 */

$pageTitle = 'Blog Editor';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../includes/markdown.php';
require_once __DIR__ . '/../../includes/seo.php';

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
    'status' => 'draft',
    'is_featured' => 0,
    'reading_time' => 5,
    'published_at' => null,
    'scheduled_for' => null
];

$existingTagsStr = '';
$seo = [
    'meta_title' => '',
    'meta_description' => '',
    'canonical_url' => '',
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
    $blog = $found;

    // Load Tags
    $tagStmt = $pdo->prepare("
        SELECT t.name FROM blog_tags t
        JOIN blog_tag_relations btr ON btr.tag_id = t.id
        WHERE btr.blog_id = :id
    ");
    $tagStmt->execute([':id' => $id]);
    $tagNames = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
    $existingTagsStr = implode(', ', $tagNames);

    // Load SEO
    $seoStmt = $pdo->prepare("SELECT * FROM seo_metadata WHERE entity_type = 'blog' AND entity_id = :id");
    $seoStmt->execute([':id' => $id]);
    $foundSeo = $seoStmt->fetch();
    if ($foundSeo) {
        $seo = $foundSeo;
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
        $authorId = !empty($_POST['author_id']) ? (int)$_POST['author_id'] : 1;
        $status = in_array($_POST['status'] ?? '', ['draft', 'published', 'scheduled']) ? $_POST['status'] : 'draft';
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $readingTime = max(1, (int)($_POST['reading_time'] ?? calculate_reading_time($content)));
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $featuredImageAlt = trim($_POST['featured_image_alt'] ?? '');
        $tagsRaw = trim($_POST['tags'] ?? '');

        // SEO Fields
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDescription = trim($_POST['meta_description'] ?? '');
        $canonicalUrl = trim($_POST['canonical_url'] ?? '');
        $ogImage = trim($_POST['og_image'] ?? '');
        $robots = trim($_POST['robots'] ?? 'index, follow');

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
            $publishedAt = null;
            if ($status === 'published') {
                $publishedAt = $blog['published_at'] ?: date('Y-m-d H:i:s');
            }

            if ($isEditing) {
                // Save revision before updating
                $revStmt = $pdo->prepare("
                    INSERT INTO blog_revisions (blog_id, admin_id, title, content, excerpt, revision_summary)
                    VALUES (:bid, :aid, :title, :content, :excerpt, 'Saved from admin editor')
                ");
                $revStmt->execute([
                    ':bid'     => $id,
                    ':aid'     => $currentUser['id'],
                    ':title'   => $blog['title'],
                    ':content' => $blog['content'],
                    ':excerpt' => $blog['excerpt']
                ]);

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
                        published_at = :published_at,
                        updated_at = NOW()
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
                    ':published_at'       => $publishedAt,
                    ':id'                 => $id
                ]);
                $savedId = $id;
            } else {
                // Insert New Blog
                $insertStmt = $pdo->prepare("
                    INSERT INTO blogs (
                        title, slug, excerpt, content, featured_image, featured_image_alt,
                        category_id, author_id, status, is_featured, reading_time, published_at
                    ) VALUES (
                        :title, :slug, :excerpt, :content, :featured_image, :featured_image_alt,
                        :category_id, :author_id, :status, :is_featured, :reading_time, :published_at
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
                    ':published_at'       => $publishedAt
                ]);
                $savedId = (int)$pdo->lastInsertId();
            }

            // Sync Tags
            $pdo->prepare("DELETE FROM blog_tag_relations WHERE blog_id = :id")->execute([':id' => $savedId]);
            if (!empty($tagsRaw)) {
                $tagsArr = array_filter(array_map('trim', explode(',', $tagsRaw)));
                foreach ($tagsArr as $tagName) {
                    $tagSlug = generate_slug($tagName);
                    // Find or create tag
                    $tCheck = $pdo->prepare("SELECT id FROM blog_tags WHERE slug = :slug");
                    $tCheck->execute([':slug' => $tagSlug]);
                    $tagId = $tCheck->fetchColumn();

                    if (!$tagId) {
                        $tIns = $pdo->prepare("INSERT INTO blog_tags (name, slug) VALUES (:name, :slug)");
                        $tIns->execute([':name' => $tagName, ':slug' => $tagSlug]);
                        $tagId = (int)$pdo->lastInsertId();
                    }

                    $relIns = $pdo->prepare("INSERT IGNORE INTO blog_tag_relations (blog_id, tag_id) VALUES (:bid, :tid)");
                    $relIns->execute([':bid' => $savedId, ':tid' => $tagId]);
                }
            }

            // Upsert SEO Metadata
            $seoCheck = $pdo->prepare("SELECT id FROM seo_metadata WHERE entity_type = 'blog' AND entity_id = :id");
            $seoCheck->execute([':id' => $savedId]);
            $seoId = $seoCheck->fetchColumn();

            if ($seoId) {
                $seoUp = $pdo->prepare("
                    UPDATE seo_metadata SET
                        meta_title = :title,
                        meta_description = :desc,
                        canonical_url = :canon,
                        og_image = :og,
                        robots = :robots,
                        updated_at = NOW()
                    WHERE id = :id
                ");
                $seoUp->execute([
                    ':title'  => $metaTitle ?: null,
                    ':desc'   => $metaDescription ?: null,
                    ':canon'  => $canonicalUrl ?: null,
                    ':og'     => $ogImage ?: null,
                    ':robots' => $robots,
                    ':id'     => $seoId
                ]);
            } else {
                $seoIns = $pdo->prepare("
                    INSERT INTO seo_metadata (entity_type, entity_id, meta_title, meta_description, canonical_url, og_image, robots)
                    VALUES ('blog', :id, :title, :desc, :canon, :og, :robots)
                ");
                $seoIns->execute([
                    ':id'     => $savedId,
                    ':title'  => $metaTitle ?: null,
                    ':desc'   => $metaDescription ?: null,
                    ':canon'  => $canonicalUrl ?: null,
                    ':og'     => $ogImage ?: null,
                    ':robots' => $robots
                ]);
            }

            // Sync Markdown file to content/blogs/:slug.md
            MarkdownManager::syncBlog($savedId);

            // Re-generate Sitemap if published
            if ($status === 'published') {
                SeoManager::generateSitemap();
            }

            $_SESSION['flash_success'] = "Article saved and synced with Markdown file system successfully!";
            header("Location: blog-edit.php?id={$savedId}");
            exit;
        }
    }
}

// Fetch categories and authors for select menus
$categories = $pdo->query("SELECT id, name FROM blog_categories ORDER BY name ASC")->fetchAll();
$authors = $pdo->query("SELECT id, name FROM authors ORDER BY name ASC")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title"><?= $isEditing ? 'Edit Strategic Analysis' : 'Write New Article' ?></h1>
    <p class="admin-page-subtitle">Draft or update content with bidirectional Markdown synchronization.</p>
  </div>
  <div class="admin-page-actions">
    <a href="blogs.php" class="btn-admin btn-admin-secondary">&larr; Back to Articles</a>
    <?php if ($isEditing): ?>
      <a href="../blog-detail.php?slug=<?= urlencode($blog['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary">
        Preview Live &nearr;
      </a>
    <?php endif; ?>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="admin-alert admin-alert-danger">
    <ul style="margin: 0; padding-left: 18px;">
      <?php foreach ($errors as $err): ?>
        <li><?= e($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="POST" action="blog-edit.php<?= $isEditing ? '?id=' . $id : '' ?>">
  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">

  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: flex-start;">
    
    <!-- LEFT COLUMN: Main Editorial Content -->
    <div>
      <div class="admin-card">
        <div class="admin-card-body">
          <!-- Title -->
          <div class="form-group-admin">
            <label for="title" class="form-label-admin">Article Title *</label>
            <input type="text" id="title" name="title" class="form-control-admin" 
                   value="<?= e($blog['title']) ?>" placeholder="e.g. Digital Transformation Strategies for Modern Businesses" required>
          </div>

          <!-- Slug -->
          <div class="form-group-admin">
            <label for="slug" class="form-label-admin">URL Slug *</label>
            <input type="text" id="slug" name="slug" class="form-control-admin" 
                   value="<?= e($blog['slug']) ?>" placeholder="digital-transformation-strategies" required>
            <span style="font-size: 11px; color: var(--admin-text-muted);">
              Permanent URL: <code>/blog/<?= e($blog['slug'] ?: 'your-slug-here') ?>/</code>
            </span>
          </div>

          <!-- Excerpt -->
          <div class="form-group-admin">
            <label for="excerpt" class="form-label-admin">Executive Excerpt *</label>
            <textarea id="excerpt" name="excerpt" rows="3" class="form-control-admin" 
                      placeholder="Concise summary for search previews, social cards, and listing cards..." required><?= e($blog['excerpt']) ?></textarea>
          </div>

          <!-- Markdown Toolbar -->
          <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="insertMd('## ')">H2</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="insertMd('### ')">H3</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="wrapMd('**', '**')">Bold</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="wrapMd('*', '*')">Italic</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="insertMd('> ')">Quote</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="insertMd('- ')">List</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="wrapMd('`', '`')">Code</button>
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" onclick="calcReadTime()">Calculate Read Time</button>
          </div>

          <!-- Content -->
          <div class="form-group-admin" style="margin-bottom: 0;">
            <label for="content" class="form-label-admin">Article Content (Markdown Supported) *</label>
            <textarea id="content" name="content" rows="18" class="form-control-admin" 
                      style="font-family: SFMono-Regular, Consolas, Monaco, monospace; font-size: 13.5px; line-height: 1.6;" 
                      placeholder="# Write your analysis here in Markdown..." required><?= e($blog['content']) ?></textarea>
          </div>
        </div>
      </div>

      <!-- SEO METADATA CARD -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title">SEO &amp; OpenGraph Metadata</h3>
        </div>
        <div class="admin-card-body">
          <div class="form-group-admin">
            <label for="meta_title" class="form-label-admin">Meta Title</label>
            <input type="text" id="meta_title" name="meta_title" class="form-control-admin" 
                   value="<?= e($seo['meta_title'] ?? '') ?>" placeholder="Defaults to Article Title if left empty">
          </div>

          <div class="form-group-admin">
            <label for="meta_description" class="form-label-admin">Meta Description</label>
            <textarea id="meta_description" name="meta_description" rows="2" class="form-control-admin" 
                      placeholder="Defaults to Article Excerpt if left empty"><?= e($seo['meta_description'] ?? '') ?></textarea>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group-admin">
              <label for="canonical_url" class="form-label-admin">Canonical URL</label>
              <input type="url" id="canonical_url" name="canonical_url" class="form-control-admin" 
                     value="<?= e($seo['canonical_url'] ?? '') ?>" placeholder="Auto-generated if empty">
            </div>

            <div class="form-group-admin">
              <label for="robots" class="form-label-admin">Robots Directive</label>
              <select id="robots" name="robots" class="form-control-admin">
                <option value="index, follow" <?= (($seo['robots'] ?? '') === 'index, follow') ? 'selected' : '' ?>>index, follow (Recommended)</option>
                <option value="noindex, follow" <?= (($seo['robots'] ?? '') === 'noindex, follow') ? 'selected' : '' ?>>noindex, follow</option>
                <option value="noindex, nofollow" <?= (($seo['robots'] ?? '') === 'noindex, nofollow') ? 'selected' : '' ?>>noindex, nofollow</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN: Publishing Controls & Taxonomy -->
    <div>
      <!-- Publishing Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title">Publishing Status</h3>
        </div>
        <div class="admin-card-body">
          <div class="form-group-admin">
            <label for="status" class="form-label-admin">Status</label>
            <select id="status" name="status" class="form-control-admin">
              <option value="published" <?= ($blog['status'] === 'published') ? 'selected' : '' ?>>Published</option>
              <option value="draft" <?= ($blog['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
              <option value="scheduled" <?= ($blog['status'] === 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
            </select>
          </div>

          <div class="form-group-admin">
            <label for="reading_time" class="form-label-admin">Reading Time (Minutes)</label>
            <input type="number" id="reading_time" name="reading_time" min="1" max="60" class="form-control-admin" 
                   value="<?= (int)$blog['reading_time'] ?>">
          </div>

          <div class="form-group-admin">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px;">
              <input type="checkbox" name="is_featured" value="1" <?= $blog['is_featured'] ? 'checked' : '' ?>>
              <strong>Pin as Featured Article</strong>
            </label>
          </div>

          <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%; padding: 11px;">
            <?= $isEditing ? 'Save &amp; Sync Article' : 'Publish Article' ?>
          </button>
        </div>
      </div>

      <!-- Taxonomy Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title">Category &amp; Author</h3>
        </div>
        <div class="admin-card-body">
          <div class="form-group-admin">
            <label for="category_id" class="form-label-admin">Category</label>
            <select id="category_id" name="category_id" class="form-control-admin">
              <option value="">Select Category</option>
              <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($blog['category_id'] == $c['id']) ? 'selected' : '' ?>>
                  <?= e($c['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group-admin">
            <label for="author_id" class="form-label-admin">Author</label>
            <select id="author_id" name="author_id" class="form-control-admin">
              <?php foreach ($authors as $a): ?>
                <option value="<?= $a['id'] ?>" <?= ($blog['author_id'] == $a['id']) ? 'selected' : '' ?>>
                  <?= e($a['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group-admin" style="margin-bottom: 0;">
            <label for="tags" class="form-label-admin">Tags (Comma Separated)</label>
            <input type="text" id="tags" name="tags" class="form-control-admin" 
                   value="<?= e($existingTagsStr) ?>" placeholder="AI, Strategy, Leadership, B2B">
          </div>
        </div>
      </div>

      <!-- Featured Image Card -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3 class="admin-card-title">Featured Image</h3>
        </div>
        <div class="admin-card-body">
          <div class="form-group-admin">
            <label for="featured_image" class="form-label-admin">Image URL / Path</label>
            <input type="text" id="featured_image" name="featured_image" class="form-control-admin" 
                   value="<?= e($blog['featured_image']) ?>" placeholder="assets/images/article-cover.jpg">
            <div style="margin-top: 6px;">
              <a href="media.php" target="_blank" style="font-size: 11.5px; color: var(--admin-accent); text-decoration: none;">
                Open Media Library &rarr;
              </a>
            </div>
          </div>

          <div class="form-group-admin" style="margin-bottom: 0;">
            <label for="featured_image_alt" class="form-label-admin">Image Alt Text</label>
            <input type="text" id="featured_image_alt" name="featured_image_alt" class="form-control-admin" 
                   value="<?= e($blog['featured_image_alt']) ?>" placeholder="Descriptive image alt text for SEO">
          </div>
        </div>
      </div>

    </div>

  </div>
</form>

<script>
  // Auto slug generation from title if new
  const titleInput = document.getElementById('title');
  const slugInput = document.getElementById('slug');
  const isEditing = <?= $isEditing ? 'true' : 'false' ?>;

  if (titleInput && slugInput && !isEditing) {
    titleInput.addEventListener('input', () => {
      const slugVal = titleInput.value.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
      slugInput.value = slugVal;
    });
  }

  // Markdown helpers
  function insertMd(prefix) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    textarea.value = text.substring(0, start) + prefix + text.substring(end);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + prefix.length;
  }

  function wrapMd(before, after) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    const selected = text.substring(start, end) || 'text';
    textarea.value = text.substring(0, start) + before + selected + after + text.substring(end);
    textarea.focus();
  }

  function calcReadTime() {
    const content = document.getElementById('content').value;
    const wordCount = content.trim().split(/\s+/).filter(Boolean).length;
    const mins = Math.max(1, Math.round(wordCount / 200));
    document.getElementById('reading_time').value = mins;
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


