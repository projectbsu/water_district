-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 04:32 AM
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
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `schedule` date NOT NULL,
  `context` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `schedule`, `context`) VALUES
(1, 'Water Interuption', '2024-10-18', 'Mawawalan ng tubig'),
(2, 'Water Interuption', '2024-10-24', 'yawa'),
(4, 'Water Interuption', '2024-10-17', 'Mawawalan po ng tubig mag ipon nakayo.'),
(5, 'Water Interuption', '2024-10-31', 'JBGWGERH');

-- --------------------------------------------------------

--
-- Table structure for table `archived_feedback`
--

CREATE TABLE `archived_feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `feedback_text` text NOT NULL,
  `reaction` varchar(20) NOT NULL,
  `sentiment_score` float NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archived_feedback`
--

INSERT INTO `archived_feedback` (`id`, `user_id`, `feedback_text`, `reaction`, `sentiment_score`, `created_at`) VALUES
(8, 1, 'Excellent customer service every time.', 'Very Happy', 1, '2024-10-09 14:11:13'),
(12, 1, 'Water pressure problems in my area.', 'Sad', 0.5, '2024-10-10 10:04:24'),
(13, 1, 'Frequent water service disruptions.', 'Angry', -1, '2024-10-11 12:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `billing_list`
--

CREATE TABLE `billing_list` (
  `id` int(30) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `reading_date` date NOT NULL,
  `bill_number` varchar(255) NOT NULL,
  `meter_number` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `present_reading` float(12,2) NOT NULL,
  `previous` float(12,2) NOT NULL,
  `total` float(12,2) NOT NULL,
  `penalty` float(12,2) DEFAULT 0.00,
  `total_after_due` float(12,2) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `paymentMethod` varchar(64) NOT NULL,
  `maintenance` float(12,2) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_list`
--

INSERT INTO `billing_list` (`id`, `name`, `account_number`, `reading_date`, `bill_number`, `meter_number`, `due_date`, `present_reading`, `previous`, `total`, `penalty`, `total_after_due`, `status`, `paymentMethod`, `maintenance`, `date_created`, `date_updated`) VALUES
(1, 'Angelo Santos', '186286e', '2024-11-02', '172', '12', '2024-10-30', 1223.00, 123.00, 1223.00, 12.00, 12.00, 2, '12', -0.01, '2024-10-11 14:28:26', '2024-10-12 09:32:29'),
(2, 'Angelo Santos', '186286e', '2024-10-17', '172', '12', '2024-10-29', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-11 14:39:01', NULL),
(3, 'Angelo Santos', '186286e', '2024-10-04', '172', '12', '2024-10-24', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-11 14:39:23', NULL),
(4, 'yawa', '186286e', '2024-09-29', '172', '12', '2024-10-16', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-11 14:41:31', '2024-10-12 08:28:35'),
(5, 'Emo Santos', '186286e', '2024-10-25', '172', '12', '2024-10-16', 1223.00, 123.00, 1223.00, 12.00, 12.00, 0, '12', -0.01, '2024-10-11 14:51:12', NULL),
(6, 'Emo Santos', '186286e', '2024-10-31', '172', '12', '2024-10-22', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-11 14:52:33', NULL),
(7, 'Emo Santos', '186286e', '2024-11-07', '172', '12', '2024-10-31', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-11 14:53:07', NULL),
(8, 'Emo Santos', '186286e', '2024-10-18', '172', '12', '2024-10-23', 1223.00, 123.00, 1223.00, 12.00, 12.00, 2, '12', -0.01, '2024-10-12 07:55:23', '2024-10-12 09:16:56'),
(9, 'Emo Santos', '186286e', '2024-11-01', '172', '12', '2024-10-29', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-12 07:55:36', NULL),
(10, 'Emo Santos', '186286e', '2024-10-31', '172', '12', '2024-10-23', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-12 07:55:52', NULL),
(11, 'Emo Santos', '186286e', '2024-11-05', '172', '12', '2024-10-21', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-12 07:56:05', NULL),
(12, 'Emo Santos', '186286e', '2024-11-01', '172', '12', '2024-10-03', 1223.00, 123.00, 1223.00, 12.00, 12.00, 1, '12', -0.01, '2024-10-12 07:58:03', NULL),
(13, 'gagi', '186286e', '2024-10-28', '172', '12', '2024-10-14', 1223.00, 123.00, 1223.00, 12.00, 12.00, 2, '12', -0.01, '2024-10-12 09:23:18', NULL),
(14, 'Ellie Joy Dimaculangan', '186286e4', '2024-10-25', '172', '12', '2024-10-31', 1223.00, 123.00, 1223.00, 12.00, 12.00, 0, '12', -0.01, '2024-10-12 10:57:43', NULL),
(15, 'Ellie Joy Dimaculangan', '186286e4', '2024-10-26', '172', '12', '2024-11-02', 1223.00, 123.00, 1223.00, 12.00, 12.00, 0, '12', -0.01, '2024-10-12 11:12:42', NULL),
(16, 'Gelloo', '6384736', '2024-11-02', '172', '12', '2024-11-01', 1223.00, 123.00, 1223.00, 12.00, 12.00, 0, '12', -0.01, '2024-10-12 11:25:23', NULL);

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
(2, 'New Connection', 'A service for installing a fresh utility connection to a property.\r\n', '2024-10-10 00:51:52'),
(3, 'Reconnection', 'Restoring a previously disconnected service due to non-payment or request.\r\n', '2024-10-10 00:52:44'),
(4, 'Disconnection', 'The termination of a utility service, either temporarily or permanently, upon request or non-compliance.\r\n', '2024-10-10 00:53:18'),
(5, 'Relocation', 'Moving existing service infrastructure to a new location within the same property or premises.\r\n', '2024-10-10 00:53:41'),
(6, 'Change Meter', 'Replacing an old or malfunctioning meter with a new one for accurate readings.\r\n', '2024-10-10 00:54:17'),
(7, 'Service Line Minor Repair', 'Small-scale repairs on the customer’s service line, addressing minor leaks or damages.\r\n', '2024-10-10 00:55:09'),
(8, 'Service Line Major Repair', 'Extensive repairs required for severe damage or faults on the customer’s service line.', '2024-10-10 00:55:32'),
(9, 'Mainline Minor Repair', 'Minor repairs on the main utility line, usually involving small leaks or wear-and-tear fixes.\r\n', '2024-10-10 00:56:04'),
(10, 'Mainline Major Repair', 'Major repairs addressing significant damage to the main utility line, which could impact multiple users.\r\n', '2024-10-10 00:56:25');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sentiment_score` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `reaction`, `feedback_text`, `created_at`, `sentiment_score`) VALUES
(58, 1, 'Harry Denn', 'Happy', 'Positive experience with community outreach efforts.', '2024-10-09 03:05:26', 1.0),
(59, 1, 'Harry Denn', 'Angry', 'Consistent issues with water quality.', '2024-10-09 03:10:37', -1.0),
(60, 1, 'Harry Denn', 'Sad', 'Water pressure problems in my area.', '2024-10-09 03:10:42', -0.5),
(61, 1, 'Harry Denn', 'Neutral', 'Standard billing process with no surprises.', '2024-10-09 03:10:46', 0.0),
(62, 1, 'Harry Denn', 'Happy', 'Positive experience with community outreach efforts.', '2024-10-09 03:10:51', 0.5),
(63, 1, 'Harry Denn', 'Very Happy', 'Fair pricing and transparent billing practices.', '2024-10-09 03:10:56', 1.0),
(64, 1, 'Harry Denn', 'Happy', 'Positive experience with community outreach efforts.', '2024-10-09 03:18:59', 0.5),
(71, 1, 'Harry Denn', 'Neutral', 'Service is adequate but not exceptional.', '2024-10-09 03:47:40', 0.0),
(72, 1, 'Harry Denn', 'Sad', 'High rates compared to neighboring districts.', '2024-10-09 05:54:43', -0.5),
(73, 1, 'Harry Denn', 'Very Happy', 'Proactive communication about projects and updates.', '2024-10-09 06:09:43', 1.0),
(78, 6, 'Gelo Santos', 'Very Happy', 'Fair pricing and transparent billing practices.', '2024-10-10 02:23:48', 1.0),
(80, 1, 'Harry Denn', 'Very Happy', 'Great programs for water conservation and education.', '2024-10-11 04:34:00', 1.0),
(81, 1, 'Harry Denn', 'Sad', 'High rates compared to neighboring districts.', '2024-10-11 05:02:56', -0.5),
(82, 1, 'Harry Denn', 'Sad', 'High rates compared to neighboring districts.', '2024-10-11 05:08:41', -0.5),
(83, 1, 'Harry Denn', 'Angry', 'Consistent issues with water quality.', '2024-10-12 05:39:04', -1.0),
(84, 1, 'Harry Denn', 'Neutral', 'Service is adequate but not exceptional.', '2024-10-16 06:16:50', 0.0),
(85, 1, 'Harry Denn', 'Neutral', 'Service is adequate but not exceptional.', '2024-10-16 06:21:08', 0.0),
(86, 1, 'Harry Denn', 'Neutral', 'Service is adequate but not exceptional.', '2024-10-16 06:22:32', 0.0);

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `account_number` varchar(30) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `status` enum('Pending','Approved','Denied') DEFAULT 'Pending',
  `date_of_request` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `name`, `email`, `contact`, `account_number`, `gender`, `barangay`, `status`, `date_of_request`, `category`) VALUES
