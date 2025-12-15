-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 04:20 AM
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
-- Database: `sinigrind_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_ref_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `date_ordered` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_claimed` timestamp NULL DEFAULT NULL,
  `order_status` varchar(2) DEFAULT 'x',
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `transaction_ref` varchar(100) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `item_id` int(11) NOT NULL,
  `sku` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','low','out of stock') NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`item_id`, `sku`, `name`, `description`, `price`, `status`, `image_file`, `date_added`, `last_updated`) VALUES
(1, 'C001', 'Arabica Coffee', '100% Arabica beans — smooth, aromatic, bold.', 450.00, 'active', 'assets/coffeepack1.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(2, 'C002', 'Colombia Coffee', 'Authentic Arabica beans from Colombia — fresh, strong.', 450.00, 'low', 'assets/coffeepack2.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(3, 'C003', 'Matcha Coffee', 'Earthy matcha blended with rich coffee notes.', 415.00, 'active', 'assets/coffeepack4.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(4, 'C004', 'Pink Coffee', 'Unique, flavorful, unapologetically fun.', 485.00, 'out of stock', 'assets/coffeepack3.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(5, 'C005', 'Blue Coffee', 'Ground blue coffee from Iceland — icy, cool.', 389.00, 'active', 'assets/coffeepack5.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(6, 'C006', 'Yellow Coffee', 'Yellow coffee made near the ocean — fresh, salty.', 399.00, 'active', 'assets/coffeepack6.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(7, 'C007', 'Black Coffee', 'Pure and bold brew — intense, strong.', 459.00, 'active', 'assets/coffeepack2.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33'),
(8, 'C008', 'White Coffee', 'Smooth, creamy blend — mild, rich.', 449.00, 'active', 'assets/coffeepack5.png', '2025-12-15 02:11:33', '2025-12-15 02:11:33');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `update_status_before_update` BEFORE UPDATE ON `products` FOR EACH ROW BEGIN
    IF NEW.stock = 0 THEN
        SET NEW.status = 'out of stock';
    ELSEIF NEW.stock < 50 THEN
        SET NEW.status = 'low';
    ELSE
        SET NEW.status = 'active';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_type` varchar(20) DEFAULT NULL,
  `stock_reason` varchar(50) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','low','out') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `item_id`, `quantity`, `unit_type`, `stock_reason`, `date_added`, `last_updated`, `status`) VALUES
(1, 1, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(2, 2, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(3, 3, 40, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(4, 4, 0, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(5, 5, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(6, 6, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(7, 7, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active'),
(8, 8, 200, 'pcs', 'Initial stock', '2025-12-14 20:12:11', '2025-12-14 20:12:11', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'luan', '$2y$10$pYPlcCgslZyfu4Kg2KJ5/u0mnZ/ChlznHbWqr.lSu7ey6uhaxeAgq', 'luan@gmail.com', '2025-12-14 09:19:16', '2025-12-14 09:19:16'),
(3, 'ash', 'ash', 'ash@gmail.com', '2025-12-14 09:27:41', '2025-12-14 09:27:41'),
(4, 'nikol', 'nikol', 'nikol@gmail.com', '2025-12-14 09:38:58', '2025-12-14 09:38:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_ref_number` (`order_ref_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `products` (`item_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `products` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
