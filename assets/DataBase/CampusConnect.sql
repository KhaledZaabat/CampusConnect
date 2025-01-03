-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 02:09 PM
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
  `Role` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `img_path` varchar(1000) NOT NULL,
  `Phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Id`, `firstName`, `lastName`, `Email`, `Role`, `Password`, `img_path`, `Phone`) VALUES
('2', 'elhadi', 'bachir', 'bachir@hello.com', 'Chef', '$2y$10$2YhSd2rUifYhm5G/GbZwm.6O9SvWUb9sMwK7FSo7AH6iCNHt1hPpC', 'uploads/profile_pics/2_1735767837.png', '0542366870'),
('3', 'khaled', 'zaabat', 'khaled@gmail.com', 'Housing', '$2y$10$2RfbScZwLe9hGsjU.2zVa.avlaNmm5nretnk6r.GHJNyoszOKA3jS', 'uploads/profile_pics/3_1735780188.png', '0542366870'),
('4', 'moh', 'amed', 'moh@gmail.com', 'Maintenance', '$2y$10$bOTg34vp0PfUfr3frHMfmObf0O1hYQ0g4zwodZ/HpohBNgerLp29q', 'uploads/profile_pics/4_1735780226.png', '0542366870'),
('6', 'abdelhak', 'kadouci', 'abdel7ak.kadouci@ensia.edu.dz', 'Admin', '$2y$10$/LAdgdQBvRIfAG8oXvaCXeE21WVdvRGKVjKibjkwqd4hzreJn9C5m', 'uploads/profile_pics/1_1735755022.png', '0542366870');

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
  `img` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Date` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `FILE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`Id`, `Date`, `title`, `content`, `FILE`) VALUES
(255, '2024-12-28 18:03:15', 'hello', 'helllolllllllllllllllllllll', NULL),
(258, '2024-12-28 18:18:40', 'ss', '<i><u><font color=\"#d13d3d\">he</font></u></i><b><font color=\"#d13d3d\">lllllo</font></b>', NULL),
(262, '2024-12-28 19:04:35', 'hello', '<table class=\"styled-table\" style=\"width: 100%;\"><tr><th>Header 1</th><th>Header 2</th></tr><tr><td>Cell 2,1</td><td>Cell 2,2</td></tr></table>', NULL),
(272, '2024-12-28 22:10:47', 'hello', 'hello', 'uploads/dsa-HOMEWORK.pdf'),
(273, '2024-12-28 22:39:19', 'I BOUGHT 100 CRAZY AMAZON ELEMENTS !!!!', '<b>GOOD MORNING</b> <font color=\"#f50000\"><b>SUN</b></font> AND <font color=\"#0031f5\"><b>CHINING</b></font> , <b>GOOD MORNING</b> <b><u><font color=\"#d800f5\">ANAZALA</font></u></b> <b><u>FAMILLYYYYYYYYYYYYYYYYYYY</u></b> .&nbsp;<br><br><font color=\"#6b5400\">GOOD MORNING GUYS THIS IS TIK TOK VIDEO&nbsp; ,</font><div><font color=\"#6b5400\"><br></font></div><div><font color=\"#6b5400\"><b>ATTACHED THE LINK PLEASE :</b></font></div><div><b style=\"\"><a href=\"https://www.youtube.com/watch?v=Bv1bzGEZxgE\" style=\"\"><font color=\"#000000\">https://www.youtube.com/watch?v=Bv1bzGEZxgE</font></a></b></div><div><font color=\"#6b5400\"><b>THIS IS OUR LAST VIDEO , ENJOY &lt;3.<br><br>AND ATTACHED IS THE HOWMWORK U HAVE TO DO THIS WEEKEND .<br></b></font><br>LOOK AT THIS TABLE :&nbsp;<br><table class=\"styled-table\" style=\"width: 100%;\"><tr><th>NAME</th><th>L.NAME</th><th>BIRTHDAY</th><th>PHONE</th></tr><tr><td>CHERIF</td><td>TAIEB EZZRAIMI</td><td>19/10/2005</td><td>0542366872</td></tr><tr><td>MERIEM</td><td>TAIEB EZZRAIMI</td><td>12/10/2003</td><td>0550405405</td></tr><tr><td>BICHOU</td><td>BICHOU TANI HH</td><td>26/09/2005</td><td>0567819403</td></tr><tr><td>MOHAMED</td><td>TAIEB EZZRAIMI</td><td>31/12/2009</td><td>0789174909</td></tr></table><br></div>', 'uploads/dsa-HOMEWORK.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Id` int(11) NOT NULL,
  `FloorID` int(11) NOT NULL,
  `RoomNumber` int(11) NOT NULL,
  `blockid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Id`, `FloorID`, `RoomNumber`, `blockid`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 5, 0),
