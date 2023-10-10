-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2023 a las 20:46:26
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
-- Base de datos: `menu_unlp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_menu`
--

CREATE TABLE `items_menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio` double NOT NULL,
  `tipo` enum('COMIDA','BEBIDA','','') NOT NULL,
  `foto` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `items_menu`
--

INSERT INTO `items_menu` (`id`, `nombre`, `precio`, `tipo`, `foto`) VALUES
(55, 'Asado', 3500, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313630383837373930373134392d6132303664373562613031313f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3136333526713d3830),
(56, 'Empanadas', 1200, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313631393932363039363631392d3539353661623464666231623f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(57, 'Milanesa', 2000, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313631333734343032363830362d6534393437346137343866363f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(58, 'Provoleta', 1800, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313438353936333633313030342d6632663030623164363630363f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3136373526713d3830),
(59, 'Matambre', 2400, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313538323338353435363739302d6461663366613730313430313f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(60, 'Locro', 1500, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313539313338363736373135332d3938373738333338303838353f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3137343026713d3830),
(61, 'Choripán', 1000, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313630303739373832383631302d3436386262323162366638653f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(62, 'Pastel de Papa', 1700, 'COMIDA', 0x68747470733a2f2f7777772e63726f6e6963612e636f6d2e61722f5f5f6578706f72742f313632393439333132383036352f73697465732f63726f6e6963612f696d672f323032312f30382f32302f706173735f315f63726f70313632393439323930353038332e6a70675f313833333139333331362e6a7067),
(63, 'Ñoquis', 1300, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313538363737393234353530392d3566343239333131323432663f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3137343026713d3830),
(64, 'Tarta de Manzana', 1600, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313536323030373930382d3137633637653837386338383f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(65, 'Facturas', 800, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313533303631303437363138312d6438333433306236346463643f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3136333526713d3830),
(66, 'Pizza', 2000, 'COMIDA', 0x68747470733a2f2f706c75732e756e73706c6173682e636f6d2f7072656d69756d5f70686f746f2d313637333433393330343138332d3838343062643064633162663f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830),
(67, 'Helado', 800, 'COMIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313537363530363239353238362d3563646131386466343365373f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3136333526713d3830),
(68, 'Alfajores', 1000, 'COMIDA', 0x68747470733a2f2f692e626c6f67732e65732f6264323639622f6973746f636b2d313336323934333836302f313336365f323030302e6a7067),
(69, 'Vino Malbec', 2500, 'BEBIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313635353937393238313332332d6137326537623034303630613f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138303526713d3830),
(70, 'Fernet', 3000, 'BEBIDA', 0x68747470733a2f2f6d656469612e6d696e75746f756e6f2e636f6d2f702f34396264366534363564383338373636386130653166343137303239613263612f61646a756e746f732f3135302f696d6167656e65732f3034302f3433312f303034303433313538312f636f6e73656a6f2d636f63612d6761732d6665726e65742e6a7067),
(71, 'Quilmes', 1000, 'BEBIDA', 0x68747470733a2f2f617264696170726f642e767465786173736574732e636f6d2f6172717569766f732f6964732f3235373039332d3830302d6175746f3f763d3633383235353434363933323533303030302677696474683d383030266865696768743d6175746f266173706563743d74727565),
(72, 'Coca-Cola', 1200, 'BEBIDA', 0x68747470733a2f2f696d616765732e756e73706c6173682e636f6d2f70686f746f2d313632343535323138343238302d3965393633316262656565393f69786c69623d72622d342e302e3326697869643d4d3377784d6a4133664442384d48787761473930627931775957646c664878386647567566444238664878386641253344253344266175746f3d666f726d6174266669743d63726f7026773d3138383726713d3830);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idItemMenu` int(11) NOT NULL,
  `nromesa` int(11) NOT NULL,
  `comentarios` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idItemMenu`, `nromesa`, `comentarios`, `created_at`) VALUES
(1, 56, 2, ' Rapidito', '2023-10-10 18:42:44'),
(2, 64, 2, ' ', '2023-10-10 18:45:43'),
(3, 56, 3, ' ', '2023-10-10 18:45:53');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
