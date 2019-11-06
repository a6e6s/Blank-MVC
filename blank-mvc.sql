-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2019 at 07:49 AM
-- Server version: 5.7.26
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
-- Database: `blank-mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `permissions` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `name`, `description`, `permissions`, `status`, `create_date`, `modified_date`) VALUES
(1, 'الإدارة', 'مجموعه تملك كافة الصلاحيات', '{\"admin_login\":{\"view\":\"1\"},\"Associations\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Donations\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Donors\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Groups\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Members\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Pages\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Settings\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"},\"Users\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete\":\"1\"}}', 1, 1543493061, 1549312322),
(2, 'الاشراف', 'مجموعة تملك صلاحيات التعديل والاضافة والعرض', '{\"admin_login\":{\"view\":\"1\"},\"Groups\":{\"index\":\"1\",\"add\":\"1\"},\"Users\":{\"index\":\"1\",\"add\":\"1\"}}', 1, 1543746264, 1544079169),
(3, 'المراقبين', '', '{\"admin_login\":{\"view\":\"1\"},\"Groups\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\"},\"Pages\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\"},\"Settings\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\"},\"Users\":{\"index\":\"1\",\"search\":\"1\",\"show\":\"1\",\"status\":\"1\",\"add\":\"1\",\"edit\":\"1\"}}', 1, 1549259804, 1572870120);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `hits` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `status` tinyint(1) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modified_date` int(11) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `image` tinytext,
  `bio` text,
  `activation_code` varchar(100) DEFAULT NULL,
  `request_password_time` int(11) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `login_date` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `modified_date` int(11) DEFAULT NULL,
  `create_date` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `groups` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `mobile`, `image`, `bio`, `activation_code`, `request_password_time`, `group_id`, `login_date`, `status`, `modified_date`, `create_date`) VALUES
(22, 'احمد المهدي', 'a6e6s1@gmail.com', '$2y$10$veHBsCh4q39J.k0MPGKfDuHhraBWnyQmnhoBVRIA1rZyL.eLAp61a', '597767751', 'thuma6e.png', '', '98783', 0, 1, 1572356041, 1, 1572954134, 1543831099),
(23, 'Monyb Younos', 'munybe@gmail.com', '$2y$10$Raf3iUVZJPQr4//YEBuypO.fWDuSWTRZPDmCa7.Ta84v21ZFWl056', '0597767751', 'logo-xl.png', '', NULL, NULL, 3, NULL, 1, 1572786141, 1572786123);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
