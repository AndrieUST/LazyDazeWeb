-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 07:28 PM
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
-- Table structure for table `manageprod2`
--

CREATE TABLE `manageprod2` (
  `Size` char(9) NOT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Quantity` int(30) NOT NULL,
  `Price` int(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manageprod2`
--

INSERT INTO `manageprod2` (`Size`, `Product_Name`, `Quantity`, `Price`, `img`) VALUES
('', 'Ninja Black Tee from manila 4', 3, 350, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila 4', 3, 350, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila 4', 0, 350, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila 4', 3, 350, 'sample-shirt.png'),
('', 'Ninja Black Tee from manila ', 12121, 2000, 'sample-shirt.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
