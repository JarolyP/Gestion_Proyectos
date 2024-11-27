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
-- Table structure for table `work_type_list`
--

DROP TABLE IF EXISTS `work_type_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_type_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `category` varchar(100) DEFAULT 'General',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_type_list`
--

LOCK TABLES `work_type_list` WRITE;
/*!40000 ALTER TABLE `work_type_list` DISABLE KEYS */;
INSERT INTO `work_type_list` VALUES (1,'Soporte Técnico','El soporte técnico, por lo tanto, es una asistencia que brindan las empresas para que sus clientes puedan hacer uso de sus productos o servicios.',1,0,'2022-01-12 11:30:31','2022-01-23 16:23:38','General'),(2,'Tecnología','La tecnología es el conjunto de conocimientos y técnicas que se aplican de manera ordenada para alcanzar un determinado objetivo o resolver un problema.',1,0,'2022-01-12 11:31:53','2022-01-23 16:26:31','General'),(3,'Validación Conexiones','Definición de consulta de validación, Obligatoria. Manejo de las conexiones con la base de datos, Obligatoria. Configuración del auto-commit, Obligatoria.',1,0,'2022-01-12 11:32:15','2022-01-23 16:21:07','General'),(4,'Control de Calidad','La función principal del control de calidad es asegurar que los productos o servicios cumplan con los requisitos mínimos de calidad.',1,0,'2022-01-12 11:32:36','2022-01-23 16:19:51','General'),(5,'Pruebas QA','En primer lugar tenemos las Pruebas Software Funcionales. Típicamente encontraremos el comportamiento del sistema, subsistema o componente software descrito en las especificaciones de requisitos o casos de uso, aunque también puede no estar documentado («que funcione como el sistema al que sustituye») . Es decir, con las funciones establecemos “lo que el sistema hace”.',1,0,'2022-01-12 11:33:13','2022-01-23 16:27:31','General'),(6,'Diseño GUI','Una interfaz gráfica de usuario (GUI), es donde coinciden el diseño de la interacción y el de la interfaz. Una interfaz es sólo la manifestación visual de \"inter\" actividades; sólo es un aspecto del diseño de interacción, no el mismo diseño de la interacción.',1,0,'2022-01-12 11:34:54','2022-01-23 16:16:43','General'),(7,'Mantenimiento Infraestructura','Es la actividad relacionada con la conservación de la infraestructura, maquinaria y equipo, que permite un mejor desempeño de operación del bien y reducción del nivel de riesgo de fallos y/o daños humanos y materiales.',0,0,'2022-01-12 11:35:14','2022-01-23 16:18:57','General'),(8,'Beta Testing','n faucibus posuere sodales. Maecenas euismod, neque id consectetur ullamcorper, nisi erat ultrices urna, sit amet auctor odio magna vitae magna. Suspendisse a diam pellentesque, efficitur lacus eu, facilisis lacus',1,1,'2022-01-12 11:35:31','2022-01-12 11:35:37','General');
/*!40000 ALTER TABLE `work_type_list` ENABLE KEYS */;
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
