-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2019 a las 22:07:43
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estudio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `lugar` varchar(30) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `cliente` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `fecha`, `hora`, `lugar`, `motivo`, `cliente`) VALUES
(3, '2018-12-06', '08:53:00', 'Castell de Ferro', 'sesion ', 4),
(6, '2018-12-12', '16:08:00', 'Granada', 'sesion ', 2),
(7, '2018-12-12', '20:02:00', 'granada', 'sesion foto y video', 6),
(8, '2018-12-20', '09:04:00', 'Castell de Ferro', 'sesion foto y video', 5),
(10, '2019-01-30', '10:54:00', 'granada', 'sesion fotos y video', 6),
(11, '2019-01-25', '15:09:00', 'castell de ferro', 'video ', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono1` int(9) NOT NULL,
  `telefono2` int(9) DEFAULT NULL,
  `nick` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `direccion`, `telefono1`, `telefono2`, `nick`, `password`) VALUES
(0, 'disponible', '', '', 0, NULL, 'admin', 'admin'),
(1, 'Marina', 'Jimenez', 'c/Recogidas 4', 661359357, 958656432, 'aniram', 'aniram91'),
(2, 'Abel', 'Jimenez Rodriguez', 'c/falsa ', 665842476, NULL, 'abeljr', 'abeljr'),
(3, 'José', 'Jimenez Cifuentes', 'c/granada ', 601665447, 958636263, 'cifunet', '1234'),
(4, 'Maria Soledad', 'Rodriguez Rubia', 'c/granada ', 637665114, 958636263, 'mari89', '1234'),
(5, 'Maria', 'Rubia', 'c/granada ', 637665114, 958636263, 'mari89', '1234'),
(6, 'Jose Miguel', 'Rodriguez', 'c/granada', 668745454, 958656474, 'josemijr', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titular` varchar(50) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titular`, `contenido`, `imagen`, `fecha`) VALUES
(5, 'Contamos con nuevo equipo', 'A partir del mes de diciembre se incorporará al estudio una nueva profesional en maquillaje. ', 'noticias/maquillaje.jpg', '2018-11-30'),
(6, 'Revelamos carretes ', '¿Tienes una cámara analógica? Revelamos tus carretes. Ahora disfruta de nuestra oferta 2x1. Traenos dos carretes y los revelamos al precio de uno. Oferta válida para tamaño 9x13cm. ', 'noticias/negativo.jpg', '2018-11-13'),
(7, 'Sesión temática Halloween', 'No te pierdas nuestra sesión temática inspirada en la noche de Halloween. Estaremos la perfumería Primor de C/Recogidas documentando el evento de Halloween. ¡Además, acude disfrazado/a y te maquillarán gratis!', 'noticias/halloween.jpg', '2018-10-24'),
(8, 'Iluminación mejorada', 'Nos alegra comunicar la llegada de un profesional en iluminación a nuestro equipo. Las sesiones fotográficas ahora tendrán un resultado más espectacular.', 'noticias/iluminacion.jpg', '2018-11-30'),
(9, 'Oferta de empleo', 'Buscamos nuevo personal para nuestro estudio, profesionales cualificados en iluminación, maquillaje, decoración y atrezzo. ', 'noticias/oferta.jpg', '2018-11-02'),
(11, 'Sesion fotográfica en la Alhambra', 'Realizaremos sesiones fotográficas dentro de la Alhambra a partir del mes de enero.', 'noticias/autumn_blossom-wallpaper-1366x768.jpg', '2018-12-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

CREATE TABLE `trabajos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `precio` double NOT NULL,
  `cliente` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `trabajos`
--

INSERT INTO `trabajos` (`id`, `imagen`, `titulo`, `descripcion`, `precio`, `cliente`) VALUES
(38, 'trabajos/trabajo.jpg', 'Still life', 'Retrato sobre mesa estilo bodegón utilizando piezas de fruta. ', 50, 0),
(41, 'trabajos/trabajo2.jpg', 'Two faced', 'Retrato artístico utilizando contrastes. ', 20, 0),
(43, 'trabajos/trabajo4.jpg', 'The writer ', 'Retrato de una escritora con juego de luces y sombras. ', 20, 3),
(48, 'trabajos/trabajo10.jpg', 'Yellow leaves', 'Retrato artístico utilizando elementos naturales. ', 20, 0),
(49, 'trabajos/trabajo11.jpg', 'Bride', 'Retrato que contrasta los últimos momentos de infancia con el acto de madurez que conlleva una boda.', 20, 0),
(50, 'trabajos/trabajo12.jpg', 'Ants', 'Fotografía artística con elementos naturales. ', 20, 0),
(51, 'trabajos/trabajo13.jpg', 'Frozen heart', 'Retrato artístico que transmite frío y oscuridad.', 20, 0),
(52, 'trabajos/trabajo3.jpg', 'The lovers', 'Retrato artístico de una pareja. ', 50, 3),
(53, 'trabajos/trabajo5.jpg', 'Duality', 'Retrato en primer plano junto a mascota. ', 50, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
