-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 28, 2022 at 03:01 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sorena`
--

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

DROP TABLE IF EXISTS `reserve`;
CREATE TABLE IF NOT EXISTS `reserve` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_uid` int(11) DEFAULT NULL,
  `r_code_meli` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_name` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_fname` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_tel` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_code_posti` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_date_vorod` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_date_khoroj` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_meghdar_eghamat` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_tedad_otagh` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_tedad_hamrah` char(32) COLLATE utf8_persian_ci NOT NULL,
  `r_adres` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`r_id`),
  KEY `reserve_ibfk_1` (`r_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `reserve`
--

INSERT INTO `reserve` (`r_id`, `r_uid`, `r_code_meli`, `r_name`, `r_fname`, `r_tel`, `r_code_posti`, `r_date_vorod`, `r_date_khoroj`, `r_meghdar_eghamat`, `r_tedad_otagh`, `r_tedad_hamrah`, `r_adres`) VALUES
(1, 5, '32151515656', 'سعید', 'حکیمی', '09132026598', '54545151515', '1400/08/05', '1400/11/05', '3 ماه', '1', '5', 'تهران خیابان همدانیان کوچه شهید باقری پلاک 241'),
(2, 4, '6598565264', 'ناهید', 'شجاعی', '09233659887', '545452112', '1400/02/25', '1400/02/30', '5 روز', '1', '5', 'تبریز خیابان ملک کوچه باقری پلاک 23'),
(4, 6, '0101565646', 'رضا', 'محمدی', '03132326484', '8199883645', '1400/05/01', '1400/07/01', '2 ماه', '1', '1', 'اصفهان-خ پروین -بعد از چهار راه اول- مجتمع کاج'),
(5, 10, '2222252255', 'کامران', 'مولایی', '61561656', '1561565566', '1400/01/01', '1400/01/15', '15 روز', '1', '1', 'کرج- خ امیر کبیر شمالی- بعد از چهار راه سوم - جنب نانوایی'),
(80, 4, '1564498489', 'حامد', 'سعادتمند', '02152936174', '1589897987', '1401/01/01', '1401/01/13', '13 روز', '1', '5', 'قم-خیابان آذر- بعد از پاساژ مولوی-مجتمع کاج');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_username` varchar(50) NOT NULL DEFAULT '',
  `u_email` varchar(50) NOT NULL DEFAULT '',
  `u_password` varchar(50) NOT NULL DEFAULT '',
  `u_usertype` varchar(25) NOT NULL DEFAULT 'register',
  `u_activation` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_username`, `u_email`, `u_password`, `u_usertype`, `u_activation`) VALUES
(1, 'admin', 'admin@sorena.com', 'admin', 'admin', b'1'),
(2, 'paziresh', 'paziresh@sorena.com', '1234', 'paziresh', b'1'),
(4, 'nahid', 'nahid@gmail.com', '1234', 'register', b'1'),
(5, 'saeed', 'saeed@gmail.com', '12345', 'register', b'1'),
(6, 'reza', 'reza@gmail.com', '1234', 'register', b'1'),
(7, 'karrim', 'mosavi@gmail.com', '1234', 'register', b'1'),
(8, 'mahsa', 'mahsa@sorena.com', '12345', 'register', b'1'),
(9, 'ahmad', 'ahmad@sorena.com', '1111', 'register', b'1'),
(10, 'kamran', 'kamran@gmail.com', '137786', 'register', b'1'),
(12, 'kamiyar', 'kamiyar@gmail.com', '1234', 'register', b'1'),
(75, 'mehdi', 'mehdi@gmail.com', 'sa123', 'register', b'1'),
(85, 'zandevakili', 'zandevakili@gmail.com', '1234', 'register', b'1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `reserve_ibfk_1` FOREIGN KEY (`r_uid`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
