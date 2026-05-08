-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_sispak
CREATE DATABASE IF NOT EXISTS `db_sispak` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_sispak`;

-- Dumping structure for table db_sispak.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.cache: ~0 rows (approximately)

-- Dumping structure for table db_sispak.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.cache_locks: ~0 rows (approximately)

-- Dumping structure for table db_sispak.ds_diagnosis
CREATE TABLE IF NOT EXISTS `ds_diagnosis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `penyakit_id` bigint unsigned DEFAULT NULL,
  `belief_top` decimal(5,4) DEFAULT NULL,
  `severity_label` enum('Tidak','Ringan','Sedang','Berat') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conflict_k` decimal(6,5) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ds_diagnosis_user_id_index` (`user_id`),
  KEY `ds_diagnosis_penyakit_id_index` (`penyakit_id`),
  KEY `ds_diagnosis_created_at_index` (`created_at`),
  CONSTRAINT `ds_diagnosis_penyakit_id_foreign` FOREIGN KEY (`penyakit_id`) REFERENCES `tblpenyakit` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ds_diagnosis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tblakun` (`id_akun`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.ds_diagnosis: ~27 rows (approximately)
INSERT INTO `ds_diagnosis` (`id`, `user_id`, `penyakit_id`, `belief_top`, `severity_label`, `conflict_k`, `note`, `created_at`, `updated_at`) VALUES
	(24, NULL, 1, 0.7842, NULL, 0.36618, NULL, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(25, 2, 1, 0.7842, NULL, 0.36618, NULL, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(26, 2, 1, 0.6639, NULL, 0.22544, NULL, '2025-11-22 00:15:15', '2025-11-22 00:15:15'),
	(27, 2, 2, 0.9230, NULL, 0.13794, NULL, '2025-11-22 00:16:18', '2025-11-22 00:16:18'),
	(28, 2, 2, 0.5265, NULL, 0.38229, NULL, '2025-11-22 00:18:00', '2025-11-22 00:18:00'),
	(29, 2, 3, 0.9868, NULL, 0.02009, NULL, '2025-11-22 00:19:28', '2025-11-22 00:19:28'),
	(30, 2, 3, 0.9597, NULL, 0.06490, NULL, '2025-11-22 00:20:39', '2025-11-22 00:20:39'),
	(31, 2, 2, 0.6986, NULL, 0.27149, NULL, '2025-11-22 00:21:41', '2025-11-22 00:21:41'),
	(32, 2, 1, 0.3299, NULL, 0.17849, NULL, '2025-11-22 00:22:40', '2025-11-22 00:22:40'),
	(33, 2, 2, 0.5041, NULL, 0.27399, NULL, '2025-11-22 00:23:51', '2025-11-22 00:23:51'),
	(34, 2, 3, 0.6901, NULL, 0.43927, NULL, '2025-11-22 00:24:59', '2025-11-22 00:24:59'),
	(35, 2, 1, 0.5065, NULL, 0.47013, NULL, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(36, 2, 3, 0.1835, NULL, 0.03265, NULL, '2025-11-26 02:19:49', '2025-11-26 02:19:49'),
	(37, 2, 1, 0.2023, NULL, 0.04845, NULL, '2025-12-03 06:44:38', '2025-12-03 06:44:38'),
	(38, 2, 3, 0.3170, NULL, 0.15306, NULL, '2025-12-03 21:05:07', '2025-12-03 21:05:07'),
	(39, 2, 1, 0.3189, NULL, 0.20903, NULL, '2025-12-12 00:18:57', '2025-12-12 00:18:57'),
	(40, 4, 1, 0.3665, NULL, 0.18783, NULL, '2025-12-16 07:23:26', '2025-12-16 07:23:26'),
	(41, 2, 2, 0.9230, NULL, 0.13794, NULL, '2026-01-05 08:50:22', '2026-01-05 08:50:22'),
	(42, 5, 1, 0.4071, NULL, 0.31150, NULL, '2026-01-05 08:56:09', '2026-01-05 08:56:09'),
	(43, 6, 3, 0.6143, NULL, 0.58204, NULL, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(45, 4, 1, 0.1840, NULL, 0.05714, NULL, '2026-01-06 05:27:58', '2026-01-06 05:27:58'),
	(46, 4, 1, 0.3299, NULL, 0.17849, NULL, '2026-01-06 05:56:59', '2026-01-06 05:56:59'),
	(47, 4, 1, 0.4071, NULL, 0.31150, NULL, '2026-01-06 06:46:42', '2026-01-06 06:46:42'),
	(48, 4, 1, 0.4071, NULL, 0.31150, NULL, '2026-01-06 20:32:55', '2026-01-06 20:32:55'),
	(49, 4, 1, 0.4071, NULL, 0.31150, NULL, '2026-01-06 22:10:19', '2026-01-06 22:10:19'),
	(50, 4, 1, 0.3552, NULL, 0.29482, NULL, '2026-01-06 22:26:40', '2026-01-06 22:26:40'),
	(51, 4, 3, 0.5223, NULL, 0.63129, NULL, '2026-01-06 22:28:01', '2026-01-06 22:28:01');

-- Dumping structure for table db_sispak.ds_diagnosis_details
CREATE TABLE IF NOT EXISTS `ds_diagnosis_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ds_diagnosis_id` bigint unsigned NOT NULL,
  `gejala_id` bigint unsigned DEFAULT NULL,
  `kemunculan_fuzzy_parameter_id` bigint unsigned NOT NULL,
  `fuzzy_densitas` decimal(5,4) DEFAULT NULL,
  `mass_used_support` decimal(4,3) DEFAULT NULL,
  `mass_used_ignorance` decimal(4,3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ds_diagnosis_details_ds_diagnosis_id_index` (`ds_diagnosis_id`),
  KEY `ds_diagnosis_details_gejala_id_index` (`gejala_id`),
  KEY `idx_dd_kemunculan_fp_id` (`kemunculan_fuzzy_parameter_id`),
  CONSTRAINT `ds_diagnosis_details_ds_diagnosis_id_foreign` FOREIGN KEY (`ds_diagnosis_id`) REFERENCES `ds_diagnosis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ds_diagnosis_details_gejala_id_foreign` FOREIGN KEY (`gejala_id`) REFERENCES `tblgejala` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_dd_kemunculan_fp` FOREIGN KEY (`kemunculan_fuzzy_parameter_id`) REFERENCES `fuzzy_parameters` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.ds_diagnosis_details: ~117 rows (approximately)
INSERT INTO `ds_diagnosis_details` (`id`, `ds_diagnosis_id`, `gejala_id`, `kemunculan_fuzzy_parameter_id`, `fuzzy_densitas`, `mass_used_support`, `mass_used_ignorance`, `created_at`, `updated_at`) VALUES
	(1, 24, 1, 2, 0.4000, 0.400, 0.600, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(2, 24, 2, 3, 0.7043, 0.704, 0.296, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(3, 24, 3, 3, 0.7857, 0.786, 0.214, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(4, 24, 4, 3, 0.7786, 0.779, 0.221, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(5, 24, 9, 3, 0.7200, 0.720, 0.280, '2025-11-21 22:33:35', '2025-11-21 22:33:35'),
	(6, 25, 1, 2, 0.4000, 0.400, 0.600, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(7, 25, 2, 3, 0.7043, 0.704, 0.296, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(8, 25, 3, 3, 0.7857, 0.786, 0.214, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(9, 25, 4, 3, 0.7786, 0.779, 0.221, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(10, 25, 9, 3, 0.7200, 0.720, 0.280, '2025-11-22 00:13:23', '2025-11-22 00:13:23'),
	(11, 26, 2, 3, 0.7043, 0.704, 0.296, '2025-11-22 00:15:15', '2025-11-22 00:15:15'),
	(12, 26, 3, 3, 0.7857, 0.786, 0.214, '2025-11-22 00:15:15', '2025-11-22 00:15:15'),
	(13, 26, 5, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:15:15', '2025-11-22 00:15:15'),
	(14, 26, 7, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:15:15', '2025-11-22 00:15:15'),
	(15, 27, 13, 3, 0.7786, 0.779, 0.221, '2025-11-22 00:16:18', '2025-11-22 00:16:18'),
	(16, 27, 14, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:16:18', '2025-11-22 00:16:18'),
	(17, 27, 15, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:16:18', '2025-11-22 00:16:18'),
	(18, 28, 3, 3, 0.7857, 0.786, 0.214, '2025-11-22 00:18:00', '2025-11-22 00:18:00'),
	(19, 28, 5, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:18:00', '2025-11-22 00:18:00'),
	(20, 28, 13, 3, 0.7786, 0.779, 0.221, '2025-11-22 00:18:00', '2025-11-22 00:18:00'),
	(21, 29, 2, 2, 0.5226, 0.523, 0.477, '2025-11-22 00:19:28', '2025-11-22 00:19:28'),
	(22, 29, 16, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:19:28', '2025-11-22 00:19:28'),
	(23, 29, 17, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:19:28', '2025-11-22 00:19:28'),
	(24, 29, 18, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:19:28', '2025-11-22 00:19:28'),
	(25, 30, 6, 2, 0.4222, 0.422, 0.578, '2025-11-22 00:20:39', '2025-11-22 00:20:39'),
	(26, 30, 8, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:20:39', '2025-11-22 00:20:39'),
	(27, 30, 16, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:20:39', '2025-11-22 00:20:39'),
	(28, 30, 17, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:20:39', '2025-11-22 00:20:39'),
	(29, 31, 3, 3, 0.7857, 0.786, 0.214, '2025-11-22 00:21:41', '2025-11-22 00:21:41'),
	(30, 31, 13, 2, 0.5889, 0.589, 0.411, '2025-11-22 00:21:41', '2025-11-22 00:21:41'),
	(31, 31, 15, 2, 0.6125, 0.613, 0.388, '2025-11-22 00:21:41', '2025-11-22 00:21:41'),
	(32, 32, 1, 2, 0.4000, 0.400, 0.600, '2025-11-22 00:22:40', '2025-11-22 00:22:40'),
	(33, 32, 2, 2, 0.5226, 0.523, 0.477, '2025-11-22 00:22:40', '2025-11-22 00:22:40'),
	(34, 32, 6, 2, 0.4222, 0.422, 0.578, '2025-11-22 00:22:40', '2025-11-22 00:22:40'),
	(35, 33, 2, 1, 0.3391, 0.339, 0.661, '2025-11-22 00:23:51', '2025-11-22 00:23:51'),
	(36, 33, 3, 3, 0.7857, 0.786, 0.214, '2025-11-22 00:23:51', '2025-11-22 00:23:51'),
	(37, 33, 14, 2, 0.5000, 0.500, 0.500, '2025-11-22 00:23:51', '2025-11-22 00:23:51'),
	(38, 34, 2, 2, 0.5226, 0.523, 0.477, '2025-11-22 00:24:59', '2025-11-22 00:24:59'),
	(39, 34, 3, 2, 0.6000, 0.600, 0.400, '2025-11-22 00:24:59', '2025-11-22 00:24:59'),
	(40, 34, 16, 3, 0.7833, 0.783, 0.217, '2025-11-22 00:24:59', '2025-11-22 00:24:59'),
	(41, 35, 1, 3, 0.6000, 0.600, 0.400, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(42, 35, 2, 3, 0.7043, 0.704, 0.296, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(43, 35, 3, 3, 0.7857, 0.786, 0.214, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(44, 35, 4, 2, 0.5889, 0.589, 0.411, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(45, 35, 5, 2, 0.5000, 0.500, 0.500, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(46, 35, 12, 2, 0.4000, 0.400, 0.600, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(47, 35, 15, 2, 0.6125, 0.000, 0.000, '2025-11-23 19:55:40', '2025-11-23 19:55:40'),
	(48, 36, 1, 1, 0.2143, 0.214, 0.786, '2025-11-26 02:19:49', '2025-11-26 02:19:49'),
	(49, 36, 6, 1, 0.2286, 0.229, 0.771, '2025-11-26 02:19:49', '2025-11-26 02:19:49'),
	(50, 37, 1, 1, 0.2143, 0.214, 0.786, '2025-12-03 06:44:38', '2025-12-03 06:44:38'),
	(51, 37, 2, 1, 0.3391, 0.339, 0.661, '2025-12-03 06:44:38', '2025-12-03 06:44:38'),
	(52, 38, 1, 2, 0.4000, 0.400, 0.600, '2025-12-03 21:05:07', '2025-12-03 21:05:07'),
	(53, 38, 2, 1, 0.3391, 0.339, 0.661, '2025-12-03 21:05:07', '2025-12-03 21:05:07'),
	(54, 38, 6, 2, 0.4222, 0.422, 0.578, '2025-12-03 21:05:07', '2025-12-03 21:05:07'),
	(55, 39, 1, 3, 0.6000, 0.600, 0.400, '2025-12-12 00:18:57', '2025-12-12 00:18:57'),
	(56, 39, 2, 2, 0.5226, 0.523, 0.477, '2025-12-12 00:18:57', '2025-12-12 00:18:57'),
	(57, 40, 1, 2, 0.4000, 0.400, 0.600, '2025-12-16 07:23:26', '2025-12-16 07:23:26'),
	(58, 40, 2, 3, 0.7043, 0.704, 0.296, '2025-12-16 07:23:26', '2025-12-16 07:23:26'),
	(59, 41, 13, 3, 0.7786, 0.779, 0.221, '2026-01-05 08:50:22', '2026-01-05 08:50:22'),
	(60, 41, 14, 2, 0.5000, 0.500, 0.500, '2026-01-05 08:50:22', '2026-01-05 08:50:22'),
	(61, 41, 15, 3, 0.7833, 0.783, 0.217, '2026-01-05 08:50:22', '2026-01-05 08:50:22'),
	(62, 42, 1, 2, 0.4000, 0.400, 0.600, '2026-01-05 08:56:09', '2026-01-05 08:56:09'),
	(63, 42, 2, 3, 0.7043, 0.704, 0.296, '2026-01-05 08:56:09', '2026-01-05 08:56:09'),
	(64, 42, 3, 2, 0.6000, 0.600, 0.400, '2026-01-05 08:56:09', '2026-01-05 08:56:09'),
	(65, 43, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(66, 43, 2, 3, 0.7043, 0.704, 0.296, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(67, 43, 3, 2, 0.6000, 0.600, 0.400, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(68, 43, 4, 1, 0.3857, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(69, 43, 5, 3, 0.6750, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(70, 43, 6, 1, 0.2286, 0.229, 0.771, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(71, 43, 7, 2, 0.5000, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(72, 43, 8, 3, 0.6750, 0.675, 0.325, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(73, 43, 9, 1, 0.3467, 0.347, 0.653, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(74, 43, 10, 3, 0.6286, 0.629, 0.371, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(75, 43, 11, 3, 0.6750, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(76, 43, 12, 2, 0.4000, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(77, 43, 13, 3, 0.7786, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(78, 43, 14, 2, 0.5000, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(79, 43, 15, 3, 0.7833, 0.000, 0.000, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(80, 43, 16, 3, 0.7833, 0.783, 0.217, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(81, 43, 17, 3, 0.7833, 0.783, 0.217, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(82, 43, 18, 3, 0.7833, 0.783, 0.217, '2026-01-06 03:02:52', '2026-01-06 03:02:52'),
	(85, 45, 1, 1, 0.2143, 0.214, 0.786, '2026-01-06 05:27:58', '2026-01-06 05:27:58'),
	(86, 45, 3, 1, 0.4000, 0.400, 0.600, '2026-01-06 05:27:58', '2026-01-06 05:27:58'),
	(87, 46, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 05:56:59', '2026-01-06 05:56:59'),
	(88, 46, 2, 2, 0.5226, 0.523, 0.477, '2026-01-06 05:56:59', '2026-01-06 05:56:59'),
	(89, 46, 6, 2, 0.4222, 0.422, 0.578, '2026-01-06 05:56:59', '2026-01-06 05:56:59'),
	(90, 47, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 06:46:42', '2026-01-06 06:46:42'),
	(91, 47, 2, 3, 0.7043, 0.704, 0.296, '2026-01-06 06:46:42', '2026-01-06 06:46:42'),
	(92, 47, 3, 2, 0.6000, 0.600, 0.400, '2026-01-06 06:46:42', '2026-01-06 06:46:42'),
	(93, 48, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 20:32:55', '2026-01-06 20:32:55'),
	(94, 48, 2, 3, 0.7043, 0.704, 0.296, '2026-01-06 20:32:55', '2026-01-06 20:32:55'),
	(95, 48, 3, 2, 0.6000, 0.600, 0.400, '2026-01-06 20:32:55', '2026-01-06 20:32:55'),
	(96, 49, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 22:10:19', '2026-01-06 22:10:19'),
	(97, 49, 2, 3, 0.7043, 0.704, 0.296, '2026-01-06 22:10:19', '2026-01-06 22:10:19'),
	(98, 49, 3, 2, 0.6000, 0.600, 0.400, '2026-01-06 22:10:19', '2026-01-06 22:10:19'),
	(99, 50, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 22:26:40', '2026-01-06 22:26:40'),
	(100, 50, 2, 1, 0.3391, 0.339, 0.661, '2026-01-06 22:26:40', '2026-01-06 22:26:40'),
	(101, 50, 3, 3, 0.7857, 0.786, 0.214, '2026-01-06 22:26:40', '2026-01-06 22:26:40'),
	(102, 51, 1, 2, 0.4000, 0.400, 0.600, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(103, 51, 2, 1, 0.3391, 0.339, 0.661, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(104, 51, 3, 2, 0.6000, 0.600, 0.400, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(105, 51, 4, 2, 0.5889, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(106, 51, 5, 2, 0.5000, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(107, 51, 6, 1, 0.2286, 0.229, 0.771, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(108, 51, 7, 3, 0.6750, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(109, 51, 8, 1, 0.3250, 0.325, 0.675, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(110, 51, 9, 1, 0.3467, 0.347, 0.653, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(111, 51, 10, 2, 0.4222, 0.422, 0.578, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(112, 51, 11, 2, 0.5000, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(113, 51, 12, 1, 0.2143, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(114, 51, 13, 1, 0.3857, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(115, 51, 14, 2, 0.5000, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(116, 51, 15, 1, 0.4333, 0.000, 0.000, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(117, 51, 16, 2, 0.6125, 0.613, 0.388, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(118, 51, 17, 2, 0.6125, 0.613, 0.388, '2026-01-06 22:28:01', '2026-01-06 22:28:01'),
	(119, 51, 18, 3, 0.7833, 0.783, 0.217, '2026-01-06 22:28:01', '2026-01-06 22:28:01');

-- Dumping structure for table db_sispak.ds_rules
CREATE TABLE IF NOT EXISTS `ds_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penyakit_id` bigint unsigned NOT NULL,
  `gejala_id` bigint unsigned NOT NULL,
  `fuzzy_parameter_id` bigint unsigned NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ds_rules_penyakit_id_gejala_id_unique` (`penyakit_id`,`gejala_id`),
  KEY `ds_rules_penyakit_id_index` (`penyakit_id`),
  KEY `ds_rules_gejala_id_index` (`gejala_id`),
  KEY `idx_ds_rules_fuzzy_parameter_id` (`fuzzy_parameter_id`),
  CONSTRAINT `ds_rules_fuzzy_parameter_id_foreign` FOREIGN KEY (`fuzzy_parameter_id`) REFERENCES `fuzzy_parameters` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ds_rules_gejala_id_foreign` FOREIGN KEY (`gejala_id`) REFERENCES `tblgejala` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ds_rules_penyakit_id_foreign` FOREIGN KEY (`penyakit_id`) REFERENCES `tblpenyakit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.ds_rules: ~29 rows (approximately)
INSERT INTO `ds_rules` (`id`, `penyakit_id`, `gejala_id`, `fuzzy_parameter_id`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES
	(30, 1, 3, 6, 'Ruam malar/fotosensitif', 1, '2025-11-21 21:39:55', '2025-11-21 21:40:12'),
	(31, 1, 4, 6, 'Ulser mulut/hidung berulang', 1, '2025-11-21 21:40:32', '2025-11-21 21:40:32'),
	(32, 1, 2, 6, 'Artritis non-erosif simetris', 1, '2025-11-21 21:41:00', '2025-11-21 21:41:00'),
	(33, 1, 9, 6, 'Edema/urin berbusa (nefritis)', 1, '2025-11-21 21:41:40', '2025-11-21 21:41:40'),
	(34, 1, 8, 5, 'Serositis (pleurit/perikarditis)', 1, '2025-11-21 21:42:03', '2025-11-21 21:42:03'),
	(35, 1, 7, 5, 'Fenomena Raynaud', 1, '2025-11-21 21:42:22', '2025-11-21 21:42:22'),
	(36, 1, 5, 5, 'Kerontokan non-skar', 1, '2025-11-21 21:42:42', '2025-11-21 21:42:42'),
	(37, 1, 10, 5, 'Gejala saraf (kejang/nyeri kepala)', 1, '2025-11-21 21:43:01', '2025-11-21 21:43:01'),
	(38, 1, 1, 4, 'Kelelahan berat', 1, '2025-11-21 21:43:27', '2025-11-21 21:43:27'),
	(39, 1, 6, 4, 'Demam non-infeksi', 1, '2025-11-21 21:43:47', '2025-11-21 21:43:47'),
	(40, 1, 13, 5, 'Plak discoid/parut (bisa koeksis)', 1, '2025-11-21 21:44:21', '2025-11-21 21:44:21'),
	(41, 1, 12, 4, 'Turun BB ≥5%', 1, '2025-11-21 21:44:35', '2025-11-21 21:44:35'),
	(42, 2, 13, 6, 'Plak discoid bersisik/menebal', 1, '2025-11-21 21:46:00', '2025-11-21 21:46:00'),
	(43, 2, 15, 6, 'Alopesia sikatrik', 1, '2025-11-21 21:46:16', '2025-11-21 21:46:16'),
	(44, 2, 3, 6, 'Ruam malar/fotosensitif', 1, '2025-11-21 21:46:32', '2025-11-21 21:46:32'),
	(45, 2, 14, 5, 'Gatal pada area ruam/plak', 1, '2025-11-21 21:46:53', '2025-11-21 21:46:53'),
	(46, 2, 5, 5, 'Kerontokan non-skar (pada CLE aktif)', 1, '2025-11-21 21:47:15', '2025-11-21 21:47:15'),
	(47, 2, 2, 4, 'Nyeri/bengkak sendi', 1, '2025-11-21 21:47:36', '2025-11-21 21:47:36'),
	(48, 2, 4, 5, 'Ulser mulut/hidung', 1, '2025-11-21 21:47:52', '2025-11-21 21:47:52'),
	(49, 2, 1, 4, 'Kelelahan Berat', 1, '2025-11-21 21:48:18', '2025-11-21 21:48:18'),
	(50, 3, 16, 6, 'Riwayat obat pemicu', 1, '2025-11-21 21:49:14', '2025-11-21 21:49:14'),
	(51, 3, 17, 6, 'Gejala muncul setelah mulai obat', 1, '2025-11-21 21:49:30', '2025-11-21 21:49:30'),
	(52, 3, 18, 6, 'Gejala membaik saat obat dihentikan', 1, '2025-11-21 21:49:47', '2025-11-21 21:49:47'),
	(53, 3, 2, 5, 'Nyeri/bengkak sendi simetris', 1, '2025-11-21 21:50:01', '2025-11-21 21:50:01'),
	(54, 3, 8, 5, 'Serositis (pleurit/perikarditis)', 1, '2025-11-21 21:50:23', '2025-11-21 21:50:23'),
	(55, 3, 6, 5, 'Demam non-infeksi', 1, '2025-11-21 21:50:43', '2025-11-21 21:50:43'),
	(56, 3, 3, 5, 'Ruam fotosensitif', 1, '2025-11-21 21:50:59', '2025-11-21 21:50:59'),
	(57, 3, 9, 4, 'Nefritis', 1, '2025-11-21 21:51:21', '2025-11-21 21:51:21'),
	(58, 3, 10, 4, 'Keterlibatan saraf', 1, '2025-11-21 21:51:37', '2025-11-21 21:51:37'),
	(59, 3, 1, 4, 'Kelelahan Berat', 1, '2025-11-21 21:52:03', '2025-11-21 21:52:03');

-- Dumping structure for table db_sispak.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_sispak.fuzzy_categories
CREATE TABLE IF NOT EXISTS `fuzzy_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_value` decimal(5,2) NOT NULL,
  `max_value` decimal(5,2) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'secondary',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.fuzzy_categories: ~2 rows (approximately)
INSERT INTO `fuzzy_categories` (`id`, `nama_kategori`, `min_value`, `max_value`, `label`, `color`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Ringan', 0.00, 0.39, 'Ringan', 'info', 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(2, 'Sedang', 0.40, 0.69, 'Sedang', 'warning', 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(3, 'Berat', 0.70, 1.00, 'Berat', 'danger', 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08');

-- Dumping structure for table db_sispak.fuzzy_parameters
CREATE TABLE IF NOT EXISTS `fuzzy_parameters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tipe` enum('kemunculan','keunikan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` decimal(3,2) NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_fuzzy_params_tipe_label` (`tipe`,`label`),
  KEY `fuzzy_parameters_tipe_is_active_index` (`tipe`,`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.fuzzy_parameters: ~6 rows (approximately)
