-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 20, 2023 at 01:05 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apspacechat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `unique_id`, `fname`, `lname`, `address`, `phonenumber`, `gender`, `email`, `password`, `img`, `status`) VALUES
(1, 'AP000001', 'Li', 'Jia Chong', 'APU', '0125467832', 'Male', 'AP000001@mail.apu.edu.my', '$2y$10$BvtmOLj6TBHjTM5X5HwIgeP2Bd/kkv5DDZM4UnwxYiMQ3pVZhaRSS', '1695210406Photo_Li Jia Chong_6-1-2023.jpeg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE IF NOT EXISTS `lecturer` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`user_id`, `unique_id`, `fname`, `lname`, `address`, `phonenumber`, `gender`, `email`, `password`, `img`, `status`) VALUES
(1, 'LP000001', 'First', 'Lecturer', 'APU', '0126754382', 'Male', 'LP000001@mail.apu.edu.my', '$2y$10$ioVJt6CMgtpTFhgtOnXqReYHx/iBGG58jWfWTCCJFTAcafvL85RVC', '1695210572avatar.png', 'active'),
(2, 'LP000002', 'Second', 'Lecturer', 'APU', '0125647832', 'Male', 'LP000002@mail.apu.edu.my', '$2y$10$Recc.Qq77ydP7P5RgfzAnukMBIh5WazxlTNDmXjJAEqor9nRQNWl6', '1695210612avatar.png', 'active'),
(3, 'LP000003', 'Third', 'Lecturer', 'APU', '0123546759', 'Male', 'LP000003@mail.apu.edu.my', '$2y$10$nwJjD13LZVfQk3OWMsRJDur/J.5mbsj59QrfXzbVN5lJpoD5zDyju', '1695210639avatar.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `incoming_msg_id` varchar(10) NOT NULL,
  `outgoing_msg_id` varchar(10) NOT NULL,
  `msg` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message_iv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `msg_timestamp` timestamp NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `message_key`, `message_iv`, `file`, `msg_timestamp`) VALUES
(1, 'LP000001', 'AP000001', 'huKbmOiIbnTvwA9gG3GO3ArJBi8U7G1ahsu8UlfT/fI=', '5806a6b28e0ff872442a9a6f2c405341d92b63370da68150546b856b7f378f34', '8b2a8d5661ccb1cd4996b92a6c726fc0', '', '2023-09-20 11:53:04'),
(2, 'AP000001', 'LP000001', 'h2FWb8KrxbYTeOqNQAMZAg==', '6b431528627da95290f1792cee8d1296495185a5b309bdabade0d27a677b6fbb', '7937c4a5d6797887c07a6d89d361755e', '', '2023-09-20 11:53:11'),
(3, 'LP000001', 'AP000001', 'ZPYXjw++ay56qo6Nh3t0d7CykkdGnVKi+iGIvHRuayEOy4nW5zx0laOu0mHoHubb', '7601505bd3fa7c84a47005f2493b1814a931e045bdedc9980ef58192f5218fcb', '7c615731e3557558b779e59dc5956316', 'cG9zdGVyLnBuZw==', '2023-09-20 11:53:23'),
(4, 'AP000001', 'LP000001', 'D2BoqhDQw2pvhqtyF1Np8SlRIAOAIu1UMNHiaA4n6Co=', 'a0d7cb415cff33995e3e7947150ddc19201614adb8f7e05b413dbd5c14a1ec4e', '6c5ee1c30f463be1798cd6cf8f8b7e3d', '', '2023-09-20 11:53:48'),
(5, 'AP000001', 'LP000001', 'QTp54+1GgYpZq0Nx15cWtCEaqVUKbp/PMQRT9acrcsP4LD+egOiFh+lTB6kcj2B+', '0e7161b6c0519f32c1a84b74f45fd1440c67302d6fd4abb7688e2c69c843a7a6', 'a4816e039e0d4e5d6b129d6d46f4c197', 'U0RQIERvY3VtZW50YXRpb24gR3JvdXAgMTcgKDEpICgxKS5kb2N4', '2023-09-20 11:54:04'),
(6, 'LP000001', 'AP000001', 'HqXurqh8H297V39PtidGdkNg/o9IyTvuNMl9YWErDKI=', 'cb83424abfe9ec79026d756b3e00f7a1cc316a94145f0007a2500ed6dada213a', 'c1bda99a45db7f04bd01a263a2da1ba1', '', '2023-09-20 11:54:38'),
(7, 'LP000001', 'AP000001', 'R3yjfAYjynxtjzZujy8vSeGavxIfuvpeWSPN0EblT5tXbeBwoHZIjAWRLHNYaj8FVoPvSdgY9G0Ite7ApGGekDt5ikVEHSDFctfcIkBSh1pdiBqVTMWgwA3H7t87uIsg', '88c762386db2dbc95f0e9361d43cd410f366bef2109b42a62a9727efe79606b8', 'd87a3259155dc593c52377cdd20e11d7', '', '2023-09-20 11:55:15'),
(8, 'AP000001', 'LP000001', 'wzQEQO/pNguvQZ+TbwV517/wr5VmG+7vcBF6+5yOWGI=', '7e9fe1a64314c71d340739d54643b55eba86ef4c9d26777623ccbacc86524023', 'd5b64b0783faa9dff3fe51773808c35e', '', '2023-09-20 11:55:20'),
(9, 'AP000001', 'LP000001', '+ysAZqupy/lFNGGiqfUD7GnxFBYl7rgoS3VC81MonW8osP96VKYpv7wkFR9sJVLQqno/M9CNd40rAexgeZE809nrr4Ljwyc8fibKGOM19gCTlJJNRjw7eGz/u8fzoPkW', '1a5217487f656997cc4ff60aec6a8dd145a2c9367520551da7433e7f8cd90cee', '83fe588b75bebb0ab370576a250bc8bf', '', '2023-09-20 11:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `intakecode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phonenumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user_id`, `unique_id`, `fname`, `lname`, `intakecode`, `address`, `phonenumber`, `gender`, `email`, `password`, `img`, `status`) VALUES
(1, 'TP000001', 'First', 'Student', 'UCDF', 'APU', '0126547832', 'Male', 'TP000001@mail.apu.edu.my', '$2y$10$oPkiKHAHSlF09XLWdFbqf.awoc/5davLwjuCnom60Ot8Il3oMogdW', '1695210503avatar.png', 'active'),
(2, 'TP000002', 'Second', 'Student', 'APD', 'APU', '0126475832', 'Male', 'TP000002@mail.apu.edu.my', '$2y$10$DCqKqrWbopaRiiMmNZ9HMu9OJ0aawX2t2vvgGmMvEmoRYAi56.df2', '1695210696avatar.png', 'active'),
(3, 'TP000003', 'Third', 'Student', 'APD', 'APU', '0129758643', 'Male', 'TP000003@mail.apu.edu.my', '$2y$10$AcfM8cWny0SRaMWf1ligCe73pe6ZkQPuMfslhEl1JNNun9SlTMuIW', '1695210720avatar.png', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `img`, `status`, `role`) VALUES
(1, 'AP000001', 'Li', 'Jia Chong', 'AP000001@mail.apu.edu.my', '1695210406Photo_Li Jia Chong_6-1-2023.jpeg', 'Active now', 'admin'),
(2, 'TP000001', 'First', 'Student', 'TP000001@mail.apu.edu.my', '1695210503avatar.png', 'Offline now', 'student'),
(3, 'LP000001', 'First', 'Lecturer', 'LP000001@mail.apu.edu.my', '1695210572avatar.png', 'Active now', 'lecturer'),
(4, 'LP000002', 'Second', 'Lecturer', 'LP000002@mail.apu.edu.my', '1695210612avatar.png', 'Offline now', 'lecturer'),
(5, 'LP000003', 'Third', 'Lecturer', 'LP000003@mail.apu.edu.my', '1695210639avatar.png', 'Offline now', 'lecturer'),
(6, 'TP000002', 'Second', 'Student', 'TP000002@mail.apu.edu.my', '1695210696avatar.png', 'Offline now', 'student'),
(7, 'TP000003', 'Third', 'Student', 'TP000003@mail.apu.edu.my', '1695210720avatar.png', 'Offline now', 'student');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
