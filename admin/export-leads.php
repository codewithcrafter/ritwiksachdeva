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
    SELECT id, full_name, email, phone, company, service_interested, 
           monthly_budget, message, status, lead_source, ip_address, created_at
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
    'Inquiry Message',
    'Pipeline Status',
    'Lead Source',
    'IP Address',
    'Submission Date'
]);

foreach ($leads as $l) {
    fputcsv($output, [
        $l['id'],
        $l['full_name'],
        $l['email'],
        $l['phone'],
        $l['company'],
        $l['service_interested'],
        $l['monthly_budget'],
        $l['message'],
        $l['status'],
        $l['lead_source'],
        $l['ip_address'],
        $l['created_at']
    ]);
}

fclose($output);
exit;


