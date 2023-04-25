-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: sg2nlmysql11plsk.secureserver.net:3306
-- Generation Time: Apr 25, 2023 at 02:21 AM
-- Server version: 5.7.26-29-log
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdbmail`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminclient`
--

CREATE TABLE `adminclient` (
  `id` int(11) NOT NULL,
  `kundennummer` int(11) NOT NULL,
  `mail` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adminclient`
--

INSERT INTO `adminclient` (`id`, `kundennummer`, `mail`) VALUES
(612, 1047, 'inhausen.webtvcampus.de'),
(613, 1047, 'jmassmann.webtvcampus.de'),
(1012, 1047, 'froehlich.webtvcampus.de'),
(1013, 1035, 'dietril@klinikum-koeln.de');

-- --------------------------------------------------------

--
-- Table structure for table `mailinfo`
--

CREATE TABLE `mailinfo` (
  `mailinfo_id` int(11) NOT NULL,
  `adminid` varchar(250) NOT NULL,
  `kundennummer` varchar(250) NOT NULL,
  `mailtype` varchar(20) NOT NULL,
  `fromaddress` varchar(250) NOT NULL,
  `toaddress` varchar(250) NOT NULL,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `filename` varchar(250) NOT NULL,
  `date` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminclient`
--
ALTER TABLE `adminclient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailinfo`
--
ALTER TABLE `mailinfo`
  ADD PRIMARY KEY (`mailinfo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminclient`
--
ALTER TABLE `adminclient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;

--
-- AUTO_INCREMENT for table `mailinfo`
--
ALTER TABLE `mailinfo`
  MODIFY `mailinfo_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