(6, 1, 6, 0),
(7, 1, 7, 0),
(8, 1, 8, 0),
(9, 1, 9, 0),
(10, 1, 10, 0),
(11, 1, 11, 0),
(12, 1, 12, 0),
(13, 1, 13, 0),
(14, 1, 14, 0),
(15, 1, 15, 0),
(16, 1, 16, 0),
(17, 1, 17, 0),
(18, 1, 18, 0),
(19, 1, 19, 0),
(20, 1, 20, 0),
(21, 2, 1, 0),
(22, 2, 2, 0),
(23, 2, 3, 0),
(24, 2, 4, 0),
(25, 2, 5, 0),
(26, 2, 6, 0),
(27, 2, 7, 0),
(28, 2, 8, 0),
(29, 2, 9, 0),
(30, 2, 10, 0),
(31, 2, 11, 0),
(32, 2, 12, 0),
(33, 2, 13, 0),
(34, 2, 14, 0),
(35, 2, 15, 0),
(36, 2, 16, 0),
(37, 2, 17, 0),
(38, 2, 18, 0),
(39, 2, 19, 0),
(40, 2, 20, 0),
(41, 3, 1, 0),
(42, 3, 2, 0),
(43, 3, 3, 0),
(44, 3, 4, 0),
(45, 3, 5, 0),
(46, 3, 6, 0),
(47, 3, 7, 0),
(48, 3, 8, 0),
(49, 3, 9, 0),
(50, 3, 10, 0),
(51, 3, 11, 0),
(52, 3, 12, 0),
(53, 3, 13, 0),
(54, 3, 14, 0),
(55, 3, 15, 0),
(56, 3, 16, 0),
(57, 3, 17, 0),
(58, 3, 18, 0),
(59, 3, 19, 0),
(60, 3, 20, 0),
(61, 4, 1, 0),
(62, 4, 2, 0),
(63, 4, 3, 0),
(64, 4, 4, 0),
(65, 4, 5, 0),
(66, 4, 6, 0),
(67, 4, 7, 0),
(68, 4, 8, 0),
(69, 4, 9, 0),
(70, 4, 10, 0),
(71, 4, 11, 0),
(72, 4, 12, 0),
(73, 4, 13, 0),
(74, 4, 14, 0),
(75, 4, 15, 0),
(76, 4, 16, 0),
(77, 4, 17, 0),
(78, 4, 18, 0),
(79, 4, 19, 0),
(80, 4, 20, 0),
(81, 5, 1, 0),
(82, 5, 2, 0),
(83, 5, 3, 0),
(84, 5, 4, 0),
(85, 5, 5, 0),
(86, 5, 6, 0),
(87, 5, 7, 0),
(88, 5, 8, 0),
(89, 5, 9, 0),
(90, 5, 10, 0),
(91, 5, 11, 0),
(92, 5, 12, 0),
(93, 5, 13, 0),
(94, 5, 14, 0),
(95, 5, 15, 0),
(96, 5, 16, 0),
(97, 5, 17, 0),
(98, 5, 18, 0),
(99, 5, 19, 0),
(100, 5, 20, 0),
(101, 6, 1, 0),
(102, 6, 2, 0),
(103, 6, 3, 0),
(104, 6, 4, 0),
(105, 6, 5, 0),
(106, 6, 6, 0),
(107, 6, 7, 0),
(108, 6, 8, 0),
(109, 6, 9, 0),
(110, 6, 10, 0),
(111, 6, 11, 0),
(112, 6, 12, 0),
(113, 6, 13, 0),
(114, 6, 14, 0),
(115, 6, 15, 0),
(116, 6, 16, 0),
(117, 6, 17, 0),
(118, 6, 18, 0),
(119, 6, 19, 0),
(120, 6, 20, 0),
(121, 7, 1, 0),
(122, 7, 2, 0),
(123, 7, 3, 0),
(124, 7, 4, 0),
(125, 7, 5, 0),
(126, 7, 6, 0),
(127, 7, 7, 0),
(128, 7, 8, 0),
(129, 7, 9, 0),
(130, 7, 10, 0),
(131, 7, 11, 0),
(132, 7, 12, 0),
(133, 7, 13, 0),
(134, 7, 14, 0),
(135, 7, 15, 0),
(136, 7, 16, 0),
(137, 7, 17, 0),
(138, 7, 18, 0),
(139, 7, 19, 0),
(140, 7, 20, 0),
(141, 8, 1, 0),
(142, 8, 2, 0),
(143, 8, 3, 0),
(144, 8, 4, 0),
(145, 8, 5, 0),
(146, 8, 6, 0),
(147, 8, 7, 0),
(148, 8, 8, 0),
(149, 8, 9, 0),
(150, 8, 10, 0),
(151, 8, 11, 0),
(152, 8, 12, 0),
(153, 8, 13, 0),
(154, 8, 14, 0),
(155, 8, 15, 0),
(156, 8, 16, 0),
(157, 8, 17, 0),
(158, 8, 18, 0),
(159, 8, 19, 0),
(160, 8, 20, 0),
(161, 9, 1, 0),
(162, 9, 2, 0),
(163, 9, 3, 0),
(164, 9, 4, 0),
(165, 9, 5, 0),
(166, 9, 6, 0),
(167, 9, 7, 0),
(168, 9, 8, 0),
(169, 9, 9, 0),
(170, 9, 10, 0),
(171, 9, 11, 0),
(172, 9, 12, 0),
(173, 9, 13, 0),
(174, 9, 14, 0),
(175, 9, 15, 0),
(176, 9, 16, 0),
(177, 9, 17, 0),
(178, 9, 18, 0),
(179, 9, 19, 0),
(180, 9, 20, 0),
(181, 10, 1, 0),
(182, 10, 2, 0),
(183, 10, 3, 0),
(184, 10, 4, 0),
(185, 10, 5, 0),
(186, 10, 6, 0),
(187, 10, 7, 0),
(188, 10, 8, 0),
(189, 10, 9, 0),
(190, 10, 10, 0),
(191, 10, 11, 0),
(192, 10, 12, 0),
(193, 10, 13, 0),
(194, 10, 14, 0),
(195, 10, 15, 0),
(196, 10, 16, 0),
(197, 10, 17, 0),
(198, 10, 18, 0),
(199, 10, 19, 0),
(200, 10, 20, 0),
(201, 11, 1, 0),
(202, 11, 2, 0),
(203, 11, 3, 0),
(204, 11, 4, 0),
(205, 11, 5, 0),
(206, 11, 6, 0),
(207, 11, 7, 0),
(208, 11, 8, 0),
(209, 11, 9, 0),
(210, 11, 10, 0),
(211, 11, 11, 0),
(212, 11, 12, 0),
(213, 11, 13, 0),
(214, 11, 14, 0),
(215, 11, 15, 0),
(216, 11, 16, 0),
(217, 11, 17, 0),
(218, 11, 18, 0),
(219, 11, 19, 0),
(220, 11, 20, 0),
(221, 12, 1, 0),
(222, 12, 2, 0),
(223, 12, 3, 0),
(224, 12, 4, 0),
(225, 12, 5, 0),
(226, 12, 6, 0),
(227, 12, 7, 0),
(228, 12, 8, 0),
(229, 12, 9, 0),
(230, 12, 10, 0),
(231, 12, 11, 0),
(232, 12, 12, 0),
(233, 12, 13, 0),
(234, 12, 14, 0),
(235, 12, 15, 0),
(236, 12, 16, 0),
(237, 12, 17, 0),
(238, 12, 18, 0),
(239, 12, 19, 0),
(240, 12, 20, 0),
(241, 13, 1, 0),
(242, 13, 2, 0),
(243, 13, 3, 0),
(244, 13, 4, 0),
(245, 13, 5, 0),
(246, 13, 6, 0),
(247, 13, 7, 0),
(248, 13, 8, 0),
(249, 13, 9, 0),
(250, 13, 10, 0),
(251, 13, 11, 0),
(252, 13, 12, 0),
(253, 13, 13, 0),
(254, 13, 14, 0),
(255, 13, 15, 0),
(256, 13, 16, 0),
(257, 13, 17, 0),
(258, 13, 18, 0),
(259, 13, 19, 0),
(260, 13, 20, 0),
(261, 14, 1, 0),
(262, 14, 2, 0),
(263, 14, 3, 0),
(264, 14, 4, 0),
(265, 14, 5, 0),
(266, 14, 6, 0),
(267, 14, 7, 0),
(268, 14, 8, 0),
(269, 14, 9, 0),
(270, 14, 10, 0),
(271, 14, 11, 0),
(272, 14, 12, 0),
(273, 14, 13, 0),
(274, 14, 14, 0),
(275, 14, 15, 0),
(276, 14, 16, 0),
(277, 14, 17, 0),
(278, 14, 18, 0),
(279, 14, 19, 0),
(280, 14, 20, 0),
(281, 15, 1, 0),
(282, 15, 2, 0),
(283, 15, 3, 0),
(284, 15, 4, 0),
(285, 15, 5, 0),
(286, 15, 6, 0),
(287, 15, 7, 0),
(288, 15, 8, 0),
(289, 15, 9, 0),
(290, 15, 10, 0),
(291, 15, 11, 0),
(292, 15, 12, 0),
(293, 15, 13, 0),
(294, 15, 14, 0),
(295, 15, 15, 0),
(296, 15, 16, 0),
(297, 15, 17, 0),
(298, 15, 18, 0),
(299, 15, 19, 0),
(300, 15, 20, 0),
(301, 16, 1, 0),
(302, 16, 2, 0),
(303, 16, 3, 0),
(304, 16, 4, 0),
(305, 16, 5, 0),
(306, 16, 6, 0),
(307, 16, 7, 0),
(308, 16, 8, 0),
(309, 16, 9, 0),
(310, 16, 10, 0),
(311, 16, 11, 0),
(312, 16, 12, 0),
(313, 16, 13, 0),
(314, 16, 14, 0),
(315, 16, 15, 0),
(316, 16, 16, 0),
(317, 16, 17, 0),
(318, 16, 18, 0),
(319, 16, 19, 0),
(320, 16, 20, 0),
(321, 17, 1, 0),
(322, 17, 2, 0),
(323, 17, 3, 0),
(324, 17, 4, 0),
(325, 17, 5, 0),
(326, 17, 6, 0),
(327, 17, 7, 0),
(328, 17, 8, 0),
(329, 17, 9, 0),
(330, 17, 10, 0),
(331, 17, 11, 0),
(332, 17, 12, 0),
(333, 17, 13, 0),
(334, 17, 14, 0),
(335, 17, 15, 0),
(336, 17, 16, 0),
(337, 17, 17, 0),
(338, 17, 18, 0),
(339, 17, 19, 0),
(340, 17, 20, 0),
(341, 18, 1, 0),
(342, 18, 2, 0),
(343, 18, 3, 0),
(344, 18, 4, 0),
(345, 18, 5, 0),
(346, 18, 6, 0),
(347, 18, 7, 0),
(348, 18, 8, 0),
(349, 18, 9, 0),
(350, 18, 10, 0),
(351, 18, 11, 0),
(352, 18, 12, 0),
(353, 18, 13, 0),
(354, 18, 14, 0),
(355, 18, 15, 0),
(356, 18, 16, 0),
(357, 18, 17, 0),
(358, 18, 18, 0),
(359, 18, 19, 0),
(360, 18, 20, 0),
(361, 19, 1, 0),
(362, 19, 2, 0),
(363, 19, 3, 0),
(364, 19, 4, 0),
(365, 19, 5, 0),
(366, 19, 6, 0),
(367, 19, 7, 0),
(368, 19, 8, 0),
(369, 19, 9, 0),
(370, 19, 10, 0),
(371, 19, 11, 0),
(372, 19, 12, 0),
(373, 19, 13, 0),
(374, 19, 14, 0),
(375, 19, 15, 0),
(376, 19, 16, 0),
(377, 19, 17, 0),
(378, 19, 18, 0),
(379, 19, 19, 0),
(380, 19, 20, 0),
(381, 20, 1, 0),
(382, 20, 2, 0),
(383, 20, 3, 0),
(384, 20, 4, 0),
(385, 20, 5, 0),
(386, 20, 6, 0),
(387, 20, 7, 0),
(388, 20, 8, 0),
(389, 20, 9, 0),
(390, 20, 10, 0),
(391, 20, 11, 0),
(392, 20, 12, 0),
(393, 20, 13, 0),
(394, 20, 14, 0),
(395, 20, 15, 0),
(396, 20, 16, 0),
(397, 20, 17, 0),
(398, 20, 18, 0),
(399, 20, 19, 0),
(400, 20, 20, 0),
(401, 21, 1, 0),
(402, 21, 2, 0),
(403, 21, 3, 0),
(404, 21, 4, 0),
(405, 21, 5, 0),
(406, 21, 6, 0),
(407, 21, 7, 0),
(408, 21, 8, 0),
(409, 21, 9, 0),
(410, 21, 10, 0),
(411, 21, 11, 0),
(412, 21, 12, 0),
(413, 21, 13, 0),
(414, 21, 14, 0),
(415, 21, 15, 0),
(416, 21, 16, 0),
(417, 21, 17, 0),
(418, 21, 18, 0),
(419, 21, 19, 0),
(420, 21, 20, 0),
(421, 22, 1, 0),
(422, 22, 2, 0),
(423, 22, 3, 0),
(424, 22, 4, 0),
(425, 22, 5, 0),
(426, 22, 6, 0),
(427, 22, 7, 0),
(428, 22, 8, 0),
(429, 22, 9, 0),
(430, 22, 10, 0),
(431, 22, 11, 0),
(432, 22, 12, 0),
(433, 22, 13, 0),
(434, 22, 14, 0),
(435, 22, 15, 0),
(436, 22, 16, 0),
(437, 22, 17, 0),
(438, 22, 18, 0),
(439, 22, 19, 0),
(440, 22, 20, 0),
(441, 23, 1, 0),
(442, 23, 2, 0),
(443, 23, 3, 0),
(444, 23, 4, 0),
(445, 23, 5, 0),
(446, 23, 6, 0),
(447, 23, 7, 0),
(448, 23, 8, 0),
(449, 23, 9, 0),
(450, 23, 10, 0),
(451, 23, 11, 0),
(452, 23, 12, 0),
(453, 23, 13, 0),
(454, 23, 14, 0),
(455, 23, 15, 0),
(456, 23, 16, 0),
(457, 23, 17, 0),
(458, 23, 18, 0),
(459, 23, 19, 0),
(460, 23, 20, 0);

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
  `roomId` int(11) DEFAULT NULL,
  `img_path` varchar(200) NOT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Id`, `firstName`, `lastName`, `Email`, `Password`, `roomId`, `img_path`, `phone`) VALUES
('1', 'cherif', 'taieb ezzraimi', 'cherif.taiebezzraimi@ensia.edu.dz', '$2y$10$UdtzxZ8KPtyfgGIMl0/L9OXOVcfgRgK5/naBH3zi2iLeUvGbD11P.', 1, 'uploads/profile_pics/1_1735754489.png', '0542366870');

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `mealtype`
--
ALTER TABLE `mealtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

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
