-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 12:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_infeksijamur`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_25_110845_create_tblrole_table', 1),
(5, '2025_01_25_111227_create_tblakun_table', 2),
(6, '2025_01_25_111458_create_tblgejala_table', 3),
(7, '2025_01_25_111948_create_tblpenyakit_table', 4),
(8, '2025_01_25_112318_create_tblnilaicf_table', 5),
(9, '2025_01_25_112605_create_tblintervalcf_table', 6),
(10, '2025_01_25_113112_create_tbldiagnosis_table', 7),
(11, '2025_01_27_190008_add_penangan_to_tblpenyakit_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8wY600G6JW8dL3arJq50zWXhKfa0ctLV36AVMNV3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiQ1Z1OXEzc0l4dDRPakZET0I5NWpYMzdQbk4yVUxGcE1VZ05iaDJBaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1738105036),
('tmZyYO22BnklQ6x7ITSrE15ZCu6MI73NQRp2oq1Q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWER2d2JLclpUZUF1NTJJS21SUlU4UlhXeGROczhiYnZpU2Jxc1g1cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1738103256);

-- --------------------------------------------------------

--
-- Table structure for table `tblakun`
--

CREATE TABLE `tblakun` (
  `id_akun` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jk` varchar(255) NOT NULL,
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblakun`
--

INSERT INTO `tblakun` (`id_akun`, `nama`, `email`, `sandi`, `alamat`, `jk`, `id_role`, `created_at`, `updated_at`) VALUES
(1, 'test admin', 'admin@example.com', '$2y$12$fJClaZcwdWN2sgEoO0CNbeoeoLATkBXQUQHkDB2GG2vNkBXiSwIx6', 'pwt', 'Laki-laki', 1, '2025-01-25 05:06:06', '2025-01-25 05:06:06'),
(2, 'aku', 'aku@gmail.com', '$2y$12$QXkrXABaEMkM8wUsniMUeuGSqaOvwoSj7vhJU3ObhFM5Nd3AQ5kC2', 'purwokerto', 'Perempuan', 2, '2025-01-25 07:43:22', '2025-01-25 07:43:22'),
(3, 'tes', 'tes@gmail.com', '$2y$12$TIuFWZ1EAnlLEXbaZlsYaOUMP3q0hZCrNirfzNqOO4G3yms1ulmIS', 'purwokerto', 'Laki-laki', 2, '2025-01-25 07:44:44', '2025-01-25 07:44:44'),
(4, 'Admin Utama', 'admin@admin.com', '$2y$12$Wnw05X9VyW.wQJtmqIM/Ue36ECS6qq6g3Sg7hN84nEtc/zFwVYcPi', 'Purwokerto', 'Perempuan', 1, '2025-01-28 15:26:41', '2025-01-28 15:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbldiagnosis`
--

CREATE TABLE `tbldiagnosis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis_id` varchar(255) NOT NULL,
  `data_diagnosis` longtext NOT NULL,
  `kondisi` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_akun` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblgejala`
--

CREATE TABLE `tblgejala` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_gejala` char(255) NOT NULL,
  `gejala` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblgejala`
--

