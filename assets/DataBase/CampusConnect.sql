-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 11:29 AM
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
-- Database: `campus_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `Id` int(11) NOT NULL,
  `blockName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`Id`, `blockName`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Id` int(11) NOT NULL,
  `Content` text NOT NULL,
  `UserId` varchar(255) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Datetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Id`, `Content`, `UserId`, `PostId`, `Datetime`) VALUES
(1, 'I found your phone in the library, I will keep it safe for you!', '202332151106', 1, '2024-12-12 11:24:07'),
(2, 'Thank you for finding my wallet, I will come pick it up.', '202332151106', 2, '2024-12-12 11:24:07');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `day`) VALUES
(6, 'Friday'),
(2, 'Monday'),
(7, 'Saturday'),
(1, 'Sunday'),
(5, 'Thursday'),
(3, 'Tuesday'),
(4, 'Wednesday');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Id` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  'Phone' varchar(50) ,
  `Role` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `img_path` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Id`, `firstName`, `lastName`, `Email`, `Role`, `Password`, `img_path`) VALUES
('232337139801', 'abdelhak', 'kadouci', 'abdelhak.kadouci@ensia.edu.dz', 'Admin', 'managerpassword123', 'assets/img/hako.png');

-- --------------------------------------------------------

--
-- Table structure for table `floor`
--

