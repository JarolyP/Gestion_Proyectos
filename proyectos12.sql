-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_list`
--

LOCK TABLES `employee_list` WRITE;
/*!40000 ALTER TABLE `employee_list` DISABLE KEYS */;
INSERT INTO `employee_list` VALUES (6,'2022-0005','Juan','','Empleado','Male','jempleado@cweb.com','Tecnologías Información','Líder de Desarrollo','84fb4ea96934cc52c6ab2851c38f8a92','g9cd0arm',1,'uploads/employee-6.png?v=1642970869','2022-01-23 15:47:49','2022-01-23 15:51:39'),(10,'','Jaroly','asdfadfaf','Polanco','Hombre','jobs13az@gmail.com','Desarrollo','Tecnico','06305e2e9d85745cdc2ae1ea00a413fc','mosa8guv',0,NULL,'2024-11-22 19:52:01','2024-11-26 17:22:19');
/*!40000 ALTER TABLE `employee_list` ENABLE KEYS */;
UNLOCK TABLES;

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
  `end_date` date DEFAULT NULL,
  `responsible` varchar(255) NOT NULL,
  `status` enum('Nuevo','En Proceso','Cancelado','Terminado','Pendiente','Cerrado') NOT NULL DEFAULT 'Nuevo' COMMENT 'Estado del proyecto',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_list`
--

