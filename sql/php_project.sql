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
(9, '1B4 Exercise Book (64 pages)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 23cm (H) x 18cm (W) x 0.3 (D)\r\n•	Material: Paper\r\n•	Paper size: 1B4\r\n•	Page count: 64 pages\r\n\r\n', '1B4 Exercise Book (64 pages)1.jpeg', '1B4 Exercise Book (64 pages)2.jpeg', '1B4 Exercise Book (64 pages)3.jpeg', '1B4 Exercise Book (64 pages)4.jpeg', 2.00, 0, 3.00, 10, ''),
(10, '1B5 Exercise Book (80 Page)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 25.5cm (H) x 20.5cm (W) x 0.4cm (D)\r\n•	Material: Paper Paper\r\n•	size: 1B5 Page \r\n•	count: 80 pages\r\n', '1B5 Exercise Book (80 Page)1.jpeg', '1B5 Exercise Book (80 Page)2.jpeg', '1B5 Exercise Book (80 Page)3.jpeg', '1B5 Exercise Book (80 Page)4.jpeg', 123.00, 0, 124.00, 1211, ''),
(13, '250 Page A4 5 Tab Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 23.5cm (W) x 2cm (D)\r\n•	Material: Paper, iron, kappa board and polypropylene (PP)\r\n•	Paper size: A4\r\n•	Page count: 250 pages\r\n•	Paper thickness: 54GSM\r\n\r\n\r\n', '250 Page A4 5 Tab Notebook - Black1.jpeg', '250 Page A4 5 Tab Notebook - Black2.jpeg', '250 Page A4 5 Tab Notebook - Black3.jpeg', '250 Page A4 5 Tab Notebook - Black4.jpeg', 4.50, 0, 6.00, 12, ''),
(14, 'Spiral A4 Notebook (Kraft)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 21cm (W)\r\n•	Material: Paper, board and iron with powder coating\r\n•	Paper size: A4\r\n•	Page count: 160 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'Spiral A4 Notebook1.jpeg', 'Spiral A4 Notebook2.jpeg', 'Spiral A4 Notebook3.jpeg', 'Spiral A4 Notebook4.jpeg', 5.00, 0, 7.00, 30, ''),
(15, 'A5 5 Subject Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 17.2cm (W) x 2cm (D)\r\n•	Material: Front cover: Polypropylene (PP)\r\n•	Back cover: Kappa board\r\n•	Inner pages and separator: Paper\r\n•	Spiral: Iron\r\n•	Paper size: A5\r\n•	Page count: 250 pages\r\n•	Paper thickness: 58GSM\r\n\r\n\r\n', 'A5 5 Subject Notebook 1.jpeg', 'A5 5 Subject Notebook 2.jpeg', 'A5 5 Subject Notebook 3.jpeg', 'A5 5 Subject Notebook 4.jpeg', 4.20, 0, 5.00, 20, ''),
(16, 'A5 Polyurethane Notebook (blue)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 14.8cm (W)\r\n•	Material: Cover: Polyurethane (PU)\r\n•	Paper size: A5\r\n•	Page count: 240 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'A5 Polyurethane Notebook1.jpeg', 'A5 Polyurethane Notebook2.jpeg', 'A5 Polyurethane Notebook3.jpeg', 'A5 Polyurethane Notebook4.jpeg', 8.00, 0, 10.00, 34, ''),
(17, 'Blu Tack', 'Desk Accessories', ' Blu Tack is the original reusable adhesive, suitable for use on non-porous surfaces such as vinyl coated wallpapers, painted surfaces, glass, metal and more.\r\n\r\n•	Net weight: 75g\r\n•	Dimensions/Size: 18cm (H) x 10.4cm (W) x 0.5cm (D)\r\n', 'Blu Tack1.jpeg', 'Blu Tack2_68dcf012a1365.jpeg', 'Blu Tack3.jpeg', 'Blu Tack4.jpeg', 3.30, 5, 5.00, 10, ''),
(18, '6 Pack Retractable Gel Pens (Black)', 'Writing Essentials', '•	6 Pack\r\n•	Tip size: 0.7mm (medium)\r\n•	Dimensions/Size: 14.6cm (H) x 1.51cm (Dia.)\r\n•	Material:\r\n        Barrel: Styrene-acrylonitrile resin\r\n        Push-button and clip: Acrylonitrile butadiene styrene (ABS)\r\n        Rotter: Derlin\r\n        Refill tube: Polypropylene (PP)\r\n        Tip: Stainless steel\r\n        Spring: Stainless steel\r\n        Grip: Elastomer\r\n\r\n', '6 Pack Retractable Gel Pens (Black)1.jpeg', '6 Pack Retractable Gel Pens (Black)2.jpeg', '6 Pack Retractable Gel Pens (Black)3.jpeg', '6 Pack Retractable Gel Pens (Black)4.jpeg', 4.00, 0, 5.00, 23, ''),
(19, '1 in 4-Color BallPen', 'Writing Essentials', '•  4-in-1 Ink Colours – Switch easily between red, blue, black & green\r\n•  Retractable Design – No caps, no mess, just click and write\r\n•  0.7 mm Fine Tip – For sharp, neat, and controlled writing\r\n', '1 in 4-Color BallPen1.jpeg', '1 in 4-Color BallPen2.jpeg', '1 in 4-Color BallPen3.jpeg', '1 in 4-Color BallPen4.jpeg', 3.00, 0, 5.00, 50, ''),
(34, 'Plastic Ruler 30cm Clear', 'Study Tools', 'This Plastic Ruler is a clear ruler perfect for use at school, home or in the office to rule those straight lines. Its 30cm size makes it easy to carry in your pencil case when you\'re on the move. Rulers have bevelled edges for clean, straight lines and graduations are in millimeters and centimeters.\r\n\r\n-30 cm ruler allowing easy storage\r\n-Measurements on both edges (top and bottom)\r\n-mm on one edge and cm the other edge\r\nAlternatives', 'Plastic Ruler 30cm Clear1.jpeg', 'Plastic Ruler 30cm Clear2.jpeg', 'Plastic Ruler 30cm Clear3.jpeg', 'Plastic Ruler 30cm Clear4.jpeg', 0.99, 0, 1.00, 100, ''),
(35, 'Push Pins Assorted Colour - 80 Pac', 'Creative Supplies', '80 pack\r\nDimensions/Size: 2.4cm (L) x 0.9cm (H) x 0.9cm (W)\r\nMaterial: Metal and polystyrene (PS)\r\nColour: Blue, Green, Orange, White', 'Push Pins Assorted Colour - 80 Pac1.jpeg', 'Push Pins Assorted Colour - 80 Pac2.jpeg', 'Push Pins Assorted Colour - 80 Pac3.jpeg', 'Push Pins Assorted Colour - 80 Pac4.jpeg', 2.00, 0, 4.00, 3, ''),
(36, 'Rubber Bands - 80', 'Creative Supplies', 'Net weight: 80g\r\nDimensions/Size: 4.9cm (L) x 1.7cm (H) x 5cm (W)\r\nMaterial: Rubber\r\nSize no. 16', 'Rubber Bands - 801.jpeg', 'Rubber Bands - 802.jpeg', 'Rubber Bands - 803.jpeg', 'Rubber Bands - 804.jpeg', 1.99, 0, 2.00, 45, ''),
(37, 'Scissors 7in', 'Creative Supplies', 'These scissors can cut paper, remove tags, snip string or ribbon and more.\r\n\r\nDimensions/Size: 17.5cm (L)\r\nMaterial: Plastic and metal\r\nColour: Blue', 'Scissors 7in1.jpeg', 'Scissors 7in2.jpeg', 'Scissors 7in3.jpeg', 'Scissors 7in4.jpeg', 2.00, 0, 2.99, 40, ''),
(38, 'Plastic Stapler ', 'Creative Supplies', 'This stapler set is perfect for home or office use.\r\n\r\nIncludes 1 stapler with 500 pieces of 26/6\r\nMaterial: Pin, metal, plastic parts\r\nColour: Black', 'Plastic Stapler 1.jpeg', 'Plastic Stapler 2.jpeg', 'Plastic Stapler 3.jpeg', 'Plastic Stapler 4.jpeg', 12.99, 0, 15.00, 10, ''),
(39, 'Tape with Dispenser ', 'Desk Accessories', '3 pack\r\nDimensions/Size:\r\n2 rolls: 30m (L) x 1.8cm (W)\r\n1 roll: 40m (L) x 1.8cm (W)\r\nMaterial: Plastic (dispenser)\r\nColour: Clear\r\nFeatures:\r\nTape with dispenser\r\n3 clear tape rolls', 'Tape with Dispenser 1.jpeg', 'Tape with Dispenser 2.jpeg', 'Tape with Dispenser 3.jpeg', 'Tape with Dispenser 4.jpeg', 5.00, 0, 7.00, 5, ''),
(40, 'Calculator Casia FC-82MSC', 'Study Tools', 'Includes case\r\nDimensions/Size: 16.5cm (H) x 8.4cm (W) x 1.7cm (D)\r\nMaterial: \r\nKey: Acrylonitrile butadiene styrene (ABS)\r\nPrinted circuit board\r\nBattery information: Requires 1 x 1.5V L1154 (LR44) button cell battery (included)\r\nColour: Silver\r\n\r\n10+2 digits\r\nDual-powered for consistent performance\r\nIdeal for maths and science use\r\nStatistical computing\r\n2-line display\r\n12 digit display\r\n240 functions including: Fraction computing and conversion, coordinates conversion, multi lines replay, statistical computing, random number generation, final answer memory (ans) and independent memory, decimal system / sexagesimal and system function \r\n', 'Calculator Casia FC-82MSC1.jpeg', 'Calculator Casia FC-82MSC2.jpeg', 'Calculator Casia FC-82MSC3.jpeg', 'Calculator Casia FC-82MSC4.jpeg', 18.99, 5, 22.00, 5, ''),
(41, 'A4 Paper White - 80 gsm', 'Desk Accessories', 'A4 White Photocopy Paper offers reliable performance for everyday printing and copying tasks. \r\nWith its bright white finish and smooth surface, this paper is suitable for use in printers, copiers, and fax machines, making it ideal for offices, schools, and home use.\r\n\r\n', 'A4 Paper White - 80 gsm1_68ff3864c7926.jpeg', 'A4 Paper White - 80 gsm2_68ff3864c7a97.jpeg', 'A4 Paper White - 80 gsm3_68ff3864c7b86.jpeg', 'A4 Paper White - 80 gsm4_68ff3864c7c53.jpeg', 8.00, 10, 9.00, 100, ''),
(42, 'Faber Castell White Plastic Eraser Dust - 2 Pack', 'Desk Accessories', 'The dust-free eraser of Faber-Castell guarantees clean, soft and lubrication-free erasers. Less eraser is created because the eraser remains roll up. The quality eraser in white does not contain any dangerous dyes.\r\n\r\nPlastic eraser for clean and soft erasers\r\nLess eraser waste\r\nDoes not contain hazardous substances\r\nThe quality eraser guarantees lubrication-free erasers\r\nColor: white', 'Faber Castell White Plastic Eraser Dust - 2 Pack1.jpeg', 'Faber Castell White Plastic Eraser Dust - 2 Pack2.jpeg', 'Faber Castell White Plastic Eraser Dust - 2 Pack3.jpeg', 'Faber Castell White Plastic Eraser Dust - 2 Pack4.jpeg', 4.00, 0, 5.00, 30, ''),
(43, 'REEVES Drawing Complete Set', 'Creative Supplies', 'REEVES Drawing Complete Set is all you need to get started with drawing.\r\n\r\nThis 23pc set includes:\r\n\r\n4 x sketching pencils\r\n10 x colour pencils\r\n1 x graphite pencil\r\n1 x pencil sharpener\r\n1 x eraser\r\n2 x blending stumps\r\n3 x paper sheets\r\n1 x sandpaper block (for the blending stumps)', 'REEVES Drawing Complete Set1.jpeg', 'REEVES Drawing Complete Set2.jpeg', 'REEVES Drawing Complete Set3.jpeg', 'REEVES Drawing Complete Set4.jpeg', 43.50, 0, 49.00, 5, ''),
(44, '10 Pack Marker Sticky Notes', 'Study Tools', 'Includes 10 x 20 sheets\r\n10 pack\r\nDimensions/Size: 21.3cm (H) x 8.8cm (W) x 0.1cm (D)\r\nMaterial: Polyethylene terephthalate (PET), polypropylene (PP) and glue\r\n', '10 Pack Marker Sticky Notes1.jpeg', '10 Pack Marker Sticky Notes2.jpeg', '10 Pack Marker Sticky Notes3.jpeg', '10 Pack Marker Sticky Notes4.jpeg', 2.00, 0, 2.00, 100, '');

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `max_uses` int(11) NOT NULL DEFAULT 1000,
  `current_uses` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`), 
  UNIQUE KEY `code` (`code`) 
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
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`), 
  UNIQUE KEY `UK_constraint` (`user_email`), 
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Table structure for table 'user_promo_code_usage'
--

CREATE TABLE `user_promo_code_usage` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `promo_code_id` INT(11) NOT NULL,
  `used_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_promo_code`
    FOREIGN KEY (`promo_code_id`)
    REFERENCES `promo_codes` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `unique_user_promo_code`
    UNIQUE (`user_id`, `promo_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