CREATE TABLE `floor` (
  `Id` int(11) NOT NULL,
  `FloorNumber` int(11) NOT NULL,
  `BlockID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `floor`
--

INSERT INTO `floor` (`Id`, `FloorNumber`, `BlockID`) VALUES
(1, 0, 1),
(2, 1, 1),
(3, 2, 1),
(4, 3, 1),
(5, 4, 1),
(6, 5, 1),
(7, 0, 2),
(8, 1, 2),
(9, 2, 2),
(10, 3, 2),
(11, 4, 2),
(12, 5, 2),
(13, 0, 3),
(14, 1, 3),
(15, 2, 3),
(16, 3, 3),
(17, 4, 3),
(18, 5, 3),
(19, 0, 4),
(20, 1, 4),
(21, 2, 4),
(22, 3, 4),
(23, 4, 4),
(24, 0, 5),
(25, 1, 5),
(26, 2, 5),
(27, 3, 5),
(28, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `Id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `urgency` varchar(50) NOT NULL,
  `duplicated` tinyint(1) NOT NULL,
  `studentId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lostandfoundpost`
--

CREATE TABLE `lostandfoundpost` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `UserId` varchar(255) NOT NULL,
  `Datetime` datetime DEFAULT current_timestamp(),
  `Type` varchar(50) NOT NULL,
  `post_img` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lostandfoundpost`
--

INSERT INTO `lostandfoundpost` (`Id`, `Title`, `Content`, `UserId`, `Datetime`, `Type`, `post_img`) VALUES
(1, 'Lost Phone', 'I have lost my phone in the library. Please contact me if found.', '202332151106', '2024-12-12 11:23:18', 'Lost', 'assets/img/ex1.png'),
(2, 'Found Wallet', 'A wallet was found near the cafeteria. Please reach out to claim it.', '202332151106', '2024-12-12 11:23:18', 'Found', 'assets/img/ex2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `meal` varchar(100) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `dayid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal`, `amount`, `dayid`, `typeid`) VALUES
(70, 'milk', '1', 1, 1),
(71, 'croissant', '1', 1, 1),
(72, 'milk', '1', 2, 1),
(73, 'Petit Pain', '1', 2, 1),
(74, 'milk', '1', 3, 1),
(75, 'Brioche', '1', 3, 1),
(76, 'milk', '1', 4, 1),
(77, 'Croissant', '1', 4, 1),
(78, 'milk', '1', 5, 1),
(79, 'brioche', '1', 5, 1),
(80, 'milk', '1', 6, 1),
(81, 'Petit Pain', '1', 6, 1),
(82, 'milk', '1', 7, 1),
(83, 'Brioche', '1', 7, 1),
(84, 'عدس', '100 g', 1, 2),
(85, 'egg', '2', 1, 2),
(86, 'Salade', '150 g', 1, 2),
(87, 'juice', '1', 1, 2),
(88, 'فاصولياء', '100 g', 2, 2),
(89, 'Meat', '150 g', 2, 2),
(90, 'Salade', '150g', 2, 2),
(91, 'ياوورت', '1', 2, 2),
(92, 'rice', '100 g', 3, 2),
(93, 'fish', '150 g', 3, 2),
(94, 'Soup', '1', 3, 2),
(95, 'Orange', '1', 3, 2),
(96, 'potato', '150 g', 4, 2),
(97, 'chicken', '200 g', 4, 2),
(98, 'salade', '150 g', 4, 2),
(99, 'ياوورت', '1', 4, 2),
(100, 'Spaghetti', '100 g', 5, 2),
(101, 'fish', '150 g', 5, 2),
(102, 'حساء', '1', 5, 2),
(103, 'Oragne', '1', 5, 2),
(104, 'عدس', '150 g', 6, 2),
(105, 'egg', '2', 6, 2),
(106, 'salade', '150 g', 6, 2),
(107, 'ياوورت', '1', 6, 2),
(108, 'Pasta', '100 g', 7, 2),
(109, 'kachir', '100 g', 7, 2),
(110, 'Salade', '150 g', 7, 2),
(111, 'ياوورت', '1', 7, 2),
(112, 'حساء', '1', 1, 3),
(113, 'potato', '150 g', 1, 3),
(114, 'Chicken', '200 g', 1, 3),
(115, 'ياوورت', '1', 1, 3),
(116, 'حساء', '1', 2, 3),
(117, 'مثوم', '150 g', 2, 3),
(118, 'Salade', '150g', 2, 3),
(119, 'ياوورت', '1', 2, 3),
(120, 'Potato', '150 g', 3, 3),
(121, 'حساء', '1', 3, 3),
(122, 'Salade', '150 g', 3, 3),
(123, 'Banana', '1', 3, 3),
(124, 'Tlitli', '100 g', 4, 3),
(125, 'chicken', '200 g', 4, 3),
(126, 'salade', '150 g', 4, 3),
(127, 'ياوورت', '1', 4, 3),
(128, 'كسكس', '100 g', 5, 3),
(129, 'chicken', '200 g', 5, 3),
(130, 'Salade', '150 g', 5, 3),
(131, 'Oragne', '1', 5, 3),
(132, 'دولمة', '150 g', 6, 3),
(133, 'salade', '150 g', 6, 3),
(134, 'Orange', '1', 6, 3),
(135, 'حساء', '1', 7, 3),
(136, 'شطيطحة', '150 g', 7, 3),
(137, 'Salade', '150 g', 7, 3),
(138, 'Apple', '1', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `mealtype`
--

CREATE TABLE `mealtype` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ;

--
-- Dumping data for table `mealtype`
--

INSERT INTO `mealtype` (`id`, `type`) VALUES
(1, 'Breakfast'),
(3, 'Dinner'),
(2, 'Lunch');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `Id` int(11) NOT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
  'File' varchar(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Id` int(11) NOT NULL,
  'blockid' int(11) NOT NULL,
  `FloorID` int(11) NOT NULL,
  `RoomNumber` int(11) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Id`,'blockid', `FloorID`, `RoomNumber`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 2, 1),
(22, 2, 2),
(23, 2, 3),
(24, 2, 4),
(25, 2, 5),
(26, 2, 6),
(27, 2, 7),
(28, 2, 8),
(29, 2, 9),
(30, 2, 10),
(31, 2, 11),
(32, 2, 12),
(33, 2, 13),
(34, 2, 14),
(35, 2, 15),
(36, 2, 16),
(37, 2, 17),
(38, 2, 18),
(39, 2, 19),
(40, 2, 20),
(41, 3, 1),
(42, 3, 2),
(43, 3, 3),
(44, 3, 4),
(45, 3, 5),
(46, 3, 6),
(47, 3, 7),
(48, 3, 8),
(49, 3, 9),
(50, 3, 10),
(51, 3, 11),
(52, 3, 12),
(53, 3, 13),
(54, 3, 14),
(55, 3, 15),
(56, 3, 16),
(57, 3, 17),
(58, 3, 18),
(59, 3, 19),
(60, 3, 20),
(61, 4, 1),
(62, 4, 2),
(63, 4, 3),
(64, 4, 4),
(65, 4, 5),
(66, 4, 6),
(67, 4, 7),
(68, 4, 8),
(69, 4, 9),
(70, 4, 10),
(71, 4, 11),
(72, 4, 12),
(73, 4, 13),
(74, 4, 14),
(75, 4, 15),
(76, 4, 16),
(77, 4, 17),
(78, 4, 18),
(79, 4, 19),
(80, 4, 20),
(81, 5, 1),
(82, 5, 2),
(83, 5, 3),
(84, 5, 4),
(85, 5, 5),
(86, 5, 6),
(87, 5, 7),
(88, 5, 8),
(89, 5, 9),
(90, 5, 10),
(91, 5, 11),
(92, 5, 12),
(93, 5, 13),
(94, 5, 14),
(95, 5, 15),
(96, 5, 16),
(97, 5, 17),
(98, 5, 18),
(99, 5, 19),
(100, 5, 20),
(101, 6, 1),
(102, 6, 2),
(103, 6, 3),
(104, 6, 4),
(105, 6, 5),
(106, 6, 6),
(107, 6, 7),
(108, 6, 8),
(109, 6, 9),
(110, 6, 10),
(111, 6, 11),
(112, 6, 12),
(113, 6, 13),
(114, 6, 14),
(115, 6, 15),
(116, 6, 16),
(117, 6, 17),
(118, 6, 18),
(119, 6, 19),
(120, 6, 20),
(121, 7, 1),
(122, 7, 2),
(123, 7, 3),
(124, 7, 4),
(125, 7, 5),
(126, 7, 6),
(127, 7, 7),
(128, 7, 8),
(129, 7, 9),
(130, 7, 10),
(131, 7, 11),
(132, 7, 12),
(133, 7, 13),
(134, 7, 14),
(135, 7, 15),
(136, 7, 16),
(137, 7, 17),
(138, 7, 18),
(139, 7, 19),
(140, 7, 20),
(141, 8, 1),
(142, 8, 2),
(143, 8, 3),
(144, 8, 4),
(145, 8, 5),
(146, 8, 6),
(147, 8, 7),
(148, 8, 8),
(149, 8, 9),
(150, 8, 10),
(151, 8, 11),
(152, 8, 12),
(153, 8, 13),
(154, 8, 14),
(155, 8, 15),
(156, 8, 16),
(157, 8, 17),
(158, 8, 18),
(159, 8, 19),
(160, 8, 20),
(161, 9, 1),
(162, 9, 2),
(163, 9, 3),
(164, 9, 4),
(165, 9, 5),
(166, 9, 6),
(167, 9, 7),
(168, 9, 8),
(169, 9, 9),
(170, 9, 10),
(171, 9, 11),
(172, 9, 12),
(173, 9, 13),
(174, 9, 14),
(175, 9, 15),
(176, 9, 16),
(177, 9, 17),
(178, 9, 18),
(179, 9, 19),
(180, 9, 20),
(181, 10, 1),
(182, 10, 2),
(183, 10, 3),
(184, 10, 4),
(185, 10, 5),
(186, 10, 6),
(187, 10, 7),
(188, 10, 8),
(189, 10, 9),
(190, 10, 10),
(191, 10, 11),
(192, 10, 12),
(193, 10, 13),
(194, 10, 14),
(195, 10, 15),
(196, 10, 16),
(197, 10, 17),
(198, 10, 18),
(199, 10, 19),
(200, 10, 20),
(201, 11, 1),
(202, 11, 2),
(203, 11, 3),
(204, 11, 4),
(205, 11, 5),
(206, 11, 6),
(207, 11, 7),
(208, 11, 8),
(209, 11, 9),
(210, 11, 10),
(211, 11, 11),
(212, 11, 12),
(213, 11, 13),
(214, 11, 14),
(215, 11, 15),
(216, 11, 16),
(217, 11, 17),
(218, 11, 18),
(219, 11, 19),
(220, 11, 20),
(221, 12, 1),
(222, 12, 2),
(223, 12, 3),
(224, 12, 4),
(225, 12, 5),
(226, 12, 6),
(227, 12, 7),
(228, 12, 8),
(229, 12, 9),
(230, 12, 10),
(231, 12, 11),
(232, 12, 12),
(233, 12, 13),
(234, 12, 14),
(235, 12, 15),
(236, 12, 16),
(237, 12, 17),
(238, 12, 18),
(239, 12, 19),
(240, 12, 20),
(241, 13, 1),
(242, 13, 2),
(243, 13, 3),
(244, 13, 4),
(245, 13, 5),
(246, 13, 6),
(247, 13, 7),
(248, 13, 8),
(249, 13, 9),
(250, 13, 10),
(251, 13, 11),
(252, 13, 12),
(253, 13, 13),
(254, 13, 14),
(255, 13, 15),
(256, 13, 16),
(257, 13, 17),
(258, 13, 18),
(259, 13, 19),
(260, 13, 20),
(261, 14, 1),
(262, 14, 2),
(263, 14, 3),
(264, 14, 4),
(265, 14, 5),
(266, 14, 6),
(267, 14, 7),
(268, 14, 8),
(269, 14, 9),
(270, 14, 10),
(271, 14, 11),
(272, 14, 12),
(273, 14, 13),
(274, 14, 14),
(275, 14, 15),
(276, 14, 16),
(277, 14, 17),
(278, 14, 18),
(279, 14, 19),
(280, 14, 20),
(281, 15, 1),
(282, 15, 2),
(283, 15, 3),
(284, 15, 4),
(285, 15, 5),
(286, 15, 6),
(287, 15, 7),
(288, 15, 8),
(289, 15, 9),
(290, 15, 10),
(291, 15, 11),
(292, 15, 12),
(293, 15, 13),
(294, 15, 14),
(295, 15, 15),
(296, 15, 16),
(297, 15, 17),
(298, 15, 18),
(299, 15, 19),
(300, 15, 20),
(301, 16, 1),
(302, 16, 2),
(303, 16, 3),
(304, 16, 4),
(305, 16, 5),
(306, 16, 6),
(307, 16, 7),
(308, 16, 8),
(309, 16, 9),
(310, 16, 10),
(311, 16, 11),
(312, 16, 12),
(313, 16, 13),
(314, 16, 14),
(315, 16, 15),
(316, 16, 16),
(317, 16, 17),
(318, 16, 18),
(319, 16, 19),
(320, 16, 20),
(321, 17, 1),
(322, 17, 2),
(323, 17, 3),
(324, 17, 4),
(325, 17, 5),
(326, 17, 6),
(327, 17, 7),
(328, 17, 8),
(329, 17, 9),
(330, 17, 10),
(331, 17, 11),
(332, 17, 12),
(333, 17, 13),
(334, 17, 14),
(335, 17, 15),
(336, 17, 16),
(337, 17, 17),
(338, 17, 18),
(339, 17, 19),
(340, 17, 20),
(341, 18, 1),
(342, 18, 2),
(343, 18, 3),
(344, 18, 4),
(345, 18, 5),
(346, 18, 6),
(347, 18, 7),
(348, 18, 8),
(349, 18, 9),
(350, 18, 10),
(351, 18, 11),
(352, 18, 12),
(353, 18, 13),
(354, 18, 14),
(355, 18, 15),
(356, 18, 16),
(357, 18, 17),
(358, 18, 18),
(359, 18, 19),
(360, 18, 20),
(361, 19, 1),
(362, 19, 2),
(363, 19, 3),
(364, 19, 4),
(365, 19, 5),
(366, 19, 6),
(367, 19, 7),
(368, 19, 8),
(369, 19, 9),
(370, 19, 10),
(371, 19, 11),
(372, 19, 12),
(373, 19, 13),
(374, 19, 14),
(375, 19, 15),
(376, 19, 16),
(377, 19, 17),
(378, 19, 18),
(379, 19, 19),
(380, 19, 20),
(381, 20, 1),
(382, 20, 2),
(383, 20, 3),
(384, 20, 4),
(385, 20, 5),
(386, 20, 6),
(387, 20, 7),
(388, 20, 8),
(389, 20, 9),
(390, 20, 10),
(391, 20, 11),
(392, 20, 12),
(393, 20, 13),
(394, 20, 14),
(395, 20, 15),
(396, 20, 16),
(397, 20, 17),
(398, 20, 18),
(399, 20, 19),
(400, 20, 20),
(401, 21, 1),
(402, 21, 2),
(403, 21, 3),
(404, 21, 4),
(405, 21, 5),
(406, 21, 6),
(407, 21, 7),
(408, 21, 8),
(409, 21, 9),
(410, 21, 10),
(411, 21, 11),
(412, 21, 12),
(413, 21, 13),
(414, 21, 14),
(415, 21, 15),
(416, 21, 16),
(417, 21, 17),
(418, 21, 18),
(419, 21, 19),
(420, 21, 20),
(421, 22, 1),
(422, 22, 2),
(423, 22, 3),
(424, 22, 4),
(425, 22, 5),
(426, 22, 6),
(427, 22, 7),
(428, 22, 8),
(429, 22, 9),
(430, 22, 10),
(431, 22, 11),
(432, 22, 12),
(433, 22, 13),
(434, 22, 14),
(435, 22, 15),
(436, 22, 16),
(437, 22, 17),
(438, 22, 18),
(439, 22, 19),
(440, 22, 20),
(441, 23, 1),
(442, 23, 2),
(443, 23, 3),
(444, 23, 4),
(445, 23, 5),
(446, 23, 6),
(447, 23, 7),
(448, 23, 8),
(449, 23, 9),
(450, 23, 10),
(451, 23, 11),
(452, 23, 12),
(453, 23, 13),
(454, 23, 14),
(455, 23, 15),
(456, 23, 16),
(457, 23, 17),
(458, 23, 18),
(459, 23, 19),
(460, 23, 20);

-- --------------------------------------------------------

--
-- Table structure for table `roomrequest`
--

CREATE TABLE `roomrequest` (
  `userId` varchar(255) NOT NULL,
  `roomId` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Id` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  'phone' varchar(50) NOT NULL,
  `roomId` int(11) DEFAULT NULL,
  `img_path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Id`, `firstName`, `lastName`, `Email`, `Password`, `roomId`, `img_path`) VALUES
