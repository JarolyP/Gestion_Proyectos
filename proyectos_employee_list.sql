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
-- Table structure for table `employee_list`
--

DROP TABLE IF EXISTS `employee_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `department` text NOT NULL,
  `position` text NOT NULL,
  `password` text NOT NULL,
  `generated_password` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_list`
--

LOCK TABLES `employee_list` WRITE;
/*!40000 ALTER TABLE `employee_list` DISABLE KEYS */;
INSERT INTO `employee_list` VALUES (6,'2022-0005','Juan','','Empleado','Male','jempleado@cweb.com','Tecnologías Información','Líder de Desarrollo','84fb4ea96934cc52c6ab2851c38f8a92','g9cd0arm',1,'uploads/employee-6.png?v=1642970869','2022-01-23 15:47:49','2022-01-23 15:51:39',NULL,NULL),(10,'','Jaroly','asdfadfaf','Polanco','Female','jobs13az@gmail.com','Desarrollo','Tecnico','06305e2e9d85745cdc2ae1ea00a413fc','mosa8guv',1,NULL,'2024-11-22 19:52:01',NULL,NULL,NULL),(11,'ADM001','Admin',NULL,'User','Male','admin@example.com','Administration','Administrator','0192023a7bbd73250516f069df18b500',NULL,1,NULL,'2024-11-26 23:58:54',NULL,NULL,NULL);
/*!40000 ALTER TABLE `employee_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-27  5:43:37
