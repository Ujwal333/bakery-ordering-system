-- Quick Fix for Order Status (with_logistic)
-- Run this query directly in phpMyAdmin

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
