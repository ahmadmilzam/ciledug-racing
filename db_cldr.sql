-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2014 at 05:31 AM
-- Server version: 5.5.36
-- PHP Version: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_cldr`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(3, 'authors', 'Authors');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `excerpt` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `images` text NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `id_category` (`id_category`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` tinyint(4) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_category`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id_category`, `id_parent`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 0, 'category test', 'category-test', '2014-04-12 22:11:32', NULL),
(2, 0, 'category test 2', 'category-test-2', '2014-04-12 22:14:19', NULL),
(3, 1, 'cat', 'cat', '2014-04-13 04:31:54', NULL),
(4, 2, 'cat 2', 'cat-2', '2014-04-13 04:34:50', NULL),
(7, 4, 'cat 3', 'cat-3', '2014-04-13 05:44:00', NULL),
(8, 3, 'cat 4', 'cat-4', '2014-04-13 07:14:39', NULL),
(9, 0, 'cat 5', 'cat-5', '2014-04-13 07:32:25', NULL),
(10, 2, 'cat 6', 'cat-6', '2014-04-13 10:32:32', NULL),
(11, 0, 'cat 7', 'cat-7', '2014-04-13 10:35:29', NULL),
(12, 1, 'cat 8', 'cat-8', '2014-04-13 10:35:36', NULL),
(13, 2, 'cat 9', 'cat-9', '2014-04-13 10:36:42', NULL),
(14, 4, 'cat 10', 'cat-10', '2014-04-14 01:32:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('0b6ec99edf44116facefb03b8aec182d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36', 1397433398, 'a:9:{s:9:"user_data";s:0:"";s:8:"identity";s:14:"admin@cldr.com";s:8:"username";s:13:"administrator";s:10:"first_name";s:5:"Ahmad";s:9:"last_name";s:6:"Milzam";s:5:"email";s:14:"admin@cldr.com";s:7:"user_id";s:1:"1";s:14:"old_last_login";s:10:"1397429198";s:10:"created_on";s:10:"1268889823";}'),
('1a935c8fe057db5bedef1db290990253', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36', 1397429193, 'a:9:{s:9:"user_data";s:0:"";s:8:"identity";s:14:"admin@cldr.com";s:8:"username";s:13:"administrator";s:10:"first_name";s:5:"Ahmad";s:9:"last_name";s:6:"Milzam";s:5:"email";s:14:"admin@cldr.com";s:7:"user_id";s:1:"1";s:14:"old_last_login";s:10:"1397425588";s:10:"created_on";s:10:"1268889823";}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) NOT NULL DEFAULT '',
  `forgotten_password_code` varchar(40) NOT NULL DEFAULT '',
  `forgotten_password_time` int(11) unsigned NOT NULL DEFAULT '0',
  `remember_code` varchar(40) NOT NULL DEFAULT '',
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '\0\0', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '9462e8eee0', 'admin@cldr.com', '', '', 0, '', 1268889823, 1397433403, 1, 'Ahmad', 'Milzam', 'ADMIN', '0'),
(2, '\0\0', 'author satu', '$2a$08$.iw3epkqlvmBeLMqwPMFuetG.4DqIxSxQO6036aWzqmGxkLGpo2Cy', '', 'author@ahmadmilzam.com', '', '', 0, '', 1393746454, 1393746454, 1, 'author', 'satu', '', '091234890547'),
(3, '\0\0', 'asdas asdasd', '$2a$08$/7OxqwraJcjMBZGC.BPNyO3iyq.tADtf3GH5bGNBeglsik82EMFZG', '', 'asdasd@ahmadmilzam.com', '', '', 0, '', 1393746527, 1393746527, 1, 'asdas', 'asdasd', '', '097798799879'),
(4, '\0\0', 'asasd asdasdasd', '$2a$08$/tuRAJwAcbE3gLtgb2/Gf.w9uaYkYjoryAMTUYtPBJbnDbQ7pzeAC', '', 'abi.rafdi20@gmail.com', '', '', 0, '', 1393756484, 1393756484, 1, 'asasd', 'asdasdasd', '', '908098039248'),
(5, '\0\0', 'asdsadasd asdasdsad', '$2a$08$u6z4rpAIVzS8a2CsuqIeuufPrrvrV5xoeE1JzlnEsdNLKfgc/IjxK', '', 'sadasdasd@asdasd.com', '', '', 0, '', 1393757069, 1393757069, 1, 'asdsadasd', 'ASDASDSAD', '', '1231231');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(10, 1, 1),
(12, 1, 3),
(3, 2, 3),
(5, 3, 3),
(7, 4, 3),
(9, 5, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
