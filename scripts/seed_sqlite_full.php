<?php
// scripts/seed_sqlite_full.php
$sqlitePath = __DIR__ . '/../content/database.sqlite';
if (!is_dir(dirname($sqlitePath))) {
    mkdir(dirname($sqlitePath), 0755, true);
}

$pdo = new PDO('sqlite:' . $sqlitePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Execute tables creation
$tablesSql = "
CREATE TABLE IF NOT EXISTS `roles` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL UNIQUE,
    `display_name` TEXT NOT NULL,
    `description` TEXT DEFAULT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `permissions` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL UNIQUE,
    `module` TEXT NOT NULL,
    `description` TEXT DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `admin_role_permissions` (
    `role_id` INTEGER NOT NULL,
    `permission_id` INTEGER NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`)
);

CREATE TABLE IF NOT EXISTS `admins` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL,
    `email` TEXT NOT NULL UNIQUE,
    `password_hash` TEXT NOT NULL,
    `role_id` INTEGER NOT NULL DEFAULT 1,
    `avatar` TEXT DEFAULT NULL,
    `status` TEXT NOT NULL DEFAULT 'active',
    `last_login_at` TEXT DEFAULT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now')),
    `updated_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `blog_authors` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL,
    `slug` TEXT NOT NULL UNIQUE,
    `title` TEXT DEFAULT NULL,
    `bio` TEXT DEFAULT NULL,
    `avatar` TEXT DEFAULT NULL,
    `email` TEXT DEFAULT NULL,
    `social_links` TEXT DEFAULT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `blog_categories` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL,
    `slug` TEXT NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `blog_tags` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL,
    `slug` TEXT NOT NULL UNIQUE,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `blogs` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `title` TEXT NOT NULL,
    `slug` TEXT NOT NULL UNIQUE,
    `excerpt` TEXT NOT NULL,
    `content` TEXT NOT NULL,
    `featured_image` TEXT DEFAULT NULL,
    `featured_image_alt` TEXT DEFAULT NULL,
    `category_id` INTEGER DEFAULT NULL,
    `author_id` INTEGER NOT NULL DEFAULT 1,
    `status` TEXT NOT NULL DEFAULT 'draft',
    `is_featured` INTEGER NOT NULL DEFAULT 0,
    `reading_time` INTEGER NOT NULL DEFAULT 5,
    `faqs_json` TEXT DEFAULT NULL,
    `published_at` TEXT DEFAULT NULL,
    `scheduled_for` TEXT DEFAULT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now')),
    `updated_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `blog_tag_relations` (
    `blog_id` INTEGER NOT NULL,
    `tag_id` INTEGER NOT NULL,
    PRIMARY KEY (`blog_id`, `tag_id`)
);

CREATE TABLE IF NOT EXISTS `contact_leads` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `full_name` TEXT NOT NULL,
    `email` TEXT NOT NULL,
    `phone` TEXT DEFAULT NULL,
    `company` TEXT DEFAULT NULL,
    `service_interested` TEXT DEFAULT NULL,
    `monthly_budget` TEXT DEFAULT NULL,
    `message` TEXT NOT NULL,
    `status` TEXT NOT NULL DEFAULT 'NEW',
    `lead_source` TEXT NOT NULL DEFAULT 'Website Contact Form',
    `source_page` TEXT DEFAULT NULL,
    `source_trigger` TEXT DEFAULT NULL,
    `form_type` TEXT DEFAULT 'popup',
    `ip_address` TEXT DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `assigned_to` INTEGER DEFAULT NULL,
    `follow_up_date` TEXT DEFAULT NULL,
    `is_spam` INTEGER NOT NULL DEFAULT 0,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now')),
    `updated_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `lead_notes` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `lead_id` INTEGER NOT NULL,
    `admin_id` INTEGER NOT NULL,
    `note` TEXT NOT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `lead_activities` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `lead_id` INTEGER NOT NULL,
    `admin_id` INTEGER NOT NULL,
    `activity_type` TEXT NOT NULL,
    `description` TEXT NOT NULL,
    `created_at` TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS `seo_metadata` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `entity_type` TEXT NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `meta_title` TEXT DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `canonical_url` TEXT DEFAULT NULL,
    `target_keywords` TEXT DEFAULT NULL,
    `og_title` TEXT DEFAULT NULL,
    `og_description` TEXT DEFAULT NULL,
    `og_image` TEXT DEFAULT NULL,
    `robots` TEXT DEFAULT 'index, follow',
    `created_at` TEXT NOT NULL DEFAULT (datetime('now')),
    `updated_at` TEXT NOT NULL DEFAULT (datetime('now'))
);
";

$pdo->exec($tablesSql);

// Seed roles
$roles = [
    [1, 'SUPER_ADMIN', 'Super Administrator', 'Full Access'],
    [2, 'EDITOR', 'Content Editor', 'Editor Access'],
    [3, 'LEAD_MANAGER', 'Lead Manager', 'CRM Access']
];
foreach ($roles as $r) {
    $pdo->prepare("INSERT OR IGNORE INTO roles (id, name, display_name, description) VALUES (?, ?, ?, ?)")->execute($r);
}

// Seed default Admin: admin@ritwiksachdeva.in and admin@ritwiksachdeva.com
$hash = '$2y$12$daaRcVsl7UO5589u6tLmdO1z1bGSQTxx6EfDm5V/tHCJtIRYUVeJy'; // Admin@2026!
$pdo->prepare("INSERT OR REPLACE INTO admins (id, name, email, password_hash, role_id, status) VALUES (1, 'Ritwik Sachdeva', 'admin@ritwiksachdeva.in', ?, 1, 'active')")->execute([$hash]);
$pdo->prepare("INSERT OR REPLACE INTO admins (id, name, email, password_hash, role_id, status) VALUES (2, 'Ritwik Sachdeva', 'admin@ritwiksachdeva.com', ?, 1, 'active')")->execute([$hash]);

// Seed Author
$pdo->prepare("INSERT OR IGNORE INTO blog_authors (id, name, slug, title, bio, avatar, email) VALUES (1, 'Ritwik Sachdeva', 'ritwik-sachdeva', 'Senior Digital Marketing Consultant', 'Over a decade of performance marketing and growth strategy experience.', 'assets/images/about-consultant.svg', 'info@ritwiksachdeva.in')")->execute();

// Seed Categories
$categories = [
    [1, 'Business Strategy', 'business-strategy', 'Scaling and economics frameworks'],
    [2, 'Digital Transformation', 'digital-transformation', 'Tech stacks and modern marketing'],
    [3, 'Leadership & Growth', 'leadership-growth', 'Management and business growth'],
    [4, 'Artificial Intelligence', 'artificial-intelligence', 'AI workflows and predictive search'],
    [5, 'Performance Marketing', 'performance-marketing', 'Paid ads, Meta & Google Ads']
];
foreach ($categories as $cat) {
    $pdo->prepare("INSERT OR IGNORE INTO blog_categories (id, name, slug, description) VALUES (?, ?, ?, ?)")->execute($cat);
}

// Seed sample leads with attribution
$sampleLeads = [
    [
        'Vikram Malhotra', 'vikram@malhotratech.com', '+91 98112-33445', 'Malhotra Technologies',
        'Performance Marketing', '₹2,50,000 - ₹5,00,000 / mo',
        'Looking to audit our Google Ads campaigns and increase ROAS from 2.1x to 4.5x.',
        'NEW', 'Popup Modal: Inquire Now (/services/performance-marketing/)',
        '/services/performance-marketing/', 'Inquire Now', 'popup'
    ],
    [
        'Priya Sharma', 'priya@urbanattire.in', '+91 99201-88776', 'Urban Attire D2C',
        'E-Commerce Management', '₹1,00,000 - ₹2,50,000 / mo',
        'We need full Amazon India & Shopify account management to scale from 20L to 1Cr monthly GMV.',
        'CONTACTED', 'Popup Modal: Explore Service Details (/services/ecommerce-management/)',
        '/services/ecommerce-management/', 'Explore Service Details', 'popup'
    ],
    [
        'Arun Khurana', 'arun@khuranaindustries.com', '+91 98711-22334', 'Khurana Industries',
        'SEO Strategy & GEO', '₹50,000 - ₹1,00,000 / mo',
        'Organic search traffic has dropped after core algorithm updates. Need high-level technical SEO audit.',
        'QUALIFIED', 'Inline Form: Contact Page Form (/contact/)',
        '/contact/', 'Contact Page Inquiry Form', 'inline'
    ]
];

foreach ($sampleLeads as $sl) {
    $check = $pdo->prepare("SELECT COUNT(*) FROM contact_leads WHERE email = ?");
    $check->execute([$sl[1]]);
    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("
            INSERT INTO contact_leads (
                full_name, email, phone, company, service_interested,
                monthly_budget, message, status, lead_source, source_page,
                source_trigger, form_type, ip_address, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '127.0.0.1', datetime('now'))
        ");
        $stmt->execute($sl);
    }
}

echo "SQLite initialization & seeding complete!\n";
