-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10. Sep, 2018 20:33 PM
-- Tjener-versjon: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignm_3_task_3`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `book`
--

CREATE TABLE `book` (
  `id:` int(11) NOT NULL,
  `title:` varchar(500) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `author:` varchar(250) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `description:` varchar(2000) CHARACTER SET utf8 COLLATE utf8_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `book`
--

INSERT INTO `book` (`id:`, `title:`, `author:`, `description:`) VALUES
(1, 'Jungle Book', 'R.Kipling', 'A classic book.'),
(2, 'Moonwalker', 'J.Walker', NULL),
(3, 'PHP & MySQL for Dummies', 'J.Valade', 'Written by some smart gal.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id:`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id:` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
