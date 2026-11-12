<?php
/**
 * Admin Markdown System Manager
 * Inspects, synchronizes, and downloads Markdown files in content/blogs/
 */

$pageTitle = 'Markdown Files';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../includes/markdown.php';

$contentDir = __DIR__ . '/../content/blogs/';
if (!is_dir($contentDir)) {
    @mkdir($contentDir, 0755, true);
}

// Handle Re-Sync All
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'sync_all') {
            $count = MarkdownManager::syncAll();
            $_SESSION['flash_success'] = "All published & draft articles ({$count} files) successfully synchronized with content/blogs/.";
        }
        header('Location: markdown.php');
        exit;
    }
}

// Handle file download request
if (isset($_GET['download'])) {
    $fn = basename($_GET['download']);
    $fPath = $contentDir . $fn;
    if (file_exists($fPath) && str_ends_with($fn, '.md')) {
        header('Content-Type: text/markdown; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fn . '"');
        readfile($fPath);
        exit;
    }
}

// Scan directory for .md files
$mdFiles = [];
if (is_dir($contentDir)) {
    $files = scandir($contentDir);
    foreach ($files as $f) {
        if (str_ends_with($f, '.md')) {
            $fullPath = $contentDir . $f;
            $mdFiles[] = [
                'filename' => $f,
                'size'     => filesize($fullPath),
                'modified' => filemtime($fullPath),
                'content'  => file_get_contents($fullPath)
            ];
        }
    }
}
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Markdown Storage &amp; Sync</h1>
    <p class="admin-page-subtitle">Every blog post is maintained as an independent YAML-frontmattered <code>.md</code> file.</p>
  </div>
  <div class="admin-page-actions">
    <form method="POST" action="markdown.php" style="margin: 0;">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
      <input type="hidden" name="action" value="sync_all">
      <button type="submit" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
        Re-Sync All From MySQL
      </button>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Markdown Files in <code>content/blogs/</code> (<?= count($mdFiles) ?>)</h3>
    <span style="font-size: 12px; color: var(--admin-text-muted);">
      Directory protected via <code>content/.htaccess</code>
    </span>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>File Name</th>
          <th>Size</th>
          <th>Last Modified</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($mdFiles)): ?>
          <?php foreach ($mdFiles as $idx => $f): ?>
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="color: var(--admin-accent); font-weight: bold;">.MD</span>
                  <span style="font-family: monospace; font-size: 13px; font-weight: 600; color: var(--admin-text-main);">
                    <?= e($f['filename']) ?>
                  </span>
                </div>
              </td>
              <td style="font-size: 12.5px; color: var(--admin-text-muted);">
                <?= round($f['size'] / 1024, 2) ?> KB
              </td>
              <td style="font-size: 12px; color: var(--admin-text-muted);">
                <?= date('Y-m-d H:i:s', $f['modified']) ?>
              </td>
              <td style="text-align: right;">
                <div style="display: inline-flex; gap: 6px;">
                  <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" 
                          onclick='previewMarkdown(<?= $idx ?>)'>
                    Inspect Content
                  </button>
                  <a href="markdown.php?download=<?= urlencode($f['filename']) ?>" class="btn-admin btn-admin-secondary btn-admin-sm">
                    Download .md
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" style="text-align: center; color: var(--admin-text-muted); padding: 36px;">
              No markdown files found. Click "Re-Sync All From MySQL" above to generate them.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Inspect Modal -->
<div class="admin-modal-backdrop" id="mdModal">
  <div class="admin-modal" style="max-width: 820px;">
    <div class="admin-modal-header">
      <h3 class="admin-modal-title" id="mdModalTitle">Markdown Inspector</h3>
      <button type="button" onclick="closeMdModal()" style="background:none;border:none;font-size:22px;cursor:pointer;">&times;</button>
    </div>
    <div class="admin-modal-body">
      <pre id="mdModalContent" style="background: #252525; color: #F8F7F4; padding: 18px; border-radius: var(--admin-radius); font-size: 12.5px; font-family: monospace; max-height: 480px; overflow-y: auto; white-space: pre-wrap; line-height: 1.55;"></pre>
    </div>
    <div class="admin-modal-footer">
      <button type="button" class="btn-admin btn-admin-secondary" onclick="closeMdModal()">Close</button>
    </div>
  </div>
</div>

<script>
  const filesData = <?= json_encode($mdFiles) ?>;

  function previewMarkdown(idx) {
    const file = filesData[idx];
    if (!file) return;
    document.getElementById('mdModalTitle').textContent = file.filename;
    document.getElementById('mdModalContent').textContent = file.content;
    document.getElementById('mdModal').classList.add('is-open');
  }

  function closeMdModal() {
    document.getElementById('mdModal').classList.remove('is-open');
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

