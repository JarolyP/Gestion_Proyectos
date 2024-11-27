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
-- Table structure for table `project_list`
--

DROP TABLE IF EXISTS `project_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `start_date` date DEFAULT NULL,
  `actual_start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `responsible` varchar(255) NOT NULL,
  `status` enum('Nuevo','En Proceso','Cancelado','Terminado','En Planificación') NOT NULL DEFAULT 'Nuevo' COMMENT 'Estado del proyecto',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `budget` decimal(10,2) DEFAULT 0.00,
  `priority` enum('Alta','Media','Baja') DEFAULT 'Media',
  `start_date_real` date DEFAULT NULL,
  `end_date_real` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_list`
--

LOCK TABLES `project_list` WRITE;
/*!40000 ALTER TABLE `project_list` DISABLE KEYS */;
INSERT INTO `project_list` VALUES (25,'dasfafdaas','','fdadsfasf','2024-11-09',NULL,'2024-11-23',NULL,'','En Planificación',0,'2024-11-27 03:29:36',NULL,0.00,'Media',NULL,NULL),(26,'Prueba','','jañsdjflkasjfjaasjfñj','2024-11-02',NULL,'2024-11-30',NULL,'7','En Planificación',1,'2024-11-27 04:33:34','2024-11-27 04:57:32',0.00,'Media',NULL,NULL),(27,'','','','0000-00-00',NULL,'0000-00-00',NULL,'','',0,'2024-11-27 04:44:10',NULL,0.00,'Media','0000-00-00','0000-00-00'),(28,'sjjfkajdsjfksafdjflñdsfjafklñasf','','','0000-00-00',NULL,'0000-00-00',NULL,'','',0,'2024-11-27 05:06:07',NULL,0.00,'Media','0000-00-00','0000-00-00'),(29,'asdfadsfsf','','','0000-00-00',NULL,'0000-00-00',NULL,'','',0,'2024-11-27 05:10:38',NULL,0.00,'Media','0000-00-00','0000-00-00'),(30,'dfdffdfddfdfdfdfdfdfddfd','','','0000-00-00',NULL,'0000-00-00',NULL,'','',0,'2024-11-27 05:10:48',NULL,0.00,'Media','0000-00-00','0000-00-00'),(31,'dsfasafasfdasfsfafasfasfsfdsa','','','0000-00-00',NULL,'0000-00-00',NULL,'','',0,'2024-11-27 05:29:09',NULL,0.00,'Media','0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `project_list` ENABLE KEYS */;
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
