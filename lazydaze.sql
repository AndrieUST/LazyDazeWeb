-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 05:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `manageinquiry`
--

CREATE TABLE `manageinquiry` (
  `InquiryID` int(200) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Inquiry_Message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manageinquiry`
--

INSERT INTO `manageinquiry` (`InquiryID`, `Customer_Email`, `Customer_Name`, `Inquiry_Message`) VALUES
(5, 'doffy0949@gmail.com', 'doffy', 'hleo'),
(6, 'doffy0949@gmail.com', 'doffy', 'helo'),
(7, 'doffy0949@gmail.com', 'Migz', 'blahbahblabh'),
(8, 'doffy0949@gmail.com', 'migz', 'blahbalahlbajaouasfiaushf0asf'),
(9, 'doffy0949@gmail.com', 'doffy', 'adadafafa'),
(10, 'johnangelo.linga.cics@ust.edu.ph', 'mika', 'blahblahbalbh'),
(11, 'johnangelo.linga.cics@ust.edu.ph', 'doffy', 'geghe'),
(12, 'johnangelo.linga.shs@ust.edu.ph', 'doffy', 'hehe');

-- --------------------------------------------------------

--
-- Table structure for table `manageinventory`
--

CREATE TABLE `manageinventory` (
  `Product_ID` int(30) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Quantity` int(200) NOT NULL,
  `Price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `manageorders`
--

CREATE TABLE `manageorders` (
  `OrderRefID` int(200) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Name` varchar(200) NOT NULL,
  `Customer_HouseNumber` varchar(200) NOT NULL,
  `Customer_Street` varchar(200) NOT NULL,
  `Customer_Barangay` varchar(200) NOT NULL,
  `Customer_City` varchar(200) NOT NULL,
  `Customer_Postal` int(200) NOT NULL,
  `Customer_Number` varchar(200) NOT NULL,
  `Product_Name` varchar(200) NOT NULL,
  `Size` varchar(200) NOT NULL,
  `Quantity` int(200) NOT NULL,
  `TotalPrice` int(200) NOT NULL,
  `img` varchar(200) NOT NULL,
  `Receipt_img` varchar(200) NOT NULL,
  `Confirmed` tinyint(1) DEFAULT 0,
  `Status` varchar(50) NOT NULL DEFAULT 'Pending',
  `Order_Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manageorders`
--

INSERT INTO `manageorders` (`OrderRefID`, `Customer_Email`, `Customer_Name`, `Customer_HouseNumber`, `Customer_Street`, `Customer_Barangay`, `Customer_City`, `Customer_Postal`, `Customer_Number`, `Product_Name`, `Size`, `Quantity`, `TotalPrice`, `img`, `Receipt_img`, `Confirmed`, `Status`, `Order_Date`) VALUES
(85, 'johnangelo.linga.cics@ust.edu.ph', 'tt', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'Long tee', 'Small', 1, 300, 'Shirt (7).png', 'uploads/receipt.png', 2, 'Refunded', '2024-04-24 23:15:22'),
(86, 'johnangelo.linga.cics@ust.edu.ph', 'tt', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'Long tee', 'Medium', 1, 300, 'Shirt (7).png', 'uploads/receipt.png', 1, 'Delivering', '2024-04-24 23:15:22'),
(87, 'johnangelo.linga.cics@ust.edu.ph', '', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', 'White- Tshirt', 'Medium', 2, 400, 'Shirt (5).png', 'uploads/receipt.png', 1, 'Received', '2024-04-24 23:17:11');

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
  `Price` int(200) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manageprod`
--

INSERT INTO `manageprod` (`ProductID`, `Product_Name`, `Description`, `Quantity_Small`, `Quantity_Medium`, `Quantity_Large`, `Quantity_XL`, `Price`, `img`) VALUES
(66, 'White- Tshirt', 'goodies ', 2, 1, 2, 5, 200, 'Shirt (5).png'),
(67, 'Ninja white', 'bettererrrr', 2, 3, 4, 4, 500, 'Shirt (3).png'),
(68, 'Long tee', 'hehe', 0, 0, 4, 3, 300, 'Shirt (7).png');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `qr_code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `payment_method`, `qr_code`) VALUES
(13, 'gcash', 'qr_codes/gcash-qr.png'),
(14, 'paymaya', 'qr_codes/paymaya-qr.png'),
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
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Customer_Email`, `Customer_HouseNumber`, `Customer_Street`, `Customer_Barangay`, `Customer_City`, `Customer_Postal`, `Customer_Number`, `Customer_PW`, `verification_code`, `email_verified_at`) VALUES
(105, 'johnangelo.linga.cics@ust.edu.ph', '1263', 'Don Quijote street sampaloc manila', '489', 'MANILA CITY', 1008, '9950240166', '$2y$10$v6YNnUpBpI77P1lFpfLM7u.NeBXpfBfdS6zfE0Lh/HFvaxwjvD8ym', '125872', '2024-04-21 21:12:23');

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
-- Indexes for table `manageinventory`
--
ALTER TABLE `manageinventory`
  ADD PRIMARY KEY (`Product_ID`);

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `manageinquiry`
--
ALTER TABLE `manageinquiry`
  MODIFY `InquiryID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `manageinventory`
--
ALTER TABLE `manageinventory`
  MODIFY `Product_ID` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manageorders`
--
ALTER TABLE `manageorders`
  MODIFY `OrderRefID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `manageprod`
--
ALTER TABLE `manageprod`
  MODIFY `ProductID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `managereview`
--
ALTER TABLE `managereview`
  MODIFY `ReviewID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
