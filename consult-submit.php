<?php
/**
 * ==========================================================================
 * GROWTH CONSULTATION POPUP - FORM SUBMISSION HANDLER
 * Validates inquiry, performs rate-limiting & anti-spam checks, and dispatches
 * email notification to Info@ritwiksachdeva.in.
 * ==========================================================================
 */

header('Content-Type: application/json; charset=utf-8');

// 1. Accept POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method Not Allowed. Only POST requests are accepted.'
    ]);
    exit;
}

// 2. Session-based rate limiting (max 3 submissions per 10 minutes per visitor)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$now = time();
$windowSeconds = 600; //  10 minutes
$maxSubmissions = 3;

if (!isset($_SESSION['consult_submissions']) || !is_array($_SESSION['consult_submissions'])) {
    $_SESSION['consult_submissions'] = [];
}

// Filter out submissions older than the rate limit window
$_SESSION['consult_submissions'] = array_filter(
    $_SESSION['consult_submissions'],
    function ($timestamp) use ($now, $windowSeconds) {
        return ($now - $timestamp) < $windowSeconds;
    }
);

if (count($_SESSION['consult_submissions']) >= $maxSubmissions) {
    http_response_code(429);
    echo json_encode([
        'success' => false,
        'message' => 'Too many requests. Please wait a few minutes before submitting again.'
    ]);
    exit;
}

// 3. Spam protection: Honeypot check
$honeypot = trim($_POST['website_url'] ?? '');
if (!empty($honeypot)) {
    // Silently succeed for automated spam bots without executing or sending mail
    echo json_encode([
        'success' => true,
        'message' => 'Inquiry received successfully!'
    ]);
    exit;
}

// 4. Capture and sanitize inputs
$rawName    = trim($_POST['name'] ?? '');
$rawEmail   = trim($_POST['email'] ?? '');
$rawPhone   = trim($_POST['phone'] ?? '');
$rawMessage = trim($_POST['message'] ?? '');

// Prevent email header injection: Disallow carriage returns or newlines in headers
if (preg_match('/[\r\n]/', $rawName) || preg_match('/[\r\n]/', $rawEmail)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid characters detected in form submission.'
    ]);
    exit;
}

// 5. Server-side validation
$errors = [];

// Name validation: required, min 2 characters
if (mb_strlen($rawName) < 2) {
    $errors[] = 'Full Name must be at least 2 characters long.';
}

// Email validation: required, valid email format
if (!filter_var($rawEmail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}

// Phone validation: required, digits/+/spaces/dash only, 7 to 15 digits
$phoneDigits = preg_replace('/[^0-9]/', '', $rawPhone);
$phoneValidChars = preg_match('/^[0-9+\s\-()]{7,25}$/', $rawPhone);
if (!$phoneValidChars || strlen($phoneDigits) < 7 || strlen($phoneDigits) > 15) {
    $errors[] = 'Please provide a valid phone number (between 7 and 15 digits).';
}

// Message is optional for the consultation form.
if ($rawMessage === '') {
    $rawMessage = 'No message provided.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors)
    ]);
    exit;
}

// 6. Capture attribution fields
$sourcePage    = trim($_POST['source_page'] ?? $_SERVER['HTTP_REFERER'] ?? '/');
$sourceTrigger = trim($_POST['source_trigger'] ?? 'Popup Modal');
$formType      = trim($_POST['form_type'] ?? 'popup');
$serviceFocus  = trim($_POST['service_focus'] ?? $_POST['service'] ?? 'Growth Consultation');
$leadSource    = "Popup Modal: {$sourceTrigger} ({$sourcePage})";

// Sanitize for safe output / email rendering
$name    = htmlspecialchars(strip_tags($rawName), ENT_QUOTES, 'UTF-8');
$email   = filter_var($rawEmail, FILTER_SANITIZE_EMAIL);
$phone   = htmlspecialchars(strip_tags($rawPhone), ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars(strip_tags($rawMessage), ENT_QUOTES, 'UTF-8');

// 7. Save to Database (contact_leads) & JSON File Fallback
$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
if (strpos($ipAddress, ',') !== false) {
    $ipParts = explode(',', $ipAddress);
    $ipAddress = trim($ipParts[0]);
}
$userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 250);

