-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2021 at 03:34 AM
-- Server version: 10.2.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vsb_plus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `admin_id`) VALUES
('admin', 'admin', 8);

-- --------------------------------------------------------

--
-- Table structure for table `S123123123`
--

CREATE TABLE `S123123123` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `S200311111`
--

CREATE TABLE `S200311111` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `S200311111`
--

INSERT INTO `S200311111` (`courseIndex`, `term`, `course_ID`, `section_num`, `course_title`, `final_grade`, `credit_hour`, `credit_earned`, `class_size`, `class_average`) VALUES
(1, '2020 Fall', 'CHEM 104', '001', 'General Chemistry I', '80', 3, 3, 80, 60),
(2, '2020 Fall', 'ENGG 123', '001', 'Engg Design & Communications', '70', 3, 3, 80, 55),
(3, '2020 Fall', 'ENGG 140', '001', 'Mechanics for EngineersStatics', '60', 3, 3, 80, 60),
(4, '2020 Fall', 'MATH 110', '001', 'Calculus I', '70', 3, 3, 80, 55),
(5, '2020 Fall', 'MATH 122', '001', 'Linear Algebra I', '70', 3, 3, 80, 55);

-- --------------------------------------------------------

--
-- Table structure for table `S200343506`
--

CREATE TABLE `S200343506` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `S200362586`
--

CREATE TABLE `S200362586` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `S200362586`
--

INSERT INTO `S200362586` (`courseIndex`, `term`, `course_ID`, `section_num`, `course_title`, `final_grade`, `credit_hour`, `credit_earned`, `class_size`, `class_average`) VALUES
(1, '2015 Fall', 'ENGG 100', '001', 'Engineering Graphics', 'NP', 3, 0, 138, 64),
(2, '2015 Fall', 'MATH 110', '005', 'Calculus I', '82', 3, 3, 55, 63),
(3, '2015 Fall', 'MATH 122', '001', 'Linear Algebra I', 'NP', 3, 0, 90, 63),
(4, '2015 Fall', 'STAT 160', '001', 'Introductory Statistics', 'NP', 3, 0, 80, 57),
(5, '2016 Winter', 'CHEM 104', '001', 'General Chemistry I', '67', 3, 3, 194, 67),
(6, '2016 Winter', 'CS 110', '003', 'Prog & Problem Solving', '71', 3, 3, 180, 60),
(7, '2016 Winter', 'ENGG 100', '001', 'Engineering Graphics', '80', 3, 3, 205, 65),
(8, '2016 Winter', 'MATH 111', '002', 'Calculus II', '70', 3, 3, 89, 54),
(9, '2016 Fall', 'ENGG 123', '001', 'Engg Design & Communications', '56', 3, 3, 208, 68),
(10, '2016 Fall', 'MATH 122', '003', 'Linear Algebra I', '85', 3, 3, 97, 72),
(11, '2016 Fall', 'PHYS 109', '003', 'General Physics I', '86', 3, 3, 120, 67),
(12, '2016 Fall', 'STAT 160', '001', 'Introductory Statistics', '67', 3, 3, 109, 61),
(13, '2017 Winter', 'ECON 201', '002', 'Introductory Microeconomics', 'NP', 3, 0, 119, 66),
(14, '2017 Winter', 'MATH 213', '002', 'Vector Calculus', 'NP', 3, 0, 115, 59),
(15, '2017 Winter', 'MATH 217', '001', 'Differential Equations I', 'NP', 3, 0, 70, 60),
(16, '2017 Winter', 'PHYS 119', '003', 'General Physics II', '72', 3, 3, 100, 64),
(21, '2017 Spring Summer', 'CS 115', '070', 'Object-Oriented Design', '66', 3, 3, 55, 78),
(22, '2017 Spring Summer', 'ENGL 100', 'L40', 'Critical Reading and Writing I', 'NP', 3, 0, 31, 59),
(23, '2017 Spring Summer', 'MATH 213', '070', 'Vector Calculus', 'W', 3, 0, 57, 63),
(24, '2017 Spring Summer', 'MATH 217', '040', 'Differential Equations I', '84', 3, 3, 83, 73),
(25, '2017 Fall', 'CS 210', '001', 'Data Structures & Abstractions', 'NP', 3, 0, 83, 66),
(26, '2017 Fall', 'ENEL 280', '001', 'Electrical Circuits', '60', 3, 3, 164, 61),
(27, '2017 Fall', 'ENGG 240', '002', 'Engg Science I - Mechanics', 'NP', 3, 0, 107, 61),
(28, '2017 Fall', 'MATH 213', '001', 'Vector Calculus', '56', 3, 3, 47, 52);

