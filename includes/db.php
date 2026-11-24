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
            $mysqlSuccess = false;
            try {
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

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                $mysqlSuccess = true;
            } catch (PDOException $e) {
                error_log("MySQL Connection unavailable: " . $e->getMessage() . " - switching to SQLite fallback.");
            }

            if (!$mysqlSuccess) {
                // Seamless SQLite fallback for local development or shared hosting environments
                $sqlitePath = dirname(__DIR__) . '/content/database.sqlite';
                if (!is_dir(dirname($sqlitePath))) {
                    mkdir(dirname($sqlitePath), 0755, true);
                }
                try {
                    self::$instance = new PDO('sqlite:' . $sqlitePath, null, null, [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]);
                } catch (PDOException $sqle) {
                    error_log("SQLite Connection Error: " . $sqle->getMessage());
                    if (php_sapi_name() === 'cli') {
                        die("Database connection failed: " . $sqle->getMessage() . "\n");
                    } else {
                        http_response_code(500);
                        die("<h1>Service Temporarily Unavailable</h1><p>Our database service is currently undergoing maintenance. Please try again shortly.</p>");
                    }
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

