-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 05:42 PM
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
-- Database: `lazydaze`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(20) NOT NULL,
  `Admin_Email` varchar(50) NOT NULL,
  `Admin_PW` varchar(255) NOT NULL,
  `verification_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Admin_Email`, `Admin_PW`, `verification_code`) VALUES
(29, 'johnlinga0949@gmail.com', '$2y$10$14VyaSCxka2vA185gB.WB.tzUQQvEAgN6L709/Fig.wqG3BkdEiy6', '266768');

-- --------------------------------------------------------

--
-- Table structure for table `managecart`
--

CREATE TABLE `managecart` (
  `id` int(30) NOT NULL,
  `Customer_Email` varchar(255) NOT NULL,
  `Size` char(9) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `Price` int(200) NOT NULL,
  `TotalPrice` int(200) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managecart`
--

INSERT INTO `managecart` (`id`, `Customer_Email`, `Size`, `Product_Name`, `Quantity`, `Price`, `TotalPrice`, `img`) VALUES
(376, 'johnangelo.linga.cics@ust.edu.ph', 'Medium', 'White Tee', 1, 500, 500, 'Shirt (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `manageinquiry`
--

CREATE TABLE `manageinquiry` (
  `InquiryID` int(200) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Inquiry_Message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manageorders`
--

CREATE TABLE `manageorders` (
  `OrderRefID` int(200) NOT NULL,
  `ProductID` int(200) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Name` varchar(200) NOT NULL,
  `Customer_HouseNumber` varchar(200) NOT NULL,
  `Customer_Street` varchar(200) NOT NULL,
  `Customer_Barangay` varchar(200) NOT NULL,
  `Customer_City` varchar(200) NOT NULL,
  `Customer_Postal` int(200) NOT NULL,
  `Customer_Number` varchar(200) NOT NULL,
  `Product_Name` varchar(200) NOT NULL,
  `Price` int(200) NOT NULL,
  `Size` varchar(200) NOT NULL,
  `Quantity` int(200) NOT NULL,
  `Prod_Cost` int(200) NOT NULL,
  `TotalPrice` int(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `Receipt_img` varchar(200) NOT NULL,
  `Confirmed` tinyint(1) DEFAULT 0,
  `Status` varchar(50) NOT NULL DEFAULT 'Pending',
  `Order_Date` datetime NOT NULL,
  `Date_Completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageorders`
--

INSERT INTO `manageorders` (`OrderRefID`, `ProductID`, `Customer_Email`, `Customer_Name`, `Customer_HouseNumber`, `Customer_Street`, `Customer_Barangay`, `Customer_City`, `Customer_Postal`, `Customer_Number`, `Product_Name`, `Price`, `Size`, `Quantity`, `Prod_Cost`, `TotalPrice`, `img`, `Receipt_img`, `Confirmed`, `Status`, `Order_Date`, `Date_Completed`) VALUES
(108, 75, 'johnangelo.linga.shs@ust.edu.ph', '', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'Short Tee', 600, 'XL', 3, 450, 1800, 'Shirt (3).png', 'uploads/receipt.png', 1, 'Received', '2024-04-28 20:58:23', '2024-04-28 21:08:37'),
(109, 74, 'johnangelo.linga.shs@ust.edu.ph', '', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'Long Tee', 400, 'Medium', 2, 300, 800, 'Shirt (2).png', 'uploads/receipt.png', 1, 'Received', '2024-04-28 20:58:23', '2024-04-28 21:08:43'),
(110, 75, 'johnangelo.linga.shs@ust.edu.ph', '', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'Short Tee', 600, 'Small', 1, 450, 600, 'Shirt (3).png', 'uploads/receipt.png', 2, 'Refunded', '2024-04-28 21:10:37', '2024-04-28 21:11:47'),
(111, 73, 'andriepaulm@gmail.com', '', 'University Tower 2', 'Galicia', 'Sampaloc', 'Manila', 1008, '639620001111', 'White Tee', 500, 'Medium', 2, 400, 1000, 'Shirt (1).png', 'uploads/gcash-qr.png', 1, 'Pending', '2024-04-28 23:26:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manageprod`
--

CREATE TABLE `manageprod` (
  `ProductID` int(200) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Quantity_Small` int(30) NOT NULL,
  `Quantity_Medium` int(30) NOT NULL,
  `Quantity_Large` int(30) NOT NULL,
  `Quantity_XL` int(30) NOT NULL,
  `Prod_Cost` int(200) NOT NULL,
  `Price` int(200) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageprod`
--

INSERT INTO `manageprod` (`ProductID`, `Product_Name`, `Description`, `Quantity_Small`, `Quantity_Medium`, `Quantity_Large`, `Quantity_XL`, `Prod_Cost`, `Price`, `img`) VALUES
(73, 'White Tee', 'Better', 5, 1, 6, 1, 400, 500, 'Shirt (1).png'),
(74, 'Long Tee', 'good', 3, 1, 0, 1, 300, 400, 'Shirt (2).png'),
(75, 'Short Tee', 'comfy', 0, 0, 4, 0, 450, 600, 'Shirt (3).png');

-- --------------------------------------------------------

--
-- Table structure for table `managereview`
--

CREATE TABLE `managereview` (
  `ReviewID` int(20) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Name` varchar(200) NOT NULL,
  `Review_Message` varchar(200) NOT NULL,
  `Rating` varchar(200) NOT NULL,
  `Product_Name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managereview`
--

INSERT INTO `managereview` (`ReviewID`, `Customer_Email`, `Customer_Name`, `Review_Message`, `Rating`, `Product_Name`) VALUES
(48, 'johnangelo.linga.shs@ust.edu.ph', 'migz', 'gege', '1', 'Short Tee'),
(49, 'johnangelo.linga.shs@ust.edu.ph', 'john', 'gege', '1', 'Long Tee');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `qr_code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `payment_method`, `qr_code`) VALUES
(13, 'GCash', 'qr_codes/gcash-qr.png'),
(14, 'Maya', 'qr_codes/paymaya-qr.png'),
(15, 'BPI', 'qr_codes/BPI-qr.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `Customer_Email` varchar(255) NOT NULL,
  `Customer_HouseNumber` varchar(200) NOT NULL,
  `Customer_Street` varchar(200) NOT NULL,
  `Customer_Barangay` varchar(200) NOT NULL,
  `Customer_City` varchar(200) NOT NULL,
  `Customer_Postal` int(200) NOT NULL,
  `Customer_Number` varchar(20) NOT NULL,
  `Customer_PW` varchar(255) NOT NULL,
  `verification_code` text NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `Confirmed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Customer_Email`, `Customer_HouseNumber`, `Customer_Street`, `Customer_Barangay`, `Customer_City`, `Customer_Postal`, `Customer_Number`, `Customer_PW`, `verification_code`, `email_verified_at`, `Confirmed`) VALUES
(138, 'doffy0949@gmail.com', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', '$2y$10$D9JIfkqfyuh7yELjloD0sOGuA692p2vnLlsF6dTTVgMOgBNoyZuqO', '235023', NULL, 0),
(140, 'johnangelo.linga.shs@ust.edu.ph', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', '$2y$10$u2dFsauWp4Wocrg9VmtiLeru1MSLdTPCrr4/bcqHY3blWMyEmpCJm', '310614', '2024-04-28 16:00:24', 1),
(141, 'johnangelo.linga.cics@ust.edu.ph', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', '$2y$10$qxkh.MMKD85lNIGFaE2bpuxId/VbNsfn0Hk3b9cB1F.5ln2BBWbyW', '289328', '2024-04-28 21:19:04', 1),
(142, 'andriepaulm@gmail.com', 'University Tower 2', 'Galicia', 'Sampaloc', 'Manila', 1008, '639620001111', '$2y$10$YVU/z7Ii02ex6jrq/mqfCOpgAEUVVwDhkSTQmzgMkPOvmg9sSFfG.', '188481', '2024-04-28 22:26:35', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managecart`
--
ALTER TABLE `managecart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manageinquiry`
--
ALTER TABLE `manageinquiry`
  ADD PRIMARY KEY (`InquiryID`);

--
-- Indexes for table `manageorders`
--
ALTER TABLE `manageorders`
  ADD PRIMARY KEY (`OrderRefID`);

--
-- Indexes for table `manageprod`
--
ALTER TABLE `manageprod`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `managereview`
--
ALTER TABLE `managereview`
  ADD PRIMARY KEY (`ReviewID`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `managecart`
--
ALTER TABLE `managecart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `manageinquiry`
--
ALTER TABLE `manageinquiry`
  MODIFY `InquiryID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `manageorders`
--
ALTER TABLE `manageorders`
  MODIFY `OrderRefID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `manageprod`
--
ALTER TABLE `manageprod`
  MODIFY `ProductID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `managereview`
--
ALTER TABLE `managereview`
  MODIFY `ReviewID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
