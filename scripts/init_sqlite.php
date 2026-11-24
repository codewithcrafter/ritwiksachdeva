<?php
// scripts/init_sqlite.php
$sqlitePath = __DIR__ . '/../content/database.sqlite';
if (!is_dir(dirname($sqlitePath))) {
    mkdir(dirname($sqlitePath), 0755, true);
}

$pdo = new PDO('sqlite:' . $sqlitePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Convert MySQL schema to SQLite compatible
$schema = file_get_contents(__DIR__ . '/../database/schema.sql');

// Clean MySQL specific syntax
$schema = preg_replace('/ENGINE=InnoDB[^;]*/i', '', $schema);
$schema = preg_replace('/DEFAULT CHARSET=[^;]*/i', '', $schema);
$schema = preg_replace('/COLLATE=[^;]*/i', '', $schema);
$schema = preg_replace('/INT UNSIGNED AUTO_INCREMENT PRIMARY KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $schema);
$schema = preg_replace('/INT UNSIGNED/i', 'INTEGER', $schema);
$schema = preg_replace('/TINYINT\(1\)/i', 'INTEGER', $schema);
$schema = preg_replace('/DATETIME/i', 'TEXT', $schema);
$schema = preg_replace('/ENUM\([^)]*\)/i', 'TEXT', $schema);
$schema = preg_replace('/ON UPDATE CURRENT_TIMESTAMP/i', '', $schema);
$schema = preg_replace('/INDEX `[^`]*` \([^)]*\),?/i', '', $schema);
$schema = preg_replace('/CONSTRAINT `[^`]*` FOREIGN KEY[^\n]*,?/i', '', $schema);
$schema = preg_replace('/,\s*\)/m', "\n)", $schema);

// Split and run statements
$stmts = explode(';', $schema);
foreach ($stmts as $stmt) {
    $stmt = trim($stmt);
    if (!empty($stmt)) {
        try {
            $pdo->exec($stmt);
        } catch (Exception $e) {
            // ignore table exists or minor syntax
        }
    }
}

// Add source_page and source_trigger columns to contact_leads if not exist
try {
    $pdo->exec("ALTER TABLE contact_leads ADD COLUMN source_page TEXT DEFAULT NULL");
} catch (Exception $e) {}
try {
    $pdo->exec("ALTER TABLE contact_leads ADD COLUMN source_trigger TEXT DEFAULT NULL");
} catch (Exception $e) {}
try {
    $pdo->exec("ALTER TABLE contact_leads ADD COLUMN form_type TEXT DEFAULT 'popup'");
} catch (Exception $e) {}

// Check tables
$tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
echo "SQLite created successfully! Tables: " . implode(', ', $tables) . "\n";

// Check default admin
$adminCount = (int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if ($adminCount === 0) {
    // Insert default admin
    $hash = password_hash('Admin@2026', PASSWORD_DEFAULT);
    $pdo->prepare("
        INSERT INTO admins (name, email, password_hash, role, is_active, created_at)
        VALUES ('Ritwik Sachdeva', 'admin@ritwiksachdeva.in', :h, 'SUPER_ADMIN', 1, datetime('now'))
    ")->execute([':h' => $hash]);
    echo "Default admin inserted: admin@ritwiksachdeva.in / Admin@2026\n";
}
