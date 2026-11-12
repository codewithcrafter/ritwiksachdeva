<?php
/**
 * Public Contact Form API Endpoint
 * Handles consultation inquiries, validates input, and records CRM leads.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
    exit;
}

// Support both form-urlencoded/multipart and application/json payloads
$input = $_POST;
if (empty($input)) {
    $rawInput = file_get_contents('php://input');
    if ($rawInput) {
        $decoded = json_decode($rawInput, true);
        if (is_array($decoded)) {
            $input = $decoded;
        }
    }
}

// Honeypot spam check
if (!empty($input['website_hp']) || !empty($input['company_website_url'])) {
    // Silently succeed for bots
    echo json_encode(['success' => true, 'message' => 'Inquiry received.']);
    exit;
}

$fullName = trim($input['name'] ?? $input['client_name'] ?? '');
$email = trim($input['email'] ?? $input['client_email'] ?? '');
$phone = trim($input['phone'] ?? $input['client_phone'] ?? '');
$company = trim($input['company'] ?? $input['client_company'] ?? '');
$service = trim($input['service'] ?? $input['client_service'] ?? '');
$budget = trim($input['budget'] ?? $input['client_budget'] ?? '');
$message = trim($input['message'] ?? $input['client_message'] ?? '');

$errors = [];

if (mb_strlen($fullName) < 2) {
    $errors['name'] = 'Please enter your full name (at least 2 characters).';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}

if (mb_strlen($message) < 10) {
    $errors['message'] = 'Please provide details about your project (at least 10 characters).';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $pdo = get_db();

    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250);

    $stmt = $pdo->prepare("
        INSERT INTO `contact_leads` (
            `full_name`, `email`, `phone`, `company`, `service_interested`,
            `monthly_budget`, `message`, `status`, `lead_source`, `ip_address`, `user_agent`
        ) VALUES (
            :name, :email, :phone, :company, :service,
            :budget, :message, 'NEW', 'Website Contact Form', :ip, :ua
        )
    ");

    $stmt->execute([
        ':name'    => $fullName,
        ':email'   => $email,
        ':phone'   => $phone ?: null,
        ':company' => $company ?: null,
        ':service' => $service ?: null,
        ':budget'  => $budget ?: null,
        ':message' => $message,
        ':ip'      => $ip,
        ':ua'      => $userAgent
    ]);

    $leadId = (int)$pdo->lastInsertId();

    // Log initial activity
    $actStmt = $pdo->prepare("
        INSERT INTO `lead_activities` (`lead_id`, `activity_type`, `description`)
        VALUES (:lead_id, 'LEAD_CREATED', 'New consultation inquiry submitted via website form')
    ");
    $actStmt->execute([':lead_id' => $leadId]);

    echo json_encode([
        'success' => true,
        'lead_id' => $leadId,
        'message' => 'Thank you! Your strategic inquiry has been recorded. We will connect with you within 24 business hours.'
    ]);
} catch (Exception $e) {
    error_log("Contact API Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred while saving your inquiry. Please try again or reach out directly.'
    ]);
}

