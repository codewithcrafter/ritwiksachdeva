<?php
/**
 * RITWIK SACHDEVA - AUTHENTICATION & SECURITY MODULE
 * Production-grade RBAC, CSRF protection, rate limiting, and session management.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * Generate or retrieve CSRF token
 */
function auth_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token from request
 */
function auth_verify_csrf(?string $token = null): bool {
    if ($token === null) {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    }
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check login rate limiting
 */
function auth_is_rate_limited(string $identifier, int $maxAttempts = 5, int $decaySeconds = 900): bool {
    $now = time();
    if (!isset($_SESSION['login_attempts'][$identifier])) {
        $_SESSION['login_attempts'][$identifier] = [];
    }

    // Filter out attempts older than decay window
    $_SESSION['login_attempts'][$identifier] = array_filter(
        $_SESSION['login_attempts'][$identifier],
        fn($timestamp) => ($now - $timestamp) < $decaySeconds
    );

    return count($_SESSION['login_attempts'][$identifier]) >= $maxAttempts;
}

/**
 * Register failed login attempt
 */
function auth_record_failed_attempt(string $identifier): void {
    if (!isset($_SESSION['login_attempts'][$identifier])) {
        $_SESSION['login_attempts'][$identifier] = [];
    }
    $_SESSION['login_attempts'][$identifier][] = time();
}

/**
 * Clear login attempts upon successful authentication
 */
function auth_clear_rate_limit(string $identifier): void {
    unset($_SESSION['login_attempts'][$identifier]);
}

/**
 * Attempt admin login
 */
function auth_login(string $email, string $password): array {
    $email = trim($email);
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $rateLimitKey = md5($email . '_' . $ip);

    if (auth_is_rate_limited($rateLimitKey)) {
        return ['success' => false, 'error' => 'Too many failed login attempts. Please try again in 15 minutes.'];
    }

    $db = get_db();
    $stmt = $db->prepare("
        SELECT a.*, r.name AS role_name, r.display_name AS role_display
        FROM admins a
        JOIN roles r ON a.role_id = r.id
        WHERE a.email = :email AND a.status = 'active'
        LIMIT 1
    ");
    $stmt->execute(['email' => $email]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        auth_record_failed_attempt($rateLimitKey);
        return ['success' => false, 'error' => 'Invalid email address or password.'];
    }

    // Clear rate limiting
    auth_clear_rate_limit($rateLimitKey);

    // Regenerate session ID to prevent session fixation (when headers allow)
    if (!headers_sent()) {
        session_regenerate_id(true);
    }

    // Load admin permissions
    $permStmt = $db->prepare("
        SELECT p.name
        FROM permissions p
        JOIN admin_role_permissions arp ON p.id = arp.permission_id
        WHERE arp.role_id = :role_id
    ");
    $permStmt->execute(['role_id' => $admin['role_id']]);
    $permissions = $permStmt->fetchAll(PDO::FETCH_COLUMN);

    $_SESSION['admin_user'] = [
        'id'           => (int)$admin['id'],
        'name'         => $admin['name'],
        'email'        => $admin['email'],
        'role_id'      => (int)$admin['role_id'],
        'role_name'    => $admin['role_name'],
        'role_display' => $admin['role_display'],
        'avatar'       => $admin['avatar'] ?: 'assets/images/about-consultant.svg',
        'permissions'  => $permissions,
        'logged_in_at' => time()
    ];

    // Update last login timestamp in DB
    $updateStmt = $db->prepare("UPDATE admins SET last_login_at = NOW() WHERE id = :id");
    $updateStmt->execute(['id' => $admin['id']]);

    return ['success' => true, 'admin' => $_SESSION['admin_user']];
}

/**
 * Check if admin is currently authenticated
 */
function auth_check(): bool {
    return !empty($_SESSION['admin_user']['id']);
}

/**
 * Retrieve authenticated admin data
 */
function auth_user(): ?array {
    return $_SESSION['admin_user'] ?? null;
}

/**
 * Check if authenticated user has specific role
 */
function auth_has_role(string ...$roles): bool {
    if (!auth_check()) return false;
    $userRole = $_SESSION['admin_user']['role_name'] ?? '';
    if ($userRole === 'SUPER_ADMIN') return true;
    return in_array($userRole, $roles, true);
}

/**
 * Check if authenticated user has specific permission
 */
function auth_has_permission(string $permission): bool {
    if (!auth_check()) return false;
    if (($_SESSION['admin_user']['role_name'] ?? '') === 'SUPER_ADMIN') {
        return true;
    }
    $permissions = $_SESSION['admin_user']['permissions'] ?? [];
    return in_array($permission, $permissions, true);
}

/**
 * Enforce authentication and optional permission
 */
function auth_require(?string $permission = null, ?string $role = null): void {
    if (!auth_check()) {
        $loginUrl = ADMIN_URL . '/login.php';
        header("Location: $loginUrl");
        exit;
    }

    if ($role !== null && !auth_has_role($role)) {
        http_response_code(403);
        die("<h1>403 Forbidden</h1><p>You do not have access to this resource.</p><p><a href='" . ADMIN_URL . "/'>Return to Dashboard</a></p>");
    }

    if ($permission !== null && !auth_has_permission($permission)) {
        http_response_code(403);
        die("<h1>403 Forbidden</h1><p>You lack the required permission: <code>" . e($permission) . "</code></p><p><a href='" . ADMIN_URL . "/'>Return to Dashboard</a></p>");
    }
}

/**
 * Log out admin
 */
function auth_logout(): void {
    $_SESSION['admin_user'] = null;
    unset($_SESSION['admin_user']);
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}
