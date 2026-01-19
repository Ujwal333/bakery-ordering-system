-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bakery_ordering_system
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

CREATE DATABASE IF NOT EXISTS `bakery_ordering_system`;
USE `bakery_ordering_system`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin','staff') DEFAULT 'admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_status` (`status`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'System Admin','admin@bakery.com','superadmin','$2y$10$G0XJda3Y8lyT1SuM71bDA.Pp8mhq/JvoSlstpaOu4eqLZxj4zNiDe','superadmin','active',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 21:11:45'),(2,'Staff Admin','staff@bakery.com','staff','$2y$10$9UvAzLWGEzJzN3H5aG5QAuJHRLFvUKjVVJZuV5WK5pL4q/VrMIimy','admin','active',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Cinnamon Premium','cinnamon-premium',NULL,'Premium bakery collection',1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'Cinnamon Classic','cinnamon-classic',NULL,'Classic favorites',1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cake_options`
--

DROP TABLE IF EXISTS `cake_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cake_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('cake_type','size','flavor','frosting','decoration') NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `stock` int(10) unsigned DEFAULT 100,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cake_options`
--

LOCK TABLES `cake_options` WRITE;
/*!40000 ALTER TABLE `cake_options` DISABLE KEYS */;
INSERT INTO `cake_options` VALUES (1,'cake_type','Sponge Cake',0.00,100,'cake-options/YmzLH1HojfY2QR4CACSXqeYZkv0ERrclCC8zSY7T.jpg',1,'2026-01-18 08:07:22','2026-01-18 06:00:42'),(2,'cake_type','Cheese Cake',0.00,100,'cake-options/z15q5yTZpHLxfsTSyQpP93CaO4TzGAdww74cACFF.jpg',1,'2026-01-18 08:07:22','2026-01-18 03:51:29'),(3,'cake_type','Mud Cake',0.00,100,'cake-options/OU7E7tjy6llooFACME3A6T4ZfjVpRnsGD6OzK3RZ.jpg',1,'2026-01-18 08:07:22','2026-01-18 03:51:53'),(4,'cake_type','Butter Cake',0.00,100,'cake-options/4kplgIFMvm5AsqoGTzhP5QnKbzHFHNmczlTK3kTN.webp',1,'2026-01-18 08:07:22','2026-01-18 05:59:45'),(5,'cake_type','Vegan Cake',0.00,100,'cake-options/jmtHGnpmmqYOKn6yCFsGriIOmXmh34EtafmQRsTh.jpg',1,'2026-01-18 08:07:22','2026-01-18 03:52:22'),(6,'cake_type','Gluten Free',0.00,100,'cake-options/DiU3wWnZD2PkT49jKoFQa6VGn1aHsOynhYtv8Mjb.webp',1,'2026-01-18 08:07:22','2026-01-18 03:51:38'),(7,'size','8 inch (Serves 8-10)',900.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(8,'size','12 inch (Serves 20-25)',1500.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(9,'size','Tiered (Serves 30+)',2500.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(12,'flavor','Red Velvet',500.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(13,'flavor','Lemon Zest',300.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(14,'flavor','Strawberry Delight',300.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(15,'frosting','Vanilla Buttercream',200.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(16,'frosting','Cream Cheese Frosting',400.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(17,'frosting','Chocolate Ganache',300.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(18,'decoration','Fresh Berries',800.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(19,'decoration','Chocolate Drip',1200.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(20,'decoration','Gold Leaf Detail',1500.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(21,'decoration','Macarons (5pcs)',1000.00,100,NULL,1,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(22,'flavor','Classic Vanilla',300.00,100,NULL,1,'2026-01-18 06:24:10','2026-01-18 06:24:10'),(23,'flavor','Double Chocolate',100.00,18,NULL,1,'2026-01-18 06:26:41','2026-01-18 06:26:41'),(24,'cake_type','Custom',0.00,50,NULL,1,'2026-01-18 06:28:46','2026-01-18 06:46:14'),(25,'size','4 inch (Serves 4-6)',600.00,20,NULL,1,'2026-01-18 06:33:24','2026-01-18 06:40:16'),(27,'flavor','Custom',100.00,100,NULL,1,'2026-01-18 06:48:14','2026-01-18 06:51:06'),(28,'frosting','Custom',200.00,100,NULL,1,'2026-01-18 06:49:26','2026-01-18 06:51:34');
/*!40000 ALTER TABLE `cake_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `custom_cake_id` bigint(20) unsigned DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `customizations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customizations`)),
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_cake_id` (`custom_cake_id`),
  KEY `idx_cart_id` (`cart_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`custom_cake_id`) REFERENCES `custom_cakes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_session_id` (`session_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (50,4,NULL,'2026-01-18 03:59:31','2026-01-18 03:59:31'),(51,NULL,'wLcUkWXebBFuPsLhPUx6cOoEgUstsy23x29voHZj','2026-01-18 04:23:57','2026-01-18 04:23:57'),(52,5,NULL,'2026-01-18 04:27:54','2026-01-18 04:27:54'),(53,NULL,'Rak16olX2EdYbrBpWBBPZlGjcFk0mGOlYQkKahoc','2026-01-18 20:58:21','2026-01-18 20:58:21'),(54,14,NULL,'2026-01-18 21:15:21','2026-01-18 21:15:21'),(55,NULL,'fnbDpGmNaPNXzOwEmcgKD7KJIoWEgtPa08kU1zfZ','2026-01-18 21:15:34','2026-01-18 21:15:34'),(56,NULL,'aO2i4vcL1tqdtzJhwERRGTy42qpDyvcdnMcFgNTf','2026-01-18 21:18:08','2026-01-18 21:18:08'),(57,15,NULL,'2026-01-18 21:19:03','2026-01-18 21:19:03'),(58,NULL,'Hz9BobWpUlJD5NQoYChiDMx248mtJRWE49dkX5bA','2026-01-18 21:41:38','2026-01-18 21:41:38'),(59,NULL,'5L69psOipCDrDe2S7SMken7ncecxAuGbXDZDdmSH','2026-01-18 21:43:21','2026-01-18 21:43:21'),(60,16,NULL,'2026-01-18 21:54:16','2026-01-18 21:54:16'),(61,17,NULL,'2026-01-18 22:42:07','2026-01-18 22:42:07'),(62,18,NULL,'2026-01-18 22:44:56','2026-01-18 22:44:56'),(63,NULL,'iHiB7DP3oJDwWfLMXyxaxFnwtoeODEKMUjRAIBum','2026-01-18 22:46:48','2026-01-18 22:46:48'),(64,NULL,'0Mq0GMkNR8kSvAJngAd2EgQgqc9R56hbaIcYLzqq','2026-01-18 22:54:50','2026-01-18 22:54:50'),(65,NULL,'aZrISmAwWNBYxrCK0TAUnYDAM7mNXBxjYvPwkVT2','2026-01-18 22:58:33','2026-01-18 22:58:33'),(66,19,NULL,'2026-01-18 23:41:34','2026-01-18 23:41:34'),(67,NULL,'fD5tOTzhrE1uL7myvxW0NFbR0jwPLbm57tb7kdeh','2026-01-18 23:51:17','2026-01-18 23:51:17');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_order` (`order`),
  KEY `idx_deleted_at` (`deleted_at`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Cakes','cakes','Delicious freshly baked cakes','categories/cakes.jpg',NULL,1,1,NULL,'2026-01-18 08:07:22','2026-01-18 22:59:30'),(2,NULL,'Cupcakes','cupcakes','Individual-sized cupcakes','categories/cupcakes.jpg',NULL,2,0,NULL,'2026-01-18 08:07:22','2026-01-19 00:47:08'),(3,NULL,'Cookies','cookies','Homemade cookies in various flavors','categories/cookies.jpg',NULL,3,0,NULL,'2026-01-18 08:07:22','2026-01-19 00:47:14'),(4,NULL,'Pastries','pastries','Flaky and delicious pastries','categories/pastries.jpg',NULL,4,0,NULL,'2026-01-18 08:07:22','2026-01-19 00:21:24'),(5,NULL,'Breads','breads','Fresh artisan breads','categories/breads.jpg',NULL,5,1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(6,1,'Birthday Cakes','birthday-cakes','Special cakes for birthday celebrations','categories/birthday-cakes.jpg',NULL,6,1,NULL,'2026-01-18 08:07:22','2026-01-19 00:18:20'),(7,1,'Wedding Cakes','wedding-cakes','Elegant multi-tier wedding cakes','categories/wedding-cakes.jpg',NULL,7,1,NULL,'2026-01-18 08:07:22','2026-01-19 00:18:20'),(8,1,'Anniversary Cakes','anniversary-cakes','Romantic cakes for anniversaries','categories/anniversary-cakes.jpg',NULL,8,1,NULL,'2026-01-18 08:07:22','2026-01-19 00:18:20'),(10,NULL,'Cupcakes & Muffins','cupcakes-muffins',NULL,NULL,NULL,0,1,NULL,'2026-01-19 00:17:19','2026-01-19 00:17:19'),(11,NULL,'Cookies & Brownies','cookies-brownies',NULL,NULL,NULL,0,1,NULL,'2026-01-19 00:17:19','2026-01-19 00:17:19'),(12,NULL,'Pastries & Sweet Treats','pastries-sweet-treats',NULL,NULL,NULL,0,1,NULL,'2026-01-19 00:17:19','2026-01-19 00:17:19'),(13,NULL,'Mini Cakes','mini-cakes',NULL,NULL,NULL,0,1,NULL,'2026-01-19 00:17:19','2026-01-19 00:17:19'),(14,NULL,'Eggless & Vegan','eggless-vegan',NULL,NULL,NULL,0,1,NULL,'2026-01-19 00:17:19','2026-01-19 00:17:19');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_queries`
--

DROP TABLE IF EXISTS `contact_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_queries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` enum('unread','read','responded') DEFAULT 'unread',
  `admin_note` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_queries`
--

LOCK TABLES `contact_queries` WRITE;
/*!40000 ALTER TABLE `contact_queries` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_queries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_cakes`
--

DROP TABLE IF EXISTS `custom_cakes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_cakes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `reference_number` varchar(50) NOT NULL,
  `cake_name` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `size_price` decimal(10,2) DEFAULT NULL,
  `flavor` varchar(100) DEFAULT NULL,
  `flavor_price` decimal(10,2) DEFAULT NULL,
  `frosting` varchar(100) DEFAULT NULL,
  `frosting_price` decimal(10,2) DEFAULT NULL,
  `decorations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`decorations`)),
  `decorations_price` decimal(10,2) DEFAULT NULL,
  `custom_message` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed','delivered') DEFAULT 'pending',
  `delivery_date` date DEFAULT NULL,
  `delivery_time` varchar(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_number` (`reference_number`),
  KEY `idx_reference_number` (`reference_number`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_delivery_date` (`delivery_date`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_cakes`
--

LOCK TABLES `custom_cakes` WRITE;
/*!40000 ALTER TABLE `custom_cakes` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_cakes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `delivery_boy_id` bigint(20) unsigned DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` enum('pending','assigned','out_for_delivery','delivered') DEFAULT 'pending',
  `estimated_delivery_time` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_delivery_boy_id` (`delivery_boy_id`),
  KEY `idx_status` (`status`),
  KEY `idx_deleted_at` (`deleted_at`),
  CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`delivery_boy_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_locations`
--

DROP TABLE IF EXISTS `delivery_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `delivery_id` bigint(20) unsigned NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `speed` decimal(8,2) DEFAULT NULL,
  `heading` decimal(6,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_delivery_id` (`delivery_id`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `delivery_locations_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_locations`
--

LOCK TABLES `delivery_locations` WRITE;
/*!40000 ALTER TABLE `delivery_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_event_date` (`event_date`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `idx_uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'Easy Online Ordering','Browse our menu, customize your order, and checkout in minutes.','fas fa-shopping-cart',NULL,'[\"Simple 3-step process\",\"Save favorite items\",\"Real-time availability\"]',1,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL),(2,'Live Order Tracking','Follow your order from our bakery to your doorstep in real-time.','fas fa-map-marker-alt',NULL,'[\"Real-time GPS tracking\",\"Arrival notifications\",\"Driver contact info\"]',2,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL),(3,'Custom Cake Builder','Design your dream cake with our interactive customization tool.','fas fa-paint-brush',NULL,'[\"Real-time preview\",\"Multiple flavor combinations\",\"Instant pricing\"]',3,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL);
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`category`),
  KEY `idx_is_featured` (`is_featured`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,'Chocolate Delight Cake','Rich chocolate cake with ganache frosting','gallery/chocolate-cake-1.jpg','Cakes',1,1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'Wedding Cake Special','Elegant 3-tier wedding cake','gallery/wedding-cake.jpg','Cakes',1,2,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,'Assorted Cupcakes','Colorful cupcakes with various flavors','gallery/cupcakes-assorted.jpg','Cupcakes',1,3,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,'Fresh Croissants','Buttery French croissants','gallery/croissants.jpg','Pastries',0,4,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(5,'Birthday Cake Collection','Custom birthday cakes showcase','gallery/birthday-cakes.jpg','Cakes',1,5,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help_contents`
--

DROP TABLE IF EXISTS `help_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `help_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT 'faq',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help_contents`
--

LOCK TABLES `help_contents` WRITE;
/*!40000 ALTER TABLE `help_contents` DISABLE KEYS */;
INSERT INTO `help_contents` VALUES (1,'help_card','Ordering','Learn how to place orders, use coupons, and customize.','fas fa-shopping-basket','ordering',1,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL),(2,'help_card','Delivery','Tracking, delivery times, and coverage areas.','fas fa-truck','delivery',2,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL),(3,'faq','What are your opening hours?','We are open from 8:00 AM to 8:00 PM every day.',NULL,NULL,1,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL),(4,'faq','Do you deliver outside Kathmandu?','Only within Kathmandu Valley currently.',NULL,NULL,2,1,'2026-01-18 08:21:11','2026-01-18 08:21:11',NULL);
/*!40000 ALTER TABLE `help_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_applications`
--

DROP TABLE IF EXISTS `job_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_applications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` bigint(20) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_applications_job_id_foreign` (`job_id`),
  CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_applications`
--

LOCK TABLES `job_applications` WRITE;
/*!40000 ALTER TABLE `job_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL DEFAULT 'Kathmandu, Nepal',
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `salary_range` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'chef','Vacancy','kichen','Kathmandu, Nepal','cook','bhm',NULL,1,'2026-01-31','2026-01-19 00:43:57','2026-01-19 00:43:57',NULL);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logistic_partners`
--

DROP TABLE IF EXISTS `logistic_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logistic_partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logistic_partners`
--

LOCK TABLES `logistic_partners` WRITE;
/*!40000 ALTER TABLE `logistic_partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `logistic_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_01_19_000000_add_google_oauth_to_users',1),(2,'2026_01_19_100000_add_dine_in_support',2),(3,'2026_01_19_110000_update_delivery_type_enum',3),(4,'2026_01_19_120000_create_jobs_table',4),(5,'2026_01_19_081708_create_logistic_partners_table',5),(6,'2026_01_19_081738_add_logistic_partner_id_to_orders_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_notifiable` (`notifiable_type`,`notifiable_id`),
  KEY `idx_read_at` (`read_at`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `custom_cake_id` bigint(20) unsigned DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `customizations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customizations`)),
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_cake_id` (`custom_cake_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`custom_cake_id`) REFERENCES `custom_cakes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,NULL,'Chocolate Cake',NULL,1,700.00,700.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,1,4,NULL,'Chocolate Cupcake',NULL,2,120.00,240.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,1,6,NULL,'Chocolate Chip Cookie',NULL,1,80.00,80.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,2,2,NULL,'Vanilla Cake',NULL,1,700.00,700.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(5,3,3,NULL,'Strawberry Cake',NULL,2,800.00,1600.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(6,3,8,NULL,'Croissant',NULL,5,120.00,600.00,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(7,4,1,NULL,'Chocolate Cake',NULL,10,800.00,8000.00,NULL,'2026-01-18 04:18:09','2026-01-18 04:18:09'),(8,5,NULL,NULL,'Custom Cake - default Double Chocolate','{\"cake_type\":\"default\",\"size\":\"default\",\"size_price\":\"0\",\"flavor\":\"Double Chocolate\",\"flavor_price\":\"100\",\"frosting\":\"Vanilla Buttercream\",\"frosting_price\":\"200\",\"decorations\":[],\"custom_message\":null,\"reference_image\":null}',1,300.00,300.00,NULL,'2026-01-18 07:03:49','2026-01-18 07:03:49'),(9,5,NULL,NULL,'Custom Cake - 4 inch (Serves 4-6) Custom','{\"cake_type\":\"Sponge Cake\",\"size\":\"4 inch (Serves 4-6)\",\"size_price\":\"600\",\"flavor\":\"Custom\",\"flavor_price\":\"100\",\"frosting\":\"Custom\",\"frosting_price\":\"200\",\"decorations\":[],\"custom_message\":null,\"reference_image\":null}',1,900.00,900.00,NULL,'2026-01-18 07:03:49','2026-01-18 07:03:49'),(10,6,4,NULL,'Chocolate Cupcake',NULL,1,150.00,150.00,NULL,'2026-01-18 22:46:11','2026-01-18 22:46:11'),(11,7,2,NULL,'Vanilla Cake',NULL,1,700.00,700.00,NULL,'2026-01-19 00:41:26','2026-01-19 00:41:26'),(12,7,11,NULL,'Happy Birthday Cake',NULL,1,1200.00,1200.00,NULL,'2026-01-19 00:41:26','2026-01-19 00:41:26'),(13,7,1,NULL,'Chocolate Cake',NULL,1,900.00,900.00,NULL,'2026-01-19 00:41:26','2026-01-19 00:41:26'),(14,7,3,NULL,'Strawberry Cake',NULL,1,850.00,850.00,NULL,'2026-01-19 00:41:26','2026-01-19 00:41:26'),(15,8,11,NULL,'Happy Birthday Cake',NULL,1,1200.00,1200.00,NULL,'2026-01-19 00:57:50','2026-01-19 00:57:50'),(16,9,1,NULL,'Chocolate Cake',NULL,2,900.00,1800.00,NULL,'2026-01-19 02:24:25','2026-01-19 02:24:25'),(17,9,2,NULL,'Vanilla Cake',NULL,1,750.00,750.00,NULL,'2026-01-19 02:24:25','2026-01-19 02:24:25'),(18,10,2,NULL,'Vanilla Cake',NULL,1,750.00,750.00,NULL,'2026-01-19 02:30:18','2026-01-19 02:30:18');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_tracking`
--

DROP TABLE IF EXISTS `order_tracking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_tracking` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `estimated_time` datetime DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_tracking_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_tracking`
--

LOCK TABLES `order_tracking` WRITE;
/*!40000 ALTER TABLE `order_tracking` DISABLE KEYS */;
INSERT INTO `order_tracking` VALUES (1,1,'pending','Order placed successfully',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,2,'confirmed','Order confirmed by admin',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,2,'preparing','Order is being prepared',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,3,'confirmed','Order confirmed by admin',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(5,3,'preparing','Order is being prepared in our kitchen',NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22');
/*!40000 ALTER TABLE `order_tracking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_province` varchar(100) DEFAULT NULL,
  `delivery_district` varchar(100) DEFAULT NULL,
  `delivery_city` varchar(100) DEFAULT NULL,
  `delivery_area` varchar(100) DEFAULT NULL,
  `delivery_street` varchar(255) DEFAULT NULL,
  `delivery_state` varchar(100) DEFAULT NULL,
  `delivery_zip` varchar(20) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `delivery_type` enum('pickup','delivery','dine-in') DEFAULT 'delivery',
  `table_number` int(11) DEFAULT NULL,
  `order_source` enum('web','walk-in','phone') NOT NULL DEFAULT 'web',
  `delivery_date` date DEFAULT NULL,
  `delivery_time` varchar(20) DEFAULT NULL,
  `delivery_window` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `estimated_delivery` datetime DEFAULT NULL,
  `special_instructions` text DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `delivery_charge` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `status` enum('pending','confirmed','preparing','ready','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
  `cancellation_reason` text DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `preparing_at` timestamp NULL DEFAULT NULL,
  `ready_at` timestamp NULL DEFAULT NULL,
  `out_for_delivery_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logistic_partner_id` bigint(20) unsigned DEFAULT NULL,
  `handed_over_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `idx_order_number` (`order_number`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_customer_email` (`customer_email`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_deleted_at` (`deleted_at`),
  KEY `orders_logistic_partner_id_foreign` (`logistic_partner_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_logistic_partner_id_foreign` FOREIGN KEY (`logistic_partner_id`) REFERENCES `logistic_partners` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'CB-00001',1,'Demo Customer','customer@bakery.com','9800000001','Kathmandu, Nepal',NULL,NULL,'Kathmandu',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,'web','2026-01-11',NULL,NULL,'2026-01-18 08:07:22',NULL,NULL,1000.00,100.00,143.00,1243.00,'cod','completed','cancelled',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 03:55:54',NULL,NULL),(2,'CB-00002',NULL,'John Doe','john@bakery.com','9800000002','Patan, Nepal',NULL,NULL,'Patan',NULL,NULL,NULL,NULL,NULL,NULL,'pickup',NULL,'web','2026-01-11',NULL,NULL,'2026-01-18 08:07:22',NULL,NULL,500.00,0.00,65.00,565.00,'card','completed','cancelled',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 07:07:36',NULL,NULL),(3,'CB-00003',NULL,'Jane Smith','jane@bakery.com','9800000003','Bhaktapur, Nepal',NULL,NULL,'Bhaktapur',NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,'web','2026-01-12',NULL,NULL,'2026-01-18 08:07:22',NULL,NULL,2000.00,100.00,273.00,2373.00,'khalti','completed','cancelled',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 04:22:10',NULL,NULL),(4,'CB-20260118-83FD42',4,'Ujwal','Ujwal@gmail.com','9769349551','kathmandu, Kathmandu, Kathmandu, Bagmati','Bagmati','Kathmandu','Kathmandu','','kathmandu','','',NULL,NULL,'delivery',NULL,'web','2026-01-18','10:00:00','10:00:00',NULL,NULL,'App Checkout',8000.00,60.00,0.00,8060.00,'cod','pending','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 04:18:09','2026-01-18 04:18:09',NULL,NULL),(5,'CB-20260118-EB7465',5,'Hari','Hari@gmail.com','9769349551','kathmandu, Kathmandu, Kathmandu, Bagmati','Bagmati','Kathmandu','Kathmandu','','kathmandu','','',NULL,NULL,'delivery',NULL,'web','2026-01-19','10:00:00','10:00:00',NULL,NULL,'App Checkout',1200.00,60.00,0.00,1260.00,'cod','pending','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 07:03:49','2026-01-18 07:03:49',NULL,NULL),(6,'CB-20260119-B0CB0B',18,'hari','Hari1@gmail.com','9769349551','kathmandu, Kathmandu, Kathmandu, Bagmati','Bagmati','Kathmandu','Kathmandu','','kathmandu','','',NULL,NULL,'delivery',NULL,'web','2026-01-20','10:00:00','10:00:00',NULL,NULL,'App Checkout',150.00,50.00,0.00,200.00,'esewa','completed','preparing',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-18 22:46:11','2026-01-18 23:33:36',NULL,NULL),(7,'CB-20260119-45C4B6',19,'Gopal','gopal@gmail.com','9769349551','','Bagmati','Kathmandu','','','','','',NULL,NULL,'dine-in',2,'web','2026-01-20','10:00:00','10:00:00',NULL,NULL,'App Checkout',3650.00,0.00,0.00,3650.00,'cod','pending','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-19 00:41:26','2026-01-19 00:41:26',NULL,NULL),(8,'CB-20260119-328630',19,'Gopal','gopal@gmail.com','9769349551','','Bagmati','Kathmandu','','','','','',NULL,NULL,'dine-in',3,'web','2026-01-20','10:00:00','10:00:00',NULL,NULL,'fasfsda',1200.00,0.00,0.00,1200.00,'cod','pending','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-19 00:57:50','2026-01-19 00:57:50',NULL,NULL),(9,'CB-20260119-BD35D1',19,'Gopal','gopal@gmail.com','9769349551','','Bagmati','Kathmandu','','','kathmandu','','',NULL,NULL,'dine-in',4,'web','2026-01-20','10:00:00','10:00:00',NULL,NULL,'App Checkout',2550.00,0.00,0.00,2550.00,'cod','pending','pending',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-19 02:24:25','2026-01-19 02:24:25',NULL,NULL),(10,'CB-20260119-4D2D30',19,'Gopal','gopal@gmail.com','9769349551','kathmandu, Kathmandu, Kathmandu, Bagmati','Bagmati','Kathmandu','Kathmandu','','kathmandu','','',NULL,NULL,'delivery',NULL,'web','2026-01-19','13:00:00','13:00:00',NULL,NULL,'App Checkout',750.00,60.00,0.00,810.00,'cod','pending','cancelled',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-01-19 02:30:18','2026-01-19 02:31:18',NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_contents`
--

DROP TABLE IF EXISTS `page_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_key` varchar(255) NOT NULL,
  `section_key` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_section_unique` (`page_key`,`section_key`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_contents`
--

LOCK TABLES `page_contents` WRITE;
/*!40000 ALTER TABLE `page_contents` DISABLE KEYS */;
INSERT INTO `page_contents` VALUES (1,'about','hero','About Us',NULL,NULL,'2026-01-18 08:21:11','2026-01-18 08:21:11'),(2,'about','main','About Cinnamon Bakery','Welcome to Cinnamon Bakery! Established in 2022, we\'ve been crafting delicious treats with love.',NULL,'2026-01-18 08:21:11','2026-01-18 08:21:11'),(3,'about','quote','Our Mission','Sweet moments for everyone.',NULL,'2026-01-18 08:21:11','2026-01-18 08:21:11'),(4,'home','hero','Artisan Bakery Crafted with Love','Discover our handcrafted pastries, cakes, and breads made with premium ingredients',NULL,'2026-01-18 08:41:34','2026-01-18 08:41:34'),(5,'features','intro','Our Sweet Features','Discover all the ways we make your experience with Cinnamon Bakery delightful, convenient, and memorable.',NULL,'2026-01-18 08:41:34','2026-01-18 08:41:34'),(6,'features','gallery','Cinnamon Gallery','Explore our collection of signature creations and customer favorites.',NULL,'2026-01-18 08:41:34','2026-01-18 08:41:34');
/*!40000 ALTER TABLE `page_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'About Us','about-us','<p>Cinnamon Bakery is dedicated to providing the finest baked goods in Kathmandu.</p>','About Cinnamon Bakery','Learn about Cinnamon Bakery',1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'Privacy Policy','privacy-policy','<p>Your privacy is important to us...</p>','Privacy Policy','Read our privacy policy',1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,'Terms & Conditions','terms-conditions','<p>By using our website, you agree to our terms...</p>','Terms & Conditions','Read our terms and conditions',1,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`),
  KEY `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `requires_verification` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `extra_charge` decimal(10,2) DEFAULT 0.00,
  `extra_charge_type` varchar(50) DEFAULT 'fixed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `idx_code` (`code`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Cash on Delivery','cod','Cash on Delivery','Pay with cash when your order is delivered',NULL,NULL,NULL,NULL,NULL,1,0,1,10.00,'fixed','2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'eSewa','esewa','eSewa Payment','Pay securely using eSewa digital wallet','payment-logos/Qj8BA0IRBjPYy8rf9O5flkQxqtHTzOobjeeWir1A.png','payment-qr-codes/Jw7IM9EW6QRbGm16uBewECypCGCJy7fJvJY74xoL.jpg',NULL,NULL,NULL,1,1,2,0.00,'fixed','2026-01-18 08:07:22','2026-01-18 07:00:02'),(3,'Khalti','khalti','Khalti Payment','Pay securely using Khalti digital wallet','payment-logos/YWcQwGwBgHdrllHOdTvZax1eq1RNYXjtMgm31mcO.png','payment-qr-codes/fxGI8S37657kZNtxccC1De4K39r49H564JHK9tNL.jpg',NULL,NULL,NULL,1,1,3,0.00,'fixed','2026-01-18 08:07:22','2026-01-18 07:01:05');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','processing','completed','failed','refunded') DEFAULT 'pending',
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_provider` (`provider`),
  KEY `idx_transaction_id` (`transaction_id`),
  KEY `idx_deleted_at` (`deleted_at`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,1,1243.00,'cod',NULL,'completed',NULL,NULL,'2026-01-18 08:07:22','2026-01-18 03:55:44'),(2,2,NULL,565.00,'card',NULL,'completed',NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,3,NULL,2373.00,'khalti',NULL,'completed',NULL,NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,6,18,200.00,'esewa','46646','completed','{\"sender_name\":\"5544\",\"sender_phone\":\"9769349551\",\"manual_entry\":true}',NULL,'2026-01-18 22:46:11','2026-01-18 23:33:20');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`abilities`)),
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `idx_tokenable` (`tokenable_type`,`tokenable_id`),
  KEY `idx_token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',17,'auth_token','a1983e78196f724512d4f451c5da1af75052d62090bdafefe0002e56aa55891b','[\"*\"]',NULL,NULL,'2026-01-18 22:42:02','2026-01-18 22:42:02'),(2,'App\\Models\\User',18,'auth_token','21a580c014294ab03dde5790afb86060766a53e5a41ed7366eb66ffd7d087a0e','[\"*\"]',NULL,NULL,'2026-01-18 22:44:55','2026-01-18 22:44:55'),(3,'App\\Models\\User',18,'auth_token','709d3402d8a999b25e94bc14ce26103c3088aaae31f3c6ee3f02aba2b35fef6a','[\"*\"]',NULL,NULL,'2026-01-18 22:47:11','2026-01-18 22:47:11'),(4,'App\\Models\\User',19,'auth_token','c52f3d475d0a170071706cfdd4f8297cf492aa7466614e4f91d2b3c7632f3812','[\"*\"]',NULL,NULL,'2026-01-18 23:41:33','2026-01-18 23:41:33');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `flavor` varchar(100) DEFAULT NULL,
  `serves` int(11) DEFAULT NULL,
  `ingredients` longtext DEFAULT NULL,
  `allergens` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `rating` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_popular` tinyint(1) DEFAULT 0,
  `is_special` tinyint(1) DEFAULT 0,
  `is_available` tinyint(1) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1,
  `customization_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customization_options`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_is_available` (`is_available`),
  KEY `idx_is_featured` (`is_featured`),
  KEY `idx_deleted_at` (`deleted_at`),
  FULLTEXT KEY `ft_name_description` (`name`,`description`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,NULL,'Chocolate Cake','chocolate-cake','Classic rich chocolate flavour, layered with cream.',900.00,899.00,'Medium','Chocolate',6,'Chocolate, Flour, Eggs, Butter',NULL,'products/ksjamTpx5BIWs6XRKl7Tv6lkg15QP19zgebzDNaP.jpg',NULL,5,10,0,1,0,1,1,'{\"sizes\":[\"Small (6 inch)\",\"Medium (8 inch)\",\"Large (10 inch)\"],\"flavors\":[\"Chocolate\",\"Vanilla\",\"Strawberry\"],\"toppings\":[\"Chocolate Ganache\",\"Buttercream\",\"Fondant\"]}',NULL,'2026-01-18 08:07:22','2026-01-19 02:30:18'),(2,1,NULL,'Vanilla Cake','vanilla-cake','Light and fluffy with vanilla cream.',750.00,699.00,'Medium','Vanilla',6,'Vanilla, Flour, Eggs, Butter',NULL,'products/uqqbI6Uo2J0jIUGC2fRXcpS1fPzleLBX3DSPdkU3.jpg',NULL,4,15,0,1,0,1,1,'{\"sizes\":[\"Small (6 inch)\",\"Medium (8 inch)\",\"Large (10 inch)\"],\"flavors\":[\"Vanilla\",\"Chocolate\",\"Red Velvet\"]}',NULL,'2026-01-18 08:07:22','2026-01-19 02:30:18'),(3,1,NULL,'Strawberry Cake','strawberry-cake','Fruity flavour with fresh fruit decoration.',850.00,799.00,'Large','Strawberry',8,'Strawberry, Flour, Eggs, Cream',NULL,'products/uzaQ4NcBe5VFqfgYkGdjdhNmU6yRcrtg1ROAvHIP.jpg',NULL,5,8,0,1,1,1,1,'{\"sizes\":[\"Medium (8 inch)\",\"Large (10 inch)\"],\"flavors\":[\"Strawberry\",\"Mixed Berry\"]}',NULL,'2026-01-18 08:07:22','2026-01-19 02:30:18'),(4,2,NULL,'Chocolate Cupcake','chocolate-cupcake','Delicious chocolate cupcake',150.00,120.00,'Single','Chocolate',1,'Chocolate, Flour',NULL,'products/rTUkUUOlUakiVhjPjBWvVmk5AkzLLphJOK0diSiS.jpg',NULL,4,50,1,1,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-19 02:30:18'),(5,2,NULL,'Vanilla Cupcake','vanilla-cupcake','Classic vanilla cupcake',140.00,NULL,'Single','Vanilla',1,'Vanilla, Flour',NULL,'products/oCgBHf8Nzb1E7zh1zt1uASlvjtP0w1EKmkurAlgv.jpg',NULL,4,50,1,0,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 03:34:13'),(6,3,NULL,'Chocolate Chip Cookie','chocolate-chip-cookie','Crispy cookie with chocolate chips',80.00,NULL,'Pack of 12','Chocolate',NULL,'Flour, Chocolate, Butter',NULL,'products/ckuC57BCHlOsBk15nLOHB600n5CtifxzvuRTMslu.jpg',NULL,4,100,1,0,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-19 00:41:26'),(7,3,NULL,'Oatmeal Cookie','oatmeal-cookie','Healthy oatmeal cookie',100.00,85.00,'Pack of 12','Oatmeal',NULL,'Oatmeal, Flour, Butter',NULL,'products/QNcqZVV5f4qJS5NIhufIwRSTX8sABYrlWNlDVmPM.jpg',NULL,4,80,0,0,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 03:34:45'),(8,4,NULL,'Croissant','croissant','Buttery French croissant',120.00,NULL,'Single','Plain',NULL,'Flour, Butter, Milk',NULL,'products/g2tHz6huMuTgPa4sTl71VFYW8HH4y7a7jUTIqcvY.jpg',NULL,5,60,1,1,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-19 02:30:18'),(9,5,NULL,'Sourdough Bread','sourdough-bread','Artisan sourdough loaf',300.00,250.00,'Loaf','Sourdough',NULL,'Flour, Salt, Yeast',NULL,'products/Uw4gAlcsDVrV4OovTcCbvVYzIrPf2weR6vzPlXhi.jpg',NULL,5,20,1,0,1,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-18 03:35:46'),(10,5,NULL,'Whole Wheat Bread','whole-wheat-bread','Healthier whole grain bread option.',220.00,99.00,'Loaf','Wheat',NULL,'Whole Wheat Flour, Salt',NULL,'products/cD3Bw3lVoAVd6XDXZVhZzoNu9jOqQDRnn2bITeTi.jpg',NULL,4,25,0,0,0,1,1,NULL,NULL,'2026-01-18 08:07:22','2026-01-19 01:55:25'),(11,6,NULL,'Happy Birthday Cake','happy-birthday-cake','Colorful birthday cake with candles and decorations',1200.00,1000.00,'Large','Vanilla',10,'Vanilla, Chocolate, Buttercream, Fondant',NULL,'products/npCTVkV6YbJV12mmKAFwnruqEvGT2rtUFKZgrVcF.jpg',NULL,5,15,1,0,1,1,1,'{\"sizes\":[\"Medium (8 inch)\",\"Large (10 inch)\",\"Extra Large (12 inch)\"],\"flavors\":[\"Vanilla\",\"Chocolate\",\"Red Velvet\",\"Funfetti\"],\"themes\":[\"Superhero\",\"Princess\",\"Sports\",\"Animals\",\"Cartoon Characters\"],\"toppings\":[\"Buttercream\",\"Fondant\",\"Chocolate Ganache\"]}',NULL,'2026-01-18 08:07:22','2026-01-19 00:41:26'),(12,6,NULL,'Kids Birthday Special','kids-birthday-special','Fun themed cake for children',1500.00,1300.00,'Large','Chocolate',12,'Chocolate, Vanilla, Fondant, Edible Decorations',NULL,'products/Ls4QcH3LdKTFk7jfXtIuPxXgu7BkkPYpbGllOytF.jpg',NULL,5,10,1,0,0,1,1,'{\"sizes\":[\"Medium (8 inch)\",\"Large (10 inch)\"],\"flavors\":[\"Chocolate\",\"Vanilla\",\"Strawberry\"],\"themes\":[\"Unicorn\",\"Dinosaur\",\"Space\",\"Under the Sea\"],\"customText\":true}',NULL,'2026-01-18 08:07:22','2026-01-19 01:19:44'),(13,7,NULL,'Classic Wedding Cake','classic-wedding-cake','Elegant 3-tier wedding cake',5000.00,4500.00,'3-Tier','Vanilla',50,'Vanilla, Chocolate, Buttercream, Fondant, Fresh Flowers',NULL,'products/xQDQocCVZGuUAYwNrKCebEYGC7huyZkKfdONZnCK.jpg',NULL,5,5,1,0,1,1,1,'{\"tiers\":[\"2-Tier\",\"3-Tier\",\"4-Tier\",\"5-Tier\"],\"flavors\":[\"Vanilla\",\"Chocolate\",\"Red Velvet\",\"Lemon\"],\"frosting\":[\"Buttercream\",\"Fondant\",\"Royal Icing\"],\"decorations\":[\"Fresh Flowers\",\"Sugar Flowers\",\"Gold Leaf\",\"Pearls\"]}',NULL,'2026-01-18 08:07:22','2026-01-19 00:41:26'),(14,7,NULL,'Modern Wedding Cake','modern-wedding-cake','Contemporary design wedding cake',6000.00,5500.00,'4-Tier','Red Velvet',75,'Red Velvet, Cream Cheese, Fondant, Edible Gold',NULL,'products/QdHmbJ3xcbsukjXQZMJiEdGYmRYObMQpJY4cc27J.jpg',NULL,5,3,1,0,1,1,1,'{\"tiers\":[\"3-Tier\",\"4-Tier\",\"5-Tier\"],\"flavors\":[\"Red Velvet\",\"Chocolate\",\"Vanilla\"],\"style\":[\"Minimalist\",\"Geometric\",\"Floral\",\"Rustic\"],\"customDesign\":true}',NULL,'2026-01-18 08:07:22','2026-01-18 03:38:04'),(15,8,NULL,'Anniversary Celebration Cake','anniversary-celebration-cake','Romantic cake for anniversaries',1800.00,1600.00,'Large','Red Velvet',15,'Red Velvet, Cream Cheese, Chocolate, Fondant',NULL,'products/jyCUSb76rqJcW8mvFZ0I3CaUZ0w57WTXxJqQIdAs.webp',NULL,5,12,1,0,0,1,1,'{\"sizes\":[\"Medium (8 inch)\",\"Large (10 inch)\"],\"flavors\":[\"Red Velvet\",\"Chocolate\",\"Vanilla\"],\"decorations\":[\"Hearts\",\"Roses\",\"Gold Accents\",\"Photo Print\"],\"customMessage\":true}',NULL,'2026-01-18 08:07:22','2026-01-19 00:41:26'),(16,8,NULL,'Golden Anniversary Special','golden-anniversary-special','Luxurious cake for milestone anniversaries',2500.00,2200.00,'Extra Large','Chocolate',20,'Chocolate, Vanilla, Gold Leaf, Premium Decorations',NULL,'products/iaExQ0SNL8FtJxuJmOBsbk5WG4Ein8loDNnxnASF.webp',NULL,5,8,1,0,1,1,1,'{\"sizes\":[\"Large (10 inch)\",\"Extra Large (12 inch)\"],\"flavors\":[\"Chocolate\",\"Vanilla\",\"Champagne\"],\"themes\":[\"Golden (50th)\",\"Silver (25th)\",\"Diamond (60th)\"],\"customDesign\":true}',NULL,'2026-01-18 08:07:22','2026-01-18 03:50:45'),(17,1,NULL,'Black Forest','black-forest','hjjbjb',11.00,NULL,NULL,NULL,NULL,NULL,NULL,'products/PWHscWuwSIADWDuJUF1bXKfOz0Nd59xWkovpNuvT.jpg','[]',0,0,0,0,0,1,1,NULL,'2026-01-18 23:31:16','2026-01-18 23:13:55','2026-01-18 23:31:16'),(18,1,NULL,'White Forest','white-forest','Light vanilla cream',600.00,NULL,NULL,NULL,NULL,NULL,NULL,'products/1CN0WdoR6XsboxlWGPIKVpp5AnmzPaaa34PyXd5Q.jpg','[]',0,0,0,0,0,1,1,NULL,'2026-01-19 00:45:06','2026-01-18 23:15:50','2026-01-19 00:45:06'),(19,1,NULL,'Red Velvet','red-velvet','Trendy & elegant',1500.00,600.00,NULL,NULL,NULL,NULL,NULL,'products/Z3EhJUsjAUsvIAMGZfVgG7mnQysQZwfR6XCS6sGY.jpg','[]',0,0,0,0,0,1,1,NULL,'2026-01-19 01:09:37','2026-01-18 23:28:06','2026-01-19 01:09:37'),(20,1,NULL,'Cheese Cake','cheese-cake','Premium option',2200.00,1599.97,NULL,NULL,NULL,NULL,NULL,'products/yi4hKLd96hIrNlFXShbw4ho5dY8UNdK6P4f0DJzA.jpg','[]',0,0,0,0,0,1,1,NULL,'2026-01-18 23:31:31','2026-01-18 23:29:44','2026-01-18 23:31:31'),(21,1,NULL,'Black Forest Cake','black-forest-cake','Chocolate sponge with cherry & cream.',800.00,799.00,NULL,NULL,NULL,NULL,NULL,'products/bSFmALUJfm5FCcGiSDN0NwGXU0hDRsIqbI6Uz1vx.webp',NULL,0,12,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:56:28'),(22,1,NULL,'White Forest Cake','white-forest-cake','Vanilla sponge with white chocolate flakes.',850.00,799.00,NULL,NULL,NULL,NULL,NULL,'products/xGGh0B1ABgAWozPU8EXR0j6TVtMPinpsuk1gYs94.jpg',NULL,0,5,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:56:50'),(23,1,NULL,'Blueberry Cake','blueberry-cake','Fruity flavour with fresh blueberry filling.',900.00,899.00,NULL,NULL,NULL,NULL,NULL,'products/5VAp7eSelblNkfaIYGVuuARWsPwrzQtpMqHIAPCP.jpg',NULL,0,5,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:57:05'),(24,1,NULL,'Red Velvet Cake','red-velvet-cake','Velvety texture, mild cocoa & cream cheese.',1200.00,1199.00,NULL,NULL,NULL,NULL,NULL,'products/185dTEfM2VD6AfalriPvXv59YDDxwUhgWiqKeUsq.jpg',NULL,0,5,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:57:19'),(25,1,NULL,'Blueberry Cheesecake','blueberry-cheesecake','Rich creamy base with blueberry topping.',2500.00,1999.00,NULL,NULL,NULL,NULL,NULL,'products/G6JSydnRaCeOLjeIekW1iYFXq7BfI7mN2OU29Era.jpg',NULL,0,2,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:57:35'),(26,1,NULL,'Classic Cheesecake','classic-cheesecake','Rich and smooth classic New York style cheesecake.',2300.00,2200.00,NULL,NULL,NULL,NULL,NULL,'products/MQHzUTXBI5tdnSJ4W7YNwwDY08actxdO5vZlwQRI.jpg',NULL,0,3,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:57:50'),(27,1,NULL,'Tiramisu Cake','tiramisu-cake','Coffee-flavoured cream layers with cocoa dusting.',1500.00,1499.00,NULL,NULL,NULL,NULL,NULL,'products/jVIw9Yd07NG3iepfCQWHEQvd3OVllfcGNpblwgMa.jpg',NULL,0,2,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:59:37'),(28,6,NULL,'Cartoon Theme Birthday Cake','cartoon-theme-birthday-cake','Customized cartoon character cakes for kids.',1500.00,1499.00,NULL,NULL,NULL,NULL,NULL,'products/GGuRQKP7WjyIPWGmrY5oLryy4xUT9yVLrntY1qVJ.webp','[\"products\\/gallery\\/wwWLG0MROJVzshV2nUT8wPMtRwWdR0KXoWhJqXUc.webp\"]',0,6,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:58:17'),(29,6,NULL,'Layered Cream Birthday Cake','layered-cream-birthday-cake','Elegant multi-layered cream cake with custom message.',1200.00,999.00,NULL,NULL,NULL,NULL,NULL,'products/H2khoXIKqQ8xO3RckMK4CnCVPAR8IZ0RW9UIdVbv.webp',NULL,0,4,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:58:56'),(30,7,NULL,'Multi-tier Wedding Cake','multi-tier-wedding-cake','Grand multi-tier designer fondant cake for weddings.',5000.00,3999.00,NULL,NULL,NULL,NULL,NULL,'products/BfQXcrVxGQLZqnVJ5ASqtb4WQeiL4YqouBgNR0ci.webp',NULL,0,1,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:58:42'),(31,7,NULL,'Elegant Pearl Wedding Cake','elegant-pearl-wedding-cake','Beautiful minimal design with edible pearls.',4500.00,3999.00,NULL,NULL,NULL,NULL,NULL,'products/g5IrRS3eg7AtGslEGEB8bqhDldx8bjhZKiSTCLnP.jpg',NULL,0,1,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:59:10'),(32,8,NULL,'Floral Anniversary Cake','floral-anniversary-cake','Elegant floral designs for your special day.',1450.00,1400.00,NULL,NULL,NULL,NULL,NULL,'products/IfsEICe24uu6JOH6OV8XPAFk5lInXz13g4FyAaje.webp',NULL,0,2,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:59:25'),(33,8,NULL,'Heart Shaped Anniversary Cake','heart-shaped-anniversary-cake','Romantic red heart design with custom names.',1400.00,1399.00,NULL,NULL,NULL,NULL,NULL,'products/96L4ml3xJd8WloLSTtzbXQsz6tE9x4uNDghA12WV.webp',NULL,0,3,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:59:55'),(34,10,NULL,'Classic Cupcakes Pack','classic-cupcakes-pack','Set of 4 small cakes with frosting; perfect for parties.',220.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/5PD9g6BTyorhoBdT1PnQRiVE6tjJWvFak0UDtjnR.webp',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:05'),(35,10,NULL,'Rainbow Cupcake','rainbow-cupcake','Decorative frosting with premium rainbow look.',230.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/JqzuwbwDvgOMqdj9YnmR2ZnoSsOwD2QW5cAeZYJh.webp',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:13'),(36,10,NULL,'Banana Muffin','banana-muffin','Soft, moist banana muffin for breakfast.',150.00,149.00,NULL,NULL,NULL,NULL,NULL,'products/Oc8lP4Mra1uUrgLwaKzOXRZ3Z0Je0CXZm0z9vlHS.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:22'),(37,10,NULL,'Chocolate Muffin','chocolate-muffin','Rich chocolate muffin with chocolate chips.',180.00,149.00,NULL,NULL,NULL,NULL,NULL,'products/tuSQjZejKf2OJtXCCimHqqha9oJtlC7EZYAsrIAq.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:31'),(38,10,NULL,'Red Velvet Muffin','red-velvet-muffin','Soft red velvet muffin with cream cheese center.',200.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/kqL0oGqMv4LaMNhlsix3xT4FPlXsIsJCkwr0PtTv.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:40'),(39,11,NULL,'Chocolate Chip Cookies Pack','chocolate-chip-cookies-pack','Classic crunchy & soft mix chocolate chip cookies.',215.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/jhdpMg1LT4D49piAHK5a8mLcMwov0NxFIpAtTU3G.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:50'),(40,11,NULL,'Butter Cookies Pack','butter-cookies-pack','Rich buttery melt-in-your-mouth cookies.',210.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/FM9X1fUY3sQ8V5JX18UdZKEoIduJbkskz8JptP7F.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:00:59'),(41,11,NULL,'Assorted Cookies Box','assorted-cookies-box','Mixed flavors including almond, oat, and more.',225.00,199.00,NULL,NULL,NULL,NULL,NULL,'products/dWSTE6G98VJoN8GNzzjj9qsoK7hqxpa6aX0PyrCn.webp',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:01:15'),(42,11,NULL,'Double Chocolate Brownie','double-chocolate-brownie','Rich chocolate fudgy square brownie piece.',375.00,249.00,NULL,NULL,NULL,NULL,NULL,'products/z7NBTtTY3XCmnYLDXvAySoTGMXixyOdhMZ9PHFWJ.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:01:25'),(43,12,NULL,'Fruit Pastry','fruit-pastry','Layers of cream and fresh seasonal fruit pieces.',80.00,49.00,NULL,NULL,NULL,NULL,NULL,'products/aGrkkRYYuankgoMc1d2OnIp0gNe2NXF0eGqhcQJs.jpg',NULL,0,200,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:01:38'),(44,12,NULL,'Chocolate Croissant','chocolate-croissant','Flaky buttery pastry with chocolate filling.',325.00,299.00,NULL,NULL,NULL,NULL,NULL,'products/gN5CaAEYq9hCievB67GFnuSxgVCASXQExOGs264B.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:01:52'),(45,12,NULL,'Plain Croissant','plain-croissant','Authentic buttery flaky French style croissant.',300.00,299.00,NULL,NULL,NULL,NULL,NULL,'products/JvUkVlvMPqxgGd5oJiBlehsjhTm6StZ6sE1JCooF.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:02:04'),(46,12,NULL,'Swiss Roll','swiss-roll','Rolled sponge with sweet cream filling.',300.00,249.00,NULL,NULL,NULL,NULL,NULL,'products/DzEnWOsifLLiHGTeMr6DlL9OhAJ8ZzuRfQi1BIbB.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:02:15'),(47,12,NULL,'Lemon Tart','lemon-tart','Zesty lemon curd in a crisp pastry shell.',475.00,399.00,NULL,NULL,NULL,NULL,NULL,'products/YKMzxEfkaxUSBE2MNyODl8vToc9Nj1AOhgkbCNgs.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:02:27'),(48,12,NULL,'Blueberry Tart','blueberry-tart','Blueberry filled pastry with custard.',485.00,399.00,NULL,NULL,NULL,NULL,NULL,'products/bwC9bk23nUN6FarIMWlAhLtqeRMuCh2OqvyYMF45.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:02:39'),(49,12,NULL,'Custard Choux Pastry','custard-choux-pastry','Bite-sized cream-filled choux pastry.',350.00,349.00,NULL,NULL,NULL,NULL,NULL,'products/J3O5FlmL0GxZsVqnRLtejoPIfnEPPrA2ZTmBw5Wi.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:02:49'),(50,5,NULL,'White Bread Loaf','white-bread-loaf','Everyday fresh sandwich bread.',150.00,149.00,NULL,NULL,NULL,NULL,NULL,'products/FSbeS4spVcEwb5KTu6egPGbB6hkxNy68PlcrSxoF.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 02:03:02'),(51,5,NULL,'French Baguette','french-baguette','Crusty European style bread loaf.',180.00,179.00,NULL,NULL,NULL,NULL,NULL,'products/zqlddZsZrB3ZAMjV2Ci14GNjyqD7rIXDJhslGddy.webp',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:48:56'),(52,5,NULL,'Plain Bagel','plain-bagel','Traditional boiled and baked round bagel.',185.00,149.00,NULL,NULL,NULL,NULL,NULL,'products/oicwLzRhNEhGlyLs3MG85xCNu2OWyxH2TcmSgZKb.webp',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:49:19'),(53,5,NULL,'Carrot Bread','carrot-bread','Sweet and spice carrot bread loaf.',100.00,99.00,NULL,NULL,NULL,NULL,NULL,'products/OCfORMVwCgTwoNKNWD8IS6iDAAlivgPNDEm58nhM.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:50:22'),(54,5,NULL,'Cheese Puff Savory','cheese-puff-savory','Savoury snack-style cheese filled puff.',190.00,149.00,NULL,NULL,NULL,NULL,NULL,'products/aNDd6F2ne0lsRbyCTKUYzzSLgnfUvXXePw4rcWqC.jpg',NULL,0,0,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:50:47'),(55,13,NULL,'Bento Cake (Mini)','bento-cake-mini','Trending small individual cakes, perfect for gifts.',500.00,499.00,NULL,NULL,NULL,NULL,NULL,'products/SOzwyezCEVfSrrPx31kPFtKOOqyu6qtnyFKgU2BX.jpg',NULL,0,100,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:51:23'),(56,14,NULL,'Eggless Chocolate Cake','eggless-chocolate-cake','Premium egg-free rich chocolate cake.',1100.00,999.00,NULL,NULL,NULL,NULL,NULL,'products/bPqbwMH3UbL8SwuDkzGZT4OzszuhO8cwvpSaquXg.jpg',NULL,0,10,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:52:03'),(57,14,NULL,'Vegan Vanilla Muffin','vegan-vanilla-muffin','Plant-based vanilla muffin.',250.00,249.00,NULL,NULL,NULL,NULL,NULL,'products/18WDXM9QEFsjbezN0fI2lz9xya3sSzx6PNFImMKR.jpg',NULL,0,0,0,0,0,1,1,NULL,NULL,'2026-01-19 00:17:19','2026-01-19 01:52:44');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Customer','customer','Regular customer account','2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'Admin','admin','Administrator user','2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,'Super Admin','super-admin','Super administrator with full access','2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,'Staff','staff',NULL,'2026-01-18 05:51:02','2026-01-18 05:51:02'),(5,'User','user',NULL,'2026-01-18 05:51:02','2026-01-18 05:51:02');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_items`
--

DROP TABLE IF EXISTS `saved_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_items`
--

LOCK TABLES `saved_items` WRITE;
/*!40000 ALTER TABLE `saved_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `saved_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `key_name` varchar(255) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `group` varchar(255) DEFAULT 'general',
  `type` varchar(255) DEFAULT 'text',
  `value_type` varchar(50) DEFAULT 'string',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `idx_key` (`key`),
  KEY `idx_key_name` (`key_name`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'bakery_name','bakery_name','Cinnamon Bakery','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(2,'bakery_logo','bakery_logo','logos/cinnamon-logo.png','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(3,'contact_email','contact_email','info@cinnamonbakery.com','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(4,'contact_phone','contact_phone','+977 1234567890','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(5,'delivery_charge','delivery_charge','100','general','text','number',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(6,'minimum_order_amount','minimum_order_amount','500','general','text','number',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(7,'tax_percentage','tax_percentage','13','general','text','number',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(8,'delivery_time_estimate','delivery_time_estimate','45','general','text','number',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(9,'business_hours_start','business_hours_start','09:00','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(10,'business_hours_end','business_hours_end','22:00','general','text','string',NULL,'2026-01-18 08:07:22','2026-01-18 08:07:22'),(11,'footer_description',NULL,'Artisan bakery crafting delicious treats since 2022. Quality ingredients, traditional methods, modern flavors.','general','text','string',NULL,'2026-01-18 08:44:53','2026-01-18 08:44:53'),(12,'contact_address',NULL,'Sano Bharayang, Kathmandu, Nepal','general','text','string',NULL,'2026-01-18 08:44:53','2026-01-18 08:44:53'),(13,'contact_hours',NULL,'Open Daily: 8AM - 8PM','general','text','string',NULL,'2026-01-18 08:44:53','2026-01-18 08:44:53'),(14,'newsletter_text',NULL,'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.','general','text','string',NULL,'2026-01-18 08:44:53','2026-01-18 08:44:53'),(15,'min_order_free_delivery',NULL,'2000','general','text','string',NULL,'2026-01-18 08:44:53','2026-01-18 08:44:53'),(21,'maintenance_mode',NULL,'0','general','text','string',NULL,'2026-01-18 03:01:10','2026-01-18 03:01:10'),(22,'social_facebook',NULL,'#','general','text','string',NULL,'2026-01-18 03:01:10','2026-01-18 03:01:10'),(23,'social_instagram',NULL,'#','general','text','string',NULL,'2026-01-18 03:01:10','2026-01-18 03:01:10'),(24,'social_twitter',NULL,'#','general','text','string',NULL,'2026-01-18 03:01:10','2026-01-18 03:01:10'),(25,'social_pinterest',NULL,'#','general','text','string',NULL,'2026-01-18 03:01:10','2026-01-18 03:01:10');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table_reservations`
--

DROP TABLE IF EXISTS `table_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table_reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `table_number` int(11) NOT NULL,
  `status` enum('available','occupied','reserved') NOT NULL DEFAULT 'available',
  `current_order_id` bigint(20) unsigned DEFAULT NULL,
  `occupied_at` timestamp NULL DEFAULT NULL,
  `available_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `table_reservations_current_order_id_foreign` (`current_order_id`),
  KEY `table_reservations_table_number_index` (`table_number`),
  KEY `table_reservations_status_index` (`status`),
  CONSTRAINT `table_reservations_current_order_id_foreign` FOREIGN KEY (`current_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table_reservations`
--

LOCK TABLES `table_reservations` WRITE;
/*!40000 ALTER TABLE `table_reservations` DISABLE KEYS */;
INSERT INTO `table_reservations` VALUES (1,1,'reserved',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:36:54'),(2,2,'occupied',7,'2026-01-19 00:41:26',NULL,'2026-01-19 00:27:17','2026-01-19 00:41:26'),(3,3,'occupied',8,'2026-01-19 00:57:50',NULL,'2026-01-19 00:27:17','2026-01-19 00:57:50'),(4,4,'occupied',9,'2026-01-19 02:24:25',NULL,'2026-01-19 00:27:17','2026-01-19 02:24:25'),(5,5,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(6,6,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(7,7,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(8,8,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(9,9,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(10,10,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(11,11,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(12,12,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(13,13,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(14,14,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(15,15,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(16,16,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(17,17,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(18,18,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(19,19,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17'),(20,20,'available',NULL,NULL,NULL,'2026-01-19 00:27:17','2026-01-19 00:27:17');
/*!40000 ALTER TABLE `table_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Rajesh Kumar','Food Enthusiast',NULL,'Amazing cakes! The quality and taste are exceptional. Highly recommended!',5,'pending','2026-01-18 04:01:56','2026-01-18 08:07:22','2026-01-18 04:01:56'),(2,'Priya Singh','Event Organizer',NULL,'Perfect for parties and events. Great customer service!',5,'pending','2026-01-18 04:02:00','2026-01-18 08:07:22','2026-01-18 04:02:00'),(3,'Amit Patel','Business Owner',NULL,'Best bakery in town. Fresh products daily!',4,'pending','2026-01-18 04:02:03','2026-01-18 08:07:22','2026-01-18 04:02:03'),(4,'Ujwal',NULL,NULL,'The product is tasty',5,'approved',NULL,'2026-01-18 04:01:31','2026-01-18 04:01:41'),(5,'Hari',NULL,NULL,'food is nice',4,'pending',NULL,'2026-01-18 04:38:25','2026-01-18 04:38:25');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_addresses`
--

LOCK TABLES `user_addresses` WRITE;
/*!40000 ALTER TABLE `user_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'https://randomuser.me/api/portraits/lego/1.jpg',
  `avatar` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT 1,
  `role` enum('customer','admin') DEFAULT 'customer',
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_phone_verified` tinyint(1) DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`),
  KEY `role_id` (`role_id`),
  KEY `idx_email` (`email`),
  KEY `idx_phone` (`phone`),
  KEY `idx_deleted_at` (`deleted_at`),
  FULLTEXT KEY `ft_name_email` (`name`,`email`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,'Demo Customer','customer@bakery.com','2026-01-18 08:07:22','$2y$10$9UvAzLWGEzJzN3H5aG5QAuJHRLFvUKjVVJZuV5WK5pL4q/VrMIimy','9800000001','Kathmandu, Nepal','https://randomuser.me/api/portraits/women/1.jpg',NULL,1,'customer',NULL,NULL,0,NULL,'2026-01-18 03:28:09','2026-01-18 08:07:22','2026-01-18 03:28:09','active'),(4,NULL,'Ujwal','Ujwal@gmail.com',NULL,'$2y$10$7OHvzFT/AcHNRQljV25uh.2GAvY3DoSzi/vq9k4vK6jPlqJWtLbKC','9769349551','','https://randomuser.me/api/portraits/women/30.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 03:59:20','2026-01-18 03:59:20','active'),(5,NULL,'Hari','Hari@gmail.com',NULL,'$2y$10$staeZr2waXLbvoBhiA0e9uTc1WjeVUowJNadqTyvS5aWNTYvZsfDq','9876543210','','https://randomuser.me/api/portraits/men/66.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 04:25:56','2026-01-18 04:25:56','active'),(6,NULL,'Super Admin','admin@bakery.com',NULL,'$2y$10$PKH7g0lWgIlVFwPlmlFTTuy.kdMudD6.Kc74cAboISwbJqJqpGWKu','9800000000',NULL,'https://randomuser.me/api/portraits/lego/1.jpg',NULL,3,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 05:51:03','2026-01-18 21:11:45','active'),(7,NULL,'Admin User','admin@cinnamonbakery.com',NULL,'$2y$10$AKgcjBkpBIh5n/Z14HtmJ.QXfj8RYEden0PljYY/y2waJx6TGrH9.','+977 9801234567','Sano Bharayang, Kathmandu','https://randomuser.me/api/portraits/men/32.jpg',NULL,1,'admin',NULL,NULL,0,NULL,NULL,'2026-01-18 05:51:03','2026-01-18 21:11:46','active'),(14,NULL,'sita','Shyam@gmail.com',NULL,'$2y$10$tmvl/jsLKMbgTOLMq3oegeCggoDzDfHlcBAYoVobzK9Fb5xHmXzM.','9786543210','','https://randomuser.me/api/portraits/men/17.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 21:15:06','2026-01-18 21:15:06','active'),(15,NULL,'gita','Gita@gmail.com',NULL,'$2y$10$DbZPOoFdSBMnaeQMR//VKOcTt080lXQGPqobkdksDAphTr8VEdsXa','9865320147','','https://randomuser.me/api/portraits/women/67.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 21:18:52','2026-01-18 21:18:52','active'),(16,NULL,'Test User','test0.11302629597974823@example.com',NULL,'$2y$10$D0YpUCOlw7.hHQDf3hKxA.ww.AM7hOOA2CqEXZOhnlK6tQf/P7d8e','9898249090','','https://randomuser.me/api/portraits/men/19.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 21:53:23','2026-01-18 21:53:23','active'),(17,NULL,'New Test User','user456@example.com',NULL,'$2y$10$TJBa6l.hcw8p9D5y9typCu1XPbYUdxbVqDDVAYXtgEI6rk4.SGiKC','9811111111','','https://randomuser.me/api/portraits/women/32.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 22:42:02','2026-01-18 22:42:02','active'),(18,NULL,'hari','Hari1@gmail.com',NULL,'$2y$10$CAvvboRx.rLV8isNOG68m.DvhoBLTphQwsiDh5AeWPRPF.vqP9xim','9867532410','','https://randomuser.me/api/portraits/men/9.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 22:44:55','2026-01-18 22:44:55','active'),(19,NULL,'Gopal','gopal@gmail.com',NULL,'$2y$10$T8IqL6f7wNwIV9gYASMhjeQ5TonVA19bVmlXKgVSdGi7qW8y4NhC.','9864571320','','https://randomuser.me/api/portraits/men/12.jpg',NULL,1,'customer',NULL,NULL,0,NULL,NULL,'2026-01-18 23:41:33','2026-01-18 23:41:33','active');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-19 14:16:51

--
-- Update status enums for orders table
--
ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending','confirmed','preparing','ready','with_logistic','out_for_delivery','delivered','cancelled') DEFAULT 'pending';
ALTER TABLE `orders` MODIFY COLUMN `payment_status` ENUM('pending','paid','completed','failed','refunded') DEFAULT 'pending';


 
 