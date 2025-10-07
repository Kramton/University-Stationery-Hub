-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 12:21 PM
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
(1, 'admin', 'admin@email.com', '827ccb0eea8a706c4c34a16891f84e7b');

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
  `pickup_name` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Add ready_for_pickup column for admin dashboard checkbox
ALTER TABLE `orders` ADD COLUMN `ready_for_pickup` TINYINT(1) NOT NULL DEFAULT 0;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`) VALUES
(1, 26.00, 'not paid', 1, '210779534', 'Auckland', '121 Mayoral Drive, Auckland CBD, Auckland1010, Auckland Central/ room 831', '2025-08-29 23:42:23'),
(2, 8.00, 'not paid', 7, '0', 'asdf', 'asdf', '2025-09-03 17:06:00'),
(3, 4.00, 'not paid', 2, '0', 'asdf', 'adfs', '2025-09-03 17:51:13'),
(4, 123.00, 'not paid', 2, '0', 'asdf', 'asdf', '2025-09-03 23:08:40'),
(5, 123.00, 'not paid', 4, '0', 'asdf', 'asdf', '2025-09-18 22:51:40'),
(6, 4.50, 'paid', 6, '1234567890', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 18:37:57'),
(7, 10.00, 'paid', 6, '1234567890', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 18:52:19'),
(8, 12.50, 'Closed', 6, '1234567890', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 19:26:34'),
(9, 118.00, 'Closed', 12, '123', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 19:59:15'),
(10, 118.00, 'Closed', 12, 'dfsaf', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 20:02:54'),
(11, 4.50, 'Closed', 12, 'asdf', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 20:03:19'),
(12, 2.00, 'Closed', 12, 'asdf', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 20:08:54'),
(14, 2.00, 'Closed', 12, '1234', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 20:26:36'),
(15, 4.50, 'Closed', 12, 'asdf', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:03:46'),
(16, 7.30, 'Closed', 12, '09876543221', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:04:31'),
(17, 123.00, 'Open', 12, '123', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:14:15'),
(18, 12.00, 'Closed', 12, '123', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:19:15'),
(19, 72.00, 'Closed', 12, 'test', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:21:34'),
(20, 48.00, 'Closed', 12, '123', '', '55 Wellesley Street East, Auckland Central, Auckland 1010', '2025-10-01 21:22:01');

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
(5, 5, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 4, '2025-09-18 22:51:40'),
(6, 6, 13, '250 Page A4 5 Tab Notebook (Black)', '250 Page A4 5 Tab Notebook - Black1.jpeg', 4.50, 1, 6, '2025-10-01 18:37:57'),
(7, 7, 19, '1 in 4-Color BallPen', '1 in 4-Color BallPen1.jpeg', 3.00, 1, 6, '2025-10-01 18:52:19'),
(8, 7, 9, '1B4 Exercise Book (64 pages)', '1B4_Ex_Book11.jpeg', 2.00, 1, 6, '2025-10-01 18:52:19'),
(9, 7, 14, 'Spiral A4 Notebook (Kraft)', 'Spiral A4 Notebook1.jpeg', 5.00, 1, 6, '2025-10-01 18:52:19'),
(10, 8, 16, 'A5 Polyurethane Notebook (blue)', 'A5 Polyurethane Notebook1.jpeg', 8.00, 1, 6, '2025-10-01 19:26:34'),
(11, 8, 13, '250 Page A4 5 Tab Notebook (Black)', '250 Page A4 5 Tab Notebook - Black1.jpeg', 4.50, 1, 6, '2025-10-01 19:26:34'),
(12, 9, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 12, '2025-10-01 19:59:15'),
(13, 10, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 12, '2025-10-01 20:02:54'),
(14, 11, 13, '250 Page A4 5 Tab Notebook (Black)', '250 Page A4 5 Tab Notebook - Black1.jpeg', 4.50, 1, 12, '2025-10-01 20:03:19'),
(15, 12, 9, '1B4 Exercise Book (64 pages)', '1B4_Ex_Book11.jpeg', 2.00, 1, 12, '2025-10-01 20:08:54'),
(17, 14, 9, '1B4 Exercise Book (64 pages)', '1B4 Exercise Book (64 pages)1.jpeg', 2.00, 1, 12, '2025-10-01 20:26:36'),
(18, 15, 13, '250 Page A4 5 Tab Notebook (Black)', '250 Page A4 5 Tab Notebook - Black1.jpeg', 4.50, 1, 12, '2025-10-01 21:03:46'),
(19, 16, 17, 'Blu Tack', 'Blu Tack1.jpeg', 3.30, 1, 12, '2025-10-01 21:04:31'),
(20, 16, 18, '6 Pack Retractable Gel Pens (Black)', '6 Pack Retractable Gel Pens (Black)1.jpeg', 4.00, 1, 12, '2025-10-01 21:04:31'),
(21, 17, 10, '1B5 Exercise Book (80 Page)', '1B5 Exercise Book (80 Page)1.jpeg', 123.00, 1, 12, '2025-10-01 21:14:15'),
(22, 18, 28, 'test', 'test1.jpeg', 12.00, 1, 12, '2025-10-01 21:19:15'),
(23, 19, 29, 'test', 'test1.jpeg', 12.00, 6, 12, '2025-10-01 21:21:34'),
(24, 20, 29, 'test', 'test1.jpeg', 12.00, 4, 12, '2025-10-01 21:22:01');

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `user_id`, `transaction_id`, `payment_date`) VALUES
(1, 6, 6, 'SIM-4ACEE5576A30', '2025-10-01 18:38:31'),
(2, 6, 6, 'SIM-03B93FBA3F55', '2025-10-01 18:43:39'),
(3, 6, 6, 'SIM-53488F225661', '2025-10-01 18:43:56'),
(4, 6, 6, 'SIM-360C9F71AE3F', '2025-10-01 18:50:51'),
(5, 7, 6, 'SIM-F7273E3C2CE9', '2025-10-01 18:52:42'),
(6, 8, 6, 'SIM-72404BFBCC4E', '2025-10-01 19:26:59'),
(7, 9, 12, 'SIM-7BA3646AD1D0', '2025-10-01 19:59:38'),
(8, 10, 12, 'SIM-51F7C03A90E0', '2025-10-01 20:03:06'),
(9, 10, 12, 'SIM-B689EEE46AE2', '2025-10-01 20:03:10'),
(10, 11, 12, 'SIM-CB1D88752920', '2025-10-01 20:03:22'),
(11, 12, 12, 'SIM-86939BE49F83', '2025-10-01 20:08:57'),
(12, 14, 12, 'SIM-02A3CE3E0212', '2025-10-01 20:26:45'),
(13, 15, 12, 'SIM-8BEAF88599AF', '2025-10-01 21:03:50'),
(14, 16, 12, 'SIM-4D425DB287D3', '2025-10-01 21:06:45'),
(15, 18, 12, 'SIM-B7A7DD8CF525', '2025-10-01 21:19:20'),
(16, 19, 12, 'SIM-38605FF2C5B0', '2025-10-01 21:21:38'),
(17, 20, 12, 'SIM-BCAEE12B3073', '2025-10-01 21:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `card_name` varchar(255) NOT NULL,
  `card_last4` char(4) NOT NULL,
  `enc_card_number` text NOT NULL,
  `enc_card_cvc` text NOT NULL,
  `nonce_card` varchar(64) NOT NULL,
  `nonce_cvc` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_info`
