-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 06:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `water_district`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_details`, `created_at`) VALUES
(1, 'Gelo', 'rgg', '2024-09-27 00:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `reaction` enum('Angry','Sad','Neutral','Happy','Very Happy') NOT NULL,
  `feedback_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `reaction`, `feedback_text`, `created_at`) VALUES
(23, 1, 'Harry Denn', 'Sad', 'kriirir', '2024-09-30 05:16:59'),
(24, 3, 'Christopher', 'Sad', 'im sad', '2024-09-30 05:21:57'),
(25, 3, 'Christopher', 'Angry', 'im angry', '2024-09-30 05:23:48'),
(26, 3, 'Christopher', 'Sad', 'im sad', '2024-09-30 05:23:55'),
(27, 3, 'Christopher', 'Neutral', 'i dont feel nothing', '2024-09-30 05:24:06'),
(29, 3, 'Christopher', 'Very Happy', 'im very happy', '2024-09-30 05:24:25'),
(33, 3, 'Christopher', 'Happy', 'im happy', '2024-10-03 04:02:11');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `customer_user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_of_request` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `customer_user_id`, `name`, `email`, `contact`, `gender`, `barangay`, `status`, `date_of_request`) VALUES
(3, 6, 'IHRGNKG', 'angelosantospamplona@gmail.com', 'NITH', 'Male', 'Anilao East', 'Pending', '2024-09-27 12:45:26'),
(4, 6, 'IHRGNKG', 'angelosantospamplona@gmail.com', 'NITH', 'Male', 'Anilao East', 'Pending', '2024-09-27 12:59:47'),
(5, 6, 'IHRGNKG', 'angelosantospamplona@gmail.com', 'NITH', 'Male', 'Anilao East', 'Pending', '2024-09-27 13:05:30'),
(6, 6, 'IHRGNKG', 'angelosantospamplona@gmail.com', 'NITH', 'Male', 'Anilao East', 'Pending', '2024-09-27 13:07:06'),
(7, 6, 'Angelo Santos', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-27 13:10:44'),
(8, 1, 'Angelo Santos', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 10:59:45'),
(9, 1, 'Angelo Santos', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:34:34'),
(10, 1, 'Angelo Santos', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:36:08'),
(11, 1, 'Gelo Santos', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:40:10'),
(12, 1, 'jana', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:44:18'),
(13, 1, 'jana', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:47:11'),
(14, 1, 'jana', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 12:47:35'),
(15, 1, 'jana', 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 'Pending', '2024-09-30 13:02:15');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `customer_user_id` int(10) UNSIGNED NOT NULL,
  `transaction_detail` varchar(255) NOT NULL,
  `transaction_time` datetime DEFAULT current_timestamp(),
  `customer_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_user_id`, `transaction_detail`, `transaction_time`, `customer_name`) VALUES
(1, 6, 'New service request added for IHRGNKG.', '2024-09-27 07:05:30', NULL),
(2, 6, 'New service request added for IHRGNKG.', '2024-09-27 07:07:06', NULL),
(3, 6, 'New service request added for Angelo Santos.', '2024-09-27 07:10:44', NULL),
(4, 1, 'New service request added for Angelo Santos.', '2024-09-30 04:59:45', NULL),
(5, 1, 'New service request added for Angelo Santos.', '2024-09-30 06:36:08', NULL),
(6, 1, 'New service request added for Gelo Santos.', '2024-09-30 06:40:10', NULL),
(7, 1, 'New service request added for jana.', '2024-09-30 06:44:18', NULL),
(8, 1, 'New service request added for jana.', '2024-09-30 06:47:11', NULL),
(9, 1, 'New service request added for jana.', '2024-09-30 06:47:35', NULL),
(17, 1, 'jana send a service request.', '2024-09-30 07:02:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `email`, `contact`, `sex`, `barangay`, `age`) VALUES
(1, 'Harry Denn', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, 'harrydean34@gmail.com', '092636747377', 'Male', 'Pulong Anahao', 32),
(2, 'John Walker', 'John', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.png', 1, 'john@gmail.com', '09108615337', 'Male', 'Pulong Anahao', 25),
(3, 'Christopher Martinez', 'Christopher', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.png', 1, 'christophermartinez11@gmail.com', '092664773272', 'Male', 'Pilahan', 40),
(4, 'Natie Williams', 'Natie', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, 'natiewilliams12@gmail.com', '091234556', 'Female', 'Barangay 1', 30),
(5, 'Kevin', 'Kevin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 0, 'kevin0992@gmail.com', '09367624422', 'Male', 'San Francisco', 32),
(6, 'Gelo Santos', 'Angelo', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 1, 'dqw8itwc6.png', 1, 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Pulong Balibaguhan', 19),
(7, 'Angelo Santos', 'Angelo', '41f6b14341c6a4c029ce75c50665244233cbc5c7', 1, 'no_image.jpg', 1, 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Anilao East', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Staff', 2, 1),
(3, 'Customer', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_user_id` (`customer_user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_user_id` (`customer_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `service_requests_ibfk_1` FOREIGN KEY (`customer_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`customer_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
