<?php
/**
 * Admin Login Page
 * Secure Authentication with CSRF & Rate Limiting
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

// If already logged in, redirect to dashboard
if (auth_check()) {
    header('Location: index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!auth_verify_csrf($csrfToken)) {
        $error = 'Invalid security session. Please refresh and try again.';
    } elseif (empty($email) || empty($password)) {
        $error = 'Please enter both your email address and password.';
    } else {
        $res = auth_login($email, $password);
        if ($res['success']) {
            header('Location: index.php');
            exit;
        } else {
            $error = $res['error'] ?? 'Authentication failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Ritwik Sachdeva CMS</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="css/admin.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23C47B45'/><text x='16' y='22' fill='%23fff' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #F8F7F4;
      padding: 24px;
    }
    .login-container {
      max-width: 420px;
      width: 100%;
    }
    .login-brand {
      text-align: center;
      margin-bottom: 28px;
    }
    .login-monogram {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      background: var(--admin-accent);
      color: #FFFFFF;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 20px;
      margin-bottom: 12px;
      box-shadow: 0 4px 12px rgba(196, 123, 69, 0.25);
    }
    .login-box {
      background: #FFFFFF;
      border: 1px solid var(--admin-border);
      border-radius: 12px;
      padding: 32px;
      box-shadow: var(--admin-shadow);
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-brand">
    <div class="login-monogram">RS</div>
    <h1 style="font-family: var(--admin-font-heading); font-size: 22px; font-weight: 700; color: var(--admin-text-main);">
      Ritwik Sachdeva
    </h1>
    <p style="font-size: 13px; color: var(--admin-text-muted);">
      CMS &amp; Growth CRM Control Portal
    </p>
  </div>

  <div class="login-box">
    <?php if (!empty($error)): ?>
      <div class="admin-alert admin-alert-danger" style="margin-bottom: 20px;">
        <span><?= e($error) ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">

      <div class="form-group-admin">
        <label for="email" class="form-label-admin">Email Address</label>
        <input type="email" id="email" name="email" class="form-control-admin" 
               placeholder="admin@ritwiksachdeva.com" 
               value="<?= e($email) ?>" required autofocus autocomplete="username">
      </div>

      <div class="form-group-admin">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <label for="password" class="form-label-admin" style="margin-bottom: 0;">Password</label>
        </div>
        <input type="password" id="password" name="password" class="form-control-admin" 
               placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required autocomplete="current-password">
      </div>

      <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%; padding: 11px; margin-top: 10px;">
        Sign In to Portal
      </button>
    </form>

    <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--admin-border); font-size: 12px; color: var(--admin-text-muted);">
      <div style="font-weight: 600; color: var(--admin-text-main); margin-bottom: 4px;">Default Credentials:</div>
      <div>Email: <code>admin@ritwiksachdeva.com</code></div>
      <div>Password: <code>Admin@2026!</code></div>
    </div>
  </div>

  <div style="text-align: center; margin-top: 20px;">
    <a href="../index.html" style="font-size: 13px; color: var(--admin-text-muted); text-decoration: none;">
      &larr; Return to Public Website
    </a>
  </div>
</div>

</body>
</html>


