-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2022 at 04:46 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comp3334_group2`
--
CREATE DATABASE IF NOT EXISTS `comp3334_group2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `comp3334_group2`;

-- --------------------------------------------------------

--
-- Table structure for table `produce`
--

CREATE TABLE IF NOT EXISTS `produce` (
  `product_id` int(50) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_price` int(50) NOT NULL,
  `product_owner` varchar(255) NOT NULL,
  `product_key` varchar(255) DEFAULT NULL,
  `product_dir` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `polycoin` int(255) NOT NULL,
  PRIMARY KEY (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
