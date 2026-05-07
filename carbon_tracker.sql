-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 03:58 PM
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
-- Database: `carbon_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `transport_log`
--

CREATE TABLE `transport_log` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `distance_km` float NOT NULL,
  `carbon_emissions` float NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_log`
--

INSERT INTO `transport_log` (`id`, `vehicle_type`, `distance_km`, `carbon_emissions`, `log_date`, `user_id`) VALUES
(1, 'Car', 20, 4, '2026-05-05 14:21:01', NULL),
(2, 'Car', 10, 2, '2026-05-05 14:41:43', NULL),
(3, 'Bus', 50, 10, '2026-05-05 14:42:15', NULL),
(4, 'Bike', 80, 16, '2026-05-05 14:42:44', NULL),
(5, 'Train', 100, 20, '2026-05-05 14:43:09', NULL),
(6, 'Car', 60, 12, '2026-05-05 14:49:55', NULL),
(7, 'Train', 200, 2, '2026-05-05 14:58:45', 1),
(8, 'Car', 30, 6, '2026-05-05 14:58:53', 1),
(9, 'Bike', 180, 3.6, '2026-05-05 16:15:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'test', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transport_log`
--
ALTER TABLE `transport_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transport_log`
--
ALTER TABLE `transport_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
