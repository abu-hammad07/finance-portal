-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 07:29 PM
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
-- Database: `finance-portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `entity_type` varchar(10) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `alert_message` varchar(255) DEFAULT NULL,
  `alert_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `egate`
--

INSERT INTO `egate` (`eGate_id`, `house_id`, `shop_id`, `house_or_shop`, `vehicle_number`, `vehicle_name`, `vehicle_color`, `eGateperson_name`, `eGate_cnic`, `eGate_charges_type`, `eGate_charges`, `payment_type`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(2, 18, NULL, 'house', 'abc-3214', 'Yamaha', 'black', 'Hassan Ali', '232222222434', 'Renew', '60000', 'Cash', '2024-06-14', 'abu.hammad', '2024-07-19', 'abu.hammad'),
(3, NULL, 6, 'shop', 'abc-32144', 'Yamaha', 'White', 'Ahmed', '232222222434', 'New Card', '60000', 'Bank', '2024-07-22', 'abu.hammad', NULL, NULL),
(4, 19, NULL, 'house', 'abc-32144', 'Honda', 'White', 'Ahmed', '232222222434', 'Renew', '60000', 'Cash', '2024-07-24', 'abu.hammad', NULL, NULL),
(5, 19, NULL, 'house', 'abc-32144', 'Honda', 'White', 'Ahmed', '232222222434', 'Renew', '60000', 'Cash', '2024-07-24', 'abu.hammad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employeeID` varchar(255) DEFAULT NULL,
  `employee_full_name` varchar(255) DEFAULT NULL,
  `employee_cnic` varchar(255) DEFAULT NULL,
  `employee_qualification` varchar(255) DEFAULT NULL,
  `employee_contact` varchar(255) DEFAULT NULL,
  `employee_email` varchar(255) DEFAULT NULL,
  `employee_address` varchar(255) DEFAULT NULL,
  `employee_image` varchar(255) DEFAULT NULL,
  `appointment_date` varchar(255) DEFAULT NULL,
  `employement_type` enum('permanent','contract') DEFAULT NULL,
  `QRcode` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employeeID`, `employee_full_name`, `employee_cnic`, `employee_qualification`, `employee_contact`, `employee_email`, `employee_address`, `employee_image`, `appointment_date`, `employement_type`, `QRcode`, `department`, `designation`, `salary`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(37, '#-0001', 'Abu Hammad', '333333333', 'PHP', '03131192139', 'hammadking427@gmail.com', 'House No.2598 Street #6, 36/G Landhi', '733976563_doplexer (3).png', '2024-07-10', 'permanent', '1720563578#-0001.png', 'IT', 'Manager', '79093', '2024-07-10 03:19:38', 'abu.hammad', NULL, NULL),
(38, '#-0002', 'Abu Hammad', '22222222222', 'PHD', '3333333333333', 'shazi.ssuet@gmail.com', '36/G Landhi Karachi', '144945439_staff-id-card.png', '2024-07-10', 'permanent', NULL, 'IT', 'Manager', '230000', '2024-07-10', 'abu.hammad', NULL, NULL),
(39, '#-0003', 'Abu Hammad', '222222', 'PHD', '32', 'shazi.ssuet@gmail.com', '36/G Landhi Karachi', '291129892_slide-1.jpg', '2024-07-10', 'contract', '1720592956#-0003.png', 'IT', 'Manager', '230000', '2024-07-10 11:29:16', 'abu.hammad', NULL, NULL);

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
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_booking`
--

INSERT INTO `events_booking` (`event_id`, `eventName`, `location`, `date`, `startTiming`, `endTiming`, `noOfPersons`, `eventType`, `customerCnic`, `customerContact`, `customerName`, `bookingPayment`, `payment_type`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(11, 'shaddi', 'Shadi Hall', '2024-07-05', '01:16', '13:18', '89', '8798', '878979', '878979', '9890', '8798', 'Bank', 'hamza_aslam', '2024-02-04', NULL, NULL),
(12, 'shaddi', 'Shadi Hall', '2024-07-05', '01:14', '01:14', '89', '8798', '87987', '8798798', '9890', '8789', 'Cash', 'hamza_aslam', '2024-05-04', NULL, NULL),
(13, 'School Party', 'Shadi Hall', '2024-07-03', '18:43', '17:43', '13', '455555555', '655555555', '444444', 'Hammad', '65555555', 'Bank', 'abu.hammad', '2024-07-13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `house_id` int(11) NOT NULL,
  `house_number` varchar(255) DEFAULT NULL,
  `house_or_shop` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_contact` varchar(255) DEFAULT NULL,
  `owner_cnic` varchar(255) DEFAULT NULL,
  `occupancy_status` varchar(255) DEFAULT NULL,
  `property_size` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `maintenance_charges` varchar(255) DEFAULT NULL,
  `added_on` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `updated_on` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`house_id`, `house_number`, `house_or_shop`, `owner_name`, `owner_contact`, `owner_cnic`, `occupancy_status`, `property_size`, `floor`, `property_type`, `maintenance_charges`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(17, '9876', NULL, 'Hammad', '776678447', '985336788', 'owned', '240 yards', 'floor2', 'Apartment', '33333', '2024-07-13', 'abu.hammad', NULL, NULL),
(18, '3452', NULL, 'Afmed', '3333333334', '5555555556', 'owned', '240 yards', 'floor2', 'Duplex', '33333', '2024-07-13', 'abu.hammad', NULL, NULL),
(19, '65437', NULL, 'Afmed', '0313119318', '4250103226807', 'owned', '520 yards', 'floor3', 'Apartment', '8000', '2024-07-14', 'abu.hammad', NULL, NULL),
(20, '23976', NULL, 'Anus', '233333334', '4333333333', 'owned', '240 yards', 'floor3', 'Apartment', '14000', '2024-08-07', 'abu.hammad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_payments`
--

CREATE TABLE `maintenance_payments` (
  `maintenance_id` int(11) NOT NULL,
  `house_shop_id` int(255) DEFAULT NULL,
  `shop_id` int(255) DEFAULT NULL,
  `house_or_shop` varchar(255) NOT NULL,
  `maintenance_month` varchar(255) NOT NULL,
  `maintenance_peyment` int(255) NOT NULL,
  `status` varchar(22) NOT NULL DEFAULT 'unpaid',
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `added_on` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `updated_on` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance_payments`
--

INSERT INTO `maintenance_payments` (`maintenance_id`, `house_shop_id`, `shop_id`, `house_or_shop`, `maintenance_month`, `maintenance_peyment`, `status`, `payment_type`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(40, 17, NULL, 'house', 'July,2024', 33333, 'Paid', 'Cash', '2024-07-13', 'abu.hammad', '2024-07-23', 'abu.hammad'),
(41, NULL, 6, 'shop', 'July,2024', 300, 'Paid', 'Cash', '2024-07-13', 'abu.hammad', '2024-07-14', 'abu.hammad'),
(42, 18, NULL, 'house', 'July,2024', 33333, 'Paid', 'Cash', '2024-07-13', 'abu.hammad', '2024-07-14', 'abu.hammad'),
(43, 19, NULL, 'house', 'July,2024', 8000, 'Paid', 'Bank', '2024-07-14', 'abu.hammad', '2024-07-14', 'abu.hammad'),
(44, NULL, 7, 'shop', 'August,2024', 50000, 'unpaid', NULL, '2024-08-06', 'abu.hammad', '', ''),
(45, NULL, 8, 'shop', 'August,2024', 25000, 'unpaid', NULL, '2024-08-06', 'abu.hammad', '', ''),
(46, NULL, 9, 'shop', 'August,2024', 12000, 'unpaid', NULL, '2024-08-06', 'abu.hammad', '', ''),
(47, NULL, 10, 'shop', 'August,2024', 50000, 'unpaid', NULL, '2024-08-06', 'abu.hammad', '', ''),
(48, 20, NULL, 'house', 'August,2024', 14000, 'unpaid', NULL, '2024-08-07', 'abu.hammad', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payroll_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `employee_salary` int(255) NOT NULL,
  `month_year` varchar(7) DEFAULT NULL,
  `total_working_days` int(11) DEFAULT NULL,
  `days_absent` int(11) DEFAULT NULL,
  `days_leave` int(11) DEFAULT NULL,
  `days_present` int(11) DEFAULT NULL,
  `absent_deduction` decimal(10,2) DEFAULT NULL,
  `total_salary` decimal(10,2) DEFAULT NULL,
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `added_by` varchar(255) DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`payroll_id`, `employee_id`, `employee_salary`, `month_year`, `total_working_days`, `days_absent`, `days_leave`, `days_present`, `absent_deduction`, `total_salary`, `payment_type`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(2, 39, 230000, '2024-08', 30, 0, 0, 30, NULL, 230000.00, NULL, '2024-08-06 19:00:00', 'abu.hammad', '2024-08-07 06:23:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payroll_pdfs`
--

CREATE TABLE `payroll_pdfs` (
  `pdf_no` int(11) NOT NULL,
  `payroll_id` varchar(255) NOT NULL,
  `payroll_pdf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_pdfs`
--

INSERT INTO `payroll_pdfs` (`pdf_no`, `payroll_id`, `payroll_pdf`) VALUES
(9, '2', '%PDF-1.3\n3 0 obj\n<</Type /Page\n/Parent 1 0 R\n/Resources 2 0 R\n/Contents 4 0 R>>\nendobj\n4 0 obj\n<</Filter /FlateDecode /Length 219>>\nstream\nx?m?MK?@????Q???&?lnJZP\n.???Z]??	J??I[1??qx?g>$nLy??ŵ?j# 41?cK	??FȾ?b??C@?;?-v1a??b?=n?\n?\\¾?⫍??sF]P&???');

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(11) NOT NULL,
  `penalty_type` varchar(255) NOT NULL,
  `penalty_cnic` varchar(55) NOT NULL,
  `penalty_charges` int(55) NOT NULL,
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`id`, `penalty_type`, `penalty_cnic`, `penalty_charges`, `payment_type`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(4, 'Rode Crose', '4250145554027', 5000, 'Cash', 'hamza_aslam', '2024-07-05', 'abu.hammad', '2024-07-23 12:32:22'),
(5, 'No Parking', '433333333333', 500, 'Cash', 'abu.hammad', '2024-08-05', NULL, NULL),
(6, 'For accident', '6666666666634', 1500, 'Cash', 'abu.hammad', '2024-08-05', NULL, NULL),
(7, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(8, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(9, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(10, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(11, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(12, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(13, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(14, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(15, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(16, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(17, 'No Parking', '44444444443', 500, 'Bank', 'hammad', '2024-08-05', NULL, NULL),
(18, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(19, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(20, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(21, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(22, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(23, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(24, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(25, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(26, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(27, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(28, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(29, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(30, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(31, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(32, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(33, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(34, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(35, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(36, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(37, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(38, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(39, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(40, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(41, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(42, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(43, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(44, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(45, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(46, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(47, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(48, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL),
(49, 'No Parking', '44444444443', 500, 'Bank', 'hammad', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `payment_type` enum('Cash','Bank') DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servants`
--

INSERT INTO `servants` (`servant_id`, `house_id`, `servantDesignation`, `servantFees`, `payment_type`, `added_by`, `added_on`, `updated_by`, `updated_on`) VALUES
(1, 18, 'Manager', '8000', 'Cash', '3', '2024-05-14', NULL, NULL),
(2, 18, 'Manager', '500', 'Bank', '3', '2024-07-22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL,
  `shop_number` varchar(255) DEFAULT NULL,
  `house_or_shop` varchar(22) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shop_id`, `shop_number`, `house_or_shop`, `owner_name`, `owner_contact`, `owner_cnic`, `occupancy_status`, `property_size`, `floor`, `property_type`, `maintenance_charges`, `added_on`, `added_by`, `updated_on`, `updated_by`) VALUES
(6, '123465', '', 'Afzal', '34333333333', '55555555555555', 'owned', '60 sq yards', 'ground', '', '300', '2024-05-13', 'abu.hammad', '2024-08-06', 'abu.hammad'),
(7, '432', '', 'Ghani', '544444444444', '46666666666', 'rented', '60 sq yards', 'ground', '', '50000', '2024-08-06', 'abu.hammad', '2024-08-06', 'abu.hammad'),
(8, '65421', '', 'Ghani', '34333333333', '3444444444345', 'rented', '60 sq yards', 'ground', '', '25000', '2024-08-06', 'abu.hammad', '2024-08-06', 'abu.hammad'),
(9, '87647', '', 'Rehman', '34333333333', '3444444444345', 'rented', 'floor3', '', '520b yards', '12000', '2024-08-06', 'abu.hammad', NULL, NULL),
(10, '85477', '', 'Rehman', '03143444442', '55555555555555', 'rented', 'floor3', '', '240 yards', '50000', '2024-08-06', 'abu.hammad', NULL, NULL);

--
-- Triggers `shops`
--
DELIMITER $$
CREATE TRIGGER `before_shop_insert` BEFORE INSERT ON `shops` FOR EACH ROW BEGIN
    SET NEW.added_on = CURDATE();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `society_maintenance`
--

CREATE TABLE `society_maintenance` (
  `society_maint_id` int(11) NOT NULL,
  `society_maint_type` varchar(55) NOT NULL,
  `society_maint_amount` int(55) NOT NULL,
  `society_maint_dueDate` varchar(55) NOT NULL,
  `society_maint_paymentDate` varchar(55) NOT NULL,
  `society_maint_comments` tinytext NOT NULL,
  `added_on` varchar(55) DEFAULT NULL,
  `added_by` varchar(55) DEFAULT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `updated_on` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `society_maintenance`
--

INSERT INTO `society_maintenance` (`society_maint_id`, `society_maint_type`, `society_maint_amount`, `society_maint_dueDate`, `society_maint_paymentDate`, `society_maint_comments`, `added_on`, `added_by`, `updated_by`, `updated_on`) VALUES
(2, 'Water Bill', 30000, '2024-08-09', '2024-08-07', 'Done', '2024-08-07', 'abu.hammad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `tenant_id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `house_or_shop` varchar(100) NOT NULL,
  `tenant_name` varchar(100) NOT NULL,
  `tenant_contact_no` varchar(100) DEFAULT NULL,
  `tenant_cnic` varchar(100) DEFAULT NULL,
  `tenant_image` varchar(255) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `added_on` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_detail`
--

INSERT INTO `users_detail` (`users_detail_id`, `full_name`, `Phone`, `address`, `gender`, `date_of_birth`, `image`, `login_time`, `logout_time`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(3, 'Hammad Kamal', '03131192135', 'landhi karachi', 'Male', '2003-11-07', '446617229_abu hammad.jpg', '2024-08-08 17:22:01', '2024-08-05 12:00:06', '2024-04-23', 'Abu Hammad', 'abu.hammad', '2024-08-05'),
(4, 'Abu Hammad', '03131197766', 'landhi karachi', 'Male', '2003-11-07', '371297085_Untitled design (25).png', '2024-07-13 11:30:32', '2024-05-30 16:16:24', '2024-04-23', 'Abu Hammad', 'hamza_aslam', '2024-05-14'),
(10, 'Javeryia ', '0313114566', 'landhi', 'Female', '2016-06-16', '494475144_Untitled design (26).png', '2024-04-25 11:17:59', '2024-04-25 11:17:08', '2024-04-24', 'Abu Hammad', 'hamza_aslam', '2024-04-28'),
(11, 'Javeria', '03131192763', 'DHA karachi Pakistan', 'Female', '2020-02-01', '177560230_t2.png', NULL, NULL, '2024-04-27', 'Abu Hammad', 'hamza_aslam', '2024-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `utility_charges`
--

CREATE TABLE `utility_charges` (
  `utility_id` int(11) NOT NULL,
  `utility_type` varchar(55) NOT NULL,
  `utility_amount` int(55) NOT NULL,
  `utility_billing_month` varchar(55) NOT NULL,
  `utility_location` varchar(55) NOT NULL,
  `added_on` varchar(55) DEFAULT NULL,
  `added_by` varchar(55) DEFAULT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `updated_on` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utility_charges`
--

INSERT INTO `utility_charges` (`utility_id`, `utility_type`, `utility_amount`, `utility_billing_month`, `utility_location`, `added_on`, `added_by`, `updated_by`, `updated_on`) VALUES
(2, 'water', 6000, '2024-07', 'Sports Area', '2024-07-17', 'abu.hammad', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egate`
--
ALTER TABLE `egate`
  ADD PRIMARY KEY (`eGate_id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

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
  ADD PRIMARY KEY (`maintenance_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payroll_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payroll_pdfs`
--
ALTER TABLE `payroll_pdfs`
  ADD PRIMARY KEY (`pdf_no`);

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
-- Indexes for table `society_maintenance`
--
ALTER TABLE `society_maintenance`
  ADD PRIMARY KEY (`society_maint_id`);

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
-- Indexes for table `utility_charges`
--
ALTER TABLE `utility_charges`
  ADD PRIMARY KEY (`utility_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `egate`
--
ALTER TABLE `egate`
  MODIFY `eGate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `maintenance_payments`
--
ALTER TABLE `maintenance_payments`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payroll_pdfs`
--
ALTER TABLE `payroll_pdfs`
  MODIFY `pdf_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `servants`
--
ALTER TABLE `servants`
  MODIFY `servant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `society_maintenance`
--
ALTER TABLE `society_maintenance`
  MODIFY `society_maint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `tenant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `utility_charges`
--
ALTER TABLE `utility_charges`
  MODIFY `utility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `egate`
--
ALTER TABLE `egate`
  ADD CONSTRAINT `egate_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `egate_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `servants`
--
ALTER TABLE `servants`
  ADD CONSTRAINT `servants_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tenants`
--
ALTER TABLE `tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
