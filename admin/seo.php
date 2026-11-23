<?php
/**
 * Admin SEO & Dynamic Sitemap Manager
 */

$pageTitle = 'SEO & Sitemaps';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../includes/seo.php';

$sitemapPath = __DIR__ . '/../sitemap.xml';

// Handle Sitemap Regeneration or Page SEO Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';

    if (auth_verify_csrf($csrf)) {
        if ($action === 'generate_sitemap') {
            $count = SeoManager::generateSitemap();
            $_SESSION['flash_success'] = "Dynamic sitemap generated with {$count} indexed URLs.";
        } elseif ($action === 'save_page_seo') {
            $pageKey = trim($_POST['page_key'] ?? '');
            $title = trim($_POST['meta_title'] ?? '');
            $desc = trim($_POST['meta_description'] ?? '');
            $canon = trim($_POST['canonical_url'] ?? '');
            $og = trim($_POST['og_image'] ?? '');
            $robots = trim($_POST['robots'] ?? 'index, follow');

            if (!empty($pageKey)) {
                $check = $pdo->prepare("SELECT id FROM seo_metadata WHERE entity_type = 'page' AND entity_id = 0 AND canonical_url = :canon_key");
                $check->execute([':canon_key' => $pageKey]);
                $existing = $check->fetchColumn();

                if ($existing) {
                    $up = $pdo->prepare("
                        UPDATE seo_metadata SET
                            meta_title = :t, meta_description = :d, canonical_url = :c, og_image = :og, robots = :r, updated_at = NOW()
                        WHERE id = :id
                    ");
                    $up->execute([':t' => $title, ':d' => $desc, ':c' => $canon ?: $pageKey, ':og' => $og ?: null, ':r' => $robots, ':id' => $existing]);
                } else {
                    $ins = $pdo->prepare("
                        INSERT INTO seo_metadata (entity_type, entity_id, meta_title, meta_description, canonical_url, og_image, robots)
                        VALUES ('page', 0, :t, :d, :c, :og, :r)
                    ");
                    $ins->execute([':t' => $title, ':d' => $desc, ':c' => $canon ?: $pageKey, ':og' => $og ?: null, ':r' => $robots]);
                }
                $_SESSION['flash_success'] = "Page SEO metadata updated for {$pageKey}.";
            }
        }
        header('Location: seo.php');
        exit;
    }
}

// Sitemap file stats
$sitemapExists = file_exists($sitemapPath);
$sitemapSize = $sitemapExists ? filesize($sitemapPath) : 0;
$sitemapTime = $sitemapExists ? filemtime($sitemapPath) : 0;
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Search Engine Optimization &amp; Sitemaps</h1>
    <p class="admin-page-subtitle">Configure page meta tags, canonical protocols, and dynamic XML sitemaps for Google Search Console.</p>
  </div>
  <div class="admin-page-actions">
    <form method="POST" action="seo.php" style="margin: 0;">
      <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
      <input type="hidden" name="action" value="generate_sitemap">
      <button type="submit" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
        Re-Generate XML Sitemap
      </button>
    </form>
  </div>
</div>

<!-- SITEMAP STATUS CARD -->
<div class="admin-card" style="margin-bottom: 24px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Dynamic XML Sitemap Status</h3>
    <?php if ($sitemapExists): ?>
      <a href="../sitemap.xml" target="_blank" class="btn-admin btn-admin-secondary btn-admin-sm">
        View Live sitemap.xml &nearr;
      </a>
    <?php endif; ?>
  </div>
  <div class="admin-card-body">
    <?php if ($sitemapExists): ?>
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
        <div style="background: #FAF8F5; padding: 16px; border-radius: var(--admin-radius); border: 1px solid var(--admin-border-light);">
          <div style="font-size: 11.5px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">File Location</div>
          <div style="font-size: 14px; font-weight: 600; color: var(--admin-text-main); margin-top: 4px;"><code>/sitemap.xml</code></div>
        </div>
        <div style="background: #FAF8F5; padding: 16px; border-radius: var(--admin-radius); border: 1px solid var(--admin-border-light);">
          <div style="font-size: 11.5px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">File Size</div>
          <div style="font-size: 14px; font-weight: 600; color: var(--admin-text-main); margin-top: 4px;"><?= round($sitemapSize / 1024, 2) ?> KB</div>
        </div>
        <div style="background: #FAF8F5; padding: 16px; border-radius: var(--admin-radius); border: 1px solid var(--admin-border-light);">
          <div style="font-size: 11.5px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Last Regenerated</div>
          <div style="font-size: 14px; font-weight: 600; color: var(--admin-text-main); margin-top: 4px;"><?= date('Y-m-d H:i:s', $sitemapTime) ?></div>
        </div>
      </div>
    <?php else: ?>
      <div class="admin-alert admin-alert-danger" style="margin-bottom: 0;">
        No sitemap found. Click "Re-Generate XML Sitemap" to build the root sitemap file.
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- PAGE LEVEL SEO CONTROLS -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Static Pages SEO Presets</h3>
  </div>
  <div class="admin-card-body">
    <div style="display: flex; flex-direction: column; gap: 24px;">

      <!-- Home Page -->
      <div style="border-bottom: 1px solid var(--admin-border-light); padding-bottom: 20px;">
        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 8px;">Home Page (index.html)</h4>
        <div style="font-size: 13px; color: var(--admin-text-muted);">
          <strong>Title:</strong> Digital Marketing Consultant | Strategy, SEO &amp; Business Growth<br>
          <strong>Meta Description:</strong> Explore professional digital marketing strategies, SEO, performance marketing and lead generation solutions designed to help businesses grow.
        </div>
      </div>

      <!-- About Page -->
      <div style="border-bottom: 1px solid var(--admin-border-light); padding-bottom: 20px;">
        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 8px;">About Page (about.html)</h4>
        <div style="font-size: 13px; color: var(--admin-text-muted);">
          <strong>Title:</strong> About Ritwik Sachdeva | Senior Digital Marketing Consultant<br>
          <strong>Meta Description:</strong> Learn about Ritwik Sachdeva's background, consulting philosophy, enterprise growth experience, and strategic frameworks.
        </div>
      </div>

      <!-- Services Page -->
      <div style="border-bottom: 1px solid var(--admin-border-light); padding-bottom: 20px;">
        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 8px;">Services Page (services.html)</h4>
        <div style="font-size: 13px; color: var(--admin-text-muted);">
          <strong>Title:</strong> Digital Marketing Services | Fractional CMO, SEO &amp; Performance Strategy<br>
          <strong>Meta Description:</strong> Comprehensive digital marketing consulting capabilities including SEO strategy, paid media management, and conversion rate optimization.
        </div>
      </div>

      <!-- Blog Page -->
      <div>
        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 8px;">Blog &amp; Knowledge Base (blog.php)</h4>
        <div style="font-size: 13px; color: var(--admin-text-muted);">
          <strong>Title:</strong> Marketing &amp; Strategy Blog | Ritwik Sachdeva - Growth Perspectives<br>
          <strong>Meta Description:</strong> In-depth insights, frameworks, and tactical blueprints for digital transformation, B2B lead generation, performance marketing, and executive leadership.
        </div>
      </div>

    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


