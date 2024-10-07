-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2022 a las 22:36:03
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyectos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_list`
--

CREATE TABLE `employee_list` (
  `id` int(30) NOT NULL,
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
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `employee_list`
--

INSERT INTO `employee_list` (`id`, `code`, `firstname`, `middlename`, `lastname`, `gender`, `email`, `department`, `position`, `password`, `generated_password`, `status`, `avatar`, `date_created`, `date_updated`) VALUES
(2, '2022-0002', 'Eduardo', '', 'Empleado', 'Male', 'eempleado@cweb.com', 'Tecnologías Información', 'Analista QA', '19e36ca1b52bb940291854cd5cd50328', 'j295eq4f', 1, 'uploads/employee-2.png?v=1642972068', '2022-01-12 13:46:11', '2022-01-23 16:07:48'),
(6, '2022-0005', 'Juan', '', 'Empleado', 'Male', 'jempleado@cweb.com', 'Tecnologías Información', 'Líder de Desarrollo', '84fb4ea96934cc52c6ab2851c38f8a92', 'g9cd0arm', 1, 'uploads/employee-6.png?v=1642970869', '2022-01-23 15:47:49', '2022-01-23 15:51:39'),
(9, '2022-0006', 'Daniel', '', 'Velasco', 'Male', 'dvelasco@cweb.com', 'Tecnologías Información', 'Líder de Desarrollo', '3b48c801368b940f94101a114cba17d5', 'i5ggrsmf', 1, 'uploads/employee-9.png?v=1643923822', '2022-02-03 16:30:22', '2022-02-03 16:30:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= New, 1= In-Progress, 2= Closed',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(6, 'Proyecto Análisis Bases de Datos', 'Proyectos de análisis de información de las bases de datos del departamento de IT de la Empresa AMCORD', 1, 0, '2022-01-23 15:43:14', '2022-01-23 15:53:21'),
(7, 'Implementar Sistema Gestor de Tareas', 'Se modifica el sistema Gestor de Tareas, se le generan nuevas pantallas.', 1, 0, '2022-02-03 16:27:42', '2022-02-03 16:31:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report_list`
--

CREATE TABLE `report_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `work_type_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `datetime_from` datetime NOT NULL,
  `datetime_to` datetime NOT NULL,
  `duration` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `report_list`
--