INSERT INTO `tblgejala` (`id`, `kode_gejala`, `gejala`, `created_at`, `updated_at`) VALUES
(1, 'G01', 'Ruam Berbentuk Lingkaran', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(2, 'G02', 'Warna Merah atau Coklat', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(3, 'G03', 'Luka Basah', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(4, 'G04', 'Pembengkakan Ringan', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(5, 'G05', 'Bercak Kulit Berwarna', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(6, 'G06', 'Bercak Tidak Teratur', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(7, 'G07', 'Kulit Kering atau Mengelupas', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(8, 'G08', 'Gatal Ringan', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(9, 'G09', 'Perubahan Warna Kulit', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(10, 'G10', 'Tidak Menyebabkan Nyeri', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(11, 'G11', 'Gatal', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(12, 'G12', 'Kulit Mengelupas', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(13, 'G13', 'Bercak Kulit Putih', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(14, 'G14', 'Pembengkakan', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(15, 'G15', 'Bau Tidak Sedap', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(16, 'G16', 'Lepuh', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(17, 'G17', 'Bercak Kebotakan', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(18, 'G18', 'Kulit Kemerahan', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(19, 'G19', 'Rambut Rontok', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(20, 'G20', 'Perubahan Warna Kuku', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(21, 'G21', 'Kuku Menebal', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(22, 'G22', 'Kuku Rapuh', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(23, 'G23', 'Kuku Mengelupas', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(24, 'G24', 'Deformitas Kuku', '2025-01-25 12:30:11', '2025-01-25 12:30:11'),
(25, 'G25', 'Rasa Nyeri atau Ketidaknyamanan', '2025-01-25 12:30:11', '2025-01-25 12:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `tblintervalcf`
--

CREATE TABLE `tblintervalcf` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kondisi` varchar(255) NOT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblintervalcf`
--

INSERT INTO `tblintervalcf` (`id`, `kondisi`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 'Tidak Tahu', 0, NULL, NULL),
(2, 'Tidak Yakin', 0.2, NULL, NULL),
(3, 'Mungkin', 0.4, NULL, NULL),
(4, 'Kemungkinan Besar', 0.6, NULL, NULL),
(5, 'Hampir Pasti', 0.8, NULL, NULL),
(6, 'Pasti', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblnilaicf`
--

CREATE TABLE `tblnilaicf` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_gejala` char(255) NOT NULL,
  `kode_penyakit` char(255) NOT NULL,
  `mb` double NOT NULL,
  `md` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblnilaicf`
--

INSERT INTO `tblnilaicf` (`id`, `kode_gejala`, `kode_penyakit`, `mb`, `md`, `created_at`, `updated_at`) VALUES
(1, 'G01', 'P01', 1, 0, NULL, NULL),
(2, 'G02', 'P01', 1, 0, NULL, NULL),
(3, 'G03', 'P01', 0.6, 0.2, NULL, NULL),
(4, 'G04', 'P04', 0.6, 0.2, NULL, NULL),
(5, 'G05', 'P01', 0.8, 0.2, NULL, NULL),
(6, 'G06', 'P02', 1, 0, NULL, NULL),
(7, 'G07', 'P02', 0.6, 0.2, NULL, NULL),
(8, 'G08', 'P02', 0.4, 0.2, NULL, NULL),
(9, 'G09', 'P02', 0.8, 0.2, NULL, NULL),
(10, 'G10', 'P02', 0.8, 0, NULL, NULL),
(11, 'G11', 'P02', 1, 0, NULL, NULL),
(12, 'G12', 'P01', 0.8, 0.4, NULL, NULL),
(13, 'G12', 'P03', 0.8, 0.2, NULL, NULL),
(14, 'G12', 'P04', 0.8, 0.2, NULL, NULL),
(15, 'G13', 'P01', 0.6, 0.2, NULL, NULL),
(16, 'G13', 'P02', 0.6, 0.2, NULL, NULL),
(17, 'G13', 'P03', 0.6, 0, NULL, NULL),
(18, 'G13', 'P04', 0.4, 0, NULL, NULL),
(19, 'G14', 'P03', 0.8, 0, NULL, NULL),
(20, 'G15', 'P03', 0.4, 0.2, NULL, NULL),
(21, 'G15', 'P04', 0.4, 0.2, NULL, NULL),
(22, 'G16', 'P03', 0.6, 0.2, NULL, NULL),
(23, 'G16', 'P05', 0.6, 0.2, NULL, NULL),
(24, 'G17', 'P03', 0.4, 0.2, NULL, NULL),
(25, 'G17', 'P04', 0.4, 0.2, NULL, NULL),
(26, 'G18', 'P04', 0.6, 0.2, NULL, NULL),
(27, 'G19', 'P03', 0.8, 0, NULL, NULL),
(28, 'G19', 'P04', 0.8, 0, NULL, NULL),
(29, 'G20', 'P05', 0.8, 0, NULL, NULL),
(30, 'G21', 'P05', 0.8, 0.2, NULL, NULL),
(31, 'G22', 'P05', 1, 0, NULL, NULL),
(32, 'G23', 'P05', 0.4, 0, NULL, NULL),
(33, 'G24', 'P05', 0.6, 0, NULL, NULL),
(34, 'G25', 'P05', 0.8, 0, NULL, NULL),
(35, 'G25', 'P03', 0.4, 0.2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpenyakit`
--

CREATE TABLE `tblpenyakit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_penyakit` char(255) NOT NULL,
  `penyakit` varchar(255) NOT NULL,
  `penangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpenyakit`
--

INSERT INTO `tblpenyakit` (`id`, `kode_penyakit`, `penyakit`, `penangan`, `created_at`, `updated_at`) VALUES
(1, 'P01', 'Kurap', 'Obat Topikal: Krim antijamur seperti clotrimazole miconazole atau terbinafine\r\nPengobatan Oral: Jika infeksi luas atau tidak merespon pengobatan topikal, dokter mungkin meresepkan obat oral seperti fluconazole atau griseofulvin.\r\n', '2025-01-25 14:25:21', '2025-01-25 14:25:21'),
(2, 'P02', 'Panu', 'Obat Topikal: Shampo atau krim yang mengandung selenium sulfida ketoconazole atau ciclopirox\r\nPengobatan Oral: Untuk kasus yang lebih parah atau berulang perlu obat oral seperti fluconazole atau itraconazole.\r\n', '2025-01-25 14:25:21', '2025-01-25 14:25:21'),
(3, 'P03', 'Kadas', 'Obat Topikal: Krim atau spray antijamur seperti terbinafine clotrimazole atau miconazole.\r\nPengobatan Oral: Dapat dipertimbangkan untuk infeksi yang luas atau tidak sembuh dengan pengobatan topikal.\r\n', '2025-01-25 14:25:21', '2025-01-25 14:25:21'),
(4, 'P04', 'Kurap Kepala', 'Pengobatan Oral: Obat antifungal griseofulvin atau terbinafine biasanya diperlukan karena infeksi ini berada di dalam folikel rambut. \r\nObat Topikal: Shampo antijamur bisa membantu tetapi biasanya tidak cukup sendirian (boleh ditanya langsung ke apoteker).\r\n', '2025-01-25 14:25:21', '2025-01-25 14:25:21'),
(5, 'P05', 'Onikomikosis', 'Obat Oral: Obat seperti terbinafine atau itraconazole sering digunakan untuk mengobati infeksi kuku.\r\nPengobatan Topikal: Untuk infeksi ringan, ada juga solusi topikal seperti ciclopirox meskipun efektivitasnya lebih rendah dibandingkan pengobatan oral.\r\n', '2025-01-25 14:25:21', '2025-01-25 14:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `tblrole`
--

CREATE TABLE `tblrole` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblrole`
--

INSERT INTO `tblrole` (`id_role`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-01-25 04:11:01', '2025-01-25 04:11:01'),
(2, 'user', '2025-01-25 04:11:01', '2025-01-25 04:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tblakun`
--
ALTER TABLE `tblakun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `tblakun_email_unique` (`email`),
  ADD KEY `tblakun_id_role_foreign` (`id_role`);

--
-- Indexes for table `tbldiagnosis`
--
ALTER TABLE `tbldiagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblgejala`
--
ALTER TABLE `tblgejala`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblintervalcf`
--
ALTER TABLE `tblintervalcf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblnilaicf`
--
ALTER TABLE `tblnilaicf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpenyakit`
--
ALTER TABLE `tblpenyakit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrole`
--
ALTER TABLE `tblrole`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblakun`
--
ALTER TABLE `tblakun`
  MODIFY `id_akun` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbldiagnosis`
--
ALTER TABLE `tbldiagnosis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblgejala`
--
ALTER TABLE `tblgejala`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tblintervalcf`
--
ALTER TABLE `tblintervalcf`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblnilaicf`
--
ALTER TABLE `tblnilaicf`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tblpenyakit`
--
ALTER TABLE `tblpenyakit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblrole`
--
ALTER TABLE `tblrole`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblakun`
--
ALTER TABLE `tblakun`
  ADD CONSTRAINT `tblakun_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `tblrole` (`id_role`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
