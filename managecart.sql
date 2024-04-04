-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2024 at 07:47 PM
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
-- Table structure for table `managecart`
--

CREATE TABLE `managecart` (
  `id` int(30) NOT NULL,
  `Size` char(9) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `Price` int(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `managecart`
--

INSERT INTO `managecart` (`id`, `Size`, `Product_Name`, `Quantity`, `Price`, `img`) VALUES
(1, '', 'Ninja Black Tee from manila ', 2, 2000, 'sample-shirt2.jpg'),
(2, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(3, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(4, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(5, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(6, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(7, '', 'Ninja Black Tee from manila 4', 3, 350, 'sample-shirt.png'),
(8, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(9, '', 'Ninja Black Tee from manila 4', 3, 350, 'sample-shirt.png'),
(10, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(11, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
(12, '', 'Ninja Black Tee from manila ', 2, 2000, 'sample-shirt2.jpg'),
(13, '', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `managecart`
--
ALTER TABLE `managecart`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `managecart`
--
ALTER TABLE `managecart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