INSERT INTO `report_list` (`id`, `project_id`, `employee_id`, `work_type_id`, `description`, `datetime_from`, `datetime_to`, `duration`, `date_created`, `date_updated`) VALUES
(8, 6, 6, 5, '&lt;p&gt;Se realizan las validaciones pertinentes de&amp;nbsp;&lt;span style=&quot;font-size: 1rem;&quot;&gt;Recopilaci&oacute;n de informaci&oacute;n, Autenticaci&oacute;n, Denegaci&oacute;n de Servicio, Sesiones, Validaci&oacute;n de Datos, Inspecciones Manuales, Modelamiento de Amenazas.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;Pendientes 3 sesiones de pruebas m&aacute;s.&lt;/p&gt;', '2022-01-23 16:00:00', '2022-01-23 17:00:00', 3600, '2022-01-23 16:00:16', NULL),
(9, 6, 2, 4, '&lt;p&gt;Se valida la calidad de las conexiones de la base de datos principal, la que valida las credenciales de los usuarios con cinco niveles de acceso.&lt;/p&gt;&lt;p&gt;Se coteja la redundancia entre los servidores de seguridad, los tiempos de respuesta son los esperados.&lt;/p&gt;', '2022-01-23 16:00:00', '2022-01-23 17:00:00', 3600, '2022-01-23 16:12:13', NULL),
(10, 7, 9, 2, '&lt;p&gt;Se realiza la primera reuni&oacute;n del proyecto con el objeto de tomar todos los requerimientos espec&iacute;ficos de los cambios a realizar en la aplicaci&oacute;n.&lt;/p&gt;', '2022-02-04 16:00:00', '2022-02-04 20:00:00', 14400, '2022-02-03 16:31:57', '2022-02-03 16:33:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Sistema de Gestión de Proyectos en PHP y MYSQL'),
(6, 'short_name', 'SGP'),
(11, 'logo', 'uploads/logo-1642992408.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1642991902.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
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
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Mauricio', NULL, 'Sevilla', 'configuroweb', '4b67deeb9aba04a5b54632ad19934f26', 'uploads/avatar-1.png?v=1643057611', NULL, 1, 1, '2021-01-20 14:02:37', '2022-01-24 15:53:31'),
(6, 'Juan', NULL, 'Usuario', 'jusuario', '4b67deeb9aba04a5b54632ad19934f26', 'uploads/avatar-6.png?v=1642971757', NULL, 2, 1, '2022-01-08 16:04:17', '2022-01-23 16:02:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `work_type_list`
--

CREATE TABLE `work_type_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `work_type_list`
--

INSERT INTO `work_type_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Soporte Técnico', 'El soporte técnico, por lo tanto, es una asistencia que brindan las empresas para que sus clientes puedan hacer uso de sus productos o servicios.', 1, 0, '2022-01-12 11:30:31', '2022-01-23 16:23:38'),
(2, 'Tecnología', 'La tecnología es el conjunto de conocimientos y técnicas que se aplican de manera ordenada para alcanzar un determinado objetivo o resolver un problema.', 1, 0, '2022-01-12 11:31:53', '2022-01-23 16:26:31'),
(3, 'Validación Conexiones', 'Definición de consulta de validación, Obligatoria. Manejo de las conexiones con la base de datos, Obligatoria. Configuración del auto-commit, Obligatoria.', 1, 0, '2022-01-12 11:32:15', '2022-01-23 16:21:07'),
(4, 'Control de Calidad', 'La función principal del control de calidad es asegurar que los productos o servicios cumplan con los requisitos mínimos de calidad.', 1, 0, '2022-01-12 11:32:36', '2022-01-23 16:19:51'),
(5, 'Pruebas QA', 'En primer lugar tenemos las Pruebas Software Funcionales. Típicamente encontraremos el comportamiento del sistema, subsistema o componente software descrito en las especificaciones de requisitos o casos de uso, aunque también puede no estar documentado («que funcione como el sistema al que sustituye») . Es decir, con las funciones establecemos “lo que el sistema hace”.', 1, 0, '2022-01-12 11:33:13', '2022-01-23 16:27:31'),
(6, 'Diseño GUI', 'Una interfaz gráfica de usuario (GUI), es donde coinciden el diseño de la interacción y el de la interfaz. Una interfaz es sólo la manifestación visual de \"inter\" actividades; sólo es un aspecto del diseño de interacción, no el mismo diseño de la interacción.', 1, 0, '2022-01-12 11:34:54', '2022-01-23 16:16:43'),
(7, 'Mantenimiento Infraestructura', 'Es la actividad relacionada con la conservación de la infraestructura, maquinaria y equipo, que permite un mejor desempeño de operación del bien y reducción del nivel de riesgo de fallos y/o daños humanos y materiales.', 0, 0, '2022-01-12 11:35:14', '2022-01-23 16:18:57'),
(8, 'Beta Testing', 'n faucibus posuere sodales. Maecenas euismod, neque id consectetur ullamcorper, nisi erat ultrices urna, sit amet auctor odio magna vitae magna. Suspendisse a diam pellentesque, efficitur lacus eu, facilisis lacus', 1, 1, '2022-01-12 11:35:31', '2022-01-12 11:35:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `employee_list`
--
ALTER TABLE `employee_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `report_list`
--
ALTER TABLE `report_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `work_type_id` (`work_type_id`);

--
-- Indices de la tabla `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `work_type_list`
--
ALTER TABLE `work_type_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `employee_list`
--
ALTER TABLE `employee_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `report_list`
--
ALTER TABLE `report_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `work_type_list`
--
ALTER TABLE `work_type_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `report_list`
--
ALTER TABLE `report_list`
  ADD CONSTRAINT `report_list_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_list_ibfk_2` FOREIGN KEY (`work_type_id`) REFERENCES `work_type_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_list_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
