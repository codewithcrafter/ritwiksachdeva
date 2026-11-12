<?php
/**
 * Admin Blog Management
 * Search, filter, duplicate, and delete blog articles
 */

$pageTitle = 'Blog Posts';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../includes/markdown.php';
require_once __DIR__ . '/../../includes/seo.php';

// Handle Actions: Delete, Duplicate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $blogId = (int)($_POST['blog_id'] ?? 0);
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf) && $blogId > 0) {
        if ($action === 'delete') {
            // Fetch slug for markdown file deletion
            $bStmt = $pdo->prepare("SELECT slug FROM blogs WHERE id = :id");
            $bStmt->execute([':id' => $blogId]);
            $slug = $bStmt->fetchColumn();

            if ($slug) {
                // Delete tags relations
                $pdo->prepare("DELETE FROM blog_tag_relations WHERE blog_id = :id")->execute([':id' => $blogId]);
                // Delete SEO meta
                $pdo->prepare("DELETE FROM seo_metadata WHERE entity_type = 'blog' AND entity_id = :id")->execute([':id' => $blogId]);
                // Delete Revisions
                $pdo->prepare("DELETE FROM blog_revisions WHERE blog_id = :id")->execute([':id' => $blogId]);
                // Delete blog
                $pdo->prepare("DELETE FROM blogs WHERE id = :id")->execute([':id' => $blogId]);
                // Delete markdown file
                MarkdownManager::deleteMarkdownFile($slug);
                // Regenerate sitemap
                SeoManager::generateSitemap();

                $_SESSION['flash_success'] = "Article deleted successfully.";
            }
        } elseif ($action === 'duplicate') {
            $bStmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
            $bStmt->execute([':id' => $blogId]);
            $orig = $bStmt->fetch();

            if ($orig) {
                $newTitle = $orig['title'] . ' (Copy)';
                $newSlug = generate_slug($newTitle) . '-' . time();
                $dupStmt = $pdo->prepare("
                    INSERT INTO blogs (
                        title, slug, excerpt, content, featured_image, featured_image_alt,
                        category_id, author_id, status, is_featured, reading_time
                    ) VALUES (
                        :title, :slug, :excerpt, :content, :img, :img_alt,
                        :cat_id, :author_id, 'draft', 0, :reading_time
                    )
                ");
                $dupStmt->execute([
                    ':title'        => $newTitle,
                    ':slug'         => $newSlug,
                    ':excerpt'      => $orig['excerpt'],
                    ':content'      => $orig['content'],
                    ':img'          => $orig['featured_image'],
                    ':img_alt'      => $orig['featured_image_alt'],
                    ':cat_id'       => $orig['category_id'],
                    ':author_id'    => $orig['author_id'],
                    ':reading_time' => $orig['reading_time']
                ]);
                $newId = (int)$pdo->lastInsertId();
                MarkdownManager::syncBlog($newId);

                $_SESSION['flash_success'] = "Article duplicated as a draft.";
            }
        }
        header('Location: blogs.php');
        exit;
    }
}

