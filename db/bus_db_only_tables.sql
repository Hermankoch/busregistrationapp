-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2023 at 10:42 AM
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
-- Database: `bus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
                                  `AdminID` int(11) NOT NULL,
                                  `Initials` varchar(100) NOT NULL,
                                  `Surname` varchar(100) NOT NULL,
                                  `Password` varchar(100) NOT NULL,
                                  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `availableseats`
--

CREATE TABLE `availableseats` (
                                  `BusRouteID` int(1) NOT NULL,
                                  `SeatsForPickup` int(3) NOT NULL,
                                  `SeatsForDropOff` int(3) NOT NULL,
                                  `SeatLimit` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `busroutes`
--

CREATE TABLE `busroutes` (
                             `BusRouteID` int(11) NOT NULL,
                             `RouteName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `busstops`
--

CREATE TABLE `busstops` (
                            `BusStopID` varchar(2) NOT NULL,
                            `LocationName` varchar(100) NOT NULL,
                            `BusRouteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropofftimes`
--

CREATE TABLE `dropofftimes` (
                                `BusStopID` varchar(2) NOT NULL,
                                `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learners`
--

CREATE TABLE `learners` (
                            `LearnerID` int(11) NOT NULL,
                            `Name` varchar(100) NOT NULL,
                            `Surname` varchar(100) NOT NULL,
                            `PhoneNumber` varchar(10) NOT NULL,
                            `Grade` int(2) NOT NULL,
                            `ParentID` int(11) DEFAULT NULL,
                            `AdminID` int(11) DEFAULT NULL,
                            `PickupID` varchar(2) DEFAULT NULL,
                            `DropOffID` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
                           `ParentID` int(11) NOT NULL,
                           `Name` varchar(100) NOT NULL,
                           `Surname` varchar(100) NOT NULL,
                           `PhoneNumber` varchar(10) NOT NULL,
                           `Email` varchar(100) NOT NULL,
                           `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickuptimes`
--

CREATE TABLE `pickuptimes` (
                               `BusStopID` varchar(2) NOT NULL,
                               `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waitinglist`
--

CREATE TABLE `waitinglist` (
                               `WaitingListID` int(11) NOT NULL,
                               `LearnerID` int(11) NOT NULL,
                               `ListDate` datetime NOT NULL,
                               `BusStopID` varchar(2) NOT NULL,
                               `PickupOrDropOff` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
    ADD PRIMARY KEY (`AdminID`);


--
-- Indexes for table `busroutes`
--
ALTER TABLE `busroutes`
    ADD PRIMARY KEY (`BusRouteID`);

--
-- Indexes for table `busstops`
--
ALTER TABLE `busstops`
    ADD PRIMARY KEY (`BusStopID`);

--
-- Indexes for table `dropofftimes`
--
ALTER TABLE `dropofftimes`
    ADD PRIMARY KEY (`BusStopID`);

--
-- Indexes for table `learners`
--
ALTER TABLE `learners`
    ADD PRIMARY KEY (`LearnerID`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
    ADD PRIMARY KEY (`ParentID`);

--
-- Indexes for table `pickuptimes`
--
ALTER TABLE `pickuptimes`
    ADD PRIMARY KEY (`BusStopID`);

--
-- Indexes for table `waitinglist`
--
ALTER TABLE `waitinglist`
    ADD PRIMARY KEY (`WaitingListID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
    MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `learners`
--
ALTER TABLE `learners`
    MODIFY `LearnerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
    MODIFY `ParentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waitinglist`
--
ALTER TABLE `waitinglist`
    MODIFY `WaitingListID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `availableseats` ADD PRIMARY KEY(`BusRouteID`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
