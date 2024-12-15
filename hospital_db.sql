-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 05:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patientid` int(11) NOT NULL,
  `doctorsid` int(11) DEFAULT NULL,
  `dop` date DEFAULT NULL,
  `status` varchar(254) NOT NULL DEFAULT 'pending',
  `concern` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patientid`, `doctorsid`, `dop`, `status`, `concern`, `created_at`) VALUES
(10, 3, 3, '2024-12-15', 'assigned', 'I have Nosebleed', '2024-12-15 17:18:29'),
(11, 5, NULL, NULL, 'pending', 'I have not yet piss in 3 days', '2024-12-15 17:56:59'),
(12, 6, NULL, NULL, 'pending', 'HUHU, my mind is stress', '2024-12-15 17:57:47'),
(13, 7, NULL, NULL, 'pending', 'My feets been hurting for days', '2024-12-15 17:58:37'),
(14, 8, NULL, NULL, 'pending', 'My back is itching every night huhu', '2024-12-15 17:59:30'),
(15, 2, 4, '2024-12-15', 'assigned', 'I only serve master rimuru', '2024-12-15 18:00:35'),
(16, 4, NULL, NULL, 'pending', 'My wife is always beautiful', '2024-12-15 18:01:32'),
(17, 3, 5, '2024-12-15', 'assigned', 'asd', '2024-12-15 18:07:54'),
(19, 3, NULL, NULL, 'pending', 'Hey', '2024-12-15 10:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(254) NOT NULL,
  `specialty` text NOT NULL,
  `status` varchar(254) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `status`) VALUES
(1, 'Dr. John Smith', 'Cardiology', 'available'),
(2, 'Dr. Emily Davis', 'Neurology', 'available'),
(3, 'Dr. Michael Brown', 'Orthopedics', 'available'),
(4, 'Dr. Sarah Johnson', 'Pediatrics', 'available'),
(5, 'Dr. William Wilson', 'Dermatology', 'available');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(254) NOT NULL DEFAULT 'Patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'San Isidro Hospital', 'sanisidrohospital@gmail.com', NULL, '$2y$10$iFY9..IoMKiusDXCzY50Kep1DXWgrPOGCr4jj30iPZiy8uBk7jura', NULL, '2024-12-11 01:12:56', '2024-12-11 01:12:56', 'Admin'),
(2, 'Noir De Tempest', 'noir@gmail.com', NULL, '$2y$10$2O0cb8bb1VAplucIQmojBuMqe/.omKY2Ow2yDcO1n9Phd8Sz.yBH.', NULL, '2024-12-11 05:37:09', '2024-12-11 05:37:09', 'Patient'),
(3, 'Blanc', 'blanc@gmail.com', NULL, '$2y$10$DpDvsIc55hCP/3jXH47YfO2VhHrpopPrpzIqYV23DEKrbdtD84iQu', NULL, '2024-12-15 01:18:18', '2024-12-15 01:18:18', 'Patient'),
(4, 'Rouge', 'rouge@gmail.com', NULL, '$2y$10$Zi.QGVhExv29qtZ9vEORmuzWyJ2uwuVD3RPpMoBxRNdnE/gQDQo3S', NULL, '2024-12-15 01:56:12', '2024-12-15 01:56:12', 'Patient'),
(5, 'Bleu', 'bleu@gmail.com', NULL, '$2y$10$4DpSabET60iAgmUzSUlDa.5LlCsqeuC6Z/UvB69cFc8.W1mkr9kqK', NULL, '2024-12-15 01:56:43', '2024-12-15 01:56:43', 'Patient'),
(6, 'Vert', 'vert@gmail.com', NULL, '$2y$10$tWqy0jLwdcutff7wTGUR9epa6KVNNACAYv.7YaGR6R6dHrwrgy6Yu', NULL, '2024-12-15 01:57:26', '2024-12-15 01:57:26', 'Patient'),
(7, 'Jaune', 'jaune@gmail.com', NULL, '$2y$10$OBxd3E10GqAfEhensXIyM.iL.d6ykp2yi27zw821dVtX83CM9Epfq', NULL, '2024-12-15 01:58:17', '2024-12-15 01:58:17', 'Patient'),
(8, 'Violet', 'violet@gmail.com', NULL, '$2y$10$2lX35GyXta3HdB1bKQ1ALucQuGIG0x3hZ7js68MvhW2CkeR5.hvDe', NULL, '2024-12-15 01:59:06', '2024-12-15 01:59:06', 'Patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