-- --------------------------------------------------------

--
-- Table structure for table `S200362878`
--

CREATE TABLE `S200362878` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `S200363504`
--

CREATE TABLE `S200363504` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `S200368746`
--

CREATE TABLE `S200368746` (
  `courseIndex` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `course_ID` varchar(255) NOT NULL,
  `section_num` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `final_grade` varchar(255) NOT NULL,
  `credit_hour` int(11) NOT NULL DEFAULT 3,
  `credit_earned` int(11) NOT NULL,
  `class_size` int(11) NOT NULL,
  `class_average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `campus` varchar(255) NOT NULL DEFAULT 'U of R',
  `faculty` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `major` varchar(255) NOT NULL,
  `minor` varchar(255) DEFAULT NULL,
  `concentration` varchar(255) DEFAULT NULL,
  `totalCredit` int(11) NOT NULL DEFAULT 0,
  `GPA` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `campus`, `faculty`, `program`, `major`, `minor`, `concentration`, `totalCredit`, `GPA`, `password`) VALUES
(123123123, '123123123', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'ISE', '', '', 136, 70, '$2y$10$Jt1mi5/cNSGMYnuPIb41tuIwMQZpv8cIkIFrYFaYxWN/VXvFoid/i'),
(200311111, 'DemoSSE', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'SSE', '', '', 11, 60, '$2y$10$dXqeAaQ/rxdkas6Ss8NvfuDMX/k95YcHmkx8rqytQhcWWgxli4l/W'),
(200343506, 'Tsai, Ming', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'ISE', '', '', 136, 60, '$2y$10$yON2Yvsqp71130pwYGn2I.xHUkOf0NkxGOzP.Ihqw1ByvRk04pmva'),
(200362586, 'Yang, Jingkang', 'U of R', 'Engineering and Applied Science', 'Bachelor of Applied Science', 'SSE', NULL, NULL, 133, 76, '$2y$10$nOiF/i0ngj/4YYg5Nac8eO3vyhkoVMJcwBTEOiMkXV8pU4W1ezXpW'),
(200362878, 'Nick', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'ESE', '', '', 3, 60, '$2y$10$lUUEI36.xAoQNOqqP6O7aeFMnzM0mcvN8nB4Gi5utxm9r18e05rG2'),
(200363504, 'Priscilla Chua', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'SSE', '', '', 136, 60, '$2y$10$shGoK/Z6BKjxqHif2x3DhuBkNEZILmF9GZSRH5KpDr.UPemKImmS.'),
(200368746, 'Xia Hua', 'University of Regina', 'Engineering and Applied Science', 'BASc', 'SSE', '', '', 136, 70, '$2y$10$2q/Vue3dw1GlWvAKWBGCpu01oWVbECO.08dE7Iwwtd4Terz/RMGpG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `S123123123`
--
ALTER TABLE `S123123123`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200311111`
--
ALTER TABLE `S200311111`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200343506`
--
ALTER TABLE `S200343506`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200362586`
--
ALTER TABLE `S200362586`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200362878`
--
ALTER TABLE `S200362878`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200363504`
--
ALTER TABLE `S200363504`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `S200368746`
--
ALTER TABLE `S200368746`
  ADD PRIMARY KEY (`courseIndex`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `S123123123`
--
ALTER TABLE `S123123123`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `S200311111`
--
ALTER TABLE `S200311111`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `S200343506`
--
ALTER TABLE `S200343506`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `S200362586`
--
ALTER TABLE `S200362586`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `S200362878`
--
ALTER TABLE `S200362878`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `S200363504`
--
ALTER TABLE `S200363504`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `S200368746`
--
ALTER TABLE `S200368746`
  MODIFY `courseIndex` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
