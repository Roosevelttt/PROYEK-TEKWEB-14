-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2024 at 08:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_tekweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `id_karyawan` int NOT NULL,
  `jam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_karyawan`, `jam`, `status`) VALUES
(1, 1, '2023-12-17 00:15:00', 1),
(2, 1, '2023-12-18 00:15:00', 1),
(3, 1, '2023-12-19 00:15:00', 1),
(4, 1, '2023-12-20 00:15:00', 1),
(5, 1, '2023-12-21 00:15:00', 1),
(6, 1, '2023-12-22 00:15:00', 1),
(7, 1, '2023-12-23 00:15:00', 1),
(8, 1, '2023-12-24 00:15:00', 1),
(9, 1, '2023-12-25 00:15:00', 1),
(10, 1, '2023-12-26 00:15:00', 1),
(11, 1, '2023-12-27 00:15:00', 1),
(12, 1, '2023-12-28 00:15:00', 1),
(13, 1, '2023-12-29 00:15:00', 1),
(14, 1, '2023-12-30 00:15:00', 1),
(15, 1, '2023-12-31 00:15:00', 1),
(16, 1, '2024-01-01 00:15:00', 1),
(17, 1, '2024-01-02 00:15:00', 1),
(18, 1, '2024-01-03 00:15:00', 1),
(19, 1, '2024-01-04 00:15:00', 1),
(20, 1, '2024-01-05 00:15:00', 1),
(21, 1, '2024-01-06 00:15:00', 1),
(22, 1, '2024-01-07 00:15:00', 1),
(23, 1, '2024-01-08 00:15:00', 1),
(24, 1, '2024-01-09 00:15:00', 1),
(25, 1, '2024-01-10 00:15:00', 1),
(26, 1, '2024-01-11 00:15:00', 1),
(27, 1, '2024-01-12 00:15:00', 1),
(28, 1, '2024-01-13 00:15:00', 1),
(29, 1, '2024-01-14 00:15:00', 1),
(30, 1, '2024-01-15 00:15:00', 1),
(31, 1, '2024-01-16 00:15:00', 1),
(32, 1, '2024-01-17 00:15:00', 1),
(33, 1, '2024-01-18 00:15:00', 1),
(34, 1, '2024-01-19 00:15:00', 1),
(35, 1, '2024-01-20 00:15:00', 1),
(36, 1, '2024-01-21 00:15:00', 1),
(37, 1, '2024-01-22 00:15:00', 1),
(38, 1, '2024-01-23 00:15:00', 1),
(39, 1, '2024-01-24 00:15:00', 1),
(40, 1, '2024-01-25 00:15:00', 1),
(41, 1, '2024-01-26 00:15:00', 1),
(42, 1, '2024-01-27 00:15:00', 1),
(43, 1, '2024-01-28 00:15:00', 1),
(44, 1, '2024-01-29 00:15:00', 1),
(45, 1, '2024-01-30 00:15:00', 1),
(46, 1, '2024-01-31 00:15:00', 1),
(47, 1, '2024-02-01 00:15:00', 1),
(48, 1, '2024-02-02 00:15:00', 1),
(49, 1, '2024-02-03 00:15:00', 1),
(50, 1, '2024-02-04 00:15:00', 1),
(51, 1, '2024-02-05 00:15:00', 1),
(52, 1, '2024-02-06 00:15:00', 1),
(53, 1, '2024-02-07 00:15:00', 1),
(54, 1, '2024-02-08 00:15:00', 1),
(55, 1, '2024-02-09 00:15:00', 1),
(56, 1, '2024-02-10 00:15:00', 1),
(57, 1, '2024-02-11 00:15:00', 1),
(58, 1, '2024-02-12 00:15:00', 1),
(59, 1, '2024-02-13 00:15:00', 1),
(60, 1, '2024-02-14 00:15:00', 1),
(61, 1, '2024-02-15 00:15:00', 1),
(62, 1, '2024-02-16 00:15:00', 1),
(63, 1, '2024-02-17 00:15:00', 1),
(64, 1, '2024-02-18 00:15:00', 1),
(65, 1, '2024-02-19 00:15:00', 1),
(66, 1, '2024-02-20 00:15:00', 1),
(67, 1, '2024-02-21 00:15:00', 1),
(68, 1, '2024-02-22 00:15:00', 1),
(69, 1, '2024-02-23 00:15:00', 1),
(70, 1, '2024-02-24 00:15:00', 1),
(71, 1, '2024-02-25 00:15:00', 1),
(72, 1, '2024-02-26 00:15:00', 1),
(73, 1, '2024-02-27 00:15:00', 1),
(74, 1, '2024-02-28 00:15:00', 1),
(75, 1, '2024-02-29 00:15:00', 1),
(76, 1, '2024-03-01 00:15:00', 1),
(77, 1, '2024-03-02 00:15:00', 1),
(78, 1, '2024-03-03 00:15:00', 1),
(79, 1, '2024-03-04 00:15:00', 1),
(80, 1, '2024-03-05 00:15:00', 1),
(81, 1, '2024-03-06 00:15:00', 1),
(82, 1, '2024-03-07 00:15:00', 1),
(83, 1, '2024-03-08 00:15:00', 1),
(84, 1, '2024-03-09 00:15:00', 1),
(85, 1, '2024-03-10 00:15:00', 1),
(86, 1, '2024-03-11 00:15:00', 1),
(87, 1, '2024-03-12 00:15:00', 1),
(88, 1, '2024-03-13 00:15:00', 1),
(89, 1, '2024-03-14 00:15:00', 1),
(90, 1, '2024-03-15 00:15:00', 1),
(91, 1, '2024-03-16 00:15:00', 1),
(92, 1, '2024-03-17 00:15:00', 1),
(93, 1, '2024-03-18 00:15:00', 1),
(94, 1, '2024-03-19 00:15:00', 1),
(95, 1, '2024-03-20 00:15:00', 1),
(96, 1, '2024-03-21 00:15:00', 1),
(97, 1, '2024-03-22 00:15:00', 1),
(98, 1, '2024-03-23 00:15:00', 1),
(99, 1, '2024-03-24 00:15:00', 1),
(100, 1, '2024-03-25 00:15:00', 1),
(101, 1, '2024-03-26 00:15:00', 1),
(102, 1, '2024-03-27 00:15:00', 1),
(103, 1, '2024-03-28 00:15:00', 1),
(104, 1, '2024-03-29 00:15:00', 1),
(105, 1, '2024-03-30 00:15:00', 1),
(106, 1, '2024-03-31 00:15:00', 1),
(107, 1, '2024-04-01 00:15:00', 1),
(108, 1, '2024-04-02 00:15:00', 1),
(109, 1, '2024-04-03 00:15:00', 1),
(110, 1, '2024-04-04 00:15:00', 1),
(111, 1, '2024-04-05 00:15:00', 1),
(112, 1, '2024-04-06 00:15:00', 1),
(113, 1, '2024-04-07 00:15:00', 1),
(114, 1, '2024-04-08 00:15:00', 1),
(115, 1, '2024-04-09 00:15:00', 1),
(116, 1, '2024-04-10 00:15:00', 1),
(117, 1, '2024-04-11 00:15:00', 1),
(118, 1, '2024-04-12 00:15:00', 1),
(119, 1, '2024-04-13 00:15:00', 1),
(120, 1, '2024-04-14 00:15:00', 1),
(121, 1, '2024-04-15 00:15:00', 1),
(122, 1, '2024-04-16 00:15:00', 1),
(123, 1, '2024-04-17 00:15:00', 1),
(124, 1, '2024-04-18 00:15:00', 1),
(125, 1, '2024-04-19 00:15:00', 1),
(126, 1, '2024-04-20 00:15:00', 1),
(127, 1, '2024-04-21 00:15:00', 1),
(128, 1, '2024-04-22 00:15:00', 1),
(129, 1, '2024-04-23 00:15:00', 1),
(130, 1, '2024-04-24 00:15:00', 1),
(131, 1, '2024-04-25 00:15:00', 1),
(132, 1, '2024-04-26 00:15:00', 1),
(133, 1, '2024-04-27 00:15:00', 1),
(134, 1, '2024-04-28 00:15:00', 1),
(135, 1, '2024-04-29 00:15:00', 1),
(136, 1, '2024-04-30 00:15:00', 1),
(137, 1, '2024-05-01 00:15:00', 1),
(138, 1, '2024-05-02 00:15:00', 1),
(139, 1, '2024-05-03 00:15:00', 1),
(140, 1, '2024-05-04 00:15:00', 1),
(141, 1, '2024-05-05 00:15:00', 1),
(142, 1, '2024-05-06 00:15:00', 1),
(143, 1, '2024-05-07 00:15:00', 1),
(144, 1, '2024-05-08 00:15:00', 1),
(145, 1, '2024-05-09 00:15:00', 1),
(146, 1, '2024-05-10 00:15:00', 1),
(147, 1, '2024-05-11 00:15:00', 1),
(148, 1, '2024-05-12 00:15:00', 1),
(149, 1, '2024-05-13 00:15:00', 1),
(150, 1, '2024-05-14 00:15:00', 1),
(151, 1, '2024-05-15 00:15:00', 1),
(152, 1, '2024-05-16 00:15:00', 1),
(153, 1, '2024-05-17 00:15:00', 1),
(154, 1, '2024-05-18 00:15:00', 1),
(155, 1, '2024-05-19 00:15:00', 1),
(156, 1, '2024-05-20 00:15:00', 1),
(157, 1, '2024-05-21 00:15:00', 1),
(158, 1, '2024-05-22 00:15:00', 1),
(159, 1, '2024-05-23 00:15:00', 1),
(160, 1, '2024-05-24 00:15:00', 1),
(161, 1, '2024-05-25 00:15:00', 1),
(162, 1, '2024-05-26 00:15:00', 1),
(163, 1, '2024-05-27 00:15:00', 1),
(164, 1, '2024-05-28 00:15:00', 1),
(165, 1, '2024-05-29 00:15:00', 1),
(166, 1, '2024-05-30 00:15:00', 1),
(167, 1, '2024-05-31 00:15:00', 1),
(168, 1, '2024-06-01 00:15:00', 1),
(169, 1, '2024-06-02 00:15:00', 1),
(170, 1, '2024-06-03 00:15:00', 1),
(171, 1, '2024-06-04 00:15:00', 1),
(172, 1, '2024-06-05 00:15:00', 1),
(173, 1, '2024-06-06 00:15:00', 1),
(174, 1, '2024-06-07 00:15:00', 1),
(175, 1, '2024-06-08 00:15:00', 1),
(176, 1, '2024-06-09 00:15:00', 1),
(177, 1, '2024-06-10 00:15:00', 1),
(178, 1, '2024-06-11 00:15:00', 1),
(179, 1, '2024-06-12 00:15:00', 1),
(180, 1, '2024-06-13 00:15:00', 1),
(181, 1, '2024-06-14 00:15:00', 1),
(182, 1, '2024-06-15 00:15:00', 1),
(183, 1, '2024-06-16 00:15:00', 1),
(184, 1, '2024-06-17 00:15:00', 1),
(185, 1, '2024-06-18 00:15:00', 1),
(186, 1, '2024-06-19 00:15:00', 1),
(187, 1, '2024-06-20 00:15:00', 1),
(188, 1, '2024-06-21 00:15:00', 1),
(189, 1, '2024-06-22 00:15:00', 1),
(190, 1, '2024-06-23 00:15:00', 1),
(191, 1, '2024-06-24 00:15:00', 1),
(192, 1, '2024-06-25 00:15:00', 1),
(193, 1, '2024-06-26 00:15:00', 1),
(194, 1, '2024-06-27 00:15:00', 1),
(195, 1, '2024-06-28 00:15:00', 1),
(196, 1, '2024-06-29 00:15:00', 1),
(197, 1, '2024-06-30 00:15:00', 1),
(198, 1, '2024-07-01 00:15:00', 1),
(199, 1, '2024-07-02 00:15:00', 1),
(200, 1, '2024-07-03 00:15:00', 1),
(201, 1, '2024-07-04 00:15:00', 1),
(202, 1, '2024-07-05 00:15:00', 1),
(203, 1, '2024-07-06 00:15:00', 1),
(204, 1, '2024-07-07 00:15:00', 1),
(205, 1, '2024-07-08 00:15:00', 1),
(206, 1, '2024-07-09 00:15:00', 1),
(207, 1, '2024-07-10 00:15:00', 1),
(208, 1, '2024-07-11 00:15:00', 1),
(209, 1, '2024-07-12 00:15:00', 1),
(210, 1, '2024-07-13 00:15:00', 1),
(211, 1, '2024-07-14 00:15:00', 1),
(212, 1, '2024-07-15 00:15:00', 1),
(213, 1, '2024-07-16 00:15:00', 1),
(214, 1, '2024-07-17 00:15:00', 1),
(215, 1, '2024-07-18 00:15:00', 1),
(216, 1, '2024-07-19 00:15:00', 1),
(217, 1, '2024-07-20 00:15:00', 1),
(218, 1, '2024-07-21 00:15:00', 1),
(219, 1, '2024-07-22 00:15:00', 1),
(220, 1, '2024-07-23 00:15:00', 1),
(221, 1, '2024-07-24 00:15:00', 1),
(222, 1, '2024-07-25 00:15:00', 1),
(223, 1, '2024-07-26 00:15:00', 1),
(224, 1, '2024-07-27 00:15:00', 1),
(225, 1, '2024-07-28 00:15:00', 1),
(226, 1, '2024-07-29 00:15:00', 1),
(227, 1, '2024-07-30 00:15:00', 1),
(228, 1, '2024-07-31 00:15:00', 1),
(229, 1, '2024-08-01 00:15:00', 1),
(230, 1, '2024-08-02 00:15:00', 1),
(231, 1, '2024-08-03 00:15:00', 1),
(232, 1, '2024-08-04 00:15:00', 1),
(233, 1, '2024-08-05 00:15:00', 1),
(234, 1, '2024-08-06 00:15:00', 1),
(235, 1, '2024-08-07 00:15:00', 1),
(236, 1, '2024-08-08 00:15:00', 1),
(237, 1, '2024-08-09 00:15:00', 1),
(238, 1, '2024-08-10 00:15:00', 1),
(239, 1, '2024-08-11 00:15:00', 1),
(240, 1, '2024-08-12 00:15:00', 1),
(241, 1, '2024-08-13 00:15:00', 1),
(242, 1, '2024-08-14 00:15:00', 1),
(243, 1, '2024-08-15 00:15:00', 1),
(244, 1, '2024-08-16 00:15:00', 1),
(245, 1, '2024-08-17 00:15:00', 1),
(246, 1, '2024-08-18 00:15:00', 1),
(247, 1, '2024-08-19 00:15:00', 1),
(248, 1, '2024-08-20 00:15:00', 1),
(249, 1, '2024-08-21 00:15:00', 1),
(250, 1, '2024-08-22 00:15:00', 1),
(251, 1, '2024-08-23 00:15:00', 1),
(252, 1, '2024-08-24 00:15:00', 1),
(253, 1, '2024-08-25 00:15:00', 1),
(254, 1, '2024-08-26 00:15:00', 1),
(255, 1, '2024-08-27 00:15:00', 1),
(256, 1, '2024-08-28 00:15:00', 1),
(257, 1, '2024-08-29 00:15:00', 1),
(258, 1, '2024-08-30 00:15:00', 1),
(259, 1, '2024-08-31 00:15:00', 1),
(260, 1, '2024-09-01 00:15:00', 1),
(261, 1, '2024-09-02 00:15:00', 1),
(262, 1, '2024-09-03 00:15:00', 1),
(263, 1, '2024-09-04 00:15:00', 1),
(264, 1, '2024-09-05 00:15:00', 1),
(265, 1, '2024-09-06 00:15:00', 1),
(266, 1, '2024-09-07 00:15:00', 1),
(267, 1, '2024-09-08 00:15:00', 1),
(268, 1, '2024-09-09 00:15:00', 1),
(269, 1, '2024-09-10 00:15:00', 1),
(270, 1, '2024-09-11 00:15:00', 1),
(271, 1, '2024-09-12 00:15:00', 1),
(272, 1, '2024-09-13 00:15:00', 1),
(273, 1, '2024-09-14 00:15:00', 1),
(274, 1, '2024-09-15 00:15:00', 1),
(275, 1, '2024-09-16 00:15:00', 1),
(276, 1, '2024-09-17 00:15:00', 1),
(277, 1, '2024-09-18 00:15:00', 1),
(278, 1, '2024-09-19 00:15:00', 1),
(279, 1, '2024-09-20 00:15:00', 1),
(280, 1, '2024-09-21 00:15:00', 1),
(281, 1, '2024-09-22 00:15:00', 1),
(282, 1, '2024-09-23 00:15:00', 1),
(283, 1, '2024-09-24 00:15:00', 1),
(284, 1, '2024-09-25 00:15:00', 1),
(285, 1, '2024-09-26 00:15:00', 1),
(286, 1, '2024-09-27 00:15:00', 1),
(287, 1, '2024-09-28 00:15:00', 1),
(288, 1, '2024-09-29 00:15:00', 1),
(289, 1, '2024-09-30 00:15:00', 1),
(290, 1, '2024-10-01 00:15:00', 1),
(291, 1, '2024-10-02 00:15:00', 1),
(292, 1, '2024-10-03 00:15:00', 1),
(293, 1, '2024-10-04 00:15:00', 1),
(294, 1, '2024-10-05 00:15:00', 1),
(295, 1, '2024-10-06 00:15:00', 1),
(296, 1, '2024-10-07 00:15:00', 1),
(297, 1, '2024-10-08 00:15:00', 1),
(298, 1, '2024-10-09 00:15:00', 1),
(299, 1, '2024-10-10 00:15:00', 1),
(300, 1, '2024-10-11 00:15:00', 1),
(301, 1, '2024-10-12 00:15:00', 1),
(302, 1, '2024-10-13 00:15:00', 1),
(303, 1, '2024-10-14 00:15:00', 1),
(304, 1, '2024-10-15 00:15:00', 1),
(305, 1, '2024-10-16 00:15:00', 1),
(306, 1, '2024-10-17 00:15:00', 1),
(307, 1, '2024-10-18 00:15:00', 1),
(308, 1, '2024-10-19 00:15:00', 1),
(309, 1, '2024-10-20 00:15:00', 1),
(310, 1, '2024-10-21 00:15:00', 1),
(311, 1, '2024-10-22 00:15:00', 1),
(312, 1, '2024-10-23 00:15:00', 1),
(313, 1, '2024-10-24 00:15:00', 1),
(314, 1, '2024-10-25 00:15:00', 1),
(315, 1, '2024-10-26 00:15:00', 1),
(316, 1, '2024-10-27 00:15:00', 1),
(317, 1, '2024-10-28 00:15:00', 1),
(318, 1, '2024-10-29 00:15:00', 1),
(319, 1, '2024-10-30 00:15:00', 1),
(320, 1, '2024-10-31 00:15:00', 1),
(321, 1, '2024-11-01 00:15:00', 1),
(322, 1, '2024-11-02 00:15:00', 1),
(323, 1, '2024-11-03 00:15:00', 1),
(324, 1, '2024-11-04 00:15:00', 1),
(325, 1, '2024-11-05 00:15:00', 1),
(326, 1, '2024-11-06 00:15:00', 1),
(327, 1, '2024-11-07 00:15:00', 1),
(328, 1, '2024-11-08 00:15:00', 1),
(329, 1, '2024-11-09 00:15:00', 1),
(330, 1, '2024-11-10 00:15:00', 1),
(331, 1, '2024-11-11 00:15:00', 1),
(332, 1, '2024-11-12 00:15:00', 1),
(333, 1, '2024-11-13 00:15:00', 1),
(334, 1, '2024-11-14 00:15:00', 1),
(335, 1, '2024-11-15 00:15:00', 1),
(336, 1, '2024-11-16 00:15:00', 1),
(337, 1, '2024-11-17 00:15:00', 1),
(338, 1, '2024-11-18 00:15:00', 1),
(339, 1, '2024-11-19 00:15:00', 1),
(340, 1, '2024-11-20 00:15:00', 1),
(341, 1, '2024-11-21 00:15:00', 1),
(342, 1, '2024-11-22 00:15:00', 1),
(343, 1, '2024-11-23 00:15:00', 1),
(344, 1, '2024-11-24 00:15:00', 1),
(345, 1, '2024-11-25 00:15:00', 1),
(346, 1, '2024-11-26 00:15:00', 1),
(347, 1, '2024-11-27 00:15:00', 1),
(348, 1, '2024-11-28 00:15:00', 1),
(349, 1, '2024-11-29 00:15:00', 1),
(350, 1, '2024-11-30 00:15:00', 1),
(351, 1, '2024-12-01 00:15:00', 1),
(352, 1, '2024-12-02 00:15:00', 1),
(353, 1, '2024-12-03 00:15:00', 1),
(354, 1, '2024-12-04 00:15:00', 1),
(355, 1, '2024-12-05 00:15:00', 1),
(356, 1, '2024-12-06 00:15:00', 1),
(357, 1, '2024-12-07 00:15:00', 1),
(358, 1, '2024-12-08 00:15:00', 1),
(359, 1, '2024-12-09 00:15:00', 1),
(360, 1, '2024-12-10 00:15:00', 1),
(361, 1, '2024-12-11 00:15:00', 1),
(362, 1, '2024-12-12 00:15:00', 1),
(363, 1, '2024-12-13 00:15:00', 1),
(364, 1, '2024-12-14 00:15:00', 1),
(365, 1, '2024-12-15 00:15:00', 1),
(366, 1, '2024-12-16 00:15:00', 1),
(367, 1, '2024-12-17 00:15:00', 1),
(368, 1, '2024-12-18 00:15:00', 1),
(369, 1, '2024-12-19 00:15:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_laporan`
--

CREATE TABLE `detail_laporan` (
  `id_detail_laporan` int NOT NULL,
  `id_detprod` int NOT NULL,
  `quantity` int NOT NULL,
  `status_in_out` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_in_out` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_laporan`
--

INSERT INTO `detail_laporan` (`id_detail_laporan`, `id_detprod`, `quantity`, `status_in_out`, `tanggal_in_out`) VALUES
(4, 15, 200, 'In', '2024-12-08 17:00:00'),
(5, 1, 5, 'In', '2024-12-08 21:51:24'),
(6, 1, 5, 'Out', '2024-12-08 21:52:03'),
(7, 16, 100, 'In', '2024-12-08 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_produk`
--

CREATE TABLE `detail_produk` (
  `id_detprod` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_ukuran` int NOT NULL,
  `stok_toko` int NOT NULL,
  `stok_gudang` int NOT NULL,
  `status_aktif` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_produk`
--

INSERT INTO `detail_produk` (`id_detprod`, `id_barang`, `id_ukuran`, `stok_toko`, `stok_gudang`, `status_aktif`) VALUES
(1, 1, 1, 1005, 1996, 1),
(2, 1, 2, 2000, 2500, 1),
(3, 1, 3, 1000, 4000, 1),
(4, 2, 1, 1498, 5000, 1),
(5, 2, 2, 1000, 3000, 1),
(6, 2, 3, 2000, 2000, 1),
(7, 3, 1, 1500, 5000, 1),
(8, 3, 2, 3000, 3000, 1),
(9, 3, 3, 1000, 2500, 1),
(10, 4, 1, 1500, 5000, 1),
(11, 4, 2, 1300, 3500, 1),
(12, 4, 3, 2000, 2000, 1),
(14, 6, 2, 0, 100, 1),
(15, 7, 1, 0, 200, 1),
(16, 8, 1, 0, 98, 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_detprod` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` int NOT NULL,
  `id_transaksi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_detprod`, `jumlah`, `subtotal`, `id_transaksi`) VALUES
(1, 1, 5, 1000000, 1),
(2, 6, 4, 1200000, 1),
(3, 6, 5, 1500000, 2),
(4, 10, 3, 450000, 2),
(5, 5, 12, 3600000, 3),
(6, 10, 20, 3000000, 4),
(7, 7, 30, 7500000, 5),
(8, 6, 5, 1500000, 6),
(9, 1, 10, 2000000, 6),
(10, 10, 10, 1500000, 6),
(11, 1, 5, 1000000, 7),
(12, 6, 4, 1200000, 7),
(13, 6, 5, 1500000, 8),
(14, 10, 3, 450000, 8),
(15, 5, 12, 3600000, 9),
(16, 10, 20, 3000000, 10),
(17, 7, 30, 7500000, 11),
(18, 6, 5, 1500000, 12),
(19, 1, 10, 2000000, 12),
(20, 10, 10, 1500000, 12),
(21, 1, 4, 1000000, 13),
(22, 16, 2, 40000, 13),
(23, 4, 2, 600000, 14);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `kode_karyawan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_telepon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gaji` int NOT NULL,
  `periode_terakhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `kode_karyawan`, `nama`, `nomor_telepon`, `start_date`, `jabatan`, `gaji`, `periode_terakhir`) VALUES
(1, 'K001', 'Bang Krisna', '0812345678', '2023-12-17 07:04:17', 'kasir', 3500000, '2024-12-19'),
(2, 'P002', 'Abdul', '0812987654', '2022-11-19 17:00:00', 'pemilik', 7000000, NULL),
(3, 'PG003', 'Matthew', '0821123456', '2024-12-19 07:15:04', 'penjaga gudang', 3000000, '2024-12-19'),
(4, 'K004', 'Roosevelt', '0819234567', '2024-12-19 07:04:17', 'kasir', 3000000, '2024-12-19'),
(5, 'P005', 'Korban Vanry', '0818123456', '2023-03-24 17:00:00', 'pemilik', 5500000, NULL),
(6, 'PG006', 'Yonatan', '0821456789', '2024-12-19 07:04:17', 'penjaga gudang', 3000000, '2024-12-19'),
(7, 'K007', 'Andika', '0813345678', '2024-12-19 07:04:17', 'kasir', 3000000, '2024-12-19'),
(8, 'P008', 'Ben', '0815123456', '2023-07-19 17:00:00', 'pemilik', 5100000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_telepon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `nomor_telepon`, `alamat`) VALUES
(1, 'Kiana', '', ''),
(2, 'Ari', '081233547688', 'Jl. A.Yani no.19 Surabaya'),
(3, 'Brone', '08224356789', 'Jl. Pahlawan No.3 Surabaya'),
(4, 'Handi', '', ''),
(5, 'Jason', '', ''),
(6, 'Pina', '082245888755', 'Jl. Manyar no.10 Surabaya'),
(7, 'Kira', '', ''),
(8, 'Arya', '081287747698', 'Jl. A.Yani no.17 Surabaya'),
(9, 'Charles', '08224356555', 'Jl. Pahlawan No.39 Surabaya'),
(10, 'Hoya', '', ''),
(11, 'Jia', '', ''),
(12, 'Laura', '082245456212', 'Jl. Kertajaya no.11 Surabaya'),
(13, 'memet', '081234556788', 'Blok F, Jl. Siwalankerto Permai II No.17, Siwalankerto'),
(14, 'memet1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_barang` int NOT NULL,
  `kode_barang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int DEFAULT NULL,
  `status_aktif` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_barang`, `kode_barang`, `harga`, `status_aktif`) VALUES
(1, 'TW001', 250000, 1),
(2, 'TM001', 300000, 1),
(3, 'BW001', 250000, 1),
(4, 'BM001', 150000, 1),
(6, 'memet', 10000, 1),
(7, 'memet1', 10000, 1),
(8, 'abc1', 20000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_harga`
--

CREATE TABLE `riwayat_harga` (
  `id_rharga` int NOT NULL,
  `id_barang` int NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perubahan_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_harga`
--

INSERT INTO `riwayat_harga` (`id_rharga`, `id_barang`, `tanggal`, `perubahan_harga`) VALUES
(2, 1, '2024-12-09 03:56:08', 250000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `kategori_penjualan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_total` int NOT NULL,
  `status_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'selesai',
  `tanggal_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `kategori_penjualan`, `harga_total`, `status_transaksi`, `tanggal_transaksi`) VALUES
(1, 1, 'retail', 2200000, 'selesai', '2024-11-02 05:03:24'),
(2, 2, 'PO', 1950000, 'selesai', '2024-11-02 10:00:00'),
(3, 3, 'PO', 3600000, 'selesai', '2024-11-03 05:07:32'),
(4, 4, 'retail', 3000000, 'selesai', '2024-11-05 05:11:18'),
(5, 5, 'retail', 7500000, 'selesai', '2024-11-06 05:11:59'),
(6, 6, 'PO', 5000000, 'selesai', '2024-11-08 05:13:44'),
(7, 7, 'retail', 2200000, 'selesai', '2024-12-02 05:03:24'),
(8, 8, 'PO', 1950000, 'selesai', '2024-12-02 10:00:00'),
(9, 9, 'PO', 3600000, 'selesai', '2024-12-03 05:07:32'),
(10, 10, 'retail', 3000000, 'selesai', '2024-12-05 05:11:18'),
(11, 11, 'retail', 7500000, 'selesai', '2024-12-06 05:11:59'),
(12, 12, 'PO', 5000000, 'selesai', '2024-12-08 05:13:44'),
(13, 13, 'PO', 1040000, 'selesai', '2024-12-09 03:58:07'),
(14, 14, 'retail', 600000, 'selesai', '2024-12-09 03:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `id_ukuran` int NOT NULL,
  `ukuran` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_aktif` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`id_ukuran`, `ukuran`, `status_aktif`) VALUES
(1, 'S', 1),
(2, 'M', 1),
(3, 'L', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `fk_id_karyawan` (`id_karyawan`);

--
-- Indexes for table `detail_laporan`
--
ALTER TABLE `detail_laporan`
  ADD PRIMARY KEY (`id_detail_laporan`),
  ADD KEY `fk_detprod_laporan` (`id_detprod`);

--
-- Indexes for table `detail_produk`
--
ALTER TABLE `detail_produk`
  ADD PRIMARY KEY (`id_detprod`),
  ADD KEY `fk_barang` (`id_barang`),
  ADD KEY `fk_ukuran` (`id_ukuran`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_transaksi` (`id_transaksi`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `riwayat_harga`
--
ALTER TABLE `riwayat_harga`
  ADD PRIMARY KEY (`id_rharga`),
  ADD KEY `fk_barang_riwayat` (`id_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id_ukuran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT for table `detail_laporan`
--
ALTER TABLE `detail_laporan`
  MODIFY `id_detail_laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_produk`
--
ALTER TABLE `detail_produk`
  MODIFY `id_detprod` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `riwayat_harga`
--
ALTER TABLE `riwayat_harga`
  MODIFY `id_rharga` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id_ukuran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_id_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_laporan`
--
ALTER TABLE `detail_laporan`
  ADD CONSTRAINT `fk_detprod_laporan` FOREIGN KEY (`id_detprod`) REFERENCES `detail_produk` (`id_detprod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_produk`
--
ALTER TABLE `detail_produk`
  ADD CONSTRAINT `fk_barang` FOREIGN KEY (`id_barang`) REFERENCES `produk` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ukuran` FOREIGN KEY (`id_ukuran`) REFERENCES `ukuran` (`id_ukuran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `fk_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_harga`
--
ALTER TABLE `riwayat_harga`
  ADD CONSTRAINT `fk_barang_riwayat` FOREIGN KEY (`id_barang`) REFERENCES `produk` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
