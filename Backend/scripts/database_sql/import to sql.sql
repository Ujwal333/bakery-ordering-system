-- Database changes for Flexible Registration & Forgot Password System
-- Run these queries to update your MySQL/MariaDB database

-- 1. Make email nullable to allow phone-only registration
ALTER TABLE users MODIFY email VARCHAR(255) NULL;

-- 2. Ensure OTP columns exist (if not already present via migrations)
-- These should already exist based on the latest codebase but provided here for manual sync
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS otp_code VARCHAR(10) NULL AFTER password;
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS otp_expires_at TIMESTAMP NULL AFTER otp_code;

-- 3. Logistic Partners and Order Handover Fix
SET FOREIGN_KEY_CHECKS=0;

-- Create logistic_partners table
CREATE TABLE IF NOT EXISTS `logistic_partners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add missing columns to orders table safely
ALTER TABLE `orders` ADD COLUMN IF NOT EXISTS `logistic_partner_id` bigint(20) UNSIGNED DEFAULT NULL;
ALTER TABLE `orders` ADD COLUMN IF NOT EXISTS `handed_over_at` timestamp NULL DEFAULT NULL;

-- Update status ENUM to include everything needed
-- This fixes the "Data truncated" error by adding the missing 'with_logistic' status
-- Using ALTER with proper order
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM(
    'pending',
    'confirmed',
    'preparing',
    'ready',
    'with_logistic',
    'out_for_delivery',
    'delivered',
    'cancelled'
) NOT NULL DEFAULT 'pending';

-- Update payment_status ENUM to ensure consistency
UPDATE `orders` SET `payment_status` = 'paid' WHERE `payment_status` = 'completed';

ALTER TABLE `orders` MODIFY COLUMN `payment_status` ENUM(
    'pending',
    'paid',
    'failed',
    'refunded'
) NOT NULL DEFAULT 'pending';

-- Add foreign key constraint safely
-- We drop it first in case it's partially set up, then add it back
SET @sql = IF((SELECT 1 FROM information_schema.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND CONSTRAINT_NAME = 'orders_logistic_partner_id_foreign'), 'ALTER TABLE `orders` DROP FOREIGN KEY `orders_logistic_partner_id_foreign`','SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

ALTER TABLE `orders` 
ADD CONSTRAINT `orders_logistic_partner_id_foreign` 
FOREIGN KEY (`logistic_partner_id`) 
REFERENCES `logistic_partners` (`id`) 
ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS=1;


