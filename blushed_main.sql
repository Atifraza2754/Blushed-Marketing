-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2026 at 11:32 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blushed_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_quiz_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_recap_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_training_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `is_info_uploaded` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `user_id`, `title`, `slug`, `description`, `image`, `is_quiz_uploaded`, `is_recap_uploaded`, `is_training_uploaded`, `is_info_uploaded`, `status`, `featured`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Junction 35', 'junction-35', NULL, NULL, 1, 1, 1, 1, 1, 0, '2026-01-18 05:19:43', '2026-01-18 08:41:52', NULL),
(2, NULL, 'BlushedBrandKhadim', 'blushedbrandkhadim', NULL, NULL, 1, 1, 1, 1, 1, 0, '2026-01-19 12:21:37', '2026-01-19 12:23:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bulk_invite_user`
--

CREATE TABLE `bulk_invite_user` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `dial_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'India', 'IN', '+91', 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(2, 'Pakistan', 'PK', '+92', 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(3, 'Qatar', 'QTR', '+974', 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `crons_track`
--

CREATE TABLE `crons_track` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `default_rates`
--

CREATE TABLE `default_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `flat_rate` double(8,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flat_rate_deduction`
--

CREATE TABLE `flat_rate_deduction` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_date` date DEFAULT NULL,
  `deduction_date` date DEFAULT NULL,
  `flat_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deduction_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_rate_after_deduction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_deduction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_to_user` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ict_form`
--

CREATE TABLE `ict_form` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `federal_tax_classification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exempt_payee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatca_reporting_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_state_zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_security_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer_identification_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digital_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE `infos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infos`
--

INSERT INTO `infos` (`id`, `user_id`, `brand_id`, `title`, `slug`, `description`, `file`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'asdf', 'asdf', 'asdf', NULL, 1, '2026-01-18 05:21:32', '2026-01-18 05:21:32', NULL),
(4, 1, 2, 'asf', 'asf', 'asf', NULL, 1, '2026-01-19 12:23:03', '2026-01-19 12:23:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `info_files`
--

CREATE TABLE `info_files` (
  `id` bigint UNSIGNED NOT NULL,
  `info_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `files` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `info_files`
--

INSERT INTO `info_files` (`id`, `info_id`, `brand_id`, `created_by`, `files`, `name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 0, 'infos_4_Khadim_Hussain_CV.pdf.docx', 'Khadim_Hussain_CV.pdf.docx', 0, '2026-01-19 12:23:03', '2026-01-19 12:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

CREATE TABLE `invites` (
  `id` bigint UNSIGNED NOT NULL,
  `invited_by` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invite_link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invite_qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_signup` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invites`
--

INSERT INTO `invites` (`id`, `invited_by`, `role_id`, `email`, `invite_link`, `invite_qr_code`, `has_signup`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'admin2@gmail.com', NULL, NULL, 0, 1, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(2, 1, 3, 'recruiter2@gmail.com', NULL, NULL, 0, 1, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(3, 1, 4, 'accounter2@gmail.com', NULL, NULL, 0, 1, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(4, 2, 5, 'user2@gmail.com', NULL, NULL, 0, 1, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_c`
--

CREATE TABLE `jobs_c` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift_start` time NOT NULL,
  `shift_end` time NOT NULL,
  `scheduled_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_of_communication` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `skus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `how_to_serve` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplies_needed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `samples_requested` tinyint(1) NOT NULL DEFAULT '0',
  `reschedule` tinyint(1) NOT NULL DEFAULT '0',
  `added_to_homebase` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs_c`
--

INSERT INTO `jobs_c` (`id`, `user_id`, `date`, `account`, `address`, `contact`, `phone`, `shift_start`, `shift_end`, `scheduled_time`, `timezone`, `email`, `method_of_communication`, `brand`, `brand_id`, `skus`, `notes`, `how_to_serve`, `supplies_needed`, `attire`, `samples_requested`, `reschedule`, `added_to_homebase`, `confirmed`, `is_published`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2023-05-20', 'Green Meadows', '1147 Hunters Crossing, Alcoa, TN 37701', 'Rebecca', '865-233-4327', '13:00:00', '14:55:00', '1:00pm-2:55pm', 'EST', 'rebecca.gmws@gmail.com', 'call', 'Junction 35', 1, 'Bam Bam Vodka, Straight Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:19:42', '2026-01-18 05:19:43', NULL),
(2, 1, '2023-05-25', 'Total Wine Knox', '11370 Parkside Dr. Knoxville, TN 37934', NULL, '865-672-5100', '11:00:00', '14:00:00', '11am-2pm', 'EST', 'htaylor@totalwine.com              ', 'call', 'Junction 35', 1, 'Bam Bam, Blk Cherry whiskey', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:19:43', '2026-01-18 05:19:43', NULL),
(3, 1, '2023-05-26', 'City Farms', '157 N Calderwood St, Alcoa, TN', 'Andrew', '865-500-3443', '15:00:00', '18:00:00', '3pm-6pm', 'EST', NULL, 'call', 'Junction 35', 1, 'Bam Bam, Blk Cherry whiskey, Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:19:43', '2026-01-18 05:19:43', NULL),
(4, 1, '2023-06-03', 'Merchants W&S', '112 Cedar Ln, Knoxville, TN 37912', NULL, 'Store# 865-688-5449', '12:00:00', '13:00:00', '12pm-1pm', 'EST', NULL, 'call', 'junction 35', 1, 'Bam Bam, Blk Cherry, bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 1, '2026-01-18 05:19:43', '2026-01-18 05:22:17', NULL),
(5, 1, '2026-01-18', 'Green Meadows', '1147 Hunters Crossing, Alcoa, TN 37701', 'Rebecca', '865-233-4327', '15:00:00', '16:00:00', '3:00pm-4:00pm', 'EST', 'rebecca.gmws@gmail.com', 'call', 'Junction 35', 1, 'Bam Bam Vodka, Straight Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 1, '2026-01-18 05:51:11', '2026-01-18 05:52:05', NULL),
(6, 1, '2023-05-25', 'Total Wine Knox', '11370 Parkside Dr. Knoxville, TN 37934', NULL, '865-672-5100', '11:00:00', '14:00:00', '11am-2pm', 'EST', 'htaylor@totalwine.com              ', 'call', 'Junction 35', 1, 'Bam Bam, Blk Cherry whiskey', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:51:11', '2026-01-18 05:51:12', NULL),
(7, 1, '2023-05-26', 'City Farms', '157 N Calderwood St, Alcoa, TN', 'Andrew', '865-500-3443', '15:00:00', '18:00:00', '3pm-6pm', 'EST', NULL, 'call', 'Junction 35', 1, 'Bam Bam, Blk Cherry whiskey, Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:51:11', '2026-01-18 05:51:12', NULL),
(8, 1, '2023-06-03', 'Merchants W&S', '112 Cedar Ln, Knoxville, TN 37912', NULL, 'Store# 865-688-5449', '12:00:00', '13:00:00', '12pm-1pm', 'EST', NULL, 'call', 'junction 35', 1, 'Bam Bam, Blk Cherry, bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 0, '2026-01-18 05:51:11', '2026-01-18 05:51:12', NULL),
(9, 1, '2026-01-19', 'Green Meadows', '1147 Hunters Crossing, Alcoa, TN 37701', 'Rebecca', '865-233-4327', '22:15:00', '22:50:00', '10:15pm-10:50pm', 'PST', 'rebecca.gmws@gmail.com', 'call', 'BlushedBrandKhadim', 2, 'Bam Bam Vodka, Straight Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 1, '2026-01-19 12:21:36', '2026-01-19 12:23:48', NULL),
(10, 1, '2026-01-19', 'Green Meadows', '1147 Hunters Crossing, Alcoa, TN 37701', 'Rebecca', '865-233-4327', '22:15:00', '22:50:00', '10:15pm-10:50pm', 'EST', 'rebecca.gmws@gmail.com', 'call', 'BlushedBrandKhadim', 2, 'Bam Bam Vodka, Straight Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 1, '2026-01-19 12:25:26', '2026-01-19 13:19:17', NULL),
(11, 1, '2026-01-19', 'Green Meadows', '1147 Hunters Crossing, Alcoa, TN 37701', 'Rebecca', '865-233-4327', '23:10:00', '00:00:00', '11:10pm-12:00am', 'EST', 'rebecca.gmws@gmail.com', 'call', 'BlushedBrandKhadim', 2, 'Bam Bam Vodka, Straight Bourbon', '0', '0', '0', '0', 0, 0, 0, 0, 1, '2026-01-21 13:45:20', '2026-01-21 13:47:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_coverage_offers`
--

CREATE TABLE `job_coverage_offers` (
  `id` bigint UNSIGNED NOT NULL,
  `coverage_request_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_coverage_requests`
--

CREATE TABLE `job_coverage_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `requestor_id` bigint UNSIGNED NOT NULL,
  `coverage_user_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('unable','can_if_needed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_members`
--

CREATE TABLE `job_members` (
  `id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `flat_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_members`
--

INSERT INTO `job_members` (`id`, `job_id`, `user_id`, `flat_rate`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 8, '0', 'approved', '2026-01-18 05:19:58', '2026-01-19 12:40:23', NULL),
(2, 5, 8, '0', 'approved', '2026-01-18 05:51:44', '2026-01-18 05:52:19', NULL),
(3, 10, 8, '0', 'pending', '2026-01-19 12:26:15', '2026-01-19 12:26:50', '2026-01-19 12:26:50'),
(4, 10, 8, '0', 'pending', '2026-01-19 12:29:03', '2026-01-19 12:29:03', NULL),
(5, 11, 8, '0', 'pending', '2026-01-21 13:45:33', '2026-01-21 13:45:36', '2026-01-21 13:45:36'),
(6, 11, 8, '10', 'approved', '2026-01-21 13:45:44', '2026-01-21 13:48:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_members_work_history`
--

CREATE TABLE `job_members_work_history` (
  `id` bigint UNSIGNED NOT NULL,
  `job_member_id` bigint UNSIGNED NOT NULL,
  `work_history_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_users`
--

CREATE TABLE `lead_users` (
  `id` bigint UNSIGNED NOT NULL,
  `lead_user_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_active` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `message`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Hi, i need help about w9form', 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(2, 5, 'Hi, i need help about payroll form', 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(3, 6, 'Hi, i need help about w9form', 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_10_24_083534_create_countries_table', 1),
(2, '2012_10_26_082752_create_roles_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(7, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(8, '2022_10_27_083739_create_site_settings_table', 1),
(9, '2023_10_26_083534_create_invites_table', 1),
(10, '2023_11_18_124554_create_brands_table', 1),
(11, '2023_11_18_124554_create_trainings_table', 1),
(12, '2023_11_18_124554_create_users_trainings_table', 1),
(13, '2023_11_19_124554_create_infos_table', 1),
(14, '2023_11_20_083500_create_quizzes_table', 1),
(15, '2023_11_21_083530_create_quiz_questions_table', 1),
(16, '2023_11_21_083533_create_quiz_question_options_table', 1),
(17, '2023_11_21_083534_create_user_quizzes_table', 1),
(18, '2023_11_23_083534_create_recaps_table', 1),
(19, '2023_11_23_083535_create_recap_questions_table', 1),
(20, '2023_11_24_083535_create_recap_question_options_table', 1),
(21, '2023_11_25_083534_create_user_recaps_table', 1),
(22, '2023_11_25_083540_create_user_recap_questions_table', 1),
(23, '2023_11_29_194832_create_jobs_table', 1),
(24, '2023_11_29_194833_create_job_members_table', 1),
(25, '2023_12_21_074046_create_w9forms_table', 1),
(26, '2023_12_21_074105_create_payrolls_table', 1),
(27, '2023_12_21_074113_create_messages_table', 1),
(28, '2024_04_15_205335_add_extra_columns_for_user_role_in_users_table', 1),
(29, '2024_05_16_194247_create_notifications_table', 1),
(30, '2024_11_02_145440_add_status_to_user_quizzes_table', 1),
(31, '2024_11_04_170515_add_answer_and_recap_question_id_column_to_user_recap_question', 1),
(32, '2024_11_05_182015_add_notes_colum_in_jobs', 1),
(33, '2024_11_08_054412_create_user_payment_job_history_table', 1),
(34, '2024_11_20_200615_create_job_members_work_history', 1),
(35, '2024_11_20_200651_create_work_history_table', 1),
(36, '2024_11_20_201011_create_user_flat_rate_history_table', 1),
(37, '2024_11_20_201456_alter_user_payment_job_history_add_column', 1),
(38, '2024_12_13_132024_create__user_quiz_reattempt_table', 1),
(39, '2024_12_23_193005_alter_table_work_history_add_column', 1),
(40, '2024_12_24_051853_alter_table_work_history_add', 1),
(41, '2024_12_25_173117_alter_table_work_history_add_new_column', 1),
(42, '2025_01_04_094619_alter_table_job_add_shift_strt_end', 1),
(43, '2025_02_15_165541_create_default_rates_table', 1),
(44, '2025_02_21_214707_create_bulk_invite_user_table', 1),
(45, '2025_04_08_180421_create_table_ict_form', 1),
(46, '2025_04_08_185706_alter_table_user', 1),
(47, '2025_04_13_123546_flat_rate_deduction', 1),
(48, '2025_04_17_043245_crons_tracking_table', 1),
(49, '2025_04_19_132533_alter_table_job_add_brand_id', 1),
(50, '2025_04_27_081612_create_training_files', 1),
(51, '2025_04_28_131739_alter_user_table_add_slug_column', 1),
(52, '2025_04_29_175057_create_info_files_table', 1),
(53, '2025_05_12_131724_alter_table_user_quiz', 1),
(54, '2025_05_25_090345_create_job_coverage_requests_table', 1),
(55, '2025_05_25_090539_create_job_coverage_offers_table', 1),
(56, '2025_05_29_192354_alter_table_jobs_add_supplies', 1),
(57, '2025_06_02_065919_alter_table_add_is_lead', 1),
(58, '2025_06_02_070104_create_lead_users_table', 1),
(59, '2025_07_20_152452_alter_table_user', 1),
(60, '2025_08_09_141902_alter_table_add_recap_url', 1),
(61, '2025_08_23_075213_alter_table_add_shift_id_column', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `description`, `link`, `created_at`, `updated_at`) VALUES
(1, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/4/detail', '2026-01-18 05:19:58', '2026-01-18 05:19:58'),
(2, 8, 'New Job Published', 'View job details', '/user/shift/4/detail', '2026-01-18 05:22:17', '2026-01-18 05:22:17'),
(3, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/5/detail', '2026-01-18 05:51:44', '2026-01-18 05:51:44'),
(4, 8, 'New Job Published', 'View job details', '/user/shift/5/detail', '2026-01-18 05:52:05', '2026-01-18 05:52:05'),
(5, 8, 'New Job Published', 'view job details', '/user/shift/5/detail', '2026-01-18 05:52:19', '2026-01-18 05:52:19'),
(6, 1, 'IC Agreement Form Submitted', 'IC Agreement Form has been submitted by Khadim ', '/onboarding/ic-aggrement/4', '2026-01-18 08:14:00', '2026-01-18 08:14:00'),
(7, 1, 'IC Agreement Form Submitted', 'IC Agreement Form has been submitted by Super Admin ', '/onboarding/ic-aggrement/5', '2026-01-18 08:25:55', '2026-01-18 08:25:55'),
(8, 8, 'Reca[ Update', 'The Recap of Junction 35has Updated. Please review it.', 'http://127.0.0.1:8000/user/recap/3', '2026-01-18 08:41:52', '2026-01-18 08:41:52'),
(9, 8, 'Reca[ Update', 'The Recap of Junction 35has Updated. Please review it.', 'http://127.0.0.1:8000/user/recap/4', '2026-01-18 08:41:52', '2026-01-18 08:41:52'),
(10, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/10/detail', '2026-01-19 12:26:15', '2026-01-19 12:26:15'),
(11, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/10/detail', '2026-01-19 12:29:03', '2026-01-19 12:29:03'),
(12, 8, 'New Job Published', 'view job details', '/user/shift/4/detail', '2026-01-19 12:40:23', '2026-01-19 12:40:23'),
(13, 8, 'New Job Published', 'View job details', '/user/shift/10/detail', '2026-01-19 13:19:17', '2026-01-19 13:19:17'),
(14, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/11/detail', '2026-01-21 13:45:33', '2026-01-21 13:45:33'),
(15, 8, 'Added To The Job', 'You Have Been Added To a Job. Please review it.', 'http://127.0.0.1:8000/user/shift/11/detail', '2026-01-21 13:45:44', '2026-01-21 13:45:44'),
(16, 8, 'New Job Published', 'View job details', '/user/shift/11/detail', '2026-01-21 13:47:10', '2026-01-21 13:47:10'),
(17, 8, 'New Job Published', 'view job details', '/user/shift/11/detail', '2026-01-21 13:48:25', '2026-01-21 13:48:25'),
(18, 8, 'Payment Approved', 'Congratulations! Your payment has been approved successfully.', 'http://127.0.0.1:8000/user/notifications/18', '2026-01-22 12:09:56', '2026-01-22 12:09:56'),
(19, 8, 'Payment Approved', 'Congratulations! Your payment has been approved successfully.', 'http://127.0.0.1:8000/user/notifications/19', '2026-01-22 12:10:02', '2026-01-22 12:10:02'),
(20, 8, 'Payment Paid', 'Your payment has been successfully paid. Thank you!', 'http://127.0.0.1:8000/user/notifications/20', '2026-01-22 12:10:22', '2026-01-22 12:10:22'),
(21, 8, '⚠️ Recap Pending – Penalty Warning', 'Your shift recap is still pending.\nPenalty applies at $5 per 24 hours.\nCurrent penalty: $50', 'http://127.0.0.1:8000/user/notifications/21', '2026-01-28 13:18:07', '2026-01-28 13:18:07'),
(22, 8, '⚠️ Recap Pending – Penalty Warning', 'Your shift recap is still pending.\nPenalty applies at $5 per 24 hours.\nCurrent penalty: $50', 'http://127.0.0.1:8000/user/notifications/22', '2026-01-28 13:18:30', '2026-01-28 13:18:30'),
(23, 8, '⚠️ Recap Pending – Penalty Warning', 'Your shift recap is still pending.\nPenalty applies at $5 per 24 hours.\nCurrent penalty: $4850', 'http://127.0.0.1:8000/user/notifications/23', '2026-01-28 13:19:00', '2026-01-28 13:19:00'),
(24, 8, '⚠️ Recap Pending – Penalty Warning', 'Your shift recap is still pending.\nPenalty applies at $5 per 24 hours.\nCurrent penalty: $45', 'http://127.0.0.1:8000/user/notifications/24', '2026-01-28 13:19:02', '2026-01-28 13:19:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatca_reporting_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voided_check` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `user_id`, `name`, `phone_no`, `payment_preference`, `email_address`, `fatca_reporting_code`, `address`, `voided_check`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Alex', NULL, NULL, 'email200@gmail.com', NULL, 'Address 1', NULL, 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(2, 6, 'John', NULL, NULL, 'email201@gmail.com', NULL, 'Address 2', NULL, 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `user_id`, `brand_id`, `title`, `description`, `image`, `no_of_questions`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'sadfsa', 'asdf', '1768731712_99626.jpeg', '0', 1, '2026-01-18 05:21:52', '2026-01-18 05:21:52', NULL),
(4, 1, 2, 'asf', 'asfd', NULL, '0', 1, '2026-01-19 12:23:13', '2026-01-19 12:23:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question_options`
--

CREATE TABLE `quiz_question_options` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_question_id` bigint UNSIGNED NOT NULL,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recaps`
--

CREATE TABLE `recaps` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `no_of_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recaps`
--

INSERT INTO `recaps` (`id`, `user_id`, `brand_id`, `title`, `description`, `event_date`, `due_date`, `no_of_questions`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'sadf', NULL, NULL, NULL, '1', 1, '2026-01-18 08:41:52', '2026-01-18 08:41:52', NULL),
(4, 1, 2, 'asdf', NULL, NULL, NULL, '1', 1, '2026-01-19 12:23:32', '2026-01-19 12:23:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recap_questions`
--

CREATE TABLE `recap_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `recap_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recap_questions`
--

INSERT INTO `recap_questions` (`id`, `recap_id`, `title`, `description`, `question_type`, `options`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'asdf', NULL, 'radio-question', 'asdf', 1, '2026-01-18 05:22:09', '2026-01-18 08:41:52', '2026-01-18 08:41:52'),
(2, 1, 'asdf', NULL, 'radio-question', 'asdf', 1, '2026-01-18 08:41:52', '2026-01-18 08:41:52', NULL),
(16, 4, 'asfdasfas', NULL, 'radio-question', 'asfdas', 1, '2026-01-19 12:23:32', '2026-01-19 12:23:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recap_question_options`
--

CREATE TABLE `recap_question_options` (
  `id` bigint UNSIGNED NOT NULL,
  `recap_question_id` bigint UNSIGNED NOT NULL,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `modules` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `is_admin`, `modules`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 0, NULL, 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(2, 'Admin', 1, NULL, 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(3, 'Recruiter', 1, NULL, 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(4, 'Accounter', 1, NULL, 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL),
(5, 'User', 0, NULL, 1, '2026-01-18 05:14:39', '2026-01-18 05:14:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_publisher`, `logo`, `favicon`, `about`, `email`, `mobile_no`, `phone_no`, `whatsapp_no`, `address`, `facebook`, `instagram`, `twitter`, `snapchat`, `linkedin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Blushed', 'Ubba Soft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`id`, `user_id`, `brand_id`, `title`, `slug`, `description`, `file`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'asdf', 'asdf', 'asdf', NULL, '2026-01-18', '2026-01-18', 1, '2026-01-18 05:21:20', '2026-01-18 05:21:20', NULL),
(4, 1, 2, 'asfd', 'asfd', 'sadfs', NULL, '2026-01-19', '2026-01-19', 1, '2026-01-19 12:22:49', '2026-01-19 12:22:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training_files`
--

CREATE TABLE `training_files` (
  `id` bigint UNSIGNED NOT NULL,
  `training_id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `files` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training_files`
--

INSERT INTO `training_files` (`id`, `training_id`, `brand_id`, `created_by`, `files`, `name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 'training_1_Khadim_Hussain_CV.pdf', 'Khadim_Hussain_CV.pdf', 0, '2026-01-18 05:21:20', '2026-01-18 05:21:20'),
(2, 4, 2, 0, 'training_4_HadiqaIrfanResume..pdf', 'HadiqaIrfanResume..pdf', 0, '2026-01-19 12:22:50', '2026-01-19 12:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `is_lead` int NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile_no` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_mobile_no_verified` tinyint(1) NOT NULL DEFAULT '0',
  `mobile_no_verified_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pr` tinyint NOT NULL,
  `is_w9` tinyint NOT NULL,
  `is_ic` tinyint NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `slug`, `role_id`, `is_lead`, `name`, `last_name`, `email`, `form_type`, `verification_code`, `is_email_verified`, `email_verified_at`, `mobile_no`, `is_mobile_no_verified`, `mobile_no_verified_at`, `profile_image`, `gender`, `date_of_birth`, `country_id`, `state`, `city`, `zipcode`, `address`, `flat_rate`, `image_1`, `image_2`, `image_3`, `image_4`, `resume`, `certificate`, `expiry_date`, `is_pr`, `is_w9`, `is_ic`, `status`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 1, 0, 'Super Admin', NULL, 'admin@gmail.com', '', NULL, 0, NULL, '12345678', 0, NULL, NULL, 'male', '1990-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$ORxXRnJcDdvcoWDO8FM1cunj0Kd34hF5NS4nxQaXWyDTDDwBpKzp.', NULL, '2026-01-18 05:14:40', '2026-01-18 05:14:40', NULL),
(2, NULL, 2, 0, 'Admin 1', NULL, 'admin1@gmail.com', '', NULL, 0, NULL, '12345672', 0, NULL, NULL, 'male', '1994-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$HDYjwQ7aLyubucZ/z86T0eCxK1eVHQzXqJ9MCbIdbQdcKAqAD0/W2', NULL, '2026-01-18 05:14:40', '2026-01-18 05:14:40', NULL),
(3, NULL, 3, 0, 'Recruiter 1', NULL, 'recruiter1@gmail.com', '', NULL, 0, NULL, '123456724', 0, NULL, NULL, 'male', '1996-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$5fsGDxdarzwA6p6RkmRe5eEDlx3wobwMbqbZkKEwLHqr2NFQEBoyG', NULL, '2026-01-18 05:14:40', '2026-01-18 05:14:40', NULL),
(4, NULL, 4, 0, 'Accounter 1', NULL, 'accounter1@gmail.com', '', NULL, 0, NULL, '123456724', 0, NULL, NULL, 'male', '1996-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$vKbA.tcFuEFJPXehDzyyIuE0lbTcCPWag214P0z5SDNKEJ/syMnS.', NULL, '2026-01-18 05:14:40', '2026-01-18 05:14:40', NULL),
(5, NULL, 5, 0, 'User 1', NULL, 'user1@gmail.com', '', NULL, 0, NULL, '123456724', 0, NULL, NULL, 'male', '1996-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$15KYPUKrmzp9k3x5j3nA.O34Pcp9oHAINIyRAgqUqQD4YjFp5iAfC', NULL, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(6, NULL, 5, 0, 'User 2', NULL, 'user2@gmail.com', '', NULL, 0, NULL, '123456702', 0, NULL, NULL, 'male', '1996-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$Kzao1uE9cF1SfsmPFCd9mebUXLHwRb/HAlIgO7j5wdKyxl/Q2w5mK', NULL, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(7, NULL, 5, 0, 'User 3', NULL, 'user3@gmail.com', '', NULL, 0, NULL, '123456703', 0, NULL, NULL, 'male', '1996-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '$2y$12$OazP.oYhN3DMizHN7lFYruoqpgfHQ.p34cYta3tCq1PEMYYy2kmwi', NULL, '2026-01-18 05:14:41', '2026-01-18 05:14:41', NULL),
(8, NULL, 5, 0, 'Khadim', NULL, '123Khadimhussain786@gmail.com', '', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[\"10\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '$2y$12$ORxXRnJcDdvcoWDO8FM1cunj0Kd34hF5NS4nxQaXWyDTDDwBpKzp.', NULL, '2026-01-18 05:16:03', '2026-01-21 13:45:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_trainings`
--

CREATE TABLE `users_trainings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `training_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_trainings`
--

INSERT INTO `users_trainings` (`id`, `user_id`, `training_id`, `status`, `due_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 1, 'pending', '2026-01-18', '2026-01-18 05:22:17', '2026-01-18 05:52:05', '2026-01-18 05:52:05'),
(2, 8, 1, 'pending', '2026-01-18', '2026-01-18 05:52:05', '2026-01-18 05:52:19', '2026-01-18 05:52:19'),
(3, 8, 1, 'pending', '2026-01-18', '2026-01-18 05:52:19', '2026-01-19 12:40:23', '2026-01-19 12:40:23'),
(4, 8, 1, 'pending', '2026-01-18', '2026-01-19 12:40:23', '2026-01-19 12:40:23', NULL),
(5, 8, 4, 'pending', '2026-01-19', '2026-01-19 13:19:17', '2026-01-21 13:47:10', '2026-01-21 13:47:10'),
(6, 8, 4, 'pending', '2026-01-19', '2026-01-21 13:47:10', '2026-01-21 13:48:25', '2026-01-21 13:48:25'),
(7, 8, 4, 'pending', '2026-01-19', '2026-01-21 13:48:25', '2026-01-21 13:48:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_flat_rate_history`
--

CREATE TABLE `user_flat_rate_history` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `flat_rate` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_job_history`
--

CREATE TABLE `user_payment_job_history` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `work_history_id` int DEFAULT NULL,
  `flat_rate` tinyint NOT NULL DEFAULT '0',
  `is_payable` tinyint NOT NULL DEFAULT '0',
  `is_paid` int NOT NULL,
  `date` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payment_job_history`
--

INSERT INTO `user_payment_job_history` (`id`, `user_id`, `job_id`, `work_history_id`, `flat_rate`, `is_payable`, `is_paid`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 8, 11, 2, 10, 1, 1, 2026, '2026-01-21 13:50:36', '2026-01-22 12:10:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_quizzes`
--

CREATE TABLE `user_quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `submit_date` timestamp NULL DEFAULT NULL,
  `shift_date` timestamp NULL DEFAULT NULL,
  `total_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_answers` text COLLATE utf8mb4_unicode_ci,
  `attempted_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `right_answers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrong_answers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_quizzes`
--

INSERT INTO `user_quizzes` (`id`, `quiz_id`, `user_id`, `submit_date`, `shift_date`, `total_questions`, `percentage`, `all_answers`, `attempted_questions`, `right_answers`, `wrong_answers`, `feedback`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-18 05:22:17', '2026-01-18 05:52:05', '2026-01-18 05:52:05'),
(2, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-18 05:52:05', '2026-01-18 05:52:19', '2026-01-18 05:52:19'),
(4, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-18 05:52:19', '2026-01-19 12:40:23', '2026-01-19 12:40:23'),
(5, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-19 12:40:23', '2026-01-19 12:40:23', NULL),
(6, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-19 13:19:17', '2026-01-21 13:47:10', '2026-01-21 13:47:10'),
(7, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-21 13:47:10', '2026-01-21 13:48:25', '2026-01-21 13:48:25'),
(8, 4, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', '2026-01-21 13:48:25', '2026-01-21 13:48:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz_reattempt`
--

CREATE TABLE `user_quiz_reattempt` (
  `id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_quiz_id` bigint UNSIGNED NOT NULL,
  `submit_date` timestamp NULL DEFAULT NULL,
  `shift_date` timestamp NULL DEFAULT NULL,
  `total_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `all_answers` text COLLATE utf8mb4_unicode_ci,
  `attempted_questions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `right_answers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrong_answers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_recaps`
--

CREATE TABLE `user_recaps` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shift_id` int NOT NULL,
  `recap_id` bigint UNSIGNED NOT NULL,
  `submit_date` timestamp NULL DEFAULT NULL,
  `shift_date` timestamp NULL DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recap_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_recaps`
--

INSERT INTO `user_recaps` (`id`, `user_id`, `shift_id`, `recap_id`, `submit_date`, `shift_date`, `feedback`, `rating`, `status`, `recap_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-18 05:22:17', '2026-01-18 05:52:05', '2026-01-18 05:52:05'),
(3, 8, 0, 1, '2026-01-23 10:57:16', NULL, NULL, NULL, 'submitted', NULL, '2026-01-18 05:52:05', '2026-01-23 10:57:16', NULL),
(4, 8, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-18 05:52:19', '2026-01-18 05:52:19', NULL),
(5, 8, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-19 12:40:23', '2026-01-19 12:40:23', NULL),
(6, 8, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-19 13:19:17', '2026-01-21 13:47:10', '2026-01-21 13:47:10'),
(7, 8, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-21 13:47:10', '2026-01-21 13:47:10', NULL),
(8, 8, 11, 4, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-21 13:48:25', '2026-01-21 13:48:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_recap_questions`
--

CREATE TABLE `user_recap_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `recap_question_id` bigint DEFAULT NULL,
  `user_recap_id` bigint UNSIGNED NOT NULL,
  `recap_question_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recap_question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `recap_question_options` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recap_question_answer` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_recap_questions`
--

INSERT INTO `user_recap_questions` (`id`, `recap_question_id`, `user_recap_id`, `recap_question_type`, `recap_question`, `answer`, `recap_question_options`, `recap_question_answer`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'radio-question', 'asdf', NULL, 'asdf', NULL, '2026-01-18 05:22:17', '2026-01-18 05:22:17'),
(2, NULL, 3, 'radio-question', 'asdf', NULL, 'asdf', 'asdf', '2026-01-18 05:52:05', '2026-01-23 10:57:16'),
(3, NULL, 4, 'radio-question', 'asdf', NULL, 'asdf', NULL, '2026-01-18 05:52:19', '2026-01-18 05:52:19'),
(15, NULL, 5, 'radio-question', 'asdf', NULL, 'asdf', NULL, '2026-01-19 12:40:23', '2026-01-19 12:40:23'),
(16, NULL, 6, 'radio-question', 'asfdasfas', NULL, 'asfdas', NULL, '2026-01-19 13:19:17', '2026-01-19 13:19:17'),
(17, NULL, 7, 'radio-question', 'asfdasfas', NULL, 'asfdas', NULL, '2026-01-21 13:47:10', '2026-01-21 13:47:10'),
(18, NULL, 8, 'radio-question', 'asfdasfas', NULL, 'asfdas', NULL, '2026-01-21 13:48:25', '2026-01-21 13:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `w9forms`
--

CREATE TABLE `w9forms` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `federal_tax_classification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exempt_payee_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fatca_reporting_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_state_zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requester_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_security_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer_identification_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `digital_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `w9forms`
--

INSERT INTO `w9forms` (`id`, `user_id`, `name`, `business_name`, `federal_tax_classification`, `exempt_payee_code`, `fatca_reporting_code`, `address`, `city_state_zipcode`, `account_number`, `requester_name`, `social_security_number`, `employer_identification_number`, `date`, `digital_signature`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Alex', 'Business 1', NULL, NULL, NULL, 'Address 1', NULL, NULL, NULL, NULL, NULL, '2026-01-18 10:14:42', NULL, 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(2, 6, 'John', 'Business 2', NULL, NULL, NULL, 'Address 2', NULL, NULL, NULL, NULL, NULL, '2026-01-18 10:14:42', NULL, 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(3, 7, 'Saim', 'Business 3', NULL, NULL, NULL, 'Address 3', NULL, NULL, NULL, NULL, NULL, '2026-01-18 10:14:42', NULL, 1, '2026-01-18 05:14:42', '2026-01-18 05:14:42', NULL),
(4, 8, 'Trading', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-18', '1', 1, '2026-01-18 08:14:00', '2026-01-18 08:14:00', NULL),
(5, 1, 'Trading', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-18', '1', 1, '2026-01-18 08:25:55', '2026-01-18 08:25:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_history`
--

CREATE TABLE `work_history` (
  `id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `job_id` bigint UNSIGNED NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_hours` int NOT NULL,
  `user_working_hour` time NOT NULL,
  `falt_rate` tinyint NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `lat` int NOT NULL,
  `lon` int NOT NULL,
  `is_active_shift` tinyint NOT NULL,
  `is_confirm` tinyint NOT NULL,
  `is_complete` tinyint NOT NULL,
  `mileage` double(6,2) NOT NULL DEFAULT '0.00',
  `sale_incentive` double(6,2) NOT NULL DEFAULT '0.00',
  `out_of_pocket_expense` double(6,2) NOT NULL DEFAULT '0.00',
  `deduction` double(6,2) NOT NULL DEFAULT '0.00',
  `total_paid` double(6,2) NOT NULL DEFAULT '0.00',
  `total_due` double(6,2) NOT NULL DEFAULT '0.00',
  `grand_total` double(6,2) NOT NULL DEFAULT '0.00',
  `is_allownce_save` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_history`
--

INSERT INTO `work_history` (`id`, `status`, `user_id`, `job_id`, `date`, `image`, `shift_hours`, `user_working_hour`, `falt_rate`, `check_in`, `check_out`, `lat`, `lon`, `is_active_shift`, `is_confirm`, `is_complete`, `mileage`, `sale_incentive`, `out_of_pocket_expense`, `deduction`, `total_paid`, `total_due`, `grand_total`, `is_allownce_save`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '1', 8, 11, '2026-01-21 13:48:54', '', 23, '00:00:25', 10, '18:48:54', '18:49:19', 0, 0, 0, 1, 1, 0.00, 10.00, 0.00, 0.00, 20.00, 0.00, 0.00, 1, '2026-01-21 13:48:54', '2026-01-22 12:10:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_title_unique` (`title`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`),
  ADD KEY `brands_user_id_foreign` (`user_id`);

--
-- Indexes for table `bulk_invite_user`
--
ALTER TABLE `bulk_invite_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crons_track`
--
ALTER TABLE `crons_track`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_rates`
--
ALTER TABLE `default_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flat_rate_deduction`
--
ALTER TABLE `flat_rate_deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ict_form`
--
ALTER TABLE `ict_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ict_form_user_id_foreign` (`user_id`);

--
-- Indexes for table `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `infos_user_id_foreign` (`user_id`),
  ADD KEY `infos_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `info_files`
--
ALTER TABLE `info_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invites`
--
ALTER TABLE `invites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invites_invited_by_foreign` (`invited_by`),
  ADD KEY `invites_role_id_foreign` (`role_id`);

--
-- Indexes for table `jobs_c`
--
ALTER TABLE `jobs_c`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_c_user_id_foreign` (`user_id`);

--
-- Indexes for table `job_coverage_offers`
--
ALTER TABLE `job_coverage_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_coverage_requests`
--
ALTER TABLE `job_coverage_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_members`
--
ALTER TABLE `job_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_members_work_history`
--
ALTER TABLE `job_members_work_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead_users`
--
ALTER TABLE `lead_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_user_id_foreign` (`user_id`),
  ADD KEY `quizzes_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `quiz_question_options`
--
ALTER TABLE `quiz_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_question_options_quiz_question_id_foreign` (`quiz_question_id`);

--
-- Indexes for table `recaps`
--
ALTER TABLE `recaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recaps_user_id_foreign` (`user_id`),
  ADD KEY `recaps_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `recap_questions`
--
ALTER TABLE `recap_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recap_questions_recap_id_foreign` (`recap_id`);

--
-- Indexes for table `recap_question_options`
--
ALTER TABLE `recap_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recap_question_options_recap_question_id_foreign` (`recap_question_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_unique` (`role`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainings_user_id_foreign` (`user_id`),
  ADD KEY `trainings_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `training_files`
--
ALTER TABLE `training_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_country_id_foreign` (`country_id`);

--
-- Indexes for table `users_trainings`
--
ALTER TABLE `users_trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_trainings_user_id_foreign` (`user_id`),
  ADD KEY `users_trainings_training_id_foreign` (`training_id`);

--
-- Indexes for table `user_flat_rate_history`
--
ALTER TABLE `user_flat_rate_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_payment_job_history`
--
ALTER TABLE `user_payment_job_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quizzes_quiz_id_foreign` (`quiz_id`),
  ADD KEY `user_quizzes_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_quiz_reattempt`
--
ALTER TABLE `user_quiz_reattempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quiz_reattempt_quiz_id_foreign` (`quiz_id`),
  ADD KEY `user_quiz_reattempt_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_recaps`
--
ALTER TABLE `user_recaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_recaps_user_id_foreign` (`user_id`),
  ADD KEY `user_recaps_recap_id_foreign` (`recap_id`);

--
-- Indexes for table `user_recap_questions`
--
ALTER TABLE `user_recap_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_recap_questions_user_recap_id_foreign` (`user_recap_id`);

--
-- Indexes for table `w9forms`
--
ALTER TABLE `w9forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `w9forms_user_id_foreign` (`user_id`);

--
-- Indexes for table `work_history`
--
ALTER TABLE `work_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bulk_invite_user`
--
ALTER TABLE `bulk_invite_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `crons_track`
--
ALTER TABLE `crons_track`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `default_rates`
--
ALTER TABLE `default_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flat_rate_deduction`
--
ALTER TABLE `flat_rate_deduction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ict_form`
--
ALTER TABLE `ict_form`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infos`
--
ALTER TABLE `infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `info_files`
--
ALTER TABLE `info_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invites`
--
ALTER TABLE `invites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs_c`
--
ALTER TABLE `jobs_c`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_coverage_offers`
--
ALTER TABLE `job_coverage_offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_coverage_requests`
--
ALTER TABLE `job_coverage_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_members`
--
ALTER TABLE `job_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_members_work_history`
--
ALTER TABLE `job_members_work_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_users`
--
ALTER TABLE `lead_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_question_options`
--
ALTER TABLE `quiz_question_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `recaps`
--
ALTER TABLE `recaps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `recap_questions`
--
ALTER TABLE `recap_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `recap_question_options`
--
ALTER TABLE `recap_question_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_files`
--
ALTER TABLE `training_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_trainings`
--
ALTER TABLE `users_trainings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_flat_rate_history`
--
ALTER TABLE `user_flat_rate_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_payment_job_history`
--
ALTER TABLE `user_payment_job_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_quiz_reattempt`
--
ALTER TABLE `user_quiz_reattempt`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_recaps`
--
ALTER TABLE `user_recaps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_recap_questions`
--
ALTER TABLE `user_recap_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `w9forms`
--
ALTER TABLE `w9forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `work_history`
--
ALTER TABLE `work_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ict_form`
--
ALTER TABLE `ict_form`
  ADD CONSTRAINT `ict_form_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `infos`
--
ALTER TABLE `infos`
  ADD CONSTRAINT `infos_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invites`
--
ALTER TABLE `invites`
  ADD CONSTRAINT `invites_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invites_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs_c`
--
ALTER TABLE `jobs_c`
  ADD CONSTRAINT `jobs_c_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_question_options`
--
ALTER TABLE `quiz_question_options`
  ADD CONSTRAINT `quiz_question_options_quiz_question_id_foreign` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recaps`
--
ALTER TABLE `recaps`
  ADD CONSTRAINT `recaps_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recaps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recap_questions`
--
ALTER TABLE `recap_questions`
  ADD CONSTRAINT `recap_questions_recap_id_foreign` FOREIGN KEY (`recap_id`) REFERENCES `recaps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recap_question_options`
--
ALTER TABLE `recap_question_options`
  ADD CONSTRAINT `recap_question_options_recap_question_id_foreign` FOREIGN KEY (`recap_question_id`) REFERENCES `recap_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trainings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_trainings`
--
ALTER TABLE `users_trainings`
  ADD CONSTRAINT `users_trainings_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `trainings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_trainings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  ADD CONSTRAINT `user_quizzes_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quizzes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_quiz_reattempt`
--
ALTER TABLE `user_quiz_reattempt`
  ADD CONSTRAINT `user_quiz_reattempt_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quiz_reattempt_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_recaps`
--
ALTER TABLE `user_recaps`
  ADD CONSTRAINT `user_recaps_recap_id_foreign` FOREIGN KEY (`recap_id`) REFERENCES `recaps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_recaps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_recap_questions`
--
ALTER TABLE `user_recap_questions`
  ADD CONSTRAINT `user_recap_questions_user_recap_id_foreign` FOREIGN KEY (`user_recap_id`) REFERENCES `user_recaps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `w9forms`
--
ALTER TABLE `w9forms`
  ADD CONSTRAINT `w9forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