LOCK TABLES `project_list` WRITE;
/*!40000 ALTER TABLE `project_list` DISABLE KEYS */;
INSERT INTO `project_list` VALUES (19,'Gestión de Usuarios','Sistema de gestión de usuarios para la web','Desarrollar un sistema de gestión de usuarios con registro, inicio de sesión y administración.','2024-12-01','2025-06-01','Juan Pérez','En Proceso',0,'2024-11-26 10:00:00',NULL),(20,'E-commerce','Desarrollo de una plataforma de comercio electrónico','Construir una plataforma de ventas online con carrito de compras, gestión de inventarios y pagos integrados.','2024-11-15','2025-05-01','Carlos Ramírez','Nuevo',0,'2024-11-26 11:00:00',NULL),(21,'Aplicación Móvil','Aplicación móvil para gestión de tareas','Crear una app que permita a los usuarios gestionar sus tareas diarias, con notificaciones y sincronización en la nube.','2024-12-10','2025-04-30','Maria López','Pendiente',0,'2024-11-26 12:00:00',NULL),(22,'Gestión de Usuarios','Sistema de gestión de usuarios para la web','Desarrollar un sistema de gestión de usuarios con registro, inicio de sesión y administración.','2024-12-01','2025-06-01','Juan Pérez','En Proceso',0,'2024-11-26 10:00:00',NULL),(23,'E-commerce','Desarrollo de una plataforma de comercio electrónico','Construir una plataforma de ventas online con carrito de compras, gestión de inventarios y pagos integrados.','2024-11-15','2025-05-01','Carlos Ramírez','Nuevo',0,'2024-11-26 11:00:00',NULL),(24,'hjgkgh','','','0000-00-00','0000-00-00','6','Nuevo',0,'2024-11-26 21:09:47',NULL);
/*!40000 ALTER TABLE `project_list` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `employee_id` (`employee_id`),
  KEY `work_type_id` (`work_type_id`),
  CONSTRAINT `report_list_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_list_ibfk_2` FOREIGN KEY (`work_type_id`) REFERENCES `work_type_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `report_list_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_list`
--

LOCK TABLES `report_list` WRITE;
/*!40000 ALTER TABLE `report_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_info`
--

DROP TABLE IF EXISTS `system_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_info` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_info`
--

LOCK TABLES `system_info` WRITE;
/*!40000 ALTER TABLE `system_info` DISABLE KEYS */;
INSERT INTO `system_info` VALUES (1,'name','ProManage'),(6,'short_name','SGPT'),(11,'logo','uploads/logo-1642992408.png'),(13,'user_avatar','uploads/user_avatar.jpg'),(14,'cover','uploads/cover-1642991902.png');
/*!40000 ALTER TABLE `system_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_list`
--

DROP TABLE IF EXISTS `task_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `estimated_start_date` date DEFAULT NULL,
  `estimated_end_date` date DEFAULT NULL,
  `actual_start_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `status` enum('Pendiente','En Proceso','Completada','Cancelada') NOT NULL DEFAULT 'Pendiente',
  `responsible` varchar(255) NOT NULL,
  `progress` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `task_type` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  KEY `fk_task_project` (`project_id`),
  CONSTRAINT `fk_task_project` FOREIGN KEY (`project_id`) REFERENCES `project_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_list`
--

LOCK TABLES `task_list` WRITE;
/*!40000 ALTER TABLE `task_list` DISABLE KEYS */;
INSERT INTO `task_list` VALUES (1,101,19,'Diseño de interfaz','Diseñar la interfaz de usuario para el sistema de gestión de usuarios.','2024-12-01','2024-12-10','2024-12-01','2024-12-09','Pendiente','Juan Pérez',0,'Diseño','2024-11-26 10:00:00'),(2,102,20,'Desarrollo de backend','Desarrollar la API para la gestión de usuarios y sus roles.','2024-12-05','2024-12-20','2024-12-05','2024-12-19','En Proceso','Carlos Ramírez',50,'Desarrollo','2024-11-26 11:00:00'),(3,103,21,'Configuración de servidor','Configurar el servidor para la plataforma de e-commerce.','2024-11-18','2024-11-25','2024-11-18','2024-11-24','Completada','Maria López',100,'Infraestructura','2024-11-26 12:00:00');
/*!40000 ALTER TABLE `task_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jaroly',NULL,'POlanco','jobs13az@gmail.com','19936568633e70a099de8080e7107196','uploads/avatar-1.png?v=1643057611',NULL,1,1,'2021-01-20 14:02:37','2024-11-22 19:13:32'),(6,'Juan',NULL,'Usuario','jusuario','4b67deeb9aba04a5b54632ad19934f26','uploads/avatar-6.png?v=1642971757',NULL,2,1,'2022-01-08 16:04:17','2022-01-23 16:02:37'),(7,'Jaroly',NULL,'Polanco','JarolyPolanco@gmail.com','19936568633e70a099de8080e7107196',NULL,NULL,2,1,'2024-11-24 18:30:36',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_type_list`
--

LOCK TABLES `work_type_list` WRITE;
/*!40000 ALTER TABLE `work_type_list` DISABLE KEYS */;
INSERT INTO `work_type_list` VALUES (1,'Soporte Técnico','El soporte técnico, por lo tanto, es una asistencia que brindan las empresas para que sus clientes puedan hacer uso de sus productos o servicios.',1,0,'2022-01-12 11:30:31','2022-01-23 16:23:38'),(2,'Tecnología','La tecnología es el conjunto de conocimientos y técnicas que se aplican de manera ordenada para alcanzar un determinado objetivo o resolver un problema.',1,0,'2022-01-12 11:31:53','2022-01-23 16:26:31'),(3,'Validación Conexiones','Definición de consulta de validación, Obligatoria. Manejo de las conexiones con la base de datos, Obligatoria. Configuración del auto-commit, Obligatoria.',1,0,'2022-01-12 11:32:15','2022-01-23 16:21:07'),(4,'Control de Calidad','La función principal del control de calidad es asegurar que los productos o servicios cumplan con los requisitos mínimos de calidad.',1,0,'2022-01-12 11:32:36','2022-01-23 16:19:51'),(5,'Pruebas QA','En primer lugar tenemos las Pruebas Software Funcionales. Típicamente encontraremos el comportamiento del sistema, subsistema o componente software descrito en las especificaciones de requisitos o casos de uso, aunque también puede no estar documentado («que funcione como el sistema al que sustituye») . Es decir, con las funciones establecemos “lo que el sistema hace”.',1,0,'2022-01-12 11:33:13','2022-01-23 16:27:31'),(6,'Diseño GUI','Una interfaz gráfica de usuario (GUI), es donde coinciden el diseño de la interacción y el de la interfaz. Una interfaz es sólo la manifestación visual de \"inter\" actividades; sólo es un aspecto del diseño de interacción, no el mismo diseño de la interacción.',1,0,'2022-01-12 11:34:54','2022-01-23 16:16:43'),(7,'Mantenimiento Infraestructura','Es la actividad relacionada con la conservación de la infraestructura, maquinaria y equipo, que permite un mejor desempeño de operación del bien y reducción del nivel de riesgo de fallos y/o daños humanos y materiales.',0,0,'2022-01-12 11:35:14','2022-01-23 16:18:57'),(8,'Beta Testing','n faucibus posuere sodales. Maecenas euismod, neque id consectetur ullamcorper, nisi erat ultrices urna, sit amet auctor odio magna vitae magna. Suspendisse a diam pellentesque, efficitur lacus eu, facilisis lacus',1,1,'2022-01-12 11:35:31','2022-01-12 11:35:37');
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

-- Dump completed on 2024-11-26 21:50:56
