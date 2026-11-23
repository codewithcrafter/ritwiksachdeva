<?php
/**
 * Admin Users & RBAC Management
 * Restricted to SUPER_ADMIN
 */

$pageTitle = 'Users & RBAC';
require_once __DIR__ . '/includes/header.php';

// Enforce SUPER_ADMIN role
if (!auth_has_role('SUPER_ADMIN')) {
    http_response_code(403);
    echo '<div class="admin-alert admin-alert-danger">Access Denied. You do not have permission to manage portal users.</div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Handle Add User / Toggle Status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'create_user') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'EDITOR';

            $validRoles = ['SUPER_ADMIN', 'EDITOR', 'LEAD_MANAGER'];
            if (!in_array($role, $validRoles)) {
                $role = 'EDITOR';
            }

            if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 8) {
                // Check if email already exists
                $check = $pdo->prepare("SELECT id FROM admins WHERE email = :email");
                $check->execute([':email' => $email]);
                if ($check->fetch()) {
                    $_SESSION['flash_error'] = "A user with email '{$email}' already exists.";
                } else {
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $ins = $pdo->prepare("
                        INSERT INTO admins (name, email, password_hash, role, is_active)
                        VALUES (:name, :email, :hash, :role, 1)
                    ");
                    $ins->execute([
                        ':name' => $name,
                        ':email' => $email,
                        ':hash' => $hash,
                        ':role' => $role
                    ]);
                    $_SESSION['flash_success'] = "User '{$name}' created with role {$role}.";
                }
            } else {
                $_SESSION['flash_error'] = "Please provide valid user details (password must be at least 8 characters).";
            }
        } elseif ($action === 'toggle_active') {
            $uid = (int)($_POST['user_id'] ?? 0);
            if ($uid > 0 && $uid !== $currentUser['id']) {
                $currStatus = (int)($_POST['current_status'] ?? 0);
                $newStatus = $currStatus ? 0 : 1;
                $pdo->prepare("UPDATE admins SET is_active = :st WHERE id = :id")->execute([':st' => $newStatus, ':id' => $uid]);
                $_SESSION['flash_success'] = "User status updated.";
            }
        }
        header('Location: users.php');
        exit;
    }
}

$users = $pdo->query("SELECT * FROM admins ORDER BY id ASC")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Users &amp; Role-Based Access (RBAC)</h1>
    <p class="admin-page-subtitle">Configure administrative accounts, editorial roles, and CRM triage access permissions.</p>
  </div>
  <div class="admin-page-actions">
    <button type="button" class="btn-admin btn-admin-primary" onclick="openAddUserModal()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      Add Portal User
    </button>
  </div>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Role</th>
          <th>Account Status</th>
          <th>Last Login</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <div class="admin-user-avatar">
                  <?= strtoupper(substr($u['name'], 0, 1)) ?>
                </div>
                <div>
                  <div style="font-weight: 700; color: var(--admin-text-main); font-size: 13.5px;"><?= e($u['name']) ?></div>
                  <div style="font-size: 12px; color: var(--admin-text-muted);"><?= e($u['email']) ?></div>
                </div>
              </div>
            </td>
            <td>
              <span class="admin-badge" style="background: #EFEAE2; color: #252525; font-weight: 700;">
                <?= e($u['role']) ?>
              </span>
            </td>
            <td>
              <?php if ($u['is_active']): ?>
                <span class="admin-badge status-published">Active</span>
              <?php else: ?>
                <span class="admin-badge lead-lost">Suspended</span>
              <?php endif; ?>
            </td>
            <td style="font-size: 12px; color: var(--admin-text-muted);">
              <?= $u['last_login_at'] ? date('M d, Y h:i A', strtotime($u['last_login_at'])) : 'Never logged in' ?>
            </td>
            <td style="text-align: right;">
              <?php if ($u['id'] !== $currentUser['id']): ?>
                <form method="POST" action="users.php" style="display: inline;">
                  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                  <input type="hidden" name="action" value="toggle_active">
                  <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                  <input type="hidden" name="current_status" value="<?= $u['is_active'] ?>">
                  <button type="submit" class="btn-admin <?= $u['is_active'] ? 'btn-admin-danger' : 'btn-admin-secondary' ?> btn-admin-sm">
                    <?= $u['is_active'] ? 'Suspend' : 'Activate' ?>
                  </button>
                </form>
              <?php else: ?>
                <span style="font-size: 11px; color: var(--admin-text-muted);">(Current Session)</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add User Modal -->
<div class="admin-modal-backdrop" id="userModal">
  <div class="admin-modal" style="max-width: 500px;">
    <div class="admin-modal-header">
      <h3 class="admin-modal-title">Create Admin User</h3>
      <button type="button" onclick="closeUserModal()" style="background:none;border:none;font-size:22px;cursor:pointer;">&times;</button>
    </div>
    <form method="POST" action="users.php">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
      <input type="hidden" name="action" value="create_user">

      <div class="admin-modal-body">
        <div class="form-group-admin">
          <label for="u_name" class="form-label-admin">Full Name *</label>
          <input type="text" id="u_name" name="name" class="form-control-admin" required>
        </div>

        <div class="form-group-admin">
          <label for="u_email" class="form-label-admin">Email Address *</label>
          <input type="email" id="u_email" name="email" class="form-control-admin" required>
        </div>

        <div class="form-group-admin">
          <label for="u_password" class="form-label-admin">Password (min 8 chars) *</label>
          <input type="password" id="u_password" name="password" class="form-control-admin" required minlength="8">
        </div>

        <div class="form-group-admin" style="margin-bottom: 0;">
          <label for="u_role" class="form-label-admin">Role Assignment *</label>
          <select id="u_role" name="role" class="form-control-admin">
            <option value="EDITOR">EDITOR (Manage Blogs &amp; Media)</option>
            <option value="LEAD_MANAGER">LEAD_MANAGER (Manage Inquiries CRM)</option>
            <option value="SUPER_ADMIN">SUPER_ADMIN (Full System Access)</option>
          </select>
        </div>
      </div>

      <div class="admin-modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeUserModal()">Cancel</button>
        <button type="submit" class="btn-admin btn-admin-primary">Create User</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openAddUserModal() {
    document.getElementById('userModal').classList.add('is-open');
  }
  function closeUserModal() {
    document.getElementById('userModal').classList.remove('is-open');
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

