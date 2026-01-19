-- Fix Users Table (Add status column if missing)
-- Note: Requires MySQL 5.7+ for IF NOT EXISTS on column add, otherwise this might error if column exists
-- Simpler approach: blindly try to add, if it fails it fails (but helpful message usually).
-- Better approach for raw SQL import:

SET FOREIGN_KEY_CHECKS=0;

-- 1. Ensure users table has necessary columns
ALTER TABLE `users` ADD COLUMN `status` ENUM('active', 'blocked') DEFAULT 'active';
ALTER TABLE `users` ADD COLUMN `phone` VARCHAR(255) NULL;
ALTER TABLE `users` ADD COLUMN `address` TEXT NULL;
ALTER TABLE `users` ADD COLUMN `profile_image` VARCHAR(255) DEFAULT 'default.jpg';
ALTER TABLE `users` ADD COLUMN `role` ENUM('customer', 'admin', 'superadmin') DEFAULT 'customer';
-- Ignore errors if columns exist

-- 2. Create Features Table
DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `benefits` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Create Help Contents Table
DROP TABLE IF EXISTS `help_contents`;
CREATE TABLE `help_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'faq',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Create Events Table (for About Page)
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` datetime NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Create Page Contents Table (For dynamic About Us text, etc)
DROP TABLE IF EXISTS `page_contents`;
CREATE TABLE `page_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, -- e.g. 'about_us'
  `section_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, -- e.g. 'hero', 'main_content'
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_section_unique` (`page_key`,`section_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- INSERT SAMPLE DATA --

-- Features
INSERT INTO `features` (`id`, `title`, `description`, `icon`, `image_path`, `benefits`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Easy Online Ordering', 'Browse our menu, customize your order, and checkout in minutes with our user-friendly interface.', 'fas fa-shopping-cart', NULL, '["Simple 3-step process","Save favorite items","Real-time availability"]', 1, 1, NOW(), NOW(), NULL),
(2, 'Live Order Tracking', 'Follow your order from our bakery to your doorstep in real-time with GPS tracking.', 'fas fa-map-marker-alt', NULL, '["Real-time GPS tracking","Arrival notifications","Driver contact info"]', 2, 1, NOW(), NOW(), NULL),
(3, 'Custom Cake Builder', 'Design your dream cake with our interactive customization tool and see it come to life.', 'fas fa-paint-brush', NULL, '["Real-time preview","Multiple flavor combinations","Instant pricing"]', 3, 1, NOW(), NOW(), NULL);

-- Help Content
INSERT INTO `help_contents` (`id`, `type`, `title`, `content`, `icon`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'help_card', 'Ordering', 'Learn how to place orders, use coupons, and customize your treats.', 'fas fa-shopping-basket', 'ordering', 1, 1, NOW(), NOW(), NULL),
(2, 'help_card', 'Delivery', 'Tracking, delivery times, and coverage areas in Kathmandu Valley.', 'fas fa-truck', 'delivery', 2, 1, NOW(), NOW(), NULL),
(3, 'faq', 'What are your opening hours?', 'We are open from 8:00 AM to 8:00 PM every day, including public holidays. Online orders can be placed 24/7.', NULL, NULL, 1, 1, NOW(), NOW(), NULL),
(4, 'faq', 'Do you deliver outside Kathmandu?', 'Currently, we only deliver within the Kathmandu Valley (Kathmandu, Lalitpur, and Bhaktapur) to ensure the freshness of our baked goods.', NULL, NULL, 2, 1, NOW(), NOW(), NULL);

-- Page Contents (About Us default)
INSERT INTO `page_contents` (`page_key`, `section_key`, `title`, `content`, `image_path`, `created_at`, `updated_at`) VALUES
('about', 'hero', 'About Us', 'Crafting sweet moments since 2022', NULL, NOW(), NOW()),
('about', 'intro', 'Our Story', 'Welcome to Cinnamon Bakery! Established in 2022, we\'ve been crafting delicious treats with love and the finest ingredients.', NULL, NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;
