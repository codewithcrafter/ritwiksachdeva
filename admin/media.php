<?php
/**
 * Admin Media Library
 * Secure file upload, dimension inspection, gallery management & URL copying
 */

$pageTitle = 'Media Library';
require_once __DIR__ . '/includes/header.php';

$uploadDir = __DIR__ . '/../assets/images/uploads/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0755, true);
}

// Handle Upload / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'upload' && !empty($_FILES['file']['name'])) {
            $file = $_FILES['file'];
            $allowedMimes = [
                'image/jpeg'    => 'jpg',
                'image/png'     => 'png',
                'image/webp'    => 'webp',
                'image/gif'     => 'gif',
                'image/svg+xml' => 'svg'
            ];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!isset($allowedMimes[$mimeType])) {
                $_SESSION['flash_error'] = "Invalid image type ({$mimeType}). Only JPG, PNG, WEBP, GIF, and SVG are supported.";
            } elseif ($file['size'] > 8 * 1024 * 1024) {
                $_SESSION['flash_error'] = "File exceeds the 8MB maximum upload limit.";
            } else {
                $ext = $allowedMimes[$mimeType];
                $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '-', pathinfo($file['name'], PATHINFO_FILENAME));
                $finalFilename = $safeName . '-' . uniqid() . '.' . $ext;
                $destPath = $uploadDir . $finalFilename;

                if (move_uploaded_file($file['tmp_name'], $destPath)) {
                    $width = null;
                    $height = null;
                    if ($mimeType !== 'image/svg+xml') {
                        $sizes = @getimagesize($destPath);
                        if ($sizes) {
                            $width = $sizes[0];
                            $height = $sizes[1];
                        }
                    }

                    $relPath = 'assets/images/uploads/' . $finalFilename;
                    $altText = trim($_POST['alt_text'] ?? pathinfo($file['name'], PATHINFO_FILENAME));

                    $ins = $pdo->prepare("
                        INSERT INTO media_library (
                            filename, filepath, original_name, mime_type, file_size, width, height, alt_text, uploaded_by
                        ) VALUES (
                            :filename, :filepath, :orig, :mime, :size, :w, :h, :alt, :uid
                        )
                    ");
                    $ins->execute([
                        ':filename' => $finalFilename,
                        ':filepath' => $relPath,
                        ':orig'     => $file['name'],
                        ':mime'     => $mimeType,
                        ':size'     => $file['size'],
                        ':w'        => $width,
                        ':h'        => $height,
                        ':alt'      => $altText,
                        ':uid'      => $currentUser['id']
                    ]);

                    $_SESSION['flash_success'] = "Image uploaded successfully: {$finalFilename}";
                } else {
                    $_SESSION['flash_error'] = "Failed to store uploaded file.";
                }
            }
        } elseif ($action === 'delete') {
            $mediaId = (int)($_POST['media_id'] ?? 0);
            if ($mediaId > 0) {
                $mStmt = $pdo->prepare("SELECT filename, filepath FROM media_library WHERE id = :id");
                $mStmt->execute([':id' => $mediaId]);
                $mediaFile = $mStmt->fetch();

                if ($mediaFile) {
                    $fullPath = __DIR__ . '/../' . $mediaFile['filepath'];
                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                    $pdo->prepare("DELETE FROM media_library WHERE id = :id")->execute([':id' => $mediaId]);
                    $_SESSION['flash_success'] = "Media asset deleted.";
                }
            }
        }
        header('Location: media.php');
        exit;
    }
}

// Fetch media files
$mediaFiles = $pdo->query("SELECT * FROM media_library ORDER BY created_at DESC")->fetchAll();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Media Library (<?= count($mediaFiles) ?>)</h1>
    <p class="admin-page-subtitle">Upload and manage high-resolution featured banners, diagrams, and consultant photography.</p>
  </div>
</div>

<!-- UPLOAD CARD -->
<div class="admin-card" style="margin-bottom: 24px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Upload Image Asset</h3>
  </div>
  <div class="admin-card-body">
    <form method="POST" action="media.php" enctype="multipart/form-data" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
      <input type="hidden" name="action" value="upload">

      <div style="flex: 1; min-width: 260px;">
        <label class="form-label-admin">Select File (JPG, PNG, WEBP, SVG, GIF up to 8MB) *</label>
        <input type="file" name="file" accept=".jpg,.jpeg,.png,.webp,.svg,.gif" class="form-control-admin" required>
      </div>

      <div style="flex: 1; min-width: 240px;">
        <label class="form-label-admin">Alt Text / Description (SEO)</label>
        <input type="text" name="alt_text" class="form-control-admin" placeholder="Descriptive image summary">
      </div>

      <button type="submit" class="btn-admin btn-admin-primary">
        Upload Asset
      </button>
    </form>
  </div>
</div>

<!-- MEDIA GALLERY GRID -->
<?php if (!empty($mediaFiles)): ?>
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
    <?php foreach ($mediaFiles as $m): ?>
      <div class="admin-card" style="margin-bottom: 0;">
        <div style="height: 180px; overflow: hidden; background: #FAF8F5; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid var(--admin-border-light);">
          <img src="../<?= e($m['filepath']) ?>" 
               alt="<?= e($m['alt_text'] ?: $m['filename']) ?>" 
               style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
        <div style="padding: 14px;">
          <div style="font-weight: 600; font-size: 13px; color: var(--admin-text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= e($m['original_name']) ?>">
            <?= e($m['original_name']) ?>
          </div>
          <div style="font-size: 11.5px; color: var(--admin-text-muted); margin-top: 4px;">
            <?= $m['width'] ? "{$m['width']}x{$m['height']}px &bull; " : '' ?>
            <?= round($m['file_size'] / 1024, 1) ?> KB
          </div>

          <div style="display: flex; gap: 6px; margin-top: 12px;">
            <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" style="flex: 1;" 
                    onclick="copyPath('<?= e($m['filepath']) ?>')">
              Copy URL
            </button>
            <form method="POST" action="media.php" style="margin: 0;" onsubmit="return confirm('Delete this media asset?');">
              <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="media_id" value="<?= $m['id'] ?>">
              <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Delete">
                &times;
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="admin-card">
    <div class="admin-card-body" style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
      No media uploaded yet. Use the upload bar above to add illustrations and photography.
    </div>
  </div>
<?php endif; ?>

<script>
  function copyPath(path) {
    navigator.clipboard.writeText(path).then(() => {
      alert('Asset relative path copied to clipboard:\n' + path);
    });
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

