-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2021 a las 18:08:13
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `idCategoriaProducto` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`idCategoriaProducto`, `nombre`) VALUES
(1, 'informatica'),
(2, 'casa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `idCategoriaProducto` int(11) NOT NULL,
  `idUsuarioVendedor` int(11) NOT NULL,
  `idUsuarioComprador` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` float NOT NULL,
  `publicacion` date NOT NULL,
  `caducidad` date NOT NULL,
  `contenidoimagen` blob NOT NULL,
  `tipoImagen` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `idCategoriaProducto`, `idUsuarioVendedor`, `idUsuarioComprador`, `nombre`, `descripcion`, `precio`, `publicacion`, `caducidad`, `contenidoimagen`, `tipoImagen`) VALUES
(2, 1, 3, 2, 'pc', 'lentiun', 30000, '2021-04-11', '2021-04-18', '', 'jpg'),
(3, 1, 1, 4, 'mouse', 'asdas dasd ', 4444, '2021-04-11', '2021-04-18', '', 'jpg'),
(4, 1, 2, 4, 'teclado', 'esta bueno ', 4444, '2021-04-11', '2021-04-18', '', 'jpg'),
(5, 1, 5, 3, 'sdd', 'asdasdas', 400, '2021-04-11', '2021-04-18', '', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombredeusuario` varchar(50) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombredeusuario`, `clave`, `apellido`, `nombre`, `email`, `telefono`) VALUES
(1, 'root', '123456', 'root', 'root', 'root@hotmail.com', '2211233434'),
(2, 'dert98', '123456', 'driver', 'dert', 'dert@hotmail.com', '2211233435'),
(3, 'edumo', '123456', 'mogro', 'eduardo', 'edum@hotmail.com', '2211244435'),
(4, 'Agustin11', '123456', 'Sargiotti', 'Agustin', 'AgustinSargiotti@hotmail.com', '1133240639'),
(5, 'NachoO', '123456', 'Oteiza', 'Nacho', 'NachoOteiza@hotmail.com', '2213643919');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`idCategoriaProducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idCategoriaProducto` (`idCategoriaProducto`),
  ADD KEY `idUsuario` (`idUsuarioVendedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombredeusuario_UNIQUE` (`nombredeusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `idCategoriaProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idCategoriaProducto`) REFERENCES `categorias_productos` (`idCategoriaProducto`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idUsuarioVendedor`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
