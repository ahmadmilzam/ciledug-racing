-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2014 at 11:42 AM
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
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `link` varchar(100) DEFAULT NULL,
  `enable_on` date NOT NULL,
  `disable_on` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
-- Table structure for table `image_gallery`
--

CREATE TABLE IF NOT EXISTS `image_gallery` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `alt` varchar(100) DEFAULT NULL,
  `caption` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `image_gallery`
--

INSERT INTO `image_gallery` (`id_img`, `filename`, `alt`, `caption`) VALUES
(2, '2ee687766f48a20c94b5e7af4950a363.jpg', 'Laptop macbook mantap punya', 'Laptop macbook super duper mantap punya'),
(3, '24e406b325346d563bf1610e4c881008.jpg', NULL, NULL),
(4, 'cd73c7eeb094a996653947cbf04da1b0.jpg', NULL, NULL),
(5, '610d39aaa78f8fa0d292273465b4d5b5.jpg', NULL, NULL),
(6, '15dcc0d2b10015a789b4d195c2d5f13c.jpg', NULL, NULL),
(7, 'abf47ff2319129cb4d3b236baadb9a10.PNG', NULL, NULL);

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
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `excerpt` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `pubdate` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_post`),
  KEY `slug` (`slug`,`pubdate`,`active`),
  KEY `id_category` (`id_category`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_post`, `id_category`, `id_user`, `title`, `slug`, `excerpt`, `description`, `thumbnail`, `pubdate`, `active`, `created_at`, `updated_at`, `view_count`) VALUES
(4, 4, 1, 'asdasd', '', 'sadasd', '<p>asdsadasd</p>', '3c8c49e94e872199cd085a3a75581b24.PNG', '2014-04-27 00:00:00', 0, '2014-04-27 15:29:08', NULL, 0),
(5, 4, 1, 'Kekerasan dan perbudakan di indonesia semakin meraja rela', '', 'Kekerasan dan perbudakan di indonesia semakin meraja rela', '<p>Kekerasan dan perbudakan di indonesia semakin meraja rela</p>', '7cd94a3379ca6b7bcdf0b4d90d8d96f1.jpg', '2014-04-27 00:00:00', 0, '2014-04-27 15:32:27', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE IF NOT EXISTS `post_categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_category`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id_category`, `id_parent`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 0, 'r00t1', '', '2014-04-01 00:00:00', NULL),
(2, 0, 'r00t2', 'asdsad', '0000-00-00 00:00:00', NULL),
(3, 0, 'r00t3', 'asdasd', '0000-00-00 00:00:00', NULL),
(4, 2, 'asdasdqeqwe', 'asdasdewrwer', '2014-04-01 00:00:00', NULL),
(5, 1, 'qwewqe', 'qwewqe', '2014-04-02 00:00:00', NULL),
(6, 1, 'gfhfgh', 'gfhgfh', '2014-04-03 00:00:00', NULL),
(7, 2, 'vbnvbn', 'vbnvbn', '2014-04-03 00:00:00', NULL);

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
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_product`),
  KEY `id_category` (`id_category`,`slug`),
  KEY `id_category_2` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id_category`, `id_parent`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 0, 'category test', 'category-test', '2014-04-12 22:11:32', NULL),
(2, 0, 'category test 2', 'category-test-2', '2014-04-12 22:14:19', NULL),
(3, 1, 'cat cat cot', 'cat', '2014-04-13 04:31:54', '2014-04-14 12:51:40'),
(4, 2, 'cat 2', 'cat-2', '2014-04-13 04:34:50', NULL),
(7, 4, 'cat 3', 'cat-3', '2014-04-13 05:44:00', NULL),
(8, 3, 'cat 4', 'cat-4', '2014-04-13 07:14:39', NULL),
(9, 0, 'cat 5', 'cat-5', '2014-04-13 07:32:25', NULL),
(10, 2, 'cat 6', 'cat-6', '2014-04-13 10:32:32', NULL),
(11, 0, 'cat 7', 'cat-7', '2014-04-13 10:35:29', NULL),
(12, 1, 'cat 8', 'cat-8', '2014-04-13 10:35:36', NULL),
(13, 2, 'cat 9', 'cat-9', '2014-04-13 10:36:42', NULL),
(14, 4, 'cat 10', 'cat-10', '2014-04-14 01:32:32', NULL),
(15, 3, 'category 22', 'category-22', '2014-04-14 11:44:19', NULL),
(16, 2, 'category 11', 'category-11', '2014-04-14 11:45:26', NULL),
(17, 15, 'category 23', 'category-23', '2014-04-14 11:46:00', NULL),
(18, 16, 'category 23', 'category-23', '2014-04-14 11:46:18', NULL);

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
('7c346248e4b2ea6fbcdcdd14f0059442', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36', 1398584417, 'a:9:{s:9:"user_data";s:0:"";s:8:"identity";s:14:"admin@cldr.com";s:8:"username";s:13:"administrator";s:10:"first_name";s:5:"Ahmad";s:9:"last_name";s:6:"Milzam";s:5:"email";s:14:"admin@cldr.com";s:7:"user_id";s:1:"1";s:14:"old_last_login";s:10:"1398580793";s:10:"created_on";s:10:"1268889823";}'),
('e6da7479093976d98cba6410b0b6d702', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36', 1398588120, 'a:9:{s:9:"user_data";s:0:"";s:8:"identity";s:14:"admin@cldr.com";s:8:"username";s:13:"administrator";s:10:"first_name";s:5:"Ahmad";s:9:"last_name";s:6:"Milzam";s:5:"email";s:14:"admin@cldr.com";s:7:"user_id";s:1:"1";s:14:"old_last_login";s:10:"1398584422";s:10:"created_on";s:10:"1268889823";}');

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
(1, '\0\0', 'administrator', '$2a$08$Ha.NrC/uDQRuh8wQveaQKOnzVZP6.FIBYVS02GCrw3ELVflZ5Gej6', '9462e8eee0', 'admin@cldr.com', '', '', 0, '', 1268889823, 1398588125, 1, 'Ahmad', 'Milzam', 'ADMIN', '0'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(39, 1, 1),
(40, 1, 3),
(3, 2, 3),
(5, 3, 3),
(7, 4, 3),
(9, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id_video` int(11) NOT NULL,
  `url` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `post_categories` (`id_category`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `product_categories` (`id_category`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