--

INSERT INTO `payment_info` (`id`, `order_id`, `user_id`, `card_name`, `card_last4`, `enc_card_number`, `enc_card_cvc`, `nonce_card`, `nonce_cvc`, `created_at`) VALUES
(1, 6, 6, 'Jon Doe', '1111', '59ASjP+JOqvDjt7iX38F1Asv0x1mj8iBxuLprmeTM+0=', 'xbhoRsBMWAvABnxbpdFtow==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 05:50:51'),
(2, 7, 6, 'Cath', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'cI2RrT26z/cSZe6ShLlf2Q==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 05:52:42'),
(3, 8, 6, 'A Chen', '5678', '4Uic1McLgl0A0Myz2YerY5kGz6+32nFpSbYTCPixBus=', 'Lq+a3RLA1Bbp2BqxVEK7ew==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 06:26:59'),
(4, 9, 12, 'Mark', '1234', 'FRjHlhboI+zzG0ozD/CzCA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 06:59:38'),
(5, 10, 12, 'asfd', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 07:03:06'),
(6, 10, 12, 'asfd', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 07:03:10'),
(7, 11, 12, 'asdf', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 07:03:22'),
(8, 12, 12, 'asdf', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 07:08:57'),
(9, 14, 12, 'asdf', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 07:26:45'),
(10, 15, 12, 'asdf', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 08:03:50'),
(11, 16, 12, 'asdf', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'VfFjv8/LTJg+xfVeqpZ/xw==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 08:06:45'),
(12, 18, 12, 'tset', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 08:19:20'),
(13, 19, 12, 'test', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'GI/BxeCs2v3Edz/BTuWENA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 08:21:38'),
(14, 20, 12, 'r', '123', 'GI/BxeCs2v3Edz/BTuWENA==', 'unGZZCjskysTLP/bSabsyA==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', 'MTIzNDU2Nzg5MDEyMzQ1Ng==', '2025-10-01 08:22:05');

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
  `market_price` decimal(10,2) DEFAULT NULL,
  `product_stock` int(11) NOT NULL DEFAULT 0,
  `product_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_special_offer`, `market_price`, `product_stock`, `product_color`) VALUES
(9, '1B4 Exercise Book (64 pages)', 'Writing Essentials', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 23cm (H) x 18cm (W) x 0.3 (D)\r\n•	Material: Paper\r\n•	Paper size: 1B4\r\n•	Page count: 64 pages\r\n\r\n', '1B4 Exercise Book (64 pages)1.jpeg', '1B4 Exercise Book (64 pages)2.jpeg', '1B4 Exercise Book (64 pages)3.jpeg', '1B4 Exercise Book (64 pages)4.jpeg', 2.00, 0, 3.00, 10, 'white'),
(10, '1B5 Exercise Book (80 Page)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 25.5cm (H) x 20.5cm (W) x 0.4cm (D)\r\n•	Material: Paper Paper\r\n•	size: 1B5 Page \r\n•	count: 80 pages\r\n', '1B5 Exercise Book (80 Page)1.jpeg', '1B5 Exercise Book (80 Page)2.jpeg', '1B5 Exercise Book (80 Page)3.jpeg', '1B5 Exercise Book (80 Page)4.jpeg', 123.00, 0, 124.00, 1211, 'white'),
(13, '250 Page A4 5 Tab Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 23.5cm (W) x 2cm (D)\r\n•	Material: Paper, iron, kappa board and polypropylene (PP)\r\n•	Paper size: A4\r\n•	Page count: 250 pages\r\n•	Paper thickness: 54GSM\r\n\r\n\r\n', '250 Page A4 5 Tab Notebook - Black1.jpeg', '250 Page A4 5 Tab Notebook - Black2.jpeg', '250 Page A4 5 Tab Notebook - Black3.jpeg', '250 Page A4 5 Tab Notebook - Black4.jpeg', 4.50, 0, 6.00, 12, 'Black'),
(14, 'Spiral A4 Notebook (Kraft)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 21cm (W)\r\n•	Material: Paper, board and iron with powder coating\r\n•	Paper size: A4\r\n•	Page count: 160 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'Spiral A4 Notebook1.jpeg', 'Spiral A4 Notebook2.jpeg', 'Spiral A4 Notebook3.jpeg', 'Spiral A4 Notebook4.jpeg', 5.00, 0, 7.00, 30, 'Kraft'),
(15, 'A5 5 Subject Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 17.2cm (W) x 2cm (D)\r\n•	Material: Front cover: Polypropylene (PP)\r\n•	Back cover: Kappa board\r\n•	Inner pages and separator: Paper\r\n•	Spiral: Iron\r\n•	Paper size: A5\r\n•	Page count: 250 pages\r\n•	Paper thickness: 58GSM\r\n\r\n\r\n', 'A5 5 Subject Notebook 1.jpeg', 'A5 5 Subject Notebook 2.jpeg', 'A5 5 Subject Notebook 3.jpeg', 'A5 5 Subject Notebook 4.jpeg', 4.20, 0, 5.00, 20, 'Black'),
(16, 'A5 Polyurethane Notebook (blue)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 14.8cm (W)\r\n•	Material: Cover: Polyurethane (PU)\r\n•	Paper size: A5\r\n•	Page count: 240 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'A5 Polyurethane Notebook1.jpeg', 'A5 Polyurethane Notebook2.jpeg', 'A5 Polyurethane Notebook3.jpeg', 'A5 Polyurethane Notebook4.jpeg', 8.00, 0, 10.00, 34, 'Navy blue'),
(17, 'Blu Tack', 'Desk Accessories', ' Blu Tack is the original reusable adhesive, suitable for use on non-porous surfaces such as vinyl coated wallpapers, painted surfaces, glass, metal and more.\r\n\r\n•	Net weight: 75g\r\n•	Dimensions/Size: 18cm (H) x 10.4cm (W) x 0.5cm (D)\r\n', 'Blu Tack1.jpeg', 'Blu Tack2_68dcf012a1365.jpeg', 'Blu Tack3.jpeg', 'Blu Tack4.jpeg', 3.30, 0, 5.00, 10, 'Blue'),
(18, '6 Pack Retractable Gel Pens (Black)', 'Writing Essentials', '•	6 Pack\r\n•	Tip size: 0.7mm (medium)\r\n•	Dimensions/Size: 14.6cm (H) x 1.51cm (Dia.)\r\n•	Material:\r\n        Barrel: Styrene-acrylonitrile resin\r\n        Push-button and clip: Acrylonitrile butadiene styrene (ABS)\r\n        Rotter: Derlin\r\n        Refill tube: Polypropylene (PP)\r\n        Tip: Stainless steel\r\n        Spring: Stainless steel\r\n        Grip: Elastomer\r\n\r\n', '6 Pack Retractable Gel Pens (Black)1.jpeg', '6 Pack Retractable Gel Pens (Black)2.jpeg', '6 Pack Retractable Gel Pens (Black)3.jpeg', '6 Pack Retractable Gel Pens (Black)4.jpeg', 4.00, 0, 5.00, 23, 'Black'),
(19, '1 in 4-Color BallPen', 'Writing Essentials', '•  4-in-1 Ink Colours – Switch easily between red, blue, black & green\r\n•  Retractable Design – No caps, no mess, just click and write\r\n•  0.7 mm Fine Tip – For sharp, neat, and controlled writing\r\n', '1 in 4-Color BallPen1.jpeg', '1 in 4-Color BallPen2.jpeg', '1 in 4-Color BallPen3.jpeg', '1 in 4-Color BallPen4.jpeg', 3.00, 0, 5.00, 50, 'red, blue, black , green');

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
(1, 'AUT!12', '$5 off for Autumn Sale', 'fixed', 5.00, 20.00, NULL, '2024-11-30 23:59:00', 500, 0, 1, '2025-09-27 03:49:44', '2025-10-01 07:18:56'),
(2, 'SAVE15', '15% off for orders over $50', 'percent', 15.00, 50.00, NULL, NULL, 1000, 0, 1, '2025-09-27 03:49:44', '2025-09-29 09:57:02'),
(3, 'OLDCODE', 'An old, disabled code', 'fixed', 10.00, 0.00, NULL, '2023-01-01 00:00:00', 1000, 0, 0, '2025-09-27 03:49:44', '2025-09-27 03:49:44');

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
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `reset_token_hash`, `reset_token_expires_at`, `verification_token`, `is_verified`, `created_at`) VALUES
(1, 'pui ming vicnent yu', 'yupm20142014@gmail.com', '$2y$10$4TddE04eNrgU1uHdpzYoE.oxtblAf..F657QJp38XpfWwgroHn73u', NULL, NULL, NULL, 0, '2025-09-18 11:12:35'),
(5, 'john', 'universitystationeryhub@gmail.com', '$2y$10$Vso7PDabnFOpEb1ahq/0heIqqbkK0Fr/xYu1lqDbvyM/FNXcqW02W', NULL, NULL, NULL, 1, '2025-09-18 11:22:17'),
(6, 'volibear', 'kerkubuste@necub.com', '$2y$10$KrwpNE.kuOBvdj3Cikubn.wbmq92Qp93H.gYktUwmdDOvLAEDulUe', NULL, NULL, NULL, 1, '2025-09-24 04:44:58'),
(7, 'volibear', 'curkebirki@necub.com', '$2y$10$vgqoaSpY6x/.bgmd785xqO2MNeLTv07n5jbRTtpJP6q3DqmYUXLPy', NULL, NULL, NULL, 1, '2025-09-30 08:04:19'),
(8, 'volibears volibears', 'kepsocirtu@necub.com', '$2y$10$tKqMOROZTUOWk2SjWrRNUOnz7BDKNrmxIwtVJi.tuNzSP8fTdC9GG', NULL, NULL, NULL, 1, '2025-09-30 08:24:35'),
(9, 'volibear', 'cilmorapsi@necub.com', '$2y$10$ippKTakHh0NUNtDRfjEQceZPvSk9kFYiuH1FKy4TbL.Iajr.LpYaq', NULL, NULL, '2c2b14030fc792c5d2f7b2381078b5ea7f138eba943882dcb5f3ecf31d56160a', 0, '2025-10-01 04:10:27'),
(10, 'volibear', 'fafyucapso@necub.com', '$2y$10$Fm0iU0zxgm87.z15ezx.S.O6f.mJOD17iMM3BjGB8Ov8DCDUiyHPe', NULL, NULL, 'a51c796b858d5171be9f3e14b3b32e4b8468223c082c7e40402d7100fff7c33c', 0, '2025-10-01 04:11:35'),
(11, 'cc', 'qqmelonqq@gmail.com', '$2y$10$/dNL3e0nx/caBSEFOX3EU.8E9vA45uEIS3JSoYez8FsSA8o.7qUqe', NULL, NULL, NULL, 1, '2025-10-01 06:36:52');

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
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
