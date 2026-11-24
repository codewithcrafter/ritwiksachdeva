<?php
/**
 * RITWIK SACHDEVA - APPLICATION CONFIGURATION
 * Environment-aware configuration, session security, and constants.
 */

// Prevent multiple inclusion
if (defined('APP_CONFIG_LOADED')) {
    return;
}
define('APP_CONFIG_LOADED', true);

// Set default timezone
date_default_timezone_set('Asia/Kolkata');

// Error reporting settings
// In production, display_errors should be 0 and log_errors 1.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// Database configuration
// Can be customized via environment variables or default settings
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'ritwik_cms_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

// Base Paths and URLs
define('ROOT_PATH', dirname(__DIR__));
define('CONTENT_BLOGS_PATH', ROOT_PATH . '/content/blogs');
define('UPLOADS_PATH', ROOT_PATH . '/assets/uploads');

// Automatically detect base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
$host = isset($_SERVER['HTTP_HOST']) ? rtrim($_SERVER['HTTP_HOST'], '.') : 'www.ritwiksachdeva.in';
$scriptDir = isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : '';
$scriptDir = str_replace('\\', '/', $scriptDir);

// Trim /admin or /blog if inside subfolder
$baseDir = preg_replace('#/(admin|blog|api|includes).*$#', '', $scriptDir);
$baseDir = rtrim($baseDir, '/');

if (php_sapi_name() === 'cli' && empty($_SERVER['HTTP_HOST'])) {
    define('BASE_URL', 'https://www.ritwiksachdeva.in');
} else {
    define('BASE_URL', rtrim($protocol . $host . $baseDir, '/'));
}
define('CANONICAL_DOMAIN', 'https://www.ritwiksachdeva.in');
define('ADMIN_URL', BASE_URL . '/admin');
define('SITE_URL', BASE_URL);

// Security Session Configuration
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 86400 * 7, // 7 days
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

/**
 * Global sanitize helper
 */
function e($string): string {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate slug from string
 */
function generate_slug(string $text): string {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a-' . time() : $text;
}

/**
 * Calculate reading time in minutes
 */
function calculate_reading_time(string $content, int $wpm = 200): int {
    $cleanText = strip_tags($content);
    $wordCount = str_word_count($cleanText);
    return max(1, (int)ceil($wordCount / $wpm));
}

