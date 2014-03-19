-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2014 at 05:09 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timer`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients_developers`
--

CREATE TABLE IF NOT EXISTS `clients_developers` (
  `client_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`,`developer_id`),
  KEY `IDX_748A0DE019EB6921` (`client_id`),
  KEY `IDX_748A0DE064DD9267` (`developer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clients_developers`
--

INSERT INTO `clients_developers` (`client_id`, `developer_id`) VALUES
(4, 2),
(4, 3),
(5, 2),
(5, 3),
(7, 2),
(7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `memus`
--

CREATE TABLE IF NOT EXISTS `memus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `developer_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7033B696166D1F9C` (`project_id`),
  KEY `IDX_7033B69664DD9267` (`developer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `memus`
--

INSERT INTO `memus` (`id`, `project_id`, `developer_id`, `title`, `status`) VALUES
(11, 2, 2, 'New Memodsasd', 1),
(12, 1, 3, 'UI Design', 1),
(13, 2, 2, 'Working with Joomla............', 1),
(14, 2, 2, 'New Memo', 0),
(15, 2, 2, 'Again Joomla.............', 1),
(16, 2, 2, 'Working.......', 1),
(17, 4, 6, 'This is test memo 1', 1),
(18, 4, 6, 'memo 2\n', 1),
(19, 4, 6, 'memo 3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `starting_date` datetime DEFAULT NULL,
  `closing_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5C93B3A419EB6921` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `title`, `starting_date`, `closing_date`, `status`) VALUES
(1, 4, 'Magento Project', '2013-05-30 08:26:12', '2013-05-30 08:27:13', 0),
(2, 4, 'Joomla', '2013-05-25 03:08:36', NULL, 1),
(3, 5, 'DotNET', '2013-05-30 08:24:52', '2013-06-06 10:58:10', 0),
(4, 7, 'Tracker', '2013-09-10 16:23:47', NULL, 1),
(5, 4, 'Test', '2014-03-14 07:49:46', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects_developers`
--

CREATE TABLE IF NOT EXISTS `projects_developers` (
  `project_id` int(11) NOT NULL,
  `developer_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`developer_id`),
  KEY `IDX_BD0EDF20166D1F9C` (`project_id`),
  KEY `IDX_BD0EDF2064DD9267` (`developer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects_developers`
--

INSERT INTO `projects_developers` (`project_id`, `developer_id`) VALUES
(1, 2),
(1, 3),
(2, 2),
(2, 3),
(3, 2),
(4, 2),
(4, 6),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE IF NOT EXISTS `time_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memu_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `image` longblob,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D06D4AC8B7793C2` (`memu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `developer_id` int(11) DEFAULT NULL,
  `memo_id` int(11) DEFAULT NULL,
  `sessionToken` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5F37A13B5A2FE0E` (`sessionToken`),
  KEY `IDX_5F37A13B166D1F9C` (`project_id`),
  KEY `IDX_5F37A13B64DD9267` (`developer_id`),
  KEY `IDX_5F37A13BB4D32439` (`memo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `project_id`, `developer_id`, `memo_id`, `sessionToken`, `start_time`, `duration`, `status`) VALUES
(1, NULL, 3, NULL, '5215f1fa2137d3.49462936', NULL, NULL, 0),
(2, NULL, 3, NULL, '52164175666268.20256567', NULL, NULL, 0),
(3, 2, 2, 13, '52164496edaec0.70008606', '2013-08-22 12:10:35', 6, 0),
(5, 4, 6, 19, '522f8e675a9483.61589335', '2013-09-10 17:27:36', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `access_type` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `access_type`, `user_type`, `created_date`, `status`) VALUES
(1, 'Admin', 'arif04cuet@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500', 1, 1, '2013-05-07 00:00:00', 1),
(2, 'rokon', 'rokon@gmail.com', 'rokon', 'f7fbd9e849dcddedfb6d6c53ba7cd871', 2, 3, '2013-05-07 17:49:14', 1),
(3, 'mamun', 'mamun@gmail.com', 'mamun', '6872edadd43c2a34f3ce1284f425a2f0', 2, 3, '2013-05-07 17:49:43', 1),
(4, 'arif', 'arif@gmail.com', 'arif', 'd53d757c0f838ea49fb46e09cbcc3cb1', 1, 2, '2013-05-07 17:50:06', 1),
(5, 'sakib', 'sakib@gmail.com', 'sakib', '0192023a7bbd73250516f069df18b500', 1, 2, '2013-05-07 17:50:29', 1),
(6, 'Michael', 'michael@epochds.com', 'michael', '0acf4539a14b3aa27deeb4cbdf6e989f', 2, 3, '2013-09-10 16:22:41', 1),
(7, 'Test Client', 'michael@epochds.com', 'michael', '0acf4539a14b3aa27deeb4cbdf6e989f', 1, 2, '2013-09-10 16:23:23', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `FK_5F37A13B166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `FK_5F37A13B64DD9267` FOREIGN KEY (`developer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_5F37A13BB4D32439` FOREIGN KEY (`memo_id`) REFERENCES `memus` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
