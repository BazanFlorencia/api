-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2022 a las 16:06:46
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_productos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `tipo_producto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `tipo_producto`) VALUES
(1, 'Frutos secos'),
(2, 'Condimentos'),
(3, 'Harina'),
(4, 'Cereales'),
(5, 'Reposteria'),
(6, 'Legumbres'),
(7, 'Semillas'),
(11, 'Frescos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_productos`
--

CREATE TABLE `lista_productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(200) NOT NULL,
  `precio` int(11) NOT NULL,
  `id_categoria` int(100) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lista_productos`
--

INSERT INTO `lista_productos` (`id_producto`, `nombre_producto`, `precio`, `id_categoria`, `imagen`) VALUES
(7, 'Chia x 100 grs. (OFERTA)', 120, 7, 'img/productos/634db370e301b.jpg'),
(8, 'Girasol pelado entero x 100 grs.', 80, 7, 'img/productos/634db38654ad4.jpg'),
(9, 'Lino x 100 grs.', 47, 7, 'img/productos/634db3cfd818d.jpg'),
(20, 'Bolitas de chocolate x 300 grs.', 220, 4, 'img/productos/634dacd65383d.jpg'),
(21, 'Copos azucarados x 300 grs.', 210, 4, 'img/productos/634dad28b6b97.jpg'),
(22, 'Copos naturales x 300 grs.', 180, 4, 'img/productos/634dad3bea3e1.jpg'),
(23, 'Aritos frutales x 300 grs.(OFERTA)', 230, 4, 'img/productos/634dad52726df.jpg'),
(24, 'Azúcar impalpable x 500 grs.', 172, 5, 'img/productos/634db2cce7d59.jpg'),
(25, 'Azúcar negra x 500 grs.', 165, 5, 'img/productos/634db2deb6f03.jpg'),
(26, 'Coco rallado x 500 grs.', 871, 5, 'img/productos/634db2ee2bdbe.jpg'),
(27, 'Polvo para hornear x 100 grs.', 90, 5, 'img/productos/634db338d7a2b.jpg'),
(28, 'Arroz integral x 500 grs.', 90, 6, 'img/productos/634db3018025a.jpg'),
(29, 'Garbanzos x 500 grs.', 125, 6, 'img/productos/634db31377e7e.jpg'),
(30, 'Porotos Alubia x 500 grs.', 110, 6, 'img/productos/634db3267317f.jpg'),
(31, 'Porotos Negros x 500 grs.', 175, 6, 'img/productos/634db3530d2be.jpg'),
(45, 'Mix frutos secos x 100grs (OFERTA)', 340, 4, 'img/productos/635073be5af2b.jpg'),
(56, 'Arándanos x 100 grs. prueba', 340, 2, 'img/productos/635073e52a127.jpg'),
(58, 'Ciruela bombón x 100 grs', 180, 1, 'img/productos/634d97afc98fc.jpg'),
(59, 'Adobo para pizza x 100 grs', 71, 2, 'img/productos/634da1bfbc75d.jpg'),
(60, 'Nueces peladas mariposa x 100 grs', 256, 1, 'img/productos/634da1e913e78.jpg'),
(61, 'Harina de algarroba x 100 grs', 53, 3, 'img/productos/634da231ca60f.jpg'),
(62, 'Harina de almendras x 100 grs', 224, 3, 'img/productos/634da2b047038.jpg'),
(63, 'Ajo en polvo', 85, 2, 'img/productos/634da45917203.jpg'),
(64, 'Condimento para arroz x 100 grs (OFERTA)', 75, 2, 'img/productos/634da47a49a32.jpg'),
(65, 'Orégano x 100 grs', 84, 2, 'img/productos/634da4a0dd0ea.jpg'),
(66, 'Pimentón x 100 grs', 82, 2, 'img/productos/634da4c26c599.jpg'),
(67, 'Provenzal x 100 grs', 95, 2, 'img/productos/634da4e1bd2b4.jpg'),
(68, 'Canela molida x 100 grs ', 240, 2, 'img/productos/634da4fa4a054.jpg'),
(69, 'Harina de Arroz x 100 grs', 183, 3, 'img/productos/634da5645aab2.jpg'),
(70, 'Harina de coco x 500 grs', 580, 3, 'img/productos/634da5c27dbd2.jpg'),
(71, 'Harina de soja x 500 grs', 149, 3, 'img/productos/634da5e48dae7.jpg'),
(72, 'Canela molida x 100 grs. prueba', 240, 5, 'img/productos/63507407a533d.jpg'),
(73, 'Lino x 100 grs.', 50, 7, 'img/productos/634db3cfd818d.jpg'),
(74, 'Lino x 100 grs.', 50, 7, 'img/productos/634db3cfd818d.jpg'),
(75, 'Lino x 100 grs.', 60, 7, 'img/productos/634db3cfd818d.jpg'),
(76, 'Lino x 100 grs.', 60, 7, 'img/productos/634db3cfd818d.jpg'),
(77, 'Lino x 100 grs.', 60, 7, ''),
(78, 'Lino x 100 grs.', 60, 7, ''),
(79, 'Lino x 100 grs.', 60, 7, ''),
(80, 'Lino x 100 grs.', 65, 7, 'img/productos/634db3cfd818d.jpg'),
(81, 'Lino x 100 grs.', 65, 7, 'img/productos/634db3cfd818d.jpg'),
(82, 'Lino x 100 grs.', 65, 7, 'img/productos/634db3cfd818d.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `name`, `email`, `password`) VALUES
(1, 'Florencia', 'florenciabz@gmail.com', '$2a$12$M3/GzKRUUb0z9T6S/Cc0Qe7mrgtMrn8uXtgNjRyNDAdOlcmq21VAy');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD CONSTRAINT `lista_productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
