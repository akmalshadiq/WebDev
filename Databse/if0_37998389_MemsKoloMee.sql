-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Generation Time: Jan 04, 2025 at 04:04 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37998389_MemsKoloMee`
--

-- --------------------------------------------------------

--
-- Table structure for table `Noodles`
--

CREATE TABLE `Noodles` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Noodles`
--

INSERT INTO `Noodles` (`id`, `type`, `name`, `description`, `price`, `status`, `image_url`, `created_at`) VALUES
(1, 'Mee Kolok', 'Mee Kolok Biasa', 'Normal', '6.50', 'available', 'meekolokchic.JPG', '2025-01-01 14:41:55'),
(2, 'Mee Pok', 'Mee Pok Biasa', 'Normal', '6.50', 'low', 'meepokchic.jpg', '2025-01-01 14:43:26'),
(3, 'Fried Noodles', 'Fried Noodles', 'Red', '8.00', 'available', 'fnoodles.jpg', '2025-01-01 14:44:33'),
(7, 'Mee Pok', 'Mee Pok Merah', 'Red', '6.50', 'available', 'meepokchic.jpg', '2025-01-01 20:01:24'),
(5, 'Fried Noodles', 'Char Kuey Teow', 'Normal', '8.00', 'available', 'ckt.jpg', '2025-01-04 04:31:50'),
(6, 'Mee Kolok', 'Mee Kolok Merah', 'Red', '6.50', 'available', 'meekolokmerah.jpg', '2025-01-04 04:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Order_Items`
--

CREATE TABLE `Order_Items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `noodle_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `toppings` text DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('Online Payment','Cash') NOT NULL,
  `payment_status` enum('Pending','Successful','Failed') NOT NULL DEFAULT 'Pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_reference` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Toppings`
--

CREATE TABLE `Toppings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Guest','Member','Admin') NOT NULL DEFAULT 'Guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `full_name`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Mohd Aiman bin Baharin', 'mohdaimanb@gmail.com', '$2y$10$UM0knAGjfr61N0x7qXTkb.315XINIlkZDi63DDdW/FY3.d.etv3Qy', 'Member', '2024-12-30 18:52:54'),
(2, 'eman', 'e@gmail.com', '$2y$10$GHdiwv6IauN/XbSr3klWkuXY3N.YiZ/B8zlI2rWuSipAqvSGgu7Ee', 'Member', '2024-12-31 13:39:10'),
(3, 'saimon', 'saimon@gmail.com', '$2y$10$ZVzPWSHgWyO89EZtQ325pe7Cw8ka6UpGnkKuljJWxlrQhWWCjqf7y', 'Member', '2024-12-31 23:04:53'),
(5, 'saimon', '12322@gmail.com', '$2y$10$1S4zu36/BewN/GISK2Gctul2U3FbsLYhGKF7DE0lAEOs9cHmvSog2', 'Member', '2024-12-31 23:30:37'),
(6, 'saimon2', 'saimon2@gmail.com', '$2y$10$.5vZIs48qicZkclIFzNBU.ggArhjtAPU.GNcNEPr91Xzzf3la5Nzu', 'Member', '2024-12-31 23:32:20'),
(7, 'Iman', 'nbdy121@gmail.com', '$2y$10$VSUW.ZXaeh9mYRVcThnzoeL/NFYnO.v6vQBFdiJrN9kMkTEX.hdUq', 'Member', '2024-12-31 23:32:37'),
(8, 'Felix', 'felixnoell123@gmail.com', '$2y$10$ssdfT9kwc6BboWH7fC.FCeXAe40WPkJSVuqPU11OmnxUPmu4EgO0a', 'Member', '2025-01-01 15:41:41'),
(9, 'dd', 'ddsada@gmail.com', '$2y$10$n5tj7.DvZt6ejZzfF1SS..5NBTs3NgvoMDYQ9gNoYNHIrNTcGpENm', 'Member', '2025-01-01 20:18:34'),
(10, 'dd', '122@gmail.com', '$2y$10$A687XLgL6vtCuTPhW61icOYPZzR2A5FoMERkRYI5xGkL9b4Q3GDYu', 'Member', '2025-01-01 20:18:56'),
(11, 'kell', 'y@s', '$2y$10$m4JDX0HzOjodbftgoKCLS.NZEsiVs85rqP0M0LoHk4JZsQxnEYZDG', 'Member', '2025-01-01 20:44:24'),
(12, 'Akmal Shadiq', 'akmalshadiq@gmail.com', '$2y$10$2d8XYZG4VoK/IbmGcbhtQu4SK.ay7v4aK.sb55Q.3I02XxPUrw1I.', 'Admin', '2025-01-04 11:31:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Noodles`
--
ALTER TABLE `Noodles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Order_Items`
--
ALTER TABLE `Order_Items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `noodle_id` (`noodle_id`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `Toppings`
--
ALTER TABLE `Toppings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Noodles`
--
ALTER TABLE `Noodles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Order_Items`
--
ALTER TABLE `Order_Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Payments`
--
ALTER TABLE `Payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Toppings`
--
ALTER TABLE `Toppings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
