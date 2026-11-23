<?php
/**
 * Admin Layout Header
 */
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';

// Ensure user is authenticated
auth_require();

$currentUser = auth_user();
$pdo = get_db();

// Unread leads count for badge
$newLeadsCount = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads WHERE status = 'NEW'")->fetchColumn();

// Page title fallback
if (!isset($pageTitle)) {
    $pageTitle = 'Admin Portal - Ritwik Sachdeva';
}

// Flash messages
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> | Ritwik Sachdeva CMS</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="css/admin.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23C47B45'/><text x='16' y='22' fill='%23fff' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">
</head>
<body>
<div class="admin-wrapper">

  <!-- Sidebar -->
  <?php require __DIR__ . '/sidebar.php'; ?>

  <!-- Main Content Wrapper -->
  <div class="admin-main">
    
    <!-- Topbar -->
    <header class="admin-topbar">
      <div class="admin-topbar-left">
        <button type="button" id="sidebarToggleBtn" class="btn-admin btn-admin-secondary btn-admin-icon" aria-label="Toggle Navigation">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <span style="font-weight: 600; color: var(--admin-text-muted); font-size: 13.5px;">
          <?= date('l, F j, Y') ?>
        </span>
      </div>

      <div class="admin-topbar-right">
        <div class="admin-user-profile">
          <div class="admin-user-avatar">
            <?= strtoupper(substr($currentUser['name'] ?? 'A', 0, 1)) ?>
          </div>
          <div>
            <div class="admin-user-name"><?= e($currentUser['name'] ?? 'Administrator') ?></div>
            <div class="admin-user-role"><?= e($currentUser['role_display'] ?? $currentUser['role_name'] ?? 'Administrator') ?></div>
          </div>
        </div>

        <a href="logout.php" class="btn-admin btn-admin-secondary btn-admin-sm" title="Log Out" style="margin-left: 8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          Logout
        </a>
      </div>
    </header>

    <!-- Page Content Area -->
    <main class="admin-content">
      <?php if ($flashSuccess): ?>
        <div class="admin-alert admin-alert-success">
          <span><?= e($flashSuccess) ?></span>
          <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-weight:bold;color:inherit;">&times;</button>
        </div>
      <?php endif; ?>

      <?php if ($flashError): ?>
        <div class="admin-alert admin-alert-danger">
          <span><?= e($flashError) ?></span>
          <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-weight:bold;color:inherit;">&times;</button>
        </div>
      <?php endif; ?>

