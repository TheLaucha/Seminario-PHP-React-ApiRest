-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2023 a las 00:39:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `menu_unlp_2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_menu`
--

CREATE TABLE `items_menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio` double NOT NULL,
  `tipo` enum('COMIDA','BEBIDA') NOT NULL,
  `imagen` longtext NOT NULL,
  `tipo_imagen` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items_menu`
--

INSERT INTO `items_menu` (`id`, `nombre`, `precio`, `tipo`, `imagen`, `tipo_imagen`) VALUES
(1, 'Milanesas', 500, 'COMIDA', 'https://url', 'jpg'),
(2, 'Carne', 500, 'COMIDA', 'https://url', ''),
(3, 'Carne', 500, 'COMIDA', 'https://url', ''),
(7, 'Carne', 500, 'COMIDA', 'https://url', ''),
(8, 'Carne', 500, 'COMIDA', 'https://url', ''),
(9, 'Carne', 500, 'COMIDA', 'https://url', ''),
(11, 'Empanadas', 5000, 'COMIDA', 'https://url', ''),
(12, 'Coca Cola', 1000, 'BEBIDA', 'https://url', ''),
(13, 'Quilmes', 1500, 'BEBIDA', 'https://url', ''),
(14, 'Agua', 500, 'BEBIDA', 'https://url', ''),
(15, 'Hamburguesa', 3500, 'COMIDA', 'https://url', 'raw'),
(16, 'Pizza', 3000, 'COMIDA', 'https://url', 'jpg'),
(17, 'Pizza', 3000, '', 'https://url', 'jpg'),
(18, 'Pizza', 3000, 'BEBIDA', 'https://url', 'jpg'),
(19, 'Pizza', 3000, 'BEBIDA', 'https://url', 'jpg'),
(21, 'Empanadas', 3000, 'COMIDA', 'https://url', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idItemMenu` int(11) NOT NULL,
  `nromesa` int(11) NOT NULL,
  `comentarios` longtext DEFAULT NULL,
  `fechaAlta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idItemMenu`, `nromesa`, `comentarios`, `fechaAlta`) VALUES
(1, 14, 2, 'Algo', '2023-11-05 23:46:37'),
(2, 8, 3, 'Nuevo', '2023-11-06 00:08:23'),
(3, 15, 1, NULL, '2023-11-06 00:08:23'),
(7, 3, 2, 'Tiene que salir en 5', '0000-00-00 00:00:00'),
(9, 3, 2, 'Tiene que salir en 5', '2023-11-09 00:03:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `items_menu`
--
ALTER TABLE `items_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_idx` (`idItemMenu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `items_menu`
--
ALTER TABLE `items_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`idItemMenu`) REFERENCES `items_menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
