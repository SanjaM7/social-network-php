-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2019 at 12:58 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) COLLATE utf32_slovenian_ci NOT NULL,
  `email` varchar(255) COLLATE utf32_slovenian_ci NOT NULL,
  `password` varchar(255) COLLATE utf32_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `email`, `password`) VALUES
(1, 'sanja', 'sanja@gmail.com', '$2y$10$UCwOtFQIUlMCF3VnT8oaCOTHUVSJPLXgBEOOu6Nldz8KqVD5Hmksq'),
(2, 'jenny', 'jenny@gmail.com', '$2y$10$bCFIZpkI/rILIvohjUlqmu.tKGqDr7K9sHmH4o2ZuThqt8g4BIZpa'),
(17, 'halle', 'halle@gmail.com', '$2y$10$c5IoRAoPts.U1R43n3O.1erXkhCxT2W6DV9bhg3HPrJ7cl4DQR7km'),
(18, 'kate', 'kate@gmail.com', '$2y$10$gksdvBn7cP6S0Du4q/W0F.WiNOISjiZp.VaIcUzYiWVZBW3WG22sS'),
(19, 'mat', 'mat@gmail.com', '$2y$10$ep9rIIrdN0JhdChQEtzlceg.qgSFn2rtpnTarrY6RxXmVZkgynAL.'),
(20, 'keanu', 'keanu@gmail.com', '$2y$10$zLkUD7VTUp4T2GBtwb7rfOtIKZy/WJWqexR3lWNhUUZnTQFxgxiou'),
(22, 'julia', 'julia@gmail.com', '$2y$10$/ZAN29Y8PpMb7bMrDIjEMuAi8TyOI0A1V/T/gZSNdGZhmupOpIk9O'),
(48, 'quantox', 'quantox@gmail.com', '$2y$10$rFMFOSpjCHsYXqcdV2FzGOesvGhgRwZ5rWGC9l0OumVa9qgALUv7m');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(10) UNSIGNED NOT NULL,
  `senderId` int(10) UNSIGNED NOT NULL,
  `receiverId` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`id`, `senderId`, `receiverId`, `status`) VALUES
(37, 18, 20, 0),
(62, 20, 2, 1),
(89, 22, 1, 1),
(90, 1, 20, 1),
(92, 1, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `statusId` int(11) UNSIGNED NOT NULL,
  `profileId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`statusId`, `profileId`) VALUES
(21, 1),
(22, 1),
(22, 17),
(28, 22),
(77, 1),
(100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf32_slovenian_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf32_slovenian_ci DEFAULT NULL,
  `yearOfBirth` int(4) DEFAULT NULL,
  `image` varchar(255) COLLATE utf32_slovenian_ci DEFAULT NULL,
  `gender` char(1) COLLATE utf32_slovenian_ci DEFAULT NULL,
  `accountId` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `firstName`, `lastName`, `yearOfBirth`, `image`, `gender`, `accountId`) VALUES
(1, 'Sanja', 'Mitrovic', 1993, 'profile1.jpg', 'F', 1),
(2, 'Jennifer', 'Wilde', 1990, 'profile2.jpg', 'F', 2),
(17, 'Halle', 'Berry', 1966, 'profile17.jpg', 'F', 17),
(18, 'Catherine', 'Middleton', 1982, 'profile18.jpg', 'F', 18),
(19, 'Matthew', 'Mcconaughey', 1969, 'profile19.jpeg', 'M', 19),
(20, 'Keanu', 'Reeves', 1964, 'profile20.jpg', 'M', 20),
(22, 'Julia', 'Roberts', 1967, 'profile22.jpg', 'F', 22),
(43, 'quantox', NULL, NULL, 'profiledefault.jpg', NULL, 48);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) UNSIGNED NOT NULL,
  `text` text COLLATE utf32_slovenian_ci NOT NULL,
  `profileId` int(11) UNSIGNED NOT NULL,
  `parentId` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `text`, `profileId`, `parentId`, `createdAt`) VALUES
(21, 'sanja 1', 1, NULL, '2019-09-23 10:39:26'),
(22, 'halle 1', 17, NULL, '2019-09-23 10:40:01'),
(28, 'julia 1', 22, NULL, '2019-09-23 19:38:20'),
(75, 'keanu 1', 20, NULL, '2019-09-28 12:33:12'),
(77, 'sanja reply 1', 1, 22, '2019-09-28 14:08:24'),
(100, '78945', 1, 21, '2019-11-03 18:20:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`(100));

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profileId` (`senderId`),
  ADD KEY `friendId` (`receiverId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`statusId`,`profileId`),
  ADD KEY `profileId` (`profileId`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accountId` (`accountId`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profileId` (`profileId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `friendships_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `profiles` (`id`),
  ADD CONSTRAINT `friendships_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `profiles` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`statusId`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`profileId`) REFERENCES `profiles` (`id`),
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`statusId`) REFERENCES `statuses` (`id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `statuses`
--
ALTER TABLE `statuses`
  ADD CONSTRAINT `statuses_ibfk_1` FOREIGN KEY (`profileId`) REFERENCES `profiles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
