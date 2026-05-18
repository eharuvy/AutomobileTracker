-- Automobile Tracker Database Initialization Script
-- Database: misc
-- Created for Ethan Haruvy's Automobile Tracker Application

CREATE DATABASE IF NOT EXISTS `misc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `misc`;

-- --------------------------------------------------------

-- Table structure for table `autos`
DROP TABLE IF EXISTS `autos`;
CREATE TABLE `autos` (
  `auto_id` INT(11) NOT NULL AUTO_INCREMENT,
  `make` VARCHAR(128) DEFAULT NULL,
  `year` INT(11) DEFAULT NULL,
  `mileage` INT(11) DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Optional: Seed data for testing local deployment
-- INSERT INTO `autos` (`make`, `year`, `mileage`) VALUES 
-- ('Toyota Camry', 2018, 45000),
-- ('Honda Civic', 2020, 28000),
-- ('Ford F-150', 2015, 95000);
