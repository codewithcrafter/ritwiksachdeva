<?php
/**
 * Admin CRM - Inquiries & Lead Management
 * Status updates, internal notes, activities audit log, and details modal
 */

$pageTitle = 'Inquiries & CRM Leads';
require_once __DIR__ . '/includes/header.php';

// Handle Actions (Status Update, Add Note, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf = $_POST['csrf_token'] ?? '';
    $leadId = (int)($_POST['lead_id'] ?? 0);

    if (auth_verify_csrf($csrf) && $leadId > 0) {
        if ($action === 'update_status') {
            $newStatus = trim($_POST['status'] ?? '');
            $validStatuses = ['NEW', 'CONTACTED', 'QUALIFIED', 'PROPOSAL_SENT', 'CONVERTED', 'LOST'];
            if (in_array($newStatus, $validStatuses)) {
                $upStmt = $pdo->prepare("UPDATE contact_leads SET status = :status, updated_at = NOW() WHERE id = :id");
                $upStmt->execute([':status' => $newStatus, ':id' => $leadId]);

                // Log Activity
                $actStmt = $pdo->prepare("
                    INSERT INTO lead_activities (lead_id, admin_id, activity_type, description)
                    VALUES (:lid, :aid, 'STATUS_UPDATE', :desc)
                ");
                $actStmt->execute([
                    ':lid'  => $leadId,
                    ':aid'  => $currentUser['id'],
                    ':desc' => "Pipeline status updated to '{$newStatus}' by {$currentUser['name']}"
                ]);

                $_SESSION['flash_success'] = "Lead #{$leadId} status updated to {$newStatus}.";
            }
        } elseif ($action === 'add_note') {
            $note = trim($_POST['note'] ?? '');
            if (!empty($note)) {
                $nStmt = $pdo->prepare("
                    INSERT INTO lead_notes (lead_id, admin_id, note)
                    VALUES (:lid, :aid, :note)
                ");
                $nStmt->execute([
                    ':lid'  => $leadId,
                    ':aid'  => $currentUser['id'],
                    ':note' => $note
                ]);

                // Log Activity
                $pdo->prepare("
                    INSERT INTO lead_activities (lead_id, admin_id, activity_type, description)
                    VALUES (:lid, :aid, 'NOTE_ADDED', 'Internal consultation note recorded')
                ")->execute([':lid' => $leadId, ':aid' => $currentUser['id']]);

                $_SESSION['flash_success'] = "Internal note added to Lead #{$leadId}.";
            }
        } elseif ($action === 'delete') {
            $pdo->prepare("DELETE FROM contact_leads WHERE id = :id")->execute([':id' => $leadId]);
            $_SESSION['flash_success'] = "Lead #{$leadId} deleted.";
        }
        header("Location: leads.php" . (!empty($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
        exit;
    }
}

// Filters & Pagination
$currentStatus = trim($_GET['status'] ?? 'ALL');
$search = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 15;
$offset = ($page - 1) * $perPage;

$where = ["1=1"];
$params = [];

if ($currentStatus !== '' && $currentStatus !== 'ALL') {
    $where[] = "l.status = :status";
    $params[':status'] = $currentStatus;
}

if ($search !== '') {
    $where[] = "(l.full_name LIKE :search OR l.email LIKE :search OR l.company LIKE :search OR l.message LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$whereClause = implode(' AND ', $where);

// Total Count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM contact_leads l WHERE {$whereClause}");
$countStmt->execute($params);
$totalLeads = (int)$countStmt->fetchColumn();
$totalPages = ceil($totalLeads / $perPage);

// Fetch Leads
$sql = "
    SELECT l.*, a.name AS assigned_admin_name
    FROM contact_leads l
    LEFT JOIN admins a ON l.assigned_to = a.id
    WHERE {$whereClause}
    ORDER BY l.created_at DESC
    LIMIT :limit OFFSET :offset
";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$leads = $stmt->fetchAll();

// Counts by status for pills
$statusCountsRaw = $pdo->query("SELECT status, COUNT(*) as cnt FROM contact_leads GROUP BY status")->fetchAll(PDO::FETCH_KEY_PAIR);
$allTotal = (int)$pdo->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Growth Inquiries CRM (<?= $totalLeads ?>)</h1>
    <p class="admin-page-subtitle">Track consultation briefs, manage pipeline stages, and document advisory interactions.</p>
  </div>
  <div class="admin-page-actions">
    <a href="export-leads.php<?= ($currentStatus !== 'ALL') ? '?status=' . urlencode($currentStatus) : '' ?>" class="btn-admin btn-admin-secondary">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
      Export CSV
    </a>
  </div>
</div>

<!-- STATUS FILTER PILLS & SEARCH -->
<div class="admin-card" style="margin-bottom: 20px;">
  <div class="admin-card-body" style="padding: 14px 20px; display: flex; flex-direction: column; gap: 14px;">
    
    <!-- Pills -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
      <a href="leads.php" class="btn-admin <?= ($currentStatus === 'ALL') ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-sm">
        All Inquiries <span style="margin-left: 4px; opacity: 0.8;">(<?= $allTotal ?>)</span>
      </a>
      <?php
        $statuses = [
          'NEW' => 'New',
          'CONTACTED' => 'Contacted',
          'QUALIFIED' => 'Qualified',
          'PROPOSAL_SENT' => 'Proposal Sent',
          'CONVERTED' => 'Converted',
          'LOST' => 'Lost'
        ];
        foreach ($statuses as $sKey => $sLabel):
          $cnt = $statusCountsRaw[$sKey] ?? 0;
      ?>
        <a href="leads.php?status=<?= $sKey ?>" class="btn-admin <?= ($currentStatus === $sKey) ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-sm">
          <?= $sLabel ?> (<?= $cnt ?>)
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Search Form -->
    <form method="GET" action="leads.php" style="display: flex; gap: 10px;">
      <?php if ($currentStatus !== 'ALL'): ?>
        <input type="hidden" name="status" value="<?= e($currentStatus) ?>">
      <?php endif; ?>
      <input type="text" name="q" value="<?= e($search) ?>" class="form-control-admin" placeholder="Search by prospect name, email, company, or message..." style="max-width: 450px;">
      <button type="submit" class="btn-admin btn-admin-secondary">Search</button>
      <?php if ($search !== '' || $currentStatus !== 'ALL'): ?>
        <a href="leads.php" class="btn-admin btn-admin-secondary" style="color: var(--admin-danger);">Clear Filter</a>
      <?php endif; ?>
    </form>

  </div>
</div>

<!-- LEADS TABLE -->
<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Prospect</th>
          <th>Company &amp; Phone</th>
          <th>Practice &amp; Budget</th>
          <th>Status</th>
          <th>Date</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($leads)): ?>
          <?php foreach ($leads as $l): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: var(--admin-text-main); font-size: 14px;">
                  <?= e($l['full_name']) ?>
                </div>
                <div style="font-size: 12px; color: var(--admin-accent); font-weight: 500;">
                  <a href="mailto:<?= e($l['email']) ?>" style="color: inherit; text-decoration: none;">
                    <?= e($l['email']) ?>
                  </a>
                </div>
              </td>
              <td>
                <div style="font-weight: 600; font-size: 13px; color: var(--admin-text-main);">
                  <?= e($l['company'] ?: 'Individual / Stealth') ?>
                </div>
                <div style="font-size: 11.5px; color: var(--admin-text-muted);">
                  <?= e($l['phone'] ?: 'No phone provided') ?>
                </div>
              </td>
              <td>
                <div style="font-size: 12.5px; font-weight: 500;">
                  <?= e($l['service_interested'] ?: 'Consulting') ?>
                </div>
                <div style="font-size: 11.5px; color: var(--admin-text-muted);">
                  Budget: <?= e($l['monthly_budget'] ?: 'Unspecified') ?>
                </div>
              </td>
              <td>
                <form method="POST" action="leads.php<?= $currentStatus !== 'ALL' ? '?status=' . urlencode($currentStatus) : '' ?>" style="margin: 0;">
                  <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                  <input type="hidden" name="action" value="update_status">
                  <input type="hidden" name="lead_id" value="<?= $l['id'] ?>">
                  <select name="status" class="form-control-admin" style="font-size: 11.5px; padding: 4px 8px; font-weight: 600; width: auto;" onchange="this.form.submit()">
                    <?php foreach ($statuses as $stVal => $stText): ?>
                      <option value="<?= $stVal ?>" <?= ($l['status'] === $stVal) ? 'selected' : '' ?>>
                        <?= $stText ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </form>
              </td>
              <td style="font-size: 12px; color: var(--admin-text-muted);">
                <?= date('M d, Y', strtotime($l['created_at'])) ?>
                <div style="font-size: 11px;"><?= date('h:i A', strtotime($l['created_at'])) ?></div>
              </td>
              <td style="text-align: right;">
                <div style="display: inline-flex; gap: 6px;">
                  <button type="button" class="btn-admin btn-admin-secondary btn-admin-sm" 
                          onclick='openLeadModal(<?= json_encode($l) ?>)'>
                    Details &amp; Notes
                  </button>
                  <form method="POST" action="leads.php" style="display: inline;" onsubmit="return confirm('Delete this consultation inquiry permanently?');">
                    <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="lead_id" value="<?= $l['id'] ?>">
                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Delete">
                      &times;
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align: center; color: var(--admin-text-muted); padding: 36px;">
              No inquiries found matching current filters.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- PAGINATION -->
<?php if ($totalPages > 1): ?>
  <div style="display: flex; justify-content: center; gap: 8px; margin-top: 20px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?= $i ?><?= ($currentStatus !== 'ALL') ? '&status=' . urlencode($currentStatus) : '' ?><?= $search ? '&q=' . urlencode($search) : '' ?>" 
         class="btn-admin <?= ($page === $i) ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-sm">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<!-- LEAD DETAILS & NOTES MODAL -->
<div class="admin-modal-backdrop" id="leadModal">
  <div class="admin-modal" style="max-width: 760px;">
    <div class="admin-modal-header">
      <h3 class="admin-modal-title" id="leadModalTitle">Consultation Inquiry Brief</h3>
      <button type="button" onclick="closeLeadModal()" style="background:none;border:none;font-size:22px;cursor:pointer;">&times;</button>
    </div>

    <div class="admin-modal-body" style="padding: 24px;">
      <!-- Prospect Info Grid -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #FAF8F5; padding: 18px; border-radius: var(--admin-radius); border: 1px solid var(--admin-border-light); margin-bottom: 20px;">
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Prospect Name</div>
          <div id="m_name" style="font-size: 15px; font-weight: 700; color: var(--admin-text-main);"></div>
        </div>
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Company / Brand</div>
          <div id="m_company" style="font-size: 14px; font-weight: 600; color: var(--admin-text-main);"></div>
        </div>
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Email Address</div>
          <div id="m_email" style="font-size: 13.5px; font-weight: 500;"></div>
        </div>
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Phone Number</div>
          <div id="m_phone" style="font-size: 13.5px;"></div>
        </div>
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Practice Area</div>
          <div id="m_service" style="font-size: 13.5px; font-weight: 600; color: var(--admin-accent);"></div>
        </div>
        <div>
          <div style="font-size: 11px; text-transform: uppercase; color: var(--admin-text-muted); font-weight: 700;">Monthly Budget</div>
          <div id="m_budget" style="font-size: 13.5px;"></div>
        </div>
      </div>

      <!-- Scope / Project Message -->
      <div style="margin-bottom: 24px;">
        <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
          Project Details &amp; Bottlenecks
        </h4>
        <div id="m_message" style="background: #FFFFFF; border: 1px solid var(--admin-border); border-radius: var(--admin-radius); padding: 16px; font-size: 14px; line-height: 1.6; white-space: pre-wrap;"></div>
      </div>

      <!-- Add Note Form -->
      <form method="POST" action="leads.php">
        <input type="hidden" name="csrf_token" value="<?= auth_csrf_token() ?>">
        <input type="hidden" name="action" value="add_note">
        <input type="hidden" name="lead_id" id="m_note_lead_id" value="0">

        <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: var(--admin-text-muted); margin-bottom: 8px;">
          Add Advisory Team Note
        </h4>
        <div class="form-group-admin">
          <textarea name="note" rows="3" class="form-control-admin" placeholder="Document discovery call findings, next steps, or qualification notes..." required></textarea>
        </div>
        <button type="submit" class="btn-admin btn-admin-primary btn-admin-sm">Save Internal Note</button>
      </form>
    </div>

    <div class="admin-modal-footer">
      <button type="button" class="btn-admin btn-admin-secondary" onclick="closeLeadModal()">Close Brief</button>
    </div>
  </div>
</div>

<script>
  function openLeadModal(lead) {
    document.getElementById('m_note_lead_id').value = lead.id;
    document.getElementById('leadModalTitle').textContent = 'Inquiry Brief #' + lead.id + ' â€” ' + lead.full_name;
    document.getElementById('m_name').textContent = lead.full_name;
    document.getElementById('m_company').textContent = lead.company || 'Not specified';
    document.getElementById('m_email').textContent = lead.email;
    document.getElementById('m_phone').textContent = lead.phone || 'Not provided';
    document.getElementById('m_service').textContent = lead.service_interested || 'General Consulting';
    document.getElementById('m_budget').textContent = lead.monthly_budget || 'Unspecified';
    document.getElementById('m_message').textContent = lead.message;
    document.getElementById('leadModal').classList.add('is-open');
  }

  function closeLeadModal() {
    document.getElementById('leadModal').classList.remove('is-open');
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


