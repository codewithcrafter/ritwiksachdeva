<?php
/**
 * RITWIK SACHDEVA - DATABASE CONNECTION MODULE
 * Robust PDO Singleton with Prepared Statements and Error Handling.
 */

require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $instance = null;

    /**
     * Get singleton PDO connection instance
     */
    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_PORT,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Log real error securely on server
                error_log("Database Connection Error: " . $e->getMessage());

                // Mask database details from public users
                if (php_sapi_name() === 'cli') {
                    die("Database connection failed: " . $e->getMessage() . "\n");
                } else {
                    http_response_code(500);
                    die("<h1>Service Temporarily Unavailable</h1><p>Our database service is currently undergoing maintenance. Please try again shortly.</p>");
                }
            }
        }

        return self::$instance;
    }

    /**
     * Prevent direct cloning or instantiation
     */
    private function __construct() {}
    private function __clone() {}
}

/**
 * Convenient procedural wrapper
 */
function get_db(): PDO {
    return Database::getConnection();
}