(2, 'Angelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', 'Pending', '2024-10-26 02:12:50', 'Relocation'),
(6, 'Angelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', '', '2024-10-26 02:21:50', 'Pending'),
(7, 'Angelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', '', '2024-10-26 02:22:50', 'Pending'),
(8, 'Angelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', '', '2024-10-26 02:28:05', 'Pending'),
(9, 'Ggelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', '', '2024-10-26 02:28:33', 'Pending'),
(10, 'Ggelo Santos', 'angelosantospamplona@gmail.com', '092664773272', '186286e', 'Male', 'Anilao East', 'Pending', '2024-10-26 02:29:45', 'Reconnection');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `transaction_detail` text NOT NULL,
  `transaction_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `age` int(3) NOT NULL,
  `account_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `email`, `contact`, `sex`, `barangay`, `age`, `account_number`) VALUES
(1, 'Harry Denn', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, 'harrydean34@gmail.com', '092636747377', 'Male', 'Pulong Anahao', 32, '98585'),
(2, 'John Walker', 'John', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.png', 1, 'john@gmail.com', '09108615337', 'Male', 'Pulong Anahao', 25, 'yyyjyfu'),
(3, 'Christopher Martinez', 'Christopher', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.png', 1, 'christophermartinez11@gmail.com', '092664773272', 'Male', 'Pilahan', 40, '7437634'),
(4, 'Natie Williams', 'Natie', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, 'natiewilliams12@gmail.com', '091234556', 'Female', 'Anilao Proper', 30, '18628655'),
(5, 'Kevin', 'Kevin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, 'kevin0992@gmail.com', '0936762', 'Male', 'San Francisco', 32, '48uhgdfv'),
(6, 'Gelo Santos', 'Angelo', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 1, 'dqw8itwc6.png', 1, 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Pulong Balibaguhan', 19, '6384736'),
(7, 'Angelo Santos', 'Angelo', '41f6b14341c6a4c029ce75c50665244233cbc5c7', 1, 'no_image.jpg', 0, 'angelosantospamplona@gmail.com', '09108615337', 'Male', 'Pulang Lupa', 20, '186286e'),
(8, 'Ellie Joy Dimaculangan', 'Ellie', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 3, 'no_image.jpg', 1, 'ellie34@gmail.com', '3885885', 'Female', 'Pilahan', 21, '186286e4');

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
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archived_feedback`
--
ALTER TABLE `archived_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `billing_list`
--
ALTER TABLE `billing_list`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`,`account_number`,`transaction_detail`,`transaction_time`) USING HASH;

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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `archived_feedback`
--
ALTER TABLE `archived_feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `billing_list`
--
ALTER TABLE `billing_list`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archived_feedback`
--
ALTER TABLE `archived_feedback`
  ADD CONSTRAINT `archived_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
