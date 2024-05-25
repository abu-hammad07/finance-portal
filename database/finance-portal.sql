-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 08:18 AM
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
-- Table structure for table `egate`
--

CREATE TABLE `egate` (
  `eGate_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `house_or_shop` enum('house','shop') DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_color` varchar(255) DEFAULT NULL,
  `eGateperson_name` varchar(255) DEFAULT NULL,
  `eGate_cnic` varchar(255) DEFAULT NULL,
  `eGate_charges_type` varchar(255) DEFAULT NULL,
  `eGate_charges` varchar(255) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `egate`
--

INSERT INTO `egate` (`eGate_id`, `house_id`, `shop_id`, `house_or_shop`, `vehicle_number`, `vehicle_name`, `vehicle_color`, `eGateperson_name`, `eGate_cnic`, `eGate_charges_type`, `eGate_charges`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(1, NULL, 2, 'shop', 'abc-32146', 'Yamaha', 'White', 'Rameez', '232222222434', 'New Card', '2000', '2024-05-18', 'abu.hammad', '2024-05-18', 'abu.hammad'),
(2, 7, NULL, 'house', 'abc-3214', 'Yamaha', 'White', 'Hassan Ali', '232222222434', 'New Card', '2000', '2024-05-18', 'abu.hammad', '2024-05-18', 'abu.hammad'),
(3, NULL, 2, 'shop', 'abc-32144', 'Yamaha', 'White', 'Rameez', '232222222434', 'Renew', '1000', '2024-05-18', 'abu.hammad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events_booking`
--

CREATE TABLE `events_booking` (
  `event_id` int(11) NOT NULL,
  `eventName` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date` varchar(150) DEFAULT NULL,
  `startTiming` varchar(100) DEFAULT NULL,
  `endTiming` varchar(100) DEFAULT NULL,
  `noOfPersons` varchar(100) DEFAULT NULL,
  `eventType` varchar(255) DEFAULT NULL,
  `customerCnic` varchar(100) DEFAULT NULL,
  `customerContact` varchar(100) DEFAULT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `bookingPayment` varchar(255) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_booking`
--

INSERT INTO `events_booking` (`event_id`, `eventName`, `location`, `date`, `startTiming`, `endTiming`, `noOfPersons`, `eventType`, `customerCnic`, `customerContact`, `customerName`, `bookingPayment`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(5, 'Holidays', 'Sports Centre', '2024-05-01', '13:03', '03:58', '3', 'Birth day', '2333333333', '34444442323', 'Anus', '30000', 'hamza_aslam', '2024-05-01', 'abu.hammad', '2024-05-15'),
(8, 'Holidays', 'Shadi Hall', '2024-05-03', '02:00', '04:00', '2', 'Birth day', '4501838348734', '78432', 'Hammad', '30000', 'hamza_aslam', '2024-05-01', 'abu.hammad', '2024-05-25'),
(10, 'Holidays', 'Shadi Hall', '2024-05-16', '02:13', '04:13', '13', 'Eid', '2555555555', '0314343544', 'Hammad', '30000', 'abu.hammad', '2024-05-15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `house_id` int(10) NOT NULL,
  `house_number` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_contact` varchar(255) NOT NULL,
  `owner_cnic` varchar(255) DEFAULT NULL,
  `occupancy_status` varchar(255) NOT NULL,
  `property_size` varchar(255) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `property_type` varchar(255) NOT NULL,
  `maintenance_charges` int(255) NOT NULL,
  `added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `added_by` varchar(255) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`house_id`, `house_number`, `owner_name`, `owner_contact`, `owner_cnic`, `occupancy_status`, `property_size`, `floor`, `property_type`, `maintenance_charges`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(1, '3234', 'Hammad', '344444544', '8377777234', 'owned', '60 sq yards', 'ground', 'Apartment', 344444, '2024-04-24 00:00:00', 'abu.hammad', '2024-05-19 11:08:03', 'abu.hammad'),
(7, '7645', 'Ali', '433333333333', '667777777435', 'owned', '60 sq yards', 'floor1', 'Duplex', 5433, '2024-01-14 00:00:00', 'hamza_aslam', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_payments`
--

CREATE TABLE `maintenance_payments` (
  `maintenance_id` int(11) NOT NULL,
  `house_id` int(55) DEFAULT NULL,
  `shop_id` int(55) DEFAULT NULL,
  `house_or_shop` varchar(22) NOT NULL,
  `maintenance_month` varchar(255) NOT NULL,
  `maintenance_peyment` varchar(255) NOT NULL,
  `added_on` varchar(55) NOT NULL,
  `added_by` varchar(55) NOT NULL,
  `updated_on` varchar(55) NOT NULL,
  `updated_by` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(11) NOT NULL,
  `penalty_type` varchar(255) NOT NULL,
  `penalty_cnic` varchar(55) NOT NULL,
  `penalty_charges` int(55) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`id`, `penalty_type`, `penalty_cnic`, `penalty_charges`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(2, 'Rode Crose', '4250145554027', 2000, 'hamza_aslam', '2024-05-16', NULL, NULL),
(3, 'Late night', '44250103226807', 5000, 'abu.hammad', '2024-05-25', NULL, NULL);

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
-- Table structure for table `servants`
--

CREATE TABLE `servants` (
  `servant_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `servantDesignation` varchar(255) DEFAULT NULL,
  `servantFees` varchar(255) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `servants`
--

INSERT INTO `servants` (`servant_id`, `house_id`, `servantDesignation`, `servantFees`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, 7, 'text', '500', '3', '2024-05-15', NULL, NULL),
(2, 7, 'text2', '500', '3', '2024-05-15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL,
  `shop_number` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_contact` varchar(255) DEFAULT NULL,
  `owner_cnic` varchar(255) DEFAULT NULL,
  `occupancy_status` varchar(255) DEFAULT NULL,
  `property_size` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `maintenance_charges` varchar(255) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shop_id`, `shop_number`, `owner_name`, `owner_contact`, `owner_cnic`, `occupancy_status`, `property_size`, `floor`, `property_type`, `maintenance_charges`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(1, '1234', 'Afzal', '03143444442', '3444444444345', 'rented', '60 sq yards', 'ground', 'Apartment', '300', '2024-05-16', '', '2024-05-16', 'abu.hammad'),
(2, '432', 'Afzal', '34333333333', '55555555555555', 'rented', 'floor2', 'Duplex', '120 sq yards', '300', '2024-05-16', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `tenant_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `tenant_name` varchar(100) NOT NULL,
  `tenant_contact_no` varchar(100) DEFAULT NULL,
  `tenant_cnic` varchar(100) DEFAULT NULL,
  `tenant_image` varchar(255) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`tenant_id`, `house_id`, `tenant_name`, `tenant_contact_no`, `tenant_cnic`, `tenant_image`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, 1, 'Hammad', '03131192139', '45555555', '285242984_abu hammad.jpg', 'hamza_aslam', '2024-05-14', 'abu.hammad', '2024-05-14'),
(2, 1, 'Hammad', '433333333', '455555555', '213363615_', 'hamza_aslam', '2024-05-14', NULL, NULL),
(3, 1, 'Hammad', '43333333', '3444444444', '813125580_abu hammad.jpg', 'hamza_aslam', '2024-05-14', NULL, NULL),
(4, 1, 'Hammad Ali', '244444444444', '4333333333333', '841838424_images.jpg', 'hamza_aslam', '2024-05-14', NULL, NULL),
(5, 7, 'Hammad Ali', '2333333333', '433333333', '729579149_abu hammad.jpg', 'abu.hammad', '2024-05-14', NULL, NULL),
(6, 7, 'Hammad Ali', '2333333333', '433333333', '129604497_abu hammad.jpg', 'abu.hammad', '2024-05-14', NULL, NULL),
(7, 7, 'Hammad Ali', '2333333333', '433333333', '609223388_abu hammad.jpg', 'abu.hammad', '2024-05-14', NULL, NULL),
(8, 7, 'Hammad Ali', '2333333333', '433333333', '394174950_abu hammad.jpg', 'abu.hammad', '2024-05-14', NULL, NULL),
(9, 7, 'Ghani', '2344443444', '4233544444343', '376714444_abu hammad.jpg', 'abu.hammad', '2024-05-14', NULL, NULL);

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
(4, 'hamza_aslam', 'hamza.aslam@gmail.com', '$2y$10$MNe5L3YIUrgwiPA62rUJ5.mLUsvKRRxyS0NggJOtyllwLeS4A2iai', 1, '43f09cbc26df3e6fe40d30496477398205d6a9fac066f16e25ba40d95e44f375346095aeb36a571046427a1b4c23ceebc4e7', 'Active', 4, NULL, 'Abu Hammad', '2024-04-23', 'hamza_aslam', '2024-04-27'),
(10, 'javeryia_hassan', 'hammad@gmail.com', '$2y$10$oy0Ors4acUtl5tYqXJbQJ.iM8ErOsKJpBbB7dVJH0G.s6qn9H8nxu', 1, '7db58ea907dd35e45204be11f97a66e7f25296a33b6feba9e8294a9fbbcf03956d5d3a2c51e75476e5c7bd0b9df901178a4b', 'Active', 10, '2024-04-24 12:18:23', 'Abu Hammad', '2024-04-24', 'hamza_aslam', '2024-04-28'),
(11, 'javeriad', 'javeria.hassan77@gmail.com', '$2y$10$jkTqQDdmdoFEs99p3Mq0t.i65TEKqrLs3WWy2kf.BPA6RXvhd7E9O', 1, 'c3680ce73b92cff782d081f299027f40f0c18c8957a89048cd8f02c3d54f94b121bcce2dc2e8c982fc4478355756cf126769', 'Active', 11, NULL, 'Abu Hammad', '2024-04-27', 'hamza_aslam', '2024-04-27');

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
(3, 'Hammad Kamal', '03131192135', 'Landhi karachi', 'Male', '2003-11-07', '446617229_abu hammad.jpg', '2024-05-25 11:12:24', '2024-05-14 10:52:10', '2024-04-23', 'Abu Hammad', 'abu.hammad', '2024-05-20'),
(4, 'Abu Hammad', '03131197766', 'landhi karachi', 'Male', '2003-11-07', '371297085_Untitled design (25).png', '2024-05-14 09:14:42', '2024-05-14 10:51:43', '2024-04-23', 'Abu Hammad', 'hamza_aslam', '2024-05-14'),
(10, 'Javeryia ', '0313114566', 'landhi', 'Female', '2016-06-16', '494475144_Untitled design (26).png', '2024-04-25 11:17:59', '2024-04-25 11:17:08', '2024-04-24', 'Abu Hammad', 'hamza_aslam', '2024-04-28'),
(11, 'Javeria', '03131192763', 'DHA karachi Pakistan', 'Female', '2020-02-01', '177560230_t2.png', NULL, NULL, '2024-04-27', 'Abu Hammad', 'hamza_aslam', '2024-04-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `egate`
--
ALTER TABLE `egate`
  ADD PRIMARY KEY (`eGate_id`),
  ADD KEY `fk_house` (`house_id`),
  ADD KEY `fk_shop` (`shop_id`);

--
-- Indexes for table `events_booking`
--
ALTER TABLE `events_booking`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `maintenance_payments`
--
ALTER TABLE `maintenance_payments`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `servants`
--
ALTER TABLE `servants`
  ADD PRIMARY KEY (`servant_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`tenant_id`),
  ADD KEY `house_id` (`house_id`);

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
-- AUTO_INCREMENT for table `egate`
--
ALTER TABLE `egate`
  MODIFY `eGate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `house_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `maintenance_payments`
--
ALTER TABLE `maintenance_payments`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `servants`
--
ALTER TABLE `servants`
  MODIFY `servant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `tenant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users_detail`
--
ALTER TABLE `users_detail`
  MODIFY `users_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `egate`
--
ALTER TABLE `egate`
  ADD CONSTRAINT `fk_house` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`),
  ADD CONSTRAINT `fk_shop` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`);

--
-- Constraints for table `maintenance_payments`
--
ALTER TABLE `maintenance_payments`
  ADD CONSTRAINT `maintenance_payments_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`),
  ADD CONSTRAINT `maintenance_payments_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`);

--
-- Constraints for table `servants`
--
ALTER TABLE `servants`
  ADD CONSTRAINT `servants_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`);

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`);

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
