<?php
/**
 * Admin Dashboard - Ritwik Sachdeva CMS
 * Real database metrics, visual trends, recent inquiries & articles
 */

$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';

// Fetch Live Statistics
$totalBlogs = (int)$pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$publishedBlogs = (int)$pdo->query("SELECT COUNT(*) FROM blogs WHERE status = 'published'")->fetchColumn();
$draftBlogs = (int)$pdo->query("SELECT COUNT(*) FROM blogs WHERE status = 'draft'")->fetchColumn();
$scheduledBlogs = (int)$pdo->query("SELECT COUNT(*) FROM blogs WHERE status = 'scheduled'")->fetchColumn();

$totalLeads = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
$newLeads = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads WHERE status = 'NEW'")->fetchColumn();
$qualifiedLeads = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads WHERE status = 'QUALIFIED'")->fetchColumn();
$convertedLeads = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads WHERE status = 'CONVERTED'")->fetchColumn();

$totalMedia = (int)$pdo->query("SELECT COUNT(*) FROM media_library")->fetchColumn();

// Recent Inquiries (Latest 5)
$recentLeadsStmt = $pdo->query("
    SELECT id, full_name, email, company, service_interested, monthly_budget, status, created_at
    FROM contact_leads
    ORDER BY created_at DESC
    LIMIT 5
");
$recentLeads = $recentLeadsStmt->fetchAll();

// Recent Blogs (Latest 5)
$recentBlogsStmt = $pdo->query("
    SELECT b.id, b.title, b.slug, b.status, b.published_at, b.created_at,
           c.name AS category_name, a.name AS author_name
    FROM blogs b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN authors a ON b.author_id = a.id
    ORDER BY b.created_at DESC
    LIMIT 5
");
$recentBlogs = $recentBlogsStmt->fetchAll();

// Category breakdown for chart
$catStatsStmt = $pdo->query("
    SELECT c.name, COUNT(b.id) AS blog_count
    FROM blog_categories c
    LEFT JOIN blogs b ON b.category_id = c.id
    GROUP BY c.id
    ORDER BY blog_count DESC
");
$catStats = $catStatsStmt->fetchAll();

// Leads by status breakdown
$statusStatsStmt = $pdo->query("
    SELECT status, COUNT(*) AS count
    FROM contact_leads
    GROUP BY status
");
$statusStatsRaw = $statusStatsStmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Executive Dashboard</h1>
    <p class="admin-page-subtitle">Welcome back, <?= e($currentUser['name'] ?? 'Admin') ?>. Here is the current growth and content activity.</p>
  </div>
  <div class="admin-page-actions">
    <a href="blog-edit.php" class="btn-admin btn-admin-primary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      Write Article
    </a>
    <a href="leads.php" class="btn-admin btn-admin-secondary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
      View Leads (<?= $totalLeads ?>)
    </a>
  </div>
</div>

<!-- TOP STATS CARDS -->
<div class="admin-stats-grid">
  <!-- Stat 1: Total Leads -->
  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-label">Total Inquiries</div>
      <div class="admin-stat-value"><?= $totalLeads ?></div>
      <div class="admin-stat-delta" style="color: var(--admin-info);">
        <strong><?= $newLeads ?></strong> pending triage
      </div>
    </div>
    <div class="admin-stat-icon blue">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
    </div>
  </div>

  <!-- Stat 2: Converted Clients -->
  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-label">Converted Clients</div>
      <div class="admin-stat-value"><?= $convertedLeads ?></div>
      <div class="admin-stat-delta" style="color: var(--admin-success);">
        <strong><?= $qualifiedLeads ?></strong> in proposal stage
      </div>
    </div>
    <div class="admin-stat-icon green">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
    </div>
  </div>

  <!-- Stat 3: Published Analyses -->
  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-label">Published Blogs</div>
      <div class="admin-stat-value"><?= $publishedBlogs ?></div>
      <div class="admin-stat-delta" style="color: var(--admin-accent);">
        <strong><?= $draftBlogs ?></strong> drafts &bull; <strong><?= $scheduledBlogs ?></strong> scheduled
      </div>
    </div>
    <div class="admin-stat-icon terracotta">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
    </div>
  </div>

  <!-- Stat 4: Media Assets -->
  <div class="admin-stat-card">
    <div>
      <div class="admin-stat-label">Media &amp; Markdown</div>
      <div class="admin-stat-value"><?= $totalMedia ?></div>
      <div class="admin-stat-delta" style="color: var(--admin-text-muted);">
        Markdown synced to <code>content/</code>
      </div>
    </div>
    <div class="admin-stat-icon amber">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
    </div>
  </div>
</div>

<!-- CHARTS ROW -->
<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; margin-bottom: 28px;">
  
  <!-- Left Chart: Lead Status Funnel -->
  <div class="admin-card" style="margin-bottom: 0;">
    <div class="admin-card-header">
      <h3 class="admin-card-title">CRM Inquiry Pipeline Funnel</h3>
      <a href="leads.php" class="btn-admin btn-admin-secondary btn-admin-sm">Manage Leads &rarr;</a>
    </div>
    <div class="admin-card-body">
      <div style="display: flex; flex-direction: column; gap: 14px;">
        <?php
          $pipelineStages = [
            'NEW' => ['label' => 'New Inquiries', 'color' => '#6366F1'],
            'CONTACTED' => ['label' => 'Contacted & Discovery', 'color' => '#F59E0B'],
            'QUALIFIED' => ['label' => 'Qualified Strategy Fits', 'color' => '#10B981'],
            'PROPOSAL_SENT' => ['label' => 'Proposal & Retainer Sent', 'color' => '#EC4899'],
            'CONVERTED' => ['label' => 'Active Consulting Clients', 'color' => '#16A34A'],
            'LOST' => ['label' => 'Closed / Disqualified', 'color' => '#EF4444']
          ];
          $maxCount = max(1, $totalLeads);
          foreach ($pipelineStages as $stKey => $stInfo):
            $count = $statusStatsRaw[$stKey] ?? 0;
            $percent = round(($count / $maxCount) * 100);
        ?>
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
              <span style="font-weight: 600; color: var(--admin-text-main);"><?= $stInfo['label'] ?></span>
              <span style="color: var(--admin-text-muted);"><strong><?= $count ?></strong> leads (<?= $percent ?>%)</span>
            </div>
            <div style="height: 9px; background: #FAF8F5; border-radius: 999px; overflow: hidden; border: 1px solid var(--admin-border-light);">
              <div style="height: 100%; width: <?= max(4, $percent) ?>%; background: <?= $stInfo['color'] ?>; border-radius: 999px; transition: width 0.4s ease;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Right Chart: Category Content Distribution -->
  <div class="admin-card" style="margin-bottom: 0;">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Content by Category</h3>
      <a href="categories.php" class="btn-admin btn-admin-secondary btn-admin-sm">Categories &rarr;</a>
    </div>
    <div class="admin-card-body">
      <div style="display: flex; flex-direction: column; gap: 12px;">
        <?php foreach ($catStats as $cat): 
          $pct = $totalBlogs > 0 ? round(($cat['blog_count'] / $totalBlogs) * 100) : 0;
        ?>
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px;">
              <span style="font-weight: 500;"><?= e($cat['name']) ?></span>
              <span style="color: var(--admin-accent); font-weight: 700;"><?= $cat['blog_count'] ?> articles</span>
            </div>
            <div style="height: 8px; background: #FAF8F5; border-radius: 999px; overflow: hidden; border: 1px solid var(--admin-border-light);">
              <div style="height: 100%; width: <?= max(5, $pct) ?>%; background: var(--admin-accent); border-radius: 999px;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</div>

<!-- RECENT INQUIRIES & RECENT POSTS -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

  <!-- Recent Inquiries -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Recent Inquiries (CRM)</h3>
      <a href="leads.php" class="btn-admin btn-admin-secondary btn-admin-sm">View All &rarr;</a>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Prospect</th>
            <th>Service</th>
            <th>Status</th>
            <th>Received</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentLeads)): ?>
            <?php foreach ($recentLeads as $lead): ?>
              <tr>
                <td>
                  <div style="font-weight: 600; color: var(--admin-text-main);"><?= e($lead['full_name']) ?></div>
                  <div style="font-size: 11.5px; color: var(--admin-text-muted);"><?= e($lead['company'] ?: $lead['email']) ?></div>
                </td>
                <td style="font-size: 12.5px;">
                  <?= e(mb_substr($lead['service_interested'] ?: 'Consulting', 0, 22)) ?>
                </td>
                <td>
                  <span class="admin-badge lead-<?= strtolower(str_replace('_', '', $lead['status'])) ?>">
                    <?= e($lead['status']) ?>
                  </span>
                </td>
                <td style="font-size: 12px; color: var(--admin-text-muted);">
                  <?= date('M d', strtotime($lead['created_at'])) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align: center; color: var(--admin-text-muted); padding: 24px;">No inquiries recorded yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Blog Posts -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Recent Strategic Articles</h3>
      <a href="blogs.php" class="btn-admin btn-admin-secondary btn-admin-sm">Manage All &rarr;</a>
    </div>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentBlogs)): ?>
            <?php foreach ($recentBlogs as $rb): ?>
              <tr>
                <td>
                  <a href="blog-edit.php?id=<?= $rb['id'] ?>" style="font-weight: 600; color: var(--admin-text-main); text-decoration: none;">
                    <?= e(mb_substr($rb['title'], 0, 36)) ?>...
                  </a>
                </td>
                <td style="font-size: 12.5px; color: var(--admin-text-muted);">
                  <?= e($rb['category_name'] ?: 'General') ?>
                </td>
                <td>
                  <span class="admin-badge status-<?= $rb['status'] ?>">
                    <?= strtoupper($rb['status']) ?>
                  </span>
                </td>
                <td>
                  <div style="display: flex; gap: 6px;">
                    <a href="blog-edit.php?id=<?= $rb['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-sm" title="Edit">
                      Edit
                    </a>
                    <a href="../blog-detail.php?slug=<?= urlencode($rb['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary btn-admin-sm" title="Preview">
                      &nearr;
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="text-align: center; color: var(--admin-text-muted); padding: 24px;">No articles created yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


