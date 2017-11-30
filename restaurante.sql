-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2017 a las 15:07:28
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--
CREATE DATABASE IF NOT EXISTS `restaurante` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `restaurante`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE IF NOT EXISTS `ingredientes` (
  `in_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `in_nombre` varchar(70) NOT NULL,
  `in_unidad` varchar(5) NOT NULL,
  PRIMARY KEY (`in_id`),
  KEY `in_nombre` (`in_nombre`),
  KEY `in_unidad` (`in_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`in_id`, `in_nombre`, `in_unidad`) VALUES
(1, 'TORTILLAS', 'PZAS'),
(2, 'QUESO', 'GR'),
(3, 'ARROZ', 'TZ'),
(4, 'SAL', 'GR'),
(5, 'PIMIENTA', 'GR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
CREATE TABLE IF NOT EXISTS `ordenes` (
  `or_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `or_fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `or_mesa` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`or_id`),
  KEY `or_fecha` (`or_fecha`),
  KEY `or_mesa` (`or_mesa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`or_id`, `or_fecha`, `or_mesa`) VALUES
(1, '2017-11-24 10:19:39', 5),
(2, '2017-11-25 10:19:39', 7),
(3, '2017-11-25 13:15:23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_platillos`
--

DROP TABLE IF EXISTS `ordenes_platillos`;
CREATE TABLE IF NOT EXISTS `ordenes_platillos` (
  `op_id_orden` int(10) UNSIGNED NOT NULL,
  `op_id_platillo` int(10) UNSIGNED NOT NULL,
  `op_precio` float UNSIGNED NOT NULL,
  `op_cantidad` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`op_id_orden`,`op_id_platillo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ordenes_platillos`
--

INSERT INTO `ordenes_platillos` (`op_id_orden`, `op_id_platillo`, `op_precio`, `op_cantidad`) VALUES
(1, 8, 35, 2),
(1, 9, 28.5, 4),
(2, 10, 25.5, 5),
(3, 8, 45, 25),
(3, 9, 20, 10),
(3, 10, 25, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos`
--

DROP TABLE IF EXISTS `platillos`;
CREATE TABLE IF NOT EXISTS `platillos` (
  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
  `pa_nombre` varchar(75) NOT NULL,
  `pa_descripcion` text,
  `pa_precio` decimal(10,0) UNSIGNED NOT NULL,
  `pa_id_tipo_comida` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`pa_id`),
  KEY `pa_nombre` (`pa_nombre`),
  KEY `pa_id_tipo_comida` (`pa_id_tipo_comida`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platillos`
--

INSERT INTO `platillos` (`pa_id`, `pa_nombre`, `pa_descripcion`, `pa_precio`, `pa_id_tipo_comida`) VALUES
(8, 'Quesadillas con quero', 'XX', '16', 8),
(9, 'Torta de jamon', '', '35', 12),
(10, 'Tostadas de crema', 'ksadjsalkd', '10', 8),
(11, 'XYZ', 'Ã±laskd', '10', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos_ingredientes`
--

DROP TABLE IF EXISTS `platillos_ingredientes`;
CREATE TABLE IF NOT EXISTS `platillos_ingredientes` (
  `pi_id_platillo` int(11) NOT NULL,
  `pi_id_ingrediente` int(11) UNSIGNED NOT NULL,
  `pi_cantidad` decimal(10,0) UNSIGNED NOT NULL,
  KEY `pi_id_platillo` (`pi_id_platillo`),
  KEY `pi_id_ingrediente` (`pi_id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platillos_ingredientes`
--

INSERT INTO `platillos_ingredientes` (`pi_id_platillo`, `pi_id_ingrediente`, `pi_cantidad`) VALUES
(8, 1, '1'),
(8, 2, '100'),
(9, 3, '10'),
(9, 5, '30'),
(11, 5, '3'),
(11, 2, '4'),
(10, 2, '100'),
(10, 1, '1'),
(10, 3, '2'),
(10, 4, '10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_comidas`
--

DROP TABLE IF EXISTS `tipos_comidas`;
CREATE TABLE IF NOT EXISTS `tipos_comidas` (
  `ti_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ti_tipo_comida` varchar(50) NOT NULL,
  PRIMARY KEY (`ti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipos_comidas`
--

INSERT INTO `tipos_comidas` (`ti_id`, `ti_tipo_comida`) VALUES
(8, 'DESAYUNO'),
(9, 'MERIENDA'),
(10, 'COLACION'),
(11, 'COMIDA'),
(12, 'CENA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `us_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `us_correo_electronico` varchar(30) NOT NULL,
  `us_clave` varchar(20) NOT NULL,
  `us_nombre` varchar(70) NOT NULL,
  `us_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`us_id`),
  UNIQUE KEY `us_correo_electronico` (`us_correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`us_id`, `us_correo_electronico`, `us_clave`, `us_nombre`, `us_status`) VALUES
(1, 'edgar_campos@ucol.mx', '123', 'Edgar Campos', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
