-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: webdb.uvm.edu
-- Generation Time: Dec 04, 2014 at 06:38 PM
-- Server version: 5.5.40-36.1-log
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `KGAUGER_BARRETOWNFOREST`
--

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE IF NOT EXISTS `Event` (
`ID` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `time` int(16) NOT NULL,
  `location` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Event_User`
--

CREATE TABLE IF NOT EXISTS `Event_User` (
`ID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isModerator` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
`ID` int(11) NOT NULL,
  `deviceID` varchar(32) NOT NULL,
  `deviceToken` varchar(64) NOT NULL,
  `name` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `badgeCount` int(1) NOT NULL,
  `isAdmin` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`ID`, `deviceID`, `deviceToken`, `name`, `email`, `badgeCount`, `isAdmin`) VALUES
(1, '40B8376B0E954317BE613ED0E325EF82', '3568f84ac515f5f66759b6077dbc231654da1eb9117b3f87f58a4bad4faae599', '', '', 4, 0),
(3, 'B44CF1BD9A7B43809C37EA7A8B8035C1', '62fe682d3877656301c830ea22a509a02e789bf22b55348ab2aebaf557150f63', '', '', 4, 0),
(4, '760A1D81F09C4AF99B355C8FA7B314A7', 'b24de4c7815c3e6d1f7c13c7520deb2bcf3ae975a13ce91fc854cab5ea012812', '', '', 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Event`
--
ALTER TABLE `Event`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `Event_User`
--
ALTER TABLE `Event_User`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `eventID` (`eventID`,`userID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `deviceToken` (`deviceToken`), ADD UNIQUE KEY `deviceID` (`deviceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Event`
--
ALTER TABLE `Event`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Event_User`
--
ALTER TABLE `Event_User`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
