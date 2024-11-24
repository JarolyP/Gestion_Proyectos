-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2023 a las 01:41:04
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbtareas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(4, 'sistema de ventas online', '												&lt;p&gt;CREACION DE SISTEMA DE VENTAS ONLINE&lt;/p&gt;&lt;p&gt;ESTUDIO&lt;/p&gt;&lt;p&gt;REQUERIMIENTOS&lt;/p&gt;&lt;p&gt;DISE&Ntilde;O&lt;/p&gt;&lt;p&gt;ELABORACION&lt;/p&gt;&lt;p&gt;PRUEBAS.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;										', 0, '2023-07-13', '2023-07-30', 9, '12,10', '2023-07-12 21:10:49'),
(5, 'sistema de control RRHH', '																		&lt;p&gt;Desarrollar sistema de control RRHH&lt;/p&gt;&lt;p&gt;asistencia&lt;/p&gt;&lt;p&gt;vacaciones&lt;/p&gt;&lt;p&gt;permisos&lt;/p&gt;&lt;p&gt;horarios&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;															', 5, '2023-07-10', '2023-07-20', 11, '12,10', '2023-07-12 21:15:32'),
(17, 'sistema de clinica', '						desarrollo de sistema de clinica					', 0, '2023-07-20', '2023-07-30', 11, '13,9,20,12', '2023-07-18 20:58:03'),
(18, 'sistema de facturacion', 'realizar un sistema completo de facturacion', 0, '2023-07-25', '2023-07-30', 11, '29,17', '2023-07-23 01:21:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Sistema de Gestión de Proyectos y Tareas', 'admin@gmail.com', '934454323', 'av. la eternidad s/n', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_list`
--

CREATE TABLE `task_list` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `description`, `status`, `date_created`) VALUES
(5, 4, 'ESTUDIO', '&lt;p&gt;FACTIBILIDAD&lt;/p&gt;&lt;p&gt;RECURSOS&lt;/p&gt;', 1, '2023-07-12 21:12:00'),
(6, 5, 'requerimientos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 3, '2023-07-12 21:16:25'),
(7, 5, 'diseño', '				&lt;p&gt;login&lt;/p&gt;&lt;p&gt;froms&lt;/p&gt;			', 3, '2023-07-12 21:16:53'),
(8, 6, 'requerimientos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 1, '2023-07-12 21:35:12'),
(9, 6, 'diseño', '&lt;p&gt;login&lt;/p&gt;&lt;p&gt;formularios&lt;/p&gt;', 3, '2023-07-12 21:41:20'),
(10, 7, 'requerimientos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 1, '2023-07-13 03:48:39'),
(11, 7, 'diseños ', '&lt;p&gt;login&lt;/p&gt;&lt;p&gt;formularios&lt;/p&gt;', 1, '2023-07-13 04:25:59'),
(12, 9, 'requerimientos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 1, '2023-07-13 14:31:14'),
(13, 13, 'requerimientos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 1, '2023-07-15 07:13:54'),
(14, 14, 'diseño', 'dise&ntilde;o de formularios o modulos', 1, '2023-07-15 07:22:14'),
(15, 18, 'requerimietos', '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 1, '2023-07-23 01:22:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(11, 'rosa', 'rojas', 'rosa@gmail.com', '84109ae4b4178430b8174b1dfef9162b', 2, '1689188580_marcador-de-posicion (1).png', '2023-07-12 21:03:45'),
(17, 'raul', 'rojas ', 'raul@gmail', 'bc7a844476607e1a59d8eb1b1f311830', 3, '1689396540_Imagen1.png', '2023-07-15 06:49:05'),
(27, 'Tarea Completo', '', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 1, '1690054320_tc.png', '2023-07-22 21:32:38'),
(29, 'david', 'roca', 'david@gmail.com', '172522ec1028ab781d9dfd17eaca4427', 3, '1690066860_loro-colorido-pluma-verde-roja-cabeza.jpg', '2023-07-23 01:01:26'),
(30, 'luis', 'perez', 'luis@gmail.com', '502ff82f7f1f8218dd41201fe4353687', 2, '1690067760_loro-colorido-pluma-verde-roja-cabeza.jpg', '2023-07-23 01:16:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `project_id`, `task_id`, `comment`, `subject`, `date`, `start_time`, `end_time`, `user_id`, `time_rendered`, `date_created`) VALUES
(1, 1, 1, '							&lt;p&gt;Sample Progress&lt;/p&gt;&lt;ul&gt;&lt;li&gt;Test 1&lt;/li&gt;&lt;li&gt;Test 2&lt;/li&gt;&lt;li&gt;Test 3&lt;/li&gt;&lt;/ul&gt;																			', 'Sample Progress', '2020-12-03', '08:00:00', '10:00:00', 1, 2, '2020-12-03 12:13:28'),
(2, 1, 1, '							Sample Progress						', 'Sample Progress 2', '2020-12-03', '13:00:00', '14:00:00', 1, 1, '2020-12-03 13:48:28'),
(3, 1, 2, '							Sample						', 'Test', '2020-12-03', '08:00:00', '09:00:00', 5, 1, '2020-12-03 13:57:22'),
(4, 1, 2, 'asdasdasd', 'Sample Progress', '2020-12-02', '08:00:00', '10:00:00', 2, 2, '2020-12-03 14:36:30'),
(5, 4, 5, 'ENTREGAR INFORME DETALLADO DE PROS Y CONTRAS.', 'FACTIBILIDDAD', '2023-07-13', '08:00:00', '05:00:00', 8, -3, '2023-07-12 21:13:31'),
(6, 6, 8, 'entregables documentaci&oacute;n detallado de requerimientos', 'FACTIBILIDAD', '2023-07-14', '08:00:00', '17:00:00', 8, 9, '2023-07-12 21:36:30'),
(7, 7, 10, '&lt;p&gt;informe detallo&lt;/p&gt;&lt;p&gt;casos que se va desarrollar&lt;/p&gt;', 'requerimientos', '2023-07-17', '08:00:00', '13:00:00', 8, 5, '2023-07-13 03:50:32'),
(8, 7, 10, '&lt;p&gt;documentos detallados&lt;/p&gt;&lt;p&gt;informe de los requerimientos&lt;/p&gt;', 'requerimientos', '2023-07-17', '08:00:00', '13:00:00', 8, 5, '2023-07-13 14:32:45'),
(9, 5, 6, '&lt;p&gt;dise&ntilde;o logos&lt;/p&gt;&lt;p&gt;dise&ntilde;o de formularios&lt;/p&gt;', 'diseños', '2023-07-18', '08:00:00', '13:00:00', 8, 5, '2023-07-18 04:06:36'),
(10, 9, 12, '&lt;p&gt;requerimiento funionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 'requerimientos', '2023-07-20', '08:00:00', '11:00:00', 15, 3, '2023-07-18 06:20:33'),
(11, 5, 6, '&lt;p&gt;funcionales&lt;/p&gt;&lt;p&gt;no funcionales&lt;/p&gt;', 'requerimientos', '2023-07-20', '08:00:00', '11:00:00', 8, 3, '2023-07-18 21:00:27'),
(12, 9, 12, 'documentacion', 'requerimientos', '2023-07-21', '08:00:00', '11:00:00', 15, 3, '2023-07-18 21:05:29'),
(13, 18, 15, 'informe de requerimientos', 'requerimientos', '2023-07-25', '08:00:00', '11:00:00', 17, 3, '2023-07-23 01:28:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
