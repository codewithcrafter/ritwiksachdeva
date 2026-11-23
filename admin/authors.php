<?php
/**
 * Admin Authors Management
 */

$pageTitle = 'Authors & Bylines';
require_once __DIR__ . '/includes/header.php';

// Handle Add / Edit / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'save') {
            $authorId = (int)($_POST['author_id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $avatar = trim($_POST['avatar'] ?? '');
            $linkedin = trim($_POST['linkedin_url'] ?? '');
            $slug = generate_slug($name);

            if (!empty($name)) {
                if ($authorId > 0) {
                    $up = $pdo->prepare("
                        UPDATE authors SET
                            name = :name, slug = :slug, title = :title, bio = :bio,
                            email = :email, avatar = :avatar, linkedin_url = :li
                        WHERE id = :id
                    ");
                    $up->execute([
                        ':name' => $name, ':slug' => $slug, ':title' => $title, ':bio' => $bio,
                        ':email' => $email ?: null, ':avatar' => $avatar ?: null, ':li' => $linkedin ?: null,
                        ':id' => $authorId
                    ]);
                    $_SESSION['flash_success'] = "Author updated.";
                } else {
                    $ins = $pdo->prepare("
                        INSERT INTO authors (name, slug, title, bio, email, avatar, linkedin_url)
                        VALUES (:name, :slug, :title, :bio, :email, :avatar, :li)
                    ");
                    $ins->execute([
                        ':name' => $name, ':slug' => $slug, ':title' => $title, ':bio' => $bio,
                        ':email' => $email ?: null, ':avatar' => $avatar ?: null, ':li' => $linkedin ?: null
                    ]);
                    $_SESSION['flash_success'] = "Author profile added.";
                }
            }
        }
        header('Location: authors.php');
        exit;
    }
}

$authors = $pdo->query("
    SELECT a.*, COUNT(b.id) AS blog_count 
    FROM authors a 
    LEFT JOIN blogs b ON b.author_id = a.id 
    GROUP BY a.id 
    ORDER BY a.name ASC
")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Author Profiles</h1>
    <p class="admin-page-subtitle">Configure editorial bylines, executive bios, and schema identities.</p>
  </div>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Author</th>
          <th>Title / Role</th>
          <th>Contact &amp; Social</th>
          <th>Articles</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($authors as $a): ?>
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 12px;">
                <img src="<?= e($a['avatar'] ?: 'assets/images/author-avatar.svg') ?>" 
                     alt="<?= e($a['name']) ?>" 
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid var(--admin-border);">
                <div>
                  <div style="font-weight: 700; color: var(--admin-text-main);"><?= e($a['name']) ?></div>
                  <div style="font-size: 11.5px; color: var(--admin-text-muted);"><?= e(mb_substr($a['bio'], 0, 75)) ?>...</div>
                </div>
              </div>
            </td>
            <td style="font-size: 13px;"><?= e($a['title'] ?: 'Consultant') ?></td>
            <td style="font-size: 12px; color: var(--admin-text-muted);">
              <div><?= e($a['email'] ?: 'No email') ?></div>
              <?php if ($a['linkedin_url']): ?>
                <a href="<?= e($a['linkedin_url']) ?>" target="_blank" style="color: var(--admin-accent); font-size: 11px;">LinkedIn &rarr;</a>
              <?php endif; ?>
            </td>
            <td>
              <span class="admin-badge" style="background: #FAF8F5; border: 1px solid var(--admin-border-light);">
                <?= (int)$a['blog_count'] ?> published
              </span>
            </td>
            <td style="text-align: right;">
              <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" 
                      onclick='editAuthor(<?= json_encode($a) ?>)'>Edit</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Author Modal -->
<div class="admin-modal-backdrop" id="authorModal">
  <div class="admin-modal">
    <div class="admin-modal-header">
      <h3 class="admin-modal-title" id="authorModalTitle">Author Details</h3>
      <button type="button" onclick="closeModal()" style="background:none;border:none;font-size:20px;cursor:pointer;">&times;</button>
    </div>
    <form method="POST" action="authors.php">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="author_id" id="modal_author_id" value="0">

      <div class="admin-modal-body">
        <div class="form-group-admin">
          <label for="modal_name" class="form-label-admin">Full Name *</label>
          <input type="text" id="modal_name" name="name" class="form-control-admin" required>
        </div>

        <div class="form-group-admin">
          <label for="modal_title" class="form-label-admin">Professional Title</label>
          <input type="text" id="modal_title" name="title" class="form-control-admin" placeholder="Digital Marketing & Growth Consultant">
        </div>

        <div class="form-group-admin">
          <label for="modal_bio" class="form-label-admin">Editorial Biography</label>
          <textarea id="modal_bio" name="bio" rows="4" class="form-control-admin"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
          <div class="form-group-admin">
            <label for="modal_email" class="form-label-admin">Email</label>
            <input type="email" id="modal_email" name="email" class="form-control-admin">
          </div>
          <div class="form-group-admin">
            <label for="modal_linkedin" class="form-label-admin">LinkedIn Profile URL</label>
            <input type="url" id="modal_linkedin" name="linkedin_url" class="form-control-admin">
          </div>
        </div>

        <div class="form-group-admin" style="margin-bottom: 0;">
          <label for="modal_avatar" class="form-label-admin">Avatar Image URL</label>
          <input type="text" id="modal_avatar" name="avatar" class="form-control-admin">
        </div>
      </div>

      <div class="admin-modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn-admin btn-admin-primary">Save Author</button>
      </div>
    </form>
  </div>
</div>

<script>
  function editAuthor(a) {
    document.getElementById('modal_author_id').value = a.id;
    document.getElementById('modal_name').value = a.name;
    document.getElementById('modal_title').value = a.title || '';
    document.getElementById('modal_bio').value = a.bio || '';
    document.getElementById('modal_email').value = a.email || '';
    document.getElementById('modal_avatar').value = a.avatar || '';
    document.getElementById('modal_linkedin').value = a.linkedin_url || '';
    document.getElementById('authorModalTitle').textContent = 'Edit Author: ' + a.name;
    document.getElementById('authorModal').classList.add('is-open');
  }

  function closeModal() {
    document.getElementById('authorModal').classList.remove('is-open');
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


