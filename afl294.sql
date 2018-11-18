-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2018 at 04:55 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `afl294`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(300) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `type`, `user_id`, `text`, `time`) VALUES
(3, 'login_fail', 17, '', '2018-11-18 04:37:23'),
(2, 'login_success', 17, '', '2018-11-18 04:37:10'),
(5, 'create_account_success', 19, '', '2018-11-18 04:39:51'),
(8, 'image_upload', 19, '{"upload_id": 10}', '2018-11-18 04:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempt`
--

CREATE TABLE `login_attempt` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempt`
--

INSERT INTO `login_attempt` (`id`, `user_id`, `time`) VALUES
(7, 17, '2018-11-18 04:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `login_token`
--

CREATE TABLE `login_token` (
  `id` int(11) NOT NULL,
  `token` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_token`
--

INSERT INTO `login_token` (`id`, `token`, `user_id`, `time`) VALUES
(31, 'ec09ec45a7156f63d056e69468af3e68', 19, '2018-11-18 04:39:51'),
(29, '548e94b8f1413e55acbc15e5ef702207', 17, '2018-11-18 04:37:10'),
(30, '3ba14331f60acc5cdc4ad16971a8a89c', 18, '2018-11-18 04:39:12'),
(1, '3db2aeca6079bfd5d5ebdb200b378c63', 1, '2018-11-12 08:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `path` varchar(250) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id`, `user_id`, `path`, `time`) VALUES
(8, 19, 'resized_standing cat.png', '2018-11-18 04:40:28'),
(9, 19, 'resized_standing cat.png', '2018-11-18 04:41:20'),
(10, 19, 'resized_background_1.jpg', '2018-11-18 04:43:34'),
(7, 1, 'resized_doge selfie.jpg', '2018-11-12 07:39:05'),
(6, 1, 'resized_dog rainbow.jpg', '2018-11-12 07:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `salt` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `salt`) VALUES
(18, '5', 'ecb7073c8e9c49719e08ed307cf6c85356691128e424591bc0b623290b6e8b09707695033b4fdb9f183a1986532687339b8d556c2771fb128825757fc4a3fde2', 'e9f88426f0d2438717c242a3f38bb02d'),
(19, '6', '2577a5f6bdc359048aaf6f11346f9cc00febfb0c3c53c0e3c5bab43ed88b878092feeb2fb049ea58f5bb5468c34c5c15b6142b1e3bb8b73e53d0dae3217e3e57', '12b750b00b7cc924403de832a0fa52b0'),
(17, '2', '21d42175b1003bf6d6efc8e1228996a87a9dbd555673760717a1087c15c3efcfe386bc05b4e1833e93d0dcf02021722198ae1f0a793512cce00099abed9e3d2d', 'a342cc61c786a1747480ea1e516e8df0'),
(1, 'test', '44b2361427faf8a78601ef39db899b223e9d6910db65b353ee0d456dc7a1942e5e5897ace230a8e9d7e1697fdedaa5fbce6431786bd96b21ef015666b8acb1f9', '44c4eef544377540213ce4c2b083441a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempt`
--
ALTER TABLE `login_attempt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_token`
--
ALTER TABLE `login_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `login_attempt`
--
ALTER TABLE `login_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
