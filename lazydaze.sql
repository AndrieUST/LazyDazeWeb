-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 05:05 PM
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
  `Description` int(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `Price` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(57, 'doffy0949@gmail.com', '123', '123', '$2y$10$EsHWzCuSopG30PQh2wKQZuCefYOD3wrd7qXLmKxBkp5suXSSBOaBW', '152551', '2024-03-05 05:25:24'),
(58, 'johnlinga0949@gmail.com', '1263 Don Quijote street sampaloc manila', '09950240166', '$2y$10$eLoNvMB6luxcUKLDjLH9/.To9mwt7KyExN83DvBIvg6tDE3zP1QEu', '331534', '2024-03-06 23:56:49'),
(60, 'torontondo08@gmail.com', '1263 Don Quijote street sampaloc manila', '09950240166', '$2y$10$/XfGpG/Y4EYdz3L/fk.PiuKiQA.mVvu87Yliyf/eXZMbqbsQRrYPy', '303211', '2024-03-06 19:23:59'),
(61, 'kylehernandez2002@gmail.com', '1212121', '1213121', '$2y$10$kf8WanedMGBZPXTuNyiP.uFn736Jqn6kpp9fr5xsHkW.BNvsAKKiq', '299992', '2024-03-06 23:26:23'),
(62, 'mikafeliiix@gmail.com', '21213', '09950240166', '$2y$10$NE4cG2MVpkZtdkhk7oKE1OvqoLZOa2unsJMhx./j5pimsaFncUoOy', '356111', '2024-03-06 23:45:23');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manageorders`
--
ALTER TABLE `manageorders`
  MODIFY `OrderRefID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manageprod`
--
ALTER TABLE `manageprod`
  MODIFY `ProductID` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
