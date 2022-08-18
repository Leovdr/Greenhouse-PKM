-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2022 at 07:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkm_greenhouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dashboard`
--

CREATE TABLE `tbl_dashboard` (
  `id_dashboard` int(11) NOT NULL,
  `suhu` float NOT NULL,
  `kelembapan` float NOT NULL,
  `ph_tanah` float NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_dashboard`
--

INSERT INTO `tbl_dashboard` (`id_dashboard`, `suhu`, `kelembapan`, `ph_tanah`, `tanggal`) VALUES
(1, 33, 75, 6.8, '2022-08-18'),
(2, 29, 74.5, 7, '2022-08-17'),
(4, 33, 75, 6.8, '2022-08-17'),
(5, 55, 90, 7.6, '2022-08-16'),
(6, 47, 45, 6.3, '2022-08-15'),
(7, 40, 20, 4.5, '2022-08-14'),
(8, 36, 52, 5.5, '2022-08-13'),
(9, 33, 65, 6.2, '2022-08-12'),
(10, 31, 57, 6.7, '2022-08-11'),
(11, 30, 63, 7.1, '2022-08-10'),
(12, 29, 65, 6.9, '2022-08-09'),
(13, 20, 94, 8.9, '2022-08-08'),
(14, 33, 75, 6.8, '2022-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_final`
--

CREATE TABLE `tbl_final` (
  `id_final` int(11) NOT NULL,
  `suhu` float NOT NULL,
  `kelembapan` float NOT NULL,
  `ph_tanah` float NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dashboard`
--
ALTER TABLE `tbl_dashboard`
  ADD PRIMARY KEY (`id_dashboard`);

--
-- Indexes for table `tbl_final`
--
ALTER TABLE `tbl_final`
  ADD PRIMARY KEY (`id_final`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dashboard`
--
ALTER TABLE `tbl_dashboard`
  MODIFY `id_dashboard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_final`
--
ALTER TABLE `tbl_final`
  MODIFY `id_final` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
