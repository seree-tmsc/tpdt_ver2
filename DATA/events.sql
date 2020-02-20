-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 03:14 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutorial`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) NOT NULL,
  `resourceID` int(4) NOT NULL,
  `mat_code` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `mat_name` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `lot_no` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `rx_no` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `batch_size` decimal(7,2) NOT NULL,
  `startdate` datetime DEFAULT NULL,
  `planning_enddate` datetime DEFAULT NULL,
  `actual_enddate` datetime NOT NULL,
  `pd_status` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `resourceID`, `mat_code`, `mat_name`, `lot_no`, `rx_no`, `batch_size`, `startdate`, `planning_enddate`, `actual_enddate`, `pd_status`) VALUES
(91, 1, 'ENR225000-DR000200', 'U-VAN 225', 'CL8123', '1', '4500.00', '2018-11-13 08:00:00', '2018-11-13 18:00:00', '2018-11-13 18:00:00', 'O'),
(92, 2, 'ENR286000-DR000200', 'U-VAN 28-60', 'CL8010', '2', '2500.00', '2018-11-13 09:00:00', '2018-11-13 19:00:00', '2018-11-13 19:00:00', 'O'),
(93, 3, 'ENR48B000-DR000200', 'U-VAN 48B', 'CL8098', '3', '4400.00', '2018-11-13 10:00:00', '2018-11-13 20:00:00', '2018-11-13 20:00:00', 'O'),
(94, 4, 'ENR62E000-DR000200', 'U-VAN 62E', 'CL8055', '4', '4000.00', '2018-11-13 11:00:00', '2018-11-13 21:00:00', '2018-11-13 21:00:00', 'O'),
(95, 5, 'ENGAL9009-DR000200', 'ALMATEX-A-9009', 'CL8063', '5', '2500.00', '2018-11-13 12:00:00', '2018-11-13 22:00:00', '2018-11-13 22:00:00', 'O'),
(96, 6, 'ENJQ17090-DR000200', 'OLESTER Q1709', 'CL8009', '6', '4000.00', '2018-11-13 13:00:00', '2018-11-13 23:00:00', '2018-11-13 23:00:00', 'O'),
(97, 7, 'ENJQ70000-DR000200', 'OLESTER Q700', 'CL8085', '7', '3800.00', '2018-11-13 14:00:00', '2018-11-14 00:00:00', '2018-11-14 00:00:00', 'O'),
(98, 8, 'ENJQC4175-DR000200', 'OLESTER QC417-5', 'CL8066', '8', '3600.00', '2018-11-13 15:00:00', '2018-11-14 01:00:00', '2018-11-14 01:00:00', 'O'),
(99, 9, 'ENJQC418H-DR000200', 'OLESTER QC418HT', 'CL8077', '9', '1500.00', '2018-11-13 16:00:00', '2018-11-14 02:00:00', '2018-11-14 02:00:00', 'O'),
(100, 1, 'ENR225000-DR000200', 'U-VAN 225', 'CL8123', '1', '4500.00', '2018-11-13 21:00:00', '2018-11-15 13:00:00', '2018-11-15 13:00:00', 'O'),
(101, 2, 'ENR286000-DR000200', 'U-VAN 28-60', 'CL8010', '2', '2500.00', '2018-11-13 21:00:00', '2018-11-14 12:00:00', '2018-11-14 12:00:00', 'O'),
(102, 3, 'ENR48B000-DR000200', 'U-VAN 48B', 'CL8098', '3', '4400.00', '2018-11-13 21:00:00', '2018-11-14 14:00:00', '2018-11-14 14:00:00', 'O'),
(103, 4, 'ENR62E000-DR000200', 'U-VAN 62E', 'CL8055', '4', '4000.00', '2018-11-13 22:00:00', '2018-11-14 08:00:00', '2018-11-14 08:00:00', 'O'),
(104, 5, 'ENGAL9009-DR000200', 'ALMATEX-A-9009', 'CL8063', '5', '2500.00', '2018-11-14 00:00:00', '2018-11-14 22:00:00', '2018-11-14 22:00:00', 'O'),
(105, 6, 'ENJQ17090-DR000200', 'OLESTER Q1709', 'CL8009', '6', '4000.00', '2018-11-14 00:00:00', '2018-11-14 15:00:00', '2018-11-14 15:00:00', 'O'),
(106, 7, 'ENJQ70000-DR000200', 'OLESTER Q700', 'CL8085', '7', '3800.00', '2018-11-14 02:00:00', '2018-11-15 09:00:00', '2018-11-15 09:00:00', 'O'),
(107, 8, 'ENJQC4175-DR000200', 'OLESTER QC417-5', 'CL8066', '8', '3600.00', '2018-11-14 05:00:00', '2018-11-15 01:00:00', '2018-11-15 01:00:00', 'O'),
(108, 9, 'ENJQC418H-DR000200', 'OLESTER QC418HT', 'CL8077', '9', '1500.00', '2018-11-14 06:00:00', '2018-11-15 02:00:00', '2018-11-15 02:00:00', 'O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
