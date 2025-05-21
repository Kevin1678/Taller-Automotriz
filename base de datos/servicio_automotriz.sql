-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2025 a las 07:44:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicio_automotriz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `servicio` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `nombre`, `telefono`, `email`, `fecha`, `hora`, `servicio`, `fecha_registro`) VALUES
(1, 'Carlos Yael', '6648426962', 'yael2@gmail.com', '2025-05-11', '17:41:00', 'Cambio de Aceite', '2025-05-12 00:41:59'),
(2, 'Carlos Yael', '6648426962', 'yael2@gmail.com', '2025-05-11', '17:41:00', 'Cambio de Aceite', '2025-05-12 00:42:15'),
(3, 'yael', '6648426962', 'carritoacu03@gmail.com', '2025-05-11', '11:45:00', 'Cambio de Aceite', '2025-05-12 00:45:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `servicio` varchar(100) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `nombre`, `telefono`, `email`, `servicio`, `mensaje`, `fecha_envio`) VALUES
(1, 'Carlos Yael', '6648426962', '', 'cambio-aceite', 'a', '2025-05-12 00:02:50'),
(2, 'Carlos Yael', '6648426962', '', 'cambio-aceite', 'a', '2025-05-12 00:03:32'),
(3, 'yael', '6648426962', 'carlosyaelacuna06@gmail.com', 'cambio-aceite', 'e', '2025-05-12 00:05:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` int(11) NOT NULL,
  `numero_presupuesto` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `validez` varchar(50) DEFAULT NULL,
  `cliente_nombre` varchar(100) DEFAULT NULL,
  `telefono_cliente` varchar(20) DEFAULT NULL,
  `marca_vehiculo` varchar(50) DEFAULT NULL,
  `modelo_vehiculo` varchar(50) DEFAULT NULL,
  `anio_vehiculo` varchar(10) DEFAULT NULL,
  `kilometraje` varchar(20) DEFAULT NULL,
  `motor` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `numero_presupuesto`, `fecha`, `validez`, `cliente_nombre`, `telefono_cliente`, `marca_vehiculo`, `modelo_vehiculo`, `anio_vehiculo`, `kilometraje`, `motor`, `observaciones`, `subtotal`, `total`, `fecha_creacion`) VALUES
(1, NULL, '2025-05-11', NULL, 'Carlos', '6648426962', 'Cheroki', 'asdasdasd', '2025', '54', '6', 'si o no?', 200.00, 200.00, '2025-05-12 01:39:27'),
(2, NULL, '2025-05-03', NULL, 'Carlos', '6648426962', 'Cheroki', 'asdasdasd', '2025', '54', '6', 'aaaa', 222.00, 222.00, '2025-05-12 01:51:36'),
(3, NULL, '2025-05-12', NULL, 'a', '6648426962', 'Cheroki', 'aa', '2025', '54', '6', 'siu?', 4444444.00, 4444444.00, '2025-05-12 02:30:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_items`
--

CREATE TABLE `presupuesto_items` (
  `id` int(11) NOT NULL,
  `presupuesto_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio` decimal(10,2) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuesto_items`
--

INSERT INTO `presupuesto_items` (`id`, `presupuesto_id`, `descripcion`, `cantidad`, `precio`, `importe`) VALUES
(1, 1, 'Cambio de Aceite', 1, 200.00, 200.00),
(2, 2, 'Cambio de Aceite', 1, 222.00, 222.00),
(3, 3, 'Cambio de Aceite', 1, 4444444.00, 4444444.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_presupuesto` (`numero_presupuesto`);

--
-- Indices de la tabla `presupuesto_items`
--
ALTER TABLE `presupuesto_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presupuesto_id` (`presupuesto_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `presupuesto_items`
--
ALTER TABLE `presupuesto_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `presupuesto_items`
--
ALTER TABLE `presupuesto_items`
  ADD CONSTRAINT `presupuesto_items_ibfk_1` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
