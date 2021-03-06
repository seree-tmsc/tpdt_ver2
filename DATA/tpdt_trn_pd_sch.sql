-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2019 at 04:10 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pd_webapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tpdt_trn_pd_sch`
--

CREATE TABLE `tpdt_trn_pd_sch` (
  `Order` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Planning plant` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Material Number` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Material description` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Batch` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Production Version` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `MRP controller` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Order Type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Order quantity` decimal(18,2) DEFAULT NULL,
  `Uom` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Basic start date` date DEFAULT NULL,
  `Basic start time` time DEFAULT NULL,
  `Basic finish date` date DEFAULT NULL,
  `Basic finish time` time DEFAULT NULL,
  `Deletion flag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RX No` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Actual start date` date DEFAULT NULL,
  `Actual start time` time DEFAULT NULL,
  `Actual finish date` date DEFAULT NULL,
  `Actual finish time` time DEFAULT NULL,
  `Pd Status` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tpdt_trn_pd_sch`
--

INSERT INTO `tpdt_trn_pd_sch` (`Order`, `Planning plant`, `Material Number`, `Material description`, `Batch`, `Production Version`, `MRP controller`, `Order Type`, `Order quantity`, `Uom`, `Basic start date`, `Basic start time`, `Basic finish date`, `Basic finish time`, `Deletion flag`, `RX No`, `Actual start date`, `Actual start time`, `Actual finish date`, `Actual finish time`, `Pd Status`) VALUES
('1013611', 'RB11', 'RKVV221G0-DR000100', 'VINYLAX-221G', 'CA7001', '0001', 'F02', 'PP01', '8200.00', 'KG', '2018-12-06', '08:30:00', '2018-12-07', '00:30:00', '', 'RX-01', '2018-12-06', '08:30:22', '0000-00-00', '00:00:00', 'O'),
('1013612', 'RB11', 'ENGSE2013-BLK01000', 'ALMATEX SE 2013', 'CA7001', '0001', 'F02', 'PP01', '9519.12', 'KG', '2018-12-06', '08:00:00', '2018-12-07', '00:00:00', '', 'RX-02', '2018-12-06', '08:00:40', '0000-00-00', '00:00:00', 'O'),
('1013613', 'RB11', 'RKA105700-DR000080', 'ACRYLAX-1057', 'CA7001', '0001', 'F02', 'PP01', '10023.02', 'KG', '2018-12-06', '08:00:00', '2018-12-07', '16:00:00', '', 'RX-03', '2018-12-06', '08:00:01', '0000-00-00', '00:00:00', 'O'),
('1013614', 'RB11', 'RKA221300-DR000100', 'ACRYLAX-2213', 'CA7001', '0001', 'F02', 'PP01', '4800.00', 'KG', '2018-12-06', '08:10:00', '2018-12-07', '20:10:00', '', 'RX-04', '2018-12-06', '08:00:11', '0000-00-00', '00:00:00', 'O'),
('1013615', 'RB11', 'RKA220600-DRN00120', 'ACRYLAX-2206', 'CA7001', '0001', 'F02', 'PP01', '1740.28', 'KG', '2018-12-06', '08:15:00', '2018-12-07', '20:15:00', '', 'RX-05', '2018-12-06', '08:00:18', '0000-00-00', '00:00:00', 'O'),
('1013616', 'RB11', 'ENCH3150B-BLK01000', 'HOPELON-3150B', 'CA7001', '0001', 'F02', 'PP01', '4099.35', 'KG', '2018-12-06', '08:30:00', '2018-12-07', '20:30:00', '', 'RX-06', '2018-12-06', '08:30:27', '0000-00-00', '00:00:00', 'O'),
('1013657', 'RB11', 'RKBB610CT-PB000120', 'PROMINATE BMST-610CT', 'CA7001', '0001', 'F01', 'PP01', '4000.00', 'KG', '2018-12-09', '08:30:00', '2018-12-10', '08:30:00', '', 'RX-06', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013658', 'RB11', 'ENFB34100-DR000200', 'ALMATEX B341', 'CA7001', '0001', 'F01', 'PP01', '5049.00', 'KG', '2018-12-06', '09:00:00', '2018-12-07', '17:00:00', '', 'RX-07', '2018-12-06', '09:00:36', '0000-00-00', '00:00:00', 'O'),
('1013659', 'RB11', 'ENFL1093T-DR000200', 'ALMATEX L1093T', 'CA7001', '0002', 'F01', 'PP01', '7125.20', 'KG', '2018-12-06', '06:00:00', '2018-12-07', '02:00:00', '', 'RX-08', '2018-12-06', '06:00:46', '0000-00-00', '00:00:00', 'O'),
('1013660', 'RB11', 'ENR286000-DR000200', 'U-VAN 28-60', 'CA7001', '0001', 'F01', 'PP01', '6982.00', 'KG', '2018-12-06', '06:30:00', '2018-12-07', '03:00:00', '', 'RX-09', '2018-12-06', '06:30:58', '0000-00-00', '00:00:00', 'O'),
('1013661', 'RB11', 'ENR286000-DR000200', 'U-VAN 28-60', 'CA7002', '0001', 'F01', 'PP01', '6982.00', 'KG', '2018-12-06', '04:30:00', '2018-12-07', '04:00:00', '', 'RX-10', '2018-12-06', '04:00:07', '0000-00-00', '00:00:00', 'O'),
('1013663', 'RB11', 'ENFP64600-DR000200', 'ALMATEX P646', 'CA7001', '0001', 'F01', 'PP01', '10062.00', 'KG', '2018-12-09', '09:00:00', '2018-12-10', '09:00:00', '', 'RX-07', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013665', 'RB11', 'ENFL90900-DR000200', 'ALMATEX L9090', 'CA7001', '0001', 'F01', 'PP01', '7083.20', 'KG', '2018-12-08', '08:30:00', '2018-12-09', '08:30:00', '', 'RX-01', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013669', 'RB11', 'ENFL10020-DR000190', 'ALMATEX L1002', 'CA7001', '0001', 'F01', 'PP01', '5138.02', 'KG', '2018-12-08', '08:00:00', '2018-12-09', '08:00:00', '', 'RX-02', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013670', 'RB11', 'ENFL5446T-DR000200', 'ALMATEX L5446T', 'CA7001', '0001', 'F01', 'PP01', '8000.00', 'KG', '2018-12-09', '06:00:00', '2018-12-10', '06:00:00', '', 'RX-08', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013671', 'RB11', 'ENR20N600-DR000200', 'U-VAN 20N60', 'CA7001', '0001', 'F01', 'PP01', '8573.00', 'KG', '2018-12-08', '08:00:00', '2018-12-09', '08:00:00', '', 'RX-03', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013672', 'RB11', 'ENR20N600-DR000200', 'U-VAN 20N60', 'CA7002', '0001', 'F01', 'PP01', '8300.00', 'KG', '2018-12-09', '06:30:00', '2018-12-10', '06:30:00', '', 'RX-09', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013673', 'RB11', 'RKOSN500B-CN000250', 'SN-500B', '770101', '0001', 'F01', 'PP01', '1399.72', 'KG', '2018-12-06', '05:00:00', '2018-12-07', '05:00:00', '', 'RX-11', '2018-12-06', '05:00:17', '0000-00-00', '00:00:00', 'O'),
('1013674', 'RB11', 'RKOSN500B-CN000250', 'SN-500B', '770102', '0001', 'F01', 'PP01', '1399.72', 'KG', '2018-12-09', '04:30:00', '2018-12-10', '04:30:00', '', 'RX-10', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013690', 'RB11', 'RKUTF1000-DR000100', 'U-RAMIN T-F-1', 'CL6006', '0001', 'F02', 'PP01', '300.00', 'KG', '2018-12-06', '05:00:00', '2018-12-07', '06:00:00', '', 'RX-12', '2018-12-06', '05:00:27', '0000-00-00', '00:00:00', 'O'),
('1013693', 'RB11', 'RKA950900-BLK01000', 'ACRYLAX-9509', 'CM6019', '0001', 'F02', 'PP01', '11260.00', 'KG', '2018-12-09', '05:00:00', '2018-12-10', '05:00:00', '', 'RX-11', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013694', 'RB11', 'RKVV60450-BX000020', 'VINYLAX-6045', 'CM6009', '0001', 'F02', 'PP01', '1054.00', 'KG', '2018-12-09', '05:00:00', '2018-12-10', '05:00:00', '', 'RX-12', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013696', 'RB11', 'UGMCM200R-KY000050', 'COSMONATE M-200', 'CM6005', '0001', 'F02', 'PP01', '250.00', 'KG', '2018-12-06', '10:15:00', '2018-12-07', '07:00:00', '', 'RX-13', '2018-12-06', '10:00:33', '0000-00-00', '00:00:00', 'O'),
('1013697', 'RB11', 'UGMCM200R-KY000054', 'COSMONATE M-200', 'CM6005', '0001', 'F02', 'PP01', '250.00', 'KG', '2018-12-06', '11:00:00', '2018-12-07', '08:00:00', '', 'RX-14', '2018-12-06', '11:00:49', '0000-00-00', '00:00:00', 'O'),
('1013698', 'RB11', 'RKVV25000-DR000100', 'VINYLAX-25', 'CA7001', '0001', 'F02', 'PP01', '4842.80', 'KG', '2018-12-09', '10:15:00', '2018-12-10', '10:15:00', '', 'RX-13', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013703', 'RB11', 'UGPMP2164-DR000200', 'MP-2164(D)', 'CA7002', '0001', 'F03', 'PP01', '1788.64', 'KG', '2018-12-09', '11:00:00', '2018-12-10', '11:00:00', '', 'RX-14', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013707', 'RB11', 'UGTCOTM20-DR000250', 'COSMONATE TM-20', 'CA7002', '0001', 'F03', 'PP01', '5625.00', 'KG', '2018-12-06', '12:00:00', '2018-12-07', '05:00:00', '', 'RX-15', '2018-12-06', '12:04:44', '0000-00-00', '00:00:00', 'O'),
('1013709', 'RB11', 'UGTCOTM20-DR000250', 'COSMONATE TM-20', 'CA7004', '0001', 'F03', 'PP01', '5625.00', 'KG', '2018-12-09', '12:00:00', '2018-12-10', '12:00:00', '', 'RX-15', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013712', 'RB11', 'UGMTM1556-DR000230', 'THAMATE-1556', 'CA7001', '0001', 'F03', 'PP01', '1300.00', 'KG', '2018-12-06', '15:00:00', '2018-12-07', '07:00:00', '', 'RX-16', '2018-12-06', '15:00:38', '0000-00-00', '00:00:00', 'O'),
('1013714', 'RB11', 'UGPRG1489-BLK02500', 'THAMOL RG-1489', 'CA7001', '0002', 'F03', 'PP01', '4793.85', 'KG', '2018-12-06', '14:20:00', '2018-12-07', '09:00:00', '', 'RX-17', '2018-12-06', '14:20:19', '0000-00-00', '00:00:00', 'O'),
('1013722', 'RB11', 'RKA106100-DR000200', 'ACRYLAX-1061', 'CA7001', '0001', 'F02', 'PP01', '4664.07', 'KG', '2018-12-08', '08:10:00', '2018-12-09', '08:10:00', '', 'RX-04', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013723', 'RB11', 'RKV6131N3-BLK01000', 'VINYLAX-6131N3', 'CA7001', '0001', 'F02', 'PP01', '6200.00', 'KG', '2018-12-09', '15:00:00', '2018-12-10', '15:00:00', '', 'RX-16', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013726', 'RB11', 'RKVV41000-DR000100', 'VINYLAX-41', 'CA7001', '0001', 'F02', 'PP01', '800.00', 'KG', '2018-12-09', '14:20:00', '2018-12-10', '14:20:00', '', 'RX-17', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013727', 'RB11', 'ENCH3150B-BLK01000', 'HOPELON-3150B', 'CA7003', '0001', 'F02', 'PP01', '4700.00', 'KG', '2018-12-09', '09:00:00', '2018-12-10', '08:30:00', '', 'RX-01', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013728', 'RB11', 'RKOSBBSA4-DR000080', 'STARBOND-BSA 4', 'CA7002', '0001', 'F02', 'PP01', '1042.40', 'KG', '2018-12-09', '10:00:00', '2018-12-10', '08:00:00', '', 'RX-02', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013756', 'RB11', 'UGPRG1489-BLK01000', 'THAMOL RG-1489', 'CA7002', '0001', 'F03', 'PP01', '10120.35', 'KG', '2018-12-09', '09:15:00', '2018-12-10', '08:00:00', '', 'RX-03', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013762', 'RB11', 'UGPHD1440-BLK01100', 'THAMOL HARD-1440', 'CA7001', '0001', 'F03', 'PP01', '10101.60', 'KG', '2018-12-09', '08:45:00', '2018-12-10', '08:10:00', '', 'RX-04', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013817', 'RB11', 'ESAEM2300-CN000150', 'ESTAR EM23', 'CA7001', '0001', 'F01', 'PP01', '100.00', 'KG', '2018-12-08', '08:15:00', '2018-12-09', '08:15:00', '', 'RX-05', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', ''),
('1013836', 'RB11', 'ENGSE2013-DRN00120', 'ALMATEX SE 2013', 'CA7001', '0001', 'F02', 'PP01', '240.00', 'KG', '2018-12-09', '09:00:00', '2018-12-10', '08:15:00', '', 'RX-05', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tpdt_trn_pd_sch`
--
ALTER TABLE `tpdt_trn_pd_sch`
  ADD PRIMARY KEY (`Order`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
