-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 15, 2020 at 02:30 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hetic_meteora`
--

-- --------------------------------------------------------

--
-- Table structure for table `meteorite_landings`
--

CREATE TABLE `meteorite_landings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `recclass` varchar(30) NOT NULL,
  `mass` int(11) NOT NULL,
  `found` tinyint(1) NOT NULL,
  `year` year(4) NOT NULL,
  `reclat` decimal(10,0) DEFAULT NULL,
  `reclong` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meteorite_landings`
--
ALTER TABLE `meteorite_landings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `year` (`year`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
