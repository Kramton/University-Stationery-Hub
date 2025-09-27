-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 01:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

CREATE DATABASE IF NOT EXISTS php_project;
USE php_project;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'admin@email.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(2, 'admin', 'admin@email.com', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(20) NOT NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`) VALUES
(1, 26.00, 'not paid', 1, '210779534', 'Auckland', '121 Mayoral Drive, Auckland CBD, Auckland1010, Auckland Central/ room 831', '2025-08-29 23:42:23'),
(2, 8.00, 'not paid', 7, '0', 'asdf', 'asdf', '2025-09-03 17:06:00'),
(3, 4.00, 'not paid', 2, '0', 'asdf', 'adfs', '2025-09-03 17:51:13'),
(4, 123.00, 'not paid', 2, '0', 'asdf', 'asdf', '2025-09-03 23:08:40'),
(5, 123.00, 'not paid', 4, '0', 'asdf', 'asdf', '2025-09-18 22:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `product_quantity`, `user_id`, `order_date`) VALUES
(1, 1, 9, '1B4 Exercise Book', '1B4_Ex_Book11.jpeg', 2.00, 13, 1, '2025-08-29 23:42:23'),
(2, 2, 16, 'A5 Polyurethane Notebook (blue)', 'A5 Polyurethane Notebook1.jpeg', 8.00, 1, 7, '2025-09-03 17:06:00'),
(3, 3, 15, 'A5 5 Subject Notebook (Black)', 'A5 5 Subject Notebook 1.jpeg', 4.00, 1, 2, '2025-09-03 17:51:13'),
(4, 4, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 2, '2025-09-03 23:08:40'),
(5, 5, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 4, '2025-09-18 22:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(250) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_special_offer` int(2) NOT NULL,
  `product_stock` int(11) NOT NULL DEFAULT 0,
  `product_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_special_offer`, `product_stock`, `product_color`) VALUES
(9, '1B4 Exercise Book (64 pages)', 'Writing Essentials', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 23cm (H) x 18cm (W) x 0.3 (D)\r\n•	Material: Paper\r\n•	Paper size: 1B4\r\n•	Page count: 64 pages\r\n\r\n', '1B4_Ex_Book11.jpeg', '1B4_Ex_Book12.jpeg', '1B4_Ex_Book13.jpeg', '1B4_Ex_Book14.jpeg', 2.00, 23, 10, 'white'),
(10, '1B5 Exercise Book (80 Page)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 25.5cm (H) x 20.5cm (W) x 0.4cm (D)\r\n•	Material: Paper Paper\r\n•	size: 1B5 Page \r\n•	count: 80 pages\r\n', '1B5 Exercise Book (80 Page)1.jpeg', '1B5 Exercise Book (80 Page)2.jpeg', '1B5 Exercise Book (80 Page)3.jpeg', '1B5 Exercise Book (80 Page)4.jpeg', 123.00, 30, 1211, 'white'),
(13, '250 Page A4 5 Tab Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 23.5cm (W) x 2cm (D)\r\n•	Material: Paper, iron, kappa board and polypropylene (PP)\r\n•	Paper size: A4\r\n•	Page count: 250 pages\r\n•	Paper thickness: 54GSM\r\n\r\n\r\n', '250 Page A4 5 Tab Notebook - Black1.jpeg', '250 Page A4 5 Tab Notebook - Black2.jpeg', '250 Page A4 5 Tab Notebook - Black3.jpeg', '250 Page A4 5 Tab Notebook - Black4.jpeg', 4.50, 0, 12, 'Black'),
(14, 'Spiral A4 Notebook (Kraft)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 21cm (W)\r\n•	Material: Paper, board and iron with powder coating\r\n•	Paper size: A4\r\n•	Page count: 160 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'Spiral A4 Notebook1.jpeg', 'Spiral A4 Notebook2.jpeg', 'Spiral A4 Notebook3.jpeg', 'Spiral A4 Notebook4.jpeg', 5.00, 10, 30, 'Kraft'),
(15, 'A5 5 Subject Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 17.2cm (W) x 2cm (D)\r\n•	Material: Front cover: Polypropylene (PP)\r\n•	Back cover: Kappa board\r\n•	Inner pages and separator: Paper\r\n•	Spiral: Iron\r\n•	Paper size: A5\r\n•	Page count: 250 pages\r\n•	Paper thickness: 58GSM\r\n\r\n\r\n', 'A5 5 Subject Notebook 1.jpeg', 'A5 5 Subject Notebook 2.jpeg', 'A5 5 Subject Notebook 3.jpeg', 'A5 5 Subject Notebook 4.jpeg', 4.20, 0, 20, 'Black'),
(16, 'A5 Polyurethane Notebook (blue)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 14.8cm (W)\r\n•	Material: Cover: Polyurethane (PU)\r\n•	Paper size: A5\r\n•	Page count: 240 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'A5 Polyurethane Notebook1.jpeg', 'A5 Polyurethane Notebook2.jpeg', 'A5 Polyurethane Notebook3.jpeg', 'A5 Polyurethane Notebook4.jpeg', 8.00, 0, 34, 'Navy blue'),
(17, 'Blu Tack', 'Desk Accessories', ' Blu Tack is the original reusable adhesive, suitable for use on non-porous surfaces such as vinyl coated wallpapers, painted surfaces, glass, metal and more.\r\n\r\n•	Net weight: 75g\r\n•	Dimensions/Size: 18cm (H) x 10.4cm (W) x 0.5cm (D)\r\n', 'Blu Tack1.jpeg', 'Blu Tack2.jpeg', 'Blu Tack3.jpeg', 'Blu Tack4.jpeg', 3.30, 0, 10, 'Blue'),
(18, '6 Pack Retractable Gel Pens (Black)', 'Writing Essentials', '•	6 Pack\r\n•	Tip size: 0.7mm (medium)\r\n•	Dimensions/Size: 14.6cm (H) x 1.51cm (Dia.)\r\n•	Material:\r\n        Barrel: Styrene-acrylonitrile resin\r\n        Push-button and clip: Acrylonitrile butadiene styrene (ABS)\r\n        Rotter: Derlin\r\n        Refill tube: Polypropylene (PP)\r\n        Tip: Stainless steel\r\n        Spring: Stainless steel\r\n        Grip: Elastomer\r\n\r\n', '6 Pack Retractable Gel Pens (Black)1.jpeg', '6 Pack Retractable Gel Pens (Black)2.jpeg', '6 Pack Retractable Gel Pens (Black)3.jpeg', '6 Pack Retractable Gel Pens (Black)4.jpeg', 4.00, 0, 23, 'Black'),
(19, '1 in 4-Color BallPen', 'Writing Essentials', '•  4-in-1 Ink Colours – Switch easily between red, blue, black & green\r\n•  Retractable Design – No caps, no mess, just click and write\r\n•  0.7 mm Fine Tip – For sharp, neat, and controlled writing\r\n', '1 in 4-Color BallPen1.jpeg', '1 in 4-Color BallPen2.jpeg', '1 in 4-Color BallPen3.jpeg', '1 in 4-Color BallPen4.jpeg', 3.00, 0, 50, 'red, blue, black , green');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `reset_token_hash`, `reset_token_expires_at`, `verification_token`, `is_verified`, `created_at`) VALUES
(1, 'pui ming vicnent yu', 'yupm20142014@gmail.com', '$2y$10$4TddE04eNrgU1uHdpzYoE.oxtblAf..F657QJp38XpfWwgroHn73u', NULL, NULL, NULL, 0, '2025-09-18 11:12:35'),
(5, 'john', 'universitystationeryhub@gmail.com', '$2y$10$Vso7PDabnFOpEb1ahq/0heIqqbkK0Fr/xYu1lqDbvyM/FNXcqW02W', NULL, NULL, NULL, 1, '2025-09-18 11:22:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UK_constraint` (`user_email`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--
CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `max_uses` int(11) NOT NULL DEFAULT 1000,
  `current_uses` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo_codes`
--
INSERT INTO `promo_codes` (`id`, `code`, `description`, `discount_type`, `discount_value`, `min_purchase`, `start_date`, `end_date`, `max_uses`, `current_uses`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AUT112', '$5 off for Autumn Sale', 'fixed', 5.00, 20.00, NULL, '2025-11-30 23:59:59', 500, 0, 1, '2025-09-18 12:00:00', '2025-09-18 12:00:00'),
(2, 'SAVE15', '15% off for orders over $50', 'percent', 15.00, 50.00, NULL, NULL, 1000, 0, 1, '2025-09-18 12:00:00', '2025-09-18 12:00:00'),
(3, 'OLDCODE', 'An old, disabled code', 'fixed', 10.00, 0.00, NULL, '2024-01-01 00:00:00', 1000, 0, 0, '2025-09-18 12:00:00', '2025-09-18 12:00:00');

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