('202332151106', 'cherif', 'taiebezzraimi', 'cherif.taiebezzraimi@ensia.edu.dz', 'password789', NULL, 'assets/img/omar.png'),
('202332151212', 'mohamed elhadi', 'bachir', 'mohamed.elhadi.bachir@ensia.edu.dz', 'password456', NULL, 'assets/img/haddi.png'),
('232337139801', 'abdelhak', 'kadouci', 'abdelhak.kadouci@ensia.edu.dz', 'password789', NULL, 'assets/img/hako.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `PostId` (`PostId`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day` (`day`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `floor`
--
ALTER TABLE `floor`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Floor_Block` (`BlockID`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `studentId` (`studentId`);

--
-- Indexes for table `lostandfoundpost`
--
ALTER TABLE `lostandfoundpost`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dayid` (`dayid`),
  ADD KEY `typeid` (`typeid`);

--
-- Indexes for table `mealtype`
--
ALTER TABLE `mealtype`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_Room_Floor` (`FloorID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `roomId` (`roomId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `floor`
--
ALTER TABLE `floor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lostandfoundpost`
--
ALTER TABLE `lostandfoundpost`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `mealtype`
--
ALTER TABLE `mealtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=461;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `student` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`PostId`) REFERENCES `lostandfoundpost` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `floor`
--
ALTER TABLE `floor`
  ADD CONSTRAINT `FK_Floor_Block` FOREIGN KEY (`BlockID`) REFERENCES `block` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `student` (`Id`) ON DELETE SET NULL;

--
-- Constraints for table `lostandfoundpost`
--
ALTER TABLE `lostandfoundpost`
  ADD CONSTRAINT `lostandfoundpost_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `student` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`dayid`) REFERENCES `days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meals_ibfk_2` FOREIGN KEY (`typeid`) REFERENCES `mealtype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `FK_Room_Floor` FOREIGN KEY (`FloorID`) REFERENCES `floor` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`roomId`) REFERENCES `room` (`Id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
