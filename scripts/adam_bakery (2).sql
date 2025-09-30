-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 07:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adam_bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-09-17 16:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama`, `created_at`) VALUES
(1, 'Roti Manis', '2025-09-17 16:22:57'),
(2, 'Roti Tawar', '2025-09-17 16:22:57'),
(3, 'Kue Kering', '2025-09-17 16:22:57'),
(4, 'Kue Ulang Tahun', '2025-09-17 16:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `customer_users`
--

CREATE TABLE `customer_users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_users`
--

INSERT INTO `customer_users` (`id`, `nama_lengkap`, `email`, `password`, `phone`, `alamat`, `created_at`, `updated_at`) VALUES
(2, 'Adam F', 'yanto@gmail.com', '$2y$10$o.m9k2sNGxJBAmXMfvVhPeLoR2jan6tIpaIa/i3CCZ3nwJfels6hW', '12345', 'pacul', '2025-09-23 06:53:03', '2025-09-23 06:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `custom_order_quotes`
--

CREATE TABLE `custom_order_quotes` (
  `id` int(11) NOT NULL,
  `kontak_id` int(11) NOT NULL,
  `quoted_price` decimal(10,2) NOT NULL,
  `quote_details` text DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `status` enum('pending','accepted','rejected','expired') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `jenis_kontak` enum('ulasan','custom_order','pertanyaan') DEFAULT 'ulasan',
  `custom_order_details` text DEFAULT NULL,
  `budget_range` varchar(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `jumlah_porsi` int(11) DEFAULT NULL,
  `status` enum('pending','reviewed','quoted','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `nama`, `email`, `pesan`, `jenis_kontak`, `custom_order_details`, `budget_range`, `event_date`, `jumlah_porsi`, `status`, `created_at`) VALUES
(1, 'Adam', 'yanto@gmail.com', 'G wuenak', 'ulasan', NULL, NULL, NULL, NULL, 'pending', '2025-09-18 11:26:56'),
(2, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', '> 5jt', '2026-01-31', 1000, 'pending', '2025-09-21 05:53:28'),
(3, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', '> 5jt', '2026-01-31', 1000, 'pending', '2025-09-21 05:57:47'),
(4, 'Adam', 'yanto@gmail.com', 'apa yah', 'custom_order', 'Nyocot sih', NULL, '2026-01-31', 1000, 'cancelled', '2025-09-21 05:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT 'placeholder.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `nama`, `deskripsi`, `harga`, `gambar`, `created_at`, `image`) VALUES
(1, 'Paket Pagi Sehat', 'Roti tawar gandum + croissant + susu segar untuk memulai hari', 35000.00, 'placeholder.jpg', '2025-09-17 16:22:57', NULL),
(2, 'Paket Ulang Tahun Kecil', 'Kue tart vanilla + 6 donat mix + lilin ulang tahun', 200000.00, 'placeholder.jpg', '2025-09-17 16:22:57', NULL),
(3, 'Paket Ulang Tahun Besar', 'Kue tart coklat + 12 donat mix + black forest mini + dekorasi', 350000.00, 'placeholder.jpg', '2025-09-17 16:22:57', NULL),
(4, 'Paket Kue Kering Lebaran', 'Nastar + kastengel + putri salju dalam kemasan cantik', 120000.00, 'placeholder.jpg', '2025-09-17 16:22:57', NULL),
(5, 'Paket Sarapan Keluarga', '2 roti tawar + 4 croissant + selai strawberry', 65000.00, 'placeholder.jpg', '2025-09-17 16:22:57', NULL),
(6, 'Paket Kecil', 'Paket Roti Unyil dengan 4 varian rasa yang bisa dipilih sesuai keinginan! ', 10000.00, 'placeholder.jpg', '2025-09-22 06:41:24', NULL),
(7, 'Paket Sedang', 'Paket Sedang dengan 4 varian rasa sesuai keinginanmu!', 15000.00, 'placeholder.jpg', '2025-09-22 06:44:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `kategori` enum('Roti Manis','Roti Tawar','Kue Kering','Kue Ulang Tahun') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT 'placeholder.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama`, `harga`, `kategori`, `deskripsi`, `gambar`, `created_at`, `updated_at`, `image`) VALUES
(1, 2, 'Roti Tawar Gandum', 25000.00, 'Roti Tawar', 'Roti tawar gandum segar dengan tekstur lembut dan rasa yang kaya', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(2, 2, 'Roti Tawar Putih', 20000.00, 'Roti Tawar', 'Roti tawar putih klasik yang lembut dan cocok untuk sarapan', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(3, 1, 'Croissant Butter', 18000.00, 'Roti Manis', 'Croissant berlapis dengan butter premium, renyah di luar lembut di dalam', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 16:22:57', NULL),
(4, 1, 'Donat Coklat', 12000.00, 'Roti Manis', 'Donat lembut dengan glazur coklat manis yang menggoda', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 16:22:57', NULL),
(5, 1, 'Donat Strawberry', 12000.00, 'Roti Manis', 'Donat dengan topping strawberry segar dan manis', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 16:22:57', NULL),
(6, 3, 'Kue Nastar', 45000.00, 'Kue Kering', 'Kue kering tradisional dengan isian nanas manis (per toples)', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(7, 3, 'Kastengel', 50000.00, 'Kue Kering', 'Kue kering keju yang gurih dan renyah (per toples)', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(8, 4, 'Kue Tart Coklat', 150000.00, 'Kue Ulang Tahun', 'Kue tart coklat dengan dekorasi cantik untuk ulang tahun', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(9, 4, 'Kue Tart Vanilla', 140000.00, 'Kue Ulang Tahun', 'Kue tart vanilla dengan cream lembut dan dekorasi elegan', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL),
(10, 4, 'Black Forest Cake', 180000.00, 'Kue Ulang Tahun', 'Kue black forest dengan cherry dan whipped cream', 'placeholder.jpg', '2025-09-17 16:22:57', '2025-09-17 17:02:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promos`
--

INSERT INTO `promos` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'Gratis Ongkir', 'Gratis coii', '2025-09-23 16:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `item_type` enum('product','package') NOT NULL,
  `nama_reviewer` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('transfer_bank') DEFAULT 'transfer_bank',
  `bank_name` varchar(100) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `transfer_amount` decimal(10,2) DEFAULT NULL,
  `transfer_proof` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `nama_pembeli`, `email`, `phone`, `alamat`, `total_amount`, `payment_method`, `bank_name`, `account_name`, `account_number`, `transfer_amount`, `transfer_proof`, `status`, `created_at`, `updated_at`, `customer_id`) VALUES
(1, 'Adam F', 'yanto@gmail.com', '12345', 'pacul', 180000.00, 'transfer_bank', 'BCA', 'Adam', '12345', 180000.00, '', 'confirmed', '2025-09-18 01:52:45', '2025-09-18 02:06:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `item_type` enum('product','package') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `product_id`, `package_id`, `item_type`, `quantity`, `price`) VALUES
(1, 1, 10, NULL, 'product', 1, 180000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `customer_users`
--
ALTER TABLE `customer_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_customer_email` (`email`);

--
-- Indexes for table `custom_order_quotes`
--
ALTER TABLE `custom_order_quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kontak_id` (`kontak_id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kontak_jenis` (`jenis_kontak`),
  ADD KEY `idx_kontak_status` (`status`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_review_transaction` (`transaction_id`),
  ADD KEY `idx_review_product` (`product_id`),
  ADD KEY `idx_review_package` (`package_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_transaction_customer` (`customer_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_transaction_id` (`transaction_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_package_id` (`package_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_users`
--
ALTER TABLE `customer_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `custom_order_quotes`
--
ALTER TABLE `custom_order_quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_order_quotes`
--
ALTER TABLE `custom_order_quotes`
  ADD CONSTRAINT `custom_order_quotes_ibfk_1` FOREIGN KEY (`kontak_id`) REFERENCES `kontak` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaction_items_ibfk_3` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
