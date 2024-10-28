-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2019 at 02:14 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `firstname`, `lastname`, `password`, `image`, `role_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, NULL, '$2y$10$mxSOjz/rZJeMZT/KvqoIGevR81GJElvVhxYIZ7y3DRuXbQCe2O/tW', '', 1, 1, 'ttQzeumB5Q6CR89yc0kpYGiNVZjg1JNlsFdJ84X2Hy6hF87MndQgoh2Tr5Xh', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins_metas`
--

CREATE TABLE `admins_metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins_metas`
--

INSERT INTO `admins_metas` (`id`, `admin_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 1, 'user_online_status', '1', '2019-03-18 22:54:20', '2019-04-08 06:10:48'),
(2, 1, 'user_last_activity', '2019-04-08 11:29:46', '2019-03-27 04:51:32', '2019-04-08 05:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `attributetitle_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `attributetitle_id`, `title`, `type`, `status`, `created_at`, `updated_at`) VALUES
(3, 5, 'S', 'Size', 2, '2019-04-07 05:39:25', '2019-04-07 05:39:25'),
(4, 5, 'M', 'Size', 2, '2019-04-07 05:39:29', '2019-04-07 05:39:29'),
(5, 5, 'L', 'Size', 2, '2019-04-07 05:39:33', '2019-04-07 05:39:33'),
(6, 6, 'Green', 'Color', 2, '2019-04-07 05:39:39', '2019-04-07 05:39:39'),
(7, 6, 'Black', 'Color', 2, '2019-04-07 05:39:46', '2019-04-07 05:39:46'),
(8, 6, 'White', 'Color', 2, '2019-04-07 05:39:51', '2019-04-07 05:39:51'),
(9, 5, 'XL', 'Size', 2, '2019-04-07 05:40:02', '2019-04-07 05:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `attributetitles`
--

CREATE TABLE `attributetitles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributetitles`
--

INSERT INTO `attributetitles` (`id`, `title`, `description`, `image`, `slug`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Size', NULL, NULL, 'size', NULL, NULL, NULL, 1, NULL, 1, '2019-04-07 05:39:09', '2019-04-07 05:39:09'),
(6, 'Color', NULL, NULL, 'color', NULL, NULL, NULL, 1, NULL, 1, '2019-04-07 05:39:16', '2019-04-07 05:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_product`
--

CREATE TABLE `attribute_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `color_id` int(10) UNSIGNED DEFAULT NULL,
  `attribute_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute_qty` decimal(10,2) DEFAULT NULL,
  `attribute_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `long_description` longtext COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_sticky` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comment_enable` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `total_posts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `description`, `image`, `slug`, `website`, `views`, `total_posts`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Brand-1', NULL, NULL, 'brand1', NULL, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:40:33', '2019-03-31 09:40:33'),
(5, 'Brand-2', NULL, NULL, 'brand-2', NULL, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:40:38', '2019-03-31 09:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `objective` text COLLATE utf8mb4_unicode_ci,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `is_enable_site_link` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `site_link_title` text COLLATE utf8mb4_unicode_ci,
  `site_link` text COLLATE utf8mb4_unicode_ci,
  `case_style` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=Normal, 1=Affiliate',
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fav_icon` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `total_posts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `title`, `color_code`, `priority`, `description`, `image`, `fav_icon`, `slug`, `views`, `total_posts`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(24, 0, 'WOMEN', '#ff0000', 1, NULL, NULL, 'weman_1.png', 'women', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 08:45:15', '2019-04-10 06:53:46'),
(25, 0, 'MEN', '#00a360', 2, NULL, NULL, 'men_1.png', 'men', 0, 4, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 08:45:45', '2019-04-10 07:23:28'),
(26, 0, 'GRACE', '#0090c9', 3, NULL, NULL, 'grace.png', 'grace', 0, 2, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 08:46:13', '2019-04-09 10:43:43'),
(27, 24, 'SHORT TOPS AND', '#ff0000', NULL, NULL, NULL, NULL, 'short-tops-and', 0, 5, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 08:48:03', '2019-04-10 06:51:18'),
(28, 24, 'SHIRTS', '#ff0000', NULL, NULL, NULL, NULL, 'shirts', 0, 8, NULL, NULL, NULL, 1, 1, 1, '2019-04-03 08:48:33', '2019-04-10 06:53:46'),
(29, 25, 'PANJABI', '#ff0000', NULL, NULL, NULL, NULL, 'panjabi', 0, 4, NULL, NULL, NULL, 1, 1, 1, '2019-04-03 08:48:50', '2019-04-10 07:00:57'),
(30, 25, 'KABLI SUIT', '#ff0000', NULL, NULL, NULL, NULL, 'kabli-suit', 0, 4, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 08:49:29', '2019-04-10 07:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `categoryables`
--

CREATE TABLE `categoryables` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `categoryable_id` int(10) UNSIGNED NOT NULL,
  `categoryable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categoryables`
--

INSERT INTO `categoryables` (`id`, `category_id`, `categoryable_id`, `categoryable_type`, `created_at`, `updated_at`) VALUES
(29, 19, 39, 'App\\Model\\Common\\Product', '2019-04-03 07:00:49', '2019-04-03 07:00:49'),
(30, 18, 38, 'App\\Model\\Common\\Product', '2019-04-03 07:02:52', '2019-04-03 07:02:52'),
(31, 19, 37, 'App\\Model\\Common\\Product', '2019-04-03 07:03:19', '2019-04-03 07:03:19'),
(35, 27, 40, 'App\\Model\\Common\\Product', '2019-04-09 04:19:37', '2019-04-09 04:19:37'),
(36, 29, 40, 'App\\Model\\Common\\Product', '2019-04-09 04:19:37', '2019-04-09 04:19:37'),
(37, 28, 41, 'App\\Model\\Common\\Product', '2019-04-03 08:55:50', '2019-04-03 08:55:50'),
(38, 30, 42, 'App\\Model\\Common\\Product', '2019-04-09 04:19:19', '2019-04-09 04:19:19'),
(39, 29, 43, 'App\\Model\\Common\\Product', '2019-04-06 04:11:23', '2019-04-06 04:11:23'),
(40, 28, 44, 'App\\Model\\Common\\Product', '2019-04-09 04:20:23', '2019-04-09 04:20:23'),
(41, 30, 1, 'App\\Model\\Common\\Blog', '2019-04-08 03:43:39', '2019-04-08 03:43:39'),
(42, 26, 1, 'App\\Model\\Common\\Blog', '2019-04-08 03:43:39', '2019-04-08 03:43:39'),
(43, 28, 45, 'App\\Model\\Common\\Product', '2019-04-08 08:52:06', '2019-04-08 08:52:06'),
(44, 27, 46, 'App\\Model\\Common\\Product', '2019-04-09 05:40:30', '2019-04-09 05:40:30'),
(45, 30, 46, 'App\\Model\\Common\\Product', '2019-04-09 05:40:30', '2019-04-09 05:40:30'),
(46, 28, 47, 'App\\Model\\Common\\Product', '2019-04-09 06:00:07', '2019-04-09 06:00:07'),
(47, 28, 48, 'App\\Model\\Common\\Product', '2019-04-10 05:32:45', '2019-04-10 05:32:45'),
(48, 26, 48, 'App\\Model\\Common\\Product', '2019-04-10 05:32:45', '2019-04-10 05:32:45'),
(49, 27, 49, 'App\\Model\\Common\\Product', '2019-04-10 05:28:44', '2019-04-10 05:28:44'),
(50, 28, 49, 'App\\Model\\Common\\Product', '2019-04-10 05:28:44', '2019-04-10 05:28:44'),
(51, 27, 1, 'App\\Model\\Common\\Product', '2019-04-10 06:46:28', '2019-04-10 06:46:28'),
(52, 29, 2, 'App\\Model\\Common\\Product', '2019-04-10 06:49:12', '2019-04-10 06:49:12'),
(53, 28, 3, 'App\\Model\\Common\\Product', '2019-04-10 06:50:04', '2019-04-10 06:50:04'),
(54, 25, 4, 'App\\Model\\Common\\Product', '2019-04-10 06:50:38', '2019-04-10 06:50:38'),
(55, 27, 5, 'App\\Model\\Common\\Product', '2019-04-10 06:51:18', '2019-04-10 06:51:18'),
(56, 25, 6, 'App\\Model\\Common\\Product', '2019-04-10 06:52:41', '2019-04-10 06:52:41'),
(57, 24, 7, 'App\\Model\\Common\\Product', '2019-04-10 06:53:46', '2019-04-10 06:53:46'),
(58, 28, 7, 'App\\Model\\Common\\Product', '2019-04-10 06:53:46', '2019-04-10 06:53:46'),
(61, 30, 8, 'App\\Model\\Common\\Product', '2019-04-10 07:09:21', '2019-04-10 07:09:21'),
(62, 25, 9, 'App\\Model\\Common\\Product', '2019-04-10 07:23:28', '2019-04-10 07:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `commentable_id` int(10) UNSIGNED NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_c_id` int(10) UNSIGNED NOT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validity` date NOT NULL,
  `discount` double(5,2) NOT NULL DEFAULT '0.00',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1 = Fixed and 2 = Percentage',
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Completed, 2=Processing, 3=Pending, 4=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `liker_id` int(10) UNSIGNED DEFAULT NULL,
  `liker_ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likeable_id` int(10) UNSIGNED NOT NULL,
  `likeable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=Not Liked yet, 1=Liked',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_private` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=Yes, 0=No',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci,
  `alt` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `is_private`, `title`, `caption`, `alt`, `description`, `slug`, `created_by`, `modified_by`, `created_at`, `updated_at`) VALUES
(1, 0, 'b2', NULL, NULL, NULL, 'b2.jpg', 1, NULL, '2019-03-19 01:30:52', '2019-03-19 01:30:52'),
(2, 0, 'b1', NULL, NULL, NULL, 'b1.jpg', 1, NULL, '2019-03-19 01:33:05', '2019-03-19 01:33:05'),
(4, 0, 'mart_logo', NULL, NULL, NULL, 'mart_logo_1.png', 1, NULL, '2019-03-27 03:46:43', '2019-03-27 03:46:43'),
(6, 0, 'Man', NULL, NULL, NULL, 'man.png', 1, NULL, '2019-03-31 08:52:42', '2019-03-31 08:52:42'),
(7, 0, 'logo-buckelup', NULL, NULL, NULL, 'logo-buckelup.png', 1, NULL, '2019-04-01 10:30:48', '2019-04-01 10:30:48'),
(8, 0, 'mart_logo', NULL, NULL, NULL, 'mart_logo.png', 1, NULL, '2019-04-02 11:16:28', '2019-04-02 11:16:28'),
(9, 0, 'Jacobs-logo', NULL, NULL, NULL, 'jacobs-logo.jpg', 1, NULL, '2019-04-02 11:20:34', '2019-04-02 11:20:34'),
(10, 0, 'fav-nextpagetl', NULL, NULL, NULL, 'fav-nextpagetl.png', 1, NULL, '2019-04-02 11:31:31', '2019-04-02 11:31:31'),
(11, 0, 'weman', NULL, NULL, NULL, 'weman.png', 1, NULL, '2019-04-03 03:39:43', '2019-04-03 03:39:43'),
(12, 0, 'men', NULL, NULL, NULL, 'men.png', 1, NULL, '2019-04-03 03:40:44', '2019-04-03 03:40:44'),
(13, 0, 'p1', NULL, NULL, NULL, 'p1.png', 1, NULL, '2019-04-03 05:00:43', '2019-04-03 05:00:43'),
(14, 0, 'pi13', NULL, NULL, NULL, 'pi13.png', 1, NULL, '2019-04-03 05:03:04', '2019-04-03 05:03:04'),
(15, 0, 'pi14', NULL, NULL, NULL, 'pi14.png', 1, NULL, '2019-04-03 05:04:36', '2019-04-03 05:04:36'),
(16, 0, 'pi15', NULL, NULL, NULL, 'pi15.png', 1, NULL, '2019-04-03 05:16:21', '2019-04-03 05:16:21'),
(17, 0, 'pi17', NULL, NULL, NULL, 'pi17.png', 1, NULL, '2019-04-03 05:24:15', '2019-04-03 05:24:15'),
(18, 0, 'pi18', NULL, NULL, NULL, 'pi18.png', 1, NULL, '2019-04-03 05:24:24', '2019-04-03 05:24:24'),
(19, 0, 'p1', NULL, NULL, NULL, 'p1_1.png', 1, NULL, '2019-04-03 06:09:13', '2019-04-03 06:09:13'),
(20, 0, 'pi13', NULL, NULL, NULL, 'pi13_1.png', 1, NULL, '2019-04-03 06:11:24', '2019-04-03 06:11:24'),
(21, 0, 'pi14', NULL, NULL, NULL, 'pi14_1.png', 1, NULL, '2019-04-03 06:29:46', '2019-04-03 06:29:46'),
(23, 0, 'pi18', NULL, NULL, NULL, 'pi18_1.png', 1, NULL, '2019-04-03 06:47:34', '2019-04-03 06:47:34'),
(29, 0, 'sale', NULL, NULL, NULL, 'sale_1.png', 1, NULL, '2019-04-03 08:44:31', '2019-04-03 08:44:31'),
(30, 0, 'newarivel', NULL, NULL, NULL, 'newarivel_2.png', 1, NULL, '2019-04-03 08:44:40', '2019-04-03 08:44:40'),
(31, 0, 'grace', NULL, NULL, NULL, 'grace.png', 1, NULL, '2019-04-03 08:44:50', '2019-04-03 08:44:50'),
(32, 0, 'men', NULL, NULL, NULL, 'men_1.png', 1, NULL, '2019-04-03 08:45:00', '2019-04-03 08:45:00'),
(33, 0, 'weman', NULL, NULL, NULL, 'weman_1.png', 1, NULL, '2019-04-03 08:45:10', '2019-04-03 08:45:10'),
(46, 0, 'slider2', NULL, NULL, NULL, 'slider2.jpg', 1, NULL, '2019-04-03 10:21:37', '2019-04-03 10:21:37'),
(47, 0, 'slider2psd', NULL, NULL, NULL, 'slider2psd.jpg', 1, NULL, '2019-04-03 10:21:45', '2019-04-03 10:21:45'),
(48, 0, 'slider3psd', NULL, NULL, NULL, 'slider3psd.jpg', 1, NULL, '2019-04-03 10:21:52', '2019-04-03 10:21:52'),
(49, 0, 'slider5', NULL, NULL, NULL, 'slider5.png', 1, NULL, '2019-04-03 10:22:07', '2019-04-03 10:22:07'),
(55, 0, 'logo-buckelup', NULL, NULL, NULL, 'logo-buckelup_1.png', 1, NULL, '2019-04-04 03:47:01', '2019-04-04 03:47:01'),
(56, 0, 'trademark-cn', NULL, NULL, NULL, 'trademark-cn.jpg', 1, NULL, '2019-04-04 03:58:04', '2019-04-04 03:58:04'),
(57, 0, 'trademark-dhl', NULL, NULL, NULL, 'trademark-dhl.jpg', 1, NULL, '2019-04-04 03:58:11', '2019-04-04 03:58:11'),
(58, 0, 'trademark-ems', NULL, NULL, NULL, 'trademark-ems.jpg', 1, NULL, '2019-04-04 03:58:18', '2019-04-04 03:58:18'),
(59, 0, 'trademark-fe', NULL, NULL, NULL, 'trademark-fe.jpg', 1, NULL, '2019-04-04 03:58:25', '2019-04-04 03:58:25'),
(60, 0, 'trademark-mc', NULL, NULL, NULL, 'trademark-mc.jpg', 1, NULL, '2019-04-04 03:58:32', '2019-04-04 03:58:32'),
(61, 0, 'trademark-qiwi', NULL, NULL, NULL, 'trademark-qiwi.jpg', 1, NULL, '2019-04-04 03:58:39', '2019-04-04 03:58:39'),
(62, 0, 'trademark-visa', NULL, NULL, NULL, 'trademark-visa.jpg', 1, NULL, '2019-04-04 03:58:46', '2019-04-04 03:58:46'),
(63, 0, 'trademark-wm', NULL, NULL, NULL, 'trademark-wm.jpg', 1, NULL, '2019-04-04 03:58:53', '2019-04-04 03:58:53'),
(64, 0, 'trademark-wu', NULL, NULL, NULL, 'trademark-wu.jpg', 1, NULL, '2019-04-04 03:59:00', '2019-04-04 03:59:00'),
(76, 0, 'IMG_0999', NULL, NULL, NULL, 'img_0999.jpg', 1, NULL, '2019-04-10 06:45:46', '2019-04-10 06:45:46'),
(77, 0, 'listslide1', NULL, NULL, NULL, 'listslide1.png', 1, NULL, '2019-04-10 06:46:06', '2019-04-10 06:46:06'),
(78, 0, 'zoom1', NULL, NULL, NULL, 'zoom1.png', 1, NULL, '2019-04-10 06:46:28', '2019-04-10 06:46:28'),
(79, 0, 'p2', NULL, NULL, NULL, 'p2.png', 1, NULL, '2019-04-10 06:46:50', '2019-04-10 06:46:50'),
(80, 0, 'p4', NULL, NULL, NULL, 'p4.png', 1, NULL, '2019-04-10 06:47:12', '2019-04-10 06:47:12'),
(81, 0, 'p5', NULL, NULL, NULL, 'p5.png', 1, NULL, '2019-04-10 06:47:37', '2019-04-10 06:47:37'),
(82, 0, 'pi26', NULL, NULL, NULL, 'pi26.png', 1, NULL, '2019-04-10 06:47:58', '2019-04-10 06:47:58'),
(83, 0, 'p1', NULL, NULL, NULL, 'p1_2.png', 1, NULL, '2019-04-10 06:48:19', '2019-04-10 06:48:19'),
(84, 0, 'IMG_1089', NULL, NULL, NULL, 'img_1089.jpg', 1, NULL, '2019-04-10 07:00:50', '2019-04-10 07:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `media_permissions`
--

CREATE TABLE `media_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `media_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_08_07_034348_create_settings_table', 1),
(4, '2017_08_07_035559_create_users_metas_table', 1),
(5, '2017_08_07_042628_create_roles_table', 1),
(6, '2017_08_07_092248_create_media_table', 1),
(7, '2017_08_08_093255_create_visitors_table', 1),
(8, '2017_08_10_091903_create_pages_table', 1),
(9, '2017_08_10_091915_create_sliders_table', 1),
(10, '2017_10_03_070336_create_categories_table', 1),
(11, '2017_10_03_070345_create_categoryables_table', 1),
(12, '2017_10_03_070354_create_tags_table', 1),
(13, '2017_10_03_070407_create_taggables_table', 1),
(14, '2017_10_03_071431_create_comments_table', 1),
(15, '2017_10_03_071448_create_blogs_table', 1),
(16, '2017_10_03_071459_create_cases_table', 1),
(17, '2017_10_03_071514_create_services_table', 1),
(18, '2017_10_30_054713_create_admins_table', 1),
(19, '2017_10_30_055642_create_admins_metas_table', 1),
(20, '2017_10_30_104950_add_features_to_services_table', 1),
(21, '2017_10_30_105110_add_extra_to_services_table', 1),
(22, '2017_10_31_113316_add_short_description_to_services_table', 1),
(23, '2017_11_01_041902_add_subtitle_to_services_table', 1),
(24, '2017_11_05_090347_create_packages_table', 1),
(25, '2017_11_05_091914_create_package_details_table', 1),
(26, '2017_11_09_064245_create_orders_table', 1),
(27, '2017_11_09_064315_create_payments_table', 1),
(28, '2017_11_09_064335_create_order_details_table', 1),
(29, '2017_11_09_083522_create_payment_methods_table', 1),
(30, '2017_11_11_040005_create_coupons_table', 1),
(31, '2017_11_11_040822_add_auth_id_to_users_table', 1),
(32, '2017_11_19_063429_create_taxes_table', 1),
(33, '2017_12_09_032351_create_media_permissions_table', 1),
(34, '2017_12_10_035008_create_subscribers_table', 1),
(35, '2018_02_28_042315_add_layout_to_services_table', 1),
(36, '2018_03_13_041023_add_style_to_sliders_table', 1),
(37, '2018_03_13_075043_add_mover_img_to_packages_table', 1),
(38, '2018_03_14_051359_create_likes_table', 1),
(39, '2018_03_14_052316_add_likes_to_blogs_table', 1),
(40, '2018_03_19_055541_create_tickets_table', 1),
(41, '2018_03_19_080800_create_tickets_details_table', 1),
(42, '2018_03_28_070117_add_three_fields_to_cases_table', 1),
(43, '2018_03_29_034328_add_extra_to_packages_table', 1),
(44, '2018_04_09_104924_add_banner_title_to_pages_table', 1),
(45, '2018_04_09_104948_add_banner_subtitle_to_pages_table', 1),
(46, '2019_03_19_050137_create_brands_table', 2),
(52, '2019_03_19_102008_create_attributetitles_table', 3),
(63, '2019_03_21_063225_create_units_table', 6),
(68, '2019_03_19_113141_create_products_table', 7),
(69, '2019_03_21_054136_create_attribute_product_table', 7),
(70, '2017_12_11_061154_create_wishlists_table', 8),
(71, '2019_03_27_091510_create_shoppingcart_table', 8),
(72, '2019_03_19_103516_create_attributes_table', 9),
(73, '2019_04_08_090946_create_product_reviews_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `total` double(10,2) NOT NULL,
  `discount` double(5,2) NOT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `tax` double(6,2) NOT NULL DEFAULT '0.00',
  `net_total` double(10,2) NOT NULL,
  `paid` double(10,2) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `completed_files` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Completed, 2=Processing, 3=Pending, 4=Cancelled',
  `order_status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Completed, 2=Pending, 3=Cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `contact_email`, `qty`, `total`, `discount`, `coupon_id`, `tax`, `net_total`, `paid`, `message`, `attachments`, `completed_files`, `created_by`, `modified_by`, `payment_status`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 2, 'admin1', 'admin1@gmail.com', 1, 699.00, 146.79, 0, 146.79, 845.79, 845.79, 'qsadsad asdsa', NULL, NULL, 2, NULL, 3, 3, '2019-03-27 05:41:56', '2019-03-27 05:41:56'),
(2, 2, 'admin2', 'admin1@gmail.com', 1, 699.00, 146.79, 0, 146.79, 845.79, 845.79, 'qsadsad asdsa', NULL, NULL, 2, NULL, 3, 3, '2019-03-27 05:42:26', '2019-03-27 05:42:26'),
(3, 2, 'admin3', 'admin1@gmail.com', 1, 699.00, 146.79, 0, 146.79, 845.79, 845.79, NULL, NULL, NULL, 2, NULL, 2, 3, '2019-03-27 05:44:04', '2019-04-01 10:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `rate` double(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `qty`, `rate`, `sub_total`) VALUES
(1, 2, 8, 1, 699.00, '699.00'),
(2, 2, 3, 2, 699.00, '699.00');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Pricing Plan, 2=Content Writing, 3=Advertisement',
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `pricing_detail` longtext COLLATE utf8mb4_unicode_ci,
  `requirements` longtext COLLATE utf8mb4_unicode_ci,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sale_qty` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sale_amount` double(25,2) NOT NULL DEFAULT '0.00',
  `mover_img` text COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `type`, `title`, `slug`, `subtitle`, `image`, `description`, `pricing_detail`, `requirements`, `views`, `sale_qty`, `sale_amount`, `mover_img`, `extra`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Clementine Gardner up', 'clementine-gardner-up', '21321312', 'mart_logo_1.png', '<p>12321312</p>', NULL, NULL, 0, 0, 0.00, 'b1.jpg', 'a:4:{s:18:\"pricing_info_title\";s:37:\"Suitable Web Hosting Packages For You\";s:10:\"step_title\";s:5:\"12312\";s:13:\"step_subtitle\";s:5:\"12312\";s:10:\"step_image\";N;}', '1231', '2312', 'sdaad', 1, NULL, 1, '2019-03-27 03:51:10', '2019-03-27 03:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `package_details`
--

CREATE TABLE `package_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `price_type` tinyint(3) UNSIGNED DEFAULT NULL,
  `sorting_position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `words` int(10) UNSIGNED NOT NULL DEFAULT '100',
  `price` double(10,2) NOT NULL,
  `isIncluded` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `package_details`
--

INSERT INTO `package_details` (`id`, `package_id`, `price_type`, `sorting_position`, `title`, `words`, `price`, `isIncluded`, `details`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, 'BASIC', 100, 12.00, 0, '[{\"pricing_info_title\":\"asd\",\"basic\":\"213\"}]', '2019-03-27 03:51:10', '2019-03-27 03:51:10'),
(2, 1, 5, 2, 'SILVER', 100, 13.00, 0, '[{\"pricing_info_title\":\"asd\",\"silver\":\"123\"}]', '2019-03-27 03:51:10', '2019-03-27 03:51:10'),
(3, 1, 5, 3, 'GOLD', 100, 14.00, 0, '[{\"pricing_info_title\":\"asd\",\"gold\":\"12321\"}]', '2019-03-27 03:51:10', '2019-03-27 03:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_subtitle` text COLLATE utf8mb4_unicode_ci,
  `banner_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `menu_title`, `page_title`, `page_subtitle`, `banner_title`, `banner_subtitle`, `banner_image`, `content`, `slug`, `template`, `views`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'WOMEN', 'WOMEN', 'WOMEN', NULL, NULL, NULL, '<p>Next Page Technology Ltd., a proactive digital marketing agency, has its Privacy Policy that governs and describes how Next Page Technology Ltd. gathers, uses, keeps tracks of and discloses user information (each, a &ldquo;User&rdquo;) of the http://nextpagetl.com/ website (&ldquo;Site&rdquo;). This privacy policy is applicable to the Site as well as all its products and services.</p>\r\n\r\n<h3>Personal identification information</h3>\r\n\r\n<p>We may collect Users&rsquo; personal identification information in different ways that might include but not be limited to, the time users visit the Site, signup with the Site, make an order, subscribe to our newsletter, provide response to any of our surveys, fill out any form, and in relation with other services, features, activities, or resources available on the Site.</p>\r\n\r\n<p>We may ask Users for, as suitable, full name, email and mailing address, cell number, and credit card information. However, Users may visit the site anonymously. We will collect and store Users&rsquo; personal identification information only when they submit the information voluntarily. Users can avoid supplying personally identification information if they want, except that such avoidance may not allow them to participate in certain activities.</p>', 'women', NULL, 20, NULL, NULL, NULL, 1, 1, 1, '2019-04-04 04:34:04', '2019-04-07 12:45:23'),
(2, 'MEN', 'MEN', 'MEN', NULL, NULL, NULL, '<p>MEN</p>', 'men', NULL, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-04 04:34:20', '2019-04-04 04:34:20'),
(3, 'GRACE', 'GRACE', 'GRACE', NULL, NULL, NULL, '<p>GRACE</p>', 'grace', NULL, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-04 04:34:35', '2019-04-04 04:34:35'),
(4, 'NEW ARRIVALS', 'NEW ARRIVALS', 'NEW ARRIVALS', NULL, NULL, NULL, '<p>NEW ARRIVALS</p>', 'new-arrivals', NULL, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-04 04:34:55', '2019-04-04 09:50:44'),
(5, 'PANJABI', 'PANJABI', 'PANJABI', NULL, NULL, NULL, '<p><span style=\"color:rgb(34, 34, 34); font-family:consolas,lucida console,courier new,monospace; font-size:12px\">PANJABI</span></p>', 'panjabi', NULL, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-04 04:35:17', '2019-04-04 04:35:17'),
(6, 'KABLI SUIT', 'KABLI SUIT', 'KABLI SUIT', NULL, NULL, NULL, '<p><span style=\"color:rgb(34, 34, 34); font-family:consolas,lucida console,courier new,monospace; font-size:12px\">KABLI SUIT</span></p>', 'kabli-suit', NULL, 2, NULL, NULL, NULL, 1, NULL, 1, '2019-04-04 04:35:33', '2019-04-07 12:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin1@gmail.com', '$2y$10$22D7Vz0jgOF4TDOVO065eO5q4jc3i9/PTowqUQnD1TTsG84GsI2JO', '2019-03-27 21:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `paid` double(10,2) NOT NULL,
  `transaction_id` text COLLATE utf8mb4_unicode_ci,
  `return_url` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=Completed, 2=Pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Offline and 2 = Online Without Card and 3 = Online With Card',
  `mode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'sandbox' COMMENT 'sandbox=Demo and live = Live',
  `api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=Completed, 2=Pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `title`, `description`, `image`, `type`, `mode`, `api_key`, `api_secret`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Qiwi', NULL, 'trademark-qiwi.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 03:59:16', '2019-04-04 03:59:16'),
(2, 'cn', NULL, 'trademark-wu.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:00:01', '2019-04-04 04:00:01'),
(3, 'visa', NULL, 'trademark-visa.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:00:12', '2019-04-04 04:00:12'),
(4, 'mc', NULL, 'trademark-mc.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:00:31', '2019-04-04 04:00:31'),
(5, 'ems', NULL, 'trademark-ems.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:01:02', '2019-04-04 04:01:02'),
(6, 'dhl', NULL, 'trademark-dhl.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:01:21', '2019-04-04 04:01:21'),
(7, 'fe', NULL, 'trademark-fe.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:01:39', '2019-04-04 04:01:39'),
(8, 'wm', NULL, 'trademark-wm.jpg', 1, 'sandbox', NULL, NULL, 1, NULL, 1, '2019-04-04 04:01:54', '2019-04-04 04:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `long_description` longtext COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_special` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `product_qty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alert_quantity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_weight` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(10) UNSIGNED DEFAULT NULL,
  `image_gallery` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_sticky` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comment_enable` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `short_description`, `long_description`, `image`, `slug`, `sku`, `stock_status`, `is_special`, `tax_class`, `regular_price`, `sale_price`, `brand_id`, `product_qty`, `alert_quantity`, `product_weight`, `product_model`, `unit_id`, `image_gallery`, `is_featured`, `is_sticky`, `comment_enable`, `comments`, `views`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Product-1', NULL, NULL, 'zoom1.png', 'product-1', 'Product-1', 'in_stock', 'No', NULL, '200.00', '150.00', 4, NULL, NULL, NULL, NULL, 2, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:46:28', '2019-04-10 06:46:28'),
(2, 'Product-2', NULL, NULL, 'p1_2.png', 'product-2', 'Product-2', 'in_stock', 'No', NULL, '500.00', '0.00', 4, NULL, NULL, NULL, NULL, 7, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:49:12', '2019-04-10 06:49:12'),
(3, 'Product-3', NULL, NULL, 'pi26.png', 'product-3', 'Product-3', 'in_stock', 'No', NULL, '800.00', '600.00', 4, NULL, NULL, NULL, NULL, 7, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:50:04', '2019-04-10 06:50:04'),
(4, 'Product-4', NULL, NULL, 'p5.png', 'product-4', 'Product-4', 'in_stock', 'No', NULL, '400.00', '0.00', 4, NULL, NULL, NULL, NULL, 9, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:50:38', '2019-04-10 06:50:38'),
(5, 'Product-5', NULL, NULL, 'zoom1.png', 'product-5', 'Product-5', 'in_stock', 'No', NULL, '600.00', '0.00', 4, NULL, NULL, NULL, NULL, 7, NULL, 0, 0, 0, 0, 2, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:51:18', '2019-04-10 10:01:57'),
(6, 'Product-6', NULL, NULL, 'p2.png', 'product-6', 'Product-6', 'in_stock', 'No', NULL, '600.00', '500.00', 5, NULL, NULL, NULL, NULL, 7, NULL, 0, 0, 0, 0, 2, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:52:41', '2019-04-10 10:02:16'),
(7, 'Product-7', NULL, NULL, 'p4.png', 'product-7', 'Product-7', 'in_stock', 'No', NULL, '800.00', '0.00', 4, NULL, NULL, NULL, NULL, 5, NULL, 0, 0, 0, 0, 2, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 06:53:46', '2019-04-10 09:59:50'),
(8, 'Product-8', NULL, NULL, 'img_1089.jpg', 'product-8', 'Product-8', 'in_stock', 'No', 'Sale Tax', '1000.00', '0.00', 4, NULL, NULL, NULL, NULL, 7, NULL, 0, 0, 0, 0, 1, NULL, NULL, NULL, 1, 1, 1, '2019-04-10 07:00:57', '2019-04-10 07:07:45'),
(9, 'Product-9', NULL, NULL, 'img_0999.jpg', 'product-9', 'Product-9', 'in_stock', 'No', NULL, '1500.00', '1200.00', 5, NULL, NULL, NULL, NULL, 9, NULL, 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 07:23:27', '2019-04-10 07:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `title`, `description`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 2, NULL, 'great', '4', 0, '2019-04-10 09:59:50', '2019-04-10 09:59:50'),
(2, 5, 6, NULL, 'wow', '3', 1, '2019-04-10 10:01:57', '2019-04-10 10:01:57'),
(3, 5, 6, NULL, 'nice', '2', 0, '2019-04-10 10:02:16', '2019-04-10 10:02:16');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permission`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `features` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `background` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `layout` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `autoload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `option_name`, `option_value`, `created_by`, `modified_by`, `autoload`, `status`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Next Page Technology Ltd.', 1, 1, 1, 1, NULL, '2019-04-10 03:36:11'),
(2, 'tag_line', 'nptl', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(3, 'address', 'Nekunjo-2, Dhaka', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(4, 'email', 'nextpagetl@gmail.com', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(5, 'secondary_email', 'info@nextpagetl.com', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(6, 'mobile', '017XXXXXXXX', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(7, 'logo', 'logo-buckelup_1.png', 1, 1, 1, 1, NULL, '2019-04-04 03:23:41'),
(8, 'favicon', 'logo-buckelup_1.png', 1, 1, 1, 1, NULL, '2019-04-10 03:40:35'),
(9, 'site_screenshot', 'logo-buckelup_1.png', 1, 1, 1, 1, NULL, '2019-04-10 03:39:59'),
(10, 'site_meta_keywords', 'Shop, ecommerce, products, nptlshop', 1, 1, 1, 1, NULL, '2019-04-10 03:37:45'),
(11, 'site_meta_description', 'We are providing unique & cute website design and development, SEO, Digital Marketing, E-commerce services, domain & hosting services, software etc.', 1, 1, 1, 1, NULL, '2019-04-10 03:40:00'),
(12, 'main_menu', 'a:1:{s:9:\"menu_item\";a:7:{i:1;a:8:{s:2:\"id\";s:1:\"1\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:5:\"WOMEN\";s:4:\"link\";s:11:\"/page/women\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:2;a:8:{s:2:\"id\";s:1:\"2\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:3:\"MEN\";s:4:\"link\";s:9:\"/page/men\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:3;a:8:{s:2:\"id\";s:1:\"3\";s:4:\"p_id\";s:1:\"2\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:7:\"PANJABI\";s:4:\"link\";s:13:\"/page/panjabi\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:4;a:8:{s:2:\"id\";s:1:\"4\";s:4:\"p_id\";s:1:\"2\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:10:\"KABLI SUIT\";s:4:\"link\";s:16:\"/page/kabli-suit\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:5;a:8:{s:2:\"id\";s:1:\"5\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:5:\"GRACE\";s:4:\"link\";s:11:\"/page/grace\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:6;a:8:{s:2:\"id\";s:1:\"6\";s:4:\"p_id\";s:1:\"5\";s:9:\"menu_type\";s:4:\"page\";s:5:\"title\";s:12:\"NEW ARRIVALS\";s:4:\"link\";s:18:\"/page/new-arrivals\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}i:7;a:8:{s:2:\"id\";s:1:\"7\";s:4:\"p_id\";s:1:\"0\";s:9:\"menu_type\";s:2:\"cl\";s:5:\"title\";s:4:\"Shop\";s:4:\"link\";s:5:\"/shop\";s:3:\"cls\";s:0:\"\";s:8:\"link_cls\";s:0:\"\";s:8:\"icon_cls\";s:0:\"\";}}}', 1, 1, 1, 1, NULL, '2019-04-07 03:15:01'),
(13, 'fb_page', 'http://facebook.com/nextpagetl', 1, NULL, 1, 1, NULL, NULL),
(14, 'gp_page', 'http://facebook.com/nextpagetl', 1, NULL, 1, 1, NULL, NULL),
(15, 'tt_page', 'http://facebook.com/nextpagetl', 1, NULL, 1, 1, NULL, NULL),
(16, 'li_page', 'http://facebook.com/nextpagetl', 1, NULL, 1, 1, NULL, NULL),
(17, 'youtube_page', 'http://facebook.com/nextpagetl', 1, NULL, 1, 1, NULL, NULL),
(18, 'website', 'www.nextpagetl.com', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(19, 'about', 'asdsadsdasd', 1, 1, 1, 2, NULL, '2019-04-04 03:23:41'),
(20, 'country', 'Bangladesh', 1, 1, 1, 2, NULL, '2019-04-04 03:23:41'),
(21, 'sm_theme_options_home_setting', 'a:46:{s:22:\"slider_change_autoplay\";N;s:15:\"canonical_title\";s:44:\"Cornerstones Of Our Digital Marketing Agency\";s:26:\"home_is_seo_section_enable\";s:1:\"1\";s:14:\"home_seo_title\";s:15:\"Your SEO Score?\";s:18:\"home_seo_btn_title\";s:12:\"Check up now\";s:17:\"seo_feature_title\";s:45:\"DO YOU WANT TO BE SEEN? YOURE IN RIGHT PLACE!\";s:23:\"seo_feature_description\";s:123:\"SEOis a section of Search Engine Land that focuses not on search marketing advice but rather the search marketing industry.\";s:17:\"seo_feature_image\";N;s:30:\"seo_feature_more_btn_is_enable\";s:1:\"1\";s:26:\"seo_feature_more_btn_label\";s:10:\"Learn more\";s:25:\"seo_feature_more_btn_link\";s:1:\"#\";s:31:\"seo_feature_quote_btn_is_enable\";s:1:\"1\";s:27:\"seo_feature_quote_btn_label\";s:11:\"Learn quote\";s:26:\"seo_feature_quote_btn_link\";s:1:\"#\";s:22:\"seo_marketing_subtitle\";s:15:\"WATCH THE VIDEO\";s:19:\"seo_marketing_title\";s:35:\"HOW TO WORKING DOODLE SEO MARKETING\";s:25:\"seo_marketing_description\";s:941:\"<p>our daily recap of search news. At the end of each business day, we&#39;ll email you a summary of th what happened in search. This will include all stories we&#39;ve covered on Search Engine Land Land as well as headlines from sources from across the web. Anyone involved with digital marketinge deals with marketing technology every day. Keep up with the latest curves thrown by Google an Bing, whether they&#39;re tweaking Product Listing Ads, adjusting Enhanced Campaigns, or changiw the way ads display on various platforms. Get the weekly recap on what&#39;s important from Search Engine Land&#39;s knowledgeable news team and our expert contributors. Everything you need to know about SEO, whether it&#39;s the latest thw news or how-tos from practitioners. Once a week, get the curated scoop from Search Engine ths Land&#39;s SEO newsletter. Reach your customers and potential customers on the popular socialalys platforms and.</p>\";s:16:\"seo_video_banner\";N;s:26:\"seo_marketing_video_poster\";N;s:19:\"seo_marketing_video\";N;s:18:\"home_service_title\";N;s:21:\"home_service_subtitle\";N;s:17:\"achievement_title\";s:13:\"OUR ACHIVMENT\";s:23:\"achievement_description\";s:82:\"SEO Boost is an experienced of online marketing firm with a big record of success!\";s:17:\"achievement_image\";N;s:13:\"total_project\";s:3:\"222\";s:19:\"total_active_client\";s:3:\"333\";s:18:\"total_success_rate\";s:2:\"98\";s:16:\"total_commitment\";s:3:\"100\";s:9:\"wcu_title\";s:26:\"Why Choose Doodle Digital?\";s:12:\"wcu_subtitle\";s:62:\"Many Services! Big Claims Everywhere! Then, why us? Because...\";s:15:\"wcu_description\";N;s:9:\"wcu_image\";N;s:13:\"case_subtitle\";s:13:\"CREATIVE WORK\";s:10:\"case_title\";s:19:\"Recent Case Studies\";s:9:\"case_show\";N;s:22:\"home_testimonial_style\";s:8:\"bg-black\";s:10:\"blog_title\";s:11:\"Latest Blog\";s:13:\"blog_subtitle\";s:63:\"Claritas est etiam processus dynamicus, qui sequitur mutationem\";s:9:\"blog_show\";N;s:13:\"product_title\";s:12:\"LATEST DEALS\";s:16:\"product_subtitle\";s:63:\"Claritas est etiam processus dynamicus, qui sequitur mutationem\";s:12:\"product_show\";s:1:\"7\";s:14:\"branding_title\";s:16:\"Valuable Clients\";s:17:\"branding_subtitle\";s:63:\"Claritas est etiam processus dynamicus, qui sequitur mutationem\";s:5:\"logos\";N;}', 1, 1, 1, 2, NULL, '2019-04-10 05:24:54'),
(22, 'sm_theme_options_contact_setting', 'a:21:{s:20:\"contact_banner_title\";s:10:\"CONTACT US\";s:23:\"contact_banner_subtitle\";s:24:\"A World of Opportunities\";s:20:\"contact_banner_image\";N;s:13:\"contact_title\";s:14:\"We Always Help\";s:16:\"contact_subtitle\";s:78:\"It is Easy To Reach Us For Any Digital Marketing Support Anytime From Anywhere\";s:17:\"contact_des_title\";s:15:\"CONNECT WITH US\";s:19:\"contact_description\";N;s:18:\"contact_form_title\";s:18:\"leave us a message\";s:28:\"contact_form_success_message\";s:64:\"Mail successfully send. We will contact you as soon as possible.\";s:20:\"contact_branch_image\";N;s:20:\"contact_branch_title\";s:12:\"Our branches\";s:23:\"contact_branch_subtitle\";s:77:\"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium.\";s:19:\"contact_share_title\";s:13:\"Share With Us\";s:19:\"contact_share_image\";N;s:22:\"contact_location_title\";s:14:\"Map & Location\";s:25:\"contact_location_subtitle\";s:77:\"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium.\";s:25:\"contact_location_latitude\";s:9:\"23.797424\";s:26:\"contact_location_longitude\";s:9:\"90.369409\";s:17:\"contact_seo_title\";N;s:21:\"contact_meta_keywords\";N;s:24:\"contact_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(23, 'sm_theme_options_about_setting', 'a:12:{s:18:\"about_banner_title\";s:8:\"ABOUT US\";s:21:\"about_banner_subtitle\";s:24:\"A World of Opportunities\";s:18:\"about_banner_image\";N;s:9:\"wwr_title\";s:10:\"Who we are\";s:12:\"wwr_subtitle\";N;s:15:\"wwr_description\";N;s:11:\"our_mission\";N;s:10:\"our_vision\";N;s:23:\"about_testimonial_style\";N;s:15:\"about_seo_title\";N;s:19:\"about_meta_keywords\";N;s:22:\"about_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(24, 'sm_theme_options_faq_setting', 'a:4:{s:16:\"faq_banner_image\";N;s:13:\"faq_seo_title\";N;s:17:\"faq_meta_keywords\";N;s:20:\"faq_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(25, 'sm_theme_options_testimonial_setting', 'a:1:{s:17:\"testimonial_title\";s:27:\"Happy Clients <br> About Us\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(26, 'sm_theme_options_team_setting', 'a:8:{s:17:\"team_banner_title\";s:13:\"JOIN OUR TEAM\";s:20:\"team_banner_subtitle\";s:24:\"A World of Opportunities\";s:17:\"team_banner_image\";N;s:10:\"team_title\";s:11:\"Expert Team\";s:13:\"team_subtitle\";s:77:\"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium.\";s:14:\"team_seo_title\";N;s:18:\"team_meta_keywords\";N;s:21:\"team_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(27, 'sm_theme_options_services_setting', 'a:14:{s:20:\"service_banner_title\";s:12:\"OUR SERVICES\";s:23:\"service_banner_subtitle\";s:24:\"A World of Opportunities\";s:20:\"service_banner_image\";N;s:13:\"service_title\";s:39:\"Full Services of Our <br>Digital Agency\";s:16:\"service_subtitle\";s:77:\"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium.\";s:17:\"service_seo_image\";N;s:17:\"service_seo_title\";s:26:\"Search Engine Optimization\";s:23:\"service_seo_description\";s:818:\"Search engine marketing has evolved a way faster than other online services. To cope with the                            fast-changing scenario in digital marketing, Doodle Digital has adopted tried and true                            techniques and up-to-date insights to be able to assist businesses of all levels, from small                            concerns to large corporations with their digital marketing goals.Being committed to making                            online marketing services easy, affordable, and useful for businesses, we cooperate with                            professionals at different levels and interact with people, so we know how people think,                            buy,                            and live. This is how, we create each of our search engine marketing strategies.\";s:16:\"service_seo_link\";s:1:\"#\";s:23:\"services_posts_per_page\";N;s:29:\"services_is_breadcrumb_enable\";s:1:\"0\";s:18:\"services_seo_title\";N;s:22:\"services_meta_keywords\";N;s:25:\"services_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(28, 'sm_theme_options_services_detail_setting', 'a:6:{s:27:\"service_detail_banner_title\";s:12:\"OUR SERVICES\";s:30:\"service_detail_banner_subtitle\";s:24:\"A World of Opportunities\";s:27:\"service_detail_banner_image\";N;s:35:\"service_detail_is_breadcrumb_enable\";s:1:\"0\";s:25:\"service_detail_mail_title\";s:7:\"Hire Us\";s:28:\"service_detail_mail_subtitle\";s:17:\"15 Day FREE Trial\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(29, 'sm_theme_options_package_setting', 'a:5:{s:20:\"package_banner_title\";s:16:\"VIEW ALL PACKAGE\";s:23:\"package_banner_subtitle\";s:64:\"A World of Opportunities We all know that content has to be good\";s:20:\"package_banner_image\";N;s:28:\"package_is_breadcrumb_enable\";s:1:\"0\";s:22:\"package_posts_per_page\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(30, 'sm_theme_options_package_detail_setting', 'a:10:{s:35:\"package_detail_is_breadcrumb_enable\";s:1:\"0\";s:26:\"package_pricing_info_title\";s:12:\"Pricing Info\";s:25:\"package_detail_move_title\";s:20:\"Move to Package info\";s:24:\"package_detail_move_icon\";s:8:\"fa-heart\";s:11:\"step1_image\";N;s:11:\"step1_title\";s:21:\"Money Back Guaranteed\";s:17:\"step1_description\";s:46:\"Ang Lorem Ipsum ay ginaamit na modelo ng print\";s:11:\"step3_image\";N;s:11:\"step3_title\";s:22:\"Satisfaction Guarantee\";s:17:\"step3_description\";s:46:\"Ang Lorem Ipsum ay ginaamit na modelo ng print\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(31, 'sm_theme_options_blog_setting', 'a:9:{s:19:\"blog_posts_per_page\";N;s:17:\"blog_banner_title\";s:9:\"BLOG HOME\";s:20:\"blog_banner_subtitle\";s:24:\"A World of Opportunities\";s:17:\"blog_banner_image\";N;s:25:\"blog_is_breadcrumb_enable\";s:1:\"0\";s:13:\"blog_ad_image\";N;s:14:\"blog_seo_title\";N;s:18:\"blog_meta_keywords\";N;s:21:\"blog_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(32, 'sm_theme_options_blog_detail_setting', 'a:6:{s:24:\"blog_detail_banner_title\";s:9:\"BLOG HOME\";s:27:\"blog_detail_banner_subtitle\";s:24:\"A World of Opportunities\";s:24:\"blog_detail_banner_image\";N;s:32:\"blog_detail_is_breadcrumb_enable\";s:1:\"0\";s:27:\"blog_related_posts_per_page\";N;s:22:\"blog_comments_per_page\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(33, 'sm_theme_options_blog_sidebar_setting', 'a:6:{s:22:\"blog_popular_is_enable\";s:1:\"1\";s:27:\"blog_popular_posts_per_page\";N;s:18:\"blog_show_category\";s:1:\"1\";s:13:\"blog_show_tag\";s:1:\"1\";s:15:\"blog_sidebar_ad\";N;s:20:\"blog_sidebar_ad_link\";s:1:\"#\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(34, 'sm_theme_options_case_setting', 'a:8:{s:17:\"case_banner_title\";s:12:\"CASE DETAILS\";s:20:\"case_banner_subtitle\";s:24:\"A World of Opportunities\";s:17:\"case_banner_image\";N;s:25:\"case_is_breadcrumb_enable\";s:1:\"0\";s:19:\"case_posts_per_page\";N;s:14:\"case_seo_title\";N;s:18:\"case_meta_keywords\";N;s:21:\"case_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:30'),
(35, 'sm_theme_options_case_detail_setting', 'a:4:{s:24:\"case_detail_banner_title\";s:12:\"CASE DETAILS\";s:27:\"case_detail_banner_subtitle\";s:24:\"A World of Opportunities\";s:24:\"case_detail_banner_image\";N;s:32:\"case_detail_is_breadcrumb_enable\";s:1:\"0\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:31'),
(36, 'sm_theme_options_order_setting', 'a:7:{s:20:\"order_posts_per_page\";N;s:17:\"invoice_signature\";N;s:24:\"invoice_approved_by_name\";s:11:\"NPTL Author\";s:31:\"invoice_approved_by_designation\";s:23:\"Director of Development\";s:20:\"invoice_banner_title\";s:12:\"CASE DETAILS\";s:23:\"invoice_banner_subtitle\";s:44:\"If you\'re struggling to get more information\";s:20:\"invoice_banner_image\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:31'),
(37, 'sm_theme_options_social_setting', 'a:10:{s:15:\"social_facebook\";s:1:\"#\";s:14:\"social_twitter\";s:1:\"#\";s:15:\"social_linkedin\";N;s:18:\"social_google_plus\";s:1:\"#\";s:13:\"social_github\";N;s:16:\"social_pinterest\";N;s:14:\"social_behance\";N;s:15:\"social_dribbble\";N;s:16:\"social_instagram\";N;s:14:\"social_youtube\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:45:01'),
(38, 'sm_theme_options_footer_setting', 'a:8:{s:11:\"footer_logo\";s:19:\"logo-buckelup_1.png\";s:20:\"footer_widget2_title\";s:7:\"COMPANY\";s:26:\"footer_widget2_description\";s:138:\"<ul>\r\n	<li><a href=\"#\">About Us</a></li>\r\n	<li><a href=\"#\">Testimonials</a></li>\r\n	<li><a href=\"#\">Affiliate Program</a>&nbsp;</li>\r\n</ul>\";s:20:\"footer_widget3_title\";s:10:\"MY ACCOUNT\";s:26:\"footer_widget3_description\";s:210:\"<ul>\r\n	<li><a href=\"#\">My Order</a></li>\r\n	<li><a href=\"#\">My Wishlist</a></li>\r\n	<li><a href=\"#\">My Credit Slip</a></li>\r\n	<li><a href=\"#\">My Addresses</a></li>\r\n	<li><a href=\"#\">My Personal In</a></li>\r\n</ul>\";s:20:\"footer_widget4_title\";s:7:\"SUPPORT\";s:26:\"footer_widget4_description\";s:99:\"<ul>\r\n	<li><a href=\"#\">Terms &amp; Conditions</a></li>\r\n	<li><a href=\"#\">Contact Us</a></li>\r\n</ul>\";s:9:\"copyright\";s:30:\"© 2019 | All rights reserved.\";}', 1, 1, 1, 2, NULL, '2019-04-04 04:24:51'),
(39, 'sm_theme_options_popup_setting', 'a:11:{s:24:\"newsletter_pop_is_enable\";s:1:\"1\";s:20:\"newsletter_pop_title\";s:19:\"Join Our Newsletter\";s:26:\"newsletter_pop_description\";s:102:\"<p>We really care about you and your website as much as you do. from us you get 100% free support.</p>\";s:24:\"newsletter_success_title\";s:26:\"Thank You For Subscribing!\";s:30:\"newsletter_success_description\";s:131:\"You\'re just one step away from being one of our dear susbcribers.<br>Please check the Email provided and confirm your susbcription.\";s:32:\"newsletter_already_success_title\";s:27:\"Thank You For Your Efforts!\";s:38:\"newsletter_already_success_description\";s:41:\"You Already Subscribed To Our Newsletter!\";s:31:\"newsletter_form_success_message\";s:24:\"Subscribed successfully.\";s:15:\"offer_is_enable\";s:1:\"1\";s:11:\"offer_title\";s:20:\"1st Order To 30% Off\";s:17:\"offer_description\";s:135:\"<p>As content marketing continues to drive results for businesses trying to reach their audience</p>\r\n\r\n<p><a href=\"#\">Get More</a></p>\";}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:31'),
(40, 'sm_theme_options_style_n_script_setting', 'a:3:{s:20:\"google_analytic_code\";s:668:\"<script>\r\n        (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){\r\n            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\r\n            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\r\n        })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');\r\n\r\n        ga(\'create\', \'UA-XXXXXXXX-X\', \'auto\');\r\n        ga(\'send\', \'pageview\');\r\n        ga(\'require\', \'linkid\', \'linkid.js\');\r\n        ga(\'require\', \'displayfeatures\');\r\n        setTimeout(\"ga(\'send\',\'event\',\'Profitable Engagement\',\'time on page more than 30 seconds\')\",30000);\r\n    </script>\";s:21:\"mrks_theme_custom_css\";N;s:20:\"mrks_theme_custom_js\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:31'),
(41, 'sm_theme_options_other_setting', 'a:7:{s:29:\"checkout_is_breadcrumb_enable\";s:1:\"0\";s:21:\"checkout_banner_title\";s:8:\"Checkout\";s:24:\"checkout_banner_subtitle\";s:24:\"A World of Opportunities\";s:21:\"checkout_banner_image\";N;s:20:\"checkout_email_label\";s:35:\"Please provide your email address :\";s:26:\"checkout_email_description\";s:147:\"Please enter an email address you check regularly, as we use this to send updates regarding your job. this email address with the service provider.\";s:28:\"checkout_payment_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-04 03:36:31'),
(42, 'currency', '৳', 1, 1, 1, 1, NULL, '2019-04-01 10:35:49'),
(43, 'sm_theme_options_product_setting', 'a:9:{s:22:\"product_posts_per_page\";s:1:\"7\";s:20:\"product_banner_title\";s:12:\"PRODUCT HOME\";s:23:\"product_banner_subtitle\";s:24:\"A World of Opportunities\";s:20:\"product_banner_image\";s:14:\"listslide1.png\";s:28:\"product_is_breadcrumb_enable\";s:1:\"0\";s:16:\"product_ad_image\";N;s:17:\"product_seo_title\";N;s:21:\"product_meta_keywords\";N;s:24:\"product_meta_description\";N;}', 1, 1, 1, 2, NULL, '2019-04-06 11:06:05'),
(44, 'sm_theme_options_product_detail_setting', 'a:6:{s:27:\"product_detail_banner_title\";s:12:\"PRODUCT HOME\";s:30:\"product_detail_banner_subtitle\";s:24:\"A World of Opportunities\";s:27:\"product_detail_banner_image\";N;s:35:\"product_detail_is_breadcrumb_enable\";s:1:\"0\";s:30:\"product_related_posts_per_page\";N;s:25:\"product_comments_per_page\";N;}', 1, 1, 1, 2, NULL, '2019-04-06 10:51:12'),
(45, 'sm_theme_options_product_sidebar_setting', 'a:9:{s:25:\"product_popular_is_enable\";s:1:\"1\";s:30:\"product_popular_posts_per_page\";N;s:21:\"product_show_category\";s:1:\"1\";s:16:\"product_show_tag\";s:1:\"1\";s:18:\"product_show_brand\";s:1:\"1\";s:17:\"product_show_size\";s:1:\"1\";s:18:\"product_show_color\";s:1:\"1\";s:18:\"product_sidebar_ad\";N;s:23:\"product_sidebar_ad_link\";s:1:\"#\";}', 1, 1, 1, 2, NULL, '2019-04-07 05:51:04'),
(46, 'seo_title', 'Next Page Technology Ltd.', 1, 1, 1, 2, NULL, '2019-04-10 03:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `style` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `style`, `title`, `description`, `image`, `extra`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'slide1', 'Slider-1', 'Slider-1 Slider-1', 'slider2psd.jpg', 'a:2:{s:12:\"button_label\";a:1:{i:0;N;}s:11:\"button_link\";a:1:{i:0;N;}}', 1, NULL, 1, '2019-04-03 10:22:17', '2019-04-03 10:22:17'),
(2, 'slide1', 'Slider-2', 'Slider-2', 'slider2.jpg', 'a:2:{s:12:\"button_label\";a:1:{i:0;N;}s:11:\"button_link\";a:1:{i:0;N;}}', 1, NULL, 1, '2019-04-03 10:32:00', '2019-04-03 10:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Disabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `firstname`, `lastname`, `ip`, `city`, `state`, `country`, `extra`, `status`, `created_at`, `updated_at`) VALUES
(1, 'demo@ecommerce.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2019-03-18 22:59:08', '2019-03-18 22:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `taggable_id` int(10) UNSIGNED NOT NULL,
  `taggable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taggables`
--

INSERT INTO `taggables` (`id`, `tag_id`, `taggable_id`, `taggable_type`, `created_at`, `updated_at`) VALUES
(5, 9, 7, 'App\\Model\\Common\\Product', '2019-03-31 09:41:42', '2019-03-31 09:41:42'),
(6, 10, 8, 'App\\Model\\Common\\Product', '2019-04-10 07:09:22', '2019-04-10 07:09:22'),
(7, 11, 15, 'App\\Model\\Common\\Product', '2019-04-01 08:49:10', '2019-04-01 08:49:10'),
(8, 12, 16, 'App\\Model\\Common\\Product', '2019-04-01 09:33:57', '2019-04-01 09:33:57'),
(9, 13, 17, 'App\\Model\\Common\\Product', '2019-04-03 05:01:11', '2019-04-03 05:01:11'),
(10, 7, 18, 'App\\Model\\Common\\Product', '2019-04-03 05:03:25', '2019-04-03 05:03:25'),
(11, 13, 18, 'App\\Model\\Common\\Product', '2019-04-03 05:03:25', '2019-04-03 05:03:25'),
(12, 7, 19, 'App\\Model\\Common\\Product', '2019-04-03 05:04:53', '2019-04-03 05:04:53'),
(13, 14, 44, 'App\\Model\\Common\\Product', '2019-04-09 04:20:23', '2019-04-09 04:20:23'),
(14, 15, 48, 'App\\Model\\Common\\Product', '2019-04-10 05:32:45', '2019-04-10 05:32:45'),
(15, 16, 49, 'App\\Model\\Common\\Product', '2019-04-10 05:28:45', '2019-04-10 05:28:45'),
(16, 17, 8, 'App\\Model\\Common\\Product', '2019-04-10 07:09:22', '2019-04-10 07:09:22'),
(17, 18, 9, 'App\\Model\\Common\\Product', '2019-04-10 07:23:28', '2019-04-10 07:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `total_posts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `title`, `description`, `image`, `slug`, `views`, `total_posts`, `seo_title`, `meta_key`, `meta_description`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Tag-1', NULL, NULL, 'tag', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:39:23', '2019-04-03 06:03:10'),
(8, 'Tag-2', NULL, NULL, 'tag-2', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:39:31', '2019-03-31 09:39:31'),
(9, 'Lorem', NULL, NULL, 'lorem', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:41:42', '2019-04-03 04:58:03'),
(10, 'Velit', NULL, NULL, 'velit', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-03-31 09:42:02', '2019-04-03 04:58:01'),
(11, 'dfs', NULL, NULL, 'dfs', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-01 08:49:10', '2019-04-03 04:57:44'),
(12, 'Exceptur', NULL, NULL, 'exceptur', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-01 09:33:57', '2019-04-03 04:57:41'),
(13, 'tag1', NULL, NULL, 'tag1', 0, 0, NULL, NULL, NULL, 1, NULL, 1, '2019-04-03 05:01:11', '2019-04-03 06:03:12'),
(14, '24234', NULL, NULL, '24234', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-07 05:48:07', '2019-04-07 05:48:07'),
(15, 'sdfsd', NULL, NULL, 'sdfsd', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-09 10:43:43', '2019-04-09 10:43:43'),
(16, '21321', NULL, NULL, '21321', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 05:27:42', '2019-04-10 05:27:42'),
(17, 'gdgsf', NULL, NULL, 'gdgsf', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 07:00:57', '2019-04-10 07:00:57'),
(18, 'kll', NULL, NULL, 'kll', 0, 1, NULL, NULL, NULL, 1, NULL, 1, '2019-04-10 07:23:28', '2019-04-10 07:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax` double(5,2) NOT NULL DEFAULT '0.00',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1 = Fixed and 2 = Percentage',
  `created_by` int(10) UNSIGNED NOT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Completed, 2=Processing, 3=Pending, 4=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1=Solved, 2=Processing, 3=Pending, 4=Cancelled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `order_id`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'A quis earum non rep', 'wrwqewq', 2, '2019-03-27 21:58:45', '2019-03-27 21:58:45'),
(2, 2, 2, 'A quis earum non rep', 'xzxczcz', 2, '2019-04-02 06:16:40', '2019-04-02 06:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_details`
--

CREATE TABLE `tickets_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets_details`
--

INSERT INTO `tickets_details` (`id`, `ticket_id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'asdad', '2019-03-27 21:59:16', '2019-03-27 21:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actual_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `modified_by` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=active, 2=pending, 3=cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `title`, `slug`, `actual_name`, `created_by`, `modified_by`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Pc(s)', 'pcs', 'piecs', 1, NULL, 1, '2019-03-21 03:02:55', '2019-03-21 03:02:55'),
(3, 'Set', 'set', 'set', 1, NULL, 1, '2019-03-21 03:03:06', '2019-03-21 03:03:06'),
(4, 'asdasdsad', 'asdasdsad', 'asdsadasda', 1, NULL, 2, NULL, NULL),
(5, 'kgs', 'kgs', 'kgsss', 1, NULL, 2, NULL, NULL),
(6, '24234', '24234', '23423', 1, NULL, 2, NULL, NULL),
(7, 'Gram', 'gram', 'Gram', 1, NULL, 2, NULL, NULL),
(8, 'Picess', 'picess', 'PicessPicess', 1, NULL, 2, NULL, NULL),
(9, 'Calvin Beans', 'calvin-beans', NULL, 1, NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `auth_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1=Active, 2=Pending, 3=Cancel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `auth_id`, `username`, `email`, `firstname`, `lastname`, `job_title`, `company`, `mobile`, `password`, `image`, `street`, `city`, `zip`, `country`, `state`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(5, NULL, 'admin1', 'admin1@gmail.com', NULL, NULL, NULL, NULL, NULL, '$2y$10$ob5Kesfu/Q.HLwSHHe0Hl.5R5yJjQua0Giuf5IKqzdcaDXmxkiu8.', NULL, NULL, NULL, NULL, NULL, NULL, 'XTR3ZsKwEF9hlzJAterz2kQvjAuPpShL6enRA76eRmg7aWhzLINKPOpAEICm', 1, '2019-04-08 05:31:58', '2019-04-08 05:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `users_metas`
--

CREATE TABLE `users_metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_metas`
--

INSERT INTO `users_metas` (`id`, `user_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(1, 2, 'user_online_status', '1', '2019-03-27 03:45:57', '2019-03-27 03:45:57'),
(2, 2, 'skype', NULL, '2019-03-27 04:19:36', '2019-03-27 04:19:36'),
(3, 2, 'front_user_online_status', '0', '2019-03-27 04:30:15', '2019-03-27 04:30:15'),
(4, 2, 'front_user_last_activity', '2019-04-08 11:20:35', '2019-03-27 04:30:15', '2019-04-08 05:20:35'),
(5, 3, 'front_user_online_status', '0', '2019-03-27 04:52:24', '2019-03-27 04:52:24'),
(6, 3, 'front_user_last_activity', '2019-03-27 10:52:24', '2019-03-27 04:52:24', '2019-03-27 04:52:24'),
(7, 5, 'front_user_online_status', '0', '2019-04-08 05:32:07', '2019-04-08 05:32:07'),
(8, 5, 'front_user_last_activity', '2019-04-09 11:11:47', '2019-04-08 05:32:07', '2019-04-09 05:11:47'),
(9, 5, 'user_online_status', '1', '2019-04-08 05:34:23', '2019-04-08 05:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `date`, `views`) VALUES
(1, '2019-03-19', 3),
(2, '2019-03-21', 5),
(3, '2019-03-23', 3),
(4, '2019-03-24', 1),
(5, '2019-03-27', 7),
(6, '2019-03-28', 5),
(7, '2019-03-31', 6),
(8, '2019-04-01', 3),
(9, '2019-04-02', 2),
(10, '2019-04-03', 1),
(11, '2019-04-04', 3),
(12, '2019-04-06', 1),
(13, '2019-04-07', 1),
(14, '2019-04-08', 10),
(15, '2019-04-09', 2),
(16, '2019-04-10', 4);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(10, 2, 40, '2019-04-04 07:14:56', '2019-04-04 07:14:56'),
(14, 2, 40, '2019-04-04 08:58:54', '2019-04-04 08:58:54'),
(15, 5, 44, '2019-04-09 05:10:58', '2019-04-09 05:10:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_firstname_index` (`firstname`),
  ADD KEY `admins_lastname_index` (`lastname`),
  ADD KEY `admins_role_id_index` (`role_id`),
  ADD KEY `admins_status_index` (`status`);

--
-- Indexes for table `admins_metas`
--
ALTER TABLE `admins_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_metas_admin_id_index` (`admin_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_attributetitle_id_index` (`attributetitle_id`),
  ADD KEY `attributes_title_index` (`title`),
  ADD KEY `attributes_type_index` (`type`),
  ADD KEY `attributes_status_index` (`status`);

--
-- Indexes for table `attributetitles`
--
ALTER TABLE `attributetitles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attributetitles_slug_unique` (`slug`),
  ADD KEY `attributetitles_title_index` (`title`),
  ADD KEY `attributetitles_status_index` (`status`);

--
-- Indexes for table `attribute_product`
--
ALTER TABLE `attribute_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_title_index` (`title`),
  ADD KEY `blogs_is_sticky_index` (`is_sticky`),
  ADD KEY `blogs_comment_enable_index` (`comment_enable`),
  ADD KEY `blogs_status_index` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`),
  ADD KEY `brands_title_index` (`title`),
  ADD KEY `brands_status_index` (`status`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cases_slug_unique` (`slug`),
  ADD KEY `cases_status_index` (`status`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_title_index` (`title`),
  ADD KEY `categories_status_index` (`status`);

--
-- Indexes for table `categoryables`
--
ALTER TABLE `categoryables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryables_category_id_index` (`category_id`),
  ADD KEY `categoryables_categoryable_id_index` (`categoryable_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_commentable_id_index` (`commentable_id`),
  ADD KEY `comments_p_c_id_index` (`p_c_id`),
  ADD KEY `comments_created_by_index` (`created_by`),
  ADD KEY `comments_status_index` (`status`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_status_index` (`status`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_liker_id_index` (`liker_id`),
  ADD KEY `likes_liker_ip_index` (`liker_ip`),
  ADD KEY `likes_likeable_id_index` (`likeable_id`),
  ADD KEY `likes_likeable_type_index` (`likeable_type`),
  ADD KEY `likes_status_index` (`status`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_slug_unique` (`slug`),
  ADD KEY `media_is_private_index` (`is_private`),
  ADD KEY `media_title_index` (`title`);

--
-- Indexes for table `media_permissions`
--
ALTER TABLE `media_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_permissions_media_id_index` (`media_id`),
  ADD KEY `media_permissions_user_id_index` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_net_total_index` (`net_total`),
  ADD KEY `orders_paid_index` (`paid`),
  ADD KEY `orders_payment_status_index` (`payment_status`),
  ADD KEY `orders_order_status_index` (`order_status`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_index` (`order_id`),
  ADD KEY `order_details_package_detail_id_index` (`product_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_slug_unique` (`slug`),
  ADD KEY `packages_type_index` (`type`),
  ADD KEY `packages_status_index` (`status`);

--
-- Indexes for table `package_details`
--
ALTER TABLE `package_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_menu_title_index` (`menu_title`),
  ADD KEY `pages_page_title_index` (`page_title`),
  ADD KEY `pages_views_index` (`views`),
  ADD KEY `pages_created_by_index` (`created_by`),
  ADD KEY `pages_status_index` (`status`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_status_index` (`status`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_status_index` (`status`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_title_index` (`title`),
  ADD KEY `products_brand_id_index` (`brand_id`),
  ADD KEY `products_unit_id_index` (`unit_id`),
  ADD KEY `products_is_featured_index` (`is_featured`),
  ADD KEY `products_is_sticky_index` (`is_sticky`),
  ADD KEY `products_comment_enable_index` (`comment_enable`),
  ADD KEY `products_status_index` (`status`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_name_index` (`name`),
  ADD KEY `roles_created_by_index` (`created_by`),
  ADD KEY `roles_status_index` (`status`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_status_index` (`status`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_option_name_unique` (`option_name`),
  ADD KEY `settings_created_by_index` (`created_by`),
  ADD KEY `settings_autoload_index` (`autoload`),
  ADD KEY `settings_status_index` (`status`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_created_by_index` (`created_by`),
  ADD KEY `sliders_status_index` (`status`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`),
  ADD KEY `subscribers_firstname_index` (`firstname`),
  ADD KEY `subscribers_lastname_index` (`lastname`),
  ADD KEY `subscribers_status_index` (`status`);

--
-- Indexes for table `taggables`
--
ALTER TABLE `taggables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taggables_tag_id_index` (`tag_id`),
  ADD KEY `taggables_taggable_id_index` (`taggable_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`),
  ADD KEY `tags_title_index` (`title`),
  ADD KEY `tags_created_by_index` (`created_by`),
  ADD KEY `tags_status_index` (`status`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_status_index` (`status`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_index` (`user_id`),
  ADD KEY `tickets_order_id_index` (`order_id`),
  ADD KEY `tickets_status_index` (`status`);

--
-- Indexes for table `tickets_details`
--
ALTER TABLE `tickets_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_details_ticket_id_index` (`ticket_id`),
  ADD KEY `tickets_details_user_id_index` (`user_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_slug_unique` (`slug`),
  ADD KEY `units_status_index` (`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD KEY `users_firstname_index` (`firstname`),
  ADD KEY `users_lastname_index` (`lastname`),
  ADD KEY `users_job_title_index` (`job_title`),
  ADD KEY `users_company_index` (`company`),
  ADD KEY `users_status_index` (`status`),
  ADD KEY `users_auth_id_index` (`auth_id`);

--
-- Indexes for table `users_metas`
--
ALTER TABLE `users_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_metas_user_id_index` (`user_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitors_date_index` (`date`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins_metas`
--
ALTER TABLE `admins_metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attributetitles`
--
ALTER TABLE `attributetitles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attribute_product`
--
ALTER TABLE `attribute_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `categoryables`
--
ALTER TABLE `categoryables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `media_permissions`
--
ALTER TABLE `media_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `package_details`
--
ALTER TABLE `package_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taggables`
--
ALTER TABLE `taggables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets_details`
--
ALTER TABLE `tickets_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_metas`
--
ALTER TABLE `users_metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_attributetitle_id_foreign` FOREIGN KEY (`attributetitle_id`) REFERENCES `attributetitles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
