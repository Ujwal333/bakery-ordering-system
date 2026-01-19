-- =============================================================
-- Bakery Ordering System Database
-- Import this file into phpMyAdmin
-- Database name: bakery_ordering_system
-- =============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `otp_code` VARCHAR(255) NULL DEFAULT NULL,
  `otp_expires_at` TIMESTAMP NULL DEFAULT NULL,
  `is_phone_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `phone` VARCHAR(255) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `profile_image` VARCHAR(255) DEFAULT 'https://randomuser.me/api/portraits/lego/1.jpg',
  `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: password_resets
-- --------------------------------------------------------
CREATE TABLE `password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: personal_access_tokens (for Sanctum)
-- --------------------------------------------------------
CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: failed_jobs
-- --------------------------------------------------------
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: categories
-- --------------------------------------------------------
CREATE TABLE `categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `image` VARCHAR(255) NULL DEFAULT NULL,
  `order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: products
-- --------------------------------------------------------
CREATE TABLE `products` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `discount_price` DECIMAL(10,2) NULL DEFAULT NULL,
  `size` VARCHAR(255) NULL DEFAULT NULL,
  `flavor` VARCHAR(255) NULL DEFAULT NULL,
  `serves` INT NULL DEFAULT NULL,
  `ingredients` TEXT NULL DEFAULT NULL,
  `allergens` TEXT NULL DEFAULT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `rating` INT NOT NULL DEFAULT 5,
  `stock` INT NOT NULL DEFAULT 100,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_popular` TINYINT(1) NOT NULL DEFAULT 0,
  `is_special` TINYINT(1) NOT NULL DEFAULT 0,
  `is_available` TINYINT(1) NOT NULL DEFAULT 1,
  `customization_options` JSON NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------
