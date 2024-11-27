-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: proyectos
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `report_list`
--

DROP TABLE IF EXISTS `report_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `project_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `work_type_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `datetime_from` datetime NOT NULL,
  `datetime_to` datetime NOT NULL,
  `duration` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `comments` text DEFAULT NULL,
  `approval_status` enum('Pendiente','Aprobado','Rechazado') DEFAULT 'Pendiente',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `employee_id` (`employee_id`),
  KEY `work_type_id` (`work_type_id`),
  CONSTRAINT `report_list_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_list_ibfk_2` FOREIGN KEY (`work_type_id`) REFERENCES `work_type_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_list_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_list`
--

LOCK TABLES `report_list` WRITE;
/*!40000 ALTER TABLE `report_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-27  5:43:36
