-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 23, 2020 at 06:56 PM
-- Server version: 10.3.22-MariaDB-1ubuntu1
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
-- Database: `bookhive`
--

-- --------------------------------------------------------

--
-- Table structure for table `Book`
--

CREATE TABLE `Book` (
  `id` int(10) NOT NULL COMMENT 'ID of book',
  `title` varchar(80) NOT NULL,
  `author` varchar(40) NOT NULL,
  `category` varchar(30) NOT NULL,
  `added_on` date NOT NULL,
  `qty` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  `ipath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Book`
--

INSERT INTO `Book` (`id`, `title`, `author`, `category`, `added_on`, `qty`, `available`, `ipath`) VALUES
(4, 'Knocks me out', 'xyz', 'thriller', '2020-09-21', 10, 4, 'b1.jpg'),
(5, 'So many books, so little time.', 'abc', 'responsibility', '2020-09-08', 8, 8, 'b4.jpg'),
(6, 'things about book', 'def', 'knowledge', '2020-09-14', 5, 2, 'b22.jpg'),
(7, 'so much', 'tuv', 'rom com', '2020-09-04', 2, 1, 'b6.jpg'),
(8, 'magic', 'aslo', 'horror', '2020-09-19', 2, 2, 'b5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `book_user`
--

CREATE TABLE `book_user` (
  `bid` int(10) NOT NULL COMMENT 'Book id',
  `id` int(10) NOT NULL COMMENT 'User id',
  `issued_on` date DEFAULT NULL COMMENT 'Date of book issued',
  `returned` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Stores whether the book is returned or not '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_user`
--

INSERT INTO `book_user` (`bid`, `id`, `issued_on`, `returned`) VALUES
(7, 1, '2020-09-23', '0'),
(6, 1, '2020-09-23', '0'),
(4, 1, '2020-09-08', '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL COMMENT 'Primary ID of user',
  `remember` varchar(255) DEFAULT NULL,
  `uname` varchar(40) NOT NULL COMMENT 'Name of user',
  `email` varchar(50) NOT NULL COMMENT 'Email of user',
  `pass` varchar(40) NOT NULL COMMENT 'Password of user',
  `type` text NOT NULL COMMENT 'Role ID of user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `remember`, `uname`, `email`, `pass`, `type`) VALUES
(1, NULL, 'Anjali Rathod', 'anjali@gmail.com', '6c2585afb5462e769b7d70d1356786f124213223', 'admin'),
(2, NULL, 'Aastha', 'aastha@gmail.com', 'ad6d1344feb00e67bac540d3611f1004b9482098', 'user'),
(3, NULL, 'Pragati', 'pragati@gmail.com', '87fbd3e6f131f89e0b0b69b87f2d2e7cd9e2d757', 'user'),
(4, NULL, 'Alphons', 'alphons@gmail.com', '17284ff3333ab5649f56ca27595f95a649d8202d', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Book`
--
ALTER TABLE `Book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_user`
--
ALTER TABLE `book_user`
  ADD KEY `index book id` (`bid`) USING BTREE,
  ADD KEY `index userid` (`id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Book`
--
ALTER TABLE `Book`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID of book', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary ID of user', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_user`
--
ALTER TABLE `book_user`
  ADD CONSTRAINT `book_user_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `Book` (`id`),
  ADD CONSTRAINT `book_user_ibfk_2` FOREIGN KEY (`id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