try {
    require_once __DIR__ . '/includes/config.php';
    require_once __DIR__ . '/includes/db.php';
    $pdo = get_db();
    
    // Check if source_page column exists, fallback to standard lead_source if not
    $insertQuery = "
        INSERT INTO `contact_leads` (
            `full_name`, `email`, `phone`, `company`, `service_interested`,
            `monthly_budget`, `message`, `status`, `lead_source`,
            `source_page`, `source_trigger`, `form_type`, `ip_address`, `user_agent`
        ) VALUES (
            :name, :email, :phone, 'Individual / Inbound Lead', :service,
            'Consultation Discussion', :message, 'NEW', :lead_source,
            :src_page, :src_trigger, :form_type, :ip, :ua
        )
    ";
    try {
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([
            ':name'        => $name,
            ':email'       => $email,
            ':phone'       => $phone,
            ':service'     => $serviceFocus,
            ':message'     => $rawMessage,
            ':lead_source' => $leadSource,
            ':src_page'    => $sourcePage,
            ':src_trigger' => $sourceTrigger,
            ':form_type'   => $formType,
            ':ip'          => $ipAddress,
            ':ua'          => $userAgent
        ]);
    } catch (Exception $colEx) {
        // Fallback for older MySQL schema without separate source columns
        $stmtFallback = $pdo->prepare("
            INSERT INTO `contact_leads` (
                `full_name`, `email`, `phone`, `service_interested`,
                `message`, `status`, `lead_source`, `ip_address`, `user_agent`
            ) VALUES (
                :name, :email, :phone, :service,
                :message, 'NEW', :lead_source, :ip, :ua
            )
        ");
        $stmtFallback->execute([
            ':name'        => $name,
            ':email'       => $email,
            ':phone'       => $phone,
            ':service'     => $serviceFocus,
            ':message'     => $rawMessage,
            ':lead_source' => $leadSource,
            ':ip'          => $ipAddress,
            ':ua'          => $userAgent
        ]);
    }
} catch (Exception $dbEx) {
    error_log("Database lead insertion error: " . $dbEx->getMessage());
}

// Write to content/leads.json as persistent file-based backup
try {
    $leadsJsonPath = __DIR__ . '/content/leads.json';
    if (!is_dir(dirname($leadsJsonPath))) {
        mkdir(dirname($leadsJsonPath), 0755, true);
    }
    $existingLeads = [];
    if (is_file($leadsJsonPath)) {
        $jsonContent = file_get_contents($leadsJsonPath);
        $existingLeads = json_decode($jsonContent, true) ?: [];
    }
    $newLeadRecord = [
        'id'             => count($existingLeads) + 1,
        'full_name'      => $name,
        'email'          => $email,
        'phone'          => $phone,
        'company'        => 'Individual / Inbound Lead',
        'service'        => $serviceFocus,
        'message'        => $rawMessage,
        'status'         => 'NEW',
        'lead_source'    => $leadSource,
        'source_page'    => $sourcePage,
        'source_trigger' => $sourceTrigger,
        'form_type'      => $formType,
        'ip_address'     => $ipAddress,
        'created_at'     => date('Y-m-d H:i:s')
    ];
    array_unshift($existingLeads, $newLeadRecord);
    file_put_contents($leadsJsonPath, json_encode($existingLeads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
} catch (Exception $jsonEx) {
    error_log("JSON lead storage error: " . $jsonEx->getMessage());
}

// 8. Record rate-limit timestamp
$_SESSION['consult_submissions'][] = $now;

// 9. Compose and send email notification
$to = 'Info@ritwiksachdeva.in';
$subject = "Growth Consultation Inquiry [{$sourceTrigger}]: {$name}";

// Determine sender domain
$host = $_SERVER['SERVER_NAME'] ?? 'ritwiksachdeva.in';
if ($host === 'localhost' || $host === '127.0.0.1' || empty($host)) {
    $senderDomain = 'ritwiksachdeva.in';
} else {
    $senderDomain = preg_replace('/^www\./i', '', $host);
}
$fromEmail = "no-reply@{$senderDomain}";

$submissionDate = date('d M Y, H:i:s T');

$emailBody = "====================================================\n"
           . " NEW GROWTH CONSULTATION INQUIRY\n"
           . "====================================================\n\n"
           . "Full Name:       {$name}\n"
           . "Email Address:   {$email}\n"
           . "Phone Number:    {$phone}\n"
           . "Source Page:     {$sourcePage}\n"
           . "Clicked Trigger: {$sourceTrigger}\n"
           . "Form Type:       {$formType}\n"
           . "Submission Time: {$submissionDate}\n"
           . "Client IP:       {$ipAddress}\n\n"
           . "----------------------------------------------------\n"
           . "GROWTH GOALS & CHALLENGES:\n"
           . "----------------------------------------------------\n"
           . "{$rawMessage}\n\n"
           . "====================================================\n"
           . "Submitted via Ritwik Sachdeva Consultation Popup\n";

$headers = [
    "From: Ritwik Sachdeva Advisory <{$fromEmail}>",
    "Reply-To: {$name} <{$email}>",
    "X-Mailer: PHP/" . phpversion(),
    "MIME-Version: 1.0",
    "Content-Type: text/plain; charset=UTF-8",
    "Content-Transfer-Encoding: 8bit"
];

// Send email with PHP's built-in mail()
$mailSent = @mail($to, $subject, $emailBody, implode("\r\n", $headers));

// 10. Return clean JSON response
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Thank you! Your consultation inquiry has been received. Our advisory team will connect with you within 24 business hours.'
]);