CREATE TABLE `orders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_phone` VARCHAR(255) NOT NULL,
  `delivery_address` TEXT NOT NULL,
  `delivery_city` VARCHAR(255) NOT NULL,
  `delivery_state` VARCHAR(255) NOT NULL,
  `delivery_zip` VARCHAR(255) NOT NULL,
  `delivery_type` ENUM('pickup', 'delivery') NOT NULL DEFAULT 'delivery',
  `delivery_date` DATETIME NOT NULL,
  `delivery_time` TIME NOT NULL,
  `order_date` DATETIME NULL DEFAULT NULL,
  `estimated_delivery` DATETIME NULL DEFAULT NULL,
  `special_instructions` TEXT NULL DEFAULT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `delivery_charge` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `tax` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('cod', 'card', 'khalti', 'esewa') NOT NULL DEFAULT 'cod',
  `payment_status` ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending',
  `status` ENUM('pending', 'confirmed', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
  `cancellation_reason` TEXT NULL DEFAULT NULL,
  `confirmed_at` DATETIME NULL DEFAULT NULL,
  `preparing_at` DATETIME NULL DEFAULT NULL,
  `ready_at` DATETIME NULL DEFAULT NULL,
  `out_for_delivery_at` DATETIME NULL DEFAULT NULL,
  `delivered_at` DATETIME NULL DEFAULT NULL,
  `cancelled_at` DATETIME NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: order_items
-- --------------------------------------------------------
CREATE TABLE `order_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `product_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `item_name` VARCHAR(255) NOT NULL,
  `customizations` JSON NULL DEFAULT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: carts
-- --------------------------------------------------------
CREATE TABLE `carts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `session_id` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: cart_items
-- --------------------------------------------------------
CREATE TABLE `cart_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` BIGINT UNSIGNED NOT NULL,
  `product_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `item_name` VARCHAR(255) NOT NULL,
  `customizations` JSON NULL DEFAULT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: custom_cakes
-- --------------------------------------------------------
CREATE TABLE `custom_cakes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `reference_number` VARCHAR(255) NOT NULL,
  `cake_name` VARCHAR(255) NULL DEFAULT NULL,
  `size` VARCHAR(255) NOT NULL,
  `size_price` DECIMAL(10,2) NOT NULL,
  `flavor` VARCHAR(255) NOT NULL,
  `flavor_price` DECIMAL(10,2) NOT NULL,
  `frosting` VARCHAR(255) NOT NULL,
  `frosting_price` DECIMAL(10,2) NOT NULL,
  `decorations` JSON NULL DEFAULT NULL,
  `decorations_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `custom_message` TEXT NULL DEFAULT NULL,
  `image_path` VARCHAR(255) NULL DEFAULT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected', 'cancelled') NOT NULL DEFAULT 'pending',
  `delivery_date` DATE NOT NULL,
  `delivery_time` TIME NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `custom_cakes_reference_number_unique` (`reference_number`),
  CONSTRAINT `custom_cakes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: order_tracking
-- --------------------------------------------------------
CREATE TABLE `order_tracking` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `location` VARCHAR(255) NULL DEFAULT NULL,
  `estimated_time` TIMESTAMP NULL DEFAULT NULL,
  `updated_by` BIGINT UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `order_tracking_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_tracking_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: events
-- --------------------------------------------------------
CREATE TABLE `events` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `event_date` DATE NOT NULL,
  `image_path` VARCHAR(255) NULL DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table: migrations (Laravel tracking)
-- --------------------------------------------------------
CREATE TABLE `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================
-- SAMPLE DATA
-- =============================================================

-- Admin User (password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@bakery.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
(2, 'Test Customer', 'customer@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NOW(), NOW());

-- Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cakes', 'cakes', 'Delicious handcrafted cakes for every occasion', 1, 1, NOW(), NOW()),
(2, 'Cupcakes', 'cupcakes', 'Perfectly portioned cupcakes with various flavors', 2, 1, NOW(), NOW()),
(3, 'Pastries', 'pastries', 'Fresh baked pastries and croissants', 3, 1, NOW(), NOW()),
(4, 'Breads', 'breads', 'Artisan breads baked daily', 4, 1, NOW(), NOW()),
(5, 'Cookies', 'cookies', 'Homemade cookies and biscuits', 5, 1, NOW(), NOW());

-- Products
INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `image_url`, `rating`, `stock`, `is_featured`, `is_popular`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 1, 'Chocolate Dream Cake', 'chocolate-dream-cake', 'Rich chocolate layers with ganache frosting', 1500.00, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400', 5, 50, 1, 1, 1, NOW(), NOW()),
(2, 1, 'Vanilla Celebration Cake', 'vanilla-celebration-cake', 'Classic vanilla cake with buttercream', 1200.00, 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=400', 5, 50, 1, 0, 1, NOW(), NOW()),
(3, 1, 'Red Velvet Cake', 'red-velvet-cake', 'Stunning red velvet with cream cheese frosting', 1400.00, 'https://images.unsplash.com/photo-1586788680434-30d324b2d46f?w=400', 5, 30, 0, 1, 1, NOW(), NOW()),
(4, 2, 'Chocolate Cupcakes', 'chocolate-cupcakes', 'Box of 6 chocolate cupcakes', 450.00, 'https://images.unsplash.com/photo-1576618148400-f54bed99fcfd?w=400', 5, 100, 1, 1, 1, NOW(), NOW()),
(5, 2, 'Vanilla Cupcakes', 'vanilla-cupcakes', 'Box of 6 vanilla cupcakes with sprinkles', 400.00, 'https://images.unsplash.com/photo-1519869325930-281384150729?w=400', 5, 100, 0, 1, 1, NOW(), NOW()),
(6, 3, 'Butter Croissant', 'butter-croissant', 'Flaky buttery French croissant', 150.00, 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400', 5, 200, 1, 1, 1, NOW(), NOW()),
(7, 3, 'Danish Pastry', 'danish-pastry', 'Sweet pastry with fruit filling', 180.00, 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?w=400', 4, 150, 0, 0, 1, NOW(), NOW()),
(8, 4, 'Sourdough Bread', 'sourdough-bread', 'Traditional sourdough loaf', 250.00, 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400', 5, 80, 1, 1, 1, NOW(), NOW()),
(9, 4, 'Whole Wheat Bread', 'whole-wheat-bread', 'Healthy whole wheat bread loaf', 200.00, 'https://images.unsplash.com/photo-1598373182133-52452f7691ef?w=400', 4, 100, 0, 0, 1, NOW(), NOW()),
(10, 5, 'Chocolate Chip Cookies', 'chocolate-chip-cookies', 'Box of 12 classic chocolate chip cookies', 350.00, 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400', 5, 150, 1, 1, 1, NOW(), NOW());

-- Migration records
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2019_08_19_000000_create_failed_jobs_table', 1),
('2019_12_14_000001_create_personal_access_tokens_table', 1),
('2024_01_01_000000_create_categories_table', 1),
('2024_01_01_000001_create_products_table', 1),
('2024_01_01_000002_create_orders_table', 1),
('2024_01_01_000003_create_order_items_table', 1),
('2024_01_01_000004_create_carts_table', 1),
('2026_01_05_180035_create_custom_cakes_table', 1),
('2026_01_05_180040_create_order_tracking_table', 1),
('2026_01_08_150241_add_otp_fields_to_users_table', 1),
('2026_01_08_154815_create_events_table', 1);

COMMIT;
