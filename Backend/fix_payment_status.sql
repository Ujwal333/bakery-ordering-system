-- Fix Payment Status ENUM
UPDATE `orders` SET `payment_status` = 'paid' WHERE `payment_status` = 'completed';

ALTER TABLE `orders` MODIFY COLUMN `payment_status` ENUM(
    'pending',
    'paid',
    'failed',
    'refunded'
) NOT NULL DEFAULT 'pending';
