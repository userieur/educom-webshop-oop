-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 24, 2022 at 11:10 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `r_webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(6) UNSIGNED NOT NULL,
  `invoice_num` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_num`, `user_id`, `date`) VALUES
(1, '4', 1, '2022-10-22'),
(11, '10', 1, '2022-10-22'),
(12, '10', 1, '2022-10-22'),
(13, '10', 1, '2022-10-22'),
(14, '10', 1, '2022-10-22'),
(15, '10', 1, '2022-10-22'),
(16, '10', 1, '2022-10-22'),
(17, '10', 1, '2022-10-22'),
(18, '10', 1, '2022-10-22'),
(20, '10', 1, '2022-10-22'),
(21, '10', 1, '2022-10-22'),
(22, '10', 1, '2022-10-22'),
(23, '10', 1, '2022-10-22'),
(26, '10', 1, '2022-10-22'),
(27, '10', 1, '2022-10-22'),
(28, '10', 1, '2022-10-22'),
(29, '10', 1, '2022-10-24'),
(30, '202210240001', 1, '2022-10-24'),
(31, '202210242', 1, '2022-10-24'),
(32, '202210240243', 1, '2022-10-24'),
(33, '202210240244', 1, '2022-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_lines`
--

CREATE TABLE `invoice_lines` (
  `id` int(6) UNSIGNED NOT NULL,
  `invoice_id` int(6) UNSIGNED NOT NULL,
  `article_id` int(6) UNSIGNED NOT NULL,
  `sales_amount` int(6) UNSIGNED NOT NULL,
  `sales_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_lines`
--

INSERT INTO `invoice_lines` (`id`, `invoice_id`, `article_id`, `sales_amount`, `sales_price`) VALUES
(5, 26, 1, 1, 3.5),
(6, 26, 3, 1, 1.3),
(7, 26, 4, 1, 2.5),
(8, 27, 1, 1, 3.5),
(9, 27, 3, 1, 1.3),
(10, 27, 4, 1, 2.5),
(11, 28, 1, 3, 3.5),
(12, 28, 4, 2, 2.5),
(13, 28, 5, 1, 2.33),
(14, 29, 1, 3, 3.5),
(15, 29, 4, 2, 2.5),
(16, 30, 1, 1, 3.5),
(17, 30, 3, 1, 1.3),
(18, 30, 5, 1, 2.33),
(19, 31, 1, 1, 3.5),
(20, 31, 4, 1, 2.5),
(21, 31, 5, 1, 2.33),
(22, 32, 1, 1, 3.5),
(23, 32, 4, 1, 2.5),
(24, 32, 5, 1, 2.33),
(25, 33, 1, 3, 3.5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `imageurl` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `imageurl`) VALUES
(1, 'Pasta', 'Superlekkere pasta', 3.5, 'pasta.jpg'),
(2, 'Paprika', 'BLablabalbla', 1.3, 'paprika.jpg'),
(3, 'Courgette', 'BLggggggga', 1.3, 'courgette.jpg'),
(4, 'Ei', 'ei want ik ben zo blij', 2.5, 'ei.jpg'),
(5, 'Spinnen', 'Voor de extra eiwitten', 2.33, 'spin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(1, 'test@test.nl', 'hello', 'he'),
(2, 'hallo@hallo.nl', 'usernameeee', '1930'),
(3, 'roll.fc@bnl.nl', 'rollie', 'hallo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invoice_lines`
--
ALTER TABLE `invoice_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `invoice_lines`
--
ALTER TABLE `invoice_lines`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invoice_lines`
--
ALTER TABLE `invoice_lines`
  ADD CONSTRAINT `article_id` FOREIGN KEY (`article_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
