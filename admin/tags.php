<?php
/**
 * Admin Tags Management
 */

$pageTitle = 'Blog Tags';
require_once __DIR__ . '/includes/header.php';

// Handle Add / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'create') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            if (empty($slug)) {
                $slug = generate_slug($name);
            } else {
                $slug = generate_slug($slug);
            }

            if (!empty($name)) {
                $tStmt = $pdo->prepare("INSERT INTO blog_tags (name, slug) VALUES (:name, :slug)");
                try {
                    $tStmt->execute([':name' => $name, ':slug' => $slug]);
                    $_SESSION['flash_success'] = "Tag '#{$name}' created.";
                } catch (PDOException $e) {
                    $_SESSION['flash_error'] = "A tag with that slug already exists.";
                }
            }
        } elseif ($action === 'delete') {
            $tagId = (int)($_POST['tag_id'] ?? 0);
            if ($tagId > 0) {
                $pdo->prepare("DELETE FROM blog_tag_relations WHERE tag_id = :id")->execute([':id' => $tagId]);
                $pdo->prepare("DELETE FROM blog_tags WHERE id = :id")->execute([':id' => $tagId]);
                $_SESSION['flash_success'] = "Tag deleted.";
            }
        }
        header('Location: tags.php');
        exit;
    }
}

// Fetch all tags with blog counts
$tags = $pdo->query("
    SELECT t.*, COUNT(btr.blog_id) AS blog_count
    FROM blog_tags t
    LEFT JOIN blog_tag_relations btr ON btr.tag_id = t.id
    GROUP BY t.id
    ORDER BY t.name ASC
")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Article Tags</h1>
    <p class="admin-page-subtitle">Manage granular subject matter tags for discovery and SEO indexing.</p>
  </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: flex-start;">
  <!-- Add Tag Form -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Add New Tag</h3>
    </div>
    <div class="admin-card-body">
      <form method="POST" action="tags.php">
        <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
        <input type="hidden" name="action" value="create">

        <div class="form-group-admin">
          <label for="tag_name" class="form-label-admin">Tag Name *</label>
          <input type="text" id="tag_name" name="name" class="form-control-admin" placeholder="e.g. CRO, Machine Learning" required>
        </div>

        <div class="form-group-admin">
          <label for="tag_slug" class="form-label-admin">Tag Slug</label>
          <input type="text" id="tag_slug" name="slug" class="form-control-admin" placeholder="cro">
        </div>

        <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%;">Create Tag</button>
      </form>
    </div>
  </div>

  <!-- Tag List -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Active Tags (<?= count($tags) ?>)</h3>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tag Name</th>
            <th>Slug</th>
            <th>Articles</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tags as $tag): ?>
            <tr>
              <td>
                <span style="font-weight: 600; color: var(--admin-text-main);">#<?= e($tag['name']) ?></span>
              </td>
              <td><code><?= e($tag['slug']) ?></code></td>
              <td>
                <span class="admin-badge" style="background: #FAF8F5; border: 1px solid var(--admin-border-light);">
                  <?= (int)$tag['blog_count'] ?> articles
                </span>
              </td>
              <td style="text-align: right;">
                <form method="POST" action="tags.php" style="display: inline;" onsubmit="return confirm('Delete this tag?');">
                  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="tag_id" value="<?= $tag['id'] ?>">
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
  const tagName = document.getElementById('tag_name');
  const tagSlug = document.getElementById('tag_slug');
  if (tagName && tagSlug) {
    tagName.addEventListener('input', () => {
      tagSlug.value = tagName.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    });
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


