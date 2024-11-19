-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 12:16 PM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(12, 1, 5, 'Ballpen', 12, 5, 'one.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `gcash_image` varchar(255) DEFAULT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `gcash_image`, `placed_on`, `payment_status`, `order_status`) VALUES
(18, 8, 'mark', '09063032063', 'mark@gmail.com', 'gcash', 'sitio baldi, bantaoay, San Vicente, Ilocos Sur', 'mini notebook (18 x 1) - ', 18, '234607446_3973340982764161_759883666750411913_n.png', '2024-11-05 09:52:50', 'Completed', 'Your order is out for delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `category`, `image_01`, `image_02`, `image_03`) VALUES
(5, 'Ballpen', 'Ballpen', 12, 'Pen', 'one.jfif', 'Ballpen one', 'Ballpen two'),
(6, 'mini notebook', 'Convenient pocket-sized journals.', 18, '', '1.jfif', '2.jpg', '3.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `sold_orders`
--

CREATE TABLE `sold_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `total_products` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `method` varchar(255) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `placed_on` datetime NOT NULL,
  `gcash_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sold_orders`
--

INSERT INTO `sold_orders` (`id`, `user_id`, `name`, `number`, `address`, `total_products`, `total_price`, `method`, `payment_status`, `placed_on`, `gcash_image`) VALUES
(9, 0, 'Ann', '1234', 'Liwliwa, TUROD, CabugAO, Ilocos Sur', 'Ballpen (12 x 1) - mini notebook (18 x 1) - ', 30.00, 'cash on delivery', 'Pending', '2024-10-17 00:00:00', ''),
(11, 0, 'marky', '123425647', 'SaaS, AsaS, Ss, Ilocos Sur', 'Ballpen (12 x 1) - ', 12.00, 'gcash', 'Completed', '2024-10-18 15:16:27', '3.jfif'),
(12, 0, 'pil', '09063032063', '01010101, dSD, adaSAs, Ilocos Sur', 'Ballpen (12 x 3) - ', 36.00, 'cash on delivery', 'pending', '2024-10-18 15:44:16', ''),
(13, 0, 'pil', '12345', 'XZX, ZXZX, XZXZX, Ilocos Sur', 'mini notebook (18 x 1) - Ballpen (12 x 1) - ', 30.00, 'cash on delivery', 'pending', '2024-10-18 16:04:37', ''),
(14, 5, 'pil', '123', 'dfdsf, dfssdf, dsfdsfdf, Ilocos Sur', 'mini notebook (18 x 1) - ', 18.00, 'cash on delivery', 'Pending', '2024-10-18 16:09:29', ''),
(15, 4, 'marky', '123456', 'xC, zCZXXC, xCxCx, Ilocos Sur', 'Ballpen (12 x 4) - ', 48.00, 'cash on delivery', 'Pending', '2024-10-18 16:11:39', ''),
(16, 7, 'Wesley Fanao', '09662018272', 'Ecarnacion Coumpond, Bayubay Sur San Vicente, San Vicente, Ilocos Sur', 'Ballpen (12 x 5) - ', 60.00, 'cash on delivery', 'Pending', '2024-10-18 19:46:55', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'michael', 'michael@gmail.com', '33ec297252717dfd7b95da92f93d73cee6041bb3'),
(4, 'marky', 'markjillianalferez@gmail.com', '51a36c6a87a5efbe9dc54ca98f5ff042d2d7ef3b'),
(6, 'justinelang', 'JUSTINE@GMAIL.COM', '819d2cbc46b3164bd1e6078ca5e661d352492f62'),
(7, 'Wesley Fanao', 'wfanao51@gmail.com', '6f1d51444c8998e9cc31e2df92c80cd90463eaaa'),
(8, 'mark', 'mark@gmail.com', 'f1b5a91d4d6ad523f2610114591c007e75d15084');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sold_orders`
--
ALTER TABLE `sold_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sold_orders`
--
ALTER TABLE `sold_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
