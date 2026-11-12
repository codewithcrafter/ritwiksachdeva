<?php
/**
 * Admin Categories Management
 */

$pageTitle = 'Blog Categories';
require_once __DIR__ . '/includes/header.php';

// Handle Add / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'create') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $desc = trim($_POST['description'] ?? '');

            if (empty($slug)) {
                $slug = generate_slug($name);
            } else {
                $slug = generate_slug($slug);
            }

            if (!empty($name)) {
                $cStmt = $pdo->prepare("INSERT INTO blog_categories (name, slug, description) VALUES (:name, :slug, :desc)");
                try {
                    $cStmt->execute([':name' => $name, ':slug' => $slug, ':desc' => $desc ?: null]);
                    $_SESSION['flash_success'] = "Category '{$name}' created successfully.";
                } catch (PDOException $e) {
                    $_SESSION['flash_error'] = "A category with that slug already exists.";
                }
            }
        } elseif ($action === 'delete') {
            $catId = (int)($_POST['category_id'] ?? 0);
            if ($catId > 0) {
                // Remove category link from blogs
                $pdo->prepare("UPDATE blogs SET category_id = NULL WHERE category_id = :id")->execute([':id' => $catId]);
                // Delete category
                $pdo->prepare("DELETE FROM blog_categories WHERE id = :id")->execute([':id' => $catId]);
                $_SESSION['flash_success'] = "Category deleted.";
            }
        }
        header('Location: categories.php');
        exit;
    }
}

// Fetch all categories with blog counts
$categories = $pdo->query("
    SELECT c.*, COUNT(b.id) AS blog_count
    FROM blog_categories c
    LEFT JOIN blogs b ON b.category_id = c.id
    GROUP BY c.id
    ORDER BY c.name ASC
")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Blog Categories</h1>
    <p class="admin-page-subtitle">Organize strategic perspectives into high-level thematic topics.</p>
  </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: flex-start;">
  <!-- Add Category Form -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Add New Category</h3>
    </div>
    <div class="admin-card-body">
      <form method="POST" action="categories.php">
        <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
        <input type="hidden" name="action" value="create">

        <div class="form-group-admin">
          <label for="cat_name" class="form-label-admin">Category Name *</label>
          <input type="text" id="cat_name" name="name" class="form-control-admin" placeholder="e.g. Performance Marketing" required>
        </div>

        <div class="form-group-admin">
          <label for="cat_slug" class="form-label-admin">Category Slug</label>
          <input type="text" id="cat_slug" name="slug" class="form-control-admin" placeholder="performance-marketing">
        </div>

        <div class="form-group-admin">
          <label for="cat_desc" class="form-label-admin">Description (Optional)</label>
          <textarea id="cat_desc" name="description" rows="3" class="form-control-admin" placeholder="Brief editorial scope..."></textarea>
        </div>

        <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%;">Create Category</button>
      </form>
    </div>
  </div>

  <!-- Category List -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Existing Categories (<?= count($categories) ?>)</h3>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Articles</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $cat): ?>
            <tr>
              <td>
                <div style="font-weight: 600; color: var(--admin-text-main);"><?= e($cat['name']) ?></div>
                <?php if ($cat['description']): ?>
                  <div style="font-size: 11.5px; color: var(--admin-text-muted);"><?= e($cat['description']) ?></div>
                <?php endif; ?>
              </td>
              <td><code><?= e($cat['slug']) ?></code></td>
              <td>
                <span class="admin-badge" style="background: #FAF8F5; border: 1px solid var(--admin-border-light);">
                  <?= (int)$cat['blog_count'] ?> posts
                </span>
              </td>
              <td style="text-align: right;">
                <form method="POST" action="categories.php" style="display: inline;" onsubmit="return confirm('Delete this category? Associated articles will remain uncategorized.');">
                  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
                  <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const catName = document.getElementById('cat_name');
  const catSlug = document.getElementById('cat_slug');
  if (catName && catSlug) {
    catName.addEventListener('input', () => {
      catSlug.value = catName.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    });
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

