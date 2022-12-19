-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2022 at 04:13 PM
-- Server version: 10.3.37-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `employee_num_id` int(15) NOT NULL,
  `hall_num_id` int(10) NOT NULL,
  `start_time_booking` time NOT NULL,
  `end_time_booking` time NOT NULL,
  `booking_day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`employee_num_id`, `hall_num_id`, `start_time_booking`, `end_time_booking`, `booking_day`) VALUES
(3, 1, '12:00:00', '09:00:00', '2022-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `compalin_num_id` int(50) NOT NULL,
  `employee_num_id` int(15) NOT NULL,
  `hall_num` int(10) NOT NULL,
  `text_complain` text NOT NULL,
  `date_time_send` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complains`
--

INSERT INTO `complains` (`compalin_num_id`, `employee_num_id`, `hall_num`, `text_complain`, `date_time_send`) VALUES
(1, 3, 2, 'test update', '2022-12-11 07:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(50) NOT NULL,
  `hall_num_id` int(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credit_hours` int(5) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  `practic` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `hall_num_id`, `course_name`, `credit_hours`, `is_special`, `practic`, `semester`, `level`) VALUES
('comp 203', 1, 'DB', 3, 0, 'lap comp 203', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(15) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone_num` varchar(50) NOT NULL,
  `specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_name`, `email`, `password`, `phone_num`, `specialization`) VALUES
(1, 'Mohamed ', 'mohamed@net.com', '236', '010', 'Bip'),
(3, 'tamer', 'tamer@em123', '246', '012', 'cs');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `hall_id` int(10) NOT NULL,
  `hall_name` varchar(255) NOT NULL,
  `capacity` int(10) NOT NULL,
  `has_monitor` tinyint(1) NOT NULL,
  `has_projector` tinyint(1) NOT NULL,
  `has_air_condition` tinyint(1) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `description_place` varchar(255) NOT NULL,
  `floor_place` int(10) NOT NULL,
  `building_place` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`hall_id`, `hall_name`, `capacity`, `has_monitor`, `has_projector`, `has_air_condition`, `is_special`, `type`, `status`, `description_place`, `floor_place`, `building_place`) VALUES
(1, 'helal hall', 250, 0, 1, 0, 0, 'hall', 'avilable', 'testtesttes', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hall_photos`
--

CREATE TABLE `hall_photos` (
  `hall_num_id` int(10) NOT NULL,
  `counter_id` int(11) NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall_photos`
--

INSERT INTO `hall_photos` (`hall_num_id`, `counter_id`, `photo`) VALUES
(1, 1, 0x696d6167652f68616c6c5f70686f746f732f313637313339383335392e77656270),
(1, 2, 0x696d6167652f68616c6c5f70686f746f732f313637313339373736302e706e67),
(1, 3, 0x696d6167652f68616c6c5f70686f746f732f313637313339383239302e77656270),
(1, 6, 0x696d6167652f68616c6c5f70686f746f732f313637313430303732392e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `hall_supervisors`
--

CREATE TABLE `hall_supervisors` (
  `hall_num_id` int(10) NOT NULL,
  `counter_id` int(11) NOT NULL,
  `supervisor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall_supervisors`
--

INSERT INTO `hall_supervisors` (`hall_num_id`, `counter_id`, `supervisor_name`) VALUES
(1, 1, 'tete');

-- --------------------------------------------------------

--
-- Table structure for table `requsts`
--

CREATE TABLE `requsts` (
  `request_num_id` int(50) NOT NULL,
  `employee_num_id` int(15) NOT NULL,
  `hall_num` int(10) NOT NULL,
  `date_time_send` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_day` date NOT NULL,
  `permental` int(11) NOT NULL,
  `start_time_booking` time NOT NULL,
  `end_time_booking` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requsts`
--

INSERT INTO `requsts` (`request_num_id`, `employee_num_id`, `hall_num`, `date_time_send`, `booking_day`, `permental`, `start_time_booking`, `end_time_booking`) VALUES
(1, 1, 1, '2022-12-11 07:09:19', '2022-12-05', 2, '02:20:00', '07:09:00'),
(3, 1, 4, '2022-12-18 15:44:45', '2022-12-08', 5, '02:00:00', '00:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_infos`
--

CREATE TABLE `supervisor_infos` (
  `counter_id` int(11) NOT NULL,
  `phone_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisor_infos`
--

INSERT INTO `supervisor_infos` (`counter_id`, `phone_num`) VALUES
(1, '01136');

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `course_code` varchar(50) NOT NULL,
  `employee_num_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaches`
--

INSERT INTO `teaches` (`course_code`, `employee_num_id`) VALUES
('comp 203', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`employee_num_id`,`hall_num_id`),
  ADD KEY `hall_num_id` (`hall_num_id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`compalin_num_id`),
  ADD KEY `employee_num_id` (`employee_num_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`),
  ADD KEY `forginkey` (`hall_num_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`hall_id`);

--
-- Indexes for table `hall_photos`
--
ALTER TABLE `hall_photos`
  ADD PRIMARY KEY (`counter_id`,`hall_num_id`),
  ADD KEY `hall_num_id` (`hall_num_id`);

--
-- Indexes for table `hall_supervisors`
--
ALTER TABLE `hall_supervisors`
  ADD PRIMARY KEY (`counter_id`,`hall_num_id`),
  ADD KEY `hall_num_id` (`hall_num_id`);

--
-- Indexes for table `requsts`
--
ALTER TABLE `requsts`
  ADD PRIMARY KEY (`request_num_id`),
  ADD KEY `employee_num_id` (`employee_num_id`);

--
-- Indexes for table `supervisor_infos`
--
ALTER TABLE `supervisor_infos`
  ADD PRIMARY KEY (`counter_id`,`phone_num`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`course_code`,`employee_num_id`),
  ADD KEY `employee_num_id` (`employee_num_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `compalin_num_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `hall_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hall_supervisors`
--
ALTER TABLE `hall_supervisors`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `requsts`
--
ALTER TABLE `requsts`
  MODIFY `request_num_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`hall_num_id`) REFERENCES `halls` (`hall_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`employee_num_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complains`
--
ALTER TABLE `complains`
  ADD CONSTRAINT `complains_ibfk_1` FOREIGN KEY (`compalin_num_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `forginkey` FOREIGN KEY (`hall_num_id`) REFERENCES `halls` (`hall_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hall_photos`
--
ALTER TABLE `hall_photos`
  ADD CONSTRAINT `hall_photos_ibfk_1` FOREIGN KEY (`hall_num_id`) REFERENCES `halls` (`hall_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hall_supervisors`
--
ALTER TABLE `hall_supervisors`
  ADD CONSTRAINT `hall_supervisors_ibfk_1` FOREIGN KEY (`hall_num_id`) REFERENCES `halls` (`hall_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `requsts`
--
ALTER TABLE `requsts`
  ADD CONSTRAINT `requsts_ibfk_1` FOREIGN KEY (`employee_num_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `supervisor_infos`
--
ALTER TABLE `supervisor_infos`
  ADD CONSTRAINT `supervisor_infos_ibfk_1` FOREIGN KEY (`counter_id`) REFERENCES `hall_supervisors` (`counter_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`employee_num_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
