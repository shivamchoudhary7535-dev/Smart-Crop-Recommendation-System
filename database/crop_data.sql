-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2026 at 01:52 PM
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
-- Database: `smart_crop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `crop_data`
--

CREATE TABLE `crop_data` (
  `id` int(11) NOT NULL,
  `farmer_name` varchar(100) NOT NULL,
  `soil` varchar(50) NOT NULL,
  `temperature` float NOT NULL,
  `humidity` varchar(50) NOT NULL,
  `rainfall` varchar(50) NOT NULL,
  `water_availability` varchar(50) NOT NULL,
  `recommended_crop` varchar(100) NOT NULL,
  `fertilizer` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_data`
--

INSERT INTO `crop_data` (`id`, `farmer_name`, `soil`, `temperature`, `humidity`, `rainfall`, `water_availability`, `recommended_crop`, `fertilizer`, `created_at`) VALUES
(1, 'Demo Farmer', 'Loamy', 28, 'Medium', 'Normal', 'Available', 'Wheat', 'DAP, Urea, Potash', '2026-07-27 09:42:43'),
(2, 'Ramesh', 'Sandy', 32, 'Low', 'Low', 'Limited', 'Bajra', 'Urea, DAP', '2026-07-27 09:42:43'),
(3, 'Suresh', 'Clay', 26, 'High', 'High', 'Available', 'Rice', 'DAP, Potash, Zinc Sulphate', '2026-07-27 09:42:43'),
(4, 'शिवम चौधरी', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-07-27 09:55:45'),
(5, 'शिवम चौधरी', 'sandy', 25, 'low', 'low', 'low', 'Bajra', NULL, '2026-07-27 09:56:34'),
(6, 'शिवम चौधरी', 'sandy', 25, 'low', 'low', 'low', 'Bajra', NULL, '2026-07-27 10:00:44'),
(7, 'Utkarsh', 'clay', 25, 'low', 'low', 'low', 'Mustard', NULL, '2026-07-27 10:01:03'),
(8, 'शिवम चौधरी', 'clay', 30, 'medium', 'low', 'low', 'सरसों', NULL, '2026-07-27 10:07:39'),
(9, 'दीपक', 'black', 35, 'low', 'high', 'good', 'सोयाबीन', NULL, '2026-07-27 10:08:54'),
(10, 'दीपक', 'black', 35, 'low', 'high', 'good', 'सोयाबीन', NULL, '2026-07-27 10:09:11'),
(11, 'दीपक', 'black', 35, 'low', 'high', 'good', 'Soybean', NULL, '2026-07-27 10:09:32'),
(12, 'शिवम चौधरी', 'red', 25, 'low', 'low', 'low', 'ज्वार', NULL, '2026-07-29 05:28:47'),
(13, 'शिवम चौधरी', 'red', 25, 'low', 'low', 'low', 'Jowar', NULL, '2026-07-29 05:29:09'),
(14, 'shivam', 'clay', 25, 'medium', 'low', 'low', 'Mustard', NULL, '2026-07-29 06:04:58'),
(15, 'shivam', 'clay', 25, 'medium', 'low', 'low', 'Mustard', NULL, '2026-07-29 06:07:58'),
(16, 'Sumit', 'clay', 25, 'low', 'low', 'low', 'Mustard', NULL, '2026-07-29 06:08:22'),
(17, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-07-29 06:47:16'),
(18, 'shivam', 'black', 25, 'high', 'low', 'low', 'कपास', NULL, '2026-07-29 07:45:19'),
(19, 'Utkarsh', 'loamy', 25, 'low', 'high', 'low', 'चना', NULL, '2026-07-29 07:53:52'),
(20, 'Utkarsh', 'loamy', 25, 'low', 'high', 'low', 'चना', NULL, '2026-07-29 07:55:09'),
(21, 'Utkarsh', 'loamy', 25, 'low', 'high', 'low', 'चना', NULL, '2026-07-29 07:55:14'),
(22, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-07-29 08:10:26'),
(23, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-07-31 08:49:28'),
(24, 'shivam', 'clay', 25, 'low', 'normal', 'low', 'सरसों', NULL, '2026-07-31 10:03:59'),
(25, 'shivam', 'clay', 25, 'low', 'normal', 'low', 'सरसों', NULL, '2026-08-03 08:17:49'),
(26, 'shivam', 'sandy', 25, 'low', 'low', 'moderate', 'बाजरा', NULL, '2026-08-03 08:47:47'),
(27, 'shivam', 'sandy', 25, 'high', 'low', 'low', 'बाजरा', NULL, '2026-08-03 09:20:16'),
(28, 'शिवम ', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-08-03 09:22:35'),
(29, 'shivam', 'sandy', 25, 'medium', 'low', 'moderate', 'बाजरा', NULL, '2026-08-03 09:24:34'),
(30, 'shivam', 'sandy', 25, 'medium', 'low', 'moderate', 'बाजरा', NULL, '2026-08-03 09:24:35'),
(31, 'shivam', 'clay', 25, 'medium', 'low', 'low', 'सरसों', NULL, '2026-08-03 09:29:07'),
(32, 'shivam', 'clay', 25, 'medium', 'low', 'low', 'सरसों', NULL, '2026-08-03 09:30:36'),
(33, 'shivam', 'clay', 25, 'medium', 'low', 'low', 'सरसों', NULL, '2026-08-03 09:30:40'),
(34, 'shivam', 'loamy', 25, 'medium', 'low', 'low', 'चना', NULL, '2026-08-05 08:24:38'),
(35, 'shivam', 'loamy', 25, 'medium', 'low', 'low', 'चना', NULL, '2026-08-05 08:24:40'),
(36, 'shivam', 'clay', 25, 'low', 'normal', 'low', 'सरसों', NULL, '2026-08-06 09:11:48'),
(37, 'shivam', 'clay', 25, 'low', 'normal', 'low', 'सरसों', NULL, '2026-08-06 09:28:24'),
(38, 'shivam', 'sandy', 26, 'medium', 'low', 'low', 'बाजरा', NULL, '2026-08-13 09:03:06'),
(39, 'shivam', 'sandy', 26, 'medium', 'low', 'low', 'बाजरा', NULL, '2026-08-13 09:03:08'),
(40, 'shivam', 'sandy', 26, 'medium', 'low', 'low', 'Bajra', NULL, '2026-08-13 09:03:58'),
(41, 'shivam', 'sandy', 26, 'medium', 'low', 'low', 'Bajra', NULL, '2026-08-13 09:19:24'),
(42, 'shivam', 'sandy', 26, 'medium', 'low', 'low', 'Bajra', NULL, '2026-08-13 09:19:32'),
(43, 'shivam', 'clay', 25, 'low', 'normal', 'low', 'Mustard', NULL, '2026-08-13 09:20:02'),
(44, 'shivam', 'sandy', 25, 'low', 'normal', 'low', 'बाजरा', NULL, '2026-08-17 06:33:25'),
(45, 'shivam', 'sandy', 25, 'low', 'normal', 'low', 'Bajra', NULL, '2026-08-17 06:34:12'),
(46, 'shivam', 'sandy', 25, 'low', 'normal', 'low', 'Bajra', NULL, '2026-08-17 06:37:03'),
(47, 'shivam', 'sandy', 25, 'low', 'normal', 'low', 'बाजरा', NULL, '2026-08-17 06:37:11'),
(48, 'shivam', 'sandy', 25, 'low', 'normal', 'low', 'Bajra', NULL, '2026-08-17 06:37:56'),
(49, 'शिवम चौधरी', 'sandy', 25, 'medium', 'normal', 'low', 'मूंगफली', NULL, '2026-08-22 09:21:27'),
(50, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'मक्का', NULL, '2026-08-26 06:19:57'),
(51, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'मक्का', NULL, '2026-08-26 06:26:13'),
(52, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:26:34'),
(53, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:26:37'),
(54, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:26:39'),
(55, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:26:42'),
(56, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'मक्का', NULL, '2026-08-26 06:26:44'),
(57, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:26:46'),
(58, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:30:56'),
(59, 'shivam', 'loamy', 25, 'high', 'low', 'low', 'Maize', NULL, '2026-08-26 06:34:26'),
(61, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'Cotton', NULL, '2026-09-01 06:54:01'),
(62, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'कपास', NULL, '2026-09-01 06:55:06'),
(63, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'कपास', NULL, '2026-09-01 06:55:07'),
(64, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'कपास', NULL, '2026-09-01 06:55:09'),
(65, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'कपास', NULL, '2026-09-01 06:55:32'),
(66, 'Priyanshu', 'black', 25, 'high', 'normal', 'good', 'कपास', NULL, '2026-09-01 06:55:42'),
(67, 'shivam', 'sandy', 25, 'medium', 'low', 'moderate', 'Bajra', NULL, '2026-09-01 07:01:17'),
(68, 'shivam', 'sandy', 25, 'medium', 'low', 'moderate', 'Bajra', NULL, '2026-09-01 07:03:46'),
(69, 'shivam', 'clay', 25, 'low', 'low', 'low', 'सरसों', NULL, '2026-09-06 08:59:27'),
(70, 'shivam', 'clay', 25, 'low', 'low', 'low', 'Mustard', NULL, '2026-09-06 08:59:46'),
(71, 'shivam', 'clay', 25, 'low', 'low', 'low', 'सरसों', NULL, '2026-09-06 09:01:58'),
(72, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 12:38:45'),
(73, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 12:49:12'),
(74, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 12:51:11'),
(75, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 13:08:31'),
(76, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'Bajra', NULL, '2026-09-13 13:10:21'),
(77, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 13:10:34'),
(78, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 13:29:37'),
(79, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 13:29:57'),
(80, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'बाजरा', NULL, '2026-09-13 13:32:19'),
(81, 'shivam', 'sandy', 25, 'low', 'low', 'low', 'Bajra', NULL, '2026-09-13 13:32:31'),
(82, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:33:07'),
(83, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:37:28'),
(84, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:40:37'),
(85, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'Mustard', NULL, '2026-09-13 13:41:20'),
(86, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:41:49'),
(87, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:43:49'),
(88, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'Mustard', NULL, '2026-09-13 13:44:09'),
(89, 'shivam', 'clay', 25, 'medium', 'low', 'moderate', 'सरसों', NULL, '2026-09-13 13:44:21'),
(90, 'shivam', 'red', 25, 'medium', 'low', 'low', 'ज्वार', NULL, '2026-09-13 13:44:47'),
(91, 'shivam', 'red', 25, 'medium', 'low', 'low', 'Jowar', NULL, '2026-09-13 13:45:01'),
(92, 'shivam', 'red', 25, 'medium', 'low', 'low', 'Jowar', NULL, '2026-09-13 13:55:38'),
(93, 'shivam', 'red', 25, 'medium', 'low', 'low', 'ज्वार', NULL, '2026-09-13 13:56:00'),
(94, 'shivam', 'loamy', 25, 'medium', 'high', 'good', 'चना', NULL, '2026-09-13 13:56:38'),
(95, 'shivam', 'loamy', 25, 'medium', 'high', 'good', 'Gram', NULL, '2026-09-13 13:56:48'),
(96, 'shivam', 'black', 25, 'high', 'low', 'low', 'Cotton', NULL, '2026-09-13 13:57:24'),
(97, 'shivam', 'black', 25, 'high', 'low', 'low', 'कपास', NULL, '2026-09-13 13:57:33'),
(98, 'Shivam Chaudhary', 'loamy', 25, 'medium', 'low', 'moderate', 'Gram', NULL, '2026-09-16 11:08:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crop_data`
--
ALTER TABLE `crop_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crop_data`
--
ALTER TABLE `crop_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
