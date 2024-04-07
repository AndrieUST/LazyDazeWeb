-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 12:30 PM
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
(29, 'johnlinga0949@gmail.com', '$2y$10$P8s7e1hxcg12UgqcqS8xFud5iSRKLUNnVOo5b7ts4oNKCVFl1Dq02', '502514');

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
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `managecart`
--

INSERT INTO `managecart` (`id`, `Customer_Email`, `Size`, `Product_Name`, `Quantity`, `Price`, `img`) VALUES
(113, 'johnangelo.linga.shs@ust.edu.ph', 'Medium', 'Ninja Black Tee from manila 2', 1, 500, 'sample-tshirt1.png');

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
(10, 'johnangelo.linga.cics@ust.edu.ph', 'mika', 'blahblahbalbh');

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
  `Product_ID` int(200) NOT NULL,
  `Customer_Email` varchar(200) NOT NULL,
  `Customer_Address` varchar(200) NOT NULL,
  `Product_Name` varchar(200) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Quantity` int(200) NOT NULL,
  `Price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(54, 'Ninja Black Tee from manila ', 'goods', 2, 2, 2, 1, 500, 'sample-shirt.png'),
(55, 'Ninja Black Tee from manila 2', 'comfortable', 1, 2, 2, 0, 500, 'sample-tshirt1.png');

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

--
-- Dumping data for table `managereview`
--

INSERT INTO `managereview` (`ReviewID`, `Customer_Email`, `Customer_Name`, `Review_Message`, `Rating`, `Product_Name`) VALUES
(32, 'doffy0949@gmail.com', 'john john', 'hehe', '1', 'Ninja Black Tee from manila 2'),
(33, 'johnangelo.linga.shs@ust.edu.ph', 'migz', 'gehehe', '1', 'Ninja Black Tee from manila 2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(9) NOT NULL,
  `Customer_Email` varchar(255) NOT NULL,
  `Customer_Address` varchar(255) NOT NULL,
  `Customer_Number` varchar(20) NOT NULL,
  `Customer_PW` varchar(255) NOT NULL,
  `verification_code` text NOT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Customer_Email`, `Customer_Address`, `Customer_Number`, `Customer_PW`, `verification_code`, `email_verified_at`) VALUES
(57, 'doffy0949@gmail.com', '123', '123', '$2y$10$EsHWzCuSopG30PQh2wKQZuCefYOD3wrd7qXLmKxBkp5suXSSBOaBW', '142394', '2024-03-31 02:51:54'),
(60, 'torontondo08@gmail.com', '1263 Don Quijote street sampaloc manila', '09950240166', '$2y$10$/XfGpG/Y4EYdz3L/fk.PiuKiQA.mVvu87Yliyf/eXZMbqbsQRrYPy', '303211', '2024-03-06 19:23:59'),
(61, 'kylehernandez2002@gmail.com', '1212121', '1213121', '$2y$10$kf8WanedMGBZPXTuNyiP.uFn736Jqn6kpp9fr5xsHkW.BNvsAKKiq', '299992', '2024-03-06 23:26:23'),
(62, 'mikafeliiix@gmail.com', '21213', '09950240166', '$2y$10$NE4cG2MVpkZtdkhk7oKE1OvqoLZOa2unsJMhx./j5pimsaFncUoOy', '356111', '2024-03-06 23:45:23'),
(65, 'johnangelo.linga.cics@ust.edu.ph', '1263 Don Quijote street sampaloc manila', '09950240166', '$2y$10$SZLp6sK2MUDZl/mcM8SpE.9M3y7QzGIhXXI66xcZADnGRhzAmXEjO', '363054', '2024-04-04 21:29:03'),
(68, 'johnangelo.linga.shs@ust.edu.ph', '1263 Don Quijote street sampaloc manila', '09950240166', '$2y$10$E4vT0EjWc0Swq0RJaz4oX.QQx6rDvcftcfQrIy8TJkvGuKOx55Tuu', '313559', '2024-04-06 20:20:06');

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
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `manageinquiry`
--
ALTER TABLE `manageinquiry`
  MODIFY `InquiryID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `manageinventory`
--
ALTER TABLE `manageinventory`
  MODIFY `Product_ID` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manageorders`
--
ALTER TABLE `manageorders`
  MODIFY `OrderRefID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manageprod`
--
ALTER TABLE `manageprod`
  MODIFY `ProductID` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `managereview`
--
ALTER TABLE `managereview`
  MODIFY `ReviewID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
