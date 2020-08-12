-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2020 at 11:10 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `protozmsrc1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `AcctNo` varchar(255) NOT NULL,
  `AcctName` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Period Covered` date NOT NULL,
  `KwH_used` int(11) NOT NULL,
  `onDue` double NOT NULL,
  `beforeDue` double NOT NULL,
  `afterDue` double NOT NULL,
  `DatePaid` date NOT NULL,
  `amtPaid` double NOT NULL,
  `Balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `ComplaintNo` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Area_Landmark` varchar(255) NOT NULL,
  `Nature_of_Complaint` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crew_function`
--

CREATE TABLE `crew_function` (
  `CFuncNo` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crew_member`
--

CREATE TABLE `crew_member` (
  `CrewNo` varchar(255) NOT NULL,
  `CFuncNo` varchar(255) NOT NULL,
  `Date_Time_Assigned` datetime NOT NULL,
  `TeamName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crew_profile`
--

CREATE TABLE `crew_profile` (
  `CrewNo` varchar(255) NOT NULL,
  `EmpID` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `Area` varchar(255) NOT NULL,
  `Designation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dispatch`
--

CREATE TABLE `dispatch` (
  `TeamName` varchar(255) NOT NULL,
  `EmpID` varchar(255) NOT NULL,
  `DateTimeDispatch` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `ComplaintNo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EmpID` varchar(255) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Area` varchar(255) NOT NULL,
  `Dept` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmpID`, `Fname`, `Mname`, `Lname`, `Area`, `Dept`) VALUES
('z124', 'Syed', 'Anda', 'Ganih', 'Area 2', 'ICT');

-- --------------------------------------------------------

--
-- Table structure for table `emp_support_complaint`
--

CREATE TABLE `emp_support_complaint` (
  `EmpID` varchar(255) NOT NULL,
  `ComplainNo` varchar(255) NOT NULL,
  `NameOfComplainant` varchar(255) NOT NULL,
  `ContactNo` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guestNo` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guestNo`, `name`, `address`, `contact`, `email`) VALUES
(1, 'thales', 'thales', 'thales', 'once@once.once'),
(2, 'admin', 'admin', 'admin', 'admin@admin.com'),
(3, 'once', 'once', 'once', 'once@once.onc'),
(4, 'tango', 'tango', 'tango', 'once@once.onc'),
(5, 'ocne', 'ocne', 'ocne', 'once@once.onc'),
(6, 'ocne', 'ocne', 'ocne', 'once@once.onc'),
(7, 'ocne', 'ocne', 'ocne', 'once@once.onc'),
(8, 'ocne', 'ocne', 'ocne', 'once@once.onc'),
(9, 'ocne', 'ocne', 'ocne', 'once@once.onc'),
(10, 'qweqweq', '234234234', '234234', 'qweqwe@sdfdsf.fwfwe'),
(11, 'qweqweq', '234234234', '234234', 'qweqwe@sdfdsf.fwfwe'),
(12, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(13, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(14, 'asdasd', 'once', 'asdasd', 'deys@gmail.com'),
(15, 'qweqweqwe', '123123123123123123', '123123', '123123@sdf.sfsdfsd'),
(16, '123', '123123123', '123123', 'once@once.onc'),
(17, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(18, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(19, 'asdasd', '123123123', '123123123', 'deys@gmail.com'),
(20, 'QWEQWE', 'QWEQE', 'QWEQWE', 'QWEEQWE@SSD.ASD'),
(21, 'qweqwe', 'WEQWEQWEQWEQWEQWE', 'QWEQWEQ', 'qweqweqweq@gbdfbdd.vvv'),
(22, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(23, 'asdasd', 'asdasd', 'asdasd', 'deys@gmail.com'),
(24, 'asdasd', 'asdasd', 'asdasd', 'deys@gmail.com'),
(25, 'qweqwe', 'asdasd', 'asdasd', 'deys@gmail.com'),
(26, 'sdasdasasdasd', 'asdasd', 'asdasd', 'deys@gmail.com'),
(27, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc'),
(28, 'qweqweqwe', '1231231231', 'admin', 'once@once.onc');

-- --------------------------------------------------------

--
-- Table structure for table `id_verification`
--

CREATE TABLE `id_verification` (
  `UserID` varchar(100) NOT NULL,
  `Date_created` varchar(100) NOT NULL,
  `IDType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `id_verification`
--

INSERT INTO `id_verification` (`UserID`, `Date_created`, `IDType`) VALUES
('12', 'curdate()', 'Guest'),
('13', '2020-08-04', 'Guest'),
('14', '2020-08-04', 'Guest'),
('15', '2020-08-04', 'Guest'),
('16', '2020-08-04', 'Guest'),
('17', '2020-08-04', 'Guest'),
('18', '2020-08-04', 'Guest'),
('19', '2020-08-05', 'Guest'),
('20', '2020-08-05', 'Guest'),
('21', '2020-08-05', 'Guest'),
('22', '2020-08-05', 'Guest'),
('23', '2020-08-05', 'Guest'),
('24', '2020-08-05', 'Guest'),
('25', '2020-08-05', 'Guest'),
('26', '2020-08-05', 'Guest'),
('27', '2020-08-05', 'Guest'),
('28', '2020-08-05', 'Guest'),
('admin', '2020-08-05', 'User'),
('tango', '', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `syst_acct`
--

CREATE TABLE `syst_acct` (
  `username` varchar(11) NOT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `syst_acct`
--

INSERT INTO `syst_acct` (`username`, `password`) VALUES
('123', '81dc9bdb52d04dc20036dbd8313ed055'),
('admin', '21232f297a57a5a743894a0e4a801fc3'),
('tango', '81dc9bdb52d04dc20036dbd8313ed055'),
('thales', '3a8aa14b09c007603f0c93151120b014');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(100) NOT NULL,
  `Fname` varchar(255) NOT NULL,
  `Mname` varchar(255) NOT NULL,
  `Lname` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `AcctNo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Fname`, `Mname`, `Lname`, `Address`, `Contact`, `AcctNo`) VALUES
('123', 'asdassdf', 'dvfdvfdv', 'dfvdfvdfvd', 'fvdfvvdfv', 'dfvdfvdfv', 'dfvdfvdfvdfv'),
('admin', 'admin', 'admin', 'admin', 'admin', 'admin', 'admin'),
('tango', '1234', '1234', '1234', '1234', '1234', '1234'),
('thales', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `accountnum` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(25) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `accountnum`, `password`, `email`, `created_at`) VALUES
(1, '0', '$2y$10$r3LcoNKLLwjgF992DeDHo.75ChrrybhDsfglxYJSkde9wcDUcvE.e', '', '2020-04-13 15:49:07'),
(2, 'hhfhdhd255', '$2y$10$4Gnhpb27/o8UhZCXAQE8Q.LdTNH0GqpGeh.GFQtZ0m9AEqRmsCvHy', '', '2020-04-13 15:55:26'),
(3, '1234567891', '$2y$10$NDRAG59hmxUMybXfCAPRYeP.olYLNjuwTEMLDute.nvpRQDiM0Qdq', '', '2020-04-13 15:57:54'),
(4, '1234567890', '$2y$10$y8yPWiBeutZKKAEi2Gm6IuqP9yO9Rj0UbldmC2uDxUEc2eXj2O8MO', '', '2020-04-13 16:04:38'),
(5, '1231231230', '$2y$10$UjYzCrOBFisdXLsKjV0pJumsMwMjV2MtU3Qx43.k0JYLDroCxmt..', '', '2020-04-13 16:32:42'),
(6, '4564564560', '$2y$10$2Q8DKrRwItK9FC5RZdb3/upTVJv7sV/MTme8.rKLeBLQrEGv8B4Ru', 'r_hanz87@yahoo.com', '2020-04-13 16:35:55'),
(7, '9876543210', '$2y$10$gUQhZrCuh/yHYqIjOF1b4ODj392vSyEub3/UMSA7C20Beu8cWaDvC', 'hccadag@gmail.com', '2020-05-03 16:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_complaint`
--

CREATE TABLE `user_complaint` (
  `ComplaintID` varchar(255) NOT NULL,
  `ComplaintNo` varchar(255) NOT NULL,
  `Date_Time_Complaint` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`AcctNo`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`ComplaintNo`);

--
-- Indexes for table `crew_function`
--
ALTER TABLE `crew_function`
  ADD PRIMARY KEY (`CFuncNo`);

--
-- Indexes for table `crew_member`
--
ALTER TABLE `crew_member`
  ADD PRIMARY KEY (`CrewNo`,`CFuncNo`);

--
-- Indexes for table `crew_profile`
--
ALTER TABLE `crew_profile`
  ADD PRIMARY KEY (`CrewNo`);

--
-- Indexes for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`TeamName`,`EmpID`,`ComplaintNo`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `emp_support_complaint`
--
ALTER TABLE `emp_support_complaint`
  ADD PRIMARY KEY (`EmpID`,`ComplainNo`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guestNo`);

--
-- Indexes for table `id_verification`
--
ALTER TABLE `id_verification`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `syst_acct`
--
ALTER TABLE `syst_acct`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`accountnum`);

--
-- Indexes for table `user_complaint`
--
ALTER TABLE `user_complaint`
  ADD PRIMARY KEY (`ComplaintID`,`ComplaintNo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guestNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
