-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: phpunit
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `account_key` varchar(100) DEFAULT NULL,
  `metadata` varchar(2000) DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `USER_UNIQUE` (`user_id`),
  UNIQUE KEY `EMAIL_UNIQUE` (`email`),
  UNIQUE KEY `PHONE_NUMBER_UNIQUE` (`phone_number`),
  UNIQUE KEY `KEY_UNIQUE` (`key`),
  UNIQUE KEY `ACCOUNT_KEY_UNIQUE` (`account_key`)
) ENGINE=InnoDB AUTO_INCREMENT=1338 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'jrico@mobileinfantry.mil','123-456-7890','Juan \"Johnny\" Rico','38211e0b592974cc81d97968b00b1d43c9e81563cb5fa888fcbc212e62bfa18f','28ede3e46155ad82e0c34fe151dc6e568392875c','2269900bf472e4c02eaddd78c8b4006e','Aliases: John, Johnny, Johnnie; Gender: Male; Occupation: Soldier; Nationality: Argentine;','2017-09-18 16:35:02','2017-09-18 16:35:03','IrYQb6AVEnP6TqgP1hRPo2jN1AsLTJls'),(2,'czim@mobileinfantry.mil','456-456-7890','Charles \"Charlie\" Zim','7ac54dde3b633ca259ee84ca1738ff2d245a721081f5dbce6f1ebdd70abb4406','17e719d8d19e5c3fae034ef6824a35b5b711493e','0f04b08be005fdcfca158a192edb75d3','John Rico\'s boot-camp training instructor and a company commander at Camp Currie.','2017-09-18 16:35:03','2017-09-18 16:35:03','RK384sWmWCCmyOHEyQtRC6wgxrd3bc2s'),(1337,'elodin@theuniversity.edu','222-222-2222','Master Elodin','e5057ee45e25037a91295fb9b8f6535170cf8f6281a1d444c8dc5b457317d0e8','aa8453829ffd0c213d26e5f6da1c8e505a03ddd0','4494a7242d71e1c73f4205b4eca09c7a','Master Elodin was an exceptionally brilliant student and also the youngest to have ever been \n                admitted to the University, at the age of 14. By the time he turned 18, he had become a Full Arcanist \n                and began working as a Giller. He continued on to become Master Namer and then Chancellor of the \n                University, though this was short lived.','2017-09-18 16:35:03','2017-09-18 16:35:03','mejl6tlbXV2A2UhefJ93GDy967pbXhQR');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-18 14:36:05
