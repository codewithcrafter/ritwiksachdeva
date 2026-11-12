-- ============================================================================
-- RITWIK SACHDEVA - BUSINESS CONSULTING & BLOG CMS DATABASE SCHEMA
-- Compatible with MySQL 8.0+ and MariaDB 10.4+ (Hostinger / cPanel / Standard LAMP)
-- Normalized architecture, InnoDB engine, utf8mb4 encoding, referential integrity.
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `ritwik_cms_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ritwik_cms_db`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- 1. ROLES TABLE
-- ----------------------------------------------------------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `lead_activities`;
DROP TABLE IF EXISTS `lead_notes`;
DROP TABLE IF EXISTS `contact_leads`;
DROP TABLE IF EXISTS `blog_revisions`;
DROP TABLE IF EXISTS `blog_tag_relations`;
DROP TABLE IF EXISTS `scheduled_publications`;
DROP TABLE IF EXISTS `blogs`;
DROP TABLE IF EXISTS `blog_tags`;
DROP TABLE IF EXISTS `blog_categories`;
DROP TABLE IF EXISTS `blog_authors`;
DROP TABLE IF EXISTS `media_library`;
DROP TABLE IF EXISTS `seo_metadata`;
DROP TABLE IF EXISTS `website_settings`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `display_name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 2. PERMISSIONS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `permissions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `module` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 3. ADMIN ROLE PERMISSIONS TABLE (Pivot)
-- ----------------------------------------------------------------------------
CREATE TABLE `admin_role_permissions` (
    `role_id` INT UNSIGNED NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    CONSTRAINT `fk_arp_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_arp_perm` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 4. ADMINS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `admins` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role_id` INT UNSIGNED NOT NULL,
    `avatar` VARCHAR(255) DEFAULT NULL,
    `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
    `last_login_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_admin_email` (`email`),
    INDEX `idx_admin_status` (`status`),
    CONSTRAINT `fk_admins_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 5. BLOG AUTHORS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `blog_authors` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL UNIQUE,
    `title` VARCHAR(150) DEFAULT 'Business & Marketing Consultant',
    `bio` TEXT DEFAULT NULL,
    `avatar` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(191) DEFAULT NULL,
    `social_links` JSON DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_author_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 6. BLOG CATEGORIES TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `blog_categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL UNIQUE,
    `description` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_cat_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 7. BLOG TAGS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `blog_tags` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL UNIQUE,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_tag_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 8. BLOGS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `blogs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(191) NOT NULL UNIQUE,
    `excerpt` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `featured_image` VARCHAR(255) DEFAULT NULL,
    `featured_image_alt` VARCHAR(255) DEFAULT NULL,
    `category_id` INT UNSIGNED DEFAULT NULL,
    `author_id` INT UNSIGNED NOT NULL,
    `status` ENUM('draft', 'published', 'scheduled') NOT NULL DEFAULT 'draft',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `reading_time` INT UNSIGNED NOT NULL DEFAULT 5,
    `published_at` DATETIME DEFAULT NULL,
    `scheduled_for` DATETIME DEFAULT NULL,
    `markdown_file_path` VARCHAR(255) DEFAULT NULL,
    `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `meta_title` VARCHAR(191) DEFAULT NULL,
    `meta_description` VARCHAR(255) DEFAULT NULL,
    `canonical_url` VARCHAR(255) DEFAULT NULL,
    `og_image` VARCHAR(255) DEFAULT NULL,
    `robots_directive` VARCHAR(50) NOT NULL DEFAULT 'index, follow',
    `schema_type` VARCHAR(50) NOT NULL DEFAULT 'BlogPosting',
    `created_by` INT UNSIGNED DEFAULT NULL,
    `updated_by` INT UNSIGNED DEFAULT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_blog_slug` (`slug`),
    INDEX `idx_blog_status` (`status`),
    INDEX `idx_blog_published` (`published_at`),
    INDEX `idx_blog_featured` (`is_featured`),
    INDEX `idx_blog_deleted` (`deleted_at`),
    CONSTRAINT `fk_blogs_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_blogs_author` FOREIGN KEY (`author_id`) REFERENCES `blog_authors` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_blogs_creator` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_blogs_updater` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 9. BLOG TAG RELATIONS TABLE (Pivot)
-- ----------------------------------------------------------------------------
CREATE TABLE `blog_tag_relations` (
    `blog_id` INT UNSIGNED NOT NULL,
    `tag_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`blog_id`, `tag_id`),
    CONSTRAINT `fk_btr_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_btr_tag` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 10. BLOG REVISIONS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `blog_revisions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `blog_id` INT UNSIGNED NOT NULL,
    `admin_id` INT UNSIGNED DEFAULT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NOT NULL,
    `excerpt` TEXT DEFAULT NULL,
    `change_summary` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_rev_blog` (`blog_id`),
    CONSTRAINT `fk_revisions_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_revisions_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 11. CONTACT LEADS TABLE (CRM)
-- ----------------------------------------------------------------------------
CREATE TABLE `contact_leads` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `company` VARCHAR(150) DEFAULT NULL,
    `service_interested` VARCHAR(100) DEFAULT NULL,
    `monthly_budget` VARCHAR(100) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('NEW', 'CONTACTED', 'QUALIFIED', 'PROPOSAL_SENT', 'CONVERTED', 'LOST') NOT NULL DEFAULT 'NEW',
    `lead_source` VARCHAR(100) NOT NULL DEFAULT 'Website Contact Form',
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `assigned_to` INT UNSIGNED DEFAULT NULL,
    `follow_up_date` DATE DEFAULT NULL,
    `is_spam` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_leads_status` (`status`),
    INDEX `idx_leads_email` (`email`),
    INDEX `idx_leads_created` (`created_at`),
    CONSTRAINT `fk_leads_assigned` FOREIGN KEY (`assigned_to`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 12. LEAD NOTES TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `lead_notes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `lead_id` INT UNSIGNED NOT NULL,
    `admin_id` INT UNSIGNED NOT NULL,
    `note` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_notes_lead` (`lead_id`),
    CONSTRAINT `fk_notes_lead` FOREIGN KEY (`lead_id`) REFERENCES `contact_leads` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_notes_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 13. LEAD ACTIVITIES TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `lead_activities` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `lead_id` INT UNSIGNED NOT NULL,
    `admin_id` INT UNSIGNED DEFAULT NULL,
    `activity_type` VARCHAR(50) NOT NULL,
    `description` TEXT NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_act_lead` (`lead_id`),
    CONSTRAINT `fk_act_lead` FOREIGN KEY (`lead_id`) REFERENCES `contact_leads` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_act_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 14. MEDIA LIBRARY TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `media_library` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `filename` VARCHAR(255) NOT NULL,
    `filepath` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_size` INT UNSIGNED NOT NULL,
    `width` INT UNSIGNED DEFAULT NULL,
    `height` INT UNSIGNED DEFAULT NULL,
    `alt_text` VARCHAR(255) DEFAULT NULL,
    `uploaded_by` INT UNSIGNED DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_media_filename` (`filename`),
    CONSTRAINT `fk_media_admin` FOREIGN KEY (`uploaded_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 15. SEO METADATA TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `seo_metadata` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page_route` VARCHAR(191) NOT NULL UNIQUE,
    `page_title` VARCHAR(191) NOT NULL,
    `meta_description` VARCHAR(255) NOT NULL,
    `canonical_url` VARCHAR(255) DEFAULT NULL,
    `og_title` VARCHAR(191) DEFAULT NULL,
    `og_description` VARCHAR(255) DEFAULT NULL,
    `og_image` VARCHAR(255) DEFAULT NULL,
    `twitter_card` VARCHAR(50) NOT NULL DEFAULT 'summary_large_image',
    `robots_directive` VARCHAR(50) NOT NULL DEFAULT 'index, follow',
    `schema_json` JSON DEFAULT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_seo_route` (`page_route`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 16. WEBSITE SETTINGS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `website_settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` LONGTEXT DEFAULT NULL,
    `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_settings_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- 17. SCHEDULED PUBLICATIONS TABLE
-- ----------------------------------------------------------------------------
CREATE TABLE `scheduled_publications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `blog_id` INT UNSIGNED NOT NULL,
    `publish_at` DATETIME NOT NULL,
    `executed_at` DATETIME DEFAULT NULL,
    `status` ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_sched_status` (`status`, `publish_at`),
    CONSTRAINT `fk_sched_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

