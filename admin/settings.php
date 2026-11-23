<?php
/**
 * Admin Website & Consulting Settings
 */

$pageTitle = 'General Settings';
require_once __DIR__ . '/includes/header.php';

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (auth_verify_csrf($csrf)) {
        $settingsToSave = [
            'site_name'        => trim($_POST['site_name'] ?? ''),
            'consultant_name'  => trim($_POST['consultant_name'] ?? ''),
            'consultant_title' => trim($_POST['consultant_title'] ?? ''),
            'contact_email'    => trim($_POST['contact_email'] ?? ''),
            'contact_phone'    => trim($_POST['contact_phone'] ?? ''),
            'linkedin_url'     => trim($_POST['linkedin_url'] ?? ''),
            'twitter_url'      => trim($_POST['twitter_url'] ?? '')
        ];

        foreach ($settingsToSave as $k => $v) {
            $up = $pdo->prepare("
                INSERT INTO website_settings (setting_key, setting_value)
                VALUES (:k, :v)
                ON DUPLICATE KEY UPDATE setting_value = :v_up
            ");
            $up->execute([':k' => $k, ':v' => $v, ':v_up' => $v]);
        }

        $_SESSION['flash_success'] = "Website settings updated successfully.";
        header('Location: settings.php');
        exit;
    }
}

// Fetch all settings
$settingsRaw = $pdo->query("SELECT setting_key, setting_value FROM website_settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Website Configuration &amp; Contact Info</h1>
    <p class="admin-page-subtitle">Configure consulting practice profiles, branding defaults, and global inquiry channels.</p>
  </div>
</div>

<div class="admin-card" style="max-width: 780px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Practice &amp; Branding Profile</h3>
  </div>
  <div class="admin-card-body">
    <form method="POST" action="settings.php">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group-admin">
          <label for="s_name" class="form-label-admin">Consultant Name</label>
          <input type="text" id="s_name" name="consultant_name" class="form-control-admin" 
                 value="<?= e($settingsRaw['consultant_name'] ?? 'Ritwik Sachdeva') ?>">
        </div>

        <div class="form-group-admin">
          <label for="s_title" class="form-label-admin">Consulting Title</label>
          <input type="text" id="s_title" name="consultant_title" class="form-control-admin" 
                 value="<?= e($settingsRaw['consultant_title'] ?? 'Digital Marketing & Growth Consultant') ?>">
        </div>
      </div>

      <div class="form-group-admin">
        <label for="site_name" class="form-label-admin">Website / Brand Name</label>
        <input type="text" id="site_name" name="site_name" class="form-control-admin" 
               value="<?= e($settingsRaw['site_name'] ?? 'Ritwik Sachdeva - Marketing Consultant') ?>">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group-admin">
          <label for="contact_email" class="form-label-admin">Primary Direct Email</label>
          <input type="email" id="contact_email" name="contact_email" class="form-control-admin" 
                 value="<?= e($settingsRaw['contact_email'] ?? 'consult@ritwiksachdeva.com') ?>">
        </div>

        <div class="form-group-admin">
          <label for="contact_phone" class="form-label-admin">WhatsApp / Direct Phone</label>
          <input type="text" id="contact_phone" name="contact_phone" class="form-control-admin" 
                 value="<?= e($settingsRaw['contact_phone'] ?? '+91 98765 43210') ?>">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group-admin">
          <label for="linkedin_url" class="form-label-admin">LinkedIn Profile</label>
          <input type="url" id="linkedin_url" name="linkedin_url" class="form-control-admin" 
                 value="<?= e($settingsRaw['linkedin_url'] ?? 'https://linkedin.com') ?>">
        </div>

        <div class="form-group-admin">
          <label for="twitter_url" class="form-label-admin">X / Twitter Profile</label>
          <input type="url" id="twitter_url" name="twitter_url" class="form-control-admin" 
                 value="<?= e($settingsRaw['twitter_url'] ?? 'https://twitter.com') ?>">
        </div>
      </div>

      <button type="submit" class="btn-admin btn-admin-primary" style="padding: 10px 24px;">
        Save Practice Settings
      </button>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


