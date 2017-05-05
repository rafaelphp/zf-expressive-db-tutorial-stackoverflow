-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost - ciudad del este PY - github: @ozzpy
-- Generation Time: May 05, 2017 at 06:52 
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expressive`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_group_id` int(11) NOT NULL,
  `users_username` varchar(45) NOT NULL,
  `users_password` varchar(128) NOT NULL,
  `users_insert_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `users_status` varchar(45) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_group_id`, `users_username`, `users_password`, `users_insert_date`, `users_update_date`, `users_status`) VALUES
(1, 1, 'webmaster', '12345', '2017-05-05 00:52:25', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users_group`
--

CREATE TABLE `users_group` (
  `users_group_id` int(2) NOT NULL,
  `users_group_name` varchar(45) NOT NULL,
  `users_group_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='admin\n';

--
-- Dumping data for table `users_group`
--

INSERT INTO `users_group` (`users_group_id`, `users_group_name`, `users_group_status`) VALUES
(1, 'admin', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD KEY `index2` (`users_username`),
  ADD KEY `index3` (`users_password`),
  ADD KEY `index5` (`users_status`),
  ADD KEY `fk_users_users_group_idx` (`users_group_id`);

--
-- Indexes for table `users_group`
--
ALTER TABLE `users_group`
  ADD PRIMARY KEY (`users_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users_group`
--
ALTER TABLE `users_group`
  MODIFY `users_group_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_users_group` FOREIGN KEY (`users_group_id`) REFERENCES `users_group` (`users_group_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
