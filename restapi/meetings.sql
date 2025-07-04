-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2025 at 02:05 PM
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
-- Database: `meetings`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `USER_ID` int(11) NOT NULL,
  `MEETING_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ROOM_ID` int(11) NOT NULL,
  `MEETING_ID` int(11) NOT NULL,
  `Start_time` text NOT NULL,
  `End_time` text NOT NULL,
  `Time_slot` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`ID`, `USER_ID`, `ROOM_ID`, `MEETING_ID`, `Start_time`, `End_time`, `Time_slot`, `Date`) VALUES
(5, 10, 2, 3, '2023-06-30 09:00:00', '2023-06-30 10:00:00', '09:00-10:00', '2023-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `ID` int(11) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `ID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Agenda` text NOT NULL,
  `Date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`ID`, `Title`, `Agenda`, `Date_time`) VALUES
(3, 'Project Kickoff', 'Discuss project goals, timelines, and roles.', '2025-07-01 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mom`
--

CREATE TABLE `mom` (
  `ID` int(11) NOT NULL,
  `MEETING_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `Action_item` text NOT NULL,
  `Decisions` text NOT NULL,
  `Discussion_points` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Capacity` text NOT NULL,
  `Features` text NOT NULL,
  `Location` text NOT NULL,
  `Availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`ID`, `Name`, `Capacity`, `Features`, `Location`, `Availability`) VALUES
(2, 'Conference Room', '10', 'Projector, WiFi', '1st Floor', 0),
(3, 'Conference Room', '10', 'Projector, WiFi', '1st Floor', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `Role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `Role`) VALUES
(5, 'rami2', '$2y$10$ji3aTO.SCpm3cpjI0Q6Yp.QJbOwyWYn8esbz3Tg95uhjUJnKXGFXq', 'employee'),
(6, '5ara', '$2y$10$a6wk990PKF4x1pgxKKRd6uWWaHjemcUdb1uZ69uFmyuIKyBFc1KRu', 'admin'),
(7, 'put', '$2y$10$NDsPFgWVe.0u1Mzf3EVhGuPBbvmFRuWdK/O66N7zboyOTI0BaTMt6', 'new'),
(8, 'testUser', '$2y$10$FE3y68FW8d2XEkj7bInkT..vLsRw4b59cTA2yo58TxLrU6skqxK7K', 'admin'),
(9, 'testtry', 'ok1', 'nah'),
(10, 'testtry', '$2y$10$IXQuJZIe7cmVCIBwjQhE2uz2wES1/n2nDqJ5j57.VZQ2PhhLddtUq', 'nah'),
(11, 'usernew', '$2y$10$.JIiC8LGq0t5zRhym8fYteWWGXghiDWIesumi2nUQpvmV3s5f54Vm', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`USER_ID`,`MEETING_ID`),
  ADD KEY `MEETING_ID` (`MEETING_ID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MEETING_ID` (`MEETING_ID`),
  ADD KEY `ROOM_ID` (`ROOM_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `mom`
--
ALTER TABLE `mom`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MEETING_ID` (`MEETING_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mom`
--
ALTER TABLE `mom`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`MEETING_ID`) REFERENCES `meetings` (`ID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`MEETING_ID`) REFERENCES `meetings` (`ID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`ROOM_ID`) REFERENCES `rooms` (`ID`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `mom`
--
ALTER TABLE `mom`
  ADD CONSTRAINT `mom_ibfk_1` FOREIGN KEY (`MEETING_ID`) REFERENCES `meetings` (`ID`),
  ADD CONSTRAINT `mom_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
