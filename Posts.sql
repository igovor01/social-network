-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 02, 2023 at 01:08 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 7.4.3-4ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GovorusicI`
--

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE `Posts` (
  `PostID` int NOT NULL,
  `UserID` varchar(300) NOT NULL,
  `PostText` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PostImgUrl` varchar(300) NOT NULL,
  `isLiked` tinyint NOT NULL,
  `isBookmarked` tinyint NOT NULL,
  `TotalLikes` int NOT NULL,
  `TotalBookmarks` int NOT NULL,
  `TotalComments` int NOT NULL,
  `DateTime` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`PostID`, `UserID`, `PostText`, `PostImgUrl`, `isLiked`, `isBookmarked`, `TotalLikes`, `TotalBookmarks`, `TotalComments`, `DateTime`) VALUES
(1, '1', 'Random je planina ', 'images/random-1.jpg', 0, 0, 5, 4, 3, '21/7/2021 21:21'),
(2, '1', 'Cetina izvire ', 'images/cetina.jpg', 0, 0, 0, 0, 0, '5/7/2022 15:04'),
(3, '1', 'otočić na kojemu se nalazi Primošten ', 'images/primosten.jpg', 0, 0, 0, 0, 0, '8/8/2017 16:47'),
(5, '1', 'Katedrala Sv. Jakova u Šibeniku ', 'images/sibenik.jpg', 1, 0, 2, 2, 2, '9/2/2023 18:31'),
(6, '1', 'Svilaja je planina ', 'images/svilaja.jpg', 0, 1, 1, 1, 1, '18/7/2022 16:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`PostID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
  MODIFY `PostID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