INSERT INTO `fuzzy_parameters` (`id`, `tipe`, `label`, `nilai`, `deskripsi`, `urutan`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'kemunculan', 'Sangat Jarang', 0.20, 'Gejala sangat jarang muncul', 1, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(2, 'kemunculan', 'Kadang-Kadang', 0.50, 'Gejala kadang-kadang muncul', 2, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(3, 'kemunculan', 'Sering', 0.80, 'Gejala sering muncul', 3, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(4, 'keunikan', 'Rendah', 0.30, 'Gejala umum, tidak spesifik untuk penyakit tertentu', 1, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(5, 'keunikan', 'Sedang', 0.50, 'Gejala cukup spesifik untuk beberapa penyakit', 2, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08'),
	(6, 'keunikan', 'Tinggi', 0.80, 'Gejala sangat spesifik dan khas untuk penyakit tertentu', 3, 1, '2025-10-26 00:03:08', '2025-10-26 00:03:08');

-- Dumping structure for table db_sispak.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.jobs: ~0 rows (approximately)

-- Dumping structure for table db_sispak.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.job_batches: ~0 rows (approximately)

-- Dumping structure for table db_sispak.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_01_25_110845_create_tblrole_table', 1),
	(5, '2025_01_25_111227_create_tblakun_table', 1),
	(6, '2025_01_25_111458_create_tblgejala_table', 1),
	(7, '2025_01_25_111948_create_tblpenyakit_table', 1),
	(8, '2025_01_25_112318_create_tblnilaicf_table', 1),
	(9, '2025_01_25_112605_create_tblintervalcf_table', 1),
	(10, '2025_01_25_113112_create_tbldiagnosis_table', 1),
	(11, '2025_01_27_190008_add_penangan_to_tblpenyakit_table', 1),
	(12, '2025_01_27_195251_add_id_akun_to_tbldiagnosis', 1),
	(13, '2025_09_30_084111_alter_tblgejala_for_ds', 1),
	(14, '2025_09_30_084235_create_ds_rules_table', 1),
	(15, '2025_09_30_084313_create_ds_diagnosis_table', 1),
	(16, '2025_09_30_084402_create_ds_diagnosis_details_table', 1),
	(17, '2025_10_04_075801_create_fuzzy_categories_table', 1),
	(18, '2025_10_08_153515_modify_ds_diagnosis_details_for_fuzzy', 1),
	(19, '2025_10_08_160838_modify_ds_rules_for_fuzzy_system', 1),
	(20, '2025_10_08_162305_move_keunikan_to_ds_rules_table', 1),
	(21, '2025_10_08_164459_make_severity_label_nullable_in_ds_diagnosis_table', 1),
	(22, '2025_10_08_164819_remove_jawaban_column_from_ds_diagnosis_details', 1),
	(23, '2025_10_15_141557_fix_ds_diagnosis_foreign_key', 1),
	(24, '2025_10_20_143218_create_fuzzy_parameters_table', 1),
	(25, '2025_10_20_153545_change_keunikan_to_string_in_ds_rules_table', 1),
	(26, '2025_10_20_153725_add_indexes_for_fuzzy_relations', 1),
	(27, '2025_10_20_154137_change_keunikan_to_fuzzy_parameter_id_in_ds_rules', 1),
	(28, '2025_10_20_154608_change_kemunculan_to_fuzzy_parameter_id_in_ds_diagnosis_details', 1),
	(29, '2025_11_26_000000_add_telepon_to_tblakun_table', 2);

-- Dumping structure for table db_sispak.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_sispak.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('BxIIsdrYTPpTOecjbo4P0og18Xi7NH7Y02UqsR6k', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo2OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWUI2Ym5RdFpWTWtYcFp6bmFVemRGMXBVUzFpYkM3bHBTNUY1WXAyTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kcy1kaWFnbm9zaXMvNDEiO31zOjc6InVzZXJfaWQiO2k6MztzOjk6InVzZXJfbmFtZSI7czoxMzoiQWRtaW5pc3RyYXRvciI7czo5OiJ1c2VyX3JvbGUiO2k6MTt9', 1768237633),
	('loS6mXvZO21qHvaFuXM1aUESZ659YvgG718Fbim8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOE9aQ1lHWDBvRXc4VlZqWGRDS1QyVUp4bGdrOXEwd1VaSEtIaERTRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778221922);

-- Dumping structure for table db_sispak.tblakun
CREATE TABLE IF NOT EXISTS `tblakun` (
  `id_akun` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sandi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_role` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_akun`),
  UNIQUE KEY `tblakun_email_unique` (`email`),
  UNIQUE KEY `tblakun_telepon_unique` (`telepon`),
  KEY `tblakun_id_role_foreign` (`id_role`),
  CONSTRAINT `tblakun_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `tblrole` (`id_role`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblakun: ~3 rows (approximately)
INSERT INTO `tblakun` (`id_akun`, `nama`, `email`, `telepon`, `sandi`, `alamat`, `jk`, `id_role`, `created_at`, `updated_at`) VALUES
	(2, 'User Baru', 'userbaru@gmail.com', '081111111111', '$2y$12$H5WJdO2XeMVtxmmzUg2mDuI0gLV2o.VNH.B5rOgVLWz5KIC945T0K', 'Purwokerto', 'Perempuan', 2, '2025-10-27 06:19:17', '2025-10-27 06:19:17'),
	(3, 'Administrator', NULL, '081234567890', '$2y$12$lJNrnQMn5LUS2yZrSEa2I.1dFMdhYObqX2ij5.v.qCxt/KDD6lwFK', 'System', 'L', 1, '2025-11-26 10:10:06', '2025-11-26 03:10:06'),
	(4, 'Ragil Putri', NULL, '081372053478', '$2y$12$T15BfAdJZUouImSMjUoBCOxS89crK3WUekIBT5XXt3eKG25vfXh0a', 'Purwokerto', 'Perempuan', 2, '2025-11-26 03:12:45', '2025-11-26 03:12:45'),
	(5, 'Tes baru', NULL, '082222222222', '$2y$12$JtIu3DfdIH/TR8eUVcj04.S4CjeS3qQPWj1yOIwckDkpwWYHUzzF2', 'purwokerto', 'Perempuan', 2, '2026-01-05 08:55:21', '2026-01-05 08:55:21'),
	(6, 'Hello', NULL, '085173212677', '$2y$12$IVINFPBB1esZkMW4tUuGnOLKyf2Xr/EcIwH9cnSbLA0w8wZ0S3CKq', 'Jakarta', 'Laki-laki', 2, '2026-01-06 02:53:46', '2026-01-06 02:53:46');

-- Dumping structure for table db_sispak.tbldiagnosis
CREATE TABLE IF NOT EXISTS `tbldiagnosis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `diagnosis_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_diagnosis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_akun` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbldiagnosis_id_akun_foreign` (`id_akun`),
  CONSTRAINT `tbldiagnosis_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `tblakun` (`id_akun`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tbldiagnosis: ~0 rows (approximately)

-- Dumping structure for table db_sispak.tblgejala
CREATE TABLE IF NOT EXISTS `tblgejala` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_gejala` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gejala` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pertanyaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `urutan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tblgejala_kode_gejala_unique` (`kode_gejala`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblgejala: ~18 rows (approximately)
INSERT INTO `tblgejala` (`id`, `kode_gejala`, `gejala`, `pertanyaan`, `is_active`, `urutan`, `created_at`, `updated_at`) VALUES
	(1, 'G001', 'Kelelahan berat menetap (≥2 minggu)', 'Apakah Anda sering merasa sangat lelah hampir setiap hari selama dua minggu atau lebih, padahal sudah cukup istirahat?', 1, 1, '2025-10-26 00:03:08', '2025-11-21 21:30:39'),
	(2, 'G002', 'Nyeri & bengkak sendi kecil simetris, kaku pagi ≥30 menit', 'Apakah kedua sisi jari/pergelangan Anda nyeri dan bengkak, dan terasa kaku saat bangun pagi (sekitar setengah jam atau lebih)?', 1, 2, '2025-10-26 00:03:08', '2025-11-21 21:30:48'),
	(3, 'G003', 'Ruam malar/fotosensitif (memburuk kena matahari)', 'Apakah ada ruam kemerahan di kulit yang mudah kambuh atau makin parah saat kena matahari (misalnya di pipi/hidung/lengan)?', 1, 3, '2025-10-26 00:03:08', '2025-11-21 21:31:00'),
	(4, 'G004', 'Ulser mulut/hidung berulang (sering tidak nyeri)', 'Apakah Anda sering sariawan atau luka kecil di mulut/hidung yang berulang tanpa sebab jelas?', 1, 4, '2025-10-26 00:03:08', '2025-11-21 21:31:13'),
	(5, 'G005', 'Kerontokan rambut menyeluruh (non-skar)', 'Apakah rambut Anda rontok lebih banyak dari biasanya saat disisir atau mandi dalam dua minggu terakhir?', 1, 5, '2025-10-26 00:03:08', '2025-11-21 21:31:22'),
	(6, 'G006', 'Demam ≥38 °C ≥2 hari tanpa tanda infeksi jelas', 'Apakah Anda demam 38°C atau lebih selama dua hari atau lebih tanpa gejala flu/pilek yang jelas?', 1, 6, '2025-10-26 00:03:08', '2025-11-21 21:31:31'),
	(7, 'G007', 'Fenomena Raynaud (putih→biru→merah saat dingin/stres)', 'Saat kedinginan atau stres, apakah jari Anda berubah warna (menjadi pucat, lalu kebiruan, lalu kemerahan)?', 1, 7, '2025-10-26 00:03:08', '2025-11-21 21:31:53'),
	(8, 'G008', 'Nyeri dada pleurit/perikardial (serositis)', 'Apakah ada nyeri dada yang sakit saat tarik napas dalam atau lebih sakit saat berbaring dan lebih enak saat duduk tegak?', 1, 8, '2025-10-26 00:03:08', '2025-11-21 21:33:14'),
	(9, 'G009', 'Bengkak tungkai/urin berbusa', 'Apakah Anda mendapati kaki bengkak atau urin tampak berbusa dalam beberapa waktu terakhir?', 1, 9, '2025-10-26 00:03:08', '2025-11-21 21:33:26'),
	(10, 'G010', 'Keluhan saraf (sakit kepala berat/kejang/kebingungan)', 'Apakah Anda pernah sakit kepala berat, kejang, atau merasa bingung tidak seperti biasanya?', 1, 10, '2025-10-26 00:03:08', '2025-11-21 21:32:37'),
	(11, 'G011', 'Nyeri otot (myalgia) menetap', 'Apakah Anda sering merasa pegal/nyeri otot yang tidak kunjung hilang?', 1, 11, '2025-10-26 00:03:08', '2025-11-21 21:34:10'),
	(12, 'G012', 'Penurunan berat badan ≥5% dalam ±1 bulan tanpa diet', 'Apakah berat badan Anda turun sekitar 5% atau lebih dalam sebulan, padahal tidak sedang diet/olahraga berlebih?', 1, 12, '2025-10-26 00:03:08', '2025-11-21 21:34:23'),
	(13, 'G013', 'Plak discoid bersisik/menebal, dapat meninggalkan parut/bekas', 'Apakah ada plak kulit tebal dan bersisik (misalnya di wajah/kulit kepala/telinga) yang meninggalkan bekas?', 1, 13, '2025-10-26 00:03:08', '2025-11-21 21:34:47'),
	(14, 'G014', 'Gatal kulit menetap pada area ruam/plak', 'Apakah kulit gatal terus-menerus, terutama pada area yang ada ruam atau plak?', 1, 14, '2025-10-26 00:03:08', '2025-11-21 21:35:27'),
	(15, 'G015', 'Alopesia sikatrik (parut) di kulit kepala', 'Apakah ada bagian kepala yang botak dan kulitnya tampak berbekas/berparut?', 1, 15, '2025-10-26 00:03:08', '2025-11-21 21:35:43'),
	(16, 'G016', 'Riwayat obat pemicu (hydralazine/procainamide/isoniazid, dll.)', 'Sebelum keluhan muncul, apakah Anda mengonsumsi obat tertentu (misalnya hydralazine, procainamide, isoniazid, atau sejenisnya)?', 1, 16, '2025-10-26 00:03:08', '2025-11-21 21:36:08'),
	(17, 'G017', 'Gejala muncul setelah mulai obat (minggu–bulan)', 'Apakah keluhan mulai timbul dalam beberapa minggu hingga bulan setelah mulai minum obat tersebut?', 1, 17, '2025-10-26 00:03:08', '2025-11-21 21:36:21'),
	(18, 'G018', 'Gejala membaik saat obat dihentikan', 'Apakah keluhan berkurang setelah obat dihentikan atau diganti atas saran dokter?', 1, 18, '2025-10-26 00:03:08', '2025-11-21 21:36:32');

-- Dumping structure for table db_sispak.tblintervalcf
CREATE TABLE IF NOT EXISTS `tblintervalcf` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblintervalcf: ~0 rows (approximately)

-- Dumping structure for table db_sispak.tblnilaicf
CREATE TABLE IF NOT EXISTS `tblnilaicf` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_gejala` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_penyakit` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mb` double NOT NULL,
  `md` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblnilaicf: ~0 rows (approximately)

-- Dumping structure for table db_sispak.tblpenyakit
CREATE TABLE IF NOT EXISTS `tblpenyakit` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_penyakit` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penyakit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblpenyakit: ~3 rows (approximately)
INSERT INTO `tblpenyakit` (`id`, `kode_penyakit`, `penyakit`, `penangan`, `created_at`, `updated_at`) VALUES
	(1, 'P001', 'Systemic Lupus Erythematosus (SLE)', '1. Gunakan tabir surya SPF 50 atau lebih dan pakai topi serta baju lengan panjang.\r\n2. Hindari matahari kuat pada pukul 10.00 sampai 15.00.\r\n3. Atur energi dengan membagi aktivitas dan sisipkan waktu istirahat.\r\n4. Tidur teratur tujuh sampai delapan jam setiap malam.\r\n5. Lakukan jalan santai atau peregangan 20 sampai 30 menit tiga sampai lima kali seminggu.\r\n6. Perbanyak sayur buah dan ikan serta batasi gorengan dan gula.\r\n7. Kelola stres dengan napas dalam relaksasi ringan atau hobi.\r\n8. Minum obat sesuai anjuran dokter dan jangan menghentikan obat sendiri.', '2025-10-26 00:03:08', '2025-11-21 21:18:54'),
	(2, 'P002', 'Cutaneous Lupus Erythematosus (CLE)', '1. Pakai tabir surya SPF 50 atau lebih dan ulang setiap dua sampai tiga jam saat beraktivitas di luar.\r\n2. Gunakan pelembap setelah mandi dan pilih sabun yang lembut.\r\n3. Hindari menggaruk area kulit yang bermasalah dan jaga kuku tetap pendek.\r\n4. Hindari matahari kuat pada pukul 10.00 sampai 15.00 dan gunakan pakaian pelindung.\r\n5. Pilih kosmetik yang tidak mudah mengiritasi kulit.\r\n6. Catat pemicu seperti matahari cuaca dingin atau stres lalu hindari bila memicu keluhan.', '2025-10-26 00:03:08', '2025-11-21 21:20:06'),
	(3, 'P003', 'Drug-Induced Lupus (DIL)', '1. Tulis daftar obat yang sedang diminum beserta tanggal mulai.\r\n2. Jangan menghentikan obat sendiri dan konsultasi ke dokter untuk penyesuaian obat.\r\n3. Istirahat cukup dan lakukan gerak ringan bertahap untuk mengurangi kaku dan nyeri.\r\n4. Gunakan kompres hangat pada sendi yang terasa nyeri.\r\n5. Amati perubahan keluhan setelah obat diganti atau dihentikan sesuai saran dokter.\r\n6. Segera ke dokter bila muncul keluhan berat seperti nyeri dada sesak napas demam tinggi ruam luas bengkak kaki atau bingung mendadak.', '2025-10-26 00:03:08', '2025-11-21 21:21:43');

-- Dumping structure for table db_sispak.tblrole
CREATE TABLE IF NOT EXISTS `tblrole` (
  `id_role` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.tblrole: ~2 rows (approximately)
INSERT INTO `tblrole` (`id_role`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '2025-10-26 00:02:10', '2025-10-26 00:02:10'),
	(2, 'user', '2025-10-26 00:02:10', '2025-10-26 00:02:10');

-- Dumping structure for table db_sispak.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_sispak.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
