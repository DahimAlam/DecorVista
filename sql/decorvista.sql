-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2025 at 01:42 PM
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
-- Database: `decorvista`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'Top 5 Interior Design Trends 2025', 'Discover the latest trends shaping modern homes...', 'blog1.jpg', '2025-09-04 19:14:49'),
(2, 'How to Choose the Right Sofa', 'A quick guide to finding the perfect sofa...', 'blog2.jpg', '2025-09-04 19:14:49'),
(3, 'Lighting Tips for Cozy Bedrooms', 'Make your bedroom relaxing with smart lighting...', 'blog3.jpg', '2025-09-04 19:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `categoryname` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `categoryname`) VALUES
(1, 'Furniture'),
(2, 'Lighting'),
(3, 'Decor'),
(4, 'Rugs & Carpets'),
(5, 'Wall Art');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `consultation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `scheduled_datetime` datetime DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designers`
--

CREATE TABLE `designers` (
  `designer_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `cnic` varchar(30) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `cnic_pic` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `expertise` varchar(150) DEFAULT NULL,
  `portfolio_link` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `available_days` varchar(150) DEFAULT NULL,
  `available_time` enum('Morning','Afternoon','Evening','Night') DEFAULT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designers`
--

INSERT INTO `designers` (`designer_id`, `name`, `email`, `contact`, `cnic`, `profile_pic`, `cnic_pic`, `address`, `experience_years`, `expertise`, `portfolio_link`, `bio`, `available_days`, `available_time`, `approved`, `created_at`, `status`, `password`) VALUES
(1, 'Ayesha Khan', 'ayesha@example.com', '03001234567', NULL, 'designer1.jpg', NULL, NULL, 5, 'Modern Interiors', NULL, NULL, NULL, NULL, 1, '2025-09-04 19:14:48', 'pending', ''),
(2, 'Ali Raza', 'ali@example.com', '03119876543', NULL, 'designer2.jpg', NULL, NULL, 8, 'Minimalist Design', NULL, NULL, NULL, NULL, 1, '2025-09-04 19:14:48', 'pending', ''),
(3, 'Sara Ahmed', 'sara@example.com', '03211223344', NULL, 'designer3.jpg', NULL, NULL, 10, 'Luxury Homes', NULL, NULL, NULL, NULL, 1, '2025-09-04 19:14:48', 'pending', ''),
(4, 'dahim', 'dahimalam00@gmail.com', '03001234567', '42101-1234567-1', 'uploads/designers/profile/1757017397_produc1.jpg', 'uploads/designers/cnic/1757017397_ChatGPT Image Sep 4, 2025, 11_48_35 PM.png', 'golmarket', 5, 'Kitchen', '', 'qrfqfqw', 'Mon,Wed,Fri', 'Afternoon', 1, '2025-09-04 20:23:17', 'approved', ''),
(5, 'Talha', 'dahimalam00@gmail.com', '03001234567', '42101-1234567-1', 'uploads/designers/profile/1757094363_produc1.jpg', 'uploads/designers/cnic/1757094363_logo.jpg', 'golmarket', 5, 'Kitchen', 'https://auth.services.adobe.com/en_US/index.html?callback=https%3A%2F%2Fims-na1.adobelogin.com%2Fims%2Fadobeid%2FBehanceWebSusi1%2FAdobeID%2Ftoken%3Fredirect_uri%3Dhttps%253A%252F%252Fwww.behance.net%252Fsearch%252Fprojects%252Fweb%252520design%252520port', 'Expert in designing', 'Mon,Wed,Fri', 'Afternoon', 1, '2025-09-05 17:46:03', 'pending', '$2y$10$LnGiNwR6J8qdUKt5S5ZcEuqjrpb/O65fuIC4fjZVRfTHqlDjKy0tC'),
(6, 'owais', 'dahim.alam145@gmail.com', '03001234567', '42101-1234567-1', 'uploads/designers/profile/1757094423_spoon1.webp', 'uploads/designers/cnic/1757094423_BGUQ4840_2000x.webp', 'golmarket', 5, 'Living Room', 'https://auth.services.adobe.com/en_US/index.html?callback=https%3A%2F%2Fims-na1.adobelogin.com%2Fims%2Fadobeid%2FBehanceWebSusi1%2FAdobeID%2Ftoken%3Fredirect_uri%3Dhttps%253A%252F%252Fwww.behance.net%252Fsearch%252Fprojects%252Fweb%252520design%252520port', 'afqoifnni', 'Tue,Sat', 'Afternoon', 1, '2025-09-05 17:47:03', 'pending', '$2y$10$LIMQHoGiywH8gUPHALeadehj6su7wVp8DdX3Ux5horCwgBp/ZbL5K'),
(7, 'dahimalam', 'dahim.alam145@gmail.com', '03001234567', '42101-1234567-1', 'uploads/designers/profile/1757094573_BGUQ4840_2000x.webp', 'uploads/designers/cnic/1757094573_spoon1.webp', 'golmarket', 5, 'Office', 'https://auth.services.adobe.com/en_US/index.html?callback=https%3A%2F%2Fims-na1.adobelogin.com%2Fims%2Fadobeid%2FBehanceWebSusi1%2FAdobeID%2Ftoken%3Fredirect_uri%3Dhttps%253A%252F%252Fwww.behance.net%252Fsearch%252Fprojects%252Fweb%252520design%252520port', 'fafff', 'Tue,Thu,Fri', 'Morning', 1, '2025-09-05 17:49:33', 'pending', '$2y$10$3.2rqP79YkKWKqikfpW5pegkzk.Gy4eiqJFkBL3R7yO07B8nZb.aO');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `category`, `image`, `designer_id`, `created_at`) VALUES
(4, 'Kitchen decor', 'Kitchen', '1757151103_5873_kitchen.jpg', 4, '2025-09-06 09:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `product_uid` varchar(50) DEFAULT NULL,
  `availability` varchar(50) DEFAULT 'In Stock',
  `thumbnail` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `productname`, `category`, `price`, `description`, `image`, `featured`, `created_at`, `category_id`, `product_uid`, `availability`, `thumbnail`, `image1`, `image2`) VALUES
(10, 'Oval Hammered Glass Spoon Holder', NULL, 250.00, 'This Item is a unique quintessential luxury every kitchen and household must-have, with the extraordinary look and gorgeous finishing. The spoon holder set takes less space and solves the problem of space in your kitchen, in addition, to enhance your interior decor in your kitchen and dining table. A great gift for a newly built house or kitchen.\r\nMaterial: Designed Glass & Golden Stand\r\nDesign & Color: Transparent & Golden\r\nSet includes: Single Piece of Spoon Holder with Stand', NULL, 1, '2025-09-05 07:39:12', 3, 'PRD-20250905-093912-6102', 'In Stock', '1757057952_spoon1.webp', '1757057952_BGUQ4840_2000x.webp', '1757057952_KZMS4781_300x.avif');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('product','designer') NOT NULL,
  `target_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `type`, `target_id`, `rating`, `comment`, `created_at`) VALUES
(1, 5, 'product', 10, 5, 'Very good product', '2025-09-06 15:05:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`, `created_at`, `name`) VALUES
(1, 'admin@decorvista.com', 'admin123', 'admin', '2025-09-04 19:14:48', ''),
(2, 'talha@example.com', '12345', 'user', '2025-09-04 19:14:48', ''),
(3, 'dahimalam00@gmail.com', 'Sahim7860!!', 'user', '2025-09-05 12:35:00', 'dahimalam'),
(4, 'ow123@gmail.com', 'Owais7860!!', 'user', '2025-09-05 13:09:15', 'Owais'),
(5, 'aliza234@gmail.com', '$2y$10$bLuSYtjV.fmtmn6x7lMRyOQ1.F9nd1oXmlMD/UVgMJwh25UTmCto.', 'user', '2025-09-06 07:56:19', 'Aliza Alam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`consultation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `designer_id` (`designer_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `designers`
--
ALTER TABLE `designers`
  ADD PRIMARY KEY (`designer_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_gallery_category` (`category`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_uid` (`product_uid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `consultation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designers`
--
ALTER TABLE `designers`
  MODIFY `designer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`designer_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
