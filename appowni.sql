-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2010 at 03:04 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appowni`
--

-- --------------------------------------------------------

--
-- Table structure for table `war_evaluations`
--

CREATE TABLE IF NOT EXISTS `war_evaluations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ReportKey` varchar(255) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `positive` tinyint(2) unsigned NOT NULL,
  `negative` tinyint(1) unsigned NOT NULL,
  `score` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ReportKey` (`ReportKey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `war_evaluations`
--

INSERT INTO `war_evaluations` (`id`, `ReportKey`, `updated`, `positive`, `negative`, `score`) VALUES
(1, '35BD5637-4066-43A3-B155-EE2DE816BFDC', '2010-08-20 11:37:33', 1, 6, 0),
(2, '02FDE7F0-0253-43FE-8FA4-7BBF8AAE9330', '2010-08-20 13:32:33', 0, 1, 0),
(3, '3308A29A-AC0E-4FC4-B751-3F24DD7AD8E2', '2010-08-20 14:32:22', 0, 1, 0),
(4, '3F2C7BB0-7944-45C7-9A9B-5285591D034D', '2010-08-20 15:16:15', 0, 1, 0),
(5, 'EB4BDD2D-CC74-459F-AAA6-71124E192C31', '2010-08-20 15:16:45', 1, 0, 0),
(6, '351990D8-9B97-4DB1-BD35-E653BAF52CF0', '2010-08-20 15:23:09', 0, 1, 0),
(7, 'D1433C1B-74BB-43D9-B7F9-93C9BB641FE3', '2010-08-20 15:32:53', 0, 1, 0),
(8, '43835237-E78A-4EF4-866F-73471324B2E9', '2010-08-20 15:32:58', 1, 0, 0),
(9, '1008275', '2010-08-20 15:48:06', 1, 0, 0),
(10, '899B0E1E-8F09-494B-86B2-0B4B060F300F', '2010-08-20 15:48:59', 1, 0, 0),
(11, 'BBA30067-A2AB-4F4B-B9E9-74D232049808', '2010-08-20 15:49:07', 1, 0, 0),
(12, 'BC4DD242-7DE9-4FA5-A765-46D1F52A1D00', '2010-08-20 16:19:41', 1, 0, 2),
(13, 'DBD18A49-B5B7-469E-A2EF-394F34110348', '2010-08-20 16:21:42', 1, 0, 3),
(14, 'E4B2879A-AB9F-4386-9BFB-9F181AFC8D2F', '2010-08-20 16:21:54', 1, 0, 1),
(15, '039170EF-27FC-4229-87EB-645CC8AF17AD', '2010-08-20 16:22:57', 1, 0, 1),
(16, '8CFB4894-4F7F-4EC2-9FD7-ACC0FB754E7E', '2010-08-20 16:30:43', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `war_ratings`
--

CREATE TABLE IF NOT EXISTS `war_ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ReportKey` varchar(255) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `criteria_id` tinyint(2) unsigned NOT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ReportKey` (`ReportKey`,`criteria_id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `war_ratings`
--

INSERT INTO `war_ratings` (`id`, `ReportKey`, `session_id`, `timestamp`, `criteria_id`, `rating`) VALUES
(1, '35BD5637-4066-43A3-B155-EE2DE816BFDC', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 13:14:13', 1, 1),
(2, '35BD5637-4066-43A3-B155-EE2DE816BFDC', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 13:14:13', 2, 0),
(3, '35BD5637-4066-43A3-B155-EE2DE816BFDC', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 13:14:13', 3, 1),
(4, '02FDE7F0-0253-43FE-8FA4-7BBF8AAE9330', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:17:53', 1, 1),
(5, '02FDE7F0-0253-43FE-8FA4-7BBF8AAE9330', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:17:53', 2, 0),
(6, '02FDE7F0-0253-43FE-8FA4-7BBF8AAE9330', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:17:53', 3, 0),
(7, '3308A29A-AC0E-4FC4-B751-3F24DD7AD8E2', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:33:19', 1, 0),
(8, '3308A29A-AC0E-4FC4-B751-3F24DD7AD8E2', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:33:19', 2, 0),
(9, '3308A29A-AC0E-4FC4-B751-3F24DD7AD8E2', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 14:33:19', 3, 1),
(10, 'EB4BDD2D-CC74-459F-AAA6-71124E192C31', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:16:49', 1, 1),
(11, 'EB4BDD2D-CC74-459F-AAA6-71124E192C31', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:16:49', 2, 0),
(12, 'EB4BDD2D-CC74-459F-AAA6-71124E192C31', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:16:49', 3, 0),
(13, '43835237-E78A-4EF4-866F-73471324B2E9', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:33:00', 1, 1),
(14, '43835237-E78A-4EF4-866F-73471324B2E9', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:33:00', 2, 0),
(15, '43835237-E78A-4EF4-866F-73471324B2E9', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:33:00', 3, 0),
(16, '1008275', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:48:07', 1, 0),
(17, '1008275', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:48:07', 2, 1),
(18, '1008275', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 15:48:07', 3, 0),
(19, 'BC4DD242-7DE9-4FA5-A765-46D1F52A1D00', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:19:45', 1, 1),
(20, 'BC4DD242-7DE9-4FA5-A765-46D1F52A1D00', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:19:45', 2, 1),
(21, 'BC4DD242-7DE9-4FA5-A765-46D1F52A1D00', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:19:45', 3, 0),
(22, 'DBD18A49-B5B7-469E-A2EF-394F34110348', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:21:45', 1, 1),
(23, 'DBD18A49-B5B7-469E-A2EF-394F34110348', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:21:45', 2, 1),
(24, 'DBD18A49-B5B7-469E-A2EF-394F34110348', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:21:45', 3, 1),
(25, 'E4B2879A-AB9F-4386-9BFB-9F181AFC8D2F', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:22:00', 1, 1),
(26, 'E4B2879A-AB9F-4386-9BFB-9F181AFC8D2F', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:22:00', 2, 0),
(27, 'E4B2879A-AB9F-4386-9BFB-9F181AFC8D2F', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:22:00', 3, 0),
(28, '039170EF-27FC-4229-87EB-645CC8AF17AD', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:23:00', 1, 1),
(29, '039170EF-27FC-4229-87EB-645CC8AF17AD', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:23:00', 2, 0),
(30, '039170EF-27FC-4229-87EB-645CC8AF17AD', 'clj6tcjf6a7tdkuvrthcobtea6', '2010-08-20 16:23:00', 3, 0);
