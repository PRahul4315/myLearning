-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: todo
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `taskdetail`
--

DROP TABLE IF EXISTS `taskdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taskdetail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taskid` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `updatedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taskdetail`
--

LOCK TABLES `taskdetail` WRITE;
/*!40000 ALTER TABLE `taskdetail` DISABLE KEYS */;
INSERT INTO `taskdetail` VALUES (1,4,1,'2025-10-07 02:00:00',NULL),(2,5,1,'2025-10-08 02:00:00',NULL),(3,5,1,'2025-10-10 02:00:00',NULL),(4,5,1,'2025-10-09 02:00:00',NULL),(5,4,1,'2025-10-11 02:00:00',NULL),(6,4,1,'2025-10-12 02:00:00',NULL),(7,5,1,'2025-10-12 02:00:00',NULL),(8,5,1,'2025-10-13 02:00:00',NULL),(9,6,1,'2025-10-13 02:00:00',NULL),(10,7,1,'2025-10-13 02:00:00',NULL),(11,8,1,'2025-10-13 02:00:00',NULL),(12,6,1,'2025-10-16 02:00:00',NULL);
/*!40000 ALTER TABLE `taskdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taskname`
--

DROP TABLE IF EXISTS `taskname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taskname` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task` varchar(45) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `createdon` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taskname`
--

LOCK TABLES `taskname` WRITE;
/*!40000 ALTER TABLE `taskname` DISABLE KEYS */;
INSERT INTO `taskname` VALUES (4,'A',1,'2025-10-16 00:00:00',NULL),(5,'B',1,'2025-10-16 00:00:00',NULL),(6,'C',1,'2025-10-16 00:00:00',NULL),(7,'D',1,'2025-10-16 00:00:00',NULL),(8,'E',1,'2025-10-16 00:00:00',NULL);
/*!40000 ALTER TABLE `taskname` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-16 18:38:53
