-- DB Fix for Order Handover and Logistics
SET FOREIGN_KEY_CHECKS=0;

-- 1. Create logistic_partners table if it doesn't exist
CREATE TABLE IF NOT EXISTS `logistic_partners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Update orders table structure
-- Add logistic_partner_id if missing
SET @row_count = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = 'logistic_partner_id');
SET @sql = IF(@row_count = 0, 'ALTER TABLE `orders` ADD COLUMN `logistic_partner_id` bigint(20) UNSIGNED DEFAULT NULL', 'SELECT "Column logistic_partner_id already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add handed_over_at if missing
SET @row_count = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = 'handed_over_at');
SET @sql = IF(@row_count = 0, 'ALTER TABLE `orders` ADD COLUMN `handed_over_at` timestamp NULL DEFAULT NULL', 'SELECT "Column handed_over_at already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Update status ENUM to include 'with_logistic'
-- Note: Enum updates are tricky to check safely in one script, so we modify it directly if needed.
-- It's safe to run this multiple times if the list of options is the same.
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending',
    'confirmed',
    'preparing',
    'ready',
    'out_for_delivery',
    'with_logistic',
    'delivered',
    'cancelled'
) DEFAULT 'pending';

-- 3. Add Foreign Key if it doesn't exist
SET @row_count = (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND CONSTRAINT_NAME = 'orders_logistic_partner_id_foreign');
SET @sql = IF(@row_count = 0, 'ALTER TABLE `orders` ADD CONSTRAINT `orders_logistic_partner_id_foreign` FOREIGN KEY (`logistic_partner_id`) REFERENCES `logistic_partners` (`id`) ON DELETE SET NULL', 'SELECT "Foreign key already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 4. Additional Dine-In Support structure check (if missing)
SET @row_count = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = 'table_number');
SET @sql = IF(@row_count = 0, 'ALTER TABLE `orders` ADD COLUMN `table_number` int(11) DEFAULT NULL AFTER `delivery_type`', 'SELECT "Column table_number already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @row_count = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND COLUMN_NAME = 'order_source');
SET @sql = IF(@row_count = 0, 'ALTER TABLE `orders` ADD COLUMN `order_source` enum("web","walk-in","phone") DEFAULT "web" AFTER `table_number`', 'SELECT "Column order_source already exists"');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS `table_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_number` int(11) NOT NULL,
  `status` enum('available','occupied','reserved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `current_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occupied_at` timestamp NULL DEFAULT NULL,
  `available_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_reservations_table_number_index` (`table_number`),
  KEY `table_reservations_status_index` (`status`),
  KEY `table_reservations_current_order_id_foreign` (`current_order_id`),
  CONSTRAINT `table_reservations_current_order_id_foreign` FOREIGN KEY (`current_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
