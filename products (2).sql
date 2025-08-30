-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 07:16 AM
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
-- Database: `php_project`
--

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
(9, '1B4 Exercise Book (64 pages)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 23cm (H) x 18cm (W) x 0.3 (D)\r\n•	Material: Paper\r\n•	Paper size: 1B4\r\n•	Page count: 64 pages\r\n\r\n', '1B4_Ex_Book11.jpeg', '1B4_Ex_Book12.jpeg', '1B4_Ex_Book13.jpeg', '1B4_Ex_Book14.jpeg', 2.00, 23, 1, 'white'),
(10, '1B5 Exercise Book (80 Page)', 'Notebooks & Paper', '•	Suitable for ages: 3+ years\r\n•	Dimensions/Size: 25.5cm (H) x 20.5cm (W) x 0.4cm (D)\r\n•	Material: Paper Paper\r\n•	size: 1B5 Page \r\n•	count: 80 pages\r\n', '1B5 Exercise Book (80 Page)1.jpeg', '1B5 Exercise Book (80 Page)2.jpeg', '1B5 Exercise Book (80 Page)3.jpeg', '1B5 Exercise Book (80 Page)4.jpeg', 123.00, 30, 1211, 'white'),
(13, '250 Page A4 5 Tab Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 23.5cm (W) x 2cm (D)\r\n•	Material: Paper, iron, kappa board and polypropylene (PP)\r\n•	Paper size: A4\r\n•	Page count: 250 pages\r\n•	Paper thickness: 54GSM\r\n\r\n\r\n', '250 Page A4 5 Tab Notebook - Black1.jpeg', '250 Page A4 5 Tab Notebook - Black2.jpeg', '250 Page A4 5 Tab Notebook - Black3.jpeg', '250 Page A4 5 Tab Notebook - Black4.jpeg', 4.50, 0, 12, 'Black'),
(14, 'Spiral A4 Notebook (Kraft)', 'Notebooks & Paper', '•	Dimensions/Size: 29.7cm (H) x 21cm (W)\r\n•	Material: Paper, board and iron with powder coating\r\n•	Paper size: A4\r\n•	Page count: 160 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'Spiral A4 Notebook1.jpeg', 'Spiral A4 Notebook2.jpeg', 'Spiral A4 Notebook3.jpeg', 'Spiral A4 Notebook4.jpeg', 5.00, 10, 30, 'Kraft'),
(15, 'A5 5 Subject Notebook (Black)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 17.2cm (W) x 2cm (D)\r\n•	Material: Front cover: Polypropylene (PP)\r\n•	Back cover: Kappa board\r\n•	Inner pages and separator: Paper\r\n•	Spiral: Iron\r\n•	Paper size: A5\r\n•	Page count: 250 pages\r\n•	Paper thickness: 58GSM\r\n\r\n\r\n', 'A5 5 Subject Notebook 1.jpeg', 'A5 5 Subject Notebook 2.jpeg', 'A5 5 Subject Notebook 3.jpeg', 'A5 5 Subject Notebook 4.jpeg', 4.20, 0, 20, 'Black'),
(16, 'A5 Polyurethane Notebook (blue)', 'Notebooks & Paper', '•	Dimensions/Size: 21cm (H) x 14.8cm (W)\r\n•	Material: Cover: Polyurethane (PU)\r\n•	Paper size: A5\r\n•	Page count: 240 pages\r\n•	Paper thickness: 80GSM\r\n\r\n', 'A5 Polyurethane Notebook1.jpeg', 'A5 Polyurethane Notebook2.jpeg', 'A5 Polyurethane Notebook3.jpeg', 'A5 Polyurethane Notebook4.jpeg', 8.00, 0, 34, 'Navy blue'),
(17, 'Blu Tack', 'Desk Accessories', ' Blu Tack is the original reusable adhesive, suitable for use on non-porous surfaces such as vinyl coated wallpapers, painted surfaces, glass, metal and more.\r\n\r\n•	Net weight: 75g\r\n•	Dimensions/Size: 18cm (H) x 10.4cm (W) x 0.5cm (D)\r\n', 'Blu Tack1.jpeg', 'Blu Tack2.jpeg', 'Blu Tack3.jpeg', 'Blu Tack4.jpeg', 3.30, 0, 10, 'Blue'),
(18, '6 Pack Retractable Gel Pens (Black)', 'Writing Essentials', '•	6 Pack\r\n•	Tip size: 0.7mm (medium)\r\n•	Dimensions/Size: 14.6cm (H) x 1.51cm (Dia.)\r\n•	Material:\r\n        Barrel: Styrene-acrylonitrile resin\r\n        Push-button and clip: Acrylonitrile butadiene styrene (ABS)\r\n        Rotter: Derlin\r\n        Refill tube: Polypropylene (PP)\r\n        Tip: Stainless steel\r\n        Spring: Stainless steel\r\n        Grip: Elastomer\r\n\r\n', '6 Pack Retractable Gel Pens (Black)1.jpeg', '6 Pack Retractable Gel Pens (Black)2.jpeg', '6 Pack Retractable Gel Pens (Black)3.jpeg', '6 Pack Retractable Gel Pens (Black)4.jpeg', 4.00, 0, 23, 'Black'),
(19, '1 in 4-Color BallPen', 'Writing Essentials', '•  4-in-1 Ink Colours – Switch easily between red, blue, black & green\r\n•  Retractable Design – No caps, no mess, just click and write\r\n•  0.7 mm Fine Tip – For sharp, neat, and controlled writing\r\n', '1 in 4-Color BallPen1.jpeg', '1 in 4-Color BallPen2.jpeg', '1 in 4-Color BallPen3.jpeg', '1 in 4-Color BallPen4.jpeg', 3.00, 0, 50, 'red, blue, black , green');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
