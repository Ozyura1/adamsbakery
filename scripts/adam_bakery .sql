-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for adam_bakery
CREATE DATABASE IF NOT EXISTS `adam_bakery` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `adam_bakery`;

-- Dumping structure for table adam_bakery.admin_users
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.admin_users: ~1 rows (approximately)
INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
	(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-09-17 16:22:57');

-- Dumping structure for table adam_bakery.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.categories: ~4 rows (approximately)
INSERT INTO `categories` (`id`, `nama`, `created_at`) VALUES
	(1, 'Roti Manis', '2025-09-17 16:22:57'),
	(2, 'Roti Tawar', '2025-09-17 16:22:57'),
	(3, 'Kue Kering', '2025-09-17 16:22:57'),
	(4, 'Kue Ulang Tahun', '2025-09-17 16:22:57');

-- Dumping structure for table adam_bakery.customer_users
CREATE TABLE IF NOT EXISTS `customer_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_customer_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.customer_users: ~1 rows (approximately)
INSERT INTO `customer_users` (`id`, `nama_lengkap`, `email`, `password`, `phone`, `alamat`, `created_at`, `updated_at`) VALUES
	(2, 'Adam F', 'yanto@gmail.com', '$2y$10$o.m9k2sNGxJBAmXMfvVhPeLoR2jan6tIpaIa/i3CCZ3nwJfels6hW', '12345', 'pacul', '2025-09-23 06:53:03', '2025-09-23 06:53:03');

-- Dumping structure for table adam_bakery.custom_order_quotes
CREATE TABLE IF NOT EXISTS `custom_order_quotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kontak_id` int NOT NULL,
  `quoted_price` decimal(10,2) NOT NULL,
  `quote_details` text COLLATE utf8mb4_general_ci,
  `valid_until` date DEFAULT NULL,
  `status` enum('pending','accepted','rejected','expired') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kontak_id` (`kontak_id`),
  CONSTRAINT `custom_order_quotes_ibfk_1` FOREIGN KEY (`kontak_id`) REFERENCES `kontak` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.custom_order_quotes: ~0 rows (approximately)

-- Dumping structure for table adam_bakery.kontak
CREATE TABLE IF NOT EXISTS `kontak` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kontak` enum('ulasan','custom_order','pertanyaan') COLLATE utf8mb4_general_ci DEFAULT 'ulasan',
  `custom_order_details` text COLLATE utf8mb4_general_ci,
  `budget_range` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `jumlah_porsi` int DEFAULT NULL,
  `status` enum('pending','reviewed','quoted','confirmed','completed','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_kontak_jenis` (`jenis_kontak`),
  KEY `idx_kontak_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.kontak: ~4 rows (approximately)
INSERT INTO `kontak` (`id`, `nama`, `email`, `pesan`, `jenis_kontak`, `custom_order_details`, `budget_range`, `event_date`, `jumlah_porsi`, `status`, `created_at`) VALUES
	(1, 'Adam', 'yanto@gmail.com', 'G wuenak', 'ulasan', NULL, NULL, NULL, NULL, 'pending', '2025-09-18 11:26:56'),
	(2, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', '> 5jt', '2026-01-31', 1000, 'pending', '2025-09-21 05:53:28'),
	(3, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', '> 5jt', '2026-01-31', 1000, 'pending', '2025-09-21 05:57:47'),
	(4, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', NULL, '2026-01-31', 1000, 'cancelled', '2025-09-21 05:59:36');

-- Dumping structure for table adam_bakery.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'placeholder.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.packages: ~7 rows (approximately)
INSERT INTO `packages` (`id`, `nama`, `deskripsi`, `harga`, `created_at`, `image`) VALUES
	(1, 'Paket Pagi Sehat', 'Roti tawar gandum + croissant + susu segar untuk memulai hari', 35000.00, '2025-09-17 16:22:57', 'placeholder.jpg'),
	(2, 'Paket Ulang Tahun Kecil', 'Kue tart vanilla + 6 donat mix + lilin ulang tahun', 200000.00, '2025-09-17 16:22:57', 'placeholder.jpg'),
	(3, 'Paket Ulang Tahun Besar', 'Kue tart coklat + 12 donat mix + black forest mini + dekorasi', 350000.00, '2025-09-17 16:22:57', 'placeholder.jpg'),
	(4, 'Paket Kue Kering Lebaran', 'Nastar + kastengel + putri salju dalam kemasan cantik', 120000.00, '2025-09-17 16:22:57', 'placeholder.jpg'),
	(5, 'Paket Sarapan Keluarga', '2 roti tawar + 4 croissant + selai strawberry', 65000.00, '2025-09-17 16:22:57', 'placeholder.jpg'),
	(6, 'Paket Kecil', 'Paket Roti Unyil dengan 4 varian rasa yang bisa dipilih sesuai keinginan! ', 10000.00, '2025-09-22 06:41:24', 'uploads/1759506407_RobloxScreenShot20231031_150947555.png'),
	(7, 'Paket Sedang', 'Paket Sedang dengan 4 varian rasa sesuai keinginanmu!', 15000.00, '2025-09-22 06:44:01', 'placeholder.jpg');

-- Dumping structure for table adam_bakery.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `kategori` enum('Roti Manis','Roti Tawar','Kue Kering','Kue Ulang Tahun') COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'placeholder.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.products: ~10 rows (approximately)
INSERT INTO `products` (`id`, `category_id`, `nama`, `harga`, `kategori`, `deskripsi`, `image`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Roti Tawar Gandum', 25000.00, 'Roti Tawar', 'Roti tawar gandum segar dengan tekstur lembut dan rasa yang kaya', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(2, 2, 'Roti Tawar Putih', 20000.00, 'Roti Tawar', 'Roti tawar putih klasik yang lembut dan cocok untuk sarapan', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(3, 1, 'Croissant Butter', 18000.00, 'Roti Manis', 'Croissant berlapis dengan butter premium, renyah di luar lembut di dalam', 'uploads/1759506523_RobloxScreenShot20231031_151006516.png', '2025-09-17 16:22:57', '2025-10-03 15:48:43'),
	(4, 1, 'Donat Coklat', 12000.00, 'Roti Manis', 'Donat lembut dengan glazur coklat manis yang menggoda', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 16:22:57'),
	(5, 1, 'Donat Strawberry', 12000.00, 'Roti Manis', 'Donat dengan topping strawberry segar dan manis', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 16:22:57'),
	(6, 3, 'Kue Nastar', 45000.00, 'Kue Kering', 'Kue kering tradisional dengan isian nanas manis (per toples)', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(7, 3, 'Kastengel', 50000.00, 'Kue Kering', 'Kue kering keju yang gurih dan renyah (per toples)', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(8, 4, 'Kue Tart Coklat', 150000.00, 'Kue Ulang Tahun', 'Kue tart coklat dengan dekorasi cantik untuk ulang tahun', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(9, 4, 'Kue Tart Vanilla', 140000.00, 'Kue Ulang Tahun', 'Kue tart vanilla dengan cream lembut dan dekorasi elegan', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35'),
	(10, 4, 'Black Forest Cake', 180000.00, 'Kue Ulang Tahun', 'Kue black forest dengan cherry dan whipped cream', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35');

-- Dumping structure for table adam_bakery.promos
CREATE TABLE IF NOT EXISTS `promos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.promos: ~1 rows (approximately)
INSERT INTO `promos` (`id`, `title`, `description`, `created_at`) VALUES
	(1, 'Gratis Ongkir', 'Gratis coii', '2025-09-23 16:24:29');

-- Dumping structure for table adam_bakery.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `item_type` enum('product','package') COLLATE utf8mb4_general_ci NOT NULL,
  `nama_reviewer` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` int NOT NULL,
  `review_text` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_review_transaction` (`transaction_id`),
  KEY `idx_review_product` (`product_id`),
  KEY `idx_review_package` (`package_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.reviews: ~0 rows (approximately)

-- Dumping structure for table adam_bakery.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pembeli` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('transfer_bank') COLLATE utf8mb4_general_ci DEFAULT 'transfer_bank',
  `bank_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transfer_amount` decimal(10,2) DEFAULT NULL,
  `transfer_proof` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_transaction_customer` (`customer_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.transactions: ~1 rows (approximately)
INSERT INTO `transactions` (`id`, `nama_pembeli`, `email`, `phone`, `alamat`, `total_amount`, `payment_method`, `bank_name`, `account_name`, `account_number`, `transfer_amount`, `transfer_proof`, `status`, `created_at`, `updated_at`, `customer_id`) VALUES
	(1, 'Adam F', 'yanto@gmail.com', '12345', 'pacul', 180000.00, 'transfer_bank', 'BCA', 'Adam', '12345', 180000.00, '', 'confirmed', '2025-09-18 01:52:45', '2025-09-18 02:06:27', NULL);

-- Dumping structure for table adam_bakery.transaction_items
CREATE TABLE IF NOT EXISTS `transaction_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `item_type` enum('product','package') COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_transaction_id` (`transaction_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_package_id` (`package_id`),
  CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transaction_items_ibfk_3` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table adam_bakery.transaction_items: ~1 rows (approximately)
INSERT INTO `transaction_items` (`id`, `transaction_id`, `product_id`, `package_id`, `item_type`, `quantity`, `price`) VALUES
	(1, 1, 10, NULL, 'product', 1, 180000.00);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
