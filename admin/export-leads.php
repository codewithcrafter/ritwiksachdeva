<?php
/**
 * Export Contact Leads to CSV
 */

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';

auth_require();

$pdo = get_db();
$status = trim($_GET['status'] ?? '');

$query = "
    SELECT *
    FROM contact_leads
";
$params = [];
if ($status !== '' && $status !== 'ALL') {
    $query .= " WHERE status = :status";
    $params[':status'] = $status;
}
$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filename = 'ritwik_consulting_leads_' . date('Y-m-d_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// UTF-8 BOM for Excel compatibility
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// CSV Header
fputcsv($output, [
    'Lead ID',
    'Full Name',
    'Work Email',
    'Phone',
    'Company',
    'Service Interested',
    'Monthly Budget',
    'Source Page URL',
    'Clicked Trigger / CTA',
    'Form Mechanism',
    'Full Lead Source',
    'Inquiry Message',
    'Pipeline Status',
    'IP Address',
    'Submission Date'
]);

foreach ($leads as $l) {
    $srcPage = $l['source_page'] ?? '';
    $srcTrigger = $l['source_trigger'] ?? '';
    if (empty($srcPage) && !empty($l['lead_source'])) {
        if (preg_match('/\((\/[^\)]*)\)/', $l['lead_source'], $mPage)) {
            $srcPage = $mPage[1];
        }
    }
    if (empty($srcTrigger) && !empty($l['lead_source'])) {
        if (preg_match('/(?:Popup Modal|Inline Form):\s*([^(]+)/i', $l['lead_source'], $mTrig)) {
            $srcTrigger = trim($mTrig[1]);
        } else {
            $srcTrigger = $l['lead_source'];
        }
    }
    $formType = $l['form_type'] ?? ((stripos($l['lead_source'] ?? '', 'popup') !== false) ? 'popup' : 'inline');

    fputcsv($output, [
        $l['id'],
        $l['full_name'],
        $l['email'],
        $l['phone'],
        $l['company'],
        $l['service_interested'],
        $l['monthly_budget'],
        $srcPage ?: '/',
        $srcTrigger ?: 'Direct',
        ($formType === 'popup') ? 'Popup Modal' : 'Contact Page Form',
        $l['lead_source'],
        $l['message'],
        $l['status'],
        $l['ip_address'],
        $l['created_at']
    ]);
}

fclose($output);
exit;


