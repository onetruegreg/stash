-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: stash
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_09_18_020741_create_jobs_table',1),(4,'2017_09_18_025631_create_failed_jobs_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'kvothe11@university.edu','111-111-1120','Kvothe, Son of Arliden','d633c22f5ae0c39d7363ab002feacd8d7eeb598ca012d986efbf153da1285b46','aa8453829ffd0c213d26e5f6da1c8e505a03ddd0',NULL,'Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 01:21:10','2017-09-18 01:21:10','hRWyZEVjE4UWiCgqcBaxPdtYOjxztDhi'),(2,'kvothe12@university.edu','111-111-1122','Kvothe, Son of Arliden','74a80deeed857f156d891503fd5e3b6a6306281ae916ff0a2cfb5f19c05d2e85','d18e2ef56130aaeb99aedccfb56ca9f92577c191',NULL,'Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 03:09:28','2017-09-18 03:09:28','ZvM5EB50TsAyK26bnAxhZDAThmM6uQU8'),(4,'kvothe13@university.edu','111-111-1123','Kvothe, Son of Arliden','41039b1db6bf8073659d9acfe02384ca4988400174a09bb0ce24eea329ded15e','ff765ea8af07d8ccef20d52e367553dada000a98','a037ae7da4461fb0cb3424c81a7c7aef','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 03:17:31','2017-09-18 03:31:14','WrXUVi1PREZfbg5rdBmm6ge0H0UpigvW'),(5,'kvothe14@university.edu','111-111-1124','Kvothe, Son of Arliden','e5057ee45e25037a91295fb9b8f6535170cf8f6281a1d444c8dc5b457317d0e8','50325717e8eac5a72b49642514e41ac10054b7f4','766d5fd728bf48646d4d58f6e9ddf3be','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 03:28:00','2017-09-18 03:32:33','mejl6tlbXV2A2UhefJ93GDy967pbXhQR'),(6,'kvothe15@university.edu','111-111-1125','Kvothe, Son of Arliden','154bec7ebe72a8ff97c08240b0abc150e879c3cb9a37d33c95f3012fb3bfa8b5','ffa905e8e9684b568cf8ce30ebeb6474c625b32d','73260c96940edd43f6d3515e03760092','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 03:28:47','2017-09-18 03:31:54','c5C8x9DcPNrEPqlb8GIwB0QgS2yGAgyK'),(7,'kvothe16@university.edu','111-111-1126','Kvothe, Son of Arliden','f319a7de4ff0cb0512d2fc37a7e69520e5c52205c108a8096ada761860d3ea18','92a40e0d4b37b5564d26bf8a151d7d4dafa8d1ec','7c9a1ad5315d8ea2537479c34b27ca4f','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 03:30:37','2017-09-18 03:31:14','HBN6GFdE8r8jqEJqwHtZ05vCb7r9j62H'),(9,'kvothe17@university.edu','111-111-1127','Kvothe, Son of Arliden','17a2bc674e74b181911909300dd13e33957d5439cbbfbed49d2cf72e42538085','bf21296f8a867909f423628680651af20af271a6','3382b0021719a11f1597815e08a376b7','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 05:17:18','2017-09-18 05:17:38','KQj2gSzw6qzImbDbDazek5MJ1tSvVqXU'),(10,'bobdole@us.gov','211-111-1127','Bob Dole','3b886a38ec0567ca5110372970d7cc42be1dc1cfbe062721c0820b2e9873e8af','58175b41614a5899ec0c0926fa7efe1574eb3d29','96ea1d466cd527fb5be9d82c253fc675','Robert Joseph Dole (born July 22, 1923) is an American lawyer and politician who represented Kansas in Congress from 1961 to 1996 and served as the Republican Leader of the United States Senate from 1985 until 1996. He was the Republican presidential nominee in the 1996 presidential election and the party\'s vice presidential nominee in the 1976 presidential election.','2017-09-18 05:19:53','2017-09-18 05:19:55','DrRoYZXYh6HAnvwEH05wfsRE6tJ9g3yC'),(12,'kvothe18@university.edu','111-111-1128','Kvothe, Son of Arliden','bc88ebf06975b746858b59e632b6b32ecc8088dedd26cbc55d16df6a55f0f649','2b9e82ead4aec25a615130911589985c9c64b973','b735f8428ec484a936cf8f0157163763','Kote, Reshi, Maedre, Red, E\'lir, Dulator, Shadicar, Lightfinger, Six-String, the Bloodless, the Arcane, Kingkiller','2017-09-18 06:38:04','2017-09-18 06:38:07','a0O1isSFuvGtoCSCH8tSrhQXXuQMFrRO'),(15,'bobdole2@us.gov','212-111-1127','Bob Dole','555d7ee1cbbe04049c5bfbdc622c1c7638b0b2a3aa5ad5a66b53e1143eda16cf','c654e5209e96e1636321286f5ff46fb9605aadb4','29c0c285ab4fea30f06a407a37f70c7b','Robert Joseph Dole (born July 22, 1923) is an American lawyer and politician who represented Kansas in Congress from 1961 to 1996 and served as the Republican Leader of the United States Senate from 1985 until 1996. He was the Republican presidential nominee in the 1996 presidential election and the party\'s vice presidential nominee in the 1976 presidential election.','2017-09-18 07:39:22','2017-09-18 07:39:25','8LgNITSV3JnRK11JVzHTrfaclZXUyTSb'),(18,'ricksanchez@flermulon.quanto','111-000-0000','Rick Sanchez','15b6f7b791cf75e6bbeaa253d3c8c9917d38745f3e4a33f414a4df803e2b566d','8e0a242e5054d7fade745e7a5a53359c1400a4d8','9482fdeb1234d28f2e9a093e8d1ce1c5','Rick Sanchez (voiced by Justin Roiland) – A genius scientist who is the father of Beth Smith and the maternal grandfather of Morty and Summer. His alcoholic tendencies lead his daughter\'s family to worry about the safety of their son Morty.','2017-09-18 17:11:22','2017-09-18 17:22:29','Q87ETftNK8tljF0OWPGKOuJbkucOdyxk'),(20,'sirrobin@camelot.gov','333-000-0000','Sir Robin The-Not-Quite-So-Brave-As-Sir-Lancelot','f62011d6daf4a2939648876379c07151ec0267d71a2c6f143dc114d1081c2f89','09927c7b84e1f9392271df2603f8bfa23b7980a0','ad5043dd2ab021437176020a40bcb2af','Bravely bold Sir Robin rode forth from Camelot. He was not afraid to die, oh brave Sir Robin. He was not at all afraid to be killed in nasty ways, brave, brave, brave, brave Sir Robin. He was not in the least bit scared to be mashed into a pulp, or to have his eyes gouged out, and his elbows broken. To have his kneecaps split, and his body burned away, and his limbs all hacked and mangled, brave Sir Robin. His head smashed in and heart cut out, and his liver removed, and his bowels unplugged, and his nostrils-','2017-09-18 17:17:18','2017-09-18 17:22:31','UTA5Dd6iSqZcLo20Kh6b2J5DBlcLiXdC'),(23,'gohan@piccolo.edu','222-222-0000','Son Gohan','e11360c84c900f20f84d155c5d050b304b014715d8732c2998b3f54db7097923','9de61e2b885ecd11778b7d6d8016dc1158df255c','b139d355244cbec0b5d18f2a5220ff19','All I do is study and fight aliens, what is my life? I guess I\'m brave though.','2017-09-18 17:31:07','2017-09-18 17:31:10','dYb1LepTAu15vUkBoN8x494WSM3OVIhE'),(24,'goku@turtleschool.edu','222-000-0000','Son Goku','ac5f0ab2c906703d3314bfd45d444b46132ada78bc11624125ee95bbd56d5cbb','e1ede590eee62f63ce9ad70332b1a313b503bc53','76bcd895f55ad35bdfab3d93c8ad0e0f','I am the hope of the universe. I am the answer to all living things that cry out for peace. I am protector of the innocent. I am the light in the darkness. I am truth. Ally to good! Nightmare to you! Father of Gohan.','2017-09-18 17:31:46','2017-09-18 17:31:49','Uvxac0weccnOm9eiAEtgBcBUB95JScbl');
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

-- Dump completed on 2017-09-18 14:37:54
