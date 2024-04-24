-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 09:42 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance-portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`, `status`) VALUES
(1, 'Admin', 'Active'),
(2, 'User', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `users_detail_id` int(11) DEFAULT NULL,
  `email_verfied_at` varchar(100) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `token`, `status`, `users_detail_id`, `email_verfied_at`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(3, 'abu.hammad', 'hammadkama@gmail.com', '$2y$10$1ykm3GATyq.VTLbUGOYa/uoqzjtTgawKX3s3pv6DTLrOAYMxVolMq', 1, '090cc7f447c8aeaa80bafc45c493677bac677e73b9f729d9b70a8ff903fe9332604c78d955eb4ea0f210c8c9771ba719700f', 'Active', 3, NULL, 'Abu Hammad', '2024-04-23', NULL, NULL),
(4, 'hamza_aslam', 'hamza.aslam@gmail.com', '$2y$10$MNe5L3YIUrgwiPA62rUJ5.mLUsvKRRxyS0NggJOtyllwLeS4A2iai', 1, '43f09cbc26df3e6fe40d30496477398205d6a9fac066f16e25ba40d95e44f375346095aeb36a571046427a1b4c23ceebc4e7', 'Inactive', 4, NULL, 'Abu Hammad', '2024-04-23', NULL, NULL),
(5, 'hammad-kamal', 'hammadka@gmail.com', '$2y$10$gbsx6/A5C.OompcH6jNe2eQnbjyWI68hJNDtS0F6cEptD4JuZhgt2', 1, '2f84e9c6def9a6569dd07693315fcadae4a45685be4430f4948dc857b9604bd16670e0d77e42a8dabbc3e6e65bba0279edc9', 'Inactive', 5, NULL, 'Abu Hammad', '2024-04-24', NULL, NULL),
(6, 'afzal', 'hammadka7878@gmail.com', '$2y$10$IDU1EikTKaW.EbEdSxRu1.hmRTA7.zQkpegde8L/d/zHWojB8jNba', 1, 'c275828503de99f1329258f995665432f797737b8b3593c07706bdcc310b0072412f9bc71069072aa92cb85619ec050fbe81', 'Active', 6, '2024-04-24 10:30:25', 'Abu Hammad', '2024-04-24', NULL, NULL),
(10, 'javeria', 'hammadkamal2003@gmail.com', '$2y$10$oy0Ors4acUtl5tYqXJbQJ.iM8ErOsKJpBbB7dVJH0G.s6qn9H8nxu', 1, '7db58ea907dd35e45204be11f97a66e7f25296a33b6feba9e8294a9fbbcf03956d5d3a2c51e75476e5c7bd0b9df901178a4b', 'Active', 10, '2024-04-24 12:18:23', 'Abu Hammad', '2024-04-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_detail`
--

CREATE TABLE `users_detail` (
  `users_detail_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `date_of_birth` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`users_detail_id`, `full_name`, `Phone`, `address`, `gender`, `date_of_birth`, `image`, `login_time`, `logout_time`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(3, 'Abu Hammad', '03131192135', 'landhi', 'Male', '2021-01-18', '728399893_Untitled design (26).png', '2024-04-24 12:06:04', '2024-04-24 12:39:25', '2024-04-23', 'Abu Hammad', NULL, NULL),
(4, 'Hamza Aslam', '03131197766', 'landhi karachi', 'Male', '2018-05-09', '239358004_Untitled design (26).png', NULL, NULL, '2024-04-23', 'Abu Hammad', NULL, NULL),
(5, 'Abu Hammad', '031998563', 'landhi', 'Male', '2024-04-03', '349177822_Untitled design (24).png', NULL, NULL, '2024-04-24', 'Abu Hammad', NULL, NULL),
(6, 'Afzal', '0313636374', 'landhi karachi', 'Male', '2018-06-24', '533539193_Untitled design (25).png', NULL, NULL, '2024-04-24', 'Abu Hammad', NULL, NULL),
(10, 'Javeria', '0313114566', 'landhi', 'Female', '2016-06-16', '494475144_Untitled design (26).png', '2024-04-24 12:40:40', '2024-04-24 12:39:58', '2024-04-24', 'Abu Hammad', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `users_detail_id` (`users_detail_id`);

--
-- Indexes for table `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`users_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `users_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`users_detail_id`) REFERENCES `users_detail` (`users_detail_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
