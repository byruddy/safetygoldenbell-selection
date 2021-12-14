-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.22-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for kp_quiz
CREATE DATABASE IF NOT EXISTS `kp_quiz` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `kp_quiz`;

-- Dumping structure for table kp_quiz.app_config
CREATE TABLE IF NOT EXISTS `app_config` (
  `formula` text NOT NULL COMMENT 'Generate all id question, duplicate for focus question or fail when answer',
  `password` varchar(155) NOT NULL,
  `version` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.m_answers
CREATE TABLE IF NOT EXISTS `m_answers` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mode` enum('test','practice') NOT NULL,
  `id_question` int(10) NOT NULL,
  `answer` tinyint(1) NOT NULL COMMENT 'bool',
  `session_id` char(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_question` (`id_question`)
) ENGINE=InnoDB AUTO_INCREMENT=775 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.m_guests
CREATE TABLE IF NOT EXISTS `m_guests` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date_signin` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.m_questions
CREATE TABLE IF NOT EXISTS `m_questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no` varchar(3) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `sheet` enum('primary','secondary','occupational','disaster','posting') NOT NULL,
  `category` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.m_tests
CREATE TABLE IF NOT EXISTS `m_tests` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `test_date` date NOT NULL,
  `start_date` varchar(8) NOT NULL,
  `end_date` varchar(8) NOT NULL,
  `pass` int(3) NOT NULL,
  `fail` int(3) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `session_id` char(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.participants
CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` char(6) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `join_test` tinyint(4) DEFAULT 0,
  `score` int(11) unsigned DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.question_answers
CREATE TABLE IF NOT EXISTS `question_answers` (
  `question_id` int(11) DEFAULT NULL,
  `a` varchar(255) DEFAULT NULL,
  `b` varchar(255) DEFAULT NULL,
  `c` varchar(255) DEFAULT NULL,
  `d` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table kp_quiz.test_logs
CREATE TABLE IF NOT EXISTS `test_logs` (
  `participant_id` char(6) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `date_choice` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
