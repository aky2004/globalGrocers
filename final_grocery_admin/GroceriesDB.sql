-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 16, 2025 at 05:32 PM
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
-- Database: `GroceriesDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Preet', '$2y$10$Hf3m0YikcCP3eyKi6pJoAuFxW.jRSZe7XTJrlvr/98F2RZhwJCiUm', 'preet126@gmail.com', '2025-04-16 10:56:11', '2025-04-16 10:56:11'),
(2, 'Aman', '$2y$10$xptMpobHYS4Ntmak2GaW4uTvRDf.wTg4do9d6Ybl0zZWNFI226V/C', 'aky123@gmail.com', '2025-04-16 15:13:48', '2025-04-16 15:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `user_id`, `action`, `created_at`) VALUES
(1, 1, 'Admin logged in', '2025-04-16 10:57:49'),
(2, 1, 'Admin logged in', '2025-04-16 12:21:11'),
(3, 1, 'Admin logged in', '2025-04-16 12:24:28'),
(4, 1, 'Admin logged in', '2025-04-16 12:27:53'),
(5, 1, 'Admin logged in', '2025-04-16 12:28:18'),
(6, 1, 'Admin logged in', '2025-04-16 12:53:42'),
(7, 1, 'Admin logged in', '2025-04-16 13:15:13'),
(8, 1, 'Admin logged in', '2025-04-16 13:16:57'),
(9, 1, 'Admin logged in', '2025-04-16 15:09:03'),
(10, 2, 'Admin logged in', '2025-04-16 15:14:10'),
(11, 2, 'Admin logged in', '2025-04-16 15:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `bg_color` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `name`, `icon`, `description`, `bg_color`, `created_at`, `updated_at`) VALUES
(1, 'fruits', 'Fruits', '🍎', 'Fresh seasonal fruits', '#C8E6C9', '2025-04-16 11:08:59', '2025-04-16 12:10:16'),
(2, 'dairy', 'Dairy', '🥛', 'Milk, cheese & yogurt', '#E0E0FF', '2025-04-16 11:08:59', '2025-04-16 12:12:57'),
(3, 'bakery', 'Bakery', '🍞', 'Fresh baked goods', '#FFEDB8', '2025-04-16 11:08:59', '2025-04-16 12:14:50'),
(4, 'meat', 'Meat', '🥩', 'Fresh & quality meats', '#FBB7C8', '2025-04-16 11:08:59', '2025-04-16 12:15:27'),
(5, 'frozen', 'Frozen', '❄️', 'Frozen meals & treats', '#E0F7FA', '2025-04-16 11:08:59', '2025-04-16 11:08:59'),
(6, 'pantry', 'Pantry', '🥫', 'Essential kitchen staples', '#FFF3E0', '2025-04-16 11:08:59', '2025-04-16 11:08:59'),
(7, 'beverages', 'Beverages', '🍹', 'Drinks & refreshments', '#FFD6FF', '2025-04-16 11:08:59', '2025-04-16 12:16:07'),
(8, 'snacks', 'Snacks', '🍿', 'Chips, nuts & more', '#FFFDE7', '2025-04-16 11:08:59', '2025-04-16 11:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `payment_method` enum('credit_card','debit_card','paypal','cash_on_delivery') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `shipping_address`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 1, 763.84, 'pending', '123 Grocery Street, City, State 12345', 'credit_card', '2025-04-16 11:05:16', '2025-04-16 11:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`quantity` * `unit_price`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `rating` decimal(3,1) NOT NULL,
  `description` text NOT NULL,
  `is_new` tinyint(1) DEFAULT 0,
  `is_sale` tinyint(1) DEFAULT 0,
  `category_id` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `original_price`, `image`, `rating`, `description`, `is_new`, `is_sale`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Organic Avocados', 414.17, NULL, '../images/avocado.jpg', 4.8, 'Fresh and ripe organic avocados', 1, 0, 'fruits', '2025-04-16 11:13:19', '2025-04-16 11:13:19'),
(2, 'Fresh Strawberries', 289.67, 414.17, '../images/strawberry.jpg', 4.6, 'Sweet and juicy strawberries', 0, 1, 'fruits', '2025-04-16 11:13:19', '2025-04-16 11:13:19'),
(3, 'Fresh Spinach', 248.17, NULL, 'https://images.unsplash.com/photo-1603833665858-e61d17a86224', 4.7, 'Organic baby spinach leaves', 0, 0, 'fruits', '2025-04-16 11:13:19', '2025-04-16 11:13:19'),
(4, 'Organic Bell Peppers', 331.17, NULL, 'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83', 4.5, 'Colorful organic bell peppers', 1, 0, 'fruits', '2025-04-16 11:13:19', '2025-04-16 11:13:19'),
(5, 'Organic Milk', 372.67, NULL, '../images/milk.jpg', 4.9, 'Fresh organic whole milk', 0, 0, 'dairy', '2025-04-16 11:14:45', '2025-04-16 11:14:45'),
(6, 'Greek Yogurt', 331.17, NULL, '../images/yogurt.jpg', 4.7, 'Creamy Greek-style yogurt', 1, 0, 'dairy', '2025-04-16 11:14:45', '2025-04-16 11:14:45'),
(7, 'Free-Range Eggs', 497.17, NULL, 'https://images.unsplash.com/photo-1598965402089-897ce52e8355', 4.8, 'Farm-fresh free-range eggs', 0, 0, 'dairy', '2025-04-16 11:14:45', '2025-04-16 11:14:45'),
(8, 'Artisan Cheese Selection', 746.17, 912.17, 'https://images.unsplash.com/photo-1452195100486-9cc805987862', 4.9, 'Premium cheese assortment', 0, 1, 'dairy', '2025-04-16 11:14:45', '2025-04-16 11:14:45'),
(9, 'Sourdough Bread', 580.17, NULL, '../images/bread.jpg', 4.9, 'Artisanal sourdough bread', 0, 0, 'bakery', '2025-04-16 11:17:02', '2025-04-16 11:17:02'),
(10, 'Butter Croissants', 206.67, 331.17, 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35', 4.7, 'Fresh-baked butter croissants', 0, 1, 'bakery', '2025-04-16 11:17:02', '2025-04-16 11:17:02'),
(11, 'French Baguette', 289.67, NULL, '../images/rolls.jpg', 4.6, 'Traditional French baguette', 0, 0, 'bakery', '2025-04-16 11:17:02', '2025-04-16 11:17:02'),
(12, 'Cinnamon Rolls', 414.17, NULL, 'https://images.unsplash.com/photo-1509365465985-25d11c17e812', 4.8, 'Fresh-baked cinnamon rolls', 1, 0, 'bakery', '2025-04-16 11:17:02', '2025-04-16 11:17:02'),
(13, 'Fresh Salmon Fillet', 1078.17, NULL, 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369', 4.8, 'Premium Atlantic salmon fillet', 1, 0, 'meat', '2025-04-16 11:17:16', '2025-04-16 11:17:16'),
(14, 'Organic Chicken Breast', 746.17, NULL, 'https://images.unsplash.com/photo-1604503468506-a8da13d82791', 4.7, 'Free-range organic chicken breast', 0, 0, 'meat', '2025-04-16 11:17:16', '2025-04-16 11:17:16'),
(15, 'Premium Ground Beef', 663.17, 829.17, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&q=80', 4.6, 'Fresh ground beef, 90% lean', 0, 1, 'meat', '2025-04-16 11:17:16', '2025-04-16 11:17:16'),
(16, 'Fresh Shrimp', 1327.17, NULL, 'https://images.unsplash.com/photo-1623855244183-52fd8d3ce2f7?auto=format&fit=crop&q=80', 4.8, 'Wild-caught jumbo shrimp', 1, 0, 'meat', '2025-04-16 11:17:16', '2025-04-16 11:17:16'),
(17, 'Mixed Vegetables', 331.17, NULL, 'https://images.unsplash.com/photo-1584473457406-6240486418e9', 4.5, 'Premium frozen vegetable mix', 0, 0, 'frozen', '2025-04-16 11:18:28', '2025-04-16 11:18:28'),
(18, 'Ice Cream Collection', 497.17, 663.17, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb', 4.8, 'Assorted ice cream flavors', 0, 1, 'frozen', '2025-04-16 11:18:28', '2025-04-16 11:18:28'),
(19, 'Pizza Pack', 829.17, NULL, 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38', 4.6, 'Ready-to-bake frozen pizzas', 1, 0, 'frozen', '2025-04-16 11:18:28', '2025-04-16 11:18:28'),
(20, 'Frozen Berry Mix', 580.17, NULL, 'https://images.unsplash.com/photo-1563746098251-d35aef196e83', 4.7, 'Premium mixed berries', 1, 0, 'frozen', '2025-04-16 11:18:28', '2025-04-16 11:18:28'),
(21, 'Organic Pasta', 248.17, NULL, 'https://images.unsplash.com/photo-1551462147-37885acc36f1', 4.7, 'Premium Italian pasta', 0, 0, 'pantry', '2025-04-16 11:19:27', '2025-04-16 11:19:27'),
(22, 'Extra Virgin Olive Oil', 995.17, 1244.17, 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5', 4.9, 'Cold-pressed olive oil', 0, 1, 'pantry', '2025-04-16 11:19:27', '2025-04-16 11:19:27'),
(23, 'Quinoa Pack', 580.17, NULL, 'https://images.unsplash.com/photo-1586201375761-83865001e31c', 4.6, 'Organic white quinoa', 1, 0, 'pantry', '2025-04-16 11:19:27', '2025-04-16 11:19:27'),
(24, 'Organic Honey', 746.17, NULL, 'https://images.unsplash.com/photo-1587049352846-4a222e784d38', 4.8, 'Raw organic honey', 1, 0, 'pantry', '2025-04-16 11:19:27', '2025-04-16 11:19:27'),
(25, 'Cold Brew Coffee', 414.17, NULL, 'https://images.unsplash.com/photo-1517701604599-bb29b565090c', 4.8, 'Smooth cold brew coffee', 1, 0, 'beverages', '2025-04-16 11:20:07', '2025-04-16 11:20:07'),
(26, 'Green Tea Collection', 663.17, 829.17, 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5', 4.7, 'Organic green tea varieties', 0, 1, 'beverages', '2025-04-16 11:20:07', '2025-04-16 11:20:07'),
(27, 'Fresh Orange Juice', 497.17, NULL, 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b', 4.9, 'Freshly squeezed orange juice', 0, 0, 'beverages', '2025-04-16 11:20:07', '2025-04-16 11:20:07'),
(28, 'Sparkling Water Pack', 1078.17, NULL, 'https://images.unsplash.com/photo-1523362628745-0c100150b504', 4.6, 'Assorted flavored sparkling water', 0, 1, 'beverages', '2025-04-16 11:20:07', '2025-04-16 11:20:07'),
(29, 'Mixed Nuts', 746.17, NULL, 'https://images.unsplash.com/photo-1536591375624-f1a7cfb59c07', 4.8, 'Premium roasted nut mix', 1, 0, 'snacks', '2025-04-16 11:21:22', '2025-04-16 11:21:22'),
(30, 'Potato Chips', 206.67, 289.67, 'https://images.unsplash.com/photo-1566478989037-eec170784d0b', 4.6, 'Crispy kettle-cooked chips', 0, 1, 'snacks', '2025-04-16 11:21:22', '2025-04-16 11:21:22'),
(31, 'Dark Chocolate', 414.17, NULL, 'https://images.unsplash.com/photo-1548907040-4d2be0667d63', 4.9, '72% cocoa dark chocolate', 0, 0, 'snacks', '2025-04-16 11:21:22', '2025-04-16 11:21:22'),
(32, 'Trail Mix', 580.17, NULL, 'https://images.unsplash.com/photo-1599042891382-c8d3fc8d9861', 4.7, 'Premium dried fruits and nuts mix', 1, 0, 'snacks', '2025-04-16 11:21:22', '2025-04-16 11:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `preferences` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `profile_image`, `updated_at`, `phone`, `address`, `preferences`) VALUES
(1, 'Preet Rana', 'preetrana1263@gmail.com', '$2y$10$6eLk5nVVjkEq0zY2pkY0huRgzqcl798Saa6ZFi14zWwWtMfRdsJNm', '2025-04-15 10:47:03', 'uploads/1744732584_WhatsApp Image 2025-03-21 at 23.12.05.jpeg', '2025-04-15 21:26:39', NULL, NULL, NULL),
(2, 'Preet Rana', 'preet123@gmail.com', '$2y$10$ukSm1pEjPxQS/L1BtO5tyOP7ZyOSFwqgjnsMVlThjklMZvHD5JMWK', '2025-04-15 10:57:49', 'uploads/1744740592_img-4.jpg', '2025-04-15 23:45:11', NULL, NULL, NULL),
(3, 'Aky', 'aky123@gmail.com', '$2y$10$Qsh0ih9kcTLYY04D.3zMhuYwEn7kdpdMvn1EST2Doy90TyoXP27SO', '2025-04-15 12:17:24', NULL, '2025-04-15 17:47:24', NULL, NULL, NULL),
(5, 'Raihan Alam', 'raihan123@gmail.com', '$2y$10$OuJ/.we8EgdpL3AvbFssu.mawXMK6cfCtz3YiLw8fvCfvimXe1EM6', '2025-04-16 08:56:46', 'uploads/1744793872_img-1.jpg', '2025-04-16 18:20:58', '', '', NULL),
(6, 'Ishu Yadav', 'ishuyad123@gmail.com', '$2y$10$DRKFs6oqD4NFuFtdVrCY3uQ.c2dDOVW6k9a7P5GvJnF/ERUfS1/5m', '2025-04-16 12:52:21', NULL, '2025-04-16 18:22:21', NULL, NULL, NULL),
(8, 'Hardeep', 'hardeep123@gmail.com', '$2y$10$q2y7orvwUepnCZUBoIJMkOE5JhWxRts5QeTvhYJNdf.MnTaRyM/dC', '2025-04-16 15:27:03', NULL, '2025-04-16 20:57:03', NULL, NULL, NULL),
(9, 'Preet', 'preet1263@gmail.com', '$2y$10$T6UINp9Ib64U/4LD5whueOxOiaTQRHv2H0Tdc6.XW.RXdIW8jImGy', '2025-04-16 15:30:34', NULL, '2025-04-16 21:00:34', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
