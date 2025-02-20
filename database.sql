-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 20, 2025 at 06:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'adidas', 'images/uuhSAGPSc2ZBlIB6sC5lPq3z9IPHMYu3y1mjWdgG.png', '2025-02-19 06:14:34', '2025-02-19 06:14:34'),
(2, 'nike', 'images/4VFav5Asx8oJ1GU4CucMw0qPYGF7LTJX7UJhG57Q.png', '2025-02-19 06:14:43', '2025-02-19 06:14:43'),
(3, 'puma', 'images/D70TWRHGenuhoqMvYDNSWaFvpyD9nfLWKNixgSgq.png', '2025-02-19 06:14:59', '2025-02-19 06:14:59'),
(5, 'converse', 'images/pK1LQkhuUezHEhXFNzBR0ILZNt8g3JbRgHolTX8J.png', '2025-02-19 06:17:59', '2025-02-19 06:17:59'),
(6, 'compass', 'images/AxQG7GirQ5H7cnd34kZGebj9ZYByuj19RehgypR8.png', '2025-02-19 06:18:15', '2025-02-19 23:40:44'),
(8, 'ventela', 'images/eD1Hf3gNt6UO0kpZrRClWiZZIheuZgmQWQmfFzHd.png', '2025-02-19 06:25:20', '2025-02-19 06:25:20'),
(9, 'new balance', 'images/7f1jYZSenRieqaHEZWJoqkZWjWVkkKJiBNIFr6ue.png', '2025-02-19 07:07:32', '2025-02-20 02:10:00'),
(10, 'onitsuka tiger', 'images/7wuthJR8VGiNHgx1IJClE5GIf0eHl1yFgqYT3Rhq.png', '2025-02-19 07:09:56', '2025-02-19 07:09:56'),
(12, 'asics', 'images/Rji1he0W8YLxyI7OSBJndR6MeXtAs39bRm58g3aY.png', '2025-02-19 07:11:03', '2025-02-19 07:11:03'),
(20, 'reebok', 'images/tK9uXKAPkk8NtHMzGoqcIoLGpQ3RY0lSk1VwvZh4.png', '2025-02-19 08:53:30', '2025-02-19 08:54:27'),
(21, 'diadora', 'images/i55TIpymdHlkXnePtJNmUlCUEtS7dKRodpyAE1ZL.png', '2025-02-19 08:53:43', '2025-02-19 08:53:43'),
(43, 'skechers', 'images/J1rGlhZ6KNl8sn8gJBDqMUF4ZrrtSDjyRczv0L2m.png', '2025-02-19 23:47:31', '2025-02-19 23:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@example.com412|127.0.0.1', 'i:1;', 1739962916),
('admin@example.com412|127.0.0.1:timer', 'i:1739962916;', 1739962916);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'training', '2025-02-19 06:38:17', '2025-02-19 06:38:43'),
(2, 'originals', '2025-02-19 06:38:51', '2025-02-19 23:40:08'),
(4, 'running', '2025-02-19 06:56:45', '2025-02-19 06:56:45'),
(14, 'outdoor', '2025-02-19 23:46:05', '2025-02-19 23:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_02_10_235808_create_users_table', 1),
(4, '2025_02_12_235651_create_products_table', 1),
(5, '2025_02_18_085107_create_transaction_purchases_table', 1),
(6, '2025_02_18_085119_create_transaction_sales_table', 1),
(7, '2025_02_18_094450_create_report_purchases_table', 1),
(8, '2025_02_18_094514_create_report_sales_table', 1),
(9, '2025_02_19_121153_create_brands_table', 2),
(10, '2025_02_19_121206_create_categories_table', 2),
(11, '2025_02_19_124118_create_products_table', 2),
(12, '2025_02_19_124402_create_transaction_purchases_table', 2),
(13, '2025_02_19_124433_create_transaction_sales_table', 2),
(14, '2025_02_20_083426_create_products_table', 3),
(15, '2025_02_20_083606_create_transaction_purchases_table', 3),
(16, '2025_02_20_083709_create_transaction_sales_table', 3),
(17, '2025_02_20_084504_create_report_purchases_table', 3),
(18, '2025_02_20_084600_create_report_sales_table', 3),
(19, '2025_02_20_084957_create_products_table', 4),
(20, '2025_02_20_085402_create_transaction_purchases_table', 4),
(21, '2025_02_20_085421_create_transaction_sales_table', 4),
(22, '2025_02_20_085447_create_report_purchases_table', 4),
(23, '2025_02_20_085510_create_report_sales_table', 4),
(24, '2025_02_20_110050_create_report_purchases_table', 5),
(25, '2025_02_20_110946_create_report_purchases_table', 6),
(26, '2025_02_20_111002_create_report_sales_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `category_id`, `name`, `purchase_price`, `sale_price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 'compass gazelle low', 275000, 450000, 4, 'images/ZujAfmJxI39eou2MJsGgJUJNn5pHDQ3PtWDw9vz6.png', '2025-02-20 01:59:49', '2025-02-20 09:33:14'),
(2, 9, 4, 'new balance 530', 1500000, 2250000, 4, 'images/qdeqG0Xlnb79aliP8stx4MGFikE0i0Ky7KkkdOIE.png', '2025-02-20 01:59:49', '2025-02-20 09:33:56'),
(3, 5, 2, 'converse 70s', 750000, 1250000, 18, 'images/Ln8MKXv8essuG5aPEtM4J1fKPzh3CqfDbDBLvPh8.png', '2025-02-20 01:59:49', '2025-02-20 06:49:11'),
(4, 1, 2, 'adidas superstar', 1000000, 1700000, 10, 'images/DWGmJxXN2hmxEDrJdbK9gMyMRAuJ1wo5Ug5lFQgr.png', '2025-02-20 02:00:45', '2025-02-20 06:49:14'),
(8, 8, 2, 'ventela public low', 200000, 275000, 10, 'images/fpiaiXNHHT87b82tDscWHYW3BAwhEAjuw8BwVUsD.png', '2025-02-20 02:02:41', '2025-02-20 06:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `report_purchases`
--

CREATE TABLE `report_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `purchase_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `profit` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `action` varchar(255) NOT NULL DEFAULT 'created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_purchases`
--

INSERT INTO `report_purchases` (`id`, `brand_id`, `category_id`, `product_id`, `transaction_purchase_id`, `name`, `purchase_price`, `sale_price`, `quantity`, `subtotal`, `profit`, `date`, `action`, `created_at`, `updated_at`) VALUES
(12, 8, 2, 8, 7, 'dika', 200000, 275000, 1, 200000.00, 75000, '2025-02-18', 'updated', '2025-02-20 06:42:56', '2025-02-20 06:42:56'),
(13, 5, 2, 3, 10, 'rizki', 750000, 1250000, 1, 750000.00, 500000, '2025-02-20', 'updated', '2025-02-20 06:42:58', '2025-02-20 06:42:58'),
(14, 1, 2, 4, 9, 'julian', 1000000, 1700000, 3, 3000000.00, 700000, '2025-02-20', 'updated', '2025-02-20 06:43:01', '2025-02-20 06:43:01'),
(15, 6, 2, 1, 8, 'intan', 275000, 450000, 2, 550000.00, 175000, '2025-02-18', 'updated', '2025-02-20 06:43:03', '2025-02-20 06:43:03'),
(17, 1, 2, 4, 11, 'dani', 1000000, 1700000, 3, 3000000.00, 700000, '2025-02-19', 'updated', '2025-02-20 06:44:21', '2025-02-20 06:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `report_sales`
--

CREATE TABLE `report_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_sale_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `purchase_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `profit` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `action` varchar(255) NOT NULL DEFAULT 'created',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_sales`
--

INSERT INTO `report_sales` (`id`, `brand_id`, `category_id`, `product_id`, `transaction_sale_id`, `name`, `purchase_price`, `sale_price`, `quantity`, `subtotal`, `profit`, `date`, `action`, `created_at`, `updated_at`) VALUES
(18, 9, 4, 2, 11, 'anto', 1500000, 2250000, 3, 6750000.00, 750000, '2025-02-18', 'updated', '2025-02-20 06:49:07', '2025-02-20 06:49:07'),
(19, 9, 4, 2, 16, 'bagos', 1500000, 2250000, 2, 4500000.00, 750000, '2025-02-20', 'updated', '2025-02-20 06:49:10', '2025-02-20 06:49:10'),
(20, 5, 2, 3, 15, 'wijaya', 750000, 1250000, 4, 5000000.00, 500000, '2025-02-10', 'updated', '2025-02-20 06:49:11', '2025-02-20 06:49:11'),
(21, 1, 2, 4, 14, 'reza', 1000000, 1700000, 1, 1700000.00, 700000, '2025-02-20', 'updated', '2025-02-20 06:49:14', '2025-02-20 06:49:14'),
(22, 6, 2, 1, 13, 'ardi', 275000, 450000, 4, 1800000.00, 175000, '2025-02-14', 'updated', '2025-02-20 06:49:16', '2025-02-20 06:49:16'),
(23, 9, 4, 2, 12, 'bintang', 1500000, 2250000, 3, 6750000.00, 750000, '2025-02-16', 'updated', '2025-02-20 06:49:19', '2025-02-20 06:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qIKHkC2BAzVBqubzyn4YKoGX7GHmeF7H7SYyQoRi', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNGlUbTJkdTFoQ2xwSmVFckdyTzAybjNDRWJlbXo5cXRzN0o2a2VvbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFuc2FjdGlvbl9wdXJjaGFzZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQwMDY2MTc5O319', 1740072786);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_purchases`
--

CREATE TABLE `transaction_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_purchases`
--

INSERT INTO `transaction_purchases` (`id`, `product_id`, `name`, `quantity`, `price`, `subtotal`, `date`, `created_at`, `updated_at`) VALUES
(7, 8, 'dika', 1, 200000.00, 200000.00, '2025-02-18', '2025-02-20 05:12:06', '2025-02-20 06:42:56'),
(8, 1, 'intan', 2, 275000.00, 550000.00, '2025-02-18', '2025-02-20 05:41:44', '2025-02-20 06:43:03'),
(9, 4, 'julian', 3, 1000000.00, 3000000.00, '2025-02-20', '2025-02-20 05:41:44', '2025-02-20 06:43:01'),
(10, 3, 'rizki', 1, 750000.00, 750000.00, '2025-02-20', '2025-02-20 05:41:44', '2025-02-20 06:42:58'),
(11, 4, 'dani', 3, 1000000.00, 3000000.00, '2025-02-19', '2025-02-20 06:40:40', '2025-02-20 06:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_sales`
--

CREATE TABLE `transaction_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_sales`
--

INSERT INTO `transaction_sales` (`id`, `product_id`, `name`, `quantity`, `price`, `subtotal`, `date`, `created_at`, `updated_at`) VALUES
(11, 2, 'anto', 3, 2250000.00, 6750000.00, '2025-02-18', '2025-02-20 05:35:32', '2025-02-20 06:49:07'),
(12, 2, 'bintang', 3, 2250000.00, 6750000.00, '2025-02-16', '2025-02-20 05:46:38', '2025-02-20 06:49:19'),
(13, 1, 'ardi', 4, 450000.00, 1800000.00, '2025-02-14', '2025-02-20 05:46:38', '2025-02-20 06:49:16'),
(14, 4, 'reza', 1, 1700000.00, 1700000.00, '2025-02-20', '2025-02-20 05:46:38', '2025-02-20 06:49:14'),
(15, 3, 'wijaya', 4, 1250000.00, 5000000.00, '2025-02-10', '2025-02-20 05:46:38', '2025-02-20 06:49:11'),
(16, 2, 'bagos', 2, 2250000.00, 4500000.00, '2025-02-20', '2025-02-20 05:46:38', '2025-02-20 06:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'fahreza', 'admin@example.com', NULL, '$2y$12$Gg1b0eLuUIsXTEAFVcdzsOmxDZktq2DcMxFJQbiLNvdTUTUvvkOzq', NULL, '2025-02-19 04:00:44', '2025-02-19 04:00:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `report_purchases`
--
ALTER TABLE `report_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_purchases_brand_id_foreign` (`brand_id`),
  ADD KEY `report_purchases_category_id_foreign` (`category_id`),
  ADD KEY `report_purchases_product_id_foreign` (`product_id`),
  ADD KEY `report_purchases_transaction_purchase_id_foreign` (`transaction_purchase_id`);

--
-- Indexes for table `report_sales`
--
ALTER TABLE `report_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_sales_brand_id_foreign` (`brand_id`),
  ADD KEY `report_sales_category_id_foreign` (`category_id`),
  ADD KEY `report_sales_product_id_foreign` (`product_id`),
  ADD KEY `report_sales_transaction_sale_id_foreign` (`transaction_sale_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaction_purchases`
--
ALTER TABLE `transaction_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_purchases_product_id_foreign` (`product_id`);

--
-- Indexes for table `transaction_sales`
--
ALTER TABLE `transaction_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_sales_product_id_foreign` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `report_purchases`
--
ALTER TABLE `report_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `report_sales`
--
ALTER TABLE `report_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transaction_purchases`
--
ALTER TABLE `transaction_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaction_sales`
--
ALTER TABLE `transaction_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_purchases`
--
ALTER TABLE `report_purchases`
  ADD CONSTRAINT `report_purchases_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_purchases_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_purchases_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_purchases_transaction_purchase_id_foreign` FOREIGN KEY (`transaction_purchase_id`) REFERENCES `transaction_purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_sales`
--
ALTER TABLE `report_sales`
  ADD CONSTRAINT `report_sales_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_sales_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_sales_transaction_sale_id_foreign` FOREIGN KEY (`transaction_sale_id`) REFERENCES `transaction_sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_purchases`
--
ALTER TABLE `transaction_purchases`
  ADD CONSTRAINT `transaction_purchases_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_sales`
--
ALTER TABLE `transaction_sales`
  ADD CONSTRAINT `transaction_sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