// Filters & Pagination
$catFilter = trim($_GET['category'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$search = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$where = ["1=1"];
$params = [];

if ($catFilter !== '') {
    $where[] = "b.category_id = :cat_id";
    $params[':cat_id'] = $catFilter;
}

if ($statusFilter !== '') {
    $where[] = "b.status = :status";
    $params[':status'] = $statusFilter;
}

if ($search !== '') {
    $where[] = "(b.title LIKE :search OR b.slug LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$whereClause = implode(' AND ', $where);

// Total Count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM blogs b WHERE {$whereClause}");
$countStmt->execute($params);
$totalBlogs = (int)$countStmt->fetchColumn();
$totalPages = ceil($totalBlogs / $perPage);

// Fetch Blogs
$sql = "
    SELECT b.*, c.name AS category_name, a.name AS author_name
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    WHERE {$whereClause}
    ORDER BY b.created_at DESC
    LIMIT :limit OFFSET :offset
";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$blogs = $stmt->fetchAll();

// Categories for filter
$allCats = $pdo->query("SELECT id, name FROM blog_categories ORDER BY name ASC")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Blog Articles (<?= $totalBlogs ?>)</h1>
    <p class="admin-page-subtitle">Publish, manage, and edit strategic analyses with auto-synced Markdown files.</p>
  </div>
  <div class="admin-page-actions">
    <a href="markdown.php" class="btn-admin btn-admin-secondary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
      Markdown Center
    </a>
    <a href="blog-edit.php" class="btn-admin btn-admin-primary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      Create New Article
    </a>
  </div>
</div>

<!-- FILTER BAR -->
<div class="admin-card" style="margin-bottom: 20px;">
  <div class="admin-card-body" style="padding: 14px 20px;">
    <form method="GET" action="blogs.php" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
      <div style="flex: 1; min-width: 220px;">
        <input type="text" name="q" value="<?= e($search) ?>" class="form-control-admin" placeholder="Search title or slug...">
      </div>

      <div style="min-width: 160px;">
        <select name="category" class="form-control-admin">
          <option value="">All Categories</option>
          <?php foreach ($allCats as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($catFilter == $c['id']) ? 'selected' : '' ?>>
              <?= e($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="min-width: 140px;">
        <select name="status" class="form-control-admin">
          <option value="">All Statuses</option>
          <option value="published" <?= ($statusFilter === 'published') ? 'selected' : '' ?>>Published</option>
          <option value="draft" <?= ($statusFilter === 'draft') ? 'selected' : '' ?>>Draft</option>
          <option value="scheduled" <?= ($statusFilter === 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
        </select>
      </div>

      <button type="submit" class="btn-admin btn-admin-secondary">Filter</button>
      <?php if ($catFilter !== '' || $statusFilter !== '' || $search !== ''): ?>
        <a href="blogs.php" class="btn-admin btn-admin-secondary" style="color: var(--admin-danger);">Clear</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- BLOGS TABLE -->
<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Article</th>
          <th>Category</th>
          <th>Author</th>
          <th>Status</th>
          <th>Date</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($blogs)): ?>
          <?php foreach ($blogs as $b): ?>
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                  <?php if ($b['is_featured']): ?>
                    <span title="Featured Article" style="color: #F59E0B; font-size: 14px;">★</span>
                  <?php endif; ?>
                  <div>
                    <a href="blog-edit.php?id=<?= $b['id'] ?>" style="font-weight: 600; color: var(--admin-text-main); text-decoration: none; font-size: 14px;">
                      <?= e($b['title']) ?>
                    </a>
                    <div style="font-size: 11.5px; color: var(--admin-text-muted);">
                      /blog/<?= e($b['slug']) ?>/ &bull; <?= (int)$b['reading_time'] ?> min read
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <span style="font-size: 12.5px; background: #FAF8F5; padding: 3px 8px; border-radius: 4px; border: 1px solid var(--admin-border-light);">
                  <?= e($b['category_name'] ?: 'Uncategorized') ?>
                </span>
              </td>
              <td style="font-size: 13px; color: var(--admin-text-muted);">
                <?= e($b['author_name'] ?: 'Admin') ?>
              </td>
              <td>
                <span class="admin-badge status-<?= $b['status'] ?>">
                  <?= strtoupper($b['status']) ?>
                </span>
              </td>
              <td style="font-size: 12px; color: var(--admin-text-muted);">
                <?= date('M d, Y', strtotime($b['published_at'] ?: $b['created_at'])) ?>
              </td>
              <td style="text-align: right;">
                <div style="display: inline-flex; gap: 6px;">
                  <a href="blog-edit.php?id=<?= $b['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-sm" title="Edit">
                    Edit
                  </a>
                  <a href="../blog-detail.php?slug=<?= urlencode($b['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary btn-admin-sm" title="Preview Live">
                    Preview
                  </a>
                  <form method="POST" action="blogs.php" style="display: inline;" onsubmit="return confirm('Duplicate this article?');">
                    <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                    <input type="hidden" name="action" value="duplicate">
                    <input type="hidden" name="blog_id" value="<?= $b['id'] ?>">
                    <button type="submit" class="btn-admin btn-admin-secondary btn-admin-sm" title="Duplicate">
                      Copy
                    </button>
                  </form>
                  <form method="POST" action="blogs.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this article? This will remove the database record and markdown file.');">
                    <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="blog_id" value="<?= $b['id'] ?>">
                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Delete">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align: center; color: var(--admin-text-muted); padding: 32px;">
              No articles match the current criteria.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
  <div style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?= $i ?><?= $catFilter ? '&category=' . urlencode($catFilter) : '' ?><?= $statusFilter ? '&status=' . urlencode($statusFilter) : '' ?><?= $search ? '&q=' . urlencode($search) : '' ?>" 
         class="btn-admin <?= ($page === $i) ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-sm">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

