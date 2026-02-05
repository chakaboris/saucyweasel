-- MySQL dump 10.13  Distrib 8.4.7, for Linux (x86_64)
--
-- Host: localhost    Database: weasel
-- ------------------------------------------------------
-- Server version	8.4.7-0ubuntu0.25.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bets` (
  `id` int NOT NULL,
  `gameid` varchar(100) NOT NULL,
  `pick` varchar(100) NOT NULL,
  `wager` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `finals`
--

DROP TABLE IF EXISTS `finals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `finals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `espnid` int NOT NULL,
  `spread` decimal(10,1) NOT NULL,
  `home_team` varchar(6) NOT NULL,
  `home_favorite` int NOT NULL,
  `home_moneyline` int NOT NULL,
  `home_spread` int NOT NULL,
  `away_team` varchar(6) NOT NULL,
  `away_favorite` int NOT NULL,
  `away_moneyline` int NOT NULL,
  `away_spread` int NOT NULL,
  `home_score` int NOT NULL,
  `away_score` int NOT NULL,
  `gametime` datetime NOT NULL,
  `gamestatus` varchar(20) NOT NULL,
  `league` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `espnid` (`espnid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4551 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `league` varchar(10) NOT NULL,
  `espnid` int NOT NULL,
  `spread` decimal(10,1) NOT NULL,
  `home_team` varchar(6) NOT NULL,
  `home_favorite` int NOT NULL,
  `home_moneyline` int NOT NULL,
  `home_spread` int NOT NULL,
  `away_team` varchar(6) NOT NULL,
  `away_favorite` int NOT NULL,
  `away_moneyline` int NOT NULL,
  `away_spread` int NOT NULL,
  `home_score` int NOT NULL,
  `away_score` int NOT NULL,
  `gametime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `espnid` (`espnid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4670 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `games_archive`
--

DROP TABLE IF EXISTS `games_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `games_archive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `league` varchar(10) NOT NULL,
  `espnid` int NOT NULL,
  `spread` decimal(10,1) NOT NULL,
  `home_team` varchar(6) NOT NULL,
  `home_favorite` int NOT NULL,
  `home_moneyline` int NOT NULL,
  `home_spread` int NOT NULL,
  `away_team` varchar(6) NOT NULL,
  `away_favorite` int NOT NULL,
  `away_moneyline` int NOT NULL,
  `away_spread` int NOT NULL,
  `home_score` int NOT NULL,
  `away_score` int NOT NULL,
  `gametime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `espnid` (`espnid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4670 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leagues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `league` varchar(10) NOT NULL,
  `api_url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `league` varchar(10) NOT NULL,
  `shortname` varchar(10) NOT NULL,
  `longname` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `one_color` varchar(10) NOT NULL,
  `two_color` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wagers`
--

DROP TABLE IF EXISTS `wagers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wagers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bettor` varchar(200) NOT NULL,
  `event_id` int NOT NULL,
  `team` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `spread` float NOT NULL,
  `wager_amount` int NOT NULL,
  `resolved` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_and_id` (`bettor`,`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `weasels`
--

DROP TABLE IF EXISTS `weasels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `weasels` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `user` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `playername` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-05 21:30:51
